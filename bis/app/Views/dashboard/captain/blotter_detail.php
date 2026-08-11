<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blotter Report - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .bl-grid {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 20px;
            align-items: start;
        }

        .bl-card {
            background: #fff;
            border: 1px solid #e8ecf4;
            border-radius: 14px;
            padding: 20px 22px;
            margin-bottom: 20px;
        }

        .bl-card-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0 0 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bl-card-title i {
            color: #9aa0b4;
        }

        .bl-detail-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        .bl-detail-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 9px 0;
            border-bottom: 1px solid #f5f6fa;
        }

        .bl-detail-item span:first-child {
            font-size: 10px;
            font-weight: 600;
            color: #9aa0b4;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .bl-detail-item strong {
            font-size: 13px;
            color: #1a1d2e;
        }

        .bl-narrative {
            font-size: 13px;
            color: #555;
            line-height: 1.75;
            margin: 0;
            background: #f8f9fc;
            border: 1px solid #e8ecf4;
            border-radius: 8px;
            padding: 12px;
        }

        .bl-form-group {
            margin-bottom: 14px;
        }

        .bl-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #4a5068;
            margin-bottom: 5px;
        }

        .bl-input,
        .bl-select,
        .bl-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e2e5ef;
            border-radius: 8px;
            font-size: 13.5px;
            font-family: 'Poppins', sans-serif;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            transition: border-color .2s;
            box-sizing: border-box;
        }

        .bl-input:focus,
        .bl-select:focus,
        .bl-textarea:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, 0.08);
        }

        .bl-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .bl-btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all .2s;
            border: none;
        }

        .bl-btn--primary {
            background: #1d2448;
            color: #fff;
        }

        .bl-btn--primary:hover {
            background: #2e3a6e;
        }

        .bl-btn--danger {
            background: #c0392b;
            color: #fff;
        }

        .bl-btn--danger:hover {
            background: #a93226;
        }

        .bl-btn--outline {
            background: #fff;
            color: #1d2448;
            border: 1.5px solid #1d2448;
        }

        .bl-btn--full {
            width: 100%;
            justify-content: center;
        }

        .bl-summons-sent {
            background: #f0faf6;
            border: 1px solid #c3e8d8;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 12.5px;
            color: #1a7a55;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        @media (max-width:1024px) {
            .bl-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = $role ?? 'captain';
    $active    = 'blotter';
    $pageTitle = 'Blotter Report';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $r = $report ?? [];
    $caseNo = str_pad($r['id'] ?? 0, 4, '0', STR_PAD_LEFT);

    $statusMap = [
        'pending'            => ['db-badge--pending',  'Pending'],
        'under_investigation' => ['db-badge--info',     'Under Investigation'],
        'resolved'           => ['db-badge--approved', 'Resolved'],
        'dismissed'          => ['db-badge--rejected', 'Dismissed'],
    ];
    [$badgeClass, $statusLabel] = $statusMap[$r['status'] ?? 'pending'] ?? $statusMap['pending'];
    ?>

    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <!-- Breadcrumb -->
            <div class="hh-breadcrumb" style="margin-bottom:20px;">
                <a href="/<?= $role ?>/blotter" class="hh-back"><i class="fas fa-arrow-left"></i> Back to Blotter Reports</a>
                <span class="hh-bc-sep">/</span>
                <span>Case #<?= $caseNo ?></span>
            </div>

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

            <!-- Header card -->
            <div class="cld-header-card" style="margin-bottom:20px;">
                <div class="cld-avatar" style="background:#c0392b;"><?= strtoupper(($r['complainant_full_name'] ?? 'U')[0]) ?></div>
                <div class="cld-header-info">
                    <h2><?= esc($r['complainant_full_name'] ?? '—') ?>
                        <span class="hh-head-badge">Complainant</span>
                    </h2>
                    <div class="cld-header-meta">
                        <span><i class="fas fa-envelope"></i> <?= esc($r['complainant_email_addr'] ?? '—') ?></span>
                        <span><i class="fas fa-exclamation-triangle"></i> <?= esc($r['incident_type']) ?></span>
                        <?php if ($r['incident_date']): ?>
                            <span><i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($r['incident_date'])) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="cld-header-right">
                    <span class="db-badge <?= $badgeClass ?>"><?= $statusLabel ?></span>
                </div>
            </div>

            <div class="bl-grid">

                <!-- LEFT: Report details + status update -->
                <div>
                    <!-- Report details -->
                    <div class="bl-card">
                        <h4 class="bl-card-title"><i class="fas fa-file-alt"></i> Report Details</h4>
                        <div class="bl-detail-list">
                            <div class="bl-detail-item"><span>Case #</span><strong>#<?= $caseNo ?></strong></div>
                            <div class="bl-detail-item"><span>Status</span><span class="db-badge <?= $badgeClass ?>"><?= $statusLabel ?></span></div>
                            <div class="bl-detail-item"><span>Incident Type</span><strong><?= esc($r['incident_type']) ?></strong></div>
                            <div class="bl-detail-item"><span>Date Filed</span><strong><?= date('M d, Y', strtotime($r['created_at'])) ?></strong></div>
                            <div class="bl-detail-item"><span>Incident Date</span><strong><?= $r['incident_date'] ? date('M d, Y', strtotime($r['incident_date'])) : '—' ?></strong></div>
                            <div class="bl-detail-item"><span>Incident Time</span><strong><?= $r['incident_time'] ? date('h:i A', strtotime($r['incident_time'])) : '—' ?></strong></div>
                            <div class="bl-detail-item" style="grid-column:1/-1;"><span>Location</span><strong><?= esc($r['location'] ?? '—') ?></strong></div>
                            <div class="bl-detail-item" style="grid-column:1/-1;"><span>Persons Involved</span><strong><?= esc($r['persons_involved'] ?? '—') ?></strong></div>
                        </div>
                    </div>

                    <!-- Narrative -->
                    <div class="bl-card">
                        <h4 class="bl-card-title"><i class="fas fa-align-left"></i> Narrative</h4>
                        <p class="bl-narrative"><?= nl2br(esc($r['narrative'] ?? '')) ?></p>
                    </div>

                    <!-- Update status -->
                    <div class="bl-card">
                        <h4 class="bl-card-title"><i class="fas fa-tasks"></i> Update Status</h4>
                        <form action="/<?= $role ?>/blotter/status/<?= $r['id'] ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="bl-form-group">
                                <label>Status</label>
                                <select name="status" class="bl-select">
                                    <option value="pending" <?= ($r['status'] ?? '') === 'pending'            ? 'selected' : '' ?>>Pending</option>
                                    <option value="under_investigation" <?= ($r['status'] ?? '') === 'under_investigation' ? 'selected' : '' ?>>Under Investigation</option>
                                    <option value="resolved" <?= ($r['status'] ?? '') === 'resolved'           ? 'selected' : '' ?>>Resolved</option>
                                    <option value="dismissed" <?= ($r['status'] ?? '') === 'dismissed'          ? 'selected' : '' ?>>Dismissed</option>
                                </select>
                            </div>
                            <div class="bl-form-group">
                                <label>Remarks</label>
                                <textarea name="remarks" class="bl-textarea" placeholder="Add notes or remarks..."><?= esc($r['remarks'] ?? '') ?></textarea>
                            </div>
                            <button type="submit" class="bl-btn bl-btn--primary bl-btn--full">
                                <i class="fas fa-save"></i> Save Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- RIGHT: Summons + Schedule Management -->
                <div>
                    <!-- ── Schedule Management Card ── -->
                    <div class="bl-card">
                        <h4 class="bl-card-title"><i class="fas fa-calendar-alt"></i> Hearing Schedule</h4>

                        <?php if (! empty($r['hearing_date'])): ?>
                            <!-- Current schedule display -->
                            <div style="background:linear-gradient(135deg,#1d2448,#2e3a6e);border-radius:10px;padding:16px 18px;margin-bottom:16px;color:#fff;">
                                <div style="font-size:10px;font-weight:700;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">
                                    <i class="fas fa-calendar-check"></i> Scheduled Hearing
                                </div>
                                <div style="font-size:18px;font-weight:700;margin-bottom:4px;">
                                    <?= date('F d, Y', strtotime($r['hearing_date'])) ?>
                                </div>
                                <div style="font-size:14px;color:rgba(255,255,255,.8);margin-bottom:8px;">
                                    <i class="fas fa-clock" style="margin-right:5px;"></i>
                                    <?= date('h:i A', strtotime($r['hearing_time'])) ?>
                                    &nbsp;&middot;&nbsp;
                                    <i class="fas fa-map-marker-alt" style="margin-right:5px;"></i>
                                    Barangay Hall
                                </div>
                                <?php if (! empty($r['hearing_notes'])): ?>
                                    <div style="font-size:12px;color:rgba(255,255,255,.65);border-top:1px solid rgba(255,255,255,.15);padding-top:8px;margin-top:4px;">
                                        <i class="fas fa-sticky-note" style="margin-right:4px;"></i>
                                        <?= esc($r['hearing_notes']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Letter button -->
                            <a href="/<?= $role ?>/blotter/letter/<?= $r['id'] ?>" target="_blank"
                                class="bl-btn bl-btn--primary bl-btn--full" style="margin-bottom:12px;text-decoration:none;">
                                <i class="fas fa-file-alt"></i> View / Print Summons Letter
                                <?php if (! empty($r['letter_issued_at'])): ?>
                                    <span style="font-size:10px;font-weight:400;opacity:.75;margin-left:4px;">
                                        (last issued <?= date('M d', strtotime($r['letter_issued_at'])) ?>)
                                    </span>
                                <?php endif; ?>
                            </a>

                            <!-- Reschedule toggle -->
                            <button type="button" class="bl-btn bl-btn--outline bl-btn--full"
                                onclick="document.getElementById('rescheduleForm').style.display = document.getElementById('rescheduleForm').style.display === 'none' ? '' : 'none'">
                                <i class="fas fa-calendar-edit"></i> Reschedule Hearing
                            </button>

                            <!-- Reschedule form (hidden by default) -->
                            <div id="rescheduleForm" style="display:none;margin-top:14px;padding-top:14px;border-top:1px solid #f0f2f8;">
                                <form action="/<?= $role ?>/blotter/reschedule/<?= $r['id'] ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;">
                                        <div class="bl-form-group" style="margin:0;">
                                            <label>New Date <span style="color:#c0392b;">*</span></label>
                                            <input type="date" name="hearing_date" class="bl-input"
                                                value="<?= esc($r['hearing_date']) ?>" required>
                                        </div>
                                        <div class="bl-form-group" style="margin:0;">
                                            <label>New Time <span style="color:#c0392b;">*</span></label>
                                            <input type="time" name="hearing_time" class="bl-input"
                                                value="<?= esc($r['hearing_time']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="bl-form-group">
                                        <label>Notes / Reason for Rescheduling</label>
                                        <textarea name="hearing_notes" class="bl-textarea"
                                            placeholder="e.g. Rescheduled due to unavailability of parties..."><?= esc($r['hearing_notes'] ?? '') ?></textarea>
                                    </div>
                                    <button type="submit" class="bl-btn bl-btn--primary bl-btn--full">
                                        <i class="fas fa-save"></i> Save New Schedule
                                    </button>
                                </form>
                            </div>

                        <?php else: ?>
                            <!-- No schedule yet -->
                            <div style="text-align:center;padding:20px 0;color:#9aa0b4;">
                                <i class="fas fa-calendar-times" style="font-size:28px;display:block;margin-bottom:8px;color:#d0d5e8;"></i>
                                <p style="font-size:13px;">No hearing scheduled yet.</p>
                                <p style="font-size:12px;margin-top:4px;">Set a schedule in the Summons section below.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- ── Summons Card ── -->
                    <div class="bl-card">
                        <h4 class="bl-card-title"><i class="fas fa-envelope"></i> Send Summons</h4>

                        <?php if ($r['summons_sent_at']): ?>
                            <div class="bl-summons-sent" style="margin-bottom:16px;">
                                <i class="fas fa-check-circle"></i>
                                <span>Last Save <strong><?= date('M d, Y h:i A', strtotime($r['summons_sent_at'])) ?></strong></span>
                            </div>
                        <?php endif; ?>

                        <form action="/<?= $role ?>/blotter/summons/<?= $r['id'] ?>" method="post">
                            <?= csrf_field() ?>

                            <div style="background:#f8f9fc;border:1px solid #e8ecf4;border-radius:10px;padding:14px 16px;margin-bottom:16px;">
                                <div style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">
                                    <i class="fas fa-user-tie"></i> Complainant (auto-filled)
                                </div>
                                <div style="font-size:13px;font-weight:600;color:#1a1d2e;"><?= esc($r['complainant_full_name'] ?? '—') ?></div>
                                <div style="font-size:12px;color:#9aa0b4;"><?= esc($r['complainant_email_addr'] ?? '—') ?></div>
                            </div>

                            <div style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.5px;margin:16px 0 10px;">
                                <i class="fas fa-calendar-alt"></i> Hearing Schedule
                            </div>

                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:10px;">
                                <div class="bl-form-group" style="margin:0;">
                                    <label>Hearing Date <span style="color:#c0392b;">*</span></label>
                                    <input type="date" name="hearing_date" class="bl-input"
                                        value="<?= esc($r['hearing_date'] ?? '') ?>" required>
                                </div>
                                <div class="bl-form-group" style="margin:0;">
                                    <label>Hearing Time <span style="color:#c0392b;">*</span></label>
                                    <input type="time" name="hearing_time" class="bl-input"
                                        value="<?= esc($r['hearing_time'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="bl-form-group">
                                <label>Hearing Notes (optional)</label>
                                <input type="text" name="hearing_notes" class="bl-input"
                                    value="<?= esc($r['hearing_notes'] ?? '') ?>"
                                    placeholder="e.g. Bring supporting documents">
                            </div>

                            <button type="submit" class="bl-btn bl-btn--danger bl-btn--full">
                                <i class="fas fa-paper-plane"></i>
                                <?= $r['summons_sent_at'] ? 'Save Edit' : 'Save' ?>
                            </button>
                        </form>
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