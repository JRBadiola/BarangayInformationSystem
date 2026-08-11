<?php

namespace App\Models;

use CodeIgniter\Model;

class BlotterModel extends Model
{
    protected $table         = 'blotter_reports';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'complainant_user_id',
        'complainant_name',
        'complainant_email',
        'complainant_contact',
        'appointment_date',
        'appointment_time',
        'incident_type',
        'incident_date',
        'incident_time',
        'location',
        'persons_involved',
        'narrative',
        'respondent_name',
        'respondent_email',
        'respondent_address',
        'status',
        'remarks',
        'processed_by',
        'summons_sent_at',
        'hearing_date',
        'hearing_time',
        'hearing_notes',
        'scheduled_by',
        'letter_issued_at',
    ];

    public function getByUser(int $userId): array
    {
        return $this->where('complainant_user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getAllWithComplainant(): array
    {
        return $this->db->table('blotter_reports b')
            ->select("b.*, CONCAT(TRIM(COALESCE(u.first_name,'')), ' ', TRIM(COALESCE(u.last_name,''))) AS complainant_full_name, u.email AS complainant_email_addr")
            ->join('users u', 'u.id = b.complainant_user_id', 'left')
            ->orderBy('b.created_at', 'DESC')
            ->get()->getResultArray();
    }
}
