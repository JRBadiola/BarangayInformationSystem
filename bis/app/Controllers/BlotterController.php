<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BlotterModel;
use App\Models\UserModel;
use App\Libraries\EmailService;

class BlotterController extends BaseController
{
    protected BlotterModel $model;

    public function __construct()
    {
        $this->model = new BlotterModel();
    }

    // ── Public (non-resident): submit blotter report ─────────────────────────

    public function storePublic()
    {
        // Complainant name — split fields
        $lastName   = trim($this->request->getPost('complainant_last_name') ?? '');
        $firstName  = trim($this->request->getPost('complainant_first_name') ?? '');
        $middleName = trim($this->request->getPost('complainant_middle_name') ?? '');

        // Compose "Last Name, First Name Middle Name" format
        $nameParts = $firstName . ($middleName ? ' ' . $middleName : '');
        $complainantName = $lastName . ', ' . $nameParts;

        $complainantEmail   = trim($this->request->getPost('complainant_email') ?? '');
        $complainantContact = trim($this->request->getPost('contact_number') ?? '');
        $complainantAddress = trim($this->request->getPost('complainant_address') ?? '');
        $incidentType       = $this->request->getPost('incident_type');
        $incidentDate       = $this->request->getPost('incident_date');
        $incidentTime       = $this->request->getPost('incident_time');
        $location           = $this->request->getPost('location');
        $personsInvolved    = $this->request->getPost('persons_involved');
        $narrative          = trim($this->request->getPost('narrative') ?? '');
        $appointmentDate    = $this->request->getPost('appointment_date') ?: null;
        $appointmentTime    = $this->request->getPost('appointment_time') ?: null;

        if (empty($lastName) || empty($firstName) || empty($complainantEmail) || empty($incidentType) || empty($narrative)) {
            return redirect()->back()->with('error', 'Please fill in all required fields.')->withInput();
        }

        // Validate appointment date is not already booked
        if ($appointmentDate) {
            if ($this->isDateBooked($appointmentDate)) {
                return redirect()->back()->with('error', 'The selected appointment date (' . date('F d, Y', strtotime($appointmentDate)) . ') is already fully booked. Please choose another date.')->withInput();
            }

            // Validate time slot is not occupied
            if ($appointmentTime) {
                $conflict = $this->getTimeConflict($appointmentDate, $appointmentTime);
                if ($conflict) {
                    return redirect()->back()->with('error', 'The selected time (' . date('h:i A', strtotime($appointmentTime)) . ') conflicts with an existing event: "' . $conflict . '". Please choose a different time.')->withInput();
                }
            }
        }

        $blotterId = $this->model->insert([
            'complainant_user_id' => null,
            'complainant_name'    => $complainantName,
            'complainant_email'   => $complainantEmail,
            'complainant_contact' => $complainantContact ?: null,
            'appointment_date'    => $appointmentDate,
            'appointment_time'    => $appointmentTime,
            'incident_type'       => $incidentType,
            'incident_date'       => $incidentDate ?: null,
            'incident_time'       => $incidentTime ?: null,
            'location'            => $location ?: null,
            'persons_involved'    => $personsInvolved ?: null,
            'narrative'           => $narrative,
            'respondent_address'  => $complainantAddress ?: null,
            'status'              => 'pending',
        ], true); // true = return insert ID

        // If appointment was requested, create a calendar entry for the captain
        if ($appointmentDate && $blotterId) {
            $userModel   = new \App\Models\UserModel();
            $captainUser = $userModel->getActiveByRole('captain');

            if ($captainUser) {
                $scheduleModel = new \App\Models\ScheduleModel();
                $caseNo = str_pad($blotterId, 4, '0', STR_PAD_LEFT);
                $scheduleModel->insert([
                    'title'       => 'Blotter Appointment #' . $caseNo . ' — ' . $incidentType,
                    'description' => 'Complainant: ' . $complainantName . ($complainantContact ? ' · ' . $complainantContact : '') . "\n" . 'Re: ' . $incidentType,
                    'event_date'  => $appointmentDate,
                    'start_time'  => $appointmentTime ?: null,
                    'end_time'    => null,
                    'event_type'  => 'appointment',
                    'color'       => '#c0392b',
                    'location'    => 'Barangay Hall',
                    'blotter_id'  => $blotterId,
                    'created_by'  => (int) $captainUser['id'],
                    'visibility'  => 'private',
                    'shared_with' => null,
                ]);
            }
        }

        $msg = 'Your blotter report has been submitted successfully. The barangay will contact you at ' . $complainantEmail . '.';
        if ($appointmentDate) {
            $msg .= ' Your appointment is set for ' . date('F d, Y', strtotime($appointmentDate));
            if ($appointmentTime) {
                $msg .= ' at ' . date('h:i A', strtotime($appointmentTime));
            }
            $msg .= '.';
        }

        return redirect()->to('/')->with('blotter_success', $msg);
    }

