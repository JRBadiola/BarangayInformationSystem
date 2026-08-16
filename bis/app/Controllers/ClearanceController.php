<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClearanceRequestModel;
use App\Models\DocumentTemplateModel;
use App\Models\BarangaySettingsModel;
use App\Models\HouseholdModel;
use App\Models\HouseholdMemberModel;
use App\Models\NotificationModel;
use App\Models\UserModel;

class ClearanceController extends BaseController
{
    protected ClearanceRequestModel $model;

    public function __construct()
    {
        $this->model = new ClearanceRequestModel();
    }

    // ── Resident: show clearance page ─────────────────────────────────────────

    public function residentIndex()
    {
        $userId    = (int) session()->get('user_id');
        $userModel = new UserModel();
        $user      = $userModel->find($userId);

        // Load household members for the "for whom" dropdown
        $members = [];
        $householdTotalIncome = 0;
        $occupation = '';   // household head's occupation for FTJS eligibility

        if (! empty($user['household_no'])) {
            $hm      = new HouseholdModel();
            $head    = $hm->find($user['household_no']);
            $memModel = new HouseholdMemberModel();
            $rawMembers = $memModel->where('household_no', $user['household_no'])->findAll();

            if ($head) {
                $members[] = [
                    'name'         => trim($head['first_name'] . ' ' . $head['last_name']),
                    'relationship' => 'Household Head',
                ];
                $householdTotalIncome += (float) ($head['monthly_income'] ?? 0);
                $occupation = $head['occupation'] ?? '';
            }
            foreach ($rawMembers as $m) {
                $members[] = [
                    'name'         => trim($m['first_name'] . ' ' . $m['last_name']),
                    'relationship' => ucfirst($m['relationship']),
                ];
                $householdTotalIncome += (float) ($m['monthly_income'] ?? 0);
            }
        }

        // Determine if the resident is employed (blocks FTJS)
        $isEmployed = ! empty($occupation)
            && strtolower(trim($occupation)) !== 'none'
            && strtolower(trim($occupation)) !== 'n/a'
            && strtolower(trim($occupation)) !== 'unemployed'
            && strtolower(trim($occupation)) !== 'student'
            && strtolower(trim($occupation)) !== 'out-of-school'
            && ! empty(trim($occupation));

        $requests = $this->model->getByUser($userId);

        return view('dashboard/resident/clearance', [
            'requests'             => $requests,
            'members'              => $members,
            'user'                 => $user,
            'householdTotalIncome' => $householdTotalIncome,
            'occupation'           => $occupation,
            'isEmployed'           => $isEmployed,
        ]);
    }

    // ── Resident: submit new request ──────────────────────────────────────────

    public function store()
    {
        $userId  = (int) session()->get('user_id');
        $userModel = new UserModel();
        $user    = $userModel->find($userId);

        $forMember   = $this->request->getPost('for_member');
        $memberRel   = $this->request->getPost('member_relationship');
        $docType     = $this->request->getPost('document_type');
        $purpose     = trim($this->request->getPost('purpose') ?? '');
        $notes       = trim($this->request->getPost('notes') ?? '');

        if (empty($forMember) || empty($docType) || empty($purpose)) {
            return redirect()->back()->with('error', 'Please fill in all required fields.')->withInput();
        }

        // ── Indigency income qualification check ──────────────────────────────
        if ($docType === 'Certificate of Indigency' && ! empty($user['household_no'])) {
            $hm          = new HouseholdModel();
            $head        = $hm->find($user['household_no']);
            $memModel    = new HouseholdMemberModel();
            $members     = $memModel->where('household_no', $user['household_no'])->findAll();

            $headIncome   = (float) ($head['monthly_income'] ?? 0);
            $memberIncome = array_sum(array_column($members, 'monthly_income'));
            $totalIncome  = $headIncome + $memberIncome;

            if ($totalIncome > 12000) {
                // Auto-reject: insert as rejected immediately
                $this->model->insert([
                    'user_id'             => $userId,
                    'household_no'        => $user['household_no'] ?? null,
                    'for_member'          => $forMember,
                    'member_relationship' => $memberRel,
                    'document_type'       => $docType,
                    'purpose'             => $purpose,
                    'notes'               => $notes ?: null,
                    'status'              => 'rejected',
                    'remarks'             => 'Automatically rejected: household net monthly income of ₱' . number_format($totalIncome, 2) . ' exceeds the ₱12,000.00 indigency threshold.',
                    'processed_at'        => date('Y-m-d H:i:s'),
                    'est_release_date'    => null,
                ]);

                $role = session()->get('role') === 'sk' ? 'sk' : 'resident';
                return redirect()->to('/' . $role . '/clearance')->with(
                    'error',
                    'Your request for a Certificate of Indigency was automatically rejected. ' .
                        'Your household\'s net monthly income (₱' . number_format($totalIncome, 2) . ') ' .
                        'exceeds the ₱12,000.00 eligibility threshold.'
                );
            }
        }

        // Estimate release: 2 business days from now
        $estRelease = date('Y-m-d', strtotime('+2 weekdays'));

        $this->model->insert([
            'user_id'             => $userId,
            'household_no'        => $user['household_no'] ?? null,
            'for_member'          => $forMember,
            'member_relationship' => $memberRel,
            'document_type'       => $docType,
            'purpose'             => $purpose,
            'notes'               => $notes ?: null,
            'status'              => 'pending',
            'est_release_date'    => $estRelease,
        ]);

        $role = session()->get('role') === 'sk' ? 'sk' : 'resident';
        return redirect()->to('/' . $role . '/clearance')->with('success', 'Request submitted successfully! Estimated release: ' . date('M d, Y', strtotime($estRelease)));
    }

