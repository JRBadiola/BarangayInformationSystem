<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Libraries\EmailService;

class SettingsController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ── Upload profile avatar ─────────────────────────────────────────────────

    public function uploadAvatar()
    {
        $userId = session()->get('user_id');
        $role   = session()->get('role');

        $file = $this->request->getFile('avatar');

        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'No valid file uploaded.');
        }

        // Validate: image only, max 2MB
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (! in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Only JPG, PNG, GIF, or WebP images are allowed.');
        }
        if ($file->getSize() > 2 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Image must be smaller than 2MB.');
        }

        // Delete old avatar if exists
        $user = $this->userModel->find($userId);
        if (! empty($user['avatar'])) {
            $oldPath = FCPATH . 'uploads/avatars/' . $user['avatar'];
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        // Save new avatar with unique name
        $newName = 'avatar_' . $userId . '_' . time() . '.' . $file->getExtension();
        $file->move(FCPATH . 'uploads/avatars/', $newName);

        $this->userModel->update($userId, ['avatar' => $newName]);

        // Update session
        session()->set('avatar', $newName);

        $redirect = in_array($role, ['captain', 'secretary', 'treasurer', 'sk'])
            ? '/' . $role . '/settings'
            : '/' . $role . '/profile';

        return redirect()->to($redirect)->with('success', 'Profile photo updated successfully.');
    }

    // ── Update profile info ───────────────────────────────────────────────────

    public function updateProfile()
    {
        $userId     = session()->get('user_id');
        $role       = session()->get('role');
        $lastName   = trim($this->request->getPost('last_name') ?? '');
        $firstName  = trim($this->request->getPost('first_name') ?? '');
        $middleName = trim($this->request->getPost('middle_name') ?? '');
        $email      = trim($this->request->getPost('email'));
        $contact    = trim($this->request->getPost('contact_number'));

        if (empty($lastName) || empty($firstName) || empty($email)) {
            return redirect()->back()->with('error', 'Last name, first name, and email are required.');
        }

        // Check email uniqueness (exclude current user)
        $existing = $this->userModel
            ->where('email', $email)
            ->where('id !=', $userId)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'That email is already used by another account.');
        }

        $this->userModel->update($userId, [
            'last_name'      => $lastName,
            'first_name'     => $firstName,
            'middle_name'    => $middleName ?: null,
            'email'          => $email,
            'contact_number' => $contact,
        ]);

        // Update session name
        $displayName = trim("$firstName $lastName");
        session()->set([
            'last_name'   => $lastName,
            'first_name'  => $firstName,
            'middle_name' => $middleName,
            'full_name'   => $displayName,
        ]);

        return redirect()->to('/' . $role . '/settings')->with('success', 'Profile updated successfully.');
    }

    // ── Step 1: Send OTP to email for password change ─────────────────────────

    public function requestPasswordOtp()
    {
        $userId = session()->get('user_id');
        $role   = session()->get('role');

        $user = $this->userModel
            ->select('id, last_name, first_name, middle_name, email, password')
            ->where('id', $userId)
            ->first();

        if (! $user) {
            return redirect()->back()->with('pw_error', 'User not found.');
        }

        // Verify current password first
        $currentPw = $this->request->getPost('current_password');
        if (! password_verify($currentPw, $user['password'])) {
            return redirect()->back()->with('pw_error', 'Current password is incorrect.');
        }

        // Generate 6-digit OTP, expires in 15 minutes
        $otp     = strval(random_int(100000, 999999));
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $this->userModel->update($userId, [
            'verify_token'         => $otp,
            'verify_token_expires' => $expires,
        ]);

        $displayName = trim($user['first_name'] . ' ' . $user['last_name']);
        // Send OTP email
        try {
            $emailService = new EmailService();
            $emailService->sendPasswordChangeOtp($user['email'], $displayName, $otp);
        } catch (\Throwable $e) {
            log_message('error', 'Password OTP email failed: ' . $e->getMessage());
            if (ENVIRONMENT === 'development') throw $e;
            return redirect()->back()->with('pw_error', 'Could not send verification email. Please try again.');
        }

        // Store in session that OTP was sent and new password is pending
        session()->set([
            'pw_otp_pending'   => true,
            'pw_new'           => password_hash($this->request->getPost('new_password'), PASSWORD_BCRYPT),
            'pw_confirm_plain' => $this->request->getPost('confirm_password'),
        ]);

        return redirect()->to('/' . $role . '/settings')->with('pw_otp_sent', true);
    }

    // ── Step 2: Verify OTP and change password ────────────────────────────────

    public function verifyPasswordOtp()
    {
        $userId = session()->get('user_id');
        $role   = session()->get('role');
        $otp    = trim($this->request->getPost('otp'));

        $user = $this->userModel
            ->select('id, verify_token, verify_token_expires')
            ->where('id', $userId)
            ->first();

        if (! $user || $user['verify_token'] !== $otp) {
            return redirect()->back()->with('pw_error', 'Incorrect verification code. Please try again.');
        }

        if (strtotime($user['verify_token_expires']) < time()) {
            session()->remove(['pw_otp_pending', 'pw_new', 'pw_confirm_plain']);
            return redirect()->back()->with('pw_error', 'Verification code has expired. Please start over.');
        }

        // Apply the new password
        $newPasswordHash = session()->get('pw_new');

        $this->userModel->update($userId, [
            'password'             => $newPasswordHash,
            'verify_token'         => null,
            'verify_token_expires' => null,
        ]);

        session()->remove(['pw_otp_pending', 'pw_new', 'pw_confirm_plain']);

        return redirect()->to('/' . $role . '/settings')->with('success', 'Password changed successfully!');
    }

    // ── Resend OTP ────────────────────────────────────────────────────────────

    public function changePassword()
    {
        // Alias — resend OTP
        $userId = session()->get('user_id');
        $role   = session()->get('role');

        $user = $this->userModel->select('id, last_name, first_name, email')->where('id', $userId)->first();
        if (! $user) return redirect()->back()->with('pw_error', 'User not found.');

        $otp     = strval(random_int(100000, 999999));
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $this->userModel->update($userId, [
            'verify_token'         => $otp,
            'verify_token_expires' => $expires,
        ]);

        $displayName = trim($user['first_name'] . ' ' . $user['last_name']);
        try {
            $emailService = new EmailService();
            $emailService->sendPasswordChangeOtp($user['email'], $displayName, $otp);
        } catch (\Throwable $e) {
            log_message('error', 'Resend password OTP failed: ' . $e->getMessage());
            return redirect()->back()->with('pw_error', 'Could not resend code.');
        }

        return redirect()->to('/' . $role . '/settings')->with('pw_otp_sent', true);
    }

    // ── Admin: Deactivate a user account (Secretary only) ────────────────────

    public function deactivateUser(int $targetUserId)
    {
        $role = session()->get('role');

        if ($role !== 'secretary') {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        // Prevent secretary from deactivating themselves
        if ((int) session()->get('user_id') === $targetUserId) {
            return redirect()->back()->with('error', 'You cannot deactivate your own account.');
        }

        $target = $this->userModel->find($targetUserId);
        if (! $target) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Prevent deactivating the seeded default secretary admin
        if (! empty($target['username']) && $target['username'] === 'secretary_admin') {
            return redirect()->back()->with('error', 'The default secretary account cannot be deactivated.');
        }

        $this->userModel->update($targetUserId, ['status' => 'rejected']);

        return redirect()->to('/secretary/create-account')
            ->with('success', esc(trim($target['first_name'] . ' ' . $target['last_name'])) . '\'s account has been deactivated. You can now create a new ' . ucfirst($target['role']) . ' account.');
    }

    // ── Admin: Reset any user's password (Secretary only, no verification) ───

    public function adminResetPassword(int $targetUserId)
    {
        $role = session()->get('role');

        // Only secretary can use this
        if ($role !== 'secretary') {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $newPassword     = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (empty($newPassword) || strlen($newPassword) < 8) {
            return redirect()->back()->with('reset_error', 'Password must be at least 8 characters.');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('reset_error', 'Passwords do not match.');
        }

        $target = $this->userModel->find($targetUserId);
        if (! $target) {
            return redirect()->back()->with('reset_error', 'User not found.');
        }

        $this->userModel->update($targetUserId, [
            'password'             => password_hash($newPassword, PASSWORD_BCRYPT),
            'verify_token'         => null,
            'verify_token_expires' => null,
        ]);

        return redirect()->to('/secretary/settings')->with('success', 'Password for <strong>' . esc(trim($target['first_name'] . ' ' . $target['last_name'])) . '</strong> has been reset successfully.');
    }
}
