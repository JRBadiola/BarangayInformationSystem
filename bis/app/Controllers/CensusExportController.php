<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HouseholdModel;
use App\Models\HouseholdMemberModel;

class CensusExportController extends BaseController
{
    /**
     * Render a print-ready landscape HTML page that the browser can save as PDF.
     * Accepts the same GET filters as the census list page.
     */
    public function exportPdf()
    {
        $role = session()->get('role');
        $db   = \Config\Database::connect();

        // ── Read all filters (mirrors UIController::_censusView) ─────────────
        $zone       = trim($_GET['zone']        ?? '');
        $gender     = trim($_GET['gender']      ?? '');
        $search     = trim($_GET['search']      ?? '');
        $ageMin     = trim($_GET['age_min']     ?? '');
        $ageMax     = trim($_GET['age_max']     ?? '');
        $isPwd      = trim($_GET['is_pwd']      ?? '');
        $isSenior   = trim($_GET['is_senior']   ?? '');
        $isSolo     = trim($_GET['is_solo']     ?? '');
        $is4ps      = trim($_GET['is_4ps']      ?? '');
        $isStudent  = trim($_GET['is_student']  ?? '');
        $isIndigent = trim($_GET['is_indigent'] ?? '');

        // ── Build WHERE for households ────────────────────────────────────────
        $hw = [];

        if ($zone !== '') {
            $z    = $db->escapeString($zone);
            $hw[] = "h.zone = '{$z}'";
        }
        if ($search !== '') {
            $s    = $db->escapeLikeString($search);
            $hw[] = "(h.last_name LIKE '%{$s}%' OR h.first_name LIKE '%{$s}%' OR h.household_no LIKE '%{$s}%')";
        }
        if ($gender !== '') {
            $g    = $db->escapeString($gender);
            $hw[] = "h.gender = '{$g}'";
        }
        if ($isPwd === '1')      $hw[] = "h.is_pwd = 1";
        if ($isSenior === '1')   $hw[] = "h.is_senior_citizen = 1";
        if ($isSolo === '1')     $hw[] = "h.is_solo_parent = 1";
        if ($is4ps === '1')      $hw[] = "h.is_4ps = 1";
        if ($isStudent === '1')  $hw[] = "UPPER(h.occupation) LIKE '%STUDENT%'";
        if ($isIndigent === '1') $hw[] = "h.monthly_income > 0 AND h.monthly_income <= 5000";
        if ($ageMin !== '') {
            $d    = date('Y-m-d', strtotime('-' . (int)$ageMin . ' years'));
            $hw[] = "h.date_of_birth IS NOT NULL AND h.date_of_birth <= '{$d}'";
        }
        if ($ageMax !== '') {
            $d    = date('Y-m-d', strtotime('-' . (int)$ageMax . ' years'));
            $hw[] = "h.date_of_birth IS NOT NULL AND h.date_of_birth >= '{$d}'";
        }

        $hwSql = ! empty($hw) ? ' WHERE ' . implode(' AND ', $hw) : '';

        // ── Fetch matching households ─────────────────────────────────────────
        $households = $db->query(
            "SELECT h.* FROM households h{$hwSql} ORDER BY h.zone ASC, h.household_no ASC"
        )->getResultArray();

        // Attach members to each household
        $memberModel = new HouseholdMemberModel();
        foreach ($households as &$hh) {
            $hh['members'] = $memberModel
                ->where('household_no', $hh['household_no'])
                ->orderBy('relationship', 'ASC')
                ->findAll();
        }
        unset($hh);

        // ── Group by zone for page breaks ─────────────────────────────────────
        $byZone = [];
        foreach ($households as $hh) {
            $z = $hh['zone'] ?: 'Unassigned';
            $byZone[$z][] = $hh;
        }

        // ── Build a human-readable filter summary for the PDF header ──────────
        $activeFilters = [];
        if ($zone)             $activeFilters[] = 'Zone: ' . $zone;
        if ($gender)           $activeFilters[] = 'Gender: ' . $gender;
        if ($ageMin)           $activeFilters[] = 'Age ≥ ' . $ageMin;
        if ($ageMax)           $activeFilters[] = 'Age ≤ ' . $ageMax;
        if ($isPwd === '1')    $activeFilters[] = 'PWD';
        if ($isSenior === '1') $activeFilters[] = 'Senior Citizen';
        if ($isSolo === '1')   $activeFilters[] = 'Solo Parent';
        if ($is4ps === '1')    $activeFilters[] = '4Ps';
        if ($isStudent === '1')  $activeFilters[] = 'Has Student';
        if ($isIndigent === '1') $activeFilters[] = 'Indigency Eligible';
        if ($search)           $activeFilters[] = 'Search: "' . $search . '"';

        return view('dashboard/captain/census_export_pdf', [
            'byZone'           => $byZone,
            'zone'             => $zone,
            'totalProjected'   => count($households),
            'dateAccomplished' => date('m/d/Y'),
            'role'             => $role,
            'activeFilters'    => $activeFilters,
        ]);
    }
}
