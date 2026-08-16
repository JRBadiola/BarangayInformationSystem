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
        'requirements',
        'notify_residents',
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
            $map[$r['status']] = (int) $r['cnt'];
            $map['total']     += (int) $r['cnt'];
        }
        return $map;
    }

    /**
     * Return programs visible to residents (Active or Upcoming).
     */
    public function getVisibleToResidents(): array
    {
        return $this->whereIn('status', ['Active', 'Upcoming'])
            ->orderBy('start_date', 'ASC')
            ->findAll();
    }

    /**
     * Get registration count for a program.
     */
    public function getRegistrationCount(int $programId): int
    {
        return (int) $this->db->table('sk_program_registrations')
            ->where('program_id', $programId)
            ->countAllResults();
    }

    /**
     * Check if a user is registered for a program.
     */
    public function isRegistered(int $programId, int $userId): ?array
    {
        return $this->db->table('sk_program_registrations')
            ->where('program_id', $programId)
            ->where('user_id', $userId)
            ->get()->getRowArray();
    }

    /**
     * Parse requirements string into an array.
     *
     * @return string[]
     */
    public static function parseRequirements(?string $req): array
    {
        if (empty($req)) return [];
        return array_filter(array_map('trim', explode(',', $req)));
    }
}
