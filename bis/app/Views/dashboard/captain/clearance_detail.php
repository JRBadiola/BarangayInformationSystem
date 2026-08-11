<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Request - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role      = $role ?? 'captain';
    $active    = 'clearance';
    $pageTitle = 'Clearance Request';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $backUrl  = '/' . $role . '/clearance';
    $user     = $user     ?? [];
    $household = $household ?? null;
    $requests = $requests ?? [];

    // Build resident display info from census
    $resName    = esc(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: 'Unknown');
    $initial    = strtoupper(($user['first_name'] ?? 'U')[0]);
    $address    = $household ? esc($household['address'] ?? ($household['zone'] ?? '—')) : '—';
    $contact    = $household ? esc($household['contact_number'] ?? '—') : '—';
    $gender     = $household ? esc($household['gender'] ?? '—') : '—';
    $civil      = $household ? esc($household['civil_status'] ?? '—') : '—';
    $occupation = $household ? esc($household['occupation'] ?? '—') : '—';
    $age        = ($household && !empty($household['date_of_birth']))
        ? (int)date_diff(date_create($household['date_of_birth']), date_create('today'))->y
        : '—';
    $zone       = $household ? esc($household['zone'] ?? '') : '';

    // Currently selected request (first pending, or first overall)
    $activeReq  = null;
    foreach ($requests as $r) {
        if ($r['status'] === 'pending') {
            $activeReq = $r;
            break;
        }
    }
    if (! $activeReq && ! empty($requests)) $activeReq = $requests[0];

    $docKeyMap = [
        'Barangay Clearance'       => 'clearance',
        'Certificate of Residency' => 'residency',
        'Certificate of Indigency' => 'indigency',
    ];
    $feeMap = [
        'Barangay Clearance'       => '₱50.00',
        'Certificate of Residency' => '₱30.00',
        'Certificate of Indigency' => 'Free',
    ];
    $badgeMap = [
        'pending'  => 'db-badge--pending',
        'approved' => 'db-badge--approved',
        'rejected' => 'db-badge--rejected',
    ];
    ?>

    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <!-- Breadcrumb -->
            <div class="hh-breadcrumb" style="margin-bottom:20px;">
                <a href="<?= $backUrl ?>" class="hh-back"><i class="fas fa-arrow-left"></i> Back to Clearance</a>
                <span class="hh-bc-sep">/</span>
                <span><?= $resName ?></span>
            </div>

            <!-- Resident header card -->
            <div class="cld-header-card">
                <div class="cld-avatar"><?= $initial ?></div>
                <div class="cld-header-info">
                    <h2><?= $resName ?></h2>
                    <div class="cld-header-meta">
                        <span><i class="fas fa-map-marker-alt"></i> <?= $address ?></span>
                        <span><i class="fas fa-phone"></i> <?= $contact ?></span>
                        <span><i class="fas fa-venus-mars"></i> <?= $gender ?>, <?= $age ?> yrs</span>
                        <span><i class="fas fa-heart"></i> <?= $civil ?></span>
                        <span><i class="fas fa-briefcase"></i> <?= $occupation ?></span>
                    </div>
                </div>
                <div class="cld-header-right">
                    <span style="font-size:12px;color:#9aa0b4;"><?= count($requests) ?> total request<?= count($requests) != 1 ? 's' : '' ?></span>
                </div>
            </div>

            <!-- Two-column layout -->
            <div class="cld-grid">

                <!-- LEFT: All requests list -->
                <div class="cld-col">
                    <div class="cld-card">
                        <h4 class="cld-card-title"><i class="fas fa-list-alt"></i> All Requests</h4>

                        <?php if (empty($requests)): ?>
                            <p style="color:#9aa0b4;font-size:13px;">No requests found for this resident.</p>
                            <?php else: foreach ($requests as $r):
                                $rBadge   = $badgeMap[$r['status']] ?? 'db-badge--pending';
                                $rFiled   = date('M d, Y', strtotime($r['created_at']));
                                $rRelease = $r['est_release_date'] ? date('M d, Y', strtotime($r['est_release_date'])) : '—';
                                $rDocKey  = $docKeyMap[$r['document_type']] ?? 'clearance';
                                $rFee     = $feeMap[$r['document_type']] ?? '—';
                                $isActive = $activeReq && $activeReq['id'] === $r['id'];
                            ?>
                                <div class="req-item <?= $isActive ? 'req-item--active' : '' ?>"
                                    onclick="selectRequest(<?= htmlspecialchars(json_encode($r), ENT_QUOTES) ?>, '<?= $rDocKey ?>', '<?= $rFee ?>')">
                                    <div class="req-item-top">
                                        <strong>#<?= str_pad($r['id'], 3, '0', STR_PAD_LEFT) ?></strong>
                                        <span class="db-badge <?= $rBadge ?>"><?= ucfirst($r['status']) ?></span>
                                    </div>
                                    <div class="req-item-doc"><?= esc($r['document_type']) ?></div>
                                    <div class="req-item-meta">
                                        <span><i class="fas fa-user"></i> <?= esc($r['for_member']) ?> (<?= esc($r['member_relationship'] ?? '') ?>)</span>
                                        <span><i class="fas fa-bullseye"></i> <?= esc($r['purpose']) ?></span>
                                        <span><i class="fas fa-calendar"></i> Filed: <?= $rFiled ?></span>
                                    </div>
                                    <?php if ($r['status'] === 'pending'): ?>
                                        <div class="req-item-actions" onclick="event.stopPropagation()">
                                            <form action="/<?= $role ?>/clearance/approve/<?= $r['id'] ?>" method="post" style="display:inline;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="db-btn db-btn--xs db-btn--success"><i class="fas fa-check"></i> Released</button>
                                            </form>
                                            <button class="db-btn db-btn--xs db-btn--danger"
                                                onclick="openRejectModal(<?= $r['id'] ?>, '<?= $role ?>')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
                </div>

                <!-- RIGHT: Document preview (auto-filled) -->
                <div class="cld-col">
                    <div class="cld-card">
                        <div class="cld-card-title-row">
                            <h4 class="cld-card-title" style="margin:0;"><i class="fas fa-file-contract"></i> Document Preview</h4>
                            <button class="db-btn db-btn--sm db-btn--primary"
                                onclick="printCurrentDoc()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                        <div id="docInfo" style="background:#f8f9fc;border:1px solid #e8ecf4;border-radius:8px;padding:12px 14px;margin-bottom:12px;font-size:12.5px;color:#4a5068;">
                            <?php if ($activeReq): ?>
                                <strong><?= esc($activeReq['document_type']) ?></strong> for
                                <strong><?= esc($activeReq['for_member']) ?></strong> —
                                Purpose: <?= esc($activeReq['purpose']) ?> —
                                Fee: <?= $feeMap[$activeReq['document_type']] ?? '—' ?>
                            <?php else: ?>
                                Select a request on the left to preview the document.
                            <?php endif; ?>
                        </div>
                        <div class="cld-doc-preview" id="docPreviewArea">
                            <?php if ($activeReq):
                                $docKey = $docKeyMap[$activeReq['document_type']] ?? 'clearance';
                                echo '<script>document.addEventListener("DOMContentLoaded",function(){document.getElementById("docPreviewArea").innerHTML=BisDoc.build("' . $docKey . '","' . addslashes($activeReq['for_member'] ?? $resName) . '","' . addslashes($activeReq['purpose'] ?? '') . '");});</script>';
                            endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="db-modal-overlay" id="rejectModal">
        <div class="db-modal" style="max-width:420px;">
            <div class="db-modal-header">
                <h3><i class="fas fa-times-circle"></i> Reject Request</h3>
                <button class="db-modal-close" onclick="document.getElementById('rejectModal').classList.remove('active')"><i class="fas fa-times"></i></button>
            </div>
            <form id="rejectForm" method="post">
                <?= csrf_field() ?>
                <div class="db-modal-body">
                    <div class="db-form-group db-form-group--full">
                        <label>Reason for Rejection (optional)</label>
                        <textarea name="remarks" rows="3" placeholder="State the reason..."></textarea>
                    </div>
                </div>
                <div class="db-modal-footer">
                    <button type="button" class="db-btn db-btn--outline" onclick="document.getElementById('rejectModal').classList.remove('active')">Cancel</button>
                    <button type="submit" class="db-btn db-btn--danger"><i class="fas fa-times"></i> Confirm Reject</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* ── Request items ── */
        .req-item {
            border: 1.5px solid #e8ecf4;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }

        .req-item:hover {
            border-color: #1d2448;
            background: #f8f9ff;
        }

        .req-item--active {
            border-color: #1d2448;
            background: #f0f2ff;
        }

        .req-item-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .req-item-doc {
            font-size: 13.5px;
            font-weight: 600;
            color: #1a1d2e;
            margin-bottom: 6px;
        }

        .req-item-meta {
            display: flex;
            flex-direction: column;
            gap: 3px;
            font-size: 11.5px;
            color: #9aa0b4;
        }

        .req-item-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .req-item-meta i {
            font-size: 10px;
        }

        .req-item-actions {
            margin-top: 10px;
            display: flex;
            gap: 8px;
        }

        /* ── Header card ── */
        .cld-header-card {
            background: #fff;
            border: 1px solid #e8ecf4;
            border-radius: 14px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .cld-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #1d2448;
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cld-header-info {
            flex: 1;
            min-width: 200px;
        }

        .cld-header-info h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1a1d2e;
            margin: 0 0 8px;
        }

        .cld-header-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12px;
            color: #6b7280;
        }

        .cld-header-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .cld-header-meta i {
            color: #b0b6cc;
            font-size: 11px;
        }

        .cld-header-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            flex-shrink: 0;
        }

        /* ── Grid ── */
        .cld-grid {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 20px;
            align-items: start;
        }

        .cld-col {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ── Cards ── */
        .cld-card {
            background: #fff;
            border: 1px solid #e8ecf4;
            border-radius: 14px;
            padding: 20px 22px;
        }

        .cld-card-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0 0 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cld-card-title i {
            color: #9aa0b4;
        }

        .cld-card-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        /* ── Detail list ── */
        .cld-detail-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        .cld-detail-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 9px 0;
            border-bottom: 1px solid #f5f6fa;
        }

        .cld-detail-item span:first-child {
            font-size: 10px;
            font-weight: 600;
            color: #9aa0b4;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .cld-detail-item strong {
            font-size: 13px;
            color: #1a1d2e;
        }

        /* ── Notes ── */
        .cld-notes {
            font-size: 13px;
            color: #555;
            line-height: 1.75;
            margin: 0;
            background: #f8f9fc;
            border: 1px solid #e8ecf4;
            border-radius: 8px;
            padding: 12px;
        }

        /* ── Action card ── */
        .cld-action-row {
            display: flex;
            gap: 10px;
        }

        /* ── Document preview ── */
        .cld-doc-preview {
            background: #f0f0f0;
            border-radius: 8px;
            overflow: auto;
            max-height: 680px;
            padding: 12px 0;
        }

        /* ── Breadcrumb ── */
        .hh-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #9aa0b4;
        }

        .hh-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #1d2448;
            text-decoration: none;
            font-weight: 500;
            transition: opacity .2s;
        }

        .hh-back:hover {
            opacity: .7;
        }

        .hh-bc-sep {
            color: #d0d5e8;
        }

        /* ── Print ── */
        @media print {

            .db-sidebar,
            .db-topbar,
            .hh-breadcrumb,
            .cld-header-right,
            .cld-col:first-child,
            .db-modal-overlay {
                display: none !important;
            }

            .db-main {
                margin-left: 0 !important;
            }

            .cld-grid {
                grid-template-columns: 1fr;
            }

            .cld-doc-preview {
                max-height: none;
                background: #fff;
                padding: 0;
            }
        }

        @media (max-width: 1024px) {
            .cld-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script src="/js/doc-templates.js"></script>
    <script>
        // Set census data for the template engine
        BisDoc.setCensus({
            name: '<?= addslashes($resName) ?>',
            age: '<?= $age ?>',
            gender: '<?= addslashes($gender) ?>',
            civil: '<?= addslashes($civil) ?>',
            address: '<?= addslashes($address) ?>',
            zone: '<?= addslashes($zone) ?>',
            occupation: '<?= addslashes($occupation) ?>',
        });
        // Set the active Punong Barangay name
        BisDoc.setCaptain('<?= addslashes($captainName ?? 'PUNONG BARANGAY') ?>');

        // Track currently displayed doc for print
        let _currentDoc = {
            key: '<?= $docKeyMap[$activeReq['document_type'] ?? 'Barangay Clearance'] ?? 'clearance' ?>',
            member: '<?= addslashes($activeReq['for_member'] ?? $resName) ?>',
            purpose: '<?= addslashes($activeReq['purpose'] ?? '') ?>',
        };

        function selectRequest(r, docKey, fee) {
            document.querySelectorAll('.req-item').forEach(el => el.classList.remove('req-item--active'));
            event.currentTarget.classList.add('req-item--active');
            document.getElementById('docInfo').innerHTML =
                `<strong>${r.document_type}</strong> for <strong>${r.for_member}</strong> — Purpose: ${r.purpose} — Fee: ${fee}`;
            _currentDoc = {
                key: docKey,
                member: r.for_member,
                purpose: r.purpose
            };
            document.getElementById('docPreviewArea').innerHTML = BisDoc.build(docKey, r.for_member, r.purpose);
        }

        function printCurrentDoc() {
            BisDoc.print(_currentDoc.key, _currentDoc.member, _currentDoc.purpose);
        }

        function openRejectModal(id, role) {
            document.getElementById('rejectForm').action = '/' + role + '/clearance/reject/' + id;
            document.getElementById('rejectModal').classList.add('active');
        }

        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>