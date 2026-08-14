<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .notif-wrap {
            max-width: 780px;
        }

        /* ── summary bar ── */
        .notif-summary {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
            margin-bottom: 28px;
        }

        .notif-stat {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(29, 36, 72, .06);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: box-shadow .2s, transform .15s;
            text-decoration: none;
        }

        .notif-stat:hover {
            box-shadow: 0 6px 20px rgba(29, 36, 72, .12);
            transform: translateY(-2px);
        }

        .notif-stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .notif-stat-num {
            font-size: 18px;
            font-weight: 700;
            color: #1a1d2e;
            line-height: 1.1;
        }

        .notif-stat-label {
            font-size: 11px;
            color: #9aa0b4;
            font-weight: 500;
            margin-top: 1px;
        }

        .notif-badge-zero {
            opacity: .45;
        }

        /* ── section cards ── */
        .notif-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29, 36, 72, .06);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .notif-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 20px;
            border-bottom: 1px solid #f0f2f8;
        }

        .notif-card-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notif-card-header-left h4 {
            margin: 0;
            font-size: 13.5px;
            font-weight: 600;
            color: #1a1d2e;
        }

        .notif-card-header-left i {
            color: #9aa0b4;
            font-size: 14px;
        }

        .notif-card-badge {
            background: #1d2448;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 9px;
            border-radius: 100px;
        }

        .notif-card-badge.zero {
            background: #e8ecf4;
            color: #9aa0b4;
        }

        /* ── items ── */
        .notif-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 13px 20px;
            border-bottom: 1px solid #f5f6fb;
            transition: background .15s;
        }

        .notif-item:last-child {
            border-bottom: none;
        }

        .notif-item:hover {
            background: #f8f9ff;
        }

        .notif-item-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .notif-item-body {
            flex: 1;
            min-width: 0;
        }

        .notif-item-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notif-item-sub {
            font-size: 12px;
            color: #6b7280;
            margin: 0;
        }

        .notif-item-time {
            font-size: 11px;
            color: #b0b6cc;
            flex-shrink: 0;
            margin-top: 3px;
        }

        .notif-item-action {
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }

        /* ── empty state ── */
        .notif-empty {
            padding: 28px 20px;
            text-align: center;
            color: #9aa0b4;
            font-size: 13px;
        }

        .notif-empty i {
            font-size: 28px;
            display: block;
            margin-bottom: 8px;
            opacity: .4;
        }

        /* ── type badge ── */
        .type-pill {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            background: #eef0fb;
            color: #5b6fd6;
        }

        @media (max-width: 640px) {
            .notif-summary {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = $role      ?? 'secretary';
    $active    = 'notifications';
    $pageTitle = 'Notifications';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $pendingAccounts      = $pendingAccounts      ?? 0;
    $pendingClearances    = $pendingClearances    ?? 0;
    $newBlotters          = $newBlotters          ?? 0;
    $openBlotters         = $openBlotters         ?? 0;
    $upcomingHearings     = $upcomingHearings     ?? 0;
    $upcomingSchedules    = $upcomingSchedules    ?? 0;
    $recentClearances     = $recentClearances     ?? [];
    $recentBlotters       = $recentBlotters       ?? [];
    $pendingUsers         = $pendingUsers         ?? [];
    $upcomingScheduleList = $upcomingScheduleList ?? [];

    $total = $pendingAccounts + $pendingClearances + $newBlotters + $upcomingHearings + $upcomingSchedules;

    function timeAgo(string $datetime): string
    {
        $diff = time() - strtotime($datetime);
        if ($diff < 60)     return 'just now';
        if ($diff < 3600)   return floor($diff / 60)  . 'm ago';
        if ($diff < 86400)  return floor($diff / 3600) . 'h ago';
        return floor($diff / 86400) . 'd ago';
    }
    ?>

    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <!-- Header row -->
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
                <div>
                    <h2 style="margin:0 0 2px;font-size:18px;font-weight:700;color:#1a1d2e;">Notifications</h2>
                    <p style="margin:0;font-size:12.5px;color:#9aa0b4;">
                        <?= $total > 0
                            ? '<span style="color:#1d2448;font-weight:600;">' . $total . ' item' . ($total !== 1 ? 's' : '') . '</span> need your attention'
                            : 'Everything is up to date' ?>
                    </p>
                </div>
                <button class="db-btn db-btn--outline" onclick="location.reload()" style="display:inline-flex;align-items:center;gap:7px;font-size:12.5px;">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>

            <!-- Summary stat cards -->
            <div class="notif-summary">
                <a href="/<?= $role ?>/pending-accounts" class="notif-stat <?= $pendingAccounts === 0 ? 'notif-badge-zero' : '' ?>">
                    <div class="notif-stat-icon" style="background:rgba(255,193,7,.14);color:#e6a800;"><i class="fas fa-user-clock"></i></div>
                    <div>
                        <div class="notif-stat-num"><?= $pendingAccounts ?></div>
                        <div class="notif-stat-label">Pending Accounts</div>
                    </div>
                </a>
                <a href="/<?= $role ?>/clearance" class="notif-stat <?= $pendingClearances === 0 ? 'notif-badge-zero' : '' ?>">
                    <div class="notif-stat-icon" style="background:rgba(91,111,214,.12);color:#5b6fd6;"><i class="fas fa-file-alt"></i></div>
                    <div>
                        <div class="notif-stat-num"><?= $pendingClearances ?></div>
                        <div class="notif-stat-label">Document Requests</div>
                    </div>
                </a>
                <a href="/<?= $role ?>/blotter" class="notif-stat <?= $newBlotters === 0 ? 'notif-badge-zero' : '' ?>">
                    <div class="notif-stat-icon" style="background:rgba(220,53,69,.12);color:#dc3545;"><i class="fas fa-book"></i></div>
                    <div>
                        <div class="notif-stat-num"><?= $newBlotters ?></div>
                        <div class="notif-stat-label">New Blotters</div>
                    </div>
                </a>
                <a href="/<?= $role ?>/blotter" class="notif-stat <?= $upcomingHearings === 0 ? 'notif-badge-zero' : '' ?>">
                    <div class="notif-stat-icon" style="background:rgba(22,199,154,.12);color:#16c79a;"><i class="fas fa-gavel"></i></div>
                    <div>
                        <div class="notif-stat-num"><?= $upcomingHearings ?></div>
                        <div class="notif-stat-label">Upcoming Hearings</div>
                    </div>
                </a>
                <a href="/<?= $role ?>/calendar" class="notif-stat <?= $upcomingSchedules === 0 ? 'notif-badge-zero' : '' ?>">
                    <div class="notif-stat-icon" style="background:rgba(124,92,191,.12);color:#7c5cbf;"><i class="fas fa-calendar-day"></i></div>
                    <div>
                        <div class="notif-stat-num"><?= $upcomingSchedules ?></div>
                        <div class="notif-stat-label">Upcoming Events</div>
                    </div>
                </a>
            </div>

            <div class="notif-wrap">

                <!-- ── 1. Pending Account Registrations ── -->
                <div class="notif-card">
                    <div class="notif-card-header">
                        <div class="notif-card-header-left">
                            <i class="fas fa-user-clock"></i>
                            <h4>Pending Account Registrations</h4>
                        </div>
                        <span class="notif-card-badge <?= $pendingAccounts === 0 ? 'zero' : '' ?>"><?= $pendingAccounts ?></span>
                    </div>
                    <?php if (empty($pendingUsers)): ?>
                        <div class="notif-empty"><i class="fas fa-check-circle" style="color:#16c79a;"></i>No pending accounts</div>
                    <?php else: ?>
                        <?php foreach ($pendingUsers as $u): ?>
                            <div class="notif-item">
                                <div class="notif-item-icon" style="background:rgba(255,193,7,.14);color:#e6a800;"><i class="fas fa-user"></i></div>
                                <div class="notif-item-body">
                                    <p class="notif-item-title"><?= esc(trim($u['first_name'] . ' ' . $u['last_name'])) ?></p>
                                    <p class="notif-item-sub">
                                        <span class="type-pill"><?= ucfirst(esc($u['role'])) ?></span>
                                        &nbsp;<?= esc($u['email']) ?>
                                    </p>
                                </div>
                                <div class="notif-item-time"><?= timeAgo($u['created_at']) ?></div>
                                <div class="notif-item-action" style="margin-left:10px;">
                                    <a href="/<?= $role ?>/pending-accounts" class="db-btn db-btn--xs db-btn--primary">Review</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if ($pendingAccounts > count($pendingUsers)): ?>
                            <div style="padding:10px 20px;font-size:12px;color:#9aa0b4;border-top:1px solid #f5f6fb;">
                                + <?= $pendingAccounts - count($pendingUsers) ?> more &mdash;
                                <a href="/<?= $role ?>/pending-accounts" style="color:#5b6fd6;">View all</a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- ── 2. Pending Document Requests ── -->
                <div class="notif-card">
                    <div class="notif-card-header">
                        <div class="notif-card-header-left">
                            <i class="fas fa-file-alt"></i>
                            <h4>Pending Document Requests</h4>
                        </div>
                        <span class="notif-card-badge <?= $pendingClearances === 0 ? 'zero' : '' ?>"><?= $pendingClearances ?></span>
                    </div>
                    <?php if (empty($recentClearances)): ?>
                        <div class="notif-empty"><i class="fas fa-check-circle" style="color:#16c79a;"></i>No pending document requests</div>
                    <?php else: ?>
                        <?php foreach ($recentClearances as $r): ?>
                            <div class="notif-item">
                                <div class="notif-item-icon" style="background:rgba(91,111,214,.12);color:#5b6fd6;"><i class="fas fa-file-contract"></i></div>
                                <div class="notif-item-body">
                                    <p class="notif-item-title"><?= esc($r['resident_name'] ?? 'Unknown') ?></p>
                                    <p class="notif-item-sub">
                                        <span class="type-pill"><?= esc($r['document_type']) ?></span>
                                        &nbsp;<?= esc($r['purpose']) ?>
                                    </p>
                                </div>
                                <div class="notif-item-time"><?= timeAgo($r['created_at']) ?></div>
                                <div class="notif-item-action" style="margin-left:10px;">
                                    <a href="/<?= $role ?>/clearance" class="db-btn db-btn--xs db-btn--outline">View</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if ($pendingClearances > count($recentClearances)): ?>
                            <div style="padding:10px 20px;font-size:12px;color:#9aa0b4;border-top:1px solid #f5f6fb;">
                                + <?= $pendingClearances - count($recentClearances) ?> more &mdash;
                                <a href="/<?= $role ?>/clearance" style="color:#5b6fd6;">View all</a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- ── 3. New Blotter Reports ── -->
                <div class="notif-card">
                    <div class="notif-card-header">
                        <div class="notif-card-header-left">
                            <i class="fas fa-book"></i>
                            <h4>New Blotter Reports</h4>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <?php if ($openBlotters > 0): ?>
                                <span style="font-size:11px;color:#9aa0b4;"><?= $openBlotters ?> total open</span>
                            <?php endif; ?>
                            <span class="notif-card-badge <?= $newBlotters === 0 ? 'zero' : '' ?>"><?= $newBlotters ?> new</span>
                        </div>
                    </div>
                    <?php if (empty($recentBlotters)): ?>
                        <div class="notif-empty"><i class="fas fa-check-circle" style="color:#16c79a;"></i>No new blotter reports</div>
                    <?php else: ?>
                        <?php foreach ($recentBlotters as $b): ?>
                            <div class="notif-item">
                                <div class="notif-item-icon" style="background:rgba(220,53,69,.12);color:#dc3545;"><i class="fas fa-exclamation-circle"></i></div>
                                <div class="notif-item-body">
                                    <p class="notif-item-title"><?= esc($b['complainant_name']) ?></p>
                                    <p class="notif-item-sub">
                                        <span class="type-pill" style="background:#fff0f3;color:#dc3545;"><?= esc($b['incident_type'] ?? 'Incident') ?></span>
                                        &nbsp;Status: <?= $b['status'] === 'under_investigation' ? 'Under Investigation' : ucfirst(str_replace('_', ' ', esc($b['status']))) ?>
                                        <?php if (!empty($b['appointment_date'])): ?>
                                            &nbsp;· Hearing: <?= date('M d', strtotime($b['appointment_date'])) ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="notif-item-time"><?= timeAgo($b['created_at']) ?></div>
                                <div class="notif-item-action" style="margin-left:10px;">
                                    <a href="/<?= $role ?>/blotter/<?= (int)$b['id'] ?>" class="db-btn db-btn--xs db-btn--outline">View</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if ($openBlotters > count($recentBlotters)): ?>
                            <div style="padding:10px 20px;font-size:12px;color:#9aa0b4;border-top:1px solid #f5f6fb;">
                                + <?= $openBlotters - count($recentBlotters) ?> more open &mdash;
                                <a href="/<?= $role ?>/blotter" style="color:#5b6fd6;">View all</a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- ── 4. Upcoming Schedules ── -->
                <div class="notif-card">
                    <div class="notif-card-header">
                        <div class="notif-card-header-left">
                            <i class="fas fa-calendar-day"></i>
                            <h4>Upcoming Events (Next 3 Days)</h4>
                        </div>
                        <span class="notif-card-badge <?= $upcomingSchedules === 0 ? 'zero' : '' ?>"><?= $upcomingSchedules ?></span>
                    </div>
                    <?php if (empty($upcomingScheduleList)): ?>
                        <div class="notif-empty"><i class="fas fa-calendar-check" style="color:#16c79a;opacity:.5;"></i>No upcoming events</div>
                    <?php else: ?>
                        <?php foreach ($upcomingScheduleList as $s): ?>
                            <div class="notif-item">
                                <div class="notif-item-icon" style="background:rgba(124,92,191,.12);color:#7c5cbf;"><i class="fas fa-calendar-alt"></i></div>
                                <div class="notif-item-body">
                                    <p class="notif-item-title"><?= esc($s['title']) ?></p>
                                    <p class="notif-item-sub">
                                        <?= date('M d, Y', strtotime($s['event_date'])) ?>
                                        <?php if (!empty($s['start_time'])): ?> at <?= date('g:i A', strtotime($s['start_time'])) ?><?php endif; ?>
                                            <?php if (!empty($s['location'])): ?> &mdash; <?= esc($s['location']) ?><?php endif; ?>
                                    </p>
                                </div>
                                <div class="notif-item-time">
                                    <?php
                                    $daysUntil = (int) floor((strtotime($s['event_date']) - strtotime(date('Y-m-d'))) / 86400);
                                    echo $daysUntil === 0 ? '<span style="color:#dc3545;font-weight:600;">Today</span>'
                                        : ($daysUntil === 1 ? '<span style="color:#e6a800;font-weight:600;">Tomorrow</span>'
                                            : 'In ' . $daysUntil . 'd');
                                    ?>
                                </div>
                                <div class="notif-item-action" style="margin-left:10px;">
                                    <a href="/<?= $role ?>/calendar" class="db-btn db-btn--xs db-btn--outline">Calendar</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div><!-- end notif-wrap -->
        </div>
    </div>

    <script>
        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>