<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Dashboard - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role      = 'sk';
    $active    = 'dashboard';
    $pageTitle = 'SK Dashboard';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $stats       = $stats       ?? ['total' => 0, 'male' => 0, 'female' => 0, 'oos' => 0, 'employed' => 0, 'students' => 0, 'programs' => 0];
    $recentYouth = $recentYouth ?? [];
    $progCounts  = $progCounts  ?? ['total' => 0, 'Active' => 0, 'Upcoming' => 0, 'Completed' => 0];

    $statusStyle = [
        'Student'       => 'background:#f0faf6;color:#1a7a55;border:1px solid #c3e8d8;',
        'Employed'      => 'background:#eef0fb;color:#1d2448;border:1px solid #d0d8f5;',
        'Unemployed'    => 'background:#fff8f0;color:#b7600a;border:1px solid #fde8c8;',
        'Out-of-School' => 'background:#fff0f1;color:#c0392b;border:1px solid #fad4d4;',
        '—'             => 'background:#f5f6fa;color:#9aa0b4;border:1px solid #e2e5ef;',
    ];
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <!-- Welcome -->
            <div class="db-welcome">
                <div>
                    <h2>Welcome back, <?= esc(session()->get('username') ?? 'SK Official') ?> 👋</h2>
                    <p>Sangguniang Kabataan — Barangay Bacolod, Bato, Camarines Sur</p>
                </div>
                <div class="db-welcome-icon"><i class="fas fa-star"></i></div>
            </div>

            <!-- Stats -->
            <div class="db-stats">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,.15);color:#5b6fd6;"><i class="fas fa-users"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['total']) ?></span><span class="db-stat-label">Registered Youth (15–30)</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,.15);color:#5b6fd6;"><i class="fas fa-male"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['male']) ?></span><span class="db-stat-label">Male Youth</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(220,53,69,.15);color:#dc3545;"><i class="fas fa-female"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['female']) ?></span><span class="db-stat-label">Female Youth</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,.15);color:#ffc107;"><i class="fas fa-user-times"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['oos']) ?></span><span class="db-stat-label">Out-of-School Youth</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,.15);color:#16c79a;"><i class="fas fa-briefcase"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['employed']) ?></span><span class="db-stat-label">Employed Youth</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,.15);color:#5b6fd6;"><i class="fas fa-calendar-check"></i></div>
                    <div><span class="db-stat-num"><?= number_format($stats['programs']) ?></span><span class="db-stat-label">Active Programs</span></div>
                </div>
            </div>

            <!-- Programs summary strip -->
            <?php if ($progCounts['total'] > 0): ?>
                <div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;">
                    <?php foreach (
                        [
                            ['Active',    '#16c79a', 'fa-play-circle'],
                            ['Upcoming',  '#e6a800', 'fa-clock'],
                            ['Completed', '#6c757d', 'fa-check-double'],
                        ] as [$s, $c, $ic]
                    ): ?>
                        <div style="flex:1;min-width:140px;background:#fff;border-radius:10px;padding:12px 16px;box-shadow:0 1px 8px rgba(29,36,72,.06);display:flex;align-items:center;gap:10px;">
                            <i class="fas <?= $ic ?>" style="color:<?= $c ?>;font-size:18px;"></i>
                            <div>
                                <div style="font-size:20px;font-weight:700;color:#1a1d2e;"><?= $progCounts[$s] ?></div>
                                <div style="font-size:11.5px;color:#9aa0b4;"><?= $s ?> Programs</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <a href="/sk/programs" style="flex:1;min-width:140px;background:linear-gradient(135deg,#1d2448,#2e3a6e);border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;text-decoration:none;">
                        <span style="color:#fff;font-size:13px;font-weight:600;">Manage Programs</span>
                        <i class="fas fa-arrow-right" style="color:rgba(255,255,255,.7);"></i>
                    </a>
                </div>
            <?php endif; ?>

            <!-- Modules -->
            <h3 class="db-section-title">Modules</h3>
            <div class="db-modules">
                <a href="/sk/profiling" class="db-module-card">
                    <div class="db-module-icon"><i class="fas fa-id-card"></i></div>
                    <h4>SK Profiling</h4>
                    <p>Manage and view the list of youth residents aged 15–30 years old.</p>
                </a>
                <a href="/sk/programs" class="db-module-card">
                    <div class="db-module-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h4>Programs & Events</h4>
                    <p>Create and track SK programs, activities, and community events.</p>
                </a>
                <a href="/sk/reports" class="db-module-card">
                    <div class="db-module-icon"><i class="fas fa-chart-bar"></i></div>
                    <h4>Reports</h4>
                    <p>Generate youth demographic reports and program participation data.</p>
                </a>
                <a href="/sk/settings" class="db-module-card">
                    <div class="db-module-icon"><i class="fas fa-cog"></i></div>
                    <h4>Settings</h4>
                    <p>Manage SK account settings and system preferences.</p>
                </a>
            </div>

            <!-- Recent Youth -->
            <h3 class="db-section-title">Recently Added Youth Profiles</h3>
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Zone</th>
                            <th>Status</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentYouth)): ?>
                            <tr>
                                <td colspan="8" style="text-align:center;padding:28px;color:#9aa0b4;">
                                    <i class="fas fa-users" style="font-size:22px;display:block;margin-bottom:8px;color:#d0d5e8;"></i>
                                    No youth profiles in the census yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentYouth as $i => $y):
                                $statusSt = $statusStyle[$y['status']] ?? $statusStyle['—'];
                                $dateLabel = $y['created_at'] ? date('M d, Y', strtotime($y['created_at'])) : '—';
                                $source    = $y['source'] ?? 'head';
                                $rid       = $y['rid']    ?? '';
                            ?>
                                <tr>
                                    <td><?= str_pad($i + 1, 3, '0', STR_PAD_LEFT) ?></td>
                                    <td><strong><?= esc(trim($y['first_name'] . ' ' . $y['last_name'])) ?></strong></td>
                                    <td><?= $y['age'] ?></td>
                                    <td><?= esc($y['gender'] ?? '—') ?></td>
                                    <td><?= esc($y['zone'] ?? '—') ?></td>
                                    <td>
                                        <span style="display:inline-block;font-size:11px;font-weight:600;padding:2px 9px;border-radius:20px;<?= $statusSt ?>">
                                            <?= esc($y['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= $dateLabel ?></td>
                                    <td>
                                        <a href="/sk/profiling?search=<?= urlencode(trim($y['first_name'] . ' ' . $y['last_name'])) ?>"
                                            class="db-action-btn">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script>
        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>