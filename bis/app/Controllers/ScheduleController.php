<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ScheduleModel;

class ScheduleController extends BaseController
{
    protected ScheduleModel $model;

    public function __construct()
    {
        $this->model = new ScheduleModel();
    }

    public function view(int $id)
    {
        $role   = session()->get('role');
        $userId = (int) session()->get('user_id');
        $event  = $this->model->find($id);

        if (! $event) {
            return redirect()->to('/' . $role . '/calendar')->with('cal_error', 'Event not found.');
        }

        $canEdit     = ((int) $event['created_by'] === $userId);
        $isSharedToMe = ($role === 'captain' && (int) ($event['shared_with'] ?? 0) === $userId);

        if (! $canEdit && ! $isSharedToMe) {
            return redirect()->to('/' . $role . '/calendar')->with('cal_error', 'You do not have access to this event.');
        }

        $captainUser = null;
        if ($role === 'secretary') {
            $userModel   = new \App\Models\UserModel();
            $captainUser = $userModel->getActiveByRole('captain');
        }

        return view('dashboard/captain/event_detail', [
            'event'       => $event,
            'role'        => $role,
            'canEdit'     => $canEdit,
            'captainUser' => $captainUser,
        ]);
    }

    public function index()
    {
        $role   = session()->get('role');
        $userId = (int) session()->get('user_id');
        $year   = (int) ($_GET['year']  ?? date('Y'));
        $month  = (int) ($_GET['month'] ?? date('n'));

        if ($month < 1) {
            $month = 12;
            $year--;
        }
        if ($month > 12) {
            $month = 1;
            $year++;
        }

        $byDate   = $this->model->getVisibleByMonth($year, $month, $userId, $role);
        $upcoming = $this->model->getUpcomingVisible($userId, $role, 8);

        $db    = \Config\Database::connect();
        $start = sprintf('%04d-%02d-01', $year, $month);
        $end   = date('Y-m-t', strtotime($start));
        $hearings = $db->table('blotter_reports')
            ->select('id, incident_type, hearing_date, hearing_time, respondent_name, complainant_name')
            ->where('hearing_date IS NOT NULL')
            ->where('hearing_date >=', $start)
            ->where('hearing_date <=', $end)
            ->get()->getResultArray();

        foreach ($hearings as $h) {
            $d = $h['hearing_date'];
            $byDate[$d][] = [
                'id'          => 'bl-' . $h['id'],
                'title'       => 'Hearing: ' . $h['incident_type'],
                'description' => 'Complainant: ' . $h['complainant_name'] . ' vs. ' . ($h['respondent_name'] ?: 'Unknown'),
                'event_date'  => $d,
                'start_time'  => $h['hearing_time'],
                'end_time'    => null,
                'event_type'  => 'hearing',
                'color'       => '#c0392b',
                'location'    => 'Barangay Hall',
                'blotter_id'  => $h['id'],
                'is_blotter'  => true,
            ];
        }

        foreach ($byDate as &$dayEvents) {
            usort($dayEvents, fn($a, $b) => strcmp($a['start_time'] ?? '', $b['start_time'] ?? ''));
        }
        unset($dayEvents);

        $captainUser = null;
        if ($role === 'secretary') {
            $userModel   = new \App\Models\UserModel();
            $captainUser = $userModel->getActiveByRole('captain');
        }

        return view('dashboard/captain/calendar', [
            'role'        => $role,
            'year'        => $year,
            'month'       => $month,
            'byDate'      => $byDate,
            'upcoming'    => $upcoming,
            'captainUser' => $captainUser,
        ]);
    }

