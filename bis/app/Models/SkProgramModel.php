<?php

namespace App\Models;

use CodeIgniter\Model;

class SkProgramModel extends Model
{
    protected $table         = 'sk_programs';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'name',
        'category',
        'description',
        'start_date',
        'end_date',
        'venue',
        'target_participants',
        'actual_participants',
        'budget',
        'status',
        'created_by',
    ];

    /** Counts grouped by status. */
    public function statusCounts(): array
    {
        $rows = $this->db->table('sk_programs')
            ->select('status, COUNT(*) AS cnt')
            ->groupBy('status')
            ->get()->getResultArray();

        $map = ['Upcoming' => 0, 'Active' => 0, 'Completed' => 0, 'Cancelled' => 0, 'total' => 0];
        foreach ($rows as $r) {
            $map[$r['status']] = (int)$r['cnt'];
            $map['total'] += (int)$r['cnt'];
        }
        return $map;
    }
}
