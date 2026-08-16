<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Activities - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .ska-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 18px;
            margin-bottom: 32px;
        }

        .ska-card {
            background: #fff;
            border: 1.5px solid #e8ecf4;
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow .2s, border-color .2s;
        }

        .ska-card:hover {
            box-shadow: 0 6px 24px rgba(29, 36, 72, .1);
            border-color: #5b6fd6;
        }

        .ska-card-header {
            padding: 16px 20px 12px;
            border-bottom: 1px solid #f0f2f8;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .ska-cat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .ska-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #1a1d2e;
            margin: 0 0 4px;
        }

        .ska-card-meta {
            font-size: 11.5px;
            color: #9aa0b4;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .ska-card-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .ska-card-body {
            padding: 12px 20px;
            flex: 1;
        }

        .ska-desc {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.6;
            margin: 0 0 10px;
        }

        .ska-reqs {
            margin: 0;
            padding: 0;
        }

        .ska-reqs-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #9aa0b4;
            margin-bottom: 6px;
        }

        .ska-req-item {
            font-size: 12.5px;
            color: #4a5068;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 3px 0;
        }

        .ska-req-item i {
            color: #5b6fd6;
            font-size: 11px;
        }

        .ska-card-footer {
            padding: 12px 20px 16px;
            border-top: 1px solid #f0f2f8;
        }

        .ska-reg-count {
            font-size: 11.5px;
            color: #9aa0b4;
            margin-bottom: 8px;
        }

        .ska-status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        /* Registration status chip */
        .ska-reg-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .ska-reg-chip--pending {
            background: #fff8ee;
            color: #e6a800;
            border: 1px solid #f5d88a;
        }

        .ska-reg-chip--approved {
            background: #edfaf5;
            color: #16a085;
            border: 1px solid #a8e6d5;
        }

        .ska-reg-chip--rejected {
            background: #fff0f0;
            color: #c0392b;
            border: 1px solid #f5c0c0;
        }

        /* Category colours */
        .cat-sports {
            background: rgba(91, 111, 214, .12);
            color: #5b6fd6;
        }

        .cat-livelihood {
            background: rgba(255, 193, 7, .12);
            color: #e6a800;
        }

        .cat-health {
            background: rgba(220, 53, 69, .12);
            color: #dc3545;
        }

        .cat-education {
            background: rgba(22, 199, 154, .12);
            color: #16c79a;
        }

        .cat-environment {
            background: rgba(40, 167, 69, .12);
            color: #28a745;
        }

        .cat-cultural {
            background: rgba(111, 66, 193, .12);
            color: #6f42c1;
        }

        .cat-other {
            background: rgba(29, 36, 72, .08);
            color: #1d2448;
        }

        @media(max-width:640px) {
            .ska-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'resident';
    $active    = 'sk_activities';
    $pageTitle = 'SK Activities';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $programs = $programs ?? [];
    $catIcons = [
        'Sports'      => 'fa-futbol',
        'Livelihood'  => 'fa-briefcase',
        'Health'      => 'fa-heartbeat',
        'Education'   => 'fa-graduation-cap',
        'Environment' => 'fa-leaf',
        'Cultural'    => 'fa-music',
        'Other'       => 'fa-calendar',
    ];
    $badgeMap = [
        'Active'    => 'db-badge--approved',
        'Upcoming'  => 'db-badge--pending',
        'Completed' => 'db-badge--completed',
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
                <div class="db-alert db-alert--danger" style="margin-bottom:16px;">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Header -->
            <div class="db-welcome">
                <div>
                    <h2>SK Activities 🌟</h2>
                    <p>Sangguniang Kabataan — Barangay Bacolod programs open for participation.</p>
                </div>
                <div class="db-welcome-icon"><i class="fas fa-star"></i></div>
            </div>

            <?php if (empty($programs)): ?>
                <div style="text-align:center;padding:60px 20px;color:#9aa0b4;">
                    <i class="fas fa-calendar-times" style="font-size:42px;display:block;margin-bottom:14px;color:#d0d5e8;"></i>
                    <p style="font-size:14px;font-weight:600;color:#6b7280;margin:0 0 4px;">No activities yet</p>
                    <p style="font-size:13px;margin:0;">Check back later — the SK will post upcoming programs here.</p>
                </div>
            <?php else: ?>
                <div class="ska-grid">
                    <?php foreach ($programs as $p):
                        $catKey  = 'cat-' . strtolower($p['category']);
                        $icon    = $catIcons[$p['category']] ?? 'fa-calendar';
                        $badge   = $badgeMap[$p['status']] ?? 'db-badge--pending';
                        $dateStr = $p['start_date'] ? date('M d, Y', strtotime($p['start_date'])) : 'TBA';
                        $endStr  = $p['end_date']   ? ' – ' . date('M d, Y', strtotime($p['end_date'])) : '';
                        $reg     = $p['registration'];
                        $reqs    = $p['requirements_list'];
                    ?>
                        <div class="ska-card">
                            <div class="ska-card-header">
                                <div class="ska-cat-icon <?= $catKey ?>"><i class="fas <?= $icon ?>"></i></div>
                                <div style="flex:1;min-width:0;">
                                    <p class="ska-card-title"><?= esc($p['name']) ?></p>
                                    <div class="ska-card-meta">
                                        <span><i class="fas fa-tag"></i> <?= esc($p['category']) ?></span>
                                        <span><i class="fas fa-calendar"></i> <?= $dateStr . $endStr ?></span>
                                        <?php if (!empty($p['venue'])): ?>
                                            <span><i class="fas fa-map-marker-alt"></i> <?= esc($p['venue']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <span class="db-badge <?= $badge ?>" style="flex-shrink:0;"><?= esc($p['status']) ?></span>
                            </div>

                            <div class="ska-card-body">
                                <?php if (!empty($p['description'])): ?>
                                    <p class="ska-desc"><?= esc($p['description']) ?></p>
                                <?php endif; ?>

                                <?php if (!empty($reqs)): ?>
                                    <div class="ska-reqs">
                                        <p class="ska-reqs-title"><i class="fas fa-clipboard-list" style="margin-right:4px;"></i>Requirements</p>
                                        <?php foreach ($reqs as $req): ?>
                                            <div class="ska-req-item"><i class="fas fa-check-circle"></i><?= esc($req) ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="ska-card-footer">
                                <p class="ska-reg-count">
                                    <i class="fas fa-users" style="margin-right:4px;color:#b0b6cc;"></i>
                                    <?= $p['registration_count'] ?> registered
                                    <?php if ($p['target_participants'] > 0): ?>
                                        of <?= $p['target_participants'] ?> slots
                                    <?php endif; ?>
                                </p>
                                <div class="ska-status-row">
                                    <?php if ($reg): ?>
                                        <!-- Already registered -->
                                        <span class="ska-reg-chip ska-reg-chip--<?= $reg['status'] ?>">
                                            <?php if ($reg['status'] === 'pending'): ?>
                                                <i class="fas fa-clock"></i> Pending Approval
                                            <?php elseif ($reg['status'] === 'approved'): ?>
                                                <i class="fas fa-check-circle"></i> Approved
                                            <?php else: ?>
                                                <i class="fas fa-times-circle"></i> Not Approved
                                            <?php endif; ?>
                                        </span>
                                        <?php if ($reg['status'] === 'pending'): ?>
                                            <form action="/resident/sk-activities/unjoin/<?= (int)$p['id'] ?>" method="post" style="display:inline;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="db-btn db-btn--xs db-btn--outline"
                                                    onclick="return confirm('Cancel your registration for this activity?')">
                                                    Cancel
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php elseif ($p['status'] === 'Completed'): ?>
                                        <span style="font-size:12px;color:#9aa0b4;"><i class="fas fa-flag-checkered"></i> This activity has ended.</span>
                                    <?php else: ?>
                                        <!-- Not registered — show Join button -->
                                        <button class="db-btn db-btn--sm db-btn--primary"
                                            onclick="openJoinModal(<?= htmlspecialchars(json_encode([
                                                                        'id'    => $p['id'],
                                                                        'name'  => $p['name'],
                                                                        'reqs'  => $reqs,
                                                                    ]), ENT_QUOTES) ?>)">
                                            <i class="fas fa-hand-paper"></i> Join Activity
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- ═══ JOIN MODAL ═══ -->
    <div class="db-modal-overlay" id="joinModal" onclick="if(event.target===this)document.getElementById('joinModal').classList.remove('active')">
        <div class="db-modal" style="max-width:500px;width:96%;">
            <div class="db-modal-header" style="background:linear-gradient(135deg,#1d2448,#2e3a6e);">
                <h3 style="color:#fff;margin:0;font-size:15px;"><i class="fas fa-hand-paper" style="margin-right:8px;"></i><span id="joinModalTitle">Join Activity</span></h3>
                <button class="db-modal-close" style="background:rgba(255,255,255,.15);color:#fff;" onclick="document.getElementById('joinModal').classList.remove('active')"><i class="fas fa-times"></i></button>
            </div>
            <form id="joinForm" method="post">
                <?= csrf_field() ?>
                <div class="db-modal-body">

                    <!-- Requirements checklist (populated by JS) -->
                    <div id="joinReqsWrap" style="display:none;margin-bottom:16px;">
                        <p style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9aa0b4;margin:0 0 8px;">
                            <i class="fas fa-clipboard-list" style="margin-right:5px;"></i>Confirm Requirements
                        </p>
                        <p style="font-size:12.5px;color:#6b7280;margin:0 0 10px;">Check each requirement you have prepared:</p>
                        <div id="joinReqsList"></div>
                    </div>

                    <div class="db-form-group db-form-group--full">
                        <label style="font-size:12.5px;font-weight:600;color:#4a5068;">Additional Notes <span style="font-weight:400;color:#b0b6cc;">(optional)</span></label>
                        <textarea name="notes" rows="3" placeholder="Any notes for the SK officer…" style="width:100%;padding:9px 12px;border:1.5px solid #e2e5ef;border-radius:8px;font-size:13px;font-family:inherit;resize:vertical;"></textarea>
                    </div>

                    <div style="background:#f0f2ff;border:1px solid #c9d0f5;border-radius:8px;padding:10px 14px;font-size:12px;color:#4a5068;margin-top:8px;">
                        <i class="fas fa-info-circle" style="color:#5b6fd6;margin-right:6px;"></i>
                        Your registration will be reviewed by the SK officer. You will be notified when it is approved.
                    </div>
                </div>
                <div class="db-modal-footer">
                    <button type="button" class="db-btn db-btn--outline" onclick="document.getElementById('joinModal').classList.remove('active')">Cancel</button>
                    <button type="submit" class="db-btn db-btn--primary"><i class="fas fa-hand-paper"></i> Submit Registration</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openJoinModal(prog) {
            document.getElementById('joinModalTitle').textContent = 'Join: ' + prog.name;
            document.getElementById('joinForm').action = '/resident/sk-activities/join/' + prog.id;

            const reqWrap = document.getElementById('joinReqsWrap');
            const reqList = document.getElementById('joinReqsList');
            reqList.innerHTML = '';

            if (prog.reqs && prog.reqs.length > 0) {
                reqWrap.style.display = '';
                prog.reqs.forEach((r, i) => {
                    const label = document.createElement('label');
                    label.style.cssText = 'display:flex;align-items:center;gap:8px;padding:6px 0;font-size:13px;color:#1a1d2e;cursor:pointer;border-bottom:1px solid #f5f6fa;';
                    label.innerHTML = `<input type="checkbox" name="requirements[]" value="${r}" style="width:15px;height:15px;accent-color:#1d2448;"> ${r}`;
                    reqList.appendChild(label);
                });
            } else {
                reqWrap.style.display = 'none';
            }

            document.getElementById('joinModal').classList.add('active');
        }

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>