<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Census Records - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php $role = $role ?? 'secretary';
    $active = 'census';
    $pageTitle = 'Census Records';
    include(APPPATH . 'Views/dashboard/sidebar.php'); ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">
            <?php $filters = $filters ?? []; ?>

            <!-- Toolbar + Filter Form -->
            <form method="get" action="" id="filterForm">
                <div class="db-toolbar">
                    <div class="db-search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Search by name or household #..."
                            value="<?= esc($filters['search'] ?? '') ?>"
                            onchange="document.getElementById('filterForm').submit()">
                    </div>
                    <div class="db-toolbar-actions">
                        <button class="db-btn db-btn--primary" type="button" onclick="openModal('addModal')">
                            <i class="fas fa-plus"></i> Add Household
                        </button>
                        <button class="db-btn db-btn--outline" type="button" onclick="toggleFilters()">
                            <i class="fas fa-filter"></i> Filters
                            <?php
                            $activeCount = 0;
                            foreach (['zone', 'gender', 'age_min', 'age_max', 'is_pwd', 'is_senior', 'is_solo', 'is_4ps', 'is_student', 'is_indigent'] as $k) {
                                if (! empty($filters[$k])) $activeCount++;
                            }
                            ?>
                            <?php if ($activeCount > 0): ?>
                                <span style="background:#c0392b;color:#fff;border-radius:100px;padding:1px 7px;font-size:11px;margin-left:4px;"><?= $activeCount ?></span>
                            <?php endif; ?>
                        </button>
                        <button class="db-btn db-btn--outline" type="button" onclick="exportPdf()">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                    </div>
                </div>

                <!-- Expandable filter panel -->
                <div id="filterPanel" style="<?= $activeCount > 0 ? '' : 'display:none;' ?> background:#fff;border:1px solid #e2e5ef;border-radius:10px;padding:16px 20px;margin-bottom:16px;">
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px;align-items:end;">

                        <!-- Zone -->
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:4px;">Zone</label>
                            <select name="zone" class="db-filter-select" style="width:100%;" onchange="this.form.submit()">
                                <option value="">All Zones</option>
                                <?php foreach (['Zone 1', 'Zone 2', 'Zone 3', 'Zone 4', 'Zone 5', 'Zone 6', 'Zone 7'] as $z): ?>
                                    <option <?= ($filters['zone'] ?? '') === $z ? 'selected' : '' ?>><?= $z ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:4px;">Gender</label>
                            <select name="gender" class="db-filter-select" style="width:100%;" onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="Male" <?= ($filters['gender'] ?? '') === 'Male'   ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= ($filters['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>

                        <!-- Age range -->
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:4px;">Age (Min)</label>
                            <input type="number" name="age_min" min="0" max="120"
                                value="<?= esc($filters['age_min'] ?? '') ?>"
                                placeholder="e.g. 18"
                                class="db-filter-select" style="width:100%;padding:8px 10px;"
                                onchange="this.form.submit()">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:4px;">Age (Max)</label>
                            <input type="number" name="age_max" min="0" max="120"
                                value="<?= esc($filters['age_max'] ?? '') ?>"
                                placeholder="e.g. 60"
                                class="db-filter-select" style="width:100%;padding:8px 10px;"
                                onchange="this.form.submit()">
                        </div>

                        <!-- Checkboxes -->
                        <div style="display:flex;flex-direction:column;gap:6px;">
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;margin-bottom:2px;">Special Groups</label>
                            <label style="display:flex;align-items:center;gap:6px;font-size:12.5px;cursor:pointer;">
                                <input type="checkbox" name="is_pwd" value="1" <?= !empty($filters['is_pwd']) ? 'checked' : '' ?> onchange="this.form.submit()"> PWD
                            </label>
                            <label style="display:flex;align-items:center;gap:6px;font-size:12.5px;cursor:pointer;">
                                <input type="checkbox" name="is_senior" value="1" <?= !empty($filters['is_senior']) ? 'checked' : '' ?> onchange="this.form.submit()"> Senior Citizen
                            </label>
                            <label style="display:flex;align-items:center;gap:6px;font-size:12.5px;cursor:pointer;">
                                <input type="checkbox" name="is_solo" value="1" <?= !empty($filters['is_solo']) ? 'checked' : '' ?> onchange="this.form.submit()"> Solo Parent
                            </label>
                        </div>

                        <div style="display:flex;flex-direction:column;gap:6px;">
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;margin-bottom:2px;">Programs / Status</label>
                            <label style="display:flex;align-items:center;gap:6px;font-size:12.5px;cursor:pointer;">
                                <input type="checkbox" name="is_4ps" value="1" <?= !empty($filters['is_4ps']) ? 'checked' : '' ?> onchange="this.form.submit()"> 4Ps Beneficiary
                            </label>
                            <label style="display:flex;align-items:center;gap:6px;font-size:12.5px;cursor:pointer;">
                                <input type="checkbox" name="is_student" value="1" <?= !empty($filters['is_student']) ? 'checked' : '' ?> onchange="this.form.submit()"> Has Student Member
                            </label>
                            <label style="display:flex;align-items:center;gap:6px;font-size:12.5px;cursor:pointer;">
                                <input type="checkbox" name="is_indigent" value="1" <?= !empty($filters['is_indigent']) ? 'checked' : '' ?> onchange="this.form.submit()"> Qualifies for Indigency <small style="color:#9aa0b4;">(≤₱5,000/mo)</small>
                            </label>
                        </div>

                        <!-- Clear filters -->
                        <div style="display:flex;align-items:flex-end;">
                            <a href="?" class="db-btn db-btn--outline" style="width:100%;justify-content:center;text-decoration:none;">
                                <i class="fas fa-times"></i> Clear Filters
                            </a>
                        </div>

                    </div>

                    <!-- Active filter chips -->
                    <?php if ($activeCount > 0): ?>
                        <div style="margin-top:12px;display:flex;flex-wrap:wrap;gap:6px;align-items:center;">
                            <span style="font-size:11.5px;color:#9aa0b4;font-weight:600;">Active:</span>
                            <?php
                            $chipLabels = [
                                'zone' => 'Zone: ',
                                'gender' => 'Gender: ',
                                'age_min' => 'Age ≥ ',
                                'age_max' => 'Age ≤ ',
                                'is_pwd' => 'PWD',
                                'is_senior' => 'Senior Citizen',
                                'is_solo' => 'Solo Parent',
                                'is_4ps' => '4Ps',
                                'is_student' => 'Has Student',
                                'is_indigent' => 'Indigency Eligible',
                            ];
                            foreach ($chipLabels as $key => $label):
                                if (empty($filters[$key])) continue;
                                $val = in_array($key, ['is_pwd', 'is_senior', 'is_solo', 'is_4ps', 'is_student', 'is_indigent']) ? '' : esc($filters[$key]);
                            ?>
                                <span style="background:#eef0fb;color:#1d2448;font-size:11.5px;font-weight:600;padding:3px 10px;border-radius:100px;border:1px solid #d0d8f5;">
                                    <?= $label . $val ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Stats row -->
            <div class="db-stats" style="margin-bottom:24px;">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,0.15);color:#16c79a;"><i class="fas fa-home"></i></div>
                    <div><span class="db-stat-num"><?= $totalHouseholds ?></span><span class="db-stat-label">Households</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,0.15);color:#ffc107;"><i class="fas fa-male"></i></div>
                    <div><span class="db-stat-num"><?= $totalMale ?></span><span class="db-stat-label">Male Heads</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(220,53,69,0.15);color:#dc3545;"><i class="fas fa-female"></i></div>
                    <div><span class="db-stat-num"><?= $totalFemale ?></span><span class="db-stat-label">Female Heads</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-wheelchair"></i></div>
                    <div><span class="db-stat-num"><?= $pwds ?></span><span class="db-stat-label">PWDs</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-hand-holding-heart"></i></div>
                    <div><span class="db-stat-num"><?= $fourPs ?></span><span class="db-stat-label">4P's</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-user-clock"></i></div>
                    <div><span class="db-stat-num"><?= $seniors ?></span><span class="db-stat-label">Senior Citizens</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-child"></i></div>
                    <div><span class="db-stat-num"><?= $soloParent ?></span><span class="db-stat-label">Solo Parents</span></div>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="db-alert db-alert--success" style="margin-bottom:16px;">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="db-alert db-alert--error" style="margin-bottom:16px;">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Table -->
            <?php
            $persons          = $persons          ?? [];
            $households       = $households       ?? [];
            $hasSpecialFilter = $hasSpecialFilter ?? false;
            $roleVal          = (string)(session()->get('role') ?? 'secretary');
            ?>

            <?php if ($hasSpecialFilter): ?>
                <!-- FILTER MODE: individual persons (head + members) -->
                <div style="background:#f0f4ff;border:1px solid #d0d8f5;border-radius:8px;padding:10px 16px;margin-bottom:12px;font-size:12.5px;color:#1d2448;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-filter"></i>
                    <strong>Filter results</strong> — showing matching individuals (household heads + members).
                    <a href="?" style="margin-left:auto;color:#c0392b;font-weight:600;text-decoration:none;"><i class="fas fa-times"></i> Clear filters</a>
                </div>
                <div class="db-table-wrap">
                    <table class="db-table">
                        <thead>
                            <tr>
                                <th>Household #</th>
                                <th>Name</th>
                                <th>Relationship</th>
                                <th>Date of Birth</th>
                                <th>Age</th>
                                <th>Occupation</th>
                                <th>Monthly Income</th>
                                <th>Zone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($persons)): ?>
                                <tr>
                                    <td colspan="9" style="text-align:center;padding:32px;color:#9aa0b4;">
                                        <i class="fas fa-search" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                        No records match the current filters.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $prevHH = null;
                                foreach ($persons as $p):
                                    $fn  = esc($p['last_name']) . ', ' . esc($p['first_name']);
                                    if (! empty($p['middle_name'])) $fn .= ' ' . esc($p['middle_name']);
                                    if (! empty($p['suffix']))      $fn .= ', ' . esc($p['suffix']);
                                    $ini    = strtoupper($p['first_name'][0] ?? '?');
                                    $dob    = ! empty($p['date_of_birth']) ? date('M d, Y', strtotime($p['date_of_birth'])) : '—';
                                    $age    = ! empty($p['date_of_birth']) ? (int)date_diff(date_create($p['date_of_birth']), date_create('today'))->y : '—';
                                    $isHead = $p['relationship'] === 'Household Head';
                                    $newHH  = $p['household_no'] !== $prevHH;
                                    $prevHH = $p['household_no'];
                                    $inc    = isset($p['monthly_income']) && $p['monthly_income'] > 0 ? '₱' . number_format($p['monthly_income'], 2) : '—';
                                ?>
                                    <tr style="<?= $isHead ? 'background:#f8f9ff;' : '' ?><?= ($newHH && !$isHead) ? 'border-top:2px solid #e8ecf4;' : '' ?>">
                                        <td><?php if ($isHead): ?><a href="/<?= $roleVal ?>/household/<?= esc($p['household_no']) ?>" style="font-weight:700;color:#1d2448;text-decoration:none;"><?= esc($p['household_no']) ?></a><?php else: ?><span style="color:#b0b6cc;font-size:12px;padding-left:10px;">└ <?= esc($p['household_no']) ?></span><?php endif; ?></td>
                                        <td>
                                            <div class="db-resident-name">
                                                <div class="db-avatar-sm" style="<?= $isHead ? '' : 'background:#6b7280;width:28px;height:28px;font-size:11px;' ?>"><?= $ini ?></div><span style="font-weight:<?= $isHead ? '600' : '400' ?>;"><?= $fn ?></span>
                                            </div>
                                        </td>
                                        <td><span class="hh-rel-badge" style="<?= $isHead ? 'background:#eef0fb;color:#1d2448;' : '' ?>"><?= esc(ucfirst($p['relationship'])) ?></span></td>
                                        <td><?= $dob ?></td>
                                        <td><?= $age ?></td>
                                        <td><?= esc($p['occupation'] ?? '—') ?></td>
                                        <td><?= $inc ?></td>
                                        <td><?= esc($p['zone'] ?? '—') ?></td>
                                        <td><?php if ($isHead): ?><div class="db-action-group"><a href="/<?= $roleVal ?>/household/<?= esc($p['household_no']) ?>" class="db-icon-btn db-icon-btn--view"><i class="fas fa-eye"></i></a>
                                                    <form action="/<?= $roleVal ?>/census/delete/<?= esc($p['household_no']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Delete household <?= esc($p['household_no']) ?>?')"><?= csrf_field() ?><button type="submit" class="db-icon-btn db-icon-btn--del"><i class="fas fa-trash"></i></button></form>
                                                </div><?php else: ?>—<?php endif; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <!-- DEFAULT MODE: household heads only -->
                <div class="db-table-wrap">
                    <table class="db-table" id="censusTable">
                        <thead>
                            <tr>
                                <th>Household #</th>
                                <th>Head of the Family</th>
                                <th>Date of Birth</th>
                                <th>Gender</th>
                                <th>Zone</th>
                                <th>Civil Status</th>
                                <th>Contact</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($households)): ?>
                                <tr>
                                    <td colspan="8" style="text-align:center;padding:32px;color:#9aa0b4;">
                                        <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                        No household records yet. Click <strong>Add Household</strong> to get started.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($households as $h):
                                    $fullName = esc($h['last_name']) . ', ' . esc($h['first_name']);
                                    $initial  = strtoupper($h['first_name'][0] ?? '?');
                                    $dob      = ! empty($h['date_of_birth']) ? date('M d, Y', strtotime($h['date_of_birth'])) : '—';
                                ?>
                                    <tr>
                                        <td><strong><?= esc($h['household_no']) ?></strong></td>
                                        <td><a href="/<?= $roleVal ?>/household/<?= esc($h['household_no']) ?>" class="hh-name-link">
                                                <div class="db-avatar-sm"><?= $initial ?></div><span><?= $fullName ?></span>
                                            </a></td>
                                        <td><?= $dob ?></td>
                                        <td><?= esc($h['gender']) ?></td>
                                        <td><?= esc($h['zone'] ?? '—') ?></td>
                                        <td><?= esc($h['civil_status']) ?></td>
                                        <td><?= esc($h['contact_number'] ?? '—') ?></td>
                                        <td>
                                            <div class="db-action-group">
                                                <a href="/<?= $roleVal ?>/household/<?= esc($h['household_no']) ?>" class="db-icon-btn db-icon-btn--view"><i class="fas fa-eye"></i></a>
                                                <button class="db-icon-btn db-icon-btn--edit"><i class="fas fa-edit"></i></button>
                                                <form action="/<?= $roleVal ?>/census/delete/<?= esc($h['household_no']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Delete household <?= esc($h['household_no']) ?>?')"><?= csrf_field() ?><button type="submit" class="db-icon-btn db-icon-btn--del"><i class="fas fa-trash"></i></button></form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <!-- Pagination -->
            <?php
            $displayTotal = $hasSpecialFilter ? $filteredTotal : ($totalHouseholdsFiltered ?? $totalHouseholds);
            $totalPages   = (int) ceil($displayTotal / $perPage);
            $start        = $displayTotal > 0 ? ($currentPage - 1) * $perPage + 1 : 0;
            $end          = min($currentPage * $perPage, $displayTotal);
            $qFilters     = $filters ?? [];
            unset($qFilters['page']);
            $qs = http_build_query(array_filter($qFilters, fn($v) => $v !== ''));
            $qs = $qs ? '&' . $qs : '';
            $label = $hasSpecialFilter ? 'person' : 'household';
            ?>
            <?php if ($displayTotal > 0): ?>
                <div class="db-pagination">
                    <span class="db-page-info">Showing <?= $start ?>–<?= $end ?> of <?= $displayTotal ?> <?= $label ?><?= $displayTotal !== 1 ? 's' : '' ?></span>
                    <div class="db-page-btns">
                        <a href="?page=<?= max(1, $currentPage - 1) ?><?= $qs ?>" class="db-page-btn <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <a href="?page=<?= $p ?><?= $qs ?>" class="db-page-btn <?= $p === $currentPage ? 'active' : '' ?>"><?= $p ?></a>
                        <?php endfor; ?>
                        <a href="?page=<?= min($totalPages, $currentPage + 1) ?><?= $qs ?>" class="db-page-btn <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            <?php elseif (($filters['search'] ?? '') !== '' || ($activeCount ?? 0) > 0): ?>
                <div style="text-align:center;padding:32px;color:#9aa0b4;">
                    <i class="fas fa-search" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                    No households match the current filters. <a href="?" style="color:#1d2448;font-weight:600;">Clear filters</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Household Modal — Paper Form Style -->
    <div class="db-modal-overlay" id="addModal">
        <div class="db-modal pf-modal">
            <form action="/<?= session()->get('role') ?>/census/store" method="post" id="censusForm">

                <!-- Modal header -->
                <div class="pf-modal-header">
                    <div class="pf-modal-title-wrap">
                        <div class="pf-modal-logo">
                            <img src="/bacolod.png" alt="Seal">
                        </div>
                        <div>
                            <div class="pf-modal-republic">Republic of the Philippines</div>
                            <div class="pf-modal-barangay">Barangay Bacolod, Bato, Camarines Sur</div>
                            <div class="pf-modal-formtitle">HOUSEHOLD CENSUS REGISTRATION FORM</div>
                        </div>
                    </div>
                    <button class="pf-close-btn" onclick="closeModal('addModal')"><i class="fas fa-times"></i></button>
                </div>

                <!-- Step tabs -->
                <div class="pf-tabs">
                    <button class="pf-tab active" id="tab1" onclick="arGoTo(1)">
                        <span class="pf-tab-num">1</span> Personal Information
                    </button>
                    <div class="pf-tab-sep"></div>
                    <button class="pf-tab" id="tab2" onclick="arGoTo(2)">
                        <span class="pf-tab-num">2</span> Family Information
                    </button>
                </div>

                <div class="pf-body">

                    <!-- ══ STEP 1: Personal Info ══ -->
                    <div class="ar-step-panel active" id="arStep1">
                        <?= csrf_field() ?>

                        <!-- Section: Household Head -->
                        <div class="pf-section">
                            <div class="pf-section-bar">
                                <i class="fas fa-user"></i> HOUSEHOLD HEAD — Personal Information
                            </div>

                            <!-- Name row -->
                            <div class="pf-field-row pf-cols-4">
                                <div class="pf-field">
                                    <div class="pf-field-label">Last Name</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="last_name" placeholder="DELA CRUZ" required>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">First Name</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="first_name" placeholder="JUAN" required>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Middle Name</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="middle_name" placeholder="SANTOS">
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Suffix (e.g. Jr)</div>
                                    <select class="pf-input" name="suffix">
                                        <option value="">— NONE —</option>
                                        <option>Jr</option>
                                        <option>Sr</option>
                                        <option>II</option>
                                        <option>III</option>
                                        <option>IV</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Details row -->
                            <div class="pf-field-row pf-cols-4">
                                <div class="pf-field">
                                    <div class="pf-field-label">Date of Birth (mm/dd/yyyy)</div>
                                    <div class="pf-date-wrap">
                                        <input type="date" class="pf-input pf-date-input" name="date_of_birth" required>
                                        <i class="fas fa-calendar-alt pf-date-icon"></i>
                                    </div>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Place of Birth</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="place_of_birth" placeholder="CITY/MUNICIPALITY" required>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Gender</div>
                                    <select class="pf-input" name="gender">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Civil Status</div>
                                    <select class="pf-input" name="civil_status">
                                        <option>Single</option>
                                        <option>Married</option>
                                        <option>Widowed</option>
                                        <option>Separated</option>
                                        <option>Annulled</option>
                                    </select>
                                </div>
                            </div>

                            <!-- More details -->
                            <div class="pf-field-row pf-cols-4">
                                <div class="pf-field">
                                    <div class="pf-field-label">Nationality</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="nationality" value="FILIPINO">
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Religion</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="religion" placeholder="E.G. ROMAN CATHOLIC">
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Occupation</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="occupation" placeholder="E.G. FARMER" required>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Monthly Income (₱)</div>
                                    <input type="number" class="pf-input" name="monthly_income" placeholder="0.00" min="0" step="0.01">
                                </div>
                            </div>

                            <div class="pf-field-row pf-cols-3">
                                <div class="pf-field">
                                    <div class="pf-field-label">Contact Number</div>
                                    <input type="text" class="pf-input" name="contact_number" placeholder="09XXXXXXXXX" maxlength="11" inputmode="numeric">
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Educational Attainment</div>
                                    <select class="pf-input" name="educational_attainment">
                                        <option value="">— Select —</option>
                                        <option>No Formal Education</option>
                                        <option>Elementary Level</option>
                                        <option>Elementary Graduate</option>
                                        <option>High School Level</option>
                                        <option>High School Graduate</option>
                                        <option>College Level</option>
                                        <option>College Graduate</option>
                                        <option>Vocational / Tech-Voc</option>
                                        <option>Post Graduate</option>
                                    </select required>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">PhilHealth Number</div>
                                    <input type="text" class="pf-input pf-philhealth" name="philhealth_no" placeholder="00000000000" maxlength="12" inputmode="numeric">
                                </div>

                                <div class="pf-field">
                                    <div class="pf-field-label">Are you a Registered Voter?</div>
                                    <div class="pf-radio-row" style="flex-direction:row;gap:20px;padding:8px 0;">
                                        <label class="pf-radio">
                                            <input type="radio" name="registered_voter" value="1"> <span>Yes</span>
                                        </label>
                                        <label class="pf-radio">
                                            <input type="radio" name="registered_voter" value="0"> <span>No</span>
                                        </label>
                                    </div required>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Classification -->
                        <div class="pf-section">
                            <div class="pf-section-bar">
                                <i class="fas fa-tags"></i> HOUSEHOLD CLASSIFICATION
                            </div>
                            <div class="pf-field-row pf-cols-4" style="align-items:center;">
                                <div class="pf-field">
                                    <div class="pf-field-label">Household No. <span style="font-size:9px;color:#16c79a;font-weight:700;">AUTO</span></div>
                                    <input type="text" class="pf-input" name="household_no" id="householdNo"
                                        readonly
                                        style="background:#f0f4ff;color:#1d2448;font-weight:700;letter-spacing:2px;cursor:default;">
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Zone / Purok</div>
                                    <select class="pf-input" name="zone">
                                        <option value="">— Select —</option required>>
                                        <option>Zone 1</option>
                                        <option>Zone 2</option>
                                        <option>Zone 3</option>
                                        <option>Zone 4</option>
                                        <option>Zone 5</option>
                                        <option>Zone 6</option>
                                        <option>Zone 7</option>
                                    </select>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Years of Residency</div>
                                    <input type="number" class="pf-input" name="years_of_residency" placeholder="0" min="0" required>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">House Ownership</div>
                                    <select class="pf-input" name="house_ownership">
                                        <option>Owned</option>
                                        <option>Rented</option>
                                        <option>Shared</option>
                                        <option>Informal Settler</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Checkboxes -->
                            <div class="pf-check-row">
                                <span class="pf-check-label">Household belongs to:</span>
                                <label class="pf-check"><input type="checkbox" name="is_4ps" value="1"> <span>4Ps Beneficiary</span></label>
                                <label class="pf-check"><input type="checkbox" name="is_pwd" value="1"> <span>PWD Member</span></label>
                                <label class="pf-check"><input type="checkbox" name="is_senior_citizen" value="1"> <span>Senior Citizen</span></label>
                                <label class="pf-check"><input type="checkbox" name="is_solo_parent" value="1"> <span>Solo Parent</span></label>
                                <label class="pf-check"><input type="checkbox" name="is_indigenous" value="1"> <span>Indigenous People</span></label>
                            </div>
                        </div>

                        <!-- Section: Water & Sanitation -->
                        <div class="pf-section">
                            <div class="pf-section-bar">
                                <i class="fas fa-tint"></i> ACCESS TO SAFE WATER &amp; SANITATION FACILITY
                            </div>

                            <!-- Water subsection -->
                            <div class="pf-subsection-label">
                                <i class="fas fa-water"></i> Access to Safe Water
                            </div>
                            <div class="pf-field-row pf-cols-2">
                                <div class="pf-field">
                                    <div class="pf-field-label">1. Basic Safe Water Source</div>
                                    <div class="pf-radio-row">
                                        <label class="pf-radio">
                                            <input type="radio" name="water_source" value="I">
                                            <span>Level I — Point Source (e.g. protected well, spring)</span>
                                        </label>
                                        <label class="pf-radio">
                                            <input type="radio" name="water_source" value="II">
                                            <span>Level II — Communal Faucet / Stand Post</span>
                                        </label>
                                        <label class="pf-radio">
                                            <input type="radio" name="water_source" value="III">
                                            <span>Level III — Individual House Connection (piped water)</span>
                                        </label>
                                        <label class="pf-radio">
                                            <input type="radio" name="water_source" value="none">
                                            <span>No Safe Water Source</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">2. Using Safety-Managed Water Service</div>
                                    <div class="pf-radio-row">
                                        <label class="pf-radio">
                                            <input type="radio" name="water_managed" value="yes">
                                            <span class="pf-radio-box"></span>
                                            <span>Yes — Water is safely managed</span>
                                        </label>
                                        <label class="pf-radio">
                                            <input type="radio" name="water_managed" value="no">
                                            <span class="pf-radio-box"></span>
                                            <span>No — Not safely managed</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Sanitation subsection -->
                            <div class="pf-subsection-label" style="border-top:1px solid #e8eaf0;">
                                <i class="fas fa-toilet"></i> Sanitation Facility
                            </div>
                            <div class="pf-field-row pf-cols-2">
                                <div class="pf-field">
                                    <div class="pf-field-label">1. Basic Sanitation Facility</div>
                                    <div class="pf-radio-row">
                                        <label class="pf-radio">
                                            <input type="radio" name="sanitation_basic" value="with">
                                            <span class="pf-radio-box"></span>
                                            <span>With Basic Sanitation Facility</span>
                                        </label>
                                        <label class="pf-radio">
                                            <input type="radio" name="sanitation_basic" value="without">
                                            <span class="pf-radio-box"></span>
                                            <span>Without Basic Sanitation Facility</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">2. Using Safely Managed Sanitation Services</div>
                                    <div class="pf-radio-row">
                                        <label class="pf-radio">
                                            <input type="radio" name="sanitation_managed" value="with">
                                            <span class="pf-radio-box"></span>
                                            <span>With Safely Managed Sanitation</span>
                                        </label>
                                        <label class="pf-radio">
                                            <input type="radio" name="sanitation_managed" value="without">
                                            <span class="pf-radio-box"></span>
                                            <span>Without Safely Managed Sanitation</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end step 1 -->

                    <!-- ══ STEP 2: Family Info ══ -->
                    <div class="ar-step-panel" id="arStep2">

                        <!-- Spouse -->
                        <div class="pf-section">
                            <div class="pf-section-bar">
                                <i class="fas fa-ring"></i> SPOUSE
                            </div>
                            <div class="pf-family-card">
                                <div class="pf-field-row pf-cols-4">
                                    <div class="pf-field">
                                        <div class="pf-field-label">Last Name</div>
                                        <input type="text" class="pf-input pf-upper pf-alpha" name="spouse_last_name" placeholder="LAST NAME">
                                    </div>
                                    <div class="pf-field">
                                        <div class="pf-field-label">First Name</div>
                                        <input type="text" class="pf-input pf-upper pf-alpha" name="spouse_first_name" placeholder="FIRST NAME">
                                    </div>
                                    <div class="pf-field">
                                        <div class="pf-field-label">Middle Name</div>
                                        <input type="text" class="pf-input pf-upper pf-alpha" name="spouse_middle_name" placeholder="MIDDLE NAME">
                                    </div>
                                    <div class="pf-field">
                                        <div class="pf-field-label">Suffix</div>
                                        <select class="pf-input" name="spouse_suffix">
                                            <option value="">— NONE —</option>
                                            <option>Jr</option>
                                            <option>Sr</option>
                                            <option>II</option>
                                            <option>III</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="pf-field-row pf-cols-4">
                                    <div class="pf-field">
                                        <div class="pf-field-label">Date of Birth</div>
                                        <div class="pf-date-wrap">
                                            <input type="date" class="pf-input pf-date-input" name="spouse_dob">
                                            <i class="fas fa-calendar-alt pf-date-icon"></i>
                                        </div>
                                    </div>
                                    <div class="pf-field">
                                        <div class="pf-field-label">Gender</div>
                                        <select class="pf-input" name="spouse_gender">
                                            <option value="">— Select —</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>
                                    <div class="pf-field">
                                        <div class="pf-field-label">Occupation</div>
                                        <input type="text" class="pf-input pf-upper pf-alpha" name="spouse_occupation" placeholder="E.G. HOUSEWIFE, TEACHER">
                                    </div>
                                    <div class="pf-field">
                                        <div class="pf-field-label">Monthly Income (₱)</div>
                                        <input type="number" class="pf-input" name="spouse_income" placeholder="0.00" min="0" step="0.01">
                                    </div>
                                </div>
                                <div class="pf-field-row pf-cols-3">
                                    <div class="pf-field">
                                        <div class="pf-field-label">Educational Attainment</div>
                                        <select class="pf-input" name="spouse_educational_attainment">
                                            <option value="">— Select —</option>
                                            <option>No Formal Education</option>
                                            <option>Elementary Level</option>
                                            <option>Elementary Graduate</option>
                                            <option>High School Level</option>
                                            <option>High School Graduate</option>
                                            <option>College Level</option>
                                            <option>College Graduate</option>
                                            <option>Vocational / Tech-Voc</option>
                                            <option>Post Graduate</option>
                                        </select>
                                    </div>
                                    <div class="pf-field">
                                        <div class="pf-field-label">PhilHealth Number</div>
                                        <input type="text" class="pf-input pf-philhealth" name="spouse_philhealth" placeholder="00000000000" maxlength="12" inputmode="numeric">
                                    </div>
                                    <div class="pf-field">
                                        <div class="pf-field-label">Registered Voter?</div>
                                        <div class="pf-radio-row" style="flex-direction:row;gap:20px;padding:8px 10px;">
                                            <label class="pf-radio"><input type="radio" name="spouse_registered_voter" value="1"> <span>Yes</span></label>
                                            <label class="pf-radio"><input type="radio" name="spouse_registered_voter" value="0" checked> <span>No</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Children -->
                        <div class="pf-section">
                            <div class="pf-section-bar" style="display:flex;align-items:center;justify-content:space-between;">
                                <span><i class="fas fa-child"></i> CHILD(REN)</span>
                                <button type="button" class="pf-add-row-btn" onclick="addChildRow()">
                                    <i class="fas fa-plus"></i> Add Row
                                </button>
                            </div>
                            <div id="childrenRows">
                                <div class="pf-member-card">
                                    <div class="pf-member-card-inner">
                                        <div class="pf-member-fields">
                                            <div class="pf-field pf-field--inline">
                                                <div class="pf-field-label">Last Name</div>
                                                <input type="text" class="pf-input pf-upper pf-alpha" name="child_last_name[]" placeholder="LAST NAME">
                                            </div>
                                            <div class="pf-field pf-field--inline">
                                                <div class="pf-field-label">First Name</div>
                                                <input type="text" class="pf-input pf-upper pf-alpha" name="child_first_name[]" placeholder="FIRST NAME">
                                            </div>
                                            <div class="pf-field pf-field--inline">
                                                <div class="pf-field-label">Middle Name</div>
                                                <input type="text" class="pf-input pf-upper pf-alpha" name="child_middle_name[]" placeholder="MIDDLE NAME">
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--xs">
                                                <div class="pf-field-label">Suffix</div>
                                                <select class="pf-input" name="child_suffix[]">
                                                    <option value="">—NONE—</option>
                                                    <option>Jr</option>
                                                    <option>Sr</option>
                                                    <option>II</option>
                                                    <option>III</option>
                                                </select>
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--sm">
                                                <div class="pf-field-label">Date of Birth</div>
                                                <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="child_dob[]"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--xs">
                                                <div class="pf-field-label">Gender</div>
                                                <select class="pf-input" name="child_gender[]">
                                                    <option value="">—Select—</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                </select>
                                            </div>
                                            <div class="pf-field pf-field--inline">
                                                <div class="pf-field-label">Occupation</div>
                                                <div class="pf-occ-wrap">
                                                    <div class="pf-occ-pills">
                                                        <button type="button" class="pf-occ-pill" data-val="STUDENT" onclick="setOcc(this,'STUDENT')">Student</button>
                                                        <button type="button" class="pf-occ-pill" data-val="OUT OF SCHOOL" onclick="setOcc(this,'OUT OF SCHOOL')">Out of School</button>
                                                    </div>
                                                    <input type="text" class="pf-input pf-upper pf-alpha" name="child_occupation[]" placeholder="OR TYPE EXACT OCCUPATION">
                                                    <div class="pf-grade-wrap">
                                                        <div class="pf-grade-label">Current Grade / Year</div>
                                                        <select class="pf-input" name="child_grade[]">
                                                            <option value="">— Select Grade / Year —</option>
                                                            <optgroup label="Elementary">
                                                                <option>Grade 1</option>
                                                                <option>Grade 2</option>
                                                                <option>Grade 3</option>
                                                                <option>Grade 4</option>
                                                                <option>Grade 5</option>
                                                                <option>Grade 6</option>
                                                            </optgroup>
                                                            <optgroup label="Junior High School">
                                                                <option>Grade 7</option>
                                                                <option>Grade 8</option>
                                                                <option>Grade 9</option>
                                                                <option>Grade 10</option>
                                                            </optgroup>
                                                            <optgroup label="Senior High School">
                                                                <option>Grade 11</option>
                                                                <option>Grade 12</option>
                                                            </optgroup>
                                                            <optgroup label="College / University">
                                                                <option>1st Year College</option>
                                                                <option>2nd Year College</option>
                                                                <option>3rd Year College</option>
                                                                <option>4th Year College</option>
                                                                <option>5th Year College</option>
                                                            </optgroup>
                                                            <optgroup label="Vocational / Technical">
                                                                <option>1st Year Tech-Voc</option>
                                                                <option>2nd Year Tech-Voc</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--sm">
                                                <div class="pf-field-label">Monthly Income (₱)</div>
                                                <input type="number" class="pf-input" name="child_income[]" placeholder="0.00" min="0" step="0.01">
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--sm">
                                                <div class="pf-field-label">PhilHealth No.</div>
                                                <input type="text" class="pf-input pf-philhealth" name="child_philhealth[]" placeholder="00000000000" maxlength="12" inputmode="numeric">
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--sm">
                                                <div class="pf-field-label">Voter?</div>
                                                <div style="display:flex;gap:12px;padding:7px 10px;">
                                                    <label class="pf-radio"><input type="radio" name="child_voter[0]" value="1"> <span>Yes</span></label>
                                                    <label class="pf-radio"><input type="radio" name="child_voter[0]" value="0" checked> <span>No</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="pf-member-del" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Other Household Members -->
                        <div class="pf-section">
                            <div class="pf-section-bar" style="display:flex;align-items:center;justify-content:space-between;">
                                <span><i class="fas fa-users"></i> OTHER HOUSEHOLD MEMBERS <em style="font-weight:400;">(other than Spouse/Children)</em></span>
                                <button type="button" class="pf-add-row-btn" onclick="addOtherRow()">
                                    <i class="fas fa-plus"></i> Add Row
                                </button>
                            </div>
                            <div id="otherRows">
                                <div class="pf-member-card">
                                    <div class="pf-member-card-inner">
                                        <div class="pf-member-fields">
                                            <div class="pf-field pf-field--inline">
                                                <div class="pf-field-label">Last Name</div>
                                                <input type="text" class="pf-input pf-upper pf-alpha" name="other_last_name[]" placeholder="LAST NAME">
                                            </div>
                                            <div class="pf-field pf-field--inline">
                                                <div class="pf-field-label">First Name</div>
                                                <input type="text" class="pf-input pf-upper pf-alpha" name="other_first_name[]" placeholder="FIRST NAME">
                                            </div>
                                            <div class="pf-field pf-field--inline">
                                                <div class="pf-field-label">Middle Name</div>
                                                <input type="text" class="pf-input pf-upper pf-alpha" name="other_middle_name[]" placeholder="MIDDLE NAME">
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--xs">
                                                <div class="pf-field-label">Suffix</div>
                                                <select class="pf-input" name="other_suffix[]">
                                                    <option value="">—NONE—</option>
                                                    <option>Jr</option>
                                                    <option>Sr</option>
                                                    <option>II</option>
                                                    <option>III</option>
                                                </select>
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--sm">
                                                <div class="pf-field-label">Date of Birth</div>
                                                <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="other_dob[]"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--xs">
                                                <div class="pf-field-label">Gender</div>
                                                <select class="pf-input" name="other_gender[]">
                                                    <option value="">—Select—</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                </select>
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--sm">
                                                <div class="pf-field-label">Relationship</div>
                                                <select class="pf-input" name="other_relationship[]">
                                                    <option value="">— Select —</option>
                                                    <option>Father</option>
                                                    <option>Mother</option>
                                                    <option>Sibling</option>
                                                    <option>Grandparent</option>
                                                    <option>Grandchild</option>
                                                    <option>Aunt/Uncle</option>
                                                    <option>Cousin</option>
                                                    <option>Other Relative</option>
                                                    <option>Non-relative</option>
                                                </select>
                                            </div>
                                            <div class="pf-field pf-field--inline pf-field--sm">
                                                <div class="pf-field-label">Voter?</div>
                                                <div style="display:flex;gap:12px;padding:7px 10px;">
                                                    <label class="pf-radio"><input type="radio" name="other_voter[0]" value="1"> <span>Yes</span></label>
                                                    <label class="pf-radio"><input type="radio" name="other_voter[0]" value="0" checked> <span>No</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="pf-member-del" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Certification line -->
                        <div class="pf-cert-box">
                            <p>I hereby certify that the information provided above is true and correct to the best of my knowledge.</p>
                            <div class="pf-cert-date-only">
                                <div class="pf-cert-recorded-label">Date of Transaction</div>
                                <div class="pf-date-wrap" style="border-bottom:1px solid #333; display:inline-flex; min-width:180px;">
                                    <input type="date" class="pf-input pf-date-input pf-cert-date-input" id="recordedDate" name="recorded_date" style="background:transparent;border:none;padding:4px 32px 4px 0;font-size:13px;">
                                    <i class="fas fa-calendar-alt pf-date-icon" style="color:#1d2448;"></i>
                                </div>
                            </div>
                        </div>

                    </div><!-- end step 2 -->

                </div><!-- end pf-body -->

                <!-- Footer -->
                <div class="pf-footer">
                    <button class="pf-btn pf-btn--outline" type="button" id="arPrevBtn" onclick="arPrev()" style="display:none;">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <div style="flex:1;"></div>
                    <button class="pf-btn pf-btn--outline" type="button" onclick="closeModal('addModal')">Cancel</button>
                    <button class="pf-btn pf-btn--primary" id="arSaveBtn" type="submit" style="display:none;">
                        <i class="fas fa-save"></i> Save Record
                    </button>
                    <button class="pf-btn pf-btn--primary" id="arNextBtn" type="button" onclick="arNext()">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('#censusTable tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }

        function openModal(id) {
            document.getElementById(id).classList.add('active');
            arGoTo(1);
            // Auto-set recorded date to today
            const today = new Date().toISOString().split('T')[0];
            const dateEl = document.getElementById('recordedDate');
            if (dateEl) dateEl.value = today;
            // Generate a unique 5-digit household number
            const hhNo = String(Math.floor(10000 + Math.random() * 90000));
            document.getElementById('householdNo').value = hhNo;
            // Init family numbers
            updateFamilyNumbers();
        }

        function updateFamilyNumbers() {
            const hhNo = document.getElementById('householdNo').value || '00000';
            const n = Math.max(1, Math.min(20, parseInt(document.getElementById('numFamilies').value) || 1));
            const wrap = document.getElementById('familyNumbersWrap');
            const inp = document.getElementById('familyNumbersInputs');
            wrap.innerHTML = '';
            inp.innerHTML = '';
            for (let i = 1; i <= n; i++) {
                const code = hhNo + '-F' + i;
                // Badge chip
                const chip = document.createElement('span');
                chip.style.cssText = 'background:#eef0fb;color:#1d2448;font-size:11px;font-weight:700;padding:3px 10px;border-radius:100px;border:1px solid #d0d8f5;letter-spacing:.5px;';
                chip.textContent = code;
                wrap.appendChild(chip);
                // Hidden input
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'family_numbers[]';
                hidden.value = code;
                inp.appendChild(hidden);
            }
        }

        function toggleFilters() {
            const panel = document.getElementById('filterPanel');
            panel.style.display = panel.style.display === 'none' ? '' : 'none';
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        let arCurrentStep = 1;
        const arTotalSteps = 2;

        function arGoTo(step) {
            arCurrentStep = step;
            document.querySelectorAll('.ar-step-panel').forEach((p, i) => p.classList.toggle('active', i + 1 === step));
            // Update tab styles
            document.getElementById('tab1').classList.toggle('active', step === 1);
            document.getElementById('tab2').classList.toggle('active', step === 2);
            document.getElementById('arPrevBtn').style.display = step > 1 ? '' : 'none';
            document.getElementById('arNextBtn').style.display = step < arTotalSteps ? '' : 'none';
            document.getElementById('arSaveBtn').style.display = step === arTotalSteps ? '' : 'none';
        }

        function arNext() {
            if (arCurrentStep < arTotalSteps) arGoTo(arCurrentStep + 1);
        }

        function arPrev() {
            if (arCurrentStep > 1) arGoTo(arCurrentStep - 1);
        }

        let _childIdx = 1;
        let _otherIdx = 1;

        function childRowHTML() {
            const i = _childIdx++;
            return `<div class="pf-member-card">
                <div class="pf-member-card-inner">
                    <div class="pf-member-fields">
                        <div class="pf-field pf-field--inline">
                            <div class="pf-field-label">Last Name</div>
                            <input type="text" class="pf-input pf-upper pf-alpha" name="child_last_name[]" placeholder="LAST NAME">
                        </div>
                        <div class="pf-field pf-field--inline">
                            <div class="pf-field-label">First Name</div>
                            <input type="text" class="pf-input pf-upper pf-alpha" name="child_first_name[]" placeholder="FIRST NAME">
                        </div>
                        <div class="pf-field pf-field--inline">
                            <div class="pf-field-label">Middle Name</div>
                            <input type="text" class="pf-input pf-upper pf-alpha" name="child_middle_name[]" placeholder="MIDDLE NAME">
                        </div>
                        <div class="pf-field pf-field--inline pf-field--xs">
                            <div class="pf-field-label">Suffix</div>
                            <select class="pf-input" name="child_suffix[]"><option value="">—NONE—</option><option>Jr</option><option>Sr</option><option>II</option><option>III</option></select>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Date of Birth</div>
                            <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="child_dob[]"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--xs">
                            <div class="pf-field-label">Gender</div>
                            <select class="pf-input" name="child_gender[]"><option value="">—Select—</option><option>Male</option><option>Female</option></select>
                        </div>
                        <div class="pf-field pf-field--inline">
                            <div class="pf-field-label">Occupation</div>
                            <div class="pf-occ-wrap">
                                <div class="pf-occ-pills">
                                    <button type="button" class="pf-occ-pill" data-val="STUDENT" onclick="setOcc(this,'STUDENT')">Student</button>
                                    <button type="button" class="pf-occ-pill" data-val="OUT OF SCHOOL" onclick="setOcc(this,'OUT OF SCHOOL')">Out of School</button>
                                </div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="child_occupation[]" placeholder="OR TYPE EXACT OCCUPATION">
                                <div class="pf-grade-wrap">
                                    <div class="pf-grade-label">Current Grade / Year</div>
                                    <select class="pf-input" name="child_grade[]">
                                        <option value="">— Select Grade / Year —</option>
                                        <optgroup label="Elementary"><option>Grade 1</option><option>Grade 2</option><option>Grade 3</option><option>Grade 4</option><option>Grade 5</option><option>Grade 6</option></optgroup>
                                        <optgroup label="Junior High School"><option>Grade 7</option><option>Grade 8</option><option>Grade 9</option><option>Grade 10</option></optgroup>
                                        <optgroup label="Senior High School"><option>Grade 11</option><option>Grade 12</option></optgroup>
                                        <optgroup label="College / University"><option>1st Year College</option><option>2nd Year College</option><option>3rd Year College</option><option>4th Year College</option><option>5th Year College</option></optgroup>
                                        <optgroup label="Vocational / Technical"><option>1st Year Tech-Voc</option><option>2nd Year Tech-Voc</option></optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Monthly Income (₱)</div>
                            <input type="number" class="pf-input" name="child_income[]" placeholder="0.00" min="0" step="0.01">
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">PhilHealth No.</div>
                            <input type="text" class="pf-input pf-philhealth" name="child_philhealth[]" placeholder="00000000000" maxlength="12" inputmode="numeric">
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Voter?</div>
                            <div style="display:flex;gap:12px;padding:7px 10px;">
                                <label class="pf-radio"><input type="radio" name="child_voter[${i}]" value="1"> <span>Yes</span></label>
                                <label class="pf-radio"><input type="radio" name="child_voter[${i}]" value="0" checked> <span>No</span></label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="pf-member-del" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                </div>
            </div>`;
        }

        function otherRowHTML() {
            const i = _otherIdx++;
            return `<div class="pf-member-card">
                <div class="pf-member-card-inner">
                    <div class="pf-member-fields">
                        <div class="pf-field pf-field--inline">
                            <div class="pf-field-label">Last Name</div>
                            <input type="text" class="pf-input pf-upper pf-alpha" name="other_last_name[]" placeholder="LAST NAME">
                        </div>
                        <div class="pf-field pf-field--inline">
                            <div class="pf-field-label">First Name</div>
                            <input type="text" class="pf-input pf-upper pf-alpha" name="other_first_name[]" placeholder="FIRST NAME">
                        </div>
                        <div class="pf-field pf-field--inline">
                            <div class="pf-field-label">Middle Name</div>
                            <input type="text" class="pf-input pf-upper pf-alpha" name="other_middle_name[]" placeholder="MIDDLE NAME">
                        </div>
                        <div class="pf-field pf-field--inline pf-field--xs">
                            <div class="pf-field-label">Suffix</div>
                            <select class="pf-input" name="other_suffix[]"><option value="">—NONE—</option><option>Jr</option><option>Sr</option><option>II</option><option>III</option></select>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Date of Birth</div>
                            <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="other_dob[]"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--xs">
                            <div class="pf-field-label">Gender</div>
                            <select class="pf-input" name="other_gender[]"><option value="">—Select—</option><option>Male</option><option>Female</option></select>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Relationship</div>
                            <select class="pf-input" name="other_relationship[]"><option value="">— Select —</option><option>Father</option><option>Mother</option><option>Sibling</option><option>Grandparent</option><option>Grandchild</option><option>Aunt/Uncle</option><option>Cousin</option><option>Other Relative</option><option>Non-relative</option></select>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Voter?</div>
                            <div style="display:flex;gap:12px;padding:7px 10px;">
                                <label class="pf-radio"><input type="radio" name="other_voter[${i}]" value="1"> <span>Yes</span></label>
                                <label class="pf-radio"><input type="radio" name="other_voter[${i}]" value="0" checked> <span>No</span></label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="pf-member-del" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                </div>
            </div>`;
        }

        function addChildRow() {
            document.getElementById('childrenRows').insertAdjacentHTML('beforeend', childRowHTML());
        }

        function addOtherRow() {
            document.getElementById('otherRows').insertAdjacentHTML('beforeend', otherRowHTML());
        }

        function removeRow(btn) {
            btn.closest('.pf-member-card').remove();
        }

        // Occupation quick-pick for children rows
        function setOcc(btn, value) {
            const wrap = btn.closest('.pf-occ-wrap');
            const input = wrap.querySelector('input[name="child_occupation[]"]');
            const pills = wrap.querySelectorAll('.pf-occ-pill');
            const alreadyActive = btn.classList.contains('active');

            pills.forEach(p => p.classList.remove('active'));
            if (alreadyActive) {
                input.value = '';
            } else {
                btn.classList.add('active');
                input.value = value;
            }
            input.dispatchEvent(new Event('input'));
            toggleGradeField(wrap, input.value);
        }

        function toggleGradeField(wrap, occValue) {
            const gradeWrap = wrap.querySelector('.pf-grade-wrap');
            if (!gradeWrap) return;
            const isStudent = occValue.trim().toUpperCase() === 'STUDENT';
            gradeWrap.classList.toggle('visible', isStudent);
        }

        // Deactivate pill + show/hide grade field when user manually types
        document.addEventListener('input', function(e) {
            if (e.target.name === 'child_occupation[]') {
                const wrap = e.target.closest('.pf-occ-wrap');
                if (!wrap) return;
                const val = e.target.value.trim().toUpperCase();
                wrap.querySelectorAll('.pf-occ-pill').forEach(p => {
                    p.classList.toggle('active', p.dataset.val === val || p.textContent.trim().toUpperCase() === val);
                });
                toggleGradeField(wrap, val);
            }
        });

        // ── Form submit: force uppercase + Solo Parent validation ───────────
        document.getElementById('censusForm').addEventListener('submit', function(e) {
            // Solo Parent requires at least one child
            const isSoloParent = document.querySelector('input[name="is_solo_parent"]')?.checked;
            if (isSoloParent) {
                const childRows = document.querySelectorAll('#childrenRows .pf-member-card');
                const hasChild = Array.from(childRows).some(row => {
                    const lastName = row.querySelector('input[name="child_last_name[]"]');
                    return lastName && lastName.value.trim() !== '';
                });
                if (!hasChild) {
                    e.preventDefault();
                    // Switch to Step 2 so the user sees the children section
                    arGoTo(2);
                    // Highlight the children section
                    const childSection = document.getElementById('childrenRows').closest('.pf-section');
                    if (childSection) {
                        childSection.style.outline = '2px solid #c0392b';
                        childSection.style.borderRadius = '6px';
                        setTimeout(() => {
                            childSection.style.outline = '';
                        }, 3000);
                        childSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                    // Show inline error
                    let errEl = document.getElementById('soloParentError');
                    if (!errEl) {
                        errEl = document.createElement('div');
                        errEl.id = 'soloParentError';
                        errEl.style.cssText = 'background:#fff0f1;border:1px solid #fad4d4;border-radius:8px;padding:10px 14px;font-size:12.5px;color:#c0392b;display:flex;align-items:center;gap:8px;margin-bottom:12px;';
                        errEl.innerHTML = '<i class="fas fa-exclamation-triangle"></i> <span>A <strong>Solo Parent</strong> record requires at least one child. Please add the child\'s information in the Child(ren) section below.</span>';
                        const childrenSection = document.getElementById('childrenRows').closest('.pf-section');
                        childrenSection.insertAdjacentElement('beforebegin', errEl);
                    }
                    return;
                }
            }
            // Remove any solo parent error if validation passes
            const errEl = document.getElementById('soloParentError');
            if (errEl) errEl.remove();

            // Force uppercase on all text inputs
            document.querySelectorAll('#censusForm input[type="text"]').forEach(function(f) {
                f.value = f.value.toUpperCase();
            });
        });

        // ── Highlight children section when Solo Parent is checked ───────
        document.addEventListener('change', function(e) {
            if (e.target.name === 'is_solo_parent') {
                const childSection = document.getElementById('childrenRows').closest('.pf-section');
                const sectionBar = childSection ? childSection.querySelector('.pf-section-bar') : null;
                if (e.target.checked) {
                    if (sectionBar) {
                        sectionBar.style.background = 'linear-gradient(90deg,#c0392b,#e74c3c)';
                        sectionBar.innerHTML = sectionBar.innerHTML.replace(
                            /CHILD\(REN\)/,
                            'CHILD(REN) <span style="font-size:10px;background:rgba(255,255,255,.2);padding:2px 8px;border-radius:10px;margin-left:6px;font-weight:400;">Required for Solo Parent</span>'
                        );
                    }
                } else {
                    if (sectionBar) {
                        sectionBar.style.background = '';
                        // Restore original text
                        sectionBar.innerHTML = sectionBar.innerHTML.replace(
                            / <span[^>]*>Required for Solo Parent<\/span>/g, ''
                        );
                    }
                    const errEl = document.getElementById('soloParentError');
                    if (errEl) errEl.remove();
                }
            }
        });

        // Live uppercase as user types + PhilHealth numbers only + alpha-only fields
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('pf-upper')) {
                const pos = e.target.selectionStart;
                e.target.value = e.target.value.toUpperCase();
                e.target.setSelectionRange(pos, pos);
            }
            if (e.target.classList.contains('pf-philhealth')) {
                e.target.value = e.target.value.replace(/\D/g, '');
            }
            if (e.target.classList.contains('pf-alpha')) {
                // Allow letters, spaces, hyphens, periods, apostrophes (for names like O'Brien, Jr.)
                const pos = e.target.selectionStart;
                e.target.value = e.target.value.replace(/[^A-Za-zÀ-ÖØ-öø-ÿ\s\-'.]/g, '');
                e.target.setSelectionRange(pos, pos);
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.target.classList.contains('pf-philhealth')) {
                const allowed = [8, 9, 13, 27, 46, 37, 38, 39, 40, 35, 36];
                if ((e.ctrlKey || e.metaKey) && [65, 67, 86, 88].includes(e.keyCode)) return;
                if (allowed.includes(e.keyCode)) return;
                if (e.key < '0' || e.key > '9') e.preventDefault();
            }
            if (e.target.classList.contains('pf-alpha')) {
                // Allow: control keys, backspace, delete, arrows, tab, etc.
                if (e.ctrlKey || e.metaKey || e.altKey) return;
                const allowed = [8, 9, 13, 27, 32, 37, 38, 39, 40, 35, 36, 45, 46];
                if (allowed.includes(e.keyCode)) return;
                // Block digit keys (0-9)
                if (e.key >= '0' && e.key <= '9') e.preventDefault();
            }
        });

        document.querySelectorAll('.db-nav-item').forEach(i => i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open')));

        function exportPdf() {
            // Pass ALL active filters — export exactly what's currently on screen
            const role = '<?= session()->get('role') ?>';
            const params = new URLSearchParams(window.location.search);
            params.delete('page'); // export all pages, not just current
            const qs = params.toString() ? '?' + params.toString() : '';
            window.open('/' + role + '/census/export/pdf' + qs, '_blank');
        }
    </script>
</body>

</html>