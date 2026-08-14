<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HouseholdModel;
use App\Models\HouseholdMemberModel;

class CensusController extends BaseController
{
    protected HouseholdModel       $householdModel;
    protected HouseholdMemberModel $memberModel;

    public function __construct()
    {
        $this->householdModel = new HouseholdModel();
        $this->memberModel    = new HouseholdMemberModel();
    }

    // ── Show create household form as a full page (instead of modal)
    public function create()
    {
        $role = session()->get('role');
        return view('dashboard/secretary/household_form', ['role' => $role]);
    }

    // ── Save new household from the census form ───────────────────────────────

    public function store()
    {
        $post = $this->request->getPost();

        // ── Solo Parent validation: must have at least one child ──────────────
        if (isset($post['is_solo_parent'])) {
            $childNames = array_filter(
                array_map('trim', (array) ($post['child_last_name'] ?? [])),
                fn($v) => $v !== ''
            );
            if (empty($childNames)) {
                return redirect()->back()
                    ->with('error', 'A Solo Parent record requires at least one child. Please add the child\'s information in the Family Information section.')
                    ->withInput();
            }
        }

        // ── Step 1: Save household head ───────────────────────────────────
        // Use the JS-generated household_no, but regenerate server-side if missing or already taken
        $householdNo = $post['household_no'] ?? null;

        // Ensure uniqueness — regenerate if the number already exists
        if (empty($householdNo) || $this->householdModel->where('household_no', $householdNo)->countAllResults() > 0) {
            do {
                $householdNo = str_pad(random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
            } while ($this->householdModel->where('household_no', $householdNo)->countAllResults() > 0);
        }

        $householdData = [
            'household_no'           => $householdNo,
            'zone'                   => $post['zone']                   ?? null,
            'last_name'              => $post['last_name']              ?? '',
            'first_name'             => $post['first_name']             ?? '',
            'middle_name'            => $post['middle_name']            ?? null,
            'suffix'                 => $post['suffix']                 ?? null,
            'date_of_birth'          => $post['date_of_birth']          ?? null,
            'place_of_birth'         => $post['place_of_birth']         ?? null,
            'gender'                 => $post['gender']                 ?? 'Male',
            'civil_status'           => $post['civil_status']           ?? 'Single',
            'nationality'            => $post['nationality']            ?? 'Filipino',
            'religion'               => $post['religion']               ?? null,
            'occupation'             => $post['occupation']             ?? null,
            'monthly_income'         => $post['monthly_income']         ?? 0,
            'contact_number'         => $post['contact_number']         ?? null,
            'educational_attainment' => $post['educational_attainment'] ?? null,
            'philhealth_no'          => $post['philhealth_no']          ?? null,
            'address'                => $post['address']                ?? null,
            'years_of_residency'     => $post['years_of_residency']     ?? 0,
            'house_ownership'        => $post['house_ownership']        ?? 'Owned',
            'is_4ps'                 => isset($post['is_4ps'])          ? 1 : 0,
            'is_pwd'                 => isset($post['is_pwd'])          ? 1 : 0,
            'is_senior_citizen'      => isset($post['is_senior_citizen']) ? 1 : 0,
            'is_solo_parent'         => isset($post['is_solo_parent'])  ? 1 : 0,
            'is_indigenous'          => isset($post['is_indigenous'])   ? 1 : 0,
            'registered_voter'       => ($post['registered_voter'] ?? '0') === '1' ? 1 : 0,
            'num_families'           => max(1, (int) ($post['num_families'] ?? 1)),
            'water_source_level'     => $post['water_source']           ?? null,
            'water_safety_managed'   => isset($post['water_managed'])   ? ($post['water_managed'] === 'yes' ? 1 : 0) : null,
            'sanitation_basic'       => $post['sanitation_basic']       ?? null,
            'sanitation_managed'     => $post['sanitation_managed']     ?? null,
            'recorded_by'            => session()->get('user_id'),
            'recorded_date'          => $post['recorded_date']          ?? date('Y-m-d'),
        ];

        // Use insert() directly — save() can behave unexpectedly with string PKs
        try {
            $inserted = $this->householdModel->insert($householdData, false);
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'uq_households_philhealth') || str_contains($msg, 'philhealth_no')) {
                return redirect()->back()->with('error', 'That PhilHealth number is already registered to another household head.')->withInput();
            }
            if (str_contains($msg, 'uq_households_contact') || str_contains($msg, 'contact_number')) {
                return redirect()->back()->with('error', 'That contact number is already registered to another household head.')->withInput();
            }
            if (str_contains($msg, 'uq_households_person')) {
                return redirect()->back()->with('error', 'A household head with the same name and date of birth already exists in the census.')->withInput();
            }
            throw $e;
        }

