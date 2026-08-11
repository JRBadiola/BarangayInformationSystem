<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ReportsExportController extends BaseController
{
    /**
     * Render a print-ready HTML page with real tables (no images).
     * The browser's "Save as PDF" produces a proper text-based PDF.
     */
    public function export(string $role = 'secretary')
    {
        $db = \Config\Database::connect();

        $heads   = $db->table('households')
            ->select('date_of_birth, gender, civil_status, occupation, is_pwd, is_solo_parent, is_4ps, is_senior_citizen, is_indigenous, monthly_income')
            ->get()->getResultArray();
        $members = $db->table('household_members')
            ->select('date_of_birth, occupation, monthly_income')
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

        foreach ($heads as $h) {
            $a = $age($h['date_of_birth']);
            if ($a === null) continue;
            foreach ($brackets as $i => $b) {
                if ($a >= $b['min'] && $a <= $b['max']) {
                    $g = strtolower($h['gender'] ?? 'male');
                    if ($g === 'female') $ageBrackets[$i]['female']++;
                    else                 $ageBrackets[$i]['male']++;
                    $ageBrackets[$i]['total']++;
                    break;
                }
            }
        }
        foreach ($members as $m) {
            $a = $age($m['date_of_birth']);
            if ($a === null) continue;
            foreach ($brackets as $i => $b) {
                if ($a >= $b['min'] && $a <= $b['max']) {
                    $ageBrackets[$i]['total']++;
                    break;
                }
            }
        }

        $laborForce = $unemployed = $osy = $osc = $pwd = $ofw = $soloParent = $indigenous = 0;
        $civilSingle = $civilMarried = 0;
        $totalPop = count($heads) + count($members);

        foreach ($heads as $h) {
            $occ = strtolower($h['occupation'] ?? '');
            if (! empty($occ) && $occ !== 'none' && $occ !== 'n/a') $laborForce++;
            if (str_contains($occ, 'unemploy'))  $unemployed++;
            if ($h['is_pwd'])         $pwd++;
            if ($h['is_solo_parent']) $soloParent++;
            if ($h['is_indigenous'])  $indigenous++;
            $cs = strtolower($h['civil_status'] ?? '');
            if ($cs === 'single')  $civilSingle++;
            if ($cs === 'married') $civilMarried++;
        }
        foreach ($members as $m) {
            $a   = $age($m['date_of_birth']);
            $occ = strtolower($m['occupation'] ?? '');
            if ($a !== null && $a >= 15 && $a <= 24 && (empty($occ) || $occ === 'none')) $osy++;
            if ($a !== null && $a >= 6  && $a <= 14  && (empty($occ) || $occ === 'none')) $osc++;
            if (! empty($occ) && $occ !== 'none' && $occ !== 'n/a') $laborForce++;
            if (str_contains($occ, 'unemploy')) $unemployed++;
            if (str_contains($occ, 'ofw') || str_contains($occ, 'overseas')) $ofw++;
        }

        $sectorRows = [
            ['label' => 'Labor Force',                            'total' => $laborForce],
            ['label' => 'Unemployed',                             'total' => $unemployed],
            ['label' => 'Out-of-School Youth (OSY) 15–24 y/o',   'total' => $osy],
            ['label' => 'Out-of-School Children (OSC) 6–14 y/o', 'total' => $osc],
            ['label' => 'Persons with Disabilities (PWDs)',       'total' => $pwd],
            ['label' => 'Overseas Filipino Workers (OFWs)',       'total' => $ofw],
            ['label' => 'Solo Parents',                           'total' => $soloParent],
            ['label' => 'Indigenous Peoples (IPs)',               'total' => $indigenous],
            ['label' => 'Civil Status: Single',                   'total' => $civilSingle],
            ['label' => 'Civil Status: Married',                  'total' => $civilMarried],
        ];

        $totalHouseholds  = count($heads);
        $totalMale        = array_sum(array_column($ageBrackets, 'male'));
        $totalFemale      = array_sum(array_column($ageBrackets, 'female'));
        $totalClearances  = $db->table('clearance_requests')->where('status', 'approved')->countAllResults();
        $avgHHSize        = $totalHouseholds > 0 ? round($totalPop / $totalHouseholds, 1) : 0;
        $registeredVoters = $db->table('households')->where('registered_voter', 1)->countAllResults();
        $totalFamilies    = (int) $db->query("SELECT COALESCE(SUM(num_families),0) AS t FROM households")->getRow()->t;

        return view('reports_export', [
            'role'             => $role,
            'totalPop'         => $totalPop,
            'totalMale'        => $totalMale,
            'totalFemale'      => $totalFemale,
            'totalHouseholds'  => $totalHouseholds,
            'totalClearances'  => $totalClearances,
            'avgHHSize'        => $avgHHSize,
            'ageBrackets'      => $ageBrackets,
            'sectorRows'       => $sectorRows,
            'registeredVoters' => $registeredVoters,
            'totalFamilies'    => $totalFamilies,
        ]);
    }
}
