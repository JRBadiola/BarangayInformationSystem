<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrations - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role      = 'sk';
    $active    = 'programs';
    $pageTitle = 'Registrations';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $program       = $program       ?? [];
    $registrations = $registrations ?? [];
    $reqList       = $reqList       ?? [];

    $badgeMap = [
        'pending'  => 'db-badge--pending',
        'approved' => 'db-badge--approved',
        'rejected' => 'db-badge--danger',
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

            <!-- Breadcrumb -->
            <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#9aa0b4;margin-bottom:16px;">
                <a href="/sk/programs" style="color:#5b6fd6;text-decoration:none;font-weight:500;display:flex;align-items:center;gap:5px;">
                    <i class="fas fa-arrow-left"></i> Programs
                </a>
                <span>›</span>
                <span><?= esc($program['name'] ?? 'Registrations') ?></span>
            </div>

            <!-- Program summary card -->
            <div style="background:#fff;border:1px solid #e8ecf4;border-radius:14px;padding:18px 22px;margin-bottom:22px;display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;">
                <div>
                    <h2 style="margin:0 0 4px;font-size:17px;font-weight:700;color:#1a1d2e;"><?= esc($program['name'] ?? '') ?></h2>
                    <div style="display:flex;flex-wrap:wrap;gap:12px;font-size:12px;color:#6b7280;margin-top:4px;">
                        <span><i class="fas fa-tag" style="margin-right:4px;color:#b0b6cc;"></i><?= esc($program['category'] ?? '') ?></span>
                        <?php if (!empty($program['start_date'])): ?>
                            <span><i class="fas fa-calendar" style="margin-right:4px;color:#b0b6cc;"></i><?= date('M d, Y', strtotime($program['start_date'])) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($program['venue'])): ?>
                            <span><i class="fas fa-map-marker-alt" style="margin-right:4px;color:#b0b6cc;"></i><?= esc($program['venue']) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($reqList)): ?>
                        <div style="margin-top:8px;font-size:12px;color:#9aa0b4;">
                            <i class="fas fa-clipboard-list" style="margin-right:5px;"></i>Requirements:
                            <?= esc(implode(', ', $reqList)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div style="text-align:center;background:#f5f7ff;padding:10px 18px;border-radius:10px;min-width:90px;">
                    <div style="font-size:22px;font-weight:700;color:#1d2448;"><?= count($registrations) ?></div>
                    <div style="font-size:11px;color:#9aa0b4;">Registered</div>
                </div>
            </div>

            <!-- Registrations table -->
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Resident</th>
                            <th>Requirements Submitted</th>
                            <th>Notes</th>
                            <th>Registered</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($registrations)): ?>
                            <tr>
                                <td colspan="7" style="text-align:center;padding:32px;color:#9aa0b4;">
                                    <i class="fas fa-users" style="font-size:26px;display:block;margin-bottom:8px;color:#d0d5e8;"></i>
                                    No registrations yet for this program.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($registrations as $i => $r):
                                $badge = $badgeMap[$r['status']] ?? 'db-badge--pending';
                                $submitted = array_filter(array_map('trim', explode(',', $r['requirements_submitted'] ?? '')));
                            ?>
                                <tr>
                                    <td><?= str_pad($i + 1, 3, '0', STR_PAD_LEFT) ?></td>
                                    <td>
                                        <div style="font-weight:600;color:#1a1d2e;"><?= esc($r['resident_name'] ?? '—') ?></div>
                                        <div style="font-size:11.5px;color:#9aa0b4;">@<?= esc($r['username'] ?? '') ?> · <?= esc($r['email'] ?? '') ?></div>
                                    </td>
                                    <td>
                                        <?php if (!empty($submitted)): ?>
                                            <?php foreach ($submitted as $s): ?>
                                                <span style="display:inline-flex;align-items:center;gap:4px;font-size:11.5px;background:#edfaf5;color:#16a085;border:1px solid #a8e6d5;padding:2px 8px;border-radius:12px;margin:2px 2px 2px 0;">
                                                    <i class="fas fa-check" style="font-size:9px;"></i><?= esc($s) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span style="color:#b0b6cc;font-size:12px;">None submitted</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-size:12.5px;color:#6b7280;"><?= esc($r['notes'] ?? '—') ?></td>
                                    <td style="font-size:12px;color:#9aa0b4;"><?= $r['created_at'] ? date('M d, Y', strtotime($r['created_at'])) : '—' ?></td>
                                    <td><span class="db-badge <?= $badge ?>"><?= ucfirst($r['status']) ?></span></td>
                                    <td>
                                        <?php if ($r['status'] === 'pending'): ?>
                                            <div style="display:flex;gap:6px;">
                                                <form action="/sk/programs/registrations/update/<?= (int)$r['id'] ?>" method="post" style="display:inline;">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="db-btn db-btn--xs db-btn--success">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>
                                                <form action="/sk/programs/registrations/update/<?= (int)$r['id'] ?>" method="post" style="display:inline;">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="db-btn db-btn--xs db-btn--danger">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <span style="font-size:12px;color:#b0b6cc;">Processed</span>
                                        <?php endif; ?>
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