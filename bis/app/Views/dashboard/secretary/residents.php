<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residents - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        /* ── Status badges ── */
        .rl-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 100px;
            white-space: nowrap;
        }

        .rl-badge--active {
            background: #e6f9f1;
            color: #0e9464;
            border: 1px solid #b2e8d2;
        }

        .rl-badge--pending {
            background: #fff8e6;
            color: #b07a00;
            border: 1px solid #ffe08a;
        }

        .rl-badge--none {
            background: #f3f4f8;
            color: #9aa0b4;
            border: 1px solid #e2e5ef;
        }

        .rl-badge--head {
            background: #eef0fb;
            color: #1d2448;
            border: 1px solid #d0d8f5;
        }

        .rl-badge--member {
            background: #f3f4f8;
            color: #6b7280;
            border: 1px solid #e2e5ef;
        }

        .rl-badge--minor {
            background: #fff0f3;
            color: #c0392b;
            border: 1px solid #f5c6cb;
        }

        .rl-table th,
        .rl-table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .rl-empty {
            text-align: center;
            padding: 40px;
            color: #9aa0b4;
        }

        .rl-empty i {
            font-size: 28px;
            display: block;
            margin-bottom: 10px;
        }

        /* ── Pending approvals panel ── */
        .pa-panel {
            background: #fffbf0;
            border: 1.5px solid #ffe08a;
            border-radius: 12px;
            margin-bottom: 24px;
            overflow: hidden;
        }

        .pa-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            cursor: pointer;
            user-select: none;
            gap: 12px;
        }

        .pa-panel-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #7a4200;
        }

        .pa-panel-title i {
            color: #e67e22;
        }

        .pa-panel-count {
            background: #e67e22;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            border-radius: 100px;
            padding: 2px 8px;
        }

        .pa-panel-chevron {
            color: #b07a00;
            transition: transform .2s;
        }

        .pa-panel-chevron.open {
            transform: rotate(180deg);
        }

        .pa-panel-body {
            border-top: 1px solid #ffe08a;
        }

        /* ── Confirmation modals ── */
        .pa-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 17, 30, 0.55);
            backdrop-filter: blur(3px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .pa-overlay.active {
            display: flex;
        }

        .pa-modal {
            background: #fff;
            border-radius: 18px;
            width: 100%;
            max-width: 420px;
            margin: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .18);
            overflow: hidden;
            animation: pa-pop .18s ease;
        }

        @keyframes pa-pop {
            from {
                transform: scale(.94);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .pa-modal-header {
            padding: 24px 24px 0;
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .pa-modal-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .pa-modal-icon--approve {
            background: rgba(22, 199, 154, .12);
            color: #16c79a;
        }

        .pa-modal-icon--reject {
            background: rgba(192, 57, 43, .10);
            color: #c0392b;
        }

        .pa-modal-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1d2e;
            margin: 0 0 4px;
        }

        .pa-modal-sub {
            font-size: 13px;
            color: #9aa0b4;
            margin: 0;
            line-height: 1.5;
        }

        .pa-modal-body {
            padding: 18px 24px 20px;
        }

        .pa-user-card {
            background: #f8f9ff;
            border: 1px solid #e2e5ef;
            border-radius: 10px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .pa-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pa-user-name {
            font-size: 14px;
            font-weight: 600;
            color: #1a1d2e;
        }

        .pa-user-meta {
            font-size: 12px;
            color: #9aa0b4;
            margin-top: 2px;
        }

        .pa-reject-note {
            margin-top: 12px;
            background: #fff8f0;
            border: 1px solid #fde8c8;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12.5px;
            color: #7a4200;
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .pa-reject-note i {
            color: #e67e22;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .pa-modal-footer {
            padding: 0 24px 24px;
            display: flex;
            gap: 10px;
        }

        .pa-btn {
            flex: 1;
            padding: 11px 16px;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: opacity .2s, transform .15s;
        }

        .pa-btn:hover {
            opacity: .88;
            transform: translateY(-1px);
        }

        .pa-btn--cancel {
            background: #f0f2f8;
            color: #4a5068;
        }

        .pa-btn--approve {
            background: #16c79a;
            color: #fff;
        }

        .pa-btn--reject {
            background: #c0392b;
            color: #fff;
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'secretary';
    $active    = 'residents';
    $pageTitle = 'Residents';
    include(APPPATH . 'Views/dashboard/sidebar.php');
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

            <!-- ── Pending Account Approvals panel ────────────────────────── -->
            <?php $pendingUsers = $pendingUsers ?? []; ?>
            <?php if (! empty($pendingUsers)): ?>
                <div class="pa-panel">
                    <div class="pa-panel-header" onclick="togglePending()">
                        <div class="pa-panel-title">
                            <i class="fas fa-user-clock"></i>
                            Pending Account Approvals
                            <span class="pa-panel-count"><?= count($pendingUsers) ?></span>
                        </div>
                        <i class="fas fa-chevron-down pa-panel-chevron open" id="paChevron"></i>
                    </div>
                    <div class="pa-panel-body" id="paBody">
                        <div class="db-table-wrap" style="margin:0;border-radius:0;border:none;box-shadow:none;">
                            <table class="db-table" style="border-radius:0;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Registered</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pendingUsers as $u):
                                        $displayName = trim($u['first_name'] . ' ' . $u['last_name']);
                                        $initial     = strtoupper(substr($u['first_name'], 0, 1));
                                    ?>
                                        <tr>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:10px;">
                                                    <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#1d2448,#2e3a6e);color:#fff;font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                        <?= $initial ?>
                                                    </div>
                                                    <span style="font-weight:600;color:#1a1d2e;"><?= esc($displayName) ?></span>
                                                </div>
                                            </td>
                                            <td><span style="color:#6b7280;">@<?= esc($u['username']) ?></span></td>
                                            <td><?= esc($u['email']) ?></td>
                                            <td>
                                                <span class="db-badge db-badge--<?= $u['role'] === 'sk' ? 'info' : 'default' ?>">
                                                    <?= strtoupper(esc($u['role'])) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($u['created_at'])) ?></td>
                                            <td>
                                                <div class="db-action-group">
                                                    <button type="button" class="db-btn db-btn--success db-btn--sm"
                                                        onclick="openApprove(<?= $u['id'] ?>, '<?= esc($displayName, 'js') ?>', '<?= esc($u['username'], 'js') ?>', '<?= strtoupper(esc($u['role'], 'js')) ?>')">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                    <button type="button" class="db-btn db-btn--danger db-btn--sm"
                                                        onclick="openReject(<?= $u['id'] ?>, '<?= esc($displayName, 'js') ?>', '<?= esc($u['username'], 'js') ?>', '<?= strtoupper(esc($u['role'], 'js')) ?>')">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ── Stats ──────────────────────────────────────────────────── -->
            <div class="db-stats" style="margin-bottom:24px;">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,0.15);color:#16c79a;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <span class="db-stat-num"><?= number_format($totalPop) ?></span>
                        <span class="db-stat-label">Total Population</span>
                    </div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(14,148,100,0.15);color:#0e9464;">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <span class="db-stat-num"><?= number_format($activeAccts) ?></span>
                        <span class="db-stat-label">Active Accounts</span>
                    </div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,0.15);color:#b07a00;">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div>
                        <span class="db-stat-num"><?= number_format($pendingAccts) ?></span>
                        <span class="db-stat-label">Pending Accounts</span>
                    </div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(192,57,43,0.15);color:#c0392b;">
                        <i class="fas fa-child"></i>
                    </div>
                    <div>
                        <span class="db-stat-num"><?= number_format($totalMinors) ?></span>
                        <span class="db-stat-label">Minors (under 18)</span>
                    </div>
                </div>
            </div>

            <!-- ── Filter toolbar ─────────────────────────────────────────── -->
            <form method="get" action="" id="filterForm">
                <div class="db-toolbar" style="margin-bottom:16px;">
                    <div class="db-search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search"
                            placeholder="Search by name..."
                            value="<?= esc($search ?? '') ?>"
                            onchange="document.getElementById('filterForm').submit()">
                    </div>
                    <div class="db-toolbar-actions">
                        <select name="zone" class="db-filter-select" onchange="this.form.submit()" style="min-width:120px;">
                            <option value="">All Zones</option>
                            <?php foreach (['Zone 1', 'Zone 2', 'Zone 3', 'Zone 4', 'Zone 5', 'Zone 6', 'Zone 7'] as $z): ?>
                                <option <?= ($filterZone ?? '') === $z ? 'selected' : '' ?>><?= $z ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select name="account" class="db-filter-select" onchange="this.form.submit()" style="min-width:160px;">
                            <option value="">All Account Status</option>
                            <option value="active" <?= ($filterAcct ?? '') === 'active'  ? 'selected' : '' ?>>Active Account</option>
                            <option value="pending" <?= ($filterAcct ?? '') === 'pending' ? 'selected' : '' ?>>Pending / Unverified</option>
                            <option value="none" <?= ($filterAcct ?? '') === 'none'    ? 'selected' : '' ?>>No Account</option>
                        </select>

                        <select name="age_group" class="db-filter-select" onchange="this.form.submit()" style="min-width:130px;">
                            <option value="">All Ages</option>
                            <option value="minor" <?= ($filterAge ?? '') === 'minor' ? 'selected' : '' ?>>Minor (under 18)</option>
                            <option value="adult" <?= ($filterAge ?? '') === 'adult' ? 'selected' : '' ?>>Adult (18+)</option>
                        </select>

                        <?php if (($search ?? '') !== '' || ($filterZone ?? '') !== '' || ($filterAcct ?? '') !== '' || ($filterAge ?? '') !== ''): ?>
                            <a href="/secretary/residents" class="db-btn db-btn--outline">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            <!-- ── Residents table ───────────────────────────────────────── -->
            <div class="db-table-wrap">
                <table class="db-table rl-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Household #</th>
                            <th>Relationship</th>
                            <th>Zone</th>
                            <th>Minor</th>
                            <th>Account Status</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($residents ?? [])): ?>
                            <tr>
                                <td colspan="8" class="rl-empty">
                                    <i class="fas fa-search"></i>
                                    No residents match the current filters.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $rowNum = ($currentPage - 1) * $perPage + 1;
                            $cutoff = (new DateTime('today'))->modify('-18 years');

                            foreach ($residents as $r):
                                $fullName = esc(strtoupper($r['last_name'])) . ', ' . esc(ucwords(strtolower($r['first_name'])));
                                if (! empty($r['middle_name'])) $fullName .= ' ' . esc(strtoupper($r['middle_name'][0])) . '.';
                                if (! empty($r['suffix']))      $fullName .= ' ' . esc($r['suffix']);
                                $initial = strtoupper($r['first_name'][0] ?? '?');

                                $dob     = ! empty($r['date_of_birth']) ? new DateTime($r['date_of_birth']) : null;
                                $isMinor = $dob ? ($dob > $cutoff) : null;

                                $acctStatus = $r['account_status'] ?? null;
                                $isHead     = ($r['relationship'] === 'Household Head');
                            ?>
                                <tr>
                                    <td style="color:#9aa0b4;font-size:12px;"><?= $rowNum++ ?></td>
                                    <td>
                                        <div class="db-resident-name">
                                            <div class="db-avatar-sm" style="<?= $isHead ? '' : 'background:#6b7280;width:28px;height:28px;font-size:11px;' ?>">
                                                <?= $initial ?>
                                            </div>
                                            <span style="font-weight:<?= $isHead ? '600' : '400' ?>;"><?= $fullName ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($isHead): ?>
                                            <a href="/secretary/household/<?= esc($r['household_no']) ?>"
                                                style="font-weight:700;color:#1d2448;text-decoration:none;">
                                                <?= esc($r['household_no']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span style="color:#9aa0b4;font-size:12px;padding-left:6px;">
                                                └ <?= esc($r['household_no']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="rl-badge <?= $isHead ? 'rl-badge--head' : 'rl-badge--member' ?>">
                                            <?= $isHead
                                                ? '<i class="fas fa-home"></i> Head'
                                                : '<i class="fas fa-user"></i> ' . esc(ucfirst($r['relationship'])) ?>
                                        </span>
                                    </td>
                                    <td><?= esc($r['zone'] ?? '—') ?></td>
                                    <td>
                                        <?php if ($isMinor === null): ?>
                                            <span style="color:#9aa0b4;font-size:12px;">—</span>
                                        <?php elseif ($isMinor): ?>
                                            <span class="rl-badge rl-badge--minor"><i class="fas fa-child"></i> Minor</span>
                                        <?php else: ?>
                                            <span style="color:#9aa0b4;font-size:12px;">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (! $isHead): ?>
                                            <span class="rl-badge rl-badge--none"><i class="fas fa-minus-circle"></i> N/A</span>
                                        <?php elseif ($acctStatus === 'active'): ?>
                                            <span class="rl-badge rl-badge--active"><i class="fas fa-check-circle"></i> Active</span>
                                        <?php elseif ($acctStatus === 'pending'): ?>
                                            <span class="rl-badge rl-badge--pending"><i class="fas fa-hourglass-half"></i> Pending</span>
                                        <?php elseif ($acctStatus === 'unverified'): ?>
                                            <span class="rl-badge rl-badge--pending"><i class="fas fa-envelope"></i> Unverified</span>
                                        <?php elseif ($acctStatus === 'rejected'): ?>
                                            <span class="rl-badge" style="background:#fde8e8;color:#c0392b;border:1px solid #f5c6cb;"><i class="fas fa-times-circle"></i> Rejected</span>
                                        <?php else: ?>
                                            <span class="rl-badge rl-badge--none"><i class="fas fa-user-slash"></i> No Account</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="color:#6b7280;font-size:12.5px;">
                                        <?= $r['username'] ? esc($r['username']) : '<span style="color:#d0d4df;">—</span>' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- ── Pagination ─────────────────────────────────────────────── -->
            <?php
            $totalPages = (int) ceil($total / $perPage);
            $start      = $total > 0 ? ($currentPage - 1) * $perPage + 1 : 0;
            $end        = min($currentPage * $perPage, $total);
            $qs = http_build_query(array_filter([
                'search'    => $search     ?? '',
                'zone'      => $filterZone ?? '',
                'account'   => $filterAcct ?? '',
                'age_group' => $filterAge  ?? '',
            ], fn($v) => $v !== ''));
            $qs = $qs ? '&' . $qs : '';
            ?>
            <?php if ($total > 0): ?>
                <div class="db-pagination">
                    <span class="db-page-info">
                        Showing <?= $start ?>–<?= $end ?> of <?= number_format($total) ?> resident<?= $total !== 1 ? 's' : '' ?>
                    </span>
                    <div class="db-page-btns">
                        <a href="?page=<?= max(1, $currentPage - 1) ?><?= $qs ?>"
                            class="db-page-btn <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <?php
                        $rangeStart = max(1, $currentPage - 3);
                        $rangeEnd   = min($totalPages, $currentPage + 3);
                        if ($rangeStart > 1): ?>
                            <a href="?page=1<?= $qs ?>" class="db-page-btn">1</a>
                            <?php if ($rangeStart > 2): ?><span class="db-page-btn" style="cursor:default;">…</span><?php endif; ?>
                        <?php endif; ?>
                        <?php for ($p = $rangeStart; $p <= $rangeEnd; $p++): ?>
                            <a href="?page=<?= $p ?><?= $qs ?>"
                                class="db-page-btn <?= $p === $currentPage ? 'active' : '' ?>"><?= $p ?></a>
                        <?php endfor; ?>
                        <?php if ($rangeEnd < $totalPages): ?>
                            <?php if ($rangeEnd < $totalPages - 1): ?><span class="db-page-btn" style="cursor:default;">…</span><?php endif; ?>
                            <a href="?page=<?= $totalPages ?><?= $qs ?>" class="db-page-btn"><?= $totalPages ?></a>
                        <?php endif; ?>
                        <a href="?page=<?= min($totalPages, $currentPage + 1) ?><?= $qs ?>"
                            class="db-page-btn <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        </div><!-- /.db-content -->
    </div><!-- /.db-main -->

    <!-- ── Approve modal ──────────────────────────────────────────────────── -->
    <div class="pa-overlay" id="approveModal">
        <div class="pa-modal">
            <div class="pa-modal-header">
                <div class="pa-modal-icon pa-modal-icon--approve"><i class="fas fa-user-check"></i></div>
                <div>
                    <div class="pa-modal-title">Approve Account</div>
                    <p class="pa-modal-sub">This account will be activated and the user can log in immediately.</p>
                </div>
            </div>
            <div class="pa-modal-body">
                <div class="pa-user-card">
                    <div class="pa-user-avatar" id="approveInitial">?</div>
                    <div>
                        <div class="pa-user-name" id="approveName">—</div>
                        <div class="pa-user-meta" id="approveMeta">—</div>
                    </div>
                </div>
            </div>
            <div class="pa-modal-footer">
                <button class="pa-btn pa-btn--cancel" onclick="closeModal('approveModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form id="approveForm" method="post" style="flex:1;display:flex;">
                    <?= csrf_field() ?>
                    <button type="submit" class="pa-btn pa-btn--approve" style="flex:1;">
                        <i class="fas fa-check"></i> Yes, Approve
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ── Reject modal ───────────────────────────────────────────────────── -->
    <div class="pa-overlay" id="rejectModal">
        <div class="pa-modal">
            <div class="pa-modal-header">
                <div class="pa-modal-icon pa-modal-icon--reject"><i class="fas fa-user-times"></i></div>
                <div>
                    <div class="pa-modal-title">Reject Account</div>
                    <p class="pa-modal-sub">This registration will be declined.</p>
                </div>
            </div>
            <div class="pa-modal-body">
                <div class="pa-user-card">
                    <div class="pa-user-avatar" id="rejectInitial">?</div>
                    <div>
                        <div class="pa-user-name" id="rejectName">—</div>
                        <div class="pa-user-meta" id="rejectMeta">—</div>
                    </div>
                </div>
                <div class="pa-reject-note">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>The user will not be able to log in. This action can be reviewed later if needed.</span>
                </div>
            </div>
            <div class="pa-modal-footer">
                <button class="pa-btn pa-btn--cancel" onclick="closeModal('rejectModal')">
                    <i class="fas fa-arrow-left"></i> Cancel
                </button>
                <form id="rejectForm" method="post" style="flex:1;display:flex;">
                    <?= csrf_field() ?>
                    <button type="submit" class="pa-btn pa-btn--reject" style="flex:1;">
                        <i class="fas fa-times"></i> Yes, Reject
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ── Pending panel toggle ──────────────────────────────────────────
        function togglePending() {
            const body = document.getElementById('paBody');
            const chevron = document.getElementById('paChevron');
            if (!body) return;
            const hidden = body.style.display === 'none';
            body.style.display = hidden ? '' : 'none';
            chevron.classList.toggle('open', hidden);
        }

        // ── Approve / Reject modals ───────────────────────────────────────
        function openApprove(id, name, username, role) {
            document.getElementById('approveName').textContent = name;
            document.getElementById('approveMeta').textContent = '@' + username + ' · ' + role;
            document.getElementById('approveInitial').textContent = name.charAt(0).toUpperCase();
            document.getElementById('approveForm').action = '/secretary/approve-account/' + id;
            document.getElementById('approveModal').classList.add('active');
        }

        function openReject(id, name, username, role) {
            document.getElementById('rejectName').textContent = name;
            document.getElementById('rejectMeta').textContent = '@' + username + ' · ' + role;
            document.getElementById('rejectInitial').textContent = name.charAt(0).toUpperCase();
            document.getElementById('rejectForm').action = '/secretary/reject-account/' + id;
            document.getElementById('rejectModal').classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        document.querySelectorAll('.pa-overlay').forEach(overlay => {
            overlay.addEventListener('click', e => {
                if (e.target === overlay) overlay.classList.remove('active');
            });
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape')
                document.querySelectorAll('.pa-overlay.active').forEach(m => m.classList.remove('active'));
        });
    </script>
</body>

</html>