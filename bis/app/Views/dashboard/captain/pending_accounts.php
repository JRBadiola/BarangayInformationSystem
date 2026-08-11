<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Accounts - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
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
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
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
            background: rgba(22, 199, 154, 0.12);
            color: #16c79a;
        }

        .pa-modal-icon--reject {
            background: rgba(192, 57, 43, 0.1);
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
    $role      = 'captain';
    $active    = 'settings';
    $pageTitle = 'Pending Accounts';
    include(APPPATH . 'Views/dashboard/sidebar.php');
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div class="db-page-header">
                <h2><i class="fas fa-user-clock"></i> Pending Account Approvals</h2>
                <p>Review and approve or reject new SK and Resident registrations.</p>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="db-alert db-alert--success">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="db-alert db-alert--error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (empty($pending)): ?>
                <div class="db-empty-state">
                    <i class="fas fa-check-double"></i>
                    <p>No pending accounts. All registrations have been reviewed.</p>
                </div>
            <?php else: ?>
                <div class="db-table-wrap">
                    <table class="db-table">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending as $user):
                                $displayName = trim($user['first_name'] . ' ' . $user['last_name']);
                                $initial = strtoupper(substr($user['first_name'], 0, 1));
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
                                    <td><span style="color:#6b7280;">@<?= esc($user['username']) ?></span></td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td>
                                        <span class="db-badge db-badge--<?= $user['role'] === 'sk' ? 'info' : 'default' ?>">
                                            <?= strtoupper(esc($user['role'])) ?>
                                        </span>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <div class="db-action-group">
                                            <button type="button"
                                                class="db-btn db-btn--success db-btn--sm"
                                                onclick="openApprove(<?= $user['id'] ?>, '<?= esc($displayName, 'js') ?>', '<?= esc($user['username'], 'js') ?>', '<?= strtoupper(esc($user['role'], 'js')) ?>')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button type="button"
                                                class="db-btn db-btn--danger db-btn--sm"
                                                onclick="openReject(<?= $user['id'] ?>, '<?= esc($displayName, 'js') ?>', '<?= esc($user['username'], 'js') ?>', '<?= strtoupper(esc($user['role'], 'js')) ?>')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- ── Approve Confirmation Modal ── -->
    <div class="pa-overlay" id="approveModal">
        <div class="pa-modal">
            <div class="pa-modal-header">
                <div class="pa-modal-icon pa-modal-icon--approve">
                    <i class="fas fa-user-check"></i>
                </div>
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

    <!-- ── Reject Confirmation Modal ── -->
    <div class="pa-overlay" id="rejectModal">
        <div class="pa-modal">
            <div class="pa-modal-header">
                <div class="pa-modal-icon pa-modal-icon--reject">
                    <i class="fas fa-user-times"></i>
                </div>
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
        function openApprove(id, name, username, role) {
            document.getElementById('approveName').textContent = name;
            document.getElementById('approveMeta').textContent = '@' + username + ' · ' + role;
            document.getElementById('approveInitial').textContent = name.charAt(0).toUpperCase();
            document.getElementById('approveForm').action = '/captain/approve-account/' + id;
            document.getElementById('approveModal').classList.add('active');
        }

        function openReject(id, name, username, role) {
            document.getElementById('rejectName').textContent = name;
            document.getElementById('rejectMeta').textContent = '@' + username + ' · ' + role;
            document.getElementById('rejectInitial').textContent = name.charAt(0).toUpperCase();
            document.getElementById('rejectForm').action = '/captain/reject-account/' + id;
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
            if (e.key === 'Escape') {
                document.querySelectorAll('.pa-overlay.active').forEach(m => m.classList.remove('active'));
            }
        });

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>