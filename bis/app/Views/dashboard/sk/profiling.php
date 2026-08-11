<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Youth Profiling - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role      = 'sk';
    $active    = 'profiling';
    $pageTitle = 'SK Youth Profiling';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $youth       = $youth       ?? [];
    $stats       = $stats       ?? ['total' => 0, 'male' => 0, 'female' => 0, 'students' => 0, 'oos' => 0];
    $total       = $total       ?? 0;
    $perPage     = $perPage     ?? 15;
    $currentPage = $currentPage ?? 1;
    $search      = $search      ?? '';
    $ageFilter   = $ageFilter   ?? '';
    $gender      = $gender      ?? '';
    $status      = $status      ?? '';
    $zone        = $zone        ?? '';
    $civil       = $civil       ?? '';

    $activeCount = 0;
    foreach (['age' => $ageFilter, 'gender' => $gender, 'status' => $status, 'zone' => $zone, 'civil' => $civil] as $v) {
        if ($v !== '') $activeCount++;
    }

    $statusBadge = [
        'Student'       => 'background:#f0faf6;color:#1a7a55;border:1px solid #c3e8d8;',
        'Employed'      => 'background:#eef0fb;color:#1d2448;border:1px solid #d0d8f5;',
        'Unemployed'    => 'background:#fff8f0;color:#b7600a;border:1px solid #fde8c8;',
        'Out-of-School' => 'background:#fff0f1;color:#c0392b;border:1px solid #fad4d4;',
    ];
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

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

            <!-- Stats -->
            <div class="db-stats" style="margin-bottom:24px;">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-users"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['total']) ?></span><span class="db-stat-label">Total Youth (15–30)</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-male"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['male']) ?></span><span class="db-stat-label">Male</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(220,53,69,0.15);color:#dc3545;"><i class="fas fa-female"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['female']) ?></span><span class="db-stat-label">Female</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,0.15);color:#16c79a;"><i class="fas fa-graduation-cap"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['students']) ?></span><span class="db-stat-label">Students</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,0.15);color:#e6a800;"><i class="fas fa-user-times"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['oos']) ?></span><span class="db-stat-label">Out-of-School</span></div>
                </div>
            </div>

            <!-- Toolbar + Filter Form -->
            <form method="get" action="" id="filterForm">
                <div class="db-toolbar">
                    <div class="db-search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Search by name or contact..."
                            value="<?= esc($search) ?>"
                            onchange="document.getElementById('filterForm').submit()">
                    </div>
                    <div class="db-toolbar-actions">
                        <button class="db-btn db-btn--outline" type="button" onclick="toggleSkFilters()">
                            <i class="fas fa-filter"></i> Filters
                            <?php if ($activeCount > 0): ?>
                                <span style="background:#c0392b;color:#fff;border-radius:100px;padding:1px 7px;font-size:11px;margin-left:4px;"><?= $activeCount ?></span>
                            <?php endif; ?>
                        </button>
                        <?php if ($search !== '' || $activeCount > 0): ?>
                            <a href="/sk/profiling" class="db-btn db-btn--outline">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Expandable filter panel -->
                <div id="skFilterPanel" style="<?= $activeCount > 0 ? '' : 'display:none;' ?> background:#fff;border:1px solid #e2e5ef;border-radius:10px;padding:16px 20px;margin-bottom:16px;">
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px;align-items:end;">

                        <!-- Zone -->
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:4px;">Zone</label>
                            <select name="zone" class="db-filter-select" style="width:100%;" onchange="this.form.submit()">
                                <option value="">All Zones</option>
                                <?php foreach (['Zone 1', 'Zone 2', 'Zone 3', 'Zone 4', 'Zone 5', 'Zone 6', 'Zone 7'] as $z): ?>
                                    <option <?= $zone === $z ? 'selected' : '' ?>><?= $z ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Age Group -->
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:4px;">Age Group</label>
                            <select name="age" class="db-filter-select" style="width:100%;" onchange="this.form.submit()">
                                <option value="">All Ages</option>
                                <option value="15-17" <?= $ageFilter === '15-17' ? 'selected' : '' ?>>15–17 (Child Youth)</option>
                                <option value="18-24" <?= $ageFilter === '18-24' ? 'selected' : '' ?>>18–24 (Core Youth)</option>
                                <option value="25-30" <?= $ageFilter === '25-30' ? 'selected' : '' ?>>25–30 (Young Adult)</option>
                            </select>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:4px;">Gender</label>
                            <select name="gender" class="db-filter-select" style="width:100%;" onchange="this.form.submit()">
                                <option value="">All Genders</option>
                                <option value="Male" <?= $gender === 'Male'   ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= $gender === 'Female' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:4px;">Status</label>
                            <select name="status" class="db-filter-select" style="width:100%;" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="Student" <?= $status === 'Student'       ? 'selected' : '' ?>>Student</option>
                                <option value="Employed" <?= $status === 'Employed'      ? 'selected' : '' ?>>Employed</option>
                                <option value="Unemployed" <?= $status === 'Unemployed'    ? 'selected' : '' ?>>Unemployed</option>
                                <option value="Out-of-School" <?= $status === 'Out-of-School' ? 'selected' : '' ?>>Out-of-School</option>
                            </select>
                        </div>

                        <!-- Civil Status -->
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:4px;">Civil Status</label>
                            <select name="civil" class="db-filter-select" style="width:100%;" onchange="this.form.submit()">
                                <option value="">All</option>
                                <?php foreach (['Single', 'Married', 'Widowed', 'Separated', 'Annulled'] as $cs): ?>
                                    <option <?= $civil === $cs ? 'selected' : '' ?>><?= $cs ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Clear button -->
                        <div style="display:flex;align-items:flex-end;">
                            <a href="/sk/profiling" class="db-btn db-btn--outline" style="width:100%;justify-content:center;text-decoration:none;">
                                <i class="fas fa-times"></i> Clear Filters
                            </a>
                        </div>

                    </div>

                    <!-- Active filter chips -->
                    <?php if ($activeCount > 0): ?>
                        <div style="margin-top:12px;display:flex;flex-wrap:wrap;gap:6px;align-items:center;">
                            <span style="font-size:11.5px;color:#9aa0b4;font-weight:600;">Active:</span>
                            <?php
                            $chipMap = [
                                'Zone: '         => $zone,
                                'Age: '          => $ageFilter,
                                'Gender: '       => $gender,
                                'Status: '       => $status,
                                'Civil Status: ' => $civil,
                            ];
                            foreach ($chipMap as $label => $val):
                                if ($val === '') continue;
                            ?>
                                <span style="background:#eef0fb;color:#1d2448;font-size:11.5px;font-weight:600;padding:3px 10px;border-radius:100px;border:1px solid #d0d8f5;">
                                    <?= $label . esc($val) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Table -->
            <div class="db-table-wrap">
                <table class="db-table" id="youthTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Age</th>
                            <th>Birthday</th>
                            <th>Gender</th>
                            <th>Zone</th>
                            <th>Civil Status</th>
                            <th>Status</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($youth)): ?>
                            <tr>
                                <td colspan="10" style="text-align:center;padding:40px;color:#9aa0b4;">
                                    <i class="fas fa-users" style="font-size:28px;display:block;margin-bottom:10px;color:#d0d5e8;"></i>
                                    <?= ($search || $ageFilter || $gender || $status)
                                        ? 'No youth records match the current filters.'
                                        : 'No household members aged 15–30 found in the census.' ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($youth as $i => $y):
                                $num     = str_pad(($currentPage - 1) * $perPage + $i + 1, 3, '0', STR_PAD_LEFT);
                                $name    = esc($y['last_name']) . ', ' . esc($y['first_name']);
                                if (! empty($y['middle_name'])) $name .= ' ' . esc(substr($y['middle_name'], 0, 1)) . '.';
                                $initial = strtoupper($y['first_name'][0] ?? '?');
                                $dob     = ! empty($y['date_of_birth']) ? date('M d, Y', strtotime($y['date_of_birth'])) : '—';
                                $badge   = $statusBadge[$y['economic_status'] ?? ''] ?? 'background:#f0f2f8;color:#6b7280;border:1px solid #e2e5ef;';
                            ?>
                                <tr>
                                    <td><strong><?= $num ?></strong></td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:9px;">
                                            <div class="db-avatar-sm"><?= $initial ?></div>
                                            <div>
                                                <div style="font-weight:500;"><?= $name ?></div>
                                                <div style="font-size:11px;color:#9aa0b4;"><?= $y['source'] === 'head' ? 'Household Head' : esc(ucfirst($y['relationship'] ?? 'Member')) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $y['age'] ?? '—' ?></td>
                                    <td><?= $dob ?></td>
                                    <td><?= esc($y['gender'] ?? '—') ?></td>
                                    <td><?= esc($y['zone'] ?? '—') ?></td>
                                    <td><?= esc($y['civil_status'] ?: '—') ?></td>
                                    <td>
                                        <span style="display:inline-flex;align-items:center;font-size:11.5px;font-weight:600;padding:3px 10px;border-radius:100px;<?= $badge ?>">
                                            <?= esc($y['economic_status'] ?? '—') ?>
                                        </span>
                                    </td>
                                    <td><?= esc($y['contact_number'] ?: '—') ?></td>
                                    <td>
                                        <div class="db-action-group">
                                            <a href="/sk/household/<?= esc($y['household_no']) ?>?source=<?= esc($y['source']) ?>&member_id=<?= $y['source'] === 'member' ? (int)$y['id'] : 0 ?>"
                                                class="db-icon-btn db-icon-btn--view" title="View Youth Profile">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php
            $totalPages = (int) ceil($total / $perPage);
            $qs = http_build_query(array_filter(['search' => $search, 'age' => $ageFilter, 'gender' => $gender, 'status' => $status, 'zone' => $zone, 'civil' => $civil]));
            $qs = $qs ? '&' . $qs : '';
            ?>
            <?php if ($total > 0): ?>
                <div class="db-pagination">
                    <span class="db-page-info">
                        Showing <?= ($currentPage - 1) * $perPage + 1 ?>–<?= min($currentPage * $perPage, $total) ?> of <?= $total ?> records
                    </span>
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
            <?php endif; ?>

        </div>
    </div>

    <script>
        function toggleSkFilters() {
            const panel = document.getElementById('skFilterPanel');
            panel.style.display = panel.style.display === 'none' ? '' : 'none';
        }

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>