    // ── Public: return booked dates as JSON for the date picker ──────────────

    public function busyDates()
    {
        $db = \Config\Database::connect();

        // Collect all appointment dates already filed
        $blotterDates = $db->table('blotter_reports')
            ->select('appointment_date AS date_val, COUNT(*) AS cnt')
            ->where('appointment_date IS NOT NULL')
            ->groupBy('appointment_date')
            ->get()->getResultArray();

        // Collect hearing dates
        $hearingDates = $db->table('blotter_reports')
            ->select('hearing_date AS date_val, COUNT(*) AS cnt')
            ->where('hearing_date IS NOT NULL')
            ->groupBy('hearing_date')
            ->get()->getResultArray();

        // Collect schedule events
        $scheduleDates = $db->table('schedules')
            ->select('event_date AS date_val, COUNT(*) AS cnt')
            ->groupBy('event_date')
            ->get()->getResultArray();

        // Aggregate — any date with 3+ total slots is "busy"
        $counts = [];
        foreach (array_merge($blotterDates, $hearingDates, $scheduleDates) as $row) {
            $d = $row['date_val'];
            $counts[$d] = ($counts[$d] ?? 0) + (int) $row['cnt'];
        }

        // Dates with >= 3 events are fully booked; return all occupied dates with their count
        $result = [];
        foreach ($counts as $date => $cnt) {
            $result[] = ['date' => $date, 'count' => $cnt, 'busy' => $cnt >= 3];
        }

        return $this->response->setJSON(['dates' => $result]);
    }

    // ── Public: return occupied time slots for a given date ───────────────────

    public function busySlots()
    {
        $date = trim($this->request->getGet('date') ?? '');

        // Basic date validation
        if (! $date || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $this->response->setJSON(['slots' => []]);
        }

        $db    = \Config\Database::connect();
        $slots = [];

        // Blotter appointments for this date
        $blotters = $db->table('blotter_reports')
            ->select('appointment_time AS start_time, NULL AS end_time, incident_type AS label')
            ->where('appointment_date', $date)
            ->where('appointment_time IS NOT NULL')
            ->get()->getResultArray();

        foreach ($blotters as $b) {
            $slots[] = [
                'start' => $b['start_time'],
                'end'   => null,
                'label' => 'Blotter Appointment: ' . $b['label'],
            ];
        }

        // Hearing dates
        $hearings = $db->table('blotter_reports')
            ->select('hearing_time AS start_time, NULL AS end_time, incident_type AS label')
            ->where('hearing_date', $date)
            ->where('hearing_time IS NOT NULL')
            ->get()->getResultArray();

        foreach ($hearings as $h) {
            $slots[] = [
                'start' => $h['start_time'],
                'end'   => null,
                'label' => 'Blotter Hearing: ' . $h['label'],
            ];
        }

        // Calendar events for this date (with start + end times)
        $events = $db->table('schedules')
            ->select('start_time, end_time, title AS label')
            ->where('event_date', $date)
            ->where('start_time IS NOT NULL')
            ->get()->getResultArray();

        foreach ($events as $e) {
            $slots[] = [
                'start' => $e['start_time'],
                'end'   => $e['end_time'],
                'label' => $e['label'],
            ];
        }

        return $this->response->setJSON(['slots' => $slots]);
    }

