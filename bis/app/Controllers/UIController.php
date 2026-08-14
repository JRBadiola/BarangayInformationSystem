<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UIController extends BaseController
{
    // ── Shared census view builder (captain + secretary) ──────────────────────
    private function _censusView(string $role): \CodeIgniter\HTTP\ResponseInterface|string
    {
        $db = \Config\Database::connect();

        // ── Active filters from GET ───────────────────────────────────────
        $filters = [
            'zone'        => trim($_GET['zone']        ?? ''),
            'gender'      => trim($_GET['gender']      ?? ''),
            'age_min'     => trim($_GET['age_min']     ?? ''),
            'age_max'     => trim($_GET['age_max']     ?? ''),
            'is_pwd'      => trim($_GET['is_pwd']      ?? ''),
            'is_senior'   => trim($_GET['is_senior']   ?? ''),
            'is_solo'     => trim($_GET['is_solo']     ?? ''),
            'is_4ps'      => trim($_GET['is_4ps']      ?? ''),
            'is_student'  => trim($_GET['is_student']  ?? ''),
            'is_indigent' => trim($_GET['is_indigent'] ?? ''),
            'search'      => trim($_GET['search']      ?? ''),
        ];

        // ── Determine filter mode ─────────────────────────────────────────
        // Any filter that can match members (gender, age, student) needs the
        // UNION view. Head-only flags (pwd, solo, 4ps, senior, indigent) stay
        // on the households table only.
        $needsUnion = (
            $filters['gender']     !== '' ||
            $filters['age_min']    !== '' ||
            $filters['age_max']    !== '' ||
            $filters['is_student'] !== ''
        );

        $hasAnyFilter = (
            $filters['zone']       !== '' ||
            $filters['gender']     !== '' ||
            $filters['age_min']    !== '' ||
            $filters['age_max']    !== '' ||
            $filters['is_pwd']     !== '' ||
            $filters['is_senior']  !== '' ||
            $filters['is_solo']    !== '' ||
            $filters['is_4ps']     !== '' ||
            $filters['is_student'] !== '' ||
            $filters['is_indigent'] !== '' ||
            $filters['search']     !== ''
        );

        // hasSpecialFilter drives the view to show the filter-results table
        $hasSpecialFilter = $hasAnyFilter;

        // ── Stats: respect zone filter, always count heads only ───────────
        $hm = new \App\Models\HouseholdModel();
        $statBase = clone $hm;
        if ($filters['zone'] !== '') {
            $statBase->where('zone', $filters['zone']);
        }

        $stats = [
            'totalHouseholds' => (clone $statBase)->countAllResults(),
            'totalMale'       => (clone $statBase)->where('gender', 'Male')->countAllResults(),
            'totalFemale'     => (clone $statBase)->where('gender', 'Female')->countAllResults(),
            'pwds'            => (clone $statBase)->where('is_pwd', 1)->countAllResults(),
            'fourPs'          => (clone $statBase)->where('is_4ps', 1)->countAllResults(),
            'seniors'         => (clone $statBase)->where('is_senior_citizen', 1)->countAllResults(),
            'soloParent'      => (clone $statBase)->where('is_solo_parent', 1)->countAllResults(),
        ];

        $perPage = 15;
        $page    = max(1, (int) ($_GET['page'] ?? 1));
        $offset  = ($page - 1) * $perPage;

        // ── Build WHERE clauses for households (heads) ────────────────────
        $hw = [];   // head WHERE conditions
        $mw = [];   // member WHERE conditions (only used in UNION mode)

        if ($filters['zone'] !== '') {
            $z    = $db->escapeString($filters['zone']);
            $hw[] = "h.zone = '{$z}'";
            $mw[] = "h2.zone = '{$z}'";
        }
        if ($filters['search'] !== '') {
            $s    = $db->escapeLikeString($filters['search']);
            $hw[] = "(h.last_name LIKE '%{$s}%' OR h.first_name LIKE '%{$s}%' OR h.household_no LIKE '%{$s}%')";
            $mw[] = "(m.last_name LIKE '%{$s}%' OR m.first_name LIKE '%{$s}%' OR m.household_no LIKE '%{$s}%')";
        }
        if ($filters['gender'] !== '') {
            $g    = $db->escapeString($filters['gender']);
            $hw[] = "h.gender = '{$g}'";
            $mw[] = "m.gender = '{$g}'";
        }
        if ($filters['is_pwd'] === '1') {
            $hw[] = "h.is_pwd = 1";
            $mw[] = "1=0";
        }
        if ($filters['is_senior'] === '1') {
            $hw[] = "h.is_senior_citizen = 1";
            $mw[] = "1=0";
        }
        if ($filters['is_solo'] === '1') {
            $hw[] = "h.is_solo_parent = 1";
            $mw[] = "1=0";
        }
        if ($filters['is_4ps'] === '1') {
            $hw[] = "h.is_4ps = 1";
            $mw[] = "1=0";
        }
        if ($filters['is_indigent'] === '1') {
            $hw[] = "h.monthly_income > 0 AND h.monthly_income <= 5000";
            $mw[] = "m.monthly_income > 0 AND m.monthly_income <= 5000";
        }
        if ($filters['age_min'] !== '') {
            // age >= age_min  →  born on or before (today - age_min years)
            $d    = date('Y-m-d', strtotime('-' . (int)$filters['age_min'] . ' years'));
            $hw[] = "h.date_of_birth IS NOT NULL AND h.date_of_birth <= '{$d}'";
            $mw[] = "m.date_of_birth IS NOT NULL AND m.date_of_birth <= '{$d}'";
        }
        if ($filters['age_max'] !== '') {
            // age <= age_max  →  born on or after (today - age_max years)
            $d    = date('Y-m-d', strtotime('-' . (int)$filters['age_max'] . ' years'));
            $hw[] = "h.date_of_birth IS NOT NULL AND h.date_of_birth >= '{$d}'";
            $mw[] = "m.date_of_birth IS NOT NULL AND m.date_of_birth >= '{$d}'";
        }
        if ($filters['is_student'] === '1') {
            $hw[] = "UPPER(h.occupation) LIKE '%STUDENT%'";
            $mw[] = "UPPER(m.occupation) LIKE '%STUDENT%'";
        }

        $hwSql = ! empty($hw) ? ' WHERE ' . implode(' AND ', $hw) : '';

        // ── No filter at all: show default heads-only table ───────────────
        if (! $hasAnyFilter) {
            $households = $db->query(
                "SELECT * FROM households h ORDER BY household_no ASC LIMIT {$perPage} OFFSET {$offset}"
            )->getResultArray();
            $totalHouseholdsFiltered = (int) $db->query("SELECT COUNT(*) AS c FROM households")->getRow()->c;

            $viewFile = ($role === 'captain') ? 'dashboard/captain/census' : 'dashboard/secretary/census';
            return view($viewFile, array_merge($stats, [
                'households'             => $households,
                'persons'                => [],
                'hasSpecialFilter'       => false,
                'filteredTotal'          => $totalHouseholdsFiltered,
                'totalHouseholdsFiltered' => $totalHouseholdsFiltered,
                'perPage'                => $perPage,
                'currentPage'            => $page,
                'filters'                => $filters,
            ]));
        }

        // ── Filters active ────────────────────────────────────────────────
        if (! $needsUnion) {
            // ── HEAD-ONLY filter (no age/student) ─────────────────────────
            // All active filters apply only to the households table.
            $sql      = "SELECT * FROM households h{$hwSql} ORDER BY household_no ASC";
            $countSql = "SELECT COUNT(*) AS c FROM households h{$hwSql}";

            $filteredTotal = (int) $db->query($countSql)->getRow()->c;
            $persons       = $db->query("{$sql} LIMIT {$perPage} OFFSET {$offset}")->getResultArray();

            // Add a synthetic 'relationship' column so the view template works
            foreach ($persons as &$p) {
                $p['relationship'] = 'Household Head';
            }
            unset($p);
        } else {
            // ── UNION filter (age or student — includes members) ──────────
            $mwSql = ! empty($mw) ? ' WHERE ' . implode(' AND ', $mw) : '';

            $headSql = "SELECT h.household_no, h.last_name, h.first_name, h.middle_name,
                h.suffix, h.date_of_birth, h.gender, h.civil_status, h.occupation,
                h.monthly_income, h.philhealth_no, h.educational_attainment,
                h.contact_number, h.zone, h.is_pwd, h.is_senior_citizen,
                h.is_solo_parent, h.is_4ps, 'Household Head' AS relationship
                FROM households h{$hwSql}";

            $memberSql = "SELECT m.household_no, m.last_name, m.first_name, m.middle_name,
                m.suffix, m.date_of_birth, m.gender, '' AS civil_status, m.occupation,
                m.monthly_income, m.philhealth_no, m.educational_attainment,
                '' AS contact_number, h2.zone, 0 AS is_pwd, 0 AS is_senior_citizen,
                0 AS is_solo_parent, 0 AS is_4ps, m.relationship
                FROM household_members m
                INNER JOIN households h2 ON h2.household_no = m.household_no{$mwSql}";

            $union         = "({$headSql}) UNION ALL ({$memberSql}) ORDER BY household_no ASC, relationship ASC";
            $filteredTotal = (int) $db->query("SELECT COUNT(*) AS total FROM ({$union}) AS c")->getRow()->total;
            $persons       = $db->query("{$union} LIMIT {$perPage} OFFSET {$offset}")->getResultArray();
        }

        $viewFile = ($role === 'captain') ? 'dashboard/captain/census' : 'dashboard/secretary/census';

        return view($viewFile, array_merge($stats, [
            'households'             => [],
            'persons'                => $persons,
            'hasSpecialFilter'       => true,
            'filteredTotal'          => $filteredTotal,
            'totalHouseholdsFiltered' => $filteredTotal,
            'perPage'                => $perPage,
            'currentPage'            => $page,
            'filters'                => $filters,
        ]));
    }

    // ── Auth ──────────────────────────────────────────
    public function home()
    {
        return view('index');
    }
    public function login()
    {
        return view('login');
    }
    public function select_role()
    {
        return view('select_role');
    }
    public function create_acc($role = 'resident')
    {
        return view('create_acc', ['role' => ucfirst($role)]);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    public function faqs()
    {
        return view('faqs');
    }
    public function privacy_policy()
    {
        return view('privacy_policy');
    }
    public function terms_of_use()
    {
        return view('terms');
    }

    // ── Dashboard data helper (shared by captain + secretary) ────────────────
    private function _dashboardData(): array
    {
        $db = \Config\Database::connect();

        $totalHouseholds  = (int) $db->table('households')->countAllResults();
        $totalMembers     = (int) $db->table('household_members')->countAllResults();
        $totalPopulation  = $totalHouseholds + $totalMembers;

        $pendingClearances  = (int) $db->table('clearance_requests')->where('status', 'pending')->countAllResults();
        $approvedClearances = (int) $db->table('clearance_requests')->where('status', 'approved')->countAllResults();
        $totalClearances    = (int) $db->table('clearance_requests')->countAllResults();

        $pendingBlotter    = (int) $db->table('blotter_reports')->where('status', 'pending')->countAllResults();
        $activeBlotter     = (int) $db->table('blotter_reports')->where('status', 'under_investigation')->countAllResults();
        $resolvedBlotter   = (int) $db->table('blotter_reports')->where('status', 'resolved')->countAllResults();

        $pendingAccounts  = (int) $db->table('users')->where('status', 'pending')->whereIn('role', ['resident', 'sk'])->countAllResults();

        $pwds        = (int) $db->table('households')->where('is_pwd', 1)->countAllResults();
        $seniors     = (int) $db->table('households')->where('is_senior_citizen', 1)->countAllResults();
        $soloParents = (int) $db->table('households')->where('is_solo_parent', 1)->countAllResults();
        $fourPs      = (int) $db->table('households')->where('is_4ps', 1)->countAllResults();

        // Recent clearance requests (last 5)
        $recentClearances = $db->table('clearance_requests cr')
            ->select("cr.id, cr.document_type, cr.status, cr.created_at,
                      CONCAT(TRIM(COALESCE(u.first_name,'')), ' ', TRIM(COALESCE(u.last_name,''))) AS resident_name")
            ->join('users u', 'u.id = cr.user_id', 'left')
            ->orderBy('cr.created_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // Recent blotter reports (last 5)
        $recentBlotter = $db->table('blotter_reports')
            ->select('id, complainant_name, incident_type, status, created_at')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // Today's appointments from schedules
        $todayAppts = $db->table('schedules')
            ->where('event_date', date('Y-m-d'))
            ->orderBy('start_time', 'ASC')
            ->limit(5)
            ->get()->getResultArray();

        // Today's blotter appointments
        $todayBlotterAppts = $db->table('blotter_reports')
            ->select('id, complainant_name, incident_type, appointment_time')
            ->where('appointment_date', date('Y-m-d'))
            ->orderBy('appointment_time', 'ASC')
            ->limit(5)
            ->get()->getResultArray();

        return compact(
            'totalHouseholds',
            'totalMembers',
            'totalPopulation',
            'pendingClearances',
            'approvedClearances',
            'totalClearances',
            'pendingBlotter',
            'activeBlotter',
            'resolvedBlotter',
            'pendingAccounts',
            'pwds',
            'seniors',
            'soloParents',
            'fourPs',
            'recentClearances',
            'recentBlotter',
            'todayAppts',
            'todayBlotterAppts'
        );
    }

    // ── Captain ───────────────────────────────────────
    public function captain_dashboard()
    {
        $data         = $this->_dashboardData();
        $data['role'] = 'captain';
        return view('dashboard/captain', $data);
    }
    public function captain_census()
    {
        return $this->_censusView('captain');
    }
    public function captain_household($id = null)
    {
        $householdModel = new \App\Models\HouseholdModel();
        $household      = $householdModel->getWithMembers((string) $id);

        if (! $household) {
            return redirect()->to('/captain/census')->with('error', 'Household not found.');
        }

        return view('dashboard/captain/household', [
            'householdId' => $household['household_no'],
            'household'   => $household,
            'members'     => $household['members'],
            'role'        => 'captain',
        ]);
    }
    public function captain_clearance()
    {
        return view('dashboard/captain/clearance');
    }
    public function captain_clearance_detail($id = '001')
    {
        return view('dashboard/captain/clearance_detail', ['requestId' => $id, 'role' => 'captain']);
    }
    // ── Shared report data builder ────────────────────────────────────────────
    private function _buildReportData(): array
    {
        $db = \Config\Database::connect();

        // ── Fetch all persons ─────────────────────────────────────────────────
        $heads   = $db->table('households')
            ->select('date_of_birth, gender, civil_status, occupation,
                      is_pwd, is_solo_parent, is_4ps, is_senior_citizen,
                      is_indigenous, monthly_income, educational_attainment,
                      registered_voter, num_families,
                      water_source_level, water_safety_managed,
                      sanitation_basic, sanitation_managed')
            ->get()->getResultArray();

        $members = $db->table('household_members')
            ->select('date_of_birth, gender, occupation, monthly_income, educational_attainment')
            ->get()->getResultArray();

        // ── Age helper ────────────────────────────────────────────────────────
        $age = function (?string $dob): ?int {
            if (empty($dob)) return null;
            try {
                return (int) date_diff(date_create($dob), date_create('today'))->y;
            } catch (\Throwable $e) {
                return null;
            }
        };

        // ── F. Population by Age Bracket (heads + members, with gender) ───────
        $brackets = [
            ['label' => 'Children 0 – 5 years old',   'min' => 0,  'max' => 5],
            ['label' => 'Children 6 – 12 years old',  'min' => 6,  'max' => 12],
            ['label' => 'Children 13 – 17 years old', 'min' => 13, 'max' => 17],
            ['label' => 'Adult 18 – 35 years old',    'min' => 18, 'max' => 35],
            ['label' => 'Adult 36 – 50 years old',    'min' => 36, 'max' => 50],
            ['label' => 'Adult 51 – 65 years old',    'min' => 51, 'max' => 65],
            ['label' => 'Adult 66 years old & above', 'min' => 66, 'max' => 999],
        ];

        $ageBrackets = array_map(fn($b) => array_merge($b, ['male' => 0, 'female' => 0, 'total' => 0]), $brackets);

        $countPerson = function (array $person) use ($age, $brackets, &$ageBrackets): void {
            $a = $age($person['date_of_birth'] ?? null);
            if ($a === null) return;
            foreach ($brackets as $i => $b) {
                if ($a >= $b['min'] && $a <= $b['max']) {
                    $g = strtolower($person['gender'] ?? '');
                    if ($g === 'female')     $ageBrackets[$i]['female']++;
                    elseif ($g === 'male')   $ageBrackets[$i]['male']++;
                    // unknown gender: no male/female increment, but still count total
                    $ageBrackets[$i]['total']++;
                    break;
                }
            }
        };

        foreach ($heads   as $h) $countPerson($h);
        foreach ($members as $m) $countPerson($m);

        // ── G. Population by Sector ───────────────────────────────────────────
        $laborForce  = $unemployed = $osy = $osc = 0;
        $pwd         = $ofw = $soloParent = $indigenous = $seniorCitizen = $fourPs = 0;
        $civilSingle = $civilMarried = $civilWidow = $civilSeparated = 0;

        foreach ($heads as $h) {
            $occ = strtolower($h['occupation'] ?? '');
            $a   = $age($h['date_of_birth'] ?? null);

            if (! empty($occ) && ! in_array($occ, ['none', 'n/a', 'unemployed', ''])) $laborForce++;
            if (str_contains($occ, 'unemploy'))  $unemployed++;
            if (str_contains($occ, 'ofw') || str_contains($occ, 'overseas')) $ofw++;

            if ((int) $h['is_pwd'])          $pwd++;
            if ((int) $h['is_solo_parent'])  $soloParent++;
            if ((int) $h['is_indigenous'])   $indigenous++;
            if ((int) $h['is_senior_citizen']) $seniorCitizen++;
            if ((int) $h['is_4ps'])          $fourPs++;

            // OSY / OSC from heads (age 15–24 or 6–14, no meaningful occupation)
            if ($a !== null && $a >= 15 && $a <= 24 && in_array($occ, ['', 'none', 'n/a', 'student', 'out-of-school'])) $osy++;
            if ($a !== null && $a >= 6  && $a <= 14  && in_array($occ, ['', 'none', 'n/a', 'student', 'out-of-school'])) $osc++;

            $cs = strtolower(trim($h['civil_status'] ?? ''));
            if ($cs === 'single')    $civilSingle++;
            if ($cs === 'married')   $civilMarried++;
            if ($cs === 'widowed' || $cs === 'widow') $civilWidow++;
            if ($cs === 'separated' || $cs === 'annulled') $civilSeparated++;
        }

        foreach ($members as $m) {
            $occ = strtolower($m['occupation'] ?? '');
            $a   = $age($m['date_of_birth'] ?? null);

            if (! empty($occ) && ! in_array($occ, ['none', 'n/a', 'unemployed', ''])) $laborForce++;
            if (str_contains($occ, 'unemploy'))  $unemployed++;
            if (str_contains($occ, 'ofw') || str_contains($occ, 'overseas')) $ofw++;

            if ($a !== null && $a >= 15 && $a <= 24 && in_array($occ, ['', 'none', 'n/a', 'student', 'out-of-school'])) $osy++;
            if ($a !== null && $a >= 6  && $a <= 14  && in_array($occ, ['', 'none', 'n/a', 'student', 'out-of-school'])) $osc++;
            if ($a !== null && $a >= 60) $seniorCitizen++;
        }

        $sectorRows = [
            ['label' => 'Senior Citizens (60+)',                    'total' => $seniorCitizen],
            ['label' => 'Persons with Disabilities (PWDs)',         'total' => $pwd],
            ['label' => 'Solo Parents',                             'total' => $soloParent],
            ['label' => 'Indigenous Peoples (IPs)',                 'total' => $indigenous],
            ['label' => '4Ps Beneficiaries',                        'total' => $fourPs],
            ['label' => 'Labor Force',                              'total' => $laborForce],
            ['label' => 'Unemployed',                               'total' => $unemployed],
            ['label' => 'Out-of-School Youth (OSY) 15–24 y/o',     'total' => $osy],
            ['label' => 'Out-of-School Children (OSC) 6–14 y/o',   'total' => $osc],
            ['label' => 'Overseas Filipino Workers (OFWs)',         'total' => $ofw],
            ['label' => 'Civil Status: Single',                     'total' => $civilSingle],
            ['label' => 'Civil Status: Married',                    'total' => $civilMarried],
            ['label' => 'Civil Status: Widowed',                    'total' => $civilWidow],
            ['label' => 'Civil Status: Separated / Annulled',       'total' => $civilSeparated],
        ];

        // ── Water & Sanitation (H) ────────────────────────────────────────────
        $waterRows = [
            ['label' => 'Level I – Point Source',       'total' => (int)$db->table('households')->where('water_source_level', '1')->countAllResults()],
            ['label' => 'Level II – Communal Faucet',   'total' => (int)$db->table('households')->where('water_source_level', '2')->countAllResults()],
            ['label' => 'Level III – Individual Connection', 'total' => (int)$db->table('households')->where('water_source_level', '3')->countAllResults()],
            ['label' => 'Safe Water (Managed)',          'total' => (int)$db->table('households')->where('water_safety_managed', 1)->countAllResults()],
        ];

        $sanitationRows = [
            ['label' => 'Basic Sanitation Facility',    'total' => (int)$db->table('households')->where('sanitation_basic', 1)->countAllResults()],
            ['label' => 'Safely Managed Sanitation',    'total' => (int)$db->table('households')->where('sanitation_managed', 1)->countAllResults()],
        ];

        // ── Educational Attainment ────────────────────────────────────────────
        $eduCounts = [];
        foreach (
            array_merge(
                array_column($heads,   'educational_attainment'),
                array_column($members, 'educational_attainment')
            ) as $edu
        ) {
            $key = ucwords(strtolower(trim($edu ?? 'Not Specified'))) ?: 'Not Specified';
            $eduCounts[$key] = ($eduCounts[$key] ?? 0) + 1;
        }
        arsort($eduCounts);
        $eduRows = array_map(fn($label, $total) => ['label' => $label, 'total' => $total], array_keys($eduCounts), $eduCounts);

        // ── Summary stats ─────────────────────────────────────────────────────
        $totalPop        = count($heads) + count($members);
        $totalHouseholds = count($heads);
        $totalMale       = array_sum(array_column($ageBrackets, 'male'));
        $totalFemale     = array_sum(array_column($ageBrackets, 'female'));
        $totalClearances = $db->table('clearance_requests')->where('status', 'approved')->countAllResults();
        $avgHHSize       = $totalHouseholds > 0 ? round($totalPop / $totalHouseholds, 1) : 0;
        $registeredVoters = $db->table('households')->where('registered_voter', 1)->countAllResults();
        $totalFamilies   = (int) $db->query("SELECT COALESCE(SUM(num_families),0) AS t FROM households")->getRow()->t;

        return [
            'totalPop'         => $totalPop,
            'totalMale'        => $totalMale,
            'totalFemale'      => $totalFemale,
            'totalHouseholds'  => $totalHouseholds,
            'totalClearances'  => $totalClearances,
            'avgHHSize'        => $avgHHSize,
            'ageBrackets'      => $ageBrackets,
            'sectorRows'       => $sectorRows,
            'waterRows'        => $waterRows,
            'sanitationRows'   => $sanitationRows,
            'eduRows'          => $eduRows,
            'registeredVoters' => $registeredVoters,
            'totalFamilies'    => $totalFamilies,
        ];
    }

    public function captain_reports()
    {
        return view('dashboard/captain/reports', $this->_buildReportData());
    }
    public function captain_chatbot()
    {
        return view('dashboard/captain/chatbot');
    }
    public function captain_blotter()
    {
        return view('dashboard/captain/blotter');
    }
    public function captain_blotter_detail($id = 'BL-001')
    {
        return view('dashboard/captain/blotter_detail', ['blotterId' => $id, 'role' => 'captain']);
    }
    public function captain_settings()
    {
        return view('dashboard/captain/settings');
    }

    public function captain_create_account()
    {
        return view('dashboard/captain/create_account');
    }

    // ── Secretary ─────────────────────────────────────
    public function secretary_dashboard()
    {
        $data         = $this->_dashboardData();
        $data['role'] = 'secretary';
        return view('dashboard/secretary', $data);
    }
    public function secretary_census()
    {
        return $this->_censusView('secretary');
    }
    public function secretary_household($id = null)
    {
        $householdModel = new \App\Models\HouseholdModel();
        $household      = $householdModel->getWithMembers((string) $id);

        if (! $household) {
            return redirect()->to('/secretary/census')->with('error', 'Household not found.');
        }

        return view('dashboard/captain/household', [
            'householdId' => $household['household_no'],
            'household'   => $household,
            'members'     => $household['members'],
            'role'        => 'secretary',
        ]);
    }
    public function secretary_clearance()
    {
        return view('dashboard/secretary/clearance');
    }
    public function secretary_clearance_detail($id = '001')
    {
        return view('dashboard/captain/clearance_detail', ['requestId' => $id, 'role' => 'secretary']);
    }
    public function secretary_requests()
    {
        return view('dashboard/secretary/requests');
    }
    public function secretary_reports()
    {
        return view('dashboard/secretary/reports', $this->_buildReportData());
    }
    public function secretary_chatbot()
    {
        return view('dashboard/secretary/chatbot');
    }
    public function secretary_blotter()
    {
        return view('dashboard/secretary/blotter');
    }
    public function secretary_blotter_detail($id = 'BL-001')
    {
        return view('dashboard/captain/blotter_detail', ['blotterId' => $id, 'role' => 'secretary']);
    }
    public function secretary_settings()
    {
        $userModel = new \App\Models\UserModel();
        $users = $userModel
            ->select('id, last_name, first_name, middle_name, username, role')
            ->whereIn('role', ['captain', 'secretary', 'treasurer', 'resident', 'sk'])
            ->where('status', 'active')
            ->orderBy('last_name', 'ASC')
            ->findAll();

        return view('dashboard/secretary/settings', ['allUsers' => $users]);
    }
    public function secretary_create_account()
    {
        $userModel = new \App\Models\UserModel();
        $db        = \Config\Database::connect();

        // Eligible residents: active, age 18+ from household census
        // Join to households to get date_of_birth for age check
        $today = date('Y-m-d');
        $cutoff = date('Y-m-d', strtotime('-18 years', strtotime($today)));

        // Fetch residents (active, email verified) who have a household link with DOB <= cutoff
        $eligibleResidents = $db->table('users u')
            ->select('u.id, u.last_name, u.first_name, u.middle_name, u.username, u.email, u.household_no,
                      h.date_of_birth,
                      TIMESTAMPDIFF(YEAR, h.date_of_birth, CURDATE()) AS age')
            ->join('households h', 'h.household_no = u.household_no', 'inner')
            ->where('u.role', 'resident')
            ->where('u.status', 'active')
            ->where('h.date_of_birth IS NOT NULL')
            ->where('h.date_of_birth <=', $cutoff)
            ->orderBy('u.last_name', 'ASC')
            ->orderBy('u.first_name', 'ASC')
            ->get()->getResultArray();

        $activeSecretaries = $userModel
            ->select('id, last_name, first_name, middle_name, username, email')
            ->where('role', 'secretary')
            ->where('status', 'active')
            ->orderBy('last_name', 'ASC')
            ->findAll();

        return view('dashboard/secretary/create_account', [
            'activeCaptain'      => $userModel->getActiveByRole('captain'),
            'activeSecretaries'  => $activeSecretaries,
            'activeSk'           => $userModel->getActiveByRole('sk'),
            'eligibleResidents'  => $eligibleResidents,
        ]);
    }

    // ── Treasurer ─────────────────────────────────────
    public function treasurer_dashboard()
    {
        return view('dashboard/treasurer');
    }
    public function treasurer_payments()
    {
        return view('dashboard/treasurer/payments');
    }
    public function treasurer_clearance()
    {
        return view('dashboard/treasurer/clearance');
    }
    public function treasurer_reports()
    {
        return view('dashboard/treasurer/reports');
    }
    public function treasurer_settings()
    {
        return view('dashboard/treasurer/settings');
    }

    // ── Resident ──────────────────────────────────────
    public function resident_dashboard()
    {
        return view('dashboard/resident');
    }
    public function resident_clearance()
    {
        return view('dashboard/resident/clearance');
    }
    public function resident_profile()
    {
        $userId    = session()->get('user_id');
        $userModel = new \App\Models\UserModel();
        $user      = $userModel->find($userId);

        $household    = null;
        $members      = [];
        $memberRecord = null;

        if (! empty($user['household_no'])) {
            $householdModel = new \App\Models\HouseholdModel();
            $household      = $householdModel->find($user['household_no']);

            if ($household) {
                $memberModel = new \App\Models\HouseholdMemberModel();
                $members     = $memberModel->where('household_no', $user['household_no'])->findAll();

                $userFirst = strtoupper(trim($user['first_name'] ?? ''));
                $userLast  = strtoupper(trim($user['last_name']  ?? ''));
                $userFull  = $userFirst . ' ' . $userLast;
                $userFullR = $userLast  . ' ' . $userFirst;

                // Pass 1 — exact first+last match against members
                foreach ($members as $m) {
                    $mFirst = strtoupper(trim($m['first_name'] ?? ''));
                    $mLast  = strtoupper(trim($m['last_name']  ?? ''));
                    $mFull  = $mFirst . ' ' . $mLast;
                    if (
                        $userFull === $mFull || $userFullR === $mFull ||
                        $userFull === ($mLast . ' ' . $mFirst)
                    ) {
                        $memberRecord = $m;
                        break;
                    }
                }

                // Pass 2 — exact first+last match against the household head
                if (! $memberRecord) {
                    $hFirst = strtoupper(trim($household['first_name'] ?? ''));
                    $hLast  = strtoupper(trim($household['last_name']  ?? ''));
                    $hFull  = $hFirst . ' ' . $hLast;
                    if (
                        $userFull === $hFull || $userFullR === $hFull ||
                        $userFull === ($hLast . ' ' . $hFirst)
                    ) {
                        $memberRecord = $household;
                    }
                }

                // Pass 3 — first-name-only fallback against members
                if (! $memberRecord && $userFirst !== '') {
                    foreach ($members as $m) {
                        if (strtoupper(trim($m['first_name'] ?? '')) === $userFirst) {
                            $memberRecord = $m;
                            break;
                        }
                    }
                }

                // Pass 4 — first-name-only fallback against head
                if (! $memberRecord && $userFirst !== '') {
                    if (strtoupper(trim($household['first_name'] ?? '')) === $userFirst) {
                        $memberRecord = $household;
                    }
                }

                // Merge: if matched a member row but personal fields are empty,
                // fill them from the household head record
                if ($memberRecord && $memberRecord !== $household) {
                    $fillFields = [
                        'date_of_birth',
                        'occupation',
                        'monthly_income',
                        'educational_attainment',
                        'philhealth_no',
                        'gender'
                    ];
                    foreach ($fillFields as $f) {
                        if (empty($memberRecord[$f]) && ! empty($household[$f])) {
                            $memberRecord[$f] = $household[$f];
                        }
                    }
                }
            }
        }

        return view('dashboard/resident/profile', [
            'user'         => $user,
            'household'    => $household,
            'members'      => $members,
            'memberRecord' => $memberRecord,
        ]);
    }
    public function resident_chatbot()
    {
        return view('dashboard/resident/chatbot');
    }
    public function resident_notifications()
    {
        $userId        = (int) session()->get('user_id');
        $notifModel    = new \App\Models\NotificationModel();
        $scheduleModel = new \App\Models\ScheduleModel();

        // ── Auto-create upcoming-event notifications (once per event) ─────────
        $db = \Config\Database::connect();
        $upcoming = $db->table('schedules')
            ->where('event_date >=', date('Y-m-d'))
            ->where('event_date <=', date('Y-m-d', strtotime('+7 days')))
            ->where('visibility !=', 'private')
            ->orderBy('event_date', 'ASC')
            ->get()->getResultArray();

        foreach ($upcoming as $ev) {
            // Only push once: check if a notification for this event already exists for this user
            $exists = $db->table('notifications')
                ->where('user_id', $userId)
                ->where('type', 'event_reminder')
                ->like('body', 'event_id:' . $ev['id'], 'none')
                ->countAllResults();

            if (! $exists) {
                $dateLabel = date('M d, Y', strtotime($ev['event_date']));
                $timeLabel = $ev['start_time'] ? ' at ' . date('g:i A', strtotime($ev['start_time'])) : '';
                \App\Models\NotificationModel::push(
                    $userId,
                    'event_reminder',
                    'Upcoming Event: ' . $ev['title'],
                    $ev['description']
                        ? $ev['description'] . ' — ' . $dateLabel . $timeLabel
                        : 'Scheduled on ' . $dateLabel . $timeLabel . ($ev['location'] ? '. Venue: ' . $ev['location'] : ''),
                    '/resident/dashboard'
                );
                // Store event_id marker in the body so we don't double-push
                $lastId = $db->insertID();
                $db->table('notifications')
                    ->where('id', $lastId)
                    ->update(['body' => ($db->table('notifications')->where('id', $lastId)->get()->getRowArray()['body'] ?? '') . ' [event_id:' . $ev['id'] . ']']);
            }
        }

        // ── Fetch all notifications for this user ─────────────────────────────
        $notifs      = $notifModel->getForUser($userId);
        $unreadCount = $notifModel->countUnread($userId);

        return view('dashboard/resident/notifications', [
            'notifs'      => $notifs,
            'unreadCount' => $unreadCount,
        ]);
    }

    // ── SK ────────────────────────────────────────────────
    public function sk_dashboard()
    {
        $db = \Config\Database::connect();

        $youthMax = date('Y-m-d', strtotime('-15 years'));
        $youthMin = date('Y-m-d', strtotime('-30 years'));

        // UNION: household heads + members aged 15–30
        $headSql = "SELECT h.date_of_birth, h.gender, h.occupation, h.last_name, h.first_name, h.zone, h.created_at, 'head' AS source, h.household_no AS rid
            FROM households h
            WHERE h.date_of_birth IS NOT NULL AND h.date_of_birth <= '{$youthMax}' AND h.date_of_birth >= '{$youthMin}'";

        $memberSql = "SELECT m.date_of_birth, m.gender, m.occupation, m.last_name, m.first_name, h2.zone, m.created_at, 'member' AS source, m.id AS rid
            FROM household_members m
            INNER JOIN households h2 ON h2.household_no = m.household_no
            WHERE m.date_of_birth IS NOT NULL AND m.date_of_birth <= '{$youthMax}' AND m.date_of_birth >= '{$youthMin}'";

        $allYouth = $db->query("({$headSql}) UNION ALL ({$memberSql})")->getResultArray();

        $total    = count($allYouth);
        $male     = count(array_filter($allYouth, fn($r) => strtolower($r['gender'] ?? '') === 'male'));
        $female   = count(array_filter($allYouth, fn($r) => strtolower($r['gender'] ?? '') === 'female'));
        $oos      = count(array_filter($allYouth, fn($r) =>
        stripos($r['occupation'] ?? '', 'out-of-school') !== false ||
            stripos($r['occupation'] ?? '', 'osy') !== false));
        $employed = count(array_filter($allYouth, fn($r) => (function ($occ) {
            $o = strtolower($occ ?? '');
            return $o !== '' && $o !== 'none' && $o !== 'n/a'
                && strpos($o, 'student') === false
                && strpos($o, 'unemploy') === false
                && strpos($o, 'out-of-school') === false
                && strpos($o, 'osy') === false;
        })($r['occupation'])));

        // Recent 5 youth sorted by created_at
        usort($allYouth, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        $recentYouth = array_slice($allYouth, 0, 5);
        foreach ($recentYouth as &$y) {
            $y['age'] = (int) date_diff(date_create($y['date_of_birth']), date_create('today'))->y;
            $occ = strtolower($y['occupation'] ?? '');
            if (str_contains($occ, 'student'))                                             $y['status'] = 'Student';
            elseif (str_contains($occ, 'unemploy'))                                        $y['status'] = 'Unemployed';
            elseif (str_contains($occ, 'out-of-school') || str_contains($occ, 'osy'))      $y['status'] = 'Out-of-School';
            elseif ($occ !== '' && $occ !== 'none' && $occ !== 'n/a')                      $y['status'] = 'Employed';
            else                                                                            $y['status'] = '—';
        }
        unset($y);

        // Programs count
        $progModel   = new \App\Models\SkProgramModel();
        $progCounts  = $progModel->statusCounts();

        return view('dashboard/sk', [
            'stats' => [
                'total'    => $total,
                'male'     => $male,
                'female'   => $female,
                'oos'      => $oos,
                'employed' => $employed,
                'students' => count(array_filter($allYouth, fn($r) => stripos($r['occupation'] ?? '', 'student') !== false)),
                'programs' => $progCounts['Active'],
            ],
            'recentYouth' => $recentYouth,
            'progCounts'  => $progCounts,
        ]);
    }
    public function sk_profiling()
    {
        return view('dashboard/sk/profiling');
    }
    public function sk_household($id = null)
    {
        $householdModel = new \App\Models\HouseholdModel();
        $household      = $householdModel->getWithMembers((string) $id);

        if (! $household) {
            return redirect()->to('/sk/profiling')->with('error', 'Household not found.');
        }

        // Find the youth member (15–30) that was clicked from the profiling list
        // The profiling list passes the member's source and id via query string
        $memberSource = $_GET['source'] ?? 'head';
        $memberId     = (int) ($_GET['member_id'] ?? 0);

        $youthMember = null;
        if ($memberSource === 'member' && $memberId > 0) {
            // Find the specific member
            foreach ($household['members'] as $m) {
                if ((int) $m['id'] === $memberId) {
                    $youthMember = $m;
                    break;
                }
            }
        } elseif ($memberSource === 'head') {
            // The head is the youth
            $youthMember = array_merge($household, ['relationship' => 'Household Head', 'id' => null]);
        }

        return view('dashboard/sk/household', [
            'householdId' => $household['household_no'],
            'household'   => $household,
            'members'     => $household['members'],
            'youthMember' => $youthMember,
            'role'        => 'sk',
        ]);
    }
    public function sk_add_youth()
    {
        return view('dashboard/sk/add_youth');
    }
    public function sk_programs()
    {
        // Delegate to SkController
        return (new \App\Controllers\SkController())->programs();
    }
    public function sk_reports()
    {
        $db = \Config\Database::connect();

        $youthMax = date('Y-m-d', strtotime('-15 years'));
        $youthMin = date('Y-m-d', strtotime('-30 years'));

        // UNION: household heads + members aged 15–30
        $headSql = "SELECT h.date_of_birth, h.gender, h.occupation
            FROM households h
            WHERE h.date_of_birth IS NOT NULL
              AND h.date_of_birth <= '{$youthMax}'
              AND h.date_of_birth >= '{$youthMin}'";

        $memberSql = "SELECT m.date_of_birth, m.gender, m.occupation
            FROM household_members m
            INNER JOIN households h2 ON h2.household_no = m.household_no
            WHERE m.date_of_birth IS NOT NULL
              AND m.date_of_birth <= '{$youthMax}'
              AND m.date_of_birth >= '{$youthMin}'";

        $allYouth = $db->query("({$headSql}) UNION ALL ({$memberSql})")->getResultArray();

        // Helper to classify occupation into status
        $classifyStatus = function (string $occ): string {
            $o = strtolower($occ);
            if (str_contains($o, 'student'))                                         return 'Student';
            if (str_contains($o, 'unemploy'))                                        return 'Unemployed';
            if (str_contains($o, 'out-of-school') || str_contains($o, 'osy'))        return 'Out-of-School';
            if ($o !== '' && $o !== 'none' && $o !== 'n/a')                          return 'Employed';
            return '';
        };

        // Age group buckets: 15–17, 18–24, 25–30
        $groups = [
            '15–17 (Child Youth)'  => ['min' => 15, 'max' => 17],
            '18–24 (Core Youth)'   => ['min' => 18, 'max' => 24],
            '25–30 (Young Adult)'  => ['min' => 25, 'max' => 30],
        ];

        $demographics = [];
        foreach ($groups as $label => $range) {
            $demographics[$label] = [
                'total' => 0,
                'male' => 0,
                'female' => 0,
                'student' => 0,
                'employed' => 0,
                'unemployed' => 0,
                'oos' => 0,
            ];
        }

        $totals = ['total' => 0, 'male' => 0, 'female' => 0, 'student' => 0, 'employed' => 0, 'unemployed' => 0, 'oos' => 0];

        foreach ($allYouth as $y) {
            $age = (int) date_diff(date_create($y['date_of_birth']), date_create('today'))->y;
            $g   = strtolower($y['gender'] ?? '');
            $s   = $classifyStatus($y['occupation'] ?? '');

            foreach ($groups as $label => $range) {
                if ($age >= $range['min'] && $age <= $range['max']) {
                    $d = &$demographics[$label];
                    $d['total']++;
                    if ($g === 'male')    $d['male']++;
                    if ($g === 'female')  $d['female']++;
                    if ($s === 'Student')       $d['student']++;
                    if ($s === 'Employed')       $d['employed']++;
                    if ($s === 'Unemployed')     $d['unemployed']++;
                    if ($s === 'Out-of-School')  $d['oos']++;
                    break;
                }
            }

            $totals['total']++;
            if ($g === 'male')   $totals['male']++;
            if ($g === 'female') $totals['female']++;
            if ($s === 'Student')       $totals['student']++;
            if ($s === 'Employed')       $totals['employed']++;
            if ($s === 'Unemployed')     $totals['unemployed']++;
            if ($s === 'Out-of-School')  $totals['oos']++;
        }

        // Programs from DB
        $progModel  = new \App\Models\SkProgramModel();
        $programs   = $progModel->orderBy('start_date', 'DESC')->findAll();
        $progCounts = $progModel->statusCounts();

        // Total actual participants across all programs
        $totalParticipants = (int) array_sum(array_column($programs, 'actual_participants'));

        return view('dashboard/sk/reports', [
            'demographics'      => $demographics,
            'totals'            => $totals,
            'programs'          => $programs,
            'progCounts'        => $progCounts,
            'totalParticipants' => $totalParticipants,
        ]);
    }
    public function sk_settings()
    {
        return view('dashboard/sk/settings');
    }
}
