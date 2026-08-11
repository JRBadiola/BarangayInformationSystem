<?php

namespace App\Models;

use CodeIgniter\Model;

class SkYouthModel extends Model
{
    protected $table         = 'sk_youth';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'date_of_birth',
        'place_of_birth',
        'gender',
        'religion',
        'citizenship',
        'contact_number',
        'email',
        'address',
        'zone',
        'months_in_brgy',
        'skills',
        'hobbies',
        'mother_name',
        'mother_occupation',
        'father_name',
        'father_occupation',
        'organizations',
        'age_group',
        'civil_status',
        'educational_background',
        'school_type',
        'school_detail',
        'governance',
        'health_concerns',
        'social_inclusion',
        'economic_status',
        'monthly_income',
        'advocacy',
        'volunteer',
        'issue_1',
        'issue_2',
        'issue_3',
        'suggestions',
        'recorded_by',
    ];

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Compute age from date_of_birth.
     */
    public static function calcAge(?string $dob): ?int
    {
        if (empty($dob)) return null;
        try {
            return (int) date_diff(date_create($dob), date_create('today'))->y;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Derive economic status label from educational_background.
     */
    public static function statusLabel(string $edu): string
    {
        $edu = strtolower($edu);
        if (str_contains($edu, 'out-of-school')) return 'Out-of-School';
        if (str_contains($edu, 'college') || str_contains($edu, 'junior') || str_contains($edu, 'senior')) return 'Student';
        return 'Student';
    }

    /**
     * Get stats for the profiling dashboard.
     */
    public function getStats(): array
    {
        $total    = $this->countAll();
        $male     = (clone $this)->where('gender', 'Male')->countAllResults();
        $female   = (clone $this)->where('gender', 'Female')->countAllResults();
        $students = (clone $this)->like('economic_status', 'Student')->countAllResults();
        $oos      = (clone $this)->like('economic_status', 'Out-of-School')->countAllResults();

        return compact('total', 'male', 'female', 'students', 'oos');
    }
}