    // ── Admin (captain/secretary): list all requests — grouped by resident ───

    public function adminIndex(string $role)
    {
        $db = \Config\Database::connect();

        // Stats
        $model    = $this->model;
        $pending  = $model->where('status', 'pending')->countAllResults();
        $approved = $model->where('status', 'approved')->countAllResults();
        $rejected = $model->where('status', 'rejected')->countAllResults();
        $total    = $model->countAll();

        // Filters
        $statusFilter = $_GET['status'] ?? '';
        $typeFilter   = $_GET['type']   ?? '';
        $search       = $_GET['search'] ?? '';

        // Group by resident (user_id) — show one row per resident with their latest request
        $builder = $db->table('clearance_requests cr')
            ->select("
                cr.user_id,
                CONCAT(TRIM(COALESCE(u.first_name,'')), ' ', TRIM(COALESCE(u.last_name,''))) AS resident_name,
                u.username,
                h.zone,
                h.address,
                h.contact_number,
                COUNT(cr.id) AS total_requests,
                SUM(cr.status = 'pending')  AS pending_count,
                SUM(cr.status = 'approved') AS approved_count,
                SUM(cr.status = 'rejected') AS rejected_count,
                MAX(cr.created_at) AS latest_filed
            ")
            ->join('users u', 'u.id = cr.user_id', 'left')
            ->join('households h', 'h.household_no = u.household_no', 'left')
            ->groupBy('cr.user_id')
            ->orderBy('latest_filed', 'DESC');

        if ($statusFilter !== '') {
            $builder->having('SUM(cr.status = "' . $db->escapeString($statusFilter) . '") >', 0);
        }
        if ($typeFilter !== '') {
            $builder->where('cr.document_type', $typeFilter);
        }
        if ($search !== '') {
            $builder->groupStart()
                ->like('u.first_name', $search)
                ->orLike('u.last_name', $search)
                ->groupEnd();
        }

        $perPage       = 10;
        $page          = (int) ($_GET['page'] ?? 1);
        $offset        = ($page - 1) * $perPage;
        $filteredTotal = $builder->countAllResults(false);
        $residents     = $builder->limit($perPage, $offset)->get()->getResultArray();

        // Fetch active captain name for document signatures
        $userModel   = new \App\Models\UserModel();
        $captainRow  = $userModel->getActiveByRole('captain');
        $captainName = $captainRow
            ? strtoupper(trim(($captainRow['first_name'] ?? '') . ' ' . ($captainRow['middle_name'] ?? '') . ' ' . ($captainRow['last_name'] ?? '')))
            : 'PUNONG BARANGAY';

        $templateModel = new DocumentTemplateModel();
        $templates     = $templateModel->tableExists()
            ? $templateModel->getTemplatesIndexedByKey()
            : $templateModel->getDefaultTemplates();

        $settingsModel   = new BarangaySettingsModel();
        $barangaySettings = $settingsModel->getAll();
        // getAll() always overrides captain_name with the live appointed captain
        $captainName = $barangaySettings['captain_name'] ?: $captainName;

        $viewFile = ($role === 'captain')
            ? 'dashboard/captain/clearance'
            : 'dashboard/secretary/clearance';

        return view($viewFile, [
            'residents'        => $residents,
            'pending'          => $pending,
            'approved'         => $approved,
            'rejected'         => $rejected,
            'total'            => $total,
            'filteredTotal'    => $filteredTotal,
            'perPage'          => $perPage,
            'currentPage'      => $page,
            'statusFilter'     => $statusFilter,
            'typeFilter'       => $typeFilter,
            'search'           => $search,
            'captainName'      => $captainName,
            'templates'        => $templates,
            'barangaySettings' => $barangaySettings,
        ]);
    }

    // ── Admin: view all requests for one resident ─────────────────────────────

    public function residentDetail(int $userId)
    {
        $role     = session()->get('role');
        $db       = \Config\Database::connect();

        // Get resident info
        $userModel = new UserModel();
        $user      = $userModel->find($userId);
        if (! $user) {
            return redirect()->to('/' . $role . '/clearance')->with('error', 'Resident not found.');
        }

        // Get census data
        $household    = null;
        $memberRecord = null;
        if (! empty($user['household_no'])) {
            $hm        = new HouseholdModel();
            $household = $hm->find($user['household_no']);
        }

        // Get all requests for this resident
        $requests = $db->table('clearance_requests')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        // Fetch active captain name for document signatures
        $captainRow  = $userModel->getActiveByRole('captain');
        $captainName = $captainRow
            ? strtoupper(trim(($captainRow['first_name'] ?? '') . ' ' . ($captainRow['middle_name'] ?? '') . '. ' . ($captainRow['last_name'] ?? '')))
            : 'PUNONG BARANGAY';

        $settingsModel    = new BarangaySettingsModel();
        $barangaySettings = $settingsModel->getAll();
        // getAll() always overrides captain_name with the live appointed captain
        $captainName = $barangaySettings['captain_name'] ?: $captainName;

        return view('dashboard/captain/clearance_detail', [
            'role'             => $role,
            'user'             => $user,
            'household'        => $household,
            'requests'         => $requests,
            'requestId'        => $userId,
            'captainName'      => $captainName,
            'barangaySettings' => $barangaySettings,
        ]);
    }

    // ── Admin: approve a request ──────────────────────────────────────────────

    public function approve(int $id)
    {
        $role = session()->get('role');
        $req  = $this->model->find($id);

        $this->model->update($id, [
            'status'       => 'approved',
            'processed_by' => session()->get('user_id'),
            'processed_at' => date('Y-m-d H:i:s'),
        ]);

        // Notify the resident
        if ($req && ! empty($req['user_id'])) {
            $estDate = ! empty($req['est_release_date'])
                ? ' Estimated release: ' . date('M d, Y', strtotime($req['est_release_date'])) . '.'
                : '';
            \App\Models\NotificationModel::push(
                (int) $req['user_id'],
                'clearance_approved',
                'Request Approved — ' . $req['document_type'],
                'Your ' . $req['document_type'] . ' request has been approved.' . $estDate . ' You may pick it up at the barangay hall during office hours.',
                '/resident/clearance'
            );
        }

        return redirect()->back()->with('success', 'Request approved.');
    }

    // ── Admin: reject a request ───────────────────────────────────────────────

    public function reject(int $id)
    {
        $role    = session()->get('role');
        $remarks = $this->request->getPost('remarks') ?? '';
        $req     = $this->model->find($id);

        $this->model->update($id, [
            'status'       => 'rejected',
            'remarks'      => $remarks,
            'processed_by' => session()->get('user_id'),
            'processed_at' => date('Y-m-d H:i:s'),
        ]);

        // Notify the resident
        if ($req && ! empty($req['user_id'])) {
            $reasonPart = $remarks ? ' Reason: ' . $remarks : '';
            \App\Models\NotificationModel::push(
                (int) $req['user_id'],
                'clearance_rejected',
                'Request Not Approved — ' . $req['document_type'],
                'Your ' . $req['document_type'] . ' request could not be approved.' . $reasonPart . ' Please visit the barangay hall for assistance.',
                '/resident/clearance'
            );
        }

        return redirect()->back()->with('success', 'Request rejected.');
    }

    public function cancel(int $id)
    {
        $userId  = (int) session()->get('user_id');
        $request = $this->model->find($id);

        // Cast DB value to int to avoid strict type mismatch
        if (! $request || (int)$request['user_id'] !== $userId || $request['status'] !== 'pending') {
            return redirect()->to('/resident/clearance')->with('error', 'Cannot cancel this request.');
        }

        $this->model->delete($id);
        $role = session()->get('role') === 'sk' ? 'sk' : 'resident';
        return redirect()->to('/' . $role . '/clearance')->with('success', 'Request cancelled successfully.');
    }
}