        if ($inserted === false) {
            $errors = implode(' ', $this->householdModel->errors());
            return redirect()->back()->with('error', 'Failed to save household: ' . $errors)->withInput();
        }

        // Verify the household actually exists before inserting members
        $exists = $this->householdModel->find($householdNo);
        if (! $exists) {
            return redirect()->back()->with('error', 'Household was not saved correctly. Please try again.')->withInput();
        }

        // household_no is the PK — use it directly
        $householdKey = $householdNo;

        // ── Step 2: Save members (spouse, children, others) ───────────────
        $members = [];

        // Spouse
        if (! empty($post['spouse_last_name'])) {
            $members[] = [
                'relationship'           => 'spouse',
                'last_name'              => $post['spouse_last_name'],
                'first_name'             => $post['spouse_first_name']             ?? '',
                'middle_name'            => $post['spouse_middle_name']            ?? null,
                'suffix'                 => $post['spouse_suffix']                 ?? null,
                'date_of_birth'          => $post['spouse_dob']                    ?? null,
                'gender'                 => $post['spouse_gender']                 ?? null,
                'occupation'             => $post['spouse_occupation']             ?? null,
                'monthly_income'         => $post['spouse_income']                 ?? 0,
                'philhealth_no'          => $post['spouse_philhealth']             ?? null,
                'educational_attainment' => $post['spouse_educational_attainment'] ?? null,
            ];
        }

        // Children — posted as arrays: child_last_name[], child_first_name[], etc.
        if (! empty($post['child_last_name'])) {
            foreach ($post['child_last_name'] as $i => $lastName) {
                if (empty($lastName)) continue;
                $members[] = [
                    'relationship'           => 'child',
                    'last_name'              => $lastName,
                    'first_name'             => $post['child_first_name'][$i]  ?? '',
                    'middle_name'            => $post['child_middle_name'][$i] ?? null,
                    'suffix'                 => $post['child_suffix'][$i]      ?? null,
                    'date_of_birth'          => $post['child_dob'][$i]         ?? null,
                    'gender'                 => $post['child_gender'][$i]      ?? null,
                    'occupation'             => $post['child_occupation'][$i]  ?? null,
                    'monthly_income'         => $post['child_income'][$i]      ?? 0,
                    'philhealth_no'          => $post['child_philhealth'][$i]  ?? null,
                    'educational_attainment' => null,
                    'grade_level'            => $post['child_grade'][$i]       ?? null,
                ];
            }
        }

        // Other household members
        if (! empty($post['other_last_name'])) {
            foreach ($post['other_last_name'] as $i => $lastName) {
                if (empty($lastName)) continue;
                $members[] = [
                    'relationship'           => $post['other_relationship'][$i] ?? 'other_relative',
                    'last_name'              => $lastName,
                    'first_name'             => $post['other_first_name'][$i]  ?? '',
                    'middle_name'            => $post['other_middle_name'][$i] ?? null,
                    'suffix'                 => $post['other_suffix'][$i]      ?? null,
                    'date_of_birth'          => $post['other_dob'][$i]         ?? null,
                    'gender'                 => $post['other_gender'][$i]      ?? null,
                    'occupation'             => null,
                    'monthly_income'         => 0,
                    'philhealth_no'          => null,
                    'educational_attainment' => null,
                ];
            }
        }

        if (! empty($members)) {
            $this->memberModel->replaceMembers($householdKey, $members);
        }

        $role = session()->get('role');
        return redirect()->to('/' . $role . '/census')->with('success', 'Household record saved successfully.');
    }

    // ── Update existing household head ────────────────────────────────────────

    public function updateHousehold(string $householdNo)
    {
        $post = $this->request->getPost();
        $role = session()->get('role');

        $data = [
            'zone'                   => $post['zone']                   ?? null,
            'last_name'              => strtoupper($post['last_name']   ?? ''),
            'first_name'             => strtoupper($post['first_name']  ?? ''),
            'middle_name'            => strtoupper($post['middle_name'] ?? ''),
            'suffix'                 => $post['suffix']                 ?? null,
            'date_of_birth'          => $post['date_of_birth']          ?? null,
            'place_of_birth'         => strtoupper($post['place_of_birth'] ?? ''),
            'gender'                 => $post['gender']                 ?? 'Male',
            'civil_status'           => $post['civil_status']           ?? 'Single',
            'nationality'            => strtoupper($post['nationality'] ?? 'FILIPINO'),
            'religion'               => strtoupper($post['religion']    ?? ''),
            'occupation'             => strtoupper($post['occupation']  ?? ''),
            'monthly_income'         => $post['monthly_income']         ?? 0,
            'contact_number'         => $post['contact_number']         ?? null,
            'educational_attainment' => $post['educational_attainment'] ?? null,
            'philhealth_no'          => $post['philhealth_no']          ?? null,
            'address'                => strtoupper($post['address']     ?? ''),
            'years_of_residency'     => $post['years_of_residency']     ?? 0,
            'house_ownership'        => $post['house_ownership']        ?? 'Owned',
            'is_4ps'                 => isset($post['is_4ps'])          ? 1 : 0,
            'is_pwd'                 => isset($post['is_pwd'])          ? 1 : 0,
            'is_senior_citizen'      => isset($post['is_senior_citizen']) ? 1 : 0,
            'is_solo_parent'         => isset($post['is_solo_parent'])  ? 1 : 0,
            'is_indigenous'          => isset($post['is_indigenous'])   ? 1 : 0,
            'registered_voter'       => ($post['registered_voter'] ?? '0') === '1' ? 1 : 0,
            'num_families'           => max(1, (int) ($post['num_families'] ?? 1)),
            'water_source_level'     => $post['water_source']           ?? null,
            'water_safety_managed'   => isset($post['water_managed'])   ? ($post['water_managed'] === 'yes' ? 1 : 0) : null,
            'sanitation_basic'       => $post['sanitation_basic']       ?? null,
            'sanitation_managed'     => $post['sanitation_managed']     ?? null,
        ];

        $this->householdModel->update($householdNo, $data);

        return redirect()->to('/' . $role . '/household/' . $householdNo)
            ->with('success', 'Household record updated successfully.');
    }

    // ── Add a single member ───────────────────────────────────────────────────

    public function addMember(string $householdNo)
    {
        $post = $this->request->getPost();
        $role = session()->get('role');

        try {
            $this->memberModel->insert([
                'household_no'           => $householdNo,
                'relationship'           => $post['relationship']           ?? 'other_relative',
                'last_name'              => strtoupper($post['last_name']   ?? ''),
                'first_name'             => strtoupper($post['first_name']  ?? ''),
                'middle_name'            => strtoupper($post['middle_name'] ?? ''),
                'suffix'                 => $post['suffix']                 ?? null,
                'date_of_birth'          => $post['date_of_birth']          ?? null,
                'gender'                 => $post['gender']                 ?? null,
                'occupation'             => strtoupper($post['occupation']  ?? ''),
                'monthly_income'         => $post['monthly_income']         ?? 0,
                'philhealth_no'          => $post['philhealth_no']          ?? null,
                'educational_attainment' => $post['educational_attainment'] ?? null,
                'grade_level'            => $post['grade_level']            ?? null,
            ]);
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'uq_members_philhealth') || str_contains($msg, 'philhealth_no')) {
                return redirect()->back()->with('error', 'That PhilHealth number is already registered to another member.')->withInput();
            }
            if (str_contains($msg, 'uq_members_person')) {
                return redirect()->back()->with('error', 'A member with the same name and date of birth already exists in this household.')->withInput();
            }
            throw $e;
        }

        return redirect()->to('/' . $role . '/household/' . $householdNo)
            ->with('success', 'Member added successfully.');
    }

    // ── Add spouse + children + others for existing household (family form) ──

    public function addFamilyMembers(string $householdNo)
    {
        $post = $this->request->getPost();
        $role = session()->get('role');

        $members = [];

        // Spouse
        if (! empty(trim($post['spouse_last_name'] ?? ''))) {
            $members[] = [
                'relationship'           => 'spouse',
                'last_name'              => strtoupper(trim($post['spouse_last_name'])),
                'first_name'             => strtoupper(trim($post['spouse_first_name']             ?? '')),
                'middle_name'            => strtoupper(trim($post['spouse_middle_name']            ?? '')) ?: null,
                'suffix'                 => $post['spouse_suffix']                 ?? null,
                'date_of_birth'          => $post['spouse_dob']                    ?? null,
                'gender'                 => $post['spouse_gender']                 ?? null,
                'occupation'             => strtoupper(trim($post['spouse_occupation']             ?? '')),
                'monthly_income'         => $post['spouse_income']                 ?? 0,
                'philhealth_no'          => $post['spouse_philhealth']             ?? null,
                'educational_attainment' => $post['spouse_educational_attainment'] ?? null,
                'grade_level'            => null,
            ];
        }

        // Children
        if (! empty($post['child_last_name'])) {
            foreach ($post['child_last_name'] as $i => $lastName) {
                if (empty(trim($lastName))) continue;
                $members[] = [
                    'relationship'           => 'child',
                    'last_name'              => strtoupper(trim($lastName)),
                    'first_name'             => strtoupper(trim($post['child_first_name'][$i]  ?? '')),
                    'middle_name'            => strtoupper(trim($post['child_middle_name'][$i] ?? '')) ?: null,
                    'suffix'                 => $post['child_suffix'][$i]      ?? null,
                    'date_of_birth'          => $post['child_dob'][$i]         ?? null,
                    'gender'                 => $post['child_gender'][$i]      ?? null,
                    'occupation'             => strtoupper(trim($post['child_occupation'][$i]  ?? '')),
                    'monthly_income'         => $post['child_income'][$i]      ?? 0,
                    'philhealth_no'          => $post['child_philhealth'][$i]  ?? null,
                    'educational_attainment' => null,
                    'grade_level'            => $post['child_grade'][$i]       ?? null,
                ];
            }
        }

        // Other members
        if (! empty($post['other_last_name'])) {
            foreach ($post['other_last_name'] as $i => $lastName) {
                if (empty(trim($lastName))) continue;
                $members[] = [
                    'relationship'           => strtolower($post['other_relationship'][$i] ?? 'other_relative'),
                    'last_name'              => strtoupper(trim($lastName)),
                    'first_name'             => strtoupper(trim($post['other_first_name'][$i]  ?? '')),
                    'middle_name'            => strtoupper(trim($post['other_middle_name'][$i] ?? '')) ?: null,
                    'suffix'                 => $post['other_suffix'][$i]      ?? null,
                    'date_of_birth'          => $post['other_dob'][$i]         ?? null,
                    'gender'                 => $post['other_gender'][$i]      ?? null,
                    'occupation'             => null,
                    'monthly_income'         => 0,
                    'philhealth_no'          => null,
                    'educational_attainment' => null,
                    'grade_level'            => null,
                ];
            }
        }

        if (empty($members)) {
            return redirect()->to('/' . $role . '/household/' . $householdNo)
                ->with('error', 'No members were provided. Please fill in at least one name.');
        }

        $added = 0;
        foreach ($members as $m) {
            $m['household_no'] = $householdNo;
            try {
                $this->memberModel->insert($m);
                $added++;
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                // Skip duplicates silently — existing members won't be overwritten
                log_message('warning', 'addFamilyMembers skip duplicate: ' . $e->getMessage());
            }
        }

        return redirect()->to('/' . $role . '/household/' . $householdNo)
            ->with('success', $added . ' member' . ($added !== 1 ? 's' : '') . ' added successfully.');
    }

    // ── Update a single member ────────────────────────────────────────────────

    public function updateMember(int $memberId)
    {
        $post        = $this->request->getPost();
        $role        = session()->get('role');
        $householdNo = $post['household_no'] ?? '';

        $this->memberModel->update($memberId, [
            'relationship'           => $post['relationship']           ?? 'other_relative',
            'last_name'              => strtoupper($post['last_name']   ?? ''),
            'first_name'             => strtoupper($post['first_name']  ?? ''),
            'middle_name'            => strtoupper($post['middle_name'] ?? ''),
            'suffix'                 => $post['suffix']                 ?? null,
            'date_of_birth'          => $post['date_of_birth']          ?? null,
            'gender'                 => $post['gender']                 ?? null,
            'occupation'             => strtoupper($post['occupation']  ?? ''),
            'monthly_income'         => $post['monthly_income']         ?? 0,
            'philhealth_no'          => $post['philhealth_no']          ?? null,
            'educational_attainment' => $post['educational_attainment'] ?? null,
            'grade_level'            => $post['grade_level']            ?? null,
        ]);

        return redirect()->to('/' . $role . '/household/' . $householdNo)
            ->with('success', 'Member updated successfully.');
    }

    // ── Delete a single member ────────────────────────────────────────────────

    public function deleteMember(int $memberId)
    {
        $role        = session()->get('role');
        $householdNo = $this->request->getPost('household_no') ?? '';

        $this->memberModel->delete($memberId);

        return redirect()->to('/' . $role . '/household/' . $householdNo)
            ->with('success', 'Member removed.');
    }

    // ── Delete household ──────────────────────────────────────────────────────

    public function delete(string $id)
    {
        $this->householdModel->delete($id);
        $role = session()->get('role');
        return redirect()->to('/' . $role . '/census')->with('success', 'Household record deleted.');
    }
}
