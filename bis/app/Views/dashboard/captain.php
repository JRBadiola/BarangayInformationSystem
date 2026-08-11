<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        /* ── Dashboard grid ── */
        .dash-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .dash-stat {
            background: #fff;
            border-radius: 14px;
            padding: 20px 22px;
            box-shadow: 0 2px 10px rgba(29, 36, 72, .06);
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
            color: inherit;
            transition: box-shadow .2s, transform .15s;
        }

        .dash-stat:hover {
            box-shadow: 0 4px 18px rgba(29, 36, 72, .12);
            transform: translateY(-2px);
        }

        .dash-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .dash-stat-num {
            font-size: 26px;
            font-weight: 700;
            color: #1a1d2e;
            line-height: 1;
            display: block;
        }

        .dash-stat-lbl {
            font-size: 12px;
            color: #9aa0b4;
            margin-top: 3px;
            display: block;
        }

        /* ── Two-col layout ── */
        .dash-row {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
            margin-bottom: 24px;
        }

        /* ── Section card ── */
        .dash-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(29, 36, 72, .06);
            overflow: hidden;
        }

        .dash-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid #f0f2f8;
        }

        .dash-card-head h4 {
            font-size: 14px;
            font-weight: 700;
            color: #1a1d2e;
            margin: 0;
        }

        .dash-card-head a {
            font-size: 12px;
            color: #5b6fd6;
            text-decoration: none;
            font-weight: 600;
        }

        .dash-card-head a:hover {
            text-decoration: underline;
        }

        /* ── Mini table ── */
        .dash-mini-table {
            width: 100%;
            border-collapse: collapse;
        }

        .dash-mini-table th {
            font-size: 10.5px;
            font-weight: 700;
            color: #9aa0b4;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 10px 16px;
            text-align: left;
            background: #fafbfd;
            border-bottom: 1px solid #f0f2f8;
        }

        .dash-mini-table td {
            padding: 11px 16px;
            font-size: 13px;
            color: #4a5068;
            border-bottom: 1px solid #f0f2f8;
        }

        .dash-mini-table tr:last-child td {
            border-bottom: none;
        }

        .dash-mini-table tr:hover td {
            background: #f8f9ff;
        }

        /* ── Badges ── */
        .dbadge {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 9px;
            border-radius: 100px;
            white-space: nowrap;
        }

        .dbadge--pending {
            background: #fff8e6;
            color: #b7600a;
        }

        .dbadge--active {
            background: #fff0f1;
            color: #c0392b;
        }

        .dbadge--approved {
            background: #eafaf5;
            color: #1a7a55;
        }

        .dbadge--resolved {
            background: #eafaf5;
            color: #1a7a55;
        }

        .dbadge--dismissed {
            background: #f0f2f8;
            color: #9aa0b4;
        }

        /* ── Quick links ── */
        .dash-links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 16px;
        }

        .dash-link {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f5f7ff;
            border: 1px solid #e0e5f5;
            border-radius: 10px;
            padding: 12px 14px;
            text-decoration: none;
            color: #1a1d2e;
            font-size: 13px;
            font-weight: 600;
            transition: background .2s, border-color .2s;
        }

        .dash-link:hover {
            background: #eef0fb;
            border-color: #c5cdf0;
        }

        .dash-link i {
            color: #5b6fd6;
            font-size: 15px;
            width: 18px;
            text-align: center;
        }

        /* ── Today's schedule ── */
        .dash-appt {
            display: flex;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid #f0f2f8;
            align-items: flex-start;
        }

        .dash-appt:last-child {
            border-bottom: none;
        }

        .dash-appt-time {
            font-size: 11px;
            font-weight: 700;
            color: #5b6fd6;
            background: #f0f2ff;
            border-radius: 6px;
            padding: 3px 8px;
            white-space: nowrap;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .dash-appt-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1d2e;
        }

        .dash-appt-sub {
            font-size: 11.5px;
            color: #9aa0b4;
            margin-top: 1px;
        }

        /* ── Population mini-cards ── */
        .dash-pop-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border-top: 1px solid #f0f2f8;
        }

        .dash-pop-cell {
            padding: 12px 16px;
            border-right: 1px solid #f0f2f8;
            border-bottom: 1px solid #f0f2f8;
            text-align: center;
        }

        .dash-pop-cell:nth-child(2n) {
            border-right: none;
        }

        .dash-pop-cell:nth-last-child(-n+2) {
            border-bottom: none;
        }

        .dash-pop-num {
            font-size: 22px;
            font-weight: 700;
            color: #1a1d2e;
            display: block;
        }

        .dash-pop-lbl {
            font-size: 11px;
            color: #9aa0b4;
        }

        /* ── Empty state ── */
        .dash-empty {
            text-align: center;
            padding: 28px 16px;
            color: #9aa0b4;
        }

        .dash-empty i {
            font-size: 26px;
            display: block;
            margin-bottom: 8px;
            color: #d0d5e8;
        }

        .dash-empty p {
            font-size: 13px;
        }

        /* ── Welcome banner ── */
        .dash-welcome {
            background: linear-gradient(135deg, #1d2448 0%, #2e3a6e 100%);
            border-radius: 16px;
            padding: 24px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            overflow: hidden;
            position: relative;
        }

        .dash-welcome::after {
            content: '';
            position: absolute;
            right: -20px;
            top: -30px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, .04);
            border-radius: 50%;
        }

        .dash-welcome h2 {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .dash-welcome p {
            color: rgba(255, 255, 255, .65);
            font-size: 13px;
            margin: 0;
        }

        .dash-welcome-date {
            color: rgba(255, 255, 255, .5);
            font-size: 12px;
            margin-top: 6px;
        }

        .dash-welcome-icon {
            font-size: 48px;
            color: rgba(255, 255, 255, .12);
            flex-shrink: 0;
        }

        @media(max-width:900px) {
            .dash-grid {
                grid-template-columns: 1fr 1fr;
            }

            .dash-row {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:540px) {
            .dash-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'captain';
    $active    = 'dashboard';
    $pageTitle = 'Dashboard';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    // Data from controller (with safe defaults)
    $totalHouseholds     = $totalHouseholds     ?? 0;
    $totalPopulation     = $totalPopulation     ?? 0;
    $pendingClearances   = $pendingClearances   ?? 0;
    $approvedClearances  = $approvedClearances  ?? 0;
    $pendingBlotter      = $pendingBlotter      ?? 0;
    $activeBlotter       = $activeBlotter       ?? 0;
    $resolvedBlotter     = $resolvedBlotter     ?? 0;
    $pendingAccounts     = $pendingAccounts     ?? 0;
    $pwds                = $pwds                ?? 0;
    $seniors             = $seniors             ?? 0;
    $soloParents         = $soloParents         ?? 0;
    $fourPs              = $fourPs              ?? 0;
    $recentClearances    = $recentClearances    ?? [];
    $recentBlotter       = $recentBlotter       ?? [];
    $todayAppts          = $todayAppts          ?? [];
    $todayBlotterAppts   = $todayBlotterAppts   ?? [];

    $firstName = session()->get('first_name') ?? session()->get('username') ?? 'Captain';
    $today     = date('l, F d, Y');

    $statusBadge = function (string $s): string {
        $map = [
            'pending'            => 'dbadge--pending',
            'under_investigation' => 'dbadge--active',
            'approved'           => 'dbadge--approved',
            'resolved'           => 'dbadge--resolved',
            'dismissed'          => 'dbadge--dismissed',
            'rejected'           => 'dbadge--active',
        ];
        $label = [
            'pending'            => 'Pending',
            'under_investigation' => 'Active',
            'approved'           => 'Approved',
            'resolved'           => 'Resolved',
            'dismissed'          => 'Dismissed',
            'rejected'           => 'Rejected',
        ];
        $cls = $map[$s] ?? 'dbadge--pending';
        $lbl = $label[$s] ?? ucfirst($s);
        return "<span class=\"dbadge {$cls}\">{$lbl}</span>";
    };
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <!-- Welcome -->
            <div class="dash-welcome">
                <div>
                    <h2>Good <?= date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening') ?>, <?= esc($firstName) ?> 👋</h2>
                    <p>Barangay Bacolod, Bato, Camarines Sur — Barangay Information System</p>
                    <div class="dash-welcome-date"><i class="fas fa-calendar" style="margin-right:5px;"></i><?= $today ?></div>
                </div>
                <div class="dash-welcome-icon"><i class="fas fa-user-tie"></i></div>
            </div>

            <!-- Stats row -->
            <div class="dash-grid">
                <a href="/captain/census" class="dash-stat">
                    <div class="dash-stat-icon" style="background:rgba(91,111,214,.15);color:#5b6fd6;">
                        <i class="fas fa-home"></i>
                    </div>
                    <div>
                        <span class="dash-stat-num"><?= number_format($totalHouseholds) ?></span>
                        <span class="dash-stat-lbl">Households</span>
                    </div>
                </a>
                <a href="/captain/census" class="dash-stat">
                    <div class="dash-stat-icon" style="background:rgba(22,199,154,.15);color:#16c79a;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <span class="dash-stat-num"><?= number_format($totalPopulation) ?></span>
                        <span class="dash-stat-lbl">Total Population</span>
                    </div>
                </a>
                <a href="/captain/clearance" class="dash-stat">
                    <div class="dash-stat-icon" style="background:rgba(255,193,7,.15);color:#f0a500;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <span class="dash-stat-num"><?= $pendingClearances ?></span>
                        <span class="dash-stat-lbl">Pending Clearances</span>
                    </div>
                </a>
                <a href="/captain/blotter" class="dash-stat">
                    <div class="dash-stat-icon" style="background:rgba(192,57,43,.12);color:#c0392b;">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <div>
                        <span class="dash-stat-num"><?= $pendingBlotter + $activeBlotter ?></span>
                        <span class="dash-stat-lbl">Open Blotter Cases</span>
                    </div>
                </a>
            </div>

            <!-- Main content: recent activity + sidebar -->
            <div class="dash-row">

                <!-- Left: Recent clearances + blotter -->
                <div style="display:flex;flex-direction:column;gap:20px;">

                    <!-- Recent Clearance Requests -->
                    <div class="dash-card">
                        <div class="dash-card-head">
                            <h4><i class="fas fa-file-signature" style="color:#5b6fd6;margin-right:8px;"></i>Recent Clearance Requests</h4>
                            <a href="/captain/clearance">View all →</a>
                        </div>
                        <?php if (empty($recentClearances)): ?>
                            <div class="dash-empty"><i class="fas fa-inbox"></i>
                                <p>No clearance requests yet.</p>
                            </div>
                        <?php else: ?>
                            <table class="dash-mini-table">
                                <thead>
                                    <tr>
                                        <th>Resident</th>
                                        <th>Document</th>
                                        <th>Filed</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentClearances as $cr): ?>
                                        <tr>
                                            <td style="font-weight:600;color:#1a1d2e;"><?= esc($cr['resident_name'] ?: '—') ?></td>
                                            <td><?= esc($cr['document_type']) ?></td>
                                            <td style="color:#9aa0b4;font-size:12px;"><?= date('M d, Y', strtotime($cr['created_at'])) ?></td>
                                            <td><?= $statusBadge($cr['status']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>

                    <!-- Recent Blotter Reports -->
                    <div class="dash-card">
                        <div class="dash-card-head">
                            <h4><i class="fas fa-gavel" style="color:#c0392b;margin-right:8px;"></i>Recent Blotter Reports</h4>
                            <a href="/captain/blotter">View all →</a>
                        </div>
                        <?php if (empty($recentBlotter)): ?>
                            <div class="dash-empty"><i class="fas fa-shield-alt"></i>
                                <p>No blotter reports.</p>
                            </div>
                        <?php else: ?>
                            <table class="dash-mini-table">
                                <thead>
                                    <tr>
                                        <th>Complainant</th>
                                        <th>Incident Type</th>
                                        <th>Filed</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentBlotter as $br): ?>
                                        <tr>
                                            <td style="font-weight:600;color:#1a1d2e;"><?= esc($br['complainant_name']) ?></td>
                                            <td><?= esc($br['incident_type']) ?></td>
                                            <td style="color:#9aa0b4;font-size:12px;"><?= date('M d, Y', strtotime($br['created_at'])) ?></td>
                                            <td><?= $statusBadge($br['status']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right sidebar -->
                <div style="display:flex;flex-direction:column;gap:20px;">

                    <!-- Today's Schedule -->
                    <div class="dash-card">
                        <div class="dash-card-head">
                            <h4><i class="fas fa-calendar-day" style="color:#16a085;margin-right:8px;"></i>Today's Schedule</h4>
                            <a href="/captain/calendar">Calendar →</a>
                        </div>
                        <?php
                        $allToday = array_merge(
                            array_map(fn($e) => ['time' => $e['start_time'] ?? '', 'title' => $e['title'], 'sub' => $e['location'] ?? ''], $todayAppts),
                            array_map(fn($b) => ['time' => $b['appointment_time'] ?? '', 'title' => 'Blotter: ' . $b['incident_type'], 'sub' => $b['complainant_name']], $todayBlotterAppts)
                        );
                        usort($allToday, fn($a, $b) => strcmp($a['time'], $b['time']));
                        ?>
                        <?php if (empty($allToday)): ?>
                            <div class="dash-empty" style="padding:20px 16px;"><i class="fas fa-calendar-check"></i>
                                <p>No events today.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($allToday as $ev): ?>
                                <div class="dash-appt">
                                    <div class="dash-appt-time"><?= $ev['time'] ? date('h:i A', strtotime($ev['time'])) : 'Anytime' ?></div>
                                    <div>
                                        <div class="dash-appt-title"><?= esc($ev['title']) ?></div>
                                        <?php if ($ev['sub']): ?><div class="dash-appt-sub"><?= esc($ev['sub']) ?></div><?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Population snapshot -->
                    <div class="dash-card">
                        <div class="dash-card-head">
                            <h4><i class="fas fa-chart-pie" style="color:#5b6fd6;margin-right:8px;"></i>Population Snapshot</h4>
                            <a href="/captain/reports">Reports →</a>
                        </div>
                        <div class="dash-pop-row">
                            <div class="dash-pop-cell">
                                <span class="dash-pop-num" style="color:#5b6fd6;"><?= $pwds ?></span>
                                <div class="dash-pop-lbl">PWDs</div>
                            </div>
                            <div class="dash-pop-cell">
                                <span class="dash-pop-num" style="color:#16a085;"><?= $seniors ?></span>
                                <div class="dash-pop-lbl">Senior Citizens</div>
                            </div>
                            <div class="dash-pop-cell">
                                <span class="dash-pop-num" style="color:#e67e22;"><?= $soloParents ?></span>
                                <div class="dash-pop-lbl">Solo Parents</div>
                            </div>
                            <div class="dash-pop-cell">
                                <span class="dash-pop-num" style="color:#c0392b;"><?= $fourPs ?></span>
                                <div class="dash-pop-lbl">4Ps Members</div>
                            </div>
                        </div>
                    </div>

                    <!-- Blotter summary -->
                    <div class="dash-card">
                        <div class="dash-card-head">
                            <h4><i class="fas fa-balance-scale" style="color:#c0392b;margin-right:8px;"></i>Blotter Summary</h4>
                        </div>
                        <div class="dash-pop-row">
                            <div class="dash-pop-cell">
                                <span class="dash-pop-num" style="color:#f0a500;"><?= $pendingBlotter ?></span>
                                <div class="dash-pop-lbl">Pending</div>
                            </div>
                            <div class="dash-pop-cell">
                                <span class="dash-pop-num" style="color:#c0392b;"><?= $activeBlotter ?></span>
                                <div class="dash-pop-lbl">Under Investigation</div>
                            </div>
                            <div class="dash-pop-cell" style="grid-column:1/-1;border-right:none;">
                                <span class="dash-pop-num" style="color:#16a085;"><?= $resolvedBlotter ?></span>
                                <div class="dash-pop-lbl">Resolved</div>
                            </div>
                        </div>
                    </div>

                    <?php if ($pendingAccounts > 0): ?>
                        <!-- Pending account approvals -->
                        <a href="/captain/pending-accounts" style="text-decoration:none;">
                            <div style="background:#fff8f0;border:1px solid #fde8c8;border-radius:12px;padding:14px 16px;display:flex;align-items:center;gap:12px;">
                                <div style="width:40px;height:40px;background:#fde8c8;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#e67e22;font-size:18px;flex-shrink:0;">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                                <div>
                                    <div style="font-size:14px;font-weight:700;color:#1a1d2e;"><?= $pendingAccounts ?> Account<?= $pendingAccounts !== 1 ? 's' : '' ?> Awaiting Approval</div>
                                    <div style="font-size:12px;color:#9aa0b4;">Click to review pending registrations</div>
                                </div>
                                <i class="fas fa-chevron-right" style="color:#b7600a;margin-left:auto;"></i>
                            </div>
                        </a>
                    <?php endif; ?>

                    <!-- Quick links -->
                    <div class="dash-card">
                        <div class="dash-card-head">
                            <h4><i class="fas fa-bolt" style="color:#f0a500;margin-right:8px;"></i>Quick Access</h4>
                        </div>
                        <div class="dash-links">
                            <a href="/captain/census" class="dash-link"><i class="fas fa-home"></i> Census</a>
                            <a href="/captain/clearance" class="dash-link"><i class="fas fa-file-alt"></i> Clearances</a>
                            <a href="/captain/blotter" class="dash-link"><i class="fas fa-gavel"></i> Blotter</a>
                            <a href="/captain/calendar" class="dash-link"><i class="fas fa-calendar"></i> Calendar</a>
                            <a href="/captain/reports" class="dash-link"><i class="fas fa-chart-bar"></i> Reports</a>
                            <a href="/captain/pending-accounts" class="dash-link"><i class="fas fa-user-check"></i> Approvals</a>
                        </div>
                    </div>

                </div>
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