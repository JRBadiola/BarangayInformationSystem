<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table         = 'schedules';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'event_type',
        'color',
        'location',
        'blotter_id',
        'created_by',
        'visibility',
        'shared_with',
    ];

    /**
     * Get events visible to a given user.
     * Captain: sees own events + events shared_with them.
     * Secretary: sees only own events.
     */
    public function getVisibleByMonth(int $year, int $month, int $userId, string $role): array
    {
        $start = sprintf('%04d-%02d-01', $year, $month);
        $end   = date('Y-m-t', strtotime($start));

        $db = \Config\Database::connect();

        if ($role === 'captain') {
            // Captain sees: own events OR events shared_with them
            $rows = $db->table('schedules')
                ->where('event_date >=', $start)
                ->where('event_date <=', $end)
                ->groupStart()
                ->where('created_by', $userId)
                ->orWhere('shared_with', $userId)
                ->groupEnd()
                ->orderBy('event_date', 'ASC')
                ->orderBy('start_time', 'ASC')
                ->get()->getResultArray();
        } else {
            // Secretary sees only own events
            $rows = $db->table('schedules')
                ->where('event_date >=', $start)
                ->where('event_date <=', $end)
                ->where('created_by', $userId)
                ->orderBy('event_date', 'ASC')
                ->orderBy('start_time', 'ASC')
                ->get()->getResultArray();
        }

        $byDate = [];
        foreach ($rows as $row) {
            $byDate[$row['event_date']][] = $row;
        }
        return $byDate;
    }

    /**
     * Get upcoming events visible to a user.
     */
    public function getUpcomingVisible(int $userId, string $role, int $limit = 8): array
    {
        $db = \Config\Database::connect();

        if ($role === 'captain') {
            return $db->table('schedules')
                ->where('event_date >=', date('Y-m-d'))
                ->groupStart()
                ->where('created_by', $userId)
                ->orWhere('shared_with', $userId)
                ->groupEnd()
                ->orderBy('event_date', 'ASC')
                ->orderBy('start_time', 'ASC')
                ->limit($limit)
                ->get()->getResultArray();
        }

        return $db->table('schedules')
            ->where('event_date >=', date('Y-m-d'))
            ->where('created_by', $userId)
            ->orderBy('event_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->limit($limit)
            ->get()->getResultArray();
    }

    /**
     * Get all events visible to a user (for list view).
     */
    public function getAllVisible(int $userId, string $role, string $search = '', string $type = ''): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('schedules');

        if ($role === 'captain') {
            $builder->groupStart()
                ->where('created_by', $userId)
                ->orWhere('shared_with', $userId)
                ->groupEnd();
        } else {
            $builder->where('created_by', $userId);
        }

        if ($search !== '') {
            $s = $db->escapeLikeString($search);
            $builder->groupStart()
                ->like('title', $search)
                ->orLike('description', $search)
                ->orLike('location', $search)
                ->groupEnd();
        }
        if ($type !== '') {
            $builder->where('event_type', $type);
        }

        return $builder->orderBy('event_date', 'DESC')->orderBy('start_time', 'ASC')->get()->getResultArray();
    }
}
