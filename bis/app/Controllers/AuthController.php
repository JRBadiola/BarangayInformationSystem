<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Libraries\EmailService;

class AuthController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ── Login ─────────────────────────────────────────────────────────────────

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->to('/login')->with('error', 'Please enter your username and password.');
        }

        $user = $this->userModel->findByCredentials($username, $password);

        if (! $user) {
            return redirect()->to('/login')->with('error', 'Invalid username or password.');
        }

        // Block unverified email
        if (! $user['email_verified']) {
            return redirect()->to('/login')->with('error', 'Please verify your email address first. Check your inbox for the verification link.');
        }

        // Block pending accounts
        if ($user['status'] === 'pending') {
            return redirect()->to('/login')->with('error', 'Your account is pending approval by the barangay secretary.');
        }

        // Block rejected accounts
        if ($user['status'] === 'rejected') {
            return redirect()->to('/login')->with('error', 'Your account registration was not approved. Please contact the barangay office.');
        }

        // Compose display name for session
        $displayName = trim(
            $user['first_name'] . ' ' .
                ($user['middle_name'] ? $user['middle_name'] . ' ' : '') .
                $user['last_name']
        );

        // Set session
        session()->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'last_name'  => $user['last_name'],
            'first_name' => $user['first_name'],
            'middle_name' => $user['middle_name'] ?? '',
            'full_name'  => $displayName, // composed for display convenience
            'role'       => $user['role'],
            'avatar'     => $user['avatar'] ?? null,
        ]);

        return redirect()->to('/' . $user['role'] . '/dashboard');
    }

    // ── Logout ────────────────────────────────────────────────────────────────

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }

    // ── Public Registration (Resident & SK only) ──────────────────────────────

    public function register()
    {
        // Public signup is always 'resident' — SK/officials are created by admin
        $role = 'resident';

        $lastName        = trim($this->request->getPost('last_name') ?? '');
        $firstName       = trim($this->request->getPost('first_name') ?? '');
        $middleName      = trim($this->request->getPost('middle_name') ?? '');
        $email           = $this->request->getPost('email');
        $username        = $this->request->getPost('username');
        $password        = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.')->withInput();
        }

        if (strlen($password) < 8) {
            return redirect()->back()->with('error', 'Password must be at least 8 characters.')->withInput();
        }

        // ── Resident census verification ──────────────────────────────────
        if ($role === 'resident') {
            $householdNo = trim($this->request->getPost('household_no') ?? '');

            if (empty($householdNo)) {
                return redirect()->back()->with('error', 'Household number is required for resident registration.')->withInput();
            }

            // Look up the household in the census
            $householdModel = new \App\Models\HouseholdModel();
            $household      = $householdModel->find($householdNo);

            if (! $household) {
                return redirect()->back()->with('error', 'Household number ' . esc($householdNo) . ' was not found in the census. Please check your household number or contact the barangay office.')->withInput();
            }

            // Verify the entered name matches the household head OR any member
            // Compare against both "First Last" and "Last First" patterns
            $enteredFull    = strtoupper(trim("$firstName $lastName"));
            $enteredFullAlt = strtoupper(trim("$lastName $firstName"));

            // Check household head
            $headFull    = strtoupper(trim($household['first_name'] . ' ' . $household['last_name']));
            $headFullAlt = strtoupper(trim($household['last_name'] . ' ' . $household['first_name']));

            $memberModel = new \App\Models\HouseholdMemberModel();
            $members     = $memberModel->where('household_no', $householdNo)->findAll();

            $nameFound = ($enteredFull === $headFull || $enteredFull === $headFullAlt
                || $enteredFullAlt === $headFull || $enteredFullAlt === $headFullAlt);

            if (! $nameFound) {
                foreach ($members as $m) {
                    $mFull    = strtoupper(trim($m['first_name'] . ' ' . $m['last_name']));
                    $mFullAlt = strtoupper(trim($m['last_name'] . ' ' . $m['first_name']));
                    if (
                        $enteredFull === $mFull || $enteredFull === $mFullAlt
                        || $enteredFullAlt === $mFull || $enteredFullAlt === $mFullAlt
                    ) {
                        $nameFound = true;
                        break;
                    }
                }
            }

            if (! $nameFound) {
                return redirect()->back()->with('error', 'Your name does not match any member recorded under Household #' . esc($householdNo) . '. Please check your name and household number, or contact the barangay office.')->withInput();
            }
        }

        $otp     = strval(random_int(100000, 999999));
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $saved = $this->userModel->save([
            'last_name'            => $lastName,
            'first_name'           => $firstName,
            'middle_name'          => $middleName ?: null,
            'email'                => $email,
            'username'             => $username,
            'password'             => password_hash($password, PASSWORD_BCRYPT),
            'role'                 => $role,
            'status'               => 'unverified',
            'email_verified'       => 0,
            'verify_token'         => $otp,
            'verify_token_expires' => $expires,
            'household_no'         => ($role === 'resident') ? ($householdNo ?? null) : null,
        ]);

        if (! $saved) {
            $errors = implode(' ', $this->userModel->errors());
            return redirect()->back()->with('error', $errors)->withInput();
        }

        // Send OTP email — use "First Last" as the greeting name
        $displayName = trim("$firstName $lastName");
        try {
            $emailService = new EmailService();
            $emailService->sendVerificationEmail($email, $displayName, $otp);
        } catch (\Throwable $e) {
            log_message('error', 'Verification email failed: ' . $e->getMessage());
            if (ENVIRONMENT === 'development') {
                throw $e;
            }
            return redirect()->to('/login')->with('error', 'Account created but we could not send the verification email. Please contact the barangay office.');
        }

        // Store email in session so the verify page knows who to verify
        session()->set('pending_verify_email', $email);

        return redirect()->to('/verify-email');
    }

    // ── Show OTP entry page ───────────────────────────────────────────────────

    public function showVerifyEmail()
    {
        if (! session()->get('pending_verify_email')) {
            return redirect()->to('/login');
        }

        return view('verify_email');
    }

    // ── Handle OTP submission ─────────────────────────────────────────────────

    public function verifyEmail()
    {
        $email = session()->get('pending_verify_email');

        if (! $email) {
            return redirect()->to('/login')->with('error', 'Session expired. Please register again.');
        }

        $enteredOtp = trim($this->request->getPost('otp'));

        // Find user by email
        $user = $this->userModel->where('email', $email)->where('email_verified', 0)->first();

        if (! $user) {
            return redirect()->to('/login')->with('error', 'Account not found or already verified.');
        }

        // Check expiry
        if (strtotime($user['verify_token_expires']) < time()) {
            return redirect()->to('/verify-email')->with('error', 'Your code has expired. Please register again.');
        }

        // Check OTP
        if ($user['verify_token'] !== $enteredOtp) {
            return redirect()->to('/verify-email')->with('error', 'Incorrect verification code. Please try again.');
        }

        // Mark verified → status becomes pending (awaiting captain/secretary approval)
        $this->userModel->markEmailVerified($user['id']);
        session()->remove('pending_verify_email');

        return redirect()->to('/login')->with('success', 'Email verified! Your account is now pending approval by the barangay captain or secretary.');
    }

    // ── Resend OTP ────────────────────────────────────────────────────────────

    public function resendOtp()
    {
        $email = session()->get('pending_verify_email');

        if (! $email) {
            return redirect()->to('/login')->with('error', 'Session expired. Please register again.');
        }

        $user = $this->userModel->where('email', $email)->where('email_verified', 0)->first();

        if (! $user) {
            return redirect()->to('/login')->with('error', 'Account not found or already verified.');
        }

        // Generate a fresh OTP
        $otp     = strval(random_int(100000, 999999));
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $this->userModel->update($user['id'], [
            'verify_token'         => $otp,
            'verify_token_expires' => $expires,
        ]);

        $displayName = trim($user['first_name'] . ' ' . $user['last_name']);
        try {
            $emailService = new EmailService();
            $emailService->sendVerificationEmail($email, $displayName, $otp);
        } catch (\Throwable $e) {
            log_message('error', 'Resend OTP failed: ' . $e->getMessage());
            if (ENVIRONMENT === 'development') {
                throw $e;
            }
            return redirect()->to('/verify-email')->with('error', 'Could not resend the code. Please try again.');
        }

        return redirect()->to('/verify-email')->with('success', 'A new verification code has been sent to your email.');
    }

    // ── Forgot Password — Step 1: Show form ──────────────────────────────────

    public function showForgotPassword()
    {
        return view('forgot_password');
    }

    // ── Forgot Password — Step 2: Send OTP to email ───────────────────────────

    public function sendForgotPasswordOtp()
    {
        $email = trim($this->request->getPost('email') ?? '');

        if (empty($email)) {
            return redirect()->back()->with('error', 'Please enter your email address.');
        }

        // Look up user by email — don't reveal whether it exists (security)
        $user = $this->userModel
            ->select('id, last_name, first_name, middle_name, email, status, email_verified')
            ->where('email', $email)
            ->first();

        if ($user && $user['email_verified'] && $user['status'] === 'active') {
            $otp     = strval(random_int(100000, 999999));
            $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

            $this->userModel->update($user['id'], [
                'verify_token'         => $otp,
                'verify_token_expires' => $expires,
            ]);

            $displayName = trim($user['first_name'] . ' ' . $user['last_name']);

            try {
                $emailService = new EmailService();
                $emailService->sendPasswordResetOtp($user['email'], $displayName, $otp);
            } catch (\Throwable $e) {
                log_message('error', 'Forgot password OTP failed: ' . $e->getMessage());
                if (ENVIRONMENT === 'development') throw $e;
                return redirect()->back()->with('error', 'Could not send the reset code. Please try again.');
            }
        }

        // Always store email in session and redirect — prevents email enumeration
        session()->set('fp_email', $email);

        return redirect()->to('/forgot-password/verify')
            ->with('success', 'If that email is registered, a reset code has been sent.');
    }

    // ── Forgot Password — Step 3: Show OTP entry ─────────────────────────────

    public function showForgotPasswordOtp()
    {
        if (! session()->get('fp_email')) {
            return redirect()->to('/forgot-password');
        }
        return view('reset_password_otp');
    }

    // ── Forgot Password — Step 4: Verify OTP ─────────────────────────────────

    public function verifyForgotPasswordOtp()
    {
        $email = session()->get('fp_email');
        if (! $email) {
            return redirect()->to('/forgot-password');
        }

        $otp = trim($this->request->getPost('otp') ?? '');

        $user = $this->userModel
            ->select('id, verify_token, verify_token_expires')
            ->where('email', $email)
            ->first();

        if (! $user || $user['verify_token'] !== $otp) {
            return redirect()->back()->with('error', 'Incorrect code. Please try again.');
        }

        if (strtotime($user['verify_token_expires']) < time()) {
            session()->remove('fp_email');
            return redirect()->to('/forgot-password')
                ->with('error', 'Your reset code has expired. Please request a new one.');
        }

        // OTP valid — mark as verified for the reset step
        session()->set('fp_verified', true);
        session()->set('fp_user_id', $user['id']);

        // Clear the token so it can't be reused
        $this->userModel->update($user['id'], [
            'verify_token'         => null,
            'verify_token_expires' => null,
        ]);

        return redirect()->to('/forgot-password/new-password');
    }

    // ── Forgot Password — Step 5: Resend OTP ─────────────────────────────────

    public function resendForgotPasswordOtp()
    {
        $email = session()->get('fp_email');
        if (! $email) {
            return redirect()->to('/forgot-password');
        }

        $user = $this->userModel
            ->select('id, last_name, first_name, email')
            ->where('email', $email)
            ->first();

        if ($user) {
            $otp     = strval(random_int(100000, 999999));
            $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

            $this->userModel->update($user['id'], [
                'verify_token'         => $otp,
                'verify_token_expires' => $expires,
            ]);

            $displayName = trim($user['first_name'] . ' ' . $user['last_name']);
            try {
                $emailService = new EmailService();
                $emailService->sendPasswordResetOtp($user['email'], $displayName, $otp);
            } catch (\Throwable $e) {
                log_message('error', 'Resend forgot password OTP failed: ' . $e->getMessage());
                if (ENVIRONMENT === 'development') throw $e;
                return redirect()->to('/forgot-password/verify')
                    ->with('error', 'Could not resend the code. Please try again.');
            }
        }

        return redirect()->to('/forgot-password/verify')
            ->with('success', 'A new reset code has been sent to your email.');
    }

    // ── Forgot Password — Step 6: Show new password form ─────────────────────

    public function showNewPassword()
    {
        if (! session()->get('fp_verified')) {
            return redirect()->to('/forgot-password');
        }
        return view('reset_password_new');
    }

    // ── Forgot Password — Step 7: Save new password ───────────────────────────

    public function saveNewPassword()
    {
        if (! session()->get('fp_verified') || ! session()->get('fp_user_id')) {
            return redirect()->to('/forgot-password');
        }

        $newPassword     = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (strlen($newPassword) < 8) {
            return redirect()->back()->with('error', 'Password must be at least 8 characters.');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        $userId = (int) session()->get('fp_user_id');

        $this->userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_BCRYPT),
        ]);

        // Clear all forgot-password session data
        session()->remove(['fp_email', 'fp_verified', 'fp_user_id']);

        return redirect()->to('/login')
            ->with('success', 'Password reset successfully. You can now sign in with your new password.');
    }

    // ── Pending Accounts (Captain & Secretary) ────────────────────────────────

    public function pendingAccounts()
    {
        $pending = $this->userModel->getPendingAccounts();
        $role    = session()->get('role');

        return view('dashboard/' . $role . '/pending_accounts', [
            'pending' => $pending,
        ]);
    }

    public function approveAccount(int $id)
    {
        $this->userModel->approveUser($id);
        $role = session()->get('role');
        return redirect()->to('/' . $role . '/pending-accounts')->with('success', 'Account approved successfully.');
    }

    public function rejectAccount(int $id)
    {
        $this->userModel->rejectUser($id);
        $role = session()->get('role');
        return redirect()->to('/' . $role . '/pending-accounts')->with('success', 'Account rejected.');
    }

    // ── Promote existing resident → official role (Secretary only) ───────────

    public function promoteResident()
    {
        if (session()->get('role') !== 'secretary') {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $targetId  = (int) $this->request->getPost('user_id');
        $newRole   = strtolower(trim($this->request->getPost('role') ?? ''));
        $callerRole = 'secretary';

        $allowed = ['captain', 'secretary', 'sk'];
        if (! in_array($newRole, $allowed, true)) {
            return redirect()->back()->with('error', 'Invalid role for promotion.')->withInput();
        }

        // Load target user
        $target = $this->userModel->find($targetId);
        if (! $target || $target['role'] !== 'resident' || $target['status'] !== 'active') {
            return redirect()->back()->with('error', 'Selected user is not an eligible active resident.')->withInput();
        }

        // Age check — use the resident's own DOB (from household_members if a member,
        // otherwise the household head row).
        if (! empty($target['household_no'])) {
            $db  = \Config\Database::connect();

            // Try to find this person as a household member first
            $memberRow = $db->table('household_members')
                ->where('household_no', $target['household_no'])
                ->where('UPPER(TRIM(first_name))', strtoupper(trim($target['first_name'] ?? '')))
                ->where('UPPER(TRIM(last_name))',  strtoupper(trim($target['last_name']  ?? '')))
                ->get()->getRowArray();

            $dob = !empty($memberRow['date_of_birth'])
                ? $memberRow['date_of_birth']
                : ($db->table('households')->where('household_no', $target['household_no'])->get()->getRowArray()['date_of_birth'] ?? null);

            if (! empty($dob)) {
                $age = (int) date_diff(date_create($dob), date_create('today'))->y;
                if ($age < 18) {
                    return redirect()->back()->with('error', 'The selected resident must be at least 18 years old.')->withInput();
                }
            }
        }

        // Single-instance check
        if (in_array($newRole, ['captain', 'secretary'], true)) {
            if ($newRole === 'secretary') {
                // Only allow one non-default (non-admin) secretary at a time.
                // The seeded default account username is `secretary_admin` and must not be revoked.
                // Also require that only the default admin may assign a resident as secretary.
                if (session()->get('username') !== 'secretary_admin') {
                    return redirect()->back()->with('error', 'Only the default secretary admin can assign another secretary.')->withInput();
                }

                $existingNonAdmin = $this->userModel
                    ->where('role', 'secretary')
                    ->where('status', 'active')
                    ->where('username !=', 'secretary_admin')
                    ->first();

                if ($existingNonAdmin) {
                    $existingName = trim($existingNonAdmin['first_name'] . ' ' . $existingNonAdmin['last_name']);
                    return redirect()->back()->with(
                        'error',
                        'An active Secretary already exists (' . esc($existingName) . '). Demote them first before promoting someone else.'
                    )->withInput();
                }

                // Block self-promotion to secretary (secretary can't replace themselves this way)
                if ((int) session()->get('user_id') === $targetId) {
                    return redirect()->back()->with('error', 'You cannot promote your own account.')->withInput();
                }
            } else {
                $existing = $this->userModel->getActiveByRole($newRole);
                if ($existing) {
                    $existingName = trim($existing['first_name'] . ' ' . $existing['last_name']);
                    return redirect()->back()->with(
                        'error',
                        'An active ' . ucfirst($newRole) . ' already exists (' . esc($existingName) . '). Demote them first before promoting someone else.'
                    )->withInput();
                }
            }
        }

        // Promote
        $this->userModel->update($targetId, ['role' => $newRole]);

        $targetName = trim($target['first_name'] . ' ' . $target['last_name']);
        return redirect()->to('/secretary/create-account')
            ->with('success', esc($targetName) . ' has been promoted to ' . ucfirst($newRole) . ' and can now access the ' . ucfirst($newRole) . ' dashboard.');
    }

    // ── Demote official → resident (Secretary only) ───────────────────────────

    public function demoteOfficial(int $targetId)
    {
        if (session()->get('role') !== 'secretary') {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        // Block self-demotion
        if ((int) session()->get('user_id') === $targetId) {
            return redirect()->back()->with('error', 'You cannot demote your own account.');
        }

        $target = $this->userModel->find($targetId);
        if (! $target) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Prevent demotion/deletion of the seeded default secretary admin
        if (! empty($target['username']) && $target['username'] === 'secretary_admin') {
            return redirect()->back()->with('error', 'The default secretary account cannot be demoted or revoked.');
        }

        $officialRoles = ['captain', 'secretary', 'sk'];
        if (! in_array($target['role'], $officialRoles, true)) {
            return redirect()->back()->with('error', 'This user does not hold an official role.');
        }

        $oldRole    = $target['role'];
        $targetName = trim($target['first_name'] . ' ' . $target['last_name']);

        // Demote back to resident
        $this->userModel->update($targetId, ['role' => 'resident']);

        return redirect()->to('/secretary/create-account')
            ->with('success', esc($targetName) . ' has been demoted from ' . ucfirst($oldRole) . ' back to Resident.');
    }

    public function createOfficialAccount()
    {
        $callerRole = session()->get('role'); // 'secretary' or 'captain'
        $role       = strtolower($this->request->getPost('role'));

        // Secretary can create: captain, resident, sk
        // Captain can create: secretary, treasurer
        $allowedByRole = [
            'secretary' => ['captain', 'resident', 'sk'],
            'captain'   => ['secretary', 'treasurer'],
        ];

        $allowed = $allowedByRole[$callerRole] ?? [];

        if (! in_array($role, $allowed, true)) {
            return redirect()->back()->with('error', 'Invalid role selected.')->withInput();
        }

        // Only the seeded default secretary admin may create a Secretary account
        if ($role === 'secretary' && session()->get('username') !== 'secretary_admin') {
            return redirect()->back()->with('error', 'Only the default secretary admin can create a Secretary account.')->withInput();
        }

        // ── Single-instance enforcement for captain and secretary ─────────────
        if (in_array($role, ['captain', 'secretary'], true)) {
            if ($role === 'secretary') {
                // Allow the seeded default `secretary_admin` plus at most one additional resident secretary.
                $existingNonAdmin = $this->userModel
                    ->where('role', 'secretary')
                    ->where('status', 'active')
                    ->where('username !=', 'secretary_admin')
                    ->first();

                if ($existingNonAdmin) {
                    $existingName = trim($existingNonAdmin['first_name'] . ' ' . $existingNonAdmin['last_name']);
                    return redirect()->back()->with(
                        'error',
                        'An active Secretary account already exists (' . esc($existingName) . '). You must deactivate that account before creating a new one.'
                    )->withInput();
                }
            } else {
                $existing = $this->userModel->getActiveByRole($role);
                if ($existing) {
                    $existingName = trim($existing['first_name'] . ' ' . $existing['last_name']);
                    return redirect()->back()->with(
                        'error',
                        'An active ' . ucfirst($role) . ' account already exists (' . esc($existingName) . '). ' .
                            'You must deactivate that account before creating a new one.'
                    )->withInput();
                }
            }
        }

        $password        = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.')->withInput();
        }

        if (strlen($password) < 8) {
            return redirect()->back()->with('error', 'Password must be at least 8 characters.')->withInput();
        }

        $householdNo = null;
        if ($role === 'resident') {
            $householdNo = trim($this->request->getPost('household_no') ?? '');
            if (! empty($householdNo)) {
                $householdModel = new \App\Models\HouseholdModel();
                if (! $householdModel->find($householdNo)) {
                    return redirect()->back()->with('error', 'Household number ' . esc($householdNo) . ' was not found in the census.')->withInput();
                }
            }
        }

        $saved = $this->userModel->save([
            'last_name'      => trim($this->request->getPost('last_name') ?? ''),
            'first_name'     => trim($this->request->getPost('first_name') ?? ''),
            'middle_name'    => trim($this->request->getPost('middle_name') ?? '') ?: null,
            'email'          => $this->request->getPost('email'),
            'username'       => $this->request->getPost('username'),
            'password'       => password_hash($password, PASSWORD_BCRYPT),
            'role'           => $role,
            'status'         => 'active',
            'email_verified' => 1,
            'household_no'   => $householdNo,
        ]);

        if (! $saved) {
            $errors = implode(' ', $this->userModel->errors());
            return redirect()->back()->with('error', $errors)->withInput();
        }

        $redirectPath = '/' . $callerRole . '/create-account';
        return redirect()->to($redirectPath)->with('success', ucfirst($role) . ' account created successfully.');
    }
}
