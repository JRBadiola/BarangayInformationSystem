<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SkYouthModel;

class SkController extends BaseController
{
    protected SkYouthModel $model;

    public function __construct()
    {
        $this->model = new SkYouthModel();
    }

    // ── Profiling list — pulls from households + household_members ───────────

    public function profiling()
    {
        $db        = \Config\Database::connect();
        $search    = trim($_GET['search']      ?? '');
        $ageFilter = trim($_GET['age']         ?? '');
        $gender    = trim($_GET['gender']      ?? '');
        $status    = trim($_GET['status']      ?? '');
        $zone      = trim($_GET['zone']        ?? '');
        $civil     = trim($_GET['civil']       ?? '');

        // Age range boundaries for youth (15–30)
        $youthMax = date('Y-m-d', strtotime('-15 years'));
        $youthMin = date('Y-m-d', strtotime('-30 years'));

        // ── Build WHERE clauses ───────────────────────────────────────────────
        $hw = ["h.date_of_birth IS NOT NULL", "h.date_of_birth <= '{$youthMax}'", "h.date_of_birth >= '{$youthMin}'"];
        $mw = ["m.date_of_birth IS NOT NULL", "m.date_of_birth <= '{$youthMax}'", "m.date_of_birth >= '{$youthMin}'"];

        if ($search !== '') {
            $s    = $db->escapeLikeString($search);
            $hw[] = "(h.last_name LIKE '%{$s}%' OR h.first_name LIKE '%{$s}%' OR h.contact_number LIKE '%{$s}%')";
            $mw[] = "(m.last_name LIKE '%{$s}%' OR m.first_name LIKE '%{$s}%')";
        }
        if ($gender !== '') {
            $g    = $db->escapeString($gender);
            $hw[] = "h.gender = '{$g}'";
            $mw[] = "m.gender = '{$g}'";
        }
        if ($zone !== '') {
            $z    = $db->escapeString($zone);
            $hw[] = "h.zone = '{$z}'";
            $mw[] = "h2.zone = '{$z}'";
        }
        if ($civil !== '') {
            $c    = $db->escapeString($civil);
            $hw[] = "h.civil_status = '{$c}'";
            $mw[] = "1=0"; // members have no civil_status
        }
        if ($ageFilter !== '') {
            [$amin, $amax] = explode('-', $ageFilter);
            $dMax = date('Y-m-d', strtotime('-' . (int)$amin . ' years'));
            $dMin = date('Y-m-d', strtotime('-' . (int)$amax . ' years'));
            $hw[] = "h.date_of_birth <= '{$dMax}' AND h.date_of_birth >= '{$dMin}'";
            $mw[] = "m.date_of_birth <= '{$dMax}' AND m.date_of_birth >= '{$dMin}'";
        }
        // Status filter — apply in SQL via occupation keyword
        if ($status !== '') {
            $statusSqlMap = [
                'Student'       => "UPPER(h.occupation) LIKE '%STUDENT%'",
                'Employed'      => "UPPER(h.occupation) NOT LIKE '%STUDENT%' AND UPPER(h.occupation) NOT LIKE '%UNEMPLOY%' AND h.occupation IS NOT NULL AND h.occupation != '' AND UPPER(h.occupation) != 'NONE'",
                'Unemployed'    => "UPPER(h.occupation) LIKE '%UNEMPLOY%'",
                'Out-of-School' => "(UPPER(h.occupation) LIKE '%OUT-OF-SCHOOL%' OR UPPER(h.occupation) LIKE '%OSY%')",
            ];
            $statusMemberMap = [
                'Student'       => "UPPER(m.occupation) LIKE '%STUDENT%'",
                'Employed'      => "UPPER(m.occupation) NOT LIKE '%STUDENT%' AND UPPER(m.occupation) NOT LIKE '%UNEMPLOY%' AND m.occupation IS NOT NULL AND m.occupation != '' AND UPPER(m.occupation) != 'NONE'",
                'Unemployed'    => "UPPER(m.occupation) LIKE '%UNEMPLOY%'",
                'Out-of-School' => "(UPPER(m.occupation) LIKE '%OUT-OF-SCHOOL%' OR UPPER(m.occupation) LIKE '%OSY%')",
            ];
            if (isset($statusSqlMap[$status])) {
                $hw[] = $statusSqlMap[$status];
                $mw[] = $statusMemberMap[$status];
            }
        }

        $hwSql = ' WHERE ' . implode(' AND ', $hw);
        $mwSql = ' WHERE ' . implode(' AND ', $mw);

        // ── UNION: heads + members ────────────────────────────────────────────
        $headSql = "SELECT
                'head'         AS source,
                h.household_no AS id,
                h.last_name, h.first_name, h.middle_name,
                h.date_of_birth, h.gender, h.civil_status,
                h.occupation, h.contact_number, h.zone, h.household_no
            FROM households h{$hwSql}";

        $memberSql = "SELECT
                'member'       AS source,
                m.id           AS id,
                m.last_name, m.first_name, m.middle_name,
                m.date_of_birth, m.gender,
                ''             AS civil_status,
                m.occupation,
                ''             AS contact_number,
                h2.zone, m.household_no
            FROM household_members m
            INNER JOIN households h2 ON h2.household_no = m.household_no{$mwSql}";

        $union = "({$headSql}) UNION ALL ({$memberSql}) ORDER BY last_name ASC, first_name ASC";

        $perPage = 15;
        $page    = max(1, (int) ($_GET['page'] ?? 1));
        $offset  = ($page - 1) * $perPage;

        $total = (int) $db->query("SELECT COUNT(*) AS c FROM ({$union}) AS t")->getRow()->c;
        $rows  = $db->query("{$union} LIMIT {$perPage} OFFSET {$offset}")->getResultArray();

        foreach ($rows as &$y) {
            $y['age'] = \App\Models\SkYouthModel::calcAge($y['date_of_birth']);
            $occ      = strtolower($y['occupation'] ?? '');
            if (str_contains($occ, 'student'))                                         $y['economic_status'] = 'Student';
            elseif (str_contains($occ, 'unemploy'))                                    $y['economic_status'] = 'Unemployed';
            elseif (str_contains($occ, 'out-of-school') || str_contains($occ, 'osy')) $y['economic_status'] = 'Out-of-School';
            elseif (! empty($occ) && $occ !== 'none' && $occ !== 'n/a')               $y['economic_status'] = 'Employed';
            else                                                                        $y['economic_status'] = '—';
        }
        unset($y);

        // ── Stats (always full unfiltered youth population) ───────────────────
        $baseHw = ["h.date_of_birth IS NOT NULL", "h.date_of_birth <= '{$youthMax}'", "h.date_of_birth >= '{$youthMin}'"];
        $baseMw = ["m.date_of_birth IS NOT NULL", "m.date_of_birth <= '{$youthMax}'", "m.date_of_birth >= '{$youthMin}'"];
        $baseHeadSql   = "SELECT h.date_of_birth, h.gender, h.occupation FROM households h WHERE " . implode(' AND ', $baseHw);
        $baseMemberSql = "SELECT m.date_of_birth, m.gender, m.occupation FROM household_members m INNER JOIN households h2 ON h2.household_no = m.household_no WHERE " . implode(' AND ', $baseMw);
        $allYouth      = $db->query("({$baseHeadSql}) UNION ALL ({$baseMemberSql})")->getResultArray();

        $statsTotal    = count($allYouth);
        $statsMale     = count(array_filter($allYouth, fn($r) => strtolower($r['gender'] ?? '') === 'male'));
        $statsFemale   = count(array_filter($allYouth, fn($r) => strtolower($r['gender'] ?? '') === 'female'));
        $statsStudents = count(array_filter($allYouth, fn($r) => stripos($r['occupation'] ?? '', 'student') !== false));
        $statsOos      = count(array_filter(
            $allYouth,
            fn($r) =>
            stripos($r['occupation'] ?? '', 'out-of-school') !== false ||
                stripos($r['occupation'] ?? '', 'osy') !== false
        ));

        return view('dashboard/sk/profiling', [
            'youth'       => $rows,
            'stats'       => ['total' => $statsTotal, 'male' => $statsMale, 'female' => $statsFemale, 'students' => $statsStudents, 'oos' => $statsOos],
            'total'       => $total,
            'perPage'     => $perPage,
            'currentPage' => $page,
            'search'      => $search,
            'ageFilter'   => $ageFilter,
            'gender'      => $gender,
            'status'      => $status,
            'zone'        => $zone,
            'civil'       => $civil,
        ]);
    }

    // ── View single youth ─────────────────────────────────────────────────────

    public function view(int $id)
    {
        $youth = $this->model->find($id);
        if (! $youth) {
            return redirect()->to('/sk/profiling')->with('error', 'Record not found.');
        }
        $youth['age'] = SkYouthModel::calcAge($youth['date_of_birth']);
        return view('dashboard/sk/view_youth', ['youth' => $youth]);
    }

    // ── Show add form ─────────────────────────────────────────────────────────

    public function addForm()
    {
        return view('dashboard/sk/add_youth');
    }

    // ── Store new youth ───────────────────────────────────────────────────────

    public function store()
    {
        $post = $this->request->getPost();

        // Derive age group from DOB
        $age      = SkYouthModel::calcAge($post['date_of_birth'] ?? null);
        $ageGroup = '';
        if ($age !== null) {
            if ($age >= 15 && $age <= 17)      $ageGroup = '15-17';
            elseif ($age >= 18 && $age <= 21)  $ageGroup = '18-21';
            elseif ($age >= 22 && $age <= 24)  $ageGroup = '22-24';
            elseif ($age >= 25 && $age <= 30)  $ageGroup = '25-30';
        }

        // Derive economic status
        $edu    = $post['educational_background'] ?? '';
        $status = $post['economic_status'] ?? SkYouthModel::statusLabel($edu);

        // Encode JSON fields
        $orgs    = [];
        if (! empty($post['org_name'])) {
            foreach ($post['org_name'] as $i => $name) {
                if (empty($name)) continue;
                $orgs[] = [
                    'name'     => $name,
                    'position' => $post['org_position'][$i] ?? '',
                    'year'     => $post['org_year'][$i]     ?? '',
                ];
            }
        }

        $this->model->insert([
            'last_name'              => strtoupper(trim($post['last_name']   ?? '')),
            'first_name'             => strtoupper(trim($post['first_name']  ?? '')),
            'middle_name'            => strtoupper(trim($post['middle_name'] ?? '')) ?: null,
            'suffix'                 => $post['suffix']          ?? null,
            'date_of_birth'          => $post['date_of_birth']   ?? null,
            'place_of_birth'         => $post['place_of_birth']  ?? null,
            'gender'                 => $post['gender']          ?? null,
            'religion'               => $post['religion']        ?? null,
            'citizenship'            => $post['citizenship']     ?? 'Filipino',
            'contact_number'         => $post['contact_number']  ?? null,
            'email'                  => $post['email']           ?? null,
            'address'                => $post['address']         ?? null,
            'zone'                   => $post['zone']            ?? null,
            'months_in_brgy'         => $post['months_in_brgy']  ?? null,
            'skills'                 => $post['skills']          ?? null,
            'hobbies'                => $post['hobbies']         ?? null,
            'mother_name'            => $post['mother_name']     ?? null,
            'mother_occupation'      => $post['mother_occupation'] ?? null,
            'father_name'            => $post['father_name']     ?? null,
            'father_occupation'      => $post['father_occupation'] ?? null,
            'organizations'          => ! empty($orgs) ? json_encode($orgs) : null,
            'age_group'              => $ageGroup ?: null,
            'civil_status'           => $post['civil_status']    ?? null,
            'educational_background' => $edu                     ?: null,
            'school_type'            => $post['school_type']     ?? null,
            'school_detail'          => $post['school_detail']   ?? null,
            'governance'             => $post['governance']       ?? null,
            'health_concerns'        => ! empty($post['health'])  ? json_encode((array)$post['health'])  : null,
            'social_inclusion'       => ! empty($post['social'])  ? json_encode((array)$post['social'])  : null,
            'economic_status'        => $status,
            'monthly_income'         => $post['monthly_income']  ?? null,
            'advocacy'               => $post['advocacy']        ?? null,
            'volunteer'              => $post['volunteer']       ?? null,
            'issue_1'                => $post['issue_1']         ?? null,
            'issue_2'                => $post['issue_2']         ?? null,
            'issue_3'                => $post['issue_3']         ?? null,
            'suggestions'            => $post['suggestions']     ?? null,
            'recorded_by'            => session()->get('user_id'),
        ]);

        return redirect()->to('/sk/profiling')->with('success', 'Youth profile added successfully.');
    }

    // ── Show edit form ────────────────────────────────────────────────────────

    public function editForm(int $id)
    {
        $youth = $this->model->find($id);
        if (! $youth) {
            return redirect()->to('/sk/profiling')->with('error', 'Record not found.');
        }
        $youth['age'] = SkYouthModel::calcAge($youth['date_of_birth']);
        return view('dashboard/sk/add_youth', ['youth' => $youth, 'editMode' => true]);
    }

    // ── Update youth ──────────────────────────────────────────────────────────

    public function update(int $id)
    {
        $post = $this->request->getPost();

        $age      = SkYouthModel::calcAge($post['date_of_birth'] ?? null);
        $ageGroup = '';
        if ($age !== null) {
            if ($age >= 15 && $age <= 17)      $ageGroup = '15-17';
            elseif ($age >= 18 && $age <= 21)  $ageGroup = '18-21';
            elseif ($age >= 22 && $age <= 24)  $ageGroup = '22-24';
            elseif ($age >= 25 && $age <= 30)  $ageGroup = '25-30';
        }

        $edu    = $post['educational_background'] ?? '';
        $status = $post['economic_status'] ?? SkYouthModel::statusLabel($edu);

        $orgs = [];
        if (! empty($post['org_name'])) {
            foreach ($post['org_name'] as $i => $name) {
                if (empty($name)) continue;
                $orgs[] = [
                    'name'     => $name,
                    'position' => $post['org_position'][$i] ?? '',
                    'year'     => $post['org_year'][$i]     ?? '',
                ];
            }
        }

        $this->model->update($id, [
            'last_name'              => strtoupper(trim($post['last_name']   ?? '')),
            'first_name'             => strtoupper(trim($post['first_name']  ?? '')),
            'middle_name'            => strtoupper(trim($post['middle_name'] ?? '')) ?: null,
            'suffix'                 => $post['suffix']          ?? null,
            'date_of_birth'          => $post['date_of_birth']   ?? null,
            'place_of_birth'         => $post['place_of_birth']  ?? null,
            'gender'                 => $post['gender']          ?? null,
            'religion'               => $post['religion']        ?? null,
            'citizenship'            => $post['citizenship']     ?? 'Filipino',
            'contact_number'         => $post['contact_number']  ?? null,
            'email'                  => $post['email']           ?? null,
            'address'                => $post['address']         ?? null,
            'zone'                   => $post['zone']            ?? null,
            'months_in_brgy'         => $post['months_in_brgy']  ?? null,
            'skills'                 => $post['skills']          ?? null,
            'hobbies'                => $post['hobbies']         ?? null,
            'mother_name'            => $post['mother_name']     ?? null,
            'mother_occupation'      => $post['mother_occupation'] ?? null,
            'father_name'            => $post['father_name']     ?? null,
            'father_occupation'      => $post['father_occupation'] ?? null,
            'organizations'          => ! empty($orgs) ? json_encode($orgs) : null,
            'age_group'              => $ageGroup ?: null,
            'civil_status'           => $post['civil_status']    ?? null,
            'educational_background' => $edu                     ?: null,
            'school_type'            => $post['school_type']     ?? null,
            'school_detail'          => $post['school_detail']   ?? null,
            'governance'             => $post['governance']       ?? null,
            'health_concerns'        => ! empty($post['health'])  ? json_encode((array)$post['health'])  : null,
            'social_inclusion'       => ! empty($post['social'])  ? json_encode((array)$post['social'])  : null,
            'economic_status'        => $status,
            'monthly_income'         => $post['monthly_income']  ?? null,
            'advocacy'               => $post['advocacy']        ?? null,
            'volunteer'              => $post['volunteer']       ?? null,
            'issue_1'                => $post['issue_1']         ?? null,
            'issue_2'                => $post['issue_2']         ?? null,
            'issue_3'                => $post['issue_3']         ?? null,
            'suggestions'            => $post['suggestions']     ?? null,
        ]);

        return redirect()->to('/sk/profiling')->with('success', 'Youth profile updated successfully.');
    }

    // ── Delete youth ──────────────────────────────────────────────────────────

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/sk/profiling')->with('success', 'Youth profile deleted.');
    }

    // ── Programs & Events ─────────────────────────────────────────────────────

    public function programs()
    {
        $progModel = new \App\Models\SkProgramModel();

        $search   = trim($_GET['search']   ?? '');
        $catF     = trim($_GET['category'] ?? '');
        $statusF  = trim($_GET['status']   ?? '');

        $builder = $progModel->orderBy('start_date', 'DESC');
        if ($search !== '')  $builder->groupStart()->like('name', $search)->orLike('venue', $search)->groupEnd();
        if ($catF !== '')    $builder->where('category', $catF);
        if ($statusF !== '') $builder->where('status', $statusF);

        $programs = $builder->findAll();
        $counts   = $progModel->statusCounts();

        return view('dashboard/sk/programs', [
            'programs' => $programs,
            'counts'   => $counts,
            'search'   => $search,
            'catF'     => $catF,
            'statusF'  => $statusF,
        ]);
    }

    public function storeProgram()
    {
        $progModel = new \App\Models\SkProgramModel();
        $post      = $this->request->getPost();

        if (empty($post['name']) || empty($post['category'])) {
            return redirect()->to('/sk/programs')->with('error', 'Program name and category are required.')->withInput();
        }

        // Auto-derive status from dates
        $today     = date('Y-m-d');
        $startDate = $post['start_date'] ?? null;
        $endDate   = $post['end_date']   ?? null;
        $status    = $post['status']     ?? '';
        if (empty($status)) {
            if ($startDate && $startDate > $today)                         $status = 'Upcoming';
            elseif ($endDate && $endDate < $today)                         $status = 'Completed';
            elseif ($startDate && $startDate <= $today)                    $status = 'Active';
            else                                                            $status = 'Upcoming';
        }

        $progModel->insert([
            'name'                => trim($post['name']),
            'category'            => $post['category'],
            'description'         => trim($post['description'] ?? '') ?: null,
            'start_date'          => $startDate ?: null,
            'end_date'            => $endDate   ?: null,
            'venue'               => trim($post['venue'] ?? '') ?: null,
            'target_participants' => (int)($post['target_participants'] ?? 0),
            'actual_participants' => (int)($post['actual_participants'] ?? 0),
            'budget'              => (float)($post['budget'] ?? 0),
            'status'              => $status,
            'created_by'          => (int)session()->get('user_id'),
        ]);

        return redirect()->to('/sk/programs')->with('success', 'Program "' . esc(trim($post['name'])) . '" added successfully.');
    }

    public function updateProgram(int $id)
    {
        $progModel = new \App\Models\SkProgramModel();
        $prog      = $progModel->find($id);
        if (! $prog) return redirect()->to('/sk/programs')->with('error', 'Program not found.');

        $post = $this->request->getPost();
        if (empty($post['name'])) return redirect()->to('/sk/programs')->with('error', 'Program name is required.');

        $today     = date('Y-m-d');
        $startDate = $post['start_date'] ?? null;
        $endDate   = $post['end_date']   ?? null;
        $status    = $post['status'] ?? $prog['status'];

        $progModel->update($id, [
            'name'                => trim($post['name']),
            'category'            => $post['category'] ?? $prog['category'],
            'description'         => trim($post['description'] ?? '') ?: null,
            'start_date'          => $startDate ?: null,
            'end_date'            => $endDate   ?: null,
            'venue'               => trim($post['venue'] ?? '') ?: null,
            'target_participants' => (int)($post['target_participants'] ?? 0),
            'actual_participants' => (int)($post['actual_participants'] ?? 0),
            'budget'              => (float)($post['budget'] ?? 0),
            'status'              => $status,
        ]);

        return redirect()->to('/sk/programs')->with('success', 'Program updated successfully.');
    }

    public function deleteProgram(int $id)
    {
        $progModel = new \App\Models\SkProgramModel();
        $progModel->delete($id);
        return redirect()->to('/sk/programs')->with('success', 'Program deleted.');
    }
}
