<?php

namespace App\Models;

use CodeIgniter\Model;

class ClearanceRequestModel extends Model
{
    protected $table         = 'clearance_requests';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'user_id',
        'household_no',
        'for_member',
        'member_relationship',
        'document_type',
        'purpose',
        'notes',
        'status',
        'remarks',
        'processed_by',
        'processed_at',
        'est_release_date',
    ];

    /**
     * Get all requests for a specific resident user.
     */
    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get all pending requests (for captain/secretary view).
     */
    public function getPending(): array
    {
        return $this->where('status', 'pending')
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }
}
