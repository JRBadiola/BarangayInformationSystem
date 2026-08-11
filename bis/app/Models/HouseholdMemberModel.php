<?php

namespace App\Models;

use CodeIgniter\Model;

class HouseholdMemberModel extends Model
{
    protected $table         = 'household_members';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'household_no',
        'relationship',
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'date_of_birth',
        'gender',
        'occupation',
        'grade_level',
        'monthly_income',
        'philhealth_no',
        'educational_attainment',
    ];

    protected $validationRules = [
        'household_no' => 'required|max_length[5]',
        'relationship' => 'required|max_length[50]',
        'last_name'    => 'required|max_length[80]',
        'first_name'   => 'required|max_length[80]',
    ];

    public function getByHousehold(string $householdNo): array
    {
        return $this->where('household_no', $householdNo)
            ->orderBy('relationship', 'ASC')
            ->findAll();
    }

    public function replaceMembers(string $householdNo, array $members): bool
    {
        $this->where('household_no', $householdNo)->delete();

        if (empty($members)) return true;

        foreach ($members as &$m) {
            $m['household_no'] = $householdNo;
        }

        return $this->insertBatch($members) !== false;
    }
}