    // ── Helper: is a date already booked (3+ appointments)? ──────────────────
    private function isDateBooked(string $date): bool
    {
        $db = \Config\Database::connect();
        $total = 0;

        $total += $db->table('blotter_reports')->where('appointment_date', $date)->countAllResults();
        $total += $db->table('blotter_reports')->where('hearing_date', $date)->countAllResults();
        $total += $db->table('schedules')->where('event_date', $date)->countAllResults();

        return $total >= 3;
    }

    // ── Helper: does a time overlap any existing slot? Returns conflict label or null ──
    private function getTimeConflict(string $date, string $time): ?string
    {
        $db      = \Config\Database::connect();
        $reqMin  = $this->toMinutes($time);
        $reqEnd  = $reqMin + 60; // 1-hour slot

        // Check calendar events with start_time + end_time
        $events = $db->table('schedules')
            ->select('title, start_time, end_time')
            ->where('event_date', $date)
            ->where('start_time IS NOT NULL')
            ->get()->getResultArray();

        foreach ($events as $ev) {
            $evStart = $this->toMinutes($ev['start_time']);
            $evEnd   = $ev['end_time'] ? $this->toMinutes($ev['end_time']) : $evStart + 60;
            if ($reqMin < $evEnd && $reqEnd > $evStart) {
                return $ev['title'];
            }
        }

        // Check existing blotter appointments (treat as 1-hour slots)
        $appts = $db->table('blotter_reports')
            ->select('incident_type, appointment_time AS slot_time')
            ->where('appointment_date', $date)
            ->where('appointment_time IS NOT NULL')
            ->get()->getResultArray();

        foreach ($appts as $a) {
            $s = $this->toMinutes($a['slot_time']);
            if ($reqMin < $s + 60 && $reqEnd > $s) {
                return 'Blotter Appointment: ' . $a['incident_type'];
            }
        }

        // Check hearing slots
        $hearings = $db->table('blotter_reports')
            ->select('incident_type, hearing_time AS slot_time')
            ->where('hearing_date', $date)
            ->where('hearing_time IS NOT NULL')
            ->get()->getResultArray();

        foreach ($hearings as $h) {
            $s = $this->toMinutes($h['slot_time']);
            if ($reqMin < $s + 60 && $reqEnd > $s) {
                return 'Blotter Hearing: ' . $h['incident_type'];
            }
        }

        return null;
    }

    private function toMinutes(string $time): int
    {
        [$h, $m] = array_map('intval', explode(':', $time));
        return $h * 60 + $m;
    }

    // ── Resident: submit blotter report ──────────────────────────────────────

    public function store()
    {
        $userId    = (int) session()->get('user_id');
        $userModel = new UserModel();
        $user      = $userModel->find($userId);

        $incidentType    = $this->request->getPost('incident_type');
        $incidentDate    = $this->request->getPost('incident_date');
        $incidentTime    = $this->request->getPost('incident_time');
        $location        = $this->request->getPost('location');
        $personsInvolved = $this->request->getPost('persons_involved');
        $narrative       = trim($this->request->getPost('narrative') ?? '');

        if (empty($incidentType) || empty($narrative)) {
            return redirect()->back()->with('blotter_error', 'Please fill in the required fields.')->withInput();
        }

        $this->model->insert([
            'complainant_user_id' => $userId,
            'complainant_name'    => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')),
            'complainant_email'   => $user['email'] ?? '',
            'incident_type'       => $incidentType,
            'incident_date'       => $incidentDate ?: null,
            'incident_time'       => $incidentTime ?: null,
            'location'            => $location ?: null,
            'persons_involved'    => $personsInvolved ?: null,
            'narrative'           => $narrative,
            'status'              => 'pending',
        ]);

        return redirect()->to('/resident/dashboard')->with('success', 'Blotter report submitted successfully. The barangay will contact you shortly.');
    }

    // ── Admin: list all blotter reports ──────────────────────────────────────

    public function adminIndex(string $role)
    {
        $statusFilter = $_GET['status'] ?? '';
        $search       = $_GET['search'] ?? '';

        $db      = \Config\Database::connect();
        $builder = $db->table('blotter_reports b')
            ->select("b.*, CONCAT(TRIM(COALESCE(u.first_name,'')), ' ', TRIM(COALESCE(u.last_name,''))) AS complainant_full_name, u.email AS complainant_email_addr")
            ->join('users u', 'u.id = b.complainant_user_id', 'left')
            ->orderBy('b.created_at', 'DESC');

        if ($statusFilter !== '') {
            $builder->where('b.status', $statusFilter);
        }
        if ($search !== '') {
            $builder->groupStart()
                ->like('u.last_name', $search)
                ->orLike('u.first_name', $search)
                ->orLike('b.incident_type', $search)
                ->orLike('b.persons_involved', $search)
                ->groupEnd();
        }

        $reports = $builder->get()->getResultArray();

        $pending       = $this->model->where('status', 'pending')->countAllResults();
        $investigating = $this->model->where('status', 'under_investigation')->countAllResults();
        $resolved      = $this->model->where('status', 'resolved')->countAllResults();
        $total         = $this->model->countAll();

        $viewFile = ($role === 'captain')
            ? 'dashboard/captain/blotter'
            : 'dashboard/secretary/blotter';

        return view($viewFile, [
            'reports'       => $reports,
            'pending'       => $pending,
            'investigating' => $investigating,
            'resolved'      => $resolved,
            'total'         => $total,
            'statusFilter'  => $statusFilter,
            'search'        => $search,
        ]);
    }

    // ── Admin: view single blotter report ────────────────────────────────────

    public function show(int $id)
    {
        $role   = (string)(session()->get('role') ?? 'captain');
        $db     = \Config\Database::connect();
        $report = $db->table('blotter_reports b')
            ->select("b.*, CONCAT(TRIM(COALESCE(u.first_name,'')), ' ', TRIM(COALESCE(u.last_name,''))) AS complainant_full_name, u.email AS complainant_email_addr")
            ->join('users u', 'u.id = b.complainant_user_id', 'left')
            ->where('b.id', $id)
            ->get()->getRowArray();

        if (! $report) {
            return redirect()->to('/' . $role . '/blotter')->with('error', 'Report not found.');
        }

        return view('dashboard/captain/blotter_detail', [
            'report' => $report,
            'role'   => $role,
        ]);
    }

    // ── Admin: update status ──────────────────────────────────────────────────

    public function updateStatus(int $id)
    {
        $role    = (string)(session()->get('role') ?? 'captain');
        $status  = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks') ?? '';

        $this->model->update($id, [
            'status'       => $status,
            'remarks'      => $remarks,
            'processed_by' => session()->get('user_id'),
        ]);

        return redirect()->to('/' . $role . '/blotter/' . $id)->with('success', 'Status updated.');
    }

    public function sendSummons(int $id)
    {
        $role   = (string)(session()->get('role') ?? 'captain');
        $report = $this->model->find($id);

        if (! $report) {
            return redirect()->back()->with('error', 'Report not found.');
        }

        $hearingDate = $this->request->getPost('hearing_date');
        $hearingTime = $this->request->getPost('hearing_time');
        $respondentName  = trim($this->request->getPost('respondent_name') ?? '');
        $respondentEmail = trim($this->request->getPost('respondent_email') ?? '');
        $respondentAddr  = trim($this->request->getPost('respondent_address') ?? '');

        if (empty($hearingDate) || empty($hearingTime)) {
            return redirect()->back()->with('error', 'Please set a hearing date and time.');
        }

        // Save respondent info + hearing schedule
        $this->model->update($id, [
            'respondent_name'    => $respondentName,
            'respondent_email'   => $respondentEmail,
            'respondent_address' => $respondentAddr,
            'hearing_date'       => $hearingDate,
            'hearing_time'       => $hearingTime,
            'status'             => 'under_investigation',
            'summons_sent_at'    => date('Y-m-d H:i:s'),
            'processed_by'       => session()->get('user_id'),
        ]);

        $caseNo      = str_pad($id, 4, '0', STR_PAD_LEFT);
        $incidentType = $report['incident_type'];
        $hDate       = date('F d, Y', strtotime($hearingDate));
        $hTime       = date('h:i A', strtotime($hearingTime));

        $emailService = new EmailService();
        $errors       = [];

        // Send to complainant
        try {
            $emailService->sendSummons(
                $report['complainant_email'],
                $report['complainant_name'],
                $caseNo,
                $incidentType,
                $hDate,
                $hTime,
                'complainant'
            );
        } catch (\Throwable $e) {
            $errors[] = 'Could not send to complainant: ' . $e->getMessage();
            log_message('error', 'Summons to complainant failed: ' . $e->getMessage());
        }

        // Send to respondent (if email provided)
        if (! empty($respondentEmail)) {
            try {
                $emailService->sendSummons(
                    $respondentEmail,
                    $respondentName ?: 'Respondent',
                    $caseNo,
                    $incidentType,
                    $hDate,
                    $hTime,
                    'respondent'
                );
            } catch (\Throwable $e) {
                $errors[] = 'Could not send to respondent: ' . $e->getMessage();
                log_message('error', 'Summons to respondent failed: ' . $e->getMessage());
            }
        }

        if (! empty($errors)) {
            return redirect()->to('/' . $role . '/blotter/' . $id)
                ->with('error', implode(' | ', $errors));
        }

        return redirect()->to('/' . $role . '/blotter/' . $id)
            ->with('success', 'Hearing Schedule saved successfully.');
    }

    // ── Admin: reschedule hearing ─────────────────────────────────────────────

    public function reschedule(int $id)
    {
        $role        = (string)(session()->get('role') ?? 'captain');
        $hearingDate = $this->request->getPost('hearing_date');
        $hearingTime = $this->request->getPost('hearing_time');
        $notes       = trim($this->request->getPost('hearing_notes') ?? '');

        if (empty($hearingDate) || empty($hearingTime)) {
            return redirect()->back()->with('error', 'Please provide both a date and time for the hearing.');
        }

        $this->model->update($id, [
            'hearing_date'  => $hearingDate,
            'hearing_time'  => $hearingTime,
            'hearing_notes' => $notes ?: null,
            'scheduled_by'  => session()->get('user_id'),
            'status'        => 'under_investigation',
        ]);

        return redirect()->to('/' . $role . '/blotter/' . $id)
            ->with('success', 'Hearing schedule updated successfully.');
    }

    // ── Admin: view/print summons letter ─────────────────────────────────────

    public function viewLetter(int $id)
    {
        $role   = (string)(session()->get('role') ?? 'captain');
        $db     = \Config\Database::connect();
        $report = $db->table('blotter_reports b')
            ->select("b.*, CONCAT(TRIM(COALESCE(u.first_name,'')), ' ', TRIM(COALESCE(u.last_name,''))) AS complainant_full_name, u.email AS complainant_email_addr")
            ->join('users u', 'u.id = b.complainant_user_id', 'left')
            ->where('b.id', $id)
            ->get()->getRowArray();

        if (! $report) {
            return redirect()->to('/' . $role . '/blotter')->with('error', 'Report not found.');
        }

        // Mark letter as issued
        $this->model->update($id, ['letter_issued_at' => date('Y-m-d H:i:s')]);

        return view('blotter_letter', [
            'report' => $report,
            'role'   => $role,
        ]);
    }
}
