<?php

namespace App\Controllers;

use App\Controllers\BaseController;

/**
 * AdminNotificationController
 *
 * Provides real-time activity notifications for secretary and captain
 * by querying live counts directly from the database.
 * These are not stored notifications — they reflect actual pending work.
 */
class AdminNotificationController extends BaseController
{
    // ── GET /secretary/notifications  ─────────────────────────────────────────
    public function index(string $role = 'secretary')
    {
        // SK gets a completely different notifications page — activity-focused
        if ($role === 'sk') {
            return view('dashboard/sk/notifications');
        }

        $data = $this->_buildNotificationData();
        $data['role'] = $role;

        $view = ($role === 'captain')
            ? 'dashboard/captain/notifications'
            : 'dashboard/secretary/notifications';

        return view($view, $data);
    }

    // ── GET /secretary/notifications/poll  (JSON for topbar bell) ─────────────
    public function poll(): \CodeIgniter\HTTP\ResponseInterface
    {
        $role = session()->get('role');

        // SK gets their own count: pending registrations for their programs
        if ($role === 'sk') {
            $userId = (int) session()->get('user_id');
            $db     = \Config\Database::connect();
            $count  = (int) $db->table('sk_program_registrations r')
                ->join('sk_programs p', 'p.id = r.program_id')
                ->where('p.created_by', $userId)
                ->where('r.status', 'pending')
                ->countAllResults();
            return $this->response->setJSON(['unread' => $count]);
        }

        // Secretary / Captain: use the shared builder
        $data  = $this->_buildNotificationData();
        $total = array_sum(array_column($data['groups'], 'count'));

        return $this->response->setJSON([
            'unread' => $total,
            'groups' => $data['groups'],
        ]);
    }

    // ── Shared data builder ───────────────────────────────────────────────────
    private function _buildNotificationData(): array
    {
        $db = \Config\Database::connect();

        // ── 1. Pending accounts awaiting approval ─────────────────────────────
        $pendingAccounts = (int) $db->table('users')
            ->where('status', 'pending')
            ->countAllResults();

        // ── 2. Pending clearance / document requests ──────────────────────────
        $pendingClearances = (int) $db->table('clearance_requests')
            ->where('status', 'pending')
            ->countAllResults();

        // ── 3. New blotter reports (filed within the last 7 days, still open) ─
        $newBlotters = (int) $db->table('blotter_reports')
            ->whereIn('status', ['pending', 'under_investigation'])
            ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->countAllResults();

        // ── 4. Unresolved blotter reports (all open/pending) ──────────────────
        $openBlotters = (int) $db->table('blotter_reports')
            ->whereIn('status', ['pending', 'under_investigation'])
            ->countAllResults();

        // ── 5. Blotter hearings scheduled for today or tomorrow ───────────────
        $upcomingHearings = (int) $db->table('blotter_reports')
            ->where('appointment_date >=', date('Y-m-d'))
            ->where('appointment_date <=', date('Y-m-d', strtotime('+1 day')))
            ->whereIn('status', ['pending', 'under_investigation'])
            ->countAllResults();

        // ── 6. Recent clearance requests (last 24h) ───────────────────────────
        $recentClearances = $db->table('clearance_requests cr')
            ->select('cr.id, cr.document_type, cr.purpose, cr.status, cr.created_at,
                      CONCAT(TRIM(u.first_name), " ", TRIM(u.last_name)) AS resident_name')
            ->join('users u', 'u.id = cr.user_id', 'left')
            ->where('cr.status', 'pending')
            ->orderBy('cr.created_at', 'DESC')
            ->limit(10)
            ->get()->getResultArray();

        // ── 7. Recent blotter reports (last 7 days) ───────────────────────────
        $recentBlotters = $db->table('blotter_reports')
            ->select('id, complainant_name, incident_type, status, created_at, appointment_date')
            ->whereIn('status', ['pending', 'under_investigation'])
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get()->getResultArray();

        // ── 8. Pending user accounts (detail) ────────────────────────────────
        $pendingUsers = $db->table('users')
            ->select('id, first_name, last_name, role, email, created_at')
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get()->getResultArray();

        // ── 9. Upcoming schedules (today + next 3 days) ───────────────────────
        $upcomingSchedules = (int) $db->table('schedules')
            ->where('event_date >=', date('Y-m-d'))
            ->where('event_date <=', date('Y-m-d', strtotime('+3 days')))
            ->countAllResults();

        $upcomingScheduleList = $db->table('schedules')
            ->select('id, title, event_date, start_time, location')
            ->where('event_date >=', date('Y-m-d'))
            ->where('event_date <=', date('Y-m-d', strtotime('+3 days')))
            ->orderBy('event_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->limit(5)
            ->get()->getResultArray();

        // ── Groups for the bell badge total ──────────────────────────────────
        $groups = [
            ['key' => 'pending_accounts',  'count' => $pendingAccounts],
            ['key' => 'pending_clearances', 'count' => $pendingClearances],
            ['key' => 'new_blotters',      'count' => $newBlotters],
            ['key' => 'upcoming_hearings', 'count' => $upcomingHearings],
            ['key' => 'upcoming_schedules', 'count' => $upcomingSchedules],
        ];

        return [
            'groups'               => $groups,
            'pendingAccounts'      => $pendingAccounts,
            'pendingClearances'    => $pendingClearances,
            'newBlotters'          => $newBlotters,
            'openBlotters'         => $openBlotters,
            'upcomingHearings'     => $upcomingHearings,
            'upcomingSchedules'    => $upcomingSchedules,
            'recentClearances'     => $recentClearances,
            'recentBlotters'       => $recentBlotters,
            'pendingUsers'         => $pendingUsers,
            'upcomingScheduleList' => $upcomingScheduleList,
        ];
    }
}
