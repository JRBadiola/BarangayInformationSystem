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

        .notif-card-hl {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notif-card-hl h4 {
            margin: 0;
            font-size: 13.5px;
            font-weight: 600;
            color: #1a1d2e;
        }

        .notif-card-hl i {
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

        .ni-icon {
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

        .ni-body {
            flex: 1;
            min-width: 0;
        }

        .ni-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ni-sub {
            font-size: 12px;
            color: #6b7280;
            margin: 0;
        }

        .ni-time {
            font-size: 11px;
            color: #b0b6cc;
            flex-shrink: 0;
            margin-top: 3px;
        }

        .ni-action {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            margin-left: 10px;
        }

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

        .type-pill {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            background: #eef0fb;
            color: #5b6fd6;
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'sk';
    $active    = 'notifications';
    $pageTitle = 'Notifications';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    // ── All data is SK-activity-specific ─────────────────────────────────────
    $db       = \Config\Database::connect();
    $skUserId = (int) session()->get('user_id');

    // 1. Pending registrations (awaiting approval)
    $pendingRegistrations = (int) $db->table('sk_program_registrations r')
        ->join('sk_programs p', 'p.id = r.program_id')
        ->where('p.created_by', $skUserId)
        ->where('r.status', 'pending')
        ->countAllResults();

    // 2. All registrations in the last 14 days across SK's programs
    $allRecentRegs = $db->table('sk_program_registrations r')
        ->select('r.id, r.status, r.created_at, r.requirements_submitted, r.notes,
                  p.name AS program_name, p.id AS program_id,
                  CONCAT(u.first_name," ",u.last_name) AS resident_name, u.username')
        ->join('sk_programs p', 'p.id = r.program_id')
        ->join('users u',       'u.id = r.user_id', 'left')
        ->where('p.created_by', $skUserId)
        ->where('r.created_at >=', date('Y-m-d H:i:s', strtotime('-14 days')))
        ->orderBy('r.created_at', 'DESC')
        ->limit(20)
        ->get()->getResultArray();

    // 3. Approved this week
    $approvedThisWeek = (int) $db->table('sk_program_registrations r')
        ->join('sk_programs p', 'p.id = r.program_id')
        ->where('p.created_by', $skUserId)
        ->where('r.status', 'approved')
        ->where('r.updated_at >=', date('Y-m-d', strtotime('monday this week')))
        ->countAllResults();

    // 4. Upcoming programs (next 7 days)
    $upcomingCount = (int) $db->table('sk_programs')
        ->where('created_by', $skUserId)
        ->whereIn('status', ['Active', 'Upcoming'])
        ->where('start_date >=', date('Y-m-d'))
        ->where('start_date <=', date('Y-m-d', strtotime('+7 days')))
        ->countAllResults();

    $upcomingPrograms = $db->table('sk_programs')
        ->where('created_by', $skUserId)
        ->whereIn('status', ['Active', 'Upcoming'])
        ->where('start_date >=', date('Y-m-d'))
        ->where('start_date <=', date('Y-m-d', strtotime('+7 days')))
        ->orderBy('start_date', 'ASC')
        ->limit(5)
        ->get()->getResultArray();

    $total = $pendingRegistrations + $upcomingCount;

    function timeAgo(string $datetime): string
    {
        $diff = time() - strtotime($datetime);
        if ($diff < 60)    return 'just now';
        if ($diff < 3600)  return floor($diff / 60) . 'm ago';
        if ($diff < 86400) return floor($diff / 3600) . 'h ago';
        return floor($diff / 86400) . 'd ago';
    }

    $pendingOnly = array_values(array_filter($allRecentRegs, fn($r) => $r['status'] === 'pending'));
    $statusStyles = [
        'pending'  => ['icon' => 'fa-user-clock',   'bg' => 'rgba(255,193,7,.14)',   'color' => '#e6a800'],
        'approved' => ['icon' => 'fa-check-circle',  'bg' => 'rgba(22,199,154,.14)', 'color' => '#16c79a'],
        'rejected' => ['icon' => 'fa-times-circle',  'bg' => 'rgba(220,53,69,.12)',  'color' => '#dc3545'],
    ];
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <!-- Header -->
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
                <div>
                    <h2 style="margin:0 0 2px;font-size:18px;font-weight:700;color:#1a1d2e;">SK Notifications</h2>
                    <p style="margin:0;font-size:12.5px;color:#9aa0b4;">
                        <?= $total > 0
                            ? '<span style="color:#1d2448;font-weight:600;">' . $total . ' item' . ($total !== 1 ? 's' : '') . '</span> need your attention'
                            : 'All caught up — no pending items' ?>
                    </p>
                </div>
                <button class="db-btn db-btn--outline" onclick="location.reload()" style="display:inline-flex;align-items:center;gap:7px;font-size:12.5px;">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>

            <!-- Summary stats -->
            <div class="notif-summary">
                <a href="/sk/programs" class="notif-stat <?= $pendingRegistrations === 0 ? 'notif-badge-zero' : '' ?>">
                    <div class="notif-stat-icon" style="background:rgba(255,193,7,.14);color:#e6a800;"><i class="fas fa-user-clock"></i></div>
                    <div>
                        <div class="notif-stat-num"><?= $pendingRegistrations ?></div>
                        <div class="notif-stat-label">Pending Approval</div>
                    </div>
                </a>
                <a href="/sk/programs" class="notif-stat">
                    <div class="notif-stat-icon" style="background:rgba(22,199,154,.14);color:#16c79a;"><i class="fas fa-user-check"></i></div>
                    <div>
                        <div class="notif-stat-num"><?= $approvedThisWeek ?></div>
                        <div class="notif-stat-label">Approved This Week</div>
                    </div>
                </a>
                <a href="/sk/programs" class="notif-stat <?= $upcomingCount === 0 ? 'notif-badge-zero' : '' ?>">
                    <div class="notif-stat-icon" style="background:rgba(124,92,191,.12);color:#7c5cbf;"><i class="fas fa-calendar-day"></i></div>
                    <div>
                        <div class="notif-stat-num"><?= $upcomingCount ?></div>
                        <div class="notif-stat-label">Upcoming (7 days)</div>
                    </div>
                </a>
            </div>

            <div class="notif-wrap">

                <!-- ① Pending registrations -->
                <div class="notif-card">
                    <div class="notif-card-header">
                        <div class="notif-card-hl">
                            <i class="fas fa-user-clock"></i>
                            <h4>Pending Registrations — Awaiting Your Approval</h4>
                        </div>
                        <span class="notif-card-badge <?= $pendingRegistrations === 0 ? 'zero' : '' ?>"><?= $pendingRegistrations ?></span>
                    </div>
                    <?php if (empty($pendingOnly)): ?>
                        <div class="notif-empty"><i class="fas fa-check-circle" style="color:#16c79a;"></i>No pending registrations — all caught up!</div>
                    <?php else: ?>
                        <?php foreach ($pendingOnly as $r): ?>
                            <div class="notif-item">
                                <div class="ni-icon" style="background:rgba(255,193,7,.14);color:#e6a800;"><i class="fas fa-user-clock"></i></div>
                                <div class="ni-body">
                                    <p class="ni-title"><?= esc($r['resident_name'] ?? 'Unknown') ?> <span style="font-weight:400;color:#9aa0b4;">wants to join</span></p>
                                    <p class="ni-sub">
                                        <span class="type-pill"><?= esc($r['program_name']) ?></span>
                                        <?php if (!empty($r['requirements_submitted'])): ?>
                                            &nbsp;· Submitted: <?= esc(mb_strimwidth($r['requirements_submitted'], 0, 48, '…')) ?>
                                        <?php else: ?>
                                            &nbsp;· <em style="color:#b0b6cc;">No requirements submitted</em>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="ni-time"><?= timeAgo($r['created_at']) ?></div>
                                <div class="ni-action">
                                    <a href="/sk/programs/registrations/<?= (int)$r['program_id'] ?>" class="db-btn db-btn--xs db-btn--primary">Review</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- ② All recent registration activity (14 days) -->
                <div class="notif-card">
                    <div class="notif-card-header">
                        <div class="notif-card-hl">
                            <i class="fas fa-history"></i>
                            <h4>Registration Activity — Last 14 Days</h4>
                        </div>
                        <span class="notif-card-badge <?= empty($allRecentRegs) ? 'zero' : '' ?>"><?= count($allRecentRegs) ?></span>
                    </div>
                    <?php if (empty($allRecentRegs)): ?>
                        <div class="notif-empty"><i class="fas fa-inbox"></i>No registration activity in the last 14 days.</div>
                    <?php else: ?>
                        <?php foreach ($allRecentRegs as $r):
                            $st = $statusStyles[$r['status']] ?? $statusStyles['pending'];
                        ?>
                            <div class="notif-item">
                                <div class="ni-icon" style="background:<?= $st['bg'] ?>;color:<?= $st['color'] ?>;"><i class="fas <?= $st['icon'] ?>"></i></div>
                                <div class="ni-body">
                                    <p class="ni-title"><?= esc($r['resident_name'] ?? 'Unknown') ?></p>
                                    <p class="ni-sub">
                                        <span class="type-pill"><?= esc($r['program_name']) ?></span>
                                        &nbsp;·&nbsp; <span style="font-weight:600;color:<?= $st['color'] ?>;"><?= ucfirst($r['status']) ?></span>
                                        <?php if (!empty($r['requirements_submitted'])): ?>
                                            &nbsp;· <?= esc(mb_strimwidth($r['requirements_submitted'], 0, 40, '…')) ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="ni-time"><?= timeAgo($r['created_at']) ?></div>
                                <div class="ni-action">
                                    <a href="/sk/programs/registrations/<?= (int)$r['program_id'] ?>" class="db-btn db-btn--xs db-btn--outline">View</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- ③ Upcoming programs (next 7 days) -->
                <div class="notif-card">
                    <div class="notif-card-header">
                        <div class="notif-card-hl">
                            <i class="fas fa-calendar-day"></i>
                            <h4>Your Upcoming Programs — Next 7 Days</h4>
                        </div>
                        <span class="notif-card-badge <?= empty($upcomingPrograms) ? 'zero' : '' ?>"><?= count($upcomingPrograms) ?></span>
                    </div>
                    <?php if (empty($upcomingPrograms)): ?>
                        <div class="notif-empty"><i class="fas fa-calendar-check" style="color:#16c79a;opacity:.5;"></i>No programs scheduled in the next 7 days.</div>
                    <?php else: ?>
                        <?php foreach ($upcomingPrograms as $p):
                            $daysUntil = (int) floor((strtotime($p['start_date']) - strtotime(date('Y-m-d'))) / 86400);
                            $regCount  = (int) $db->table('sk_program_registrations')->where('program_id', $p['id'])->countAllResults();
                        ?>
                            <div class="notif-item">
                                <div class="ni-icon" style="background:rgba(124,92,191,.12);color:#7c5cbf;"><i class="fas fa-calendar-alt"></i></div>
                                <div class="ni-body">
                                    <p class="ni-title"><?= esc($p['name']) ?></p>
                                    <p class="ni-sub">
                                        <?= date('M d, Y', strtotime($p['start_date'])) ?>
                                        <?php if (!empty($p['venue'])): ?> &mdash; <?= esc($p['venue']) ?><?php endif; ?>
                                            &nbsp;·&nbsp; <i class="fas fa-users" style="color:#b0b6cc;"></i> <?= $regCount ?> registered
                                    </p>
                                </div>
                                <div class="ni-time">
                                    <?= $daysUntil === 0 ? '<span style="color:#dc3545;font-weight:600;">Today</span>'
                                        : ($daysUntil === 1 ? '<span style="color:#e6a800;font-weight:600;">Tomorrow</span>'
                                            : 'In ' . $daysUntil . 'd') ?>
                                </div>
                                <div class="ni-action">
                                    <a href="/sk/programs/registrations/<?= (int)$p['id'] ?>" class="db-btn db-btn--xs db-btn--outline">Registrations</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div><!-- /.notif-wrap -->
        </div>
    </div>

    <script>
        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>