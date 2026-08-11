<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blotter Reports - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role   = $role   ?? 'captain';
    $active = 'blotter';
    $pageTitle = 'Blotter Reports';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $reports       = $reports       ?? [];
    $pending       = $pending       ?? 0;
    $investigating = $investigating ?? 0;
    $resolved      = $resolved      ?? 0;
    $total         = $total         ?? 0;
    $statusFilter  = $statusFilter  ?? '';
    $search        = $search        ?? '';

    $statusMap = [
        'pending'           => ['db-badge--pending',  'fa-clock',          'Pending'],
        'under_investigation' => ['db-badge--info',    'fa-search',         'Under Investigation'],
        'resolved'          => ['db-badge--approved', 'fa-check-circle',   'Resolved'],
        'dismissed'         => ['db-badge--rejected', 'fa-times-circle',   'Dismissed'],
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

            <!-- Stats -->
            <div class="db-stats" style="margin-bottom:24px;">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,0.15);color:#ffc107;"><i class="fas fa-clock"></i></div>
                    <div><span class="db-stat-num"><?= $pending ?></span><span class="db-stat-label">Pending</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-search"></i></div>
                    <div><span class="db-stat-num"><?= $investigating ?></span><span class="db-stat-label">Under Investigation</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,0.15);color:#16c79a;"><i class="fas fa-check-circle"></i></div>
                    <div><span class="db-stat-num"><?= $resolved ?></span><span class="db-stat-label">Resolved</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(29,36,72,0.1);color:#1d2448;"><i class="fas fa-file-alt"></i></div>
                    <div><span class="db-stat-num"><?= $total ?></span><span class="db-stat-label">Total Reports</span></div>
                </div>
            </div>

            <!-- Toolbar -->
            <form method="get" action="">
                <div class="db-toolbar">
                    <div class="db-search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Search by name or incident type..."
                            value="<?= esc($search) ?>" onchange="this.form.submit()">
                    </div>
                    <div class="db-toolbar-actions">
                        <select class="db-filter-select" name="status" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="pending" <?= $statusFilter === 'pending'            ? 'selected' : '' ?>>Pending</option>
                            <option value="under_investigation" <?= $statusFilter === 'under_investigation' ? 'selected' : '' ?>>Under Investigation</option>
                            <option value="resolved" <?= $statusFilter === 'resolved'           ? 'selected' : '' ?>>Resolved</option>
                            <option value="dismissed" <?= $statusFilter === 'dismissed'          ? 'selected' : '' ?>>Dismissed</option>
                        </select>
                    </div>
                </div>
            </form>

            <!-- Table -->
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Complainant</th>
                            <th>Incident Type</th>
                            <th>Date of Incident</th>
                            <th>Persons Involved</th>
                            <th>Date Filed</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($reports)): ?>
                            <tr>
                                <td colspan="8" style="text-align:center;padding:32px;color:#9aa0b4;">
                                    <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                    No blotter reports found.
                                </td>
                            </tr>
                            <?php else: foreach ($reports as $r):
                                [$badgeClass, $icon, $label] = $statusMap[$r['status']] ?? $statusMap['pending'];
                                $displayName = $r['complainant_full_name'] ?? $r['complainant_name'] ?? '—';
                                $displayEmail = $r['complainant_email_addr'] ?? $r['complainant_email'] ?? '';
                                $initial  = strtoupper(($displayName)[0] ?? 'U');
                                $isWalkin = empty($r['complainant_user_id']);
                                $filed    = date('M d, Y', strtotime($r['created_at']));
                                $incDate  = $r['incident_date'] ? date('M d, Y', strtotime($r['incident_date'])) : '—';
                            ?>
                                <tr>
                                    <td><strong>#<?= str_pad($r['id'], 4, '0', STR_PAD_LEFT) ?></strong></td>
                                    <td>
                                        <div class="db-resident-name">
                                            <div class="db-avatar-sm" style="<?= $isWalkin ? 'background:#5b6fd6;' : '' ?>"><?= $initial ?></div>
                                            <div>
                                                <div style="font-weight:600;font-size:13px;"><?= esc($displayName) ?></div>
                                                <div style="font-size:11px;color:#9aa0b4;display:flex;align-items:center;gap:5px;">
                                                    <?= esc($displayEmail) ?>
                                                    <?php if ($isWalkin): ?>
                                                        <span style="background:#f0f4ff;color:#5b6fd6;font-size:10px;font-weight:700;padding:1px 6px;border-radius:100px;">Walk-in</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc($r['incident_type']) ?></td>
                                    <td><?= $incDate ?></td>
                                    <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= esc($r['persons_involved'] ?? '—') ?></td>
                                    <td><?= $filed ?></td>
                                    <td><span class="db-badge <?= $badgeClass ?>"><i class="fas <?= $icon ?>"></i> <?= $label ?></span></td>
                                    <td>
                                        <a href="/<?= $role ?>/blotter/<?= $r['id'] ?>" class="db-btn db-btn--sm db-btn--outline">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                        <?php endforeach;
                        endif; ?>
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