    public function store()
    {
        $role   = session()->get('role');
        $userId = (int) session()->get('user_id');
        $post   = $this->request->getPost();

        if (empty($post['title']) || empty($post['event_date'])) {
            return redirect()->back()->with('cal_error', 'Title and date are required.');
        }

        $shareWithCaptain = ! empty($post['share_with_captain']) && $role === 'secretary';
        $visibility = $shareWithCaptain ? 'shared' : 'private';
        $sharedWith = null;

        if ($shareWithCaptain) {
            $userModel   = new \App\Models\UserModel();
            $captainUser = $userModel->getActiveByRole('captain');
            $sharedWith  = $captainUser ? (int) $captainUser['id'] : null;
        }

        $this->model->insert([
            'title'       => trim($post['title']),
            'description' => trim($post['description'] ?? ''),
            'event_date'  => $post['event_date'],
            'start_time'  => $post['start_time']  ?: null,
            'end_time'    => $post['end_time']     ?: null,
            'event_type'  => $post['event_type']   ?? 'appointment',
            'color'       => $post['color']        ?? '#1d2448',
            'location'    => trim($post['location'] ?? ''),
            'created_by'  => $userId,
            'visibility'  => $visibility,
            'shared_with' => $sharedWith,
        ]);

        $qs  = http_build_query(['year' => date('Y', strtotime($post['event_date'])), 'month' => date('n', strtotime($post['event_date']))]);
        $msg = 'Event added successfully.';
        if ($shareWithCaptain && $sharedWith) {
            $msg .= ' It has also been added to the Captain\'s calendar.';
        }
        return redirect()->to('/' . $role . '/calendar?' . $qs)->with('cal_success', $msg);
    }

    public function update(int $id)
    {
        $role   = session()->get('role');
        $userId = (int) session()->get('user_id');
        $post   = $this->request->getPost();
        $event  = $this->model->find($id);

        if (! $event || (int) $event['created_by'] !== $userId) {
            return redirect()->back()->with('cal_error', 'You can only edit events you created.');
        }

        if (empty($post['title']) || empty($post['event_date'])) {
            return redirect()->back()->with('cal_error', 'Title and date are required.');
        }

        $shareWithCaptain = ! empty($post['share_with_captain']) && $role === 'secretary';
        $visibility = $event['visibility'];
        $sharedWith = $event['shared_with'];

        if ($role === 'secretary') {
            $visibility = $shareWithCaptain ? 'shared' : 'private';
            if ($shareWithCaptain) {
                $userModel   = new \App\Models\UserModel();
                $captainUser = $userModel->getActiveByRole('captain');
                $sharedWith  = $captainUser ? (int) $captainUser['id'] : null;
            } else {
                $sharedWith = null;
            }
        }

        $this->model->update($id, [
            'title'       => trim($post['title']),
            'description' => trim($post['description'] ?? ''),
            'event_date'  => $post['event_date'],
            'start_time'  => $post['start_time']  ?: null,
            'end_time'    => $post['end_time']     ?: null,
            'event_type'  => $post['event_type']   ?? 'appointment',
            'color'       => $post['color']        ?? '#1d2448',
            'location'    => trim($post['location'] ?? ''),
            'visibility'  => $visibility,
            'shared_with' => $sharedWith,
        ]);

        $qs = http_build_query(['year' => date('Y', strtotime($post['event_date'])), 'month' => date('n', strtotime($post['event_date']))]);
        return redirect()->to('/' . $role . '/calendar?' . $qs)->with('cal_success', 'Event updated.');
    }

    public function delete(int $id)
    {
        $role   = session()->get('role');
        $userId = (int) session()->get('user_id');
        $event  = $this->model->find($id);

        if (! $event || (int) $event['created_by'] !== $userId) {
            return redirect()->back()->with('cal_error', 'You can only delete events you created.');
        }

        $this->model->delete($id);

        $qs = http_build_query(['year' => date('Y', strtotime($event['event_date'])), 'month' => date('n', strtotime($event['event_date']))]);
        return redirect()->to('/' . $role . '/calendar?' . $qs)->with('cal_success', 'Event deleted.');
    }

    public function listAll()
    {
        $role   = session()->get('role');
        $userId = (int) session()->get('user_id');
        $search = trim($_GET['search'] ?? '');
        $type   = trim($_GET['type']   ?? '');

        $events = $this->model->getAllVisible($userId, $role, $search, $type);

        return view('dashboard/captain/events_list', [
            'events' => $events,
            'role'   => $role,
            'search' => $search,
            'type'   => $type,
        ]);
    }
}
