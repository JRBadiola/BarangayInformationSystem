<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Clearances - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        /* ── Empty state ── */
        .clr-empty {
            text-align: center;
            padding: 48px 20px;
            color: #9aa0b4;
        }

        .clr-empty i {
            font-size: 40px;
            display: block;
            margin-bottom: 12px;
            color: #d0d5e8;
        }

        /* ── Modal ── */
        .clr-modal {
            max-width: 560px;
            border-radius: 16px;
            overflow: hidden;
        }

        .clr-modal-header {
            background: linear-gradient(135deg, #1d2448 0%, #2e3a6e 100%);
            padding: 22px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .clr-modal-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .clr-modal-header-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
        }

        .clr-modal-header h3 {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 2px;
        }

        .clr-modal-header p {
            color: rgba(255, 255, 255, 0.65);
            font-size: 12px;
            margin: 0;
        }

        .clr-modal-close {
            background: rgba(255, 255, 255, 0.12);
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
        }

        .clr-modal-close:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Form body */
        .clr-form-body {
            padding: 24px 28px;
            background: #f9fafb;
        }

        .clr-section {
            margin-bottom: 22px;
        }

        .clr-section-label {
            font-size: 11px;
            font-weight: 700;
            color: #9aa0b4;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .clr-section-label i {
            color: #1d2448;
        }

        /* Member pills */
        .clr-member-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .clr-member-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border: 2px solid #e2e5ef;
            border-radius: 12px;
            cursor: pointer;
            background: #fff;
            transition: all .2s;
            font-family: 'Poppins', sans-serif;
        }

        .clr-member-pill:hover {
            border-color: #1d2448;
            background: #f0f2ff;
        }

        .clr-member-pill.selected {
            border-color: #1d2448;
            background: #1d2448;
        }

        .clr-member-pill input[type="radio"] {
            display: none;
        }

        .clr-member-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #eef0fb;
            color: #1d2448;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .clr-member-pill.selected .clr-member-avatar {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .clr-member-name {
            font-size: 12.5px;
            font-weight: 600;
            color: #1a1d2e;
            line-height: 1.3;
        }

        .clr-member-rel {
            font-size: 11px;
            color: #9aa0b4;
        }

        .clr-member-pill.selected .clr-member-name,
        .clr-member-pill.selected .clr-member-rel {
            color: #fff;
        }

        /* Doc type cards */
        .clr-doc-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .clr-doc-card {
            border: 2px solid #e2e5ef;
            border-radius: 12px;
            padding: 16px 12px;
            text-align: center;
            cursor: pointer;
            background: #fff;
            transition: all .2s;
            font-family: 'Poppins', sans-serif;
            position: relative;
        }

        .clr-doc-card:hover {
            border-color: #1d2448;
            background: #f8f9ff;
            transform: translateY(-1px);
        }

        .clr-doc-card.selected {
            border-color: #1d2448;
            background: #1d2448;
        }

        .clr-doc-card input[type="radio"] {
            display: none;
        }

        .clr-doc-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #eef0fb;
            color: #1d2448;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin: 0 auto 10px;
        }

        .clr-doc-card.selected .clr-doc-icon {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .clr-doc-name {
            font-size: 11.5px;
            font-weight: 700;
            color: #1a1d2e;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .clr-doc-fee {
            font-size: 11px;
            color: #9aa0b4;
            font-weight: 600;
        }

        .clr-doc-card.selected .clr-doc-name,
        .clr-doc-card.selected .clr-doc-fee {
            color: #fff;
        }

        .clr-doc-check {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: #fff;
        }

        .clr-doc-card.selected .clr-doc-check {
            display: flex;
        }

        /* Select & textarea */
        .clr-select,
        .clr-textarea {
            width: 100%;
            padding: 11px 14px;
            border: 2px solid #e2e5ef;
            border-radius: 10px;
            font-size: 13.5px;
            font-family: 'Poppins', sans-serif;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box;
        }

        .clr-select:focus,
        .clr-textarea:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, 0.08);
        }

        .clr-textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Info note */
        .clr-info-note {
            background: #f0f4ff;
            border: 1px solid #d0d8f5;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 12.5px;
            color: #4a5068;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .clr-info-note i {
            color: #5b6fd6;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Submit btn */
        .clr-submit-btn {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: opacity .2s, transform .15s;
        }

        .clr-submit-btn:hover {
            opacity: .92;
            transform: translateY(-1px);
        }

        /* Status badges */
        .clr-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 100px;
        }

        .clr-badge--pending {
            background: #fff8f0;
            color: #b7600a;
            border: 1px solid #fde8c8;
        }

        .clr-badge--approved {
            background: #f0faf6;
            color: #1a7a55;
            border: 1px solid #c3e8d8;
        }

        .clr-badge--rejected {
            background: #fff0f1;
            color: #c0392b;
            border: 1px solid #fad4d4;
        }

        .clr-badge--released {
            background: #eef0fb;
            color: #1d2448;
            border: 1px solid #d0d8f5;
        }

        /* No household warning */
        .clr-no-hh {
            background: #fff8f0;
            border: 1px solid #fde8c8;
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 13px;
            color: #b7600a;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        /* Divider */
        .clr-divider {
            height: 1px;
            background: #f0f2f8;
            margin: 0 0 20px;
        }

        /* Indigency ineligible state */
        .clr-doc-card--ineligible {
            opacity: .6;
            cursor: not-allowed !important;
            pointer-events: none;
            border-color: #fad4d4 !important;
            background: #fff5f5 !important;
        }

        .clr-indig-warn {
            margin-top: 6px;
            font-size: 10px;
            font-weight: 700;
            color: #c0392b;
            background: #fff0f1;
            border: 1px solid #fad4d4;
            border-radius: 6px;
            padding: 3px 7px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        gap: 8px;
        padding: 8px 14px;
        border: 1.5px solid #e2e5ef;
        border-radius: 100px;
        cursor: pointer;
        font-size: 12.5px;
        font-weight: 500;
        color: #4a5068;
        background: #fff;
        transition: all .2s;
        font-family: 'Poppins',
        sans-serif;
        }

        .clr-member-pill:hover {
            border-color: #1d2448;
            color: #1d2448;
            background: #f0f2ff;
        }

        .clr-member-pill.selected {
            border-color: #1d2448;
            background: #1d2448;
            color: #fff;
        }

        .clr-member-pill input[type="radio"] {
            display: none;
        }

        .clr-member-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
        }

        .clr-member-pill:not(.selected) .clr-member-avatar {
            background: #eef0fb;
            color: #1d2448;
        }

        /* Doc type cards */
        .clr-doc-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .clr-doc-card {
            border: 1.5px solid #e2e5ef;
            border-radius: 10px;
            padding: 12px 10px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            font-family: 'Poppins', sans-serif;
        }

        .clr-doc-card:hover {
            border-color: #1d2448;
            background: #f0f2ff;
        }

        .clr-doc-card.selected {
            border-color: #1d2448;
            background: #1d2448;
            color: #fff;
        }

        .clr-doc-card input[type="radio"] {
            display: none;
        }

        .clr-doc-card i {
            font-size: 20px;
            display: block;
            margin-bottom: 6px;
        }

        .clr-doc-card span {
            font-size: 11px;
            font-weight: 600;
            line-height: 1.3;
            display: block;
        }

        .clr-doc-card .clr-doc-fee {
            font-size: 10px;
            margin-top: 3px;
            opacity: .7;
        }

        /* Submit btn */
        .clr-submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: opacity .2s, transform .15s;
        }

        .clr-submit-btn:hover {
            opacity: .92;
            transform: translateY(-1px);
        }

        /* Status badges */
        .clr-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 100px;
        }

        .clr-badge--pending {
            background: #fff8f0;
            color: #b7600a;
            border: 1px solid #fde8c8;
        }

        .clr-badge--approved {
            background: #f0faf6;
            color: #1a7a55;
            border: 1px solid #c3e8d8;
        }

        .clr-badge--rejected {
            background: #fff0f1;
            color: #c0392b;
            border: 1px solid #fad4d4;
        }

        .clr-badge--released {
            background: #eef0fb;
            color: #1d2448;
            border: 1px solid #d0d8f5;
        }

        /* No household warning */
        .clr-no-hh {
            background: #fff8f0;
            border: 1px solid #fde8c8;
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 13px;
            color: #b7600a;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'resident';
    $active    = 'clearance';
    $pageTitle = 'My Clearances';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $requests = $requests ?? [];
    $members  = $members  ?? [];
    $user     = $user     ?? [];
    ?>


    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>

        <!-- Welcome -->
        <div class="db-welcome">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="db-alert db-alert--success" style="margin-bottom:16px;">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('blotter_error')): ?>
                <div class="db-alert db-alert--error" style="margin-bottom:16px;">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('blotter_error') ?>
                </div>
            <?php endif; ?>
            <div>
                <h2>Hello, <?= esc(session()->get('full_name') ?? session()->get('username') ?? 'Resident') ?> 👋</h2>
                <p>Barangay Bacolod, Bato, Camarines Sur — Barangay Information System</p>
            </div>
            <div class="db-welcome-icon"><i class="fas fa-users"></i></div>
        </div>
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

            <?php if (empty($members)): ?>
                <div class="clr-no-hh">
                    <i class="fas fa-exclamation-triangle" style="margin-top:2px;flex-shrink:0;"></i>
                    <div>Your account is not linked to a household in the census. You need to be verified and linked to a household before you can request documents. Please contact the barangay office.</div>
                </div>
            <?php endif; ?>

            <!-- Toolbar -->
            <div class="db-toolbar">
                <div class="db-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search requests..." id="searchInput" oninput="filterRequests()">
                </div>
                <div class="db-toolbar-actions">
                    <?php if (! empty($members)): ?>
                        <button class="db-btn db-btn--primary" onclick="openModal('newModal')">
                            <i class="fas fa-plus"></i> New Request
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Requests table -->
            <div class="db-table-wrap">
                <table class="db-table" id="requestsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>For</th>
                            <th>Document Type</th>
                            <th>Purpose</th>
                            <th>Date Filed</th>
                            <th>Est. Release</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="8">
                                    <div class="clr-empty">
                                        <i class="fas fa-file-alt"></i>
                                        <p>No requests yet. Click <strong>New Request</strong> to get started.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($requests as $r):
                                $statusMap = [
                                    'pending'  => ['clr-badge--pending',  'fa-clock',        'Pending'],
                                    'approved' => ['clr-badge--approved', 'fa-check-circle', 'Approved'],
                                    'rejected' => ['clr-badge--rejected', 'fa-times-circle', 'Rejected'],
                                    'released' => ['clr-badge--released', 'fa-box-open',     'Released'],
                                ];
                                [$badgeClass, $icon, $label] = $statusMap[$r['status']] ?? $statusMap['pending'];
                                $filed   = date('M d, Y', strtotime($r['created_at']));
                                $release = $r['est_release_date'] ? date('M d, Y', strtotime($r['est_release_date'])) : '—';
                            ?>
                                <tr>
                                    <td><strong>#<?= str_pad($r['id'], 3, '0', STR_PAD_LEFT) ?></strong></td>
                                    <td>
                                        <div style="font-size:13px;font-weight:600;color:#1a1d2e;"><?= esc($r['for_member']) ?></div>
                                        <div style="font-size:11px;color:#9aa0b4;"><?= esc($r['member_relationship'] ?? '') ?></div>
                                    </td>
                                    <td><?= esc($r['document_type']) ?></td>
                                    <td><?= esc($r['purpose']) ?></td>
                                    <td><?= $filed ?></td>
                                    <td><?= $release ?></td>
                                    <td>
                                        <span class="clr-badge <?= $badgeClass ?>">
                                            <i class="fas <?= $icon ?>"></i> <?= $label ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($r['status'] === 'pending'): ?>
                                            <button type="button"
                                                class="db-icon-btn db-icon-btn--del"
                                                title="Cancel Request"
                                                onclick="confirmCancel(<?= $r['id'] ?>, '<?= esc($r['document_type']) ?>')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="db-icon-btn db-icon-btn--view" title="View"><i class="fas fa-eye"></i></button>
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

    <!-- ══ CANCEL CONFIRMATION MODAL ══ -->
    <div class="db-modal-overlay" id="cancelModal">
        <div class="db-modal" style="max-width:400px;">
            <div class="db-modal-header" style="background:#fff0f1;border-bottom:1px solid #fad4d4;">
                <h3 style="color:#c0392b;font-size:14px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-exclamation-triangle"></i> Cancel Request
                </h3>
                <button class="db-modal-close" onclick="closeModal('cancelModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="db-modal-body" style="padding:24px;">
                <p style="font-size:13.5px;color:#4a5068;margin:0 0 6px;">Are you sure you want to cancel this request?</p>
                <p id="cancelDocType" style="font-size:14px;font-weight:700;color:#1a1d2e;margin:0 0 16px;"></p>
                <p style="font-size:12.5px;color:#9aa0b4;margin:0;">This action cannot be undone. The request will be permanently removed.</p>
            </div>
            <div class="db-modal-footer" style="gap:10px;">
                <button class="db-btn db-btn--outline" onclick="closeModal('cancelModal')" style="flex:1;">
                    Keep Request
                </button>
                <form id="cancelForm" method="post" style="flex:1;">
                    <?= csrf_field() ?>
                    <button type="submit" class="db-btn db-btn--danger" style="width:100%;justify-content:center;">
                        <i class="fas fa-times"></i> Yes, Cancel It
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="db-modal-overlay" id="newModal">
        <div class="db-modal clr-modal">

            <!-- Header -->
            <div class="clr-modal-header">
                <div class="clr-modal-header-left">
                    <div class="clr-modal-header-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <h3>New Document Request</h3>
                        <p>Fill in the details below to submit your request</p>
                    </div>
                </div>
                <button class="clr-modal-close" onclick="closeModal('newModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="/resident/clearance/store" method="post" id="clearanceForm">
                <?= csrf_field() ?>
                <div class="clr-form-body" style="max-height:72vh;overflow-y:auto;">

                    <!-- Step 1: Who is this for? -->
                    <div class="clr-section">
                        <div class="clr-section-label">
                            <i class="fas fa-user"></i> Who is this document for?
                        </div>
                        <?php if (empty($members)): ?>
                            <p style="font-size:12.5px;color:#b7600a;background:#fff8f0;padding:10px 14px;border-radius:8px;border:1px solid #fde8c8;">
                                <i class="fas fa-exclamation-triangle"></i>
                                No household members found. Please contact the barangay office.
                            </p>
                        <?php else: ?>
                            <div class="clr-member-pills" id="memberPills">
                                <?php foreach ($members as $i => $m): ?>
                                    <label class="clr-member-pill <?= $i === 0 ? 'selected' : '' ?>"
                                        onclick="selectMember(this, '<?= esc($m['name']) ?>', '<?= esc($m['relationship']) ?>')">
                                        <input type="radio" name="_member_ui" value="<?= esc($m['name']) ?>" <?= $i === 0 ? 'checked' : '' ?>>
                                        <div class="clr-member-avatar"><?= strtoupper($m['name'][0] ?? '?') ?></div>
                                        <div>
                                            <div class="clr-member-name"><?= esc($m['name']) ?></div>
                                            <div class="clr-member-rel"><?= esc($m['relationship']) ?></div>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="for_member" id="forMember" value="<?= esc($members[0]['name'] ?? '') ?>">
                            <input type="hidden" name="member_relationship" id="memberRel" value="<?= esc($members[0]['relationship'] ?? '') ?>">
                        <?php endif; ?>
                    </div>

                    <div class="clr-divider"></div>

                    <!-- Step 2: Document type -->
                    <div class="clr-section">
                        <div class="clr-section-label">
                            <i class="fas fa-file-contract"></i> Select Document Type
                        </div>
                        <div class="clr-doc-grid">
                            <label class="clr-doc-card selected" onclick="selectDoc(this)">
                                <input type="radio" name="document_type" value="Barangay Clearance" checked>
                                <div class="clr-doc-check"><i class="fas fa-check"></i></div>
                                <div class="clr-doc-icon"><i class="fas fa-certificate"></i></div>
                                <div class="clr-doc-name">Barangay Clearance</div>
                                <div class="clr-doc-fee">Free</div>
                            </label>
                            <label class="clr-doc-card" onclick="selectDoc(this)">
                                <input type="radio" name="document_type" value="Certificate of Residency">
                                <div class="clr-doc-check"><i class="fas fa-check"></i></div>
                                <div class="clr-doc-icon"><i class="fas fa-home"></i></div>
                                <div class="clr-doc-name">Certificate of Residency</div>
                                <div class="clr-doc-fee">Free</div>
                            </label>
                            <label class="clr-doc-card" onclick="selectDoc(this)" id="indigencyCard">
                                <input type="radio" name="document_type" value="Certificate of Indigency">
                                <div class="clr-doc-check"><i class="fas fa-check"></i></div>
                                <div class="clr-doc-icon"><i class="fas fa-hand-holding-heart"></i></div>
                                <div class="clr-doc-name">Certificate of Indigency</div>
                                <div class="clr-doc-fee">Free</div>
                                <?php if (($householdTotalIncome ?? 0) > 12000): ?>
                                    <div class="clr-indig-warn"><i class="fas fa-ban"></i> Income exceeds ₱12,000/mo</div>
                                <?php endif; ?>
                            </label>

                            <label class="clr-doc-card" onclick="selectDoc(this)">
                                <input type="radio" name="document_type" value="Certificate of Residency">
                                <div class="clr-doc-check"><i class="fas fa-check"></i></div>
                                <div class="clr-doc-icon"><i class="fas fa-home"></i></div>
                                <div class="clr-doc-name">Certificate of Good Moral</div>
                                <div class="clr-doc-fee">Free</div>
                            </label>

                            <label class="clr-doc-card <?= (strcasecmp(trim($occupation ?? ''), 'Employed') === 0 ? 'clr-doc-card--ineligible' : '') ?>" onclick="selectDoc(this)" id="firstTimeJobSeekersCard">
                                <input type="radio" name="document_type" value="First Time Job Seekers" <?= (strcasecmp(trim($occupation ?? ''), 'Employed') === 0 ? 'disabled' : '') ?>>
                                <div class="clr-doc-check"><i class="fas fa-check"></i></div>
                                <div class="clr-doc-icon"><i class="fas fa-home"></i></div>
                                <div class="clr-doc-name">First Time Job Seekers</div>
                                <div class="clr-doc-fee">Free</div>
                                <?php if (strcasecmp(trim($occupation ?? ''), 'Employed') === 0): ?>
                                    <div class="clr-indig-warn"><i class="fas fa-ban"></i> Currently employed, not eligible for First Time Job Seekers</div>
                                <?php endif; ?>
                            </label>
                        </div>
                    </div>

                    <div class="clr-divider"></div>

                    <!-- Step 3: Purpose -->
                    <div class="clr-section">
                        <div class="clr-section-label">
                            <i class="fas fa-bullseye"></i> Purpose
                        </div>
                        <select name="purpose" class="clr-select" required>
                            <option value="">-- Select purpose --</option>
                            <optgroup label="Employment">
                                <option>Employment / Job Application</option>
                                <option>Business Permit</option>
                            </optgroup>
                            <optgroup label="Education">
                                <option>School Enrollment</option>
                                <option>Scholarship Application</option>
                            </optgroup>
                            <optgroup label="Government / Legal">
                                <option>Government Transaction</option>
                                <option>Travel / Passport</option>
                                <option>Bank / Financial Requirement</option>
                                <option>Court Requirement</option>
                            </optgroup>
                            <optgroup label="Health / Social">
                                <option>Medical Assistance</option>
                                <option>Social Welfare (DSWD / 4Ps)</option>
                                <option>PhilHealth / SSS / GSIS</option>
                            </optgroup>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Step 4: Notes -->
                    <div class="clr-section" style="margin-bottom:18px;">
                        <div class="clr-section-label">
                            <i class="fas fa-sticky-note"></i> Additional Notes
                            <span style="font-size:10px;color:#b0b6cc;font-weight:400;text-transform:none;letter-spacing:0;">(optional)</span>
                        </div>
                        <textarea name="notes" class="clr-textarea"
                            placeholder="Any additional information the barangay should know..."></textarea>
                    </div>

                    <!-- Info note -->
                    <div class="clr-info-note">
                        <i class="fas fa-clock"></i>
                        <span>Processing takes <strong>1–2 business days</strong>. You will be notified once your document is ready for pickup at the barangay hall.</span>
                    </div>

                    <button type="submit" class="clr-submit-btn">
                        <i class="fas fa-paper-plane"></i> Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        function confirmCancel(id, docType) {
            document.getElementById('cancelDocType').textContent = docType;
            document.getElementById('cancelForm').action = '/resident/clearance/cancel/' + id;
            openModal('cancelModal');
        }

        function selectMember(el, name, rel) {
            document.querySelectorAll('.clr-member-pill').forEach(p => p.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('forMember').value = name;
            document.getElementById('memberRel').value = rel;
        }

        function selectDoc(el) {
            // Block selection if card is ineligible
            if (el.classList.contains('clr-doc-card--ineligible')) return;
            document.querySelectorAll('.clr-doc-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
        }

        // Mark indigency card as ineligible if household income > 12,000
        (function initIndigencyCard() {
            const totalIncome = <?= (float) ($householdTotalIncome ?? 0) ?>;
            const card = document.getElementById('indigencyCard');
            if (card && totalIncome > 12000) {
                card.classList.add('clr-doc-card--ineligible');
                card.querySelector('input[type="radio"]').disabled = true;
                // If it was pre-selected, deselect it
                if (card.classList.contains('selected')) {
                    card.classList.remove('selected');
                    // Select the first available card instead
                    const first = document.querySelector('.clr-doc-card:not(.clr-doc-card--ineligible)');
                    if (first) {
                        first.classList.add('selected');
                        const radio = first.querySelector('input[type="radio"]');
                        if (radio) radio.checked = true;
                    }
                }
            }
        })();

        function filterRequests() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('#requestsTable tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>