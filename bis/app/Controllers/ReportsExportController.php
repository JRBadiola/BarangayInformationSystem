<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ReportsExportController extends BaseController
{
    /**
     * Render a print-ready HTML page using the same data as the on-screen report.
     * The browser's "Save as PDF" / "Print" produces a proper text-based PDF.
     */
    public function export(string $role = 'secretary')
    {
        $data = $this->_buildReportData();
        return view('reports_export', array_merge($data, ['role' => $role]));
    }

    // ── Shared report data builder (mirrors UIController::_buildReportData) ───
    private function _buildReportData(): array
    {
        $db = \Config\Database::connect();

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

        $age = function (?string $dob): ?int {
            if (empty($dob)) return null;
            try {
                return (int) date_diff(date_create($dob), date_create('today'))->y;
            } catch (\Throwable $e) {
                return null;
            }
        };

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
                    if ($g === 'female')   $ageBrackets[$i]['female']++;
                    elseif ($g === 'male') $ageBrackets[$i]['male']++;
                    $ageBrackets[$i]['total']++;
                    break;
                }
            }
        };

        foreach ($heads   as $h) $countPerson($h);
        foreach ($members as $m) $countPerson($m);

        $laborForce  = $unemployed = $osy = $osc = 0;
        $pwd         = $ofw = $soloParent = $indigenous = $seniorCitizen = $fourPs = 0;
        $civilSingle = $civilMarried = $civilWidow = $civilSeparated = 0;

        foreach ($heads as $h) {
            $occ = strtolower($h['occupation'] ?? '');
            $a   = $age($h['date_of_birth'] ?? null);

            if (! empty($occ) && ! in_array($occ, ['none', 'n/a', 'unemployed', ''])) $laborForce++;
            if (str_contains($occ, 'unemploy'))  $unemployed++;
            if (str_contains($occ, 'ofw') || str_contains($occ, 'overseas')) $ofw++;

            if ((int) $h['is_pwd'])            $pwd++;
            if ((int) $h['is_solo_parent'])    $soloParent++;
            if ((int) $h['is_indigenous'])     $indigenous++;
            if ((int) $h['is_senior_citizen']) $seniorCitizen++;
            if ((int) $h['is_4ps'])            $fourPs++;

            if ($a !== null && $a >= 15 && $a <= 24 && in_array($occ, ['', 'none', 'n/a', 'student', 'out-of-school'])) $osy++;
            if ($a !== null && $a >= 6  && $a <= 14  && in_array($occ, ['', 'none', 'n/a', 'student', 'out-of-school'])) $osc++;

            $cs = strtolower(trim($h['civil_status'] ?? ''));
            if ($cs === 'single')   $civilSingle++;
            if ($cs === 'married')  $civilMarried++;
            if (in_array($cs, ['widowed', 'widow'])) $civilWidow++;
            if (in_array($cs, ['separated', 'annulled'])) $civilSeparated++;
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

        $waterRows = [
            ['label' => 'Level I – Point Source',            'total' => (int)$db->table('households')->where('water_source_level', '1')->countAllResults()],
            ['label' => 'Level II – Communal Faucet',        'total' => (int)$db->table('households')->where('water_source_level', '2')->countAllResults()],
            ['label' => 'Level III – Individual Connection', 'total' => (int)$db->table('households')->where('water_source_level', '3')->countAllResults()],
            ['label' => 'Safe Water (Managed)',               'total' => (int)$db->table('households')->where('water_safety_managed', 1)->countAllResults()],
        ];

        $sanitationRows = [
            ['label' => 'Basic Sanitation Facility',  'total' => (int)$db->table('households')->where('sanitation_basic', 1)->countAllResults()],
            ['label' => 'Safely Managed Sanitation',  'total' => (int)$db->table('households')->where('sanitation_managed', 1)->countAllResults()],
        ];

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
        $eduRows = array_map(fn($l, $t) => ['label' => $l, 'total' => $t], array_keys($eduCounts), $eduCounts);

        $totalPop         = count($heads) + count($members);
        $totalHouseholds  = count($heads);
        $totalMale        = array_sum(array_column($ageBrackets, 'male'));
        $totalFemale      = array_sum(array_column($ageBrackets, 'female'));
        $totalClearances  = $db->table('clearance_requests')->where('status', 'approved')->countAllResults();
        $avgHHSize        = $totalHouseholds > 0 ? round($totalPop / $totalHouseholds, 1) : 0;
        $registeredVoters = $db->table('households')->where('registered_voter', 1)->countAllResults();
        $totalFamilies    = (int) $db->query("SELECT COALESCE(SUM(num_families),0) AS t FROM households")->getRow()->t;

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
}
