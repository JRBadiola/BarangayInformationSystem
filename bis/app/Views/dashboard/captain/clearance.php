<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Management - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php $role = 'captain';
    $active = 'clearance';
    $pageTitle = 'Clearance Management';
    include(APPPATH . 'Views/dashboard/sidebar.php'); ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div class="db-stats" style="margin-bottom:24px;">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,0.15);color:#ffc107;"><i class="fas fa-clock"></i></div>
                    <div><span class="db-stat-num"><?= $pending ?? 0 ?></span><span class="db-stat-label">Pending</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,0.15);color:#16c79a;"><i class="fas fa-check-circle"></i></div>
                    <div><span class="db-stat-num"><?= $approved ?? 0 ?></span><span class="db-stat-label">Approved</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(220,53,69,0.15);color:#dc3545;"><i class="fas fa-times-circle"></i></div>
                    <div><span class="db-stat-num"><?= $rejected ?? 0 ?></span><span class="db-stat-label">Rejected</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-file-alt"></i></div>
                    <div><span class="db-stat-num"><?= $total ?? 0 ?></span><span class="db-stat-label">Total Requests</span></div>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="db-alert db-alert--success" style="margin-bottom:16px;">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form method="get" action="" style="margin-bottom:0;">
                <div class="db-toolbar">
                    <div class="db-search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Search requests..." id="searchInput"
                            value="<?= esc($search ?? '') ?>" onchange="this.form.submit()">
                    </div>
                    <div class="db-toolbar-actions">
                        <select class="db-filter-select" name="status" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="pending" <?= ($statusFilter ?? '') === 'pending'  ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= ($statusFilter ?? '') === 'approved' ? 'selected' : '' ?>>Released</option>
                            <option value="rejected" <?= ($statusFilter ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                        <select class="db-filter-select" name="type" onchange="this.form.submit()">
                            <option value="">All Types</option>
                            <option value="Barangay Clearance" <?= ($typeFilter ?? '') === 'Barangay Clearance'       ? 'selected' : '' ?>>Barangay Clearance</option>
                            <option value="Certificate of Residency" <?= ($typeFilter ?? '') === 'Certificate of Residency' ? 'selected' : '' ?>>Certificate of Residency</option>
                            <option value="Certificate of Indigency" <?= ($typeFilter ?? '') === 'Certificate of Indigency' ? 'selected' : '' ?>>Certificate of Indigency</option>
                        </select>
                    </div>
                </div>
            </form>

            <div class="db-table-wrap">
                <table class="db-table" id="clearanceTable">
                    <thead>
                        <tr>
                            <th>Resident</th>
                            <th>Total Requests</th>
                            <th>Status Summary</th>
                            <th>Latest Filed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $residents = $residents ?? [];
                        $roleVal   = 'captain';
                        if (empty($residents)): ?>
                            <tr>
                                <td colspan="5" style="text-align:center;padding:32px;color:#9aa0b4;">
                                    <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                    No requests found.
                                </td>
                            </tr>
                            <?php else: foreach ($residents as $res):
                                $initial    = strtoupper(($res['resident_name'] ?? 'U')[0]);
                                $filed      = date('M d, Y', strtotime($res['latest_filed']));
                                $pendingC   = (int)$res['pending_count'];
                                $approvedC  = (int)$res['approved_count'];
                                $rejectedC  = (int)$res['rejected_count'];
                            ?>
                                <tr>
                                    <td>
                                        <div class="res-name-link">
                                            <div class="db-avatar-sm"><?= $initial ?></div>
                                            <div>
                                                <div style="font-weight:600;font-size:13px;"><?= esc($res['resident_name']) ?></div>
                                                <div style="font-size:11px;color:#9aa0b4;"><?= esc($res['zone'] ?? '—') ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= (int)$res['total_requests'] ?> request<?= $res['total_requests'] != 1 ? 's' : '' ?></td>
                                    <td>
                                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                            <?php if ($pendingC > 0): ?><span class="db-badge db-badge--pending"><?= $pendingC ?> Pending</span><?php endif; ?>
                                            <?php if ($approvedC > 0): ?><span class="db-badge db-badge--approved"><?= $approvedC ?> Approved</span><?php endif; ?>
                                            <?php if ($rejectedC > 0): ?><span class="db-badge db-badge--rejected"><?= $rejectedC ?> Rejected</span><?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?= $filed ?></td>
                                    <td>
                                        <a href="/<?= $roleVal ?>/clearance/request/<?= $res['user_id'] ?>"
                                            class="db-btn db-btn--sm db-btn--outline">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </td>
                                </tr>
                        <?php endforeach;
                        endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php
            $filteredTotal = $filteredTotal ?? 0;
            $totalPages    = (int) ceil($filteredTotal / ($perPage ?? 10));
            $start         = $filteredTotal > 0 ? (($currentPage ?? 1) - 1) * ($perPage ?? 10) + 1 : 0;
            $end           = min(($currentPage ?? 1) * ($perPage ?? 10), $filteredTotal);
            $qs = http_build_query(array_filter(['status' => $statusFilter ?? '', 'type' => $typeFilter ?? '', 'search' => $search ?? ''], fn($v) => $v !== ''));
            $qs = $qs ? '&' . $qs : '';
            ?>
            <?php if ($filteredTotal > 0): ?>
                <div class="db-pagination">
                    <span class="db-page-info">Showing <?= $start ?>–<?= $end ?> of <?= $filteredTotal ?> request<?= $filteredTotal !== 1 ? 's' : '' ?></span>
                    <div class="db-page-btns">
                        <a href="?page=<?= max(1, ($currentPage ?? 1) - 1) ?><?= $qs ?>" class="db-page-btn <?= ($currentPage ?? 1) <= 1 ? 'disabled' : '' ?>"><i class="fas fa-chevron-left"></i></a>
                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <a href="?page=<?= $p ?><?= $qs ?>" class="db-page-btn <?= $p === ($currentPage ?? 1) ? 'active' : '' ?>"><?= $p ?></a>
                        <?php endfor; ?>
                        <a href="?page=<?= min($totalPages, ($currentPage ?? 1) + 1) ?><?= $qs ?>" class="db-page-btn <?= ($currentPage ?? 1) >= $totalPages ? 'disabled' : '' ?>"><i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            <?php endif; ?>

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
                                <textarea name="remarks" rows="3" placeholder="State the reason for rejection..."></textarea>
                            </div>
                        </div>
                        <div class="db-modal-footer">
                            <button type="button" class="db-btn db-btn--outline" onclick="document.getElementById('rejectModal').classList.remove('active')">Cancel</button>
                            <button type="submit" class="db-btn db-btn--danger"><i class="fas fa-times"></i> Confirm Reject</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Document Templates Section -->
            <h3 class="db-section-title" style="margin-top:12px;"><i class="fas fa-file-alt" style="color:#5b6fd6;margin-right:8px;"></i>Document Templates</h3>
            <div class="doc-templates-grid">
                <div class="doc-tpl-card" onclick="openDocModal('clearance')">
                    <div class="doc-tpl-icon" style="background:rgba(91,111,214,0.12);color:#5b6fd6;"><i class="fas fa-file-contract"></i></div>
                    <div class="doc-tpl-info">
                        <h4>Barangay Clearance</h4>
                        <p>General-purpose clearance for employment, travel, and other purposes.</p>
                    </div>
                    <div class="doc-tpl-actions">
                        <button class="db-btn db-btn--sm db-btn--outline" onclick="event.stopPropagation();openDocModal('clearance')"><i class="fas fa-eye"></i> Preview</button>
                        <button class="db-btn db-btn--sm db-btn--primary" onclick="event.stopPropagation();printDoc('clearance')"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="doc-tpl-card" onclick="openDocModal('residency')">
                    <div class="doc-tpl-icon" style="background:rgba(22,199,154,0.12);color:#16c79a;"><i class="fas fa-home"></i></div>
                    <div class="doc-tpl-info">
                        <h4>Barangay Certification</h4>
                        <p>Certifies that the resident lives within the barangay jurisdiction.</p>
                    </div>
                    <div class="doc-tpl-actions">
                        <button class="db-btn db-btn--sm db-btn--outline" onclick="event.stopPropagation();openDocModal('residency')"><i class="fas fa-eye"></i> Preview</button>
                        <button class="db-btn db-btn--sm db-btn--primary" onclick="event.stopPropagation();printDoc('residency')"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="doc-tpl-card" onclick="openDocModal('indigency')">
                    <div class="doc-tpl-icon" style="background:rgba(255,193,7,0.12);color:#e6a800;"><i class="fas fa-hand-holding-heart"></i></div>
                    <div class="doc-tpl-info">
                        <h4>Certificate of Indigency</h4>
                        <p>Certifies that the resident belongs to an indigent family.</p>
                    </div>
                    <div class="doc-tpl-actions">
                        <button class="db-btn db-btn--sm db-btn--outline" onclick="event.stopPropagation();openDocModal('indigency')"><i class="fas fa-eye"></i> Preview</button>
                        <button class="db-btn db-btn--sm db-btn--primary" onclick="event.stopPropagation();printDoc('indigency')"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="doc-tpl-card" onclick="openDocModal('business')">
                    <div class="doc-tpl-icon" style="background:rgba(220,53,69,0.12);color:#dc3545;"><i class="fas fa-store"></i></div>
                    <div class="doc-tpl-info">
                        <h4>Business Permit Clearance</h4>
                        <p>Clearance required for business permit applications within the barangay.</p>
                    </div>
                    <div class="doc-tpl-actions">
                        <button class="db-btn db-btn--sm db-btn--outline" onclick="event.stopPropagation();openDocModal('business')"><i class="fas fa-eye"></i> Preview</button>
                        <button class="db-btn db-btn--sm db-btn--primary" onclick="event.stopPropagation();printDoc('business')"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="doc-tpl-card" onclick="openDocModal('good_moral')">
                    <div class="doc-tpl-icon" style="background:rgba(91,111,214,0.12);color:#5b6fd6;"><i class="fas fa-award"></i></div>
                    <div class="doc-tpl-info">
                        <h4>Certificate of Good Moral</h4>
                        <p>Attests to the good moral character of the resident in the community.</p>
                    </div>
                    <div class="doc-tpl-actions">
                        <button class="db-btn db-btn--sm db-btn--outline" onclick="event.stopPropagation();openDocModal('good_moral')"><i class="fas fa-eye"></i> Preview</button>
                        <button class="db-btn db-btn--sm db-btn--primary" onclick="event.stopPropagation();printDoc('good_moral')"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="doc-tpl-card" onclick="openDocModal('solo_parent')">
                    <div class="doc-tpl-icon" style="background:rgba(22,199,154,0.12);color:#16c79a;"><i class="fas fa-user-friends"></i></div>
                    <div class="doc-tpl-info">
                        <h4>Solo Parent Certificate</h4>
                        <p>Certifies the resident's status as a solo parent for government benefits.</p>
                    </div>
                    <div class="doc-tpl-actions">
                        <button class="db-btn db-btn--sm db-btn--outline" onclick="event.stopPropagation();openDocModal('solo_parent')"><i class="fas fa-eye"></i> Preview</button>
                        <button class="db-btn db-btn--sm db-btn--primary" onclick="event.stopPropagation();printDoc('solo_parent')"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="db-modal-overlay" id="docModal">
        <div class="db-modal" style="max-width:860px;width:98%;">
            <div class="db-modal-header">
                <h3 id="docModalTitle"><i class="fas fa-file-alt"></i> Document Preview</h3>
                <button class="db-modal-close" onclick="closeDocModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="db-modal-body" style="padding:0;max-height:80vh;overflow-y:auto;background:#f0f0f0;">
                <div id="docPreviewArea"></div>
            </div>
            <div class="db-modal-footer">
                <button class="db-btn db-btn--outline" onclick="closeDocModal()">Close</button>
                <button class="db-btn db-btn--primary" id="docPrintBtn"><i class="fas fa-print"></i> Print</button>
            </div>
        </div>
    </div>
    <style>
        .doc-templates-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .doc-tpl-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #eaeef6;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s, border-color .2s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .04);
        }

        .doc-tpl-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(29, 36, 72, .1);
            border-color: #5b6fd6;
        }

        .doc-tpl-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .doc-tpl-info h4 {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 600;
            color: #1d2448;
        }

        .doc-tpl-info p {
            margin: 0;
            font-size: 12px;
            color: #7a8aaa;
            line-height: 1.5;
        }

        .doc-tpl-actions {
            display: flex;
            gap: 8px;
            margin-top: auto;
        }

        /* Document template print styles */
        .doc-template {
            padding: 32px 36px;
            font-family: 'Times New Roman', serif;
            font-size: 13px;
            color: #111;
            line-height: 1.7;
        }

        .doc-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1d2448;
            padding-bottom: 14px;
        }

        .doc-header .doc-republic {
            font-size: 11px;
            letter-spacing: .5px;
            color: #555;
            margin: 0;
        }

        .doc-header .doc-province {
            font-size: 11px;
            color: #555;
            margin: 0;
        }

        .doc-header .doc-barangay {
            font-size: 18px;
            font-weight: 700;
            color: #1d2448;
            margin: 6px 0 2px;
            letter-spacing: .5px;
        }

        .doc-header .doc-municipality {
            font-size: 12px;
            color: #444;
            margin: 0;
        }

        .doc-header .doc-logo-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 8px;
        }

        .doc-header .doc-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid #1d2448;
            object-fit: contain;
        }

        .doc-title {
            text-align: center;
            margin: 18px 0 6px;
        }

        .doc-title h2 {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #1d2448;
            margin: 0;
            text-decoration: underline;
        }

        .doc-title p {
            font-size: 11px;
            color: #777;
            margin: 4px 0 0;
            font-style: italic;
        }

        .doc-body {
            margin: 20px 0;
            text-align: justify;
        }

        .doc-body p {
            margin: 0 0 12px;
        }

        .doc-blank {
            display: inline-block;
            border-bottom: 1px solid #111;
            min-width: 180px;
            text-align: center;
            font-weight: 600;
        }

        .doc-footer {
            margin-top: 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .doc-sig {
            text-align: center;
            min-width: 200px;
        }

        .doc-sig .doc-sig-line {
            border-top: 1px solid #111;
            margin-top: 48px;
            padding-top: 4px;
            font-weight: 700;
            font-size: 13px;
        }

        .doc-sig .doc-sig-title {
            font-size: 11px;
            color: #555;
        }

        .doc-or {
            margin-top: 20px;
            font-size: 11px;
            color: #555;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }

        .doc-control {
            text-align: right;
            font-size: 11px;
            color: #777;
            margin-bottom: 8px;
        }

        @media print {

            .db-modal-overlay,
            .db-topbar,
            .db-sidebar,
            .db-toolbar,
            .db-stats,
            .db-table-wrap,
            .db-pagination,
            .doc-templates-grid,
            .db-section-title {
                display: none !important;
            }

            .doc-template {
                padding: 20px;
            }
        }
    </style>

    <style>
        .res-name-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #1a1d2e;
            font-weight: 500;
        }

        .res-name-link:hover span {
            color: #1d2448;
            text-decoration: underline;
        }
    </style>

    <script>
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const s = document.getElementById('statusFilter').value.toLowerCase();
            document.querySelectorAll('#clearanceTable tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = (text.includes(q) && (s === '' || text.includes(s))) ? '' : 'none';
            });
        }
        document.querySelectorAll('.db-nav-item').forEach(i => i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open')));

        function openRejectModal(id, role) {
            document.getElementById('rejectForm').action = '/' + role + '/clearance/reject/' + id;
            document.getElementById('rejectModal').classList.add('active');
        }

        const templates = {
            clearance: {
                title: 'Barangay Clearance',
                html: `<div class="bc-wrap" id="printable-doc">
  <div class="bc-page">

    <div class="bc-top-box">
      <div class="bc-header-row">
            <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">
                <div class="bc-header-center">
                    <p>Republic of the Philippines</p>
                    <p>Region V</p>
                    <p>Province of Camarines Sur</p>
                    <p>Municipality of Bato</p>
                    <p><strong>BARANGAY BACOLOD</strong></p>
                    <p class="bc-oOo">-oOo-</p>
                </div>
            <img src="/bacolod.png" class="bc-seal" alt="Bato Seal">
        </div>
      <div class="bc-office-bar" style="text-align:center;"><strong>OFFICE OF THE PUNONG BARANGAY</strong></div>
    </div>

    <div class="bc-body-box">
      <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>

      <div class="bc-doc-title">BARANGAY CLEARANCE</div>

      <div class="bc-body-text">
        <p><strong>TO WHOM IT MAY CONCERN,</strong></p>
        <p class="bc-indent">This is to certify that <span class="bc-line" style="width:220px;"></span>, a legal age, Single and a bonafide resident of <span class="bc-line" style="width:110px;"></span>, <strong>Barangay Bacolod, Bato, Camarines Sur.</strong></p>
        <p class="bc-indent">She possessed good moral character trustworthy, a law-abiding Filipino Citizen and&nbsp; cooperative to all undertakings for the progress of&nbsp; the community.</p>
        <p class="bc-indent">This Barangay Clearance is being issued upon the request of the above-named person for&nbsp; whatever legal purposes it may serve.</p>
        <p class="bc-indent">Given this <span class="bc-line" style="width:75px;"></span> day of <span class="bc-line" style="width:120px;"></span> at <strong>Barangay Bacolod, Bato, Camarines Sur, Philippines.</strong></p>
      </div>

      <div class="bc-sig-section">
        <div class="bc-sig-left">
          <div class="bc-sig-line"></div>
          <div class="bc-sig-sub">(Signature of Applicant)</div>
        </div>
        <div class="bc-sig-right">
          <p class="bc-approved-by">Approved by:</p>
          <p class="bc-captain-name"><?= esc($captainName ?? 'PUNONG BARANGAY') ?></p>
          <p class="bc-captain-title">Punong Barangay</p>
        </div>
      </div>

      <div class="bc-footer-info">
        <p>CTC No.&nbsp; : 08467278</p>
        <p>Issued at : <strong><u>Bacolod Bato Camarines Sur</u></strong></p>
        <p>Issued on: <strong><u>April 12, 2026</u></strong></p>
        <div class="bc-photo-row">
          <div class="bc-photo-box"></div>
          <div class="bc-photo-box"></div>
        </div>
        <p>OR. No.&nbsp;&nbsp; : 2149024</p>
        <p>Issued at : <strong><u>Bacolod, Bato, Camarines Sur</u></strong></p>
        <p>Issued on: <strong><u>April 12, 2026</u></strong></p>
      </div>
    </div>
  </div>
</div>
<style>
/* A4 = 210mm × 297mm. At 96dpi screen: 794px × 1123px */
.bc-wrap{font-family:'Cambria',serif;font-size:14px;color:#111;background:#f0f0f0;display:flex;justify-content:center;padding:20px 0;}
.bc-page{width:794px;min-height:1123px;background:#fff;border:2px solid #3a6abf;box-sizing:border-box;display:flex;flex-direction:column;position:relative;}
/* header */
.bc-top-box{border-bottom:2px solid #3a6abf;padding:24px 40px 0;}
.bc-header-row{display:flex;align-items:flex-start;justify-content:center;gap:32px;padding-bottom:14px;}
.bc-seal{width:90px;height:90px;object-fit:contain;border-radius:50%;}
.bc-header-center{text-align:center;font-size:13px;line-height:1.7;color:#111;}
.bc-header-center p{margin:0;}
.bc-header-center strong{font-size:14px;}
.bc-oOo{font-style:italic;color:#555;margin-top:3px!important;}
.bc-office-bar{font-size:17px;font-weight:700;letter-spacing:.5px;color:#111;padding:10px 0 12px;margin-top:10px;text-align:center;}
/* body */
.bc-body-box{flex:1;padding:28px 48px 36px;position:relative;overflow:hidden;}
.bc-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:0.07;pointer-events:none;z-index:0;}
.bc-watermark img{width:420px;height:420px;object-fit:contain;}
.bc-doc-title{text-align:center;font-size:20px;font-weight:700;color:#111;letter-spacing:.5px;margin-bottom:28px;position:relative;z-index:1;}
.bc-body-text{position:relative;z-index:1;line-height:2;text-align:justify;font-size:14px;}
.bc-body-text p{margin:0 0 14px;}
.bc-indent{text-indent:3em;}
.bc-line{display:inline-block;border-bottom:1px solid #111;vertical-align:bottom;height:1px;}
/* signatures */
.bc-sig-section{display:flex;justify-content:space-between;align-items:flex-end;margin:48px 0 32px;position:relative;z-index:1;}
.bc-sig-left{min-width:200px;}
.bc-sig-line{border-bottom:1px solid #111;width:190px;margin-bottom:4px;}
.bc-sig-sub{font-size:12px;color:#444;}
.bc-sig-right{text-align:center;}
.bc-approved-by{margin:0 0 4px;font-size:14px;}
.bc-captain-name{margin:0;font-weight:700;font-size:15px;letter-spacing:.3px;}
.bc-captain-title{margin:0;font-size:13px;color:#333;}
/* footer */
.bc-footer-info{position:relative;z-index:1;font-size:13px;line-height:1.8;}
.bc-footer-info p{margin:0;}
.bc-photo-row{display:flex;gap:12px;margin:12px 0;}
.bc-photo-box{width:90px;height:100px;border:1px solid #555;}
</style>`
            },
            residency: {
                title: 'Barangay Certification',
                html: `<div class="bc-wrap" id="printable-doc">
  <div class="bc-page">

    <div class="bc-top-box">
      <div class="bc-header-row">
        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">
        <div class="bc-header-center">
          <p>Republic of the Philippines</p>
          <p>Region V</p>
          <p>Province of Camarines Sur</p>
          <p>Municipality of Bato</p>
          <p><strong>BARANGAY BACOLOD</strong></p>
          <p class="bc-oOo">-oOo-</p>
        </div>
        <img src="/bacolod.png" class="bc-seal" alt="Bato Seal">
      </div>
      <div class="bc-office-bar" style="text-align:center;font-size:17px;font-weight:700;letter-spacing:.5px;padding:10px 0 12px;margin-top:10px;"><strong>OFFICE OF THE PUNONG BARANGAY</strong></div>
    </div>

    <div class="bc-body-box">
      <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>

      <div class="bc-doc-title" style="color:#1a3a8f;font-size:22px;font-weight:800;margin-bottom:32px;">BARANGAY CERTIFICATION</div>

      <div class="bc-body-text" style="line-height:1.9;font-size:14px;">
        <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
        <p class="bc-indent">This is to certify that &nbsp;<strong>MR. RODOLFO RELANO AND MRS. PATRICIA ELPEDES RELANO</strong>, both of legal age, Married Filipino and a Bonafide resident of &nbsp;Zone 3 Barangay Bacolod , Bato Camarines Sur.</p>
        <p class="bc-indent">This further certify &nbsp;that according to the records &nbsp;that above- mentioned names was living in the same Household together at the address stated above.</p>
        <p class="bc-indent">This certification is issued upon the request of interested party as reference and for whatever legal intent this may serve.</p>
        <p class="bc-indent">Issued this <strong>16th</strong> day of <strong>April, 2026</strong> at <strong>Barangay Bacolod, Bato, Camarines Sur. Philippines.</strong></p>
      </div>

      <div class="bc-sig-section" style="justify-content:flex-end;margin:60px 0 32px;">
        <div style="text-align:center;min-width:220px;">
          <p style="margin:0 0 6px;font-size:14px;">Attested by:</p>
          <p style="margin:0;font-weight:700;font-size:15px;text-decoration:underline;letter-spacing:.3px;"><?= esc($captainName ?? 'PUNONG BARANGAY') ?></p>
          <p style="margin:0;font-size:13px;color:#333;">Punong Barangay</p>
        </div>
      </div>

    </div>
  </div>
</div>
<style>
.bc-wrap{font-family:'Cambria',serif;font-size:14px;color:#111;background:#f0f0f0;display:flex;justify-content:center;padding:20px 0;}
.bc-page{width:794px;min-height:1123px;background:#fff;border:2px solid #3a6abf;box-sizing:border-box;display:flex;flex-direction:column;position:relative;}
.bc-top-box{border-bottom:2px solid #3a6abf;padding:24px 40px 0;}
.bc-header-row{display:flex;align-items:flex-start;justify-content:center;gap:32px;padding-bottom:14px;}
.bc-seal{width:90px;height:90px;object-fit:contain;border-radius:50%;}
.bc-header-center{text-align:center;font-size:13px;line-height:1.7;color:#111;}
.bc-header-center p{margin:0;}
.bc-header-center strong{font-size:14px;}
.bc-oOo{font-style:italic;color:#555;margin-top:3px!important;}
.bc-body-box{flex:1;padding:28px 48px 36px;position:relative;overflow:hidden;}
.bc-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:0.07;pointer-events:none;z-index:0;}
.bc-watermark img{width:420px;height:420px;object-fit:contain;}
.bc-doc-title{text-align:center;letter-spacing:.5px;position:relative;z-index:1;}
.bc-body-text{position:relative;z-index:1;text-align:justify;}
.bc-body-text p{margin:0 0 20px;}
.bc-indent{text-indent:3em;}
.bc-line{display:inline-block;border-bottom:1px solid #111;vertical-align:bottom;height:1px;}
.bc-sig-section{display:flex;align-items:flex-end;position:relative;z-index:1;}
</style>`
            },
            indigency: {
                title: 'Certificate of Indigency',
                html: `<div class="bc-wrap" id="printable-doc">
  <div class="bc-page">

    <div class="bc-top-box">
      <div class="bc-header-row">
        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">
        <div class="bc-header-center">
          <p>Republic of the Philippines</p>
          <p>Region V</p>
          <p>Province of Camarines Sur</p>
          <p>Municipality of Bato</p>
          <p><strong>BARANGAY BACOLOD</strong></p>
          <p class="bc-oOo">-oOo-</p>
        </div>
        <img src="/bacolod.png" class="bc-seal" alt="Bato Seal">
      </div>
      <div class="bc-office-bar" style="text-align:center;font-size:17px;font-weight:700;letter-spacing:.5px;padding:10px 0 12px;margin-top:10px;"><strong>OFFICE OF THE PUNONG BARANGAY</strong></div>
    </div>

    <div class="bc-body-box">
      <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>

      <div class="bc-doc-title" style="color:#1a3a8f;font-size:22px;font-weight:800;margin-bottom:32px;">CERTIFICATE OF INDIGENCY</div>

      <div class="bc-body-text" style="line-height:1.9;font-size:14px;">
        <p><strong>To Whom It May Concern,</strong></p>
        <p class="bc-indent">This is to certify that <strong>EMELDA L. BENEGAS,</strong> legal age, married, bonafide resident of <strong>Zone 5, Barangay Bacolod, Bato, Camarines Sur</strong> and are identified belonging to the <strong>"Indigent family"</strong> in this community as per record in this office.</p>
        <p class="bc-indent">This further certifies that the above-named and whose family earned meager income not enough to augment their basic needs and financial, hence and indigent and qualified to avail for &nbsp;<strong>Philhealth Assistance (YAKAP)</strong>.</p>
        <p class="bc-indent">Given this <strong>13th</strong> day of <strong>April, 2026</strong> at <strong>Barangay Bacolod, Bato Camarines Sur. Philippines.</strong></p>
      </div>

      <div class="bc-sig-section" style="justify-content:flex-end;margin:60px 0 32px;">
        <div style="text-align:center;min-width:220px;">
          <p style="margin:0 0 6px;font-size:14px;">Attested by:</p>
          <p style="margin:0;font-weight:700;font-size:15px;text-decoration:underline;letter-spacing:.3px;"><?= esc($captainName ?? 'PUNONG BARANGAY') ?></p>
          <p style="margin:0;font-size:13px;color:#333;">Punong Barangay</p>
        </div>
      </div>

      <p class="bc-not-valid">Not Valid Without Seal</p>

    </div>
  </div>
</div>
<style>
.bc-wrap{font-family:'Cambria',serif;font-size:14px;color:#111;background:#f0f0f0;display:flex;justify-content:center;padding:20px 0;}
.bc-page{width:794px;min-height:1123px;background:#fff;border:2px solid #3a6abf;box-sizing:border-box;display:flex;flex-direction:column;position:relative;}
.bc-top-box{border-bottom:2px solid #3a6abf;padding:24px 40px 0;}
.bc-header-row{display:flex;align-items:flex-start;justify-content:center;gap:32px;padding-bottom:14px;}
.bc-seal{width:90px;height:90px;object-fit:contain;border-radius:50%;}
.bc-header-center{text-align:center;font-size:13px;line-height:1.7;color:#111;}
.bc-header-center p{margin:0;}
.bc-header-center strong{font-size:14px;}
.bc-oOo{font-style:italic;color:#555;margin-top:3px!important;}
.bc-body-box{flex:1;padding:28px 48px 36px;position:relative;overflow:hidden;}
.bc-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:0.07;pointer-events:none;z-index:0;}
.bc-watermark img{width:420px;height:420px;object-fit:contain;}
.bc-doc-title{text-align:center;letter-spacing:.5px;position:relative;z-index:1;}
.bc-body-text{position:relative;z-index:1;text-align:justify;}
.bc-body-text p{margin:0 0 20px;}
.bc-indent{text-indent:3em;}
.bc-sig-section{display:flex;align-items:flex-end;position:relative;z-index:1;}
.bc-not-valid{color:#c0392b;font-size:13px;font-weight:600;position:relative;z-index:1;margin:0;}
</style>`
            },
            business: {
                title: 'Business Permit Clearance',
                html: `<div class="doc-template" id="printable-doc">
                    <div class="doc-control">Control No.: <strong>BP-2026-____</strong></div>
                    <div class="doc-header">
                        <div class="doc-logo-row">
                            <img src="/bacolod.png" class="doc-logo" alt="Logo">
                            <div>
                                <p class="doc-republic">Republic of the Philippines</p>
                                <p class="doc-province">Province of Camarines Sur</p>
                                <p class="doc-barangay">BARANGAY BACOLOD</p>
                                <p class="doc-municipality">Municipality of Bato, Camarines Sur</p>
                            </div>
                        </div>
                    </div>
                    <div class="doc-title"><h2>Business Permit Clearance</h2><p>Office of the Punong Barangay</p></div>
                    <div class="doc-body">
                        <p>TO WHOM IT MAY CONCERN:</p>
                        <p>This is to certify that <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, owner/operator of <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> located at <span class="doc-blank">Barangay Bacolod, Bato, Camarines Sur</span>, has been granted clearance by this barangay to operate said business.</p>
                        <p>The said business has no pending complaints or violations on record in this office as of the date of issuance.</p>
                        <p>This clearance is issued upon the request of the above-named person for business permit application purposes.</p>
                        <p>Issued this <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;</span> day of <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> at Barangay Bacolod, Bato, Camarines Sur.</p>
                    </div>
                    <div class="doc-footer">
                        <div class="doc-sig">
                            <div class="doc-sig-line">HON. [CAPTAIN NAME]</div>
                            <div class="doc-sig-title">Punong Barangay</div>
                        </div>
                    </div>
                    <div class="doc-or"><strong>OR No.:</strong> _____________ &nbsp;&nbsp; <strong>Amount Paid:</strong> ₱200.00 &nbsp;&nbsp; <strong>Date:</strong> _____________</div>
                </div>`
            },
            good_moral: {
                title: 'Certificate of Good Moral Character',
                html: `<div class="bc-wrap" id="printable-doc">
  <div class="bc-page">

    <div class="bc-top-box">
      <div class="bc-header-row">
        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">
        <div class="bc-header-center">
          <p>Republic of the Philippines</p>
          <p>Region V</p>
          <p>Province of Camarines Sur</p>
          <p>Municipality of Bato</p>
          <p><strong>BARANGAY BACOLOD</strong></p>
          <p class="bc-oOo">-oOo-</p>
        </div>
        <img src="/bacolod.png" class="bc-seal" alt="Bato Seal">
      </div>
      <div class="bc-office-bar" style="text-align:center;font-size:17px;font-weight:700;letter-spacing:.5px;padding:10px 0 12px;margin-top:10px;"><strong>OFFICE OF THE PUNONG BARANGAY</strong></div>
    </div>

    <div class="bc-body-box bc-two-col">

      <!-- LEFT: Officials sidebar -->
      <div class="bc-officials">
        <p class="bc-off-head">BARANGAY OFFICIALS</p>
        <p class="bc-off-name">HON. <?= esc($captainName ?? 'PUNONG BARANGAY') ?></p>
        <p class="bc-off-role">Punong Barangay</p>

        <p class="bc-off-head" style="margin-top:14px;">SANGGUNIANG BARANGAY</p>

        <p class="bc-off-name">HON. SANNY R. CUYA</p>
        <p class="bc-off-role">Committee on Agriculture</p>

        <p class="bc-off-name">HON. ROSITA E. PRESNILLO</p>
        <p class="bc-off-role">Committee on Health</p>

        <p class="bc-off-name">HON. MA. TERESA C. SASALUYA</p>
        <p class="bc-off-role">Committee on BDRRMC</p>

        <p class="bc-off-name">HON. NOLITO S. SANTOR</p>
        <p class="bc-off-role">Committee on Infrastructure</p>

        <p class="bc-off-name">HON. ARLENE I. DANCALAN</p>
        <p class="bc-off-role">Committee on Appropriation</p>

        <p class="bc-off-name">HON. MERCY C. DANCALAN</p>
        <p class="bc-off-role">Committee on Education</p>

        <p class="bc-off-name">HON. CHRISTOPHER L. SANTOR</p>
        <p class="bc-off-role">Committee on Peace and Order</p>

        <p class="bc-off-name">KRISTINE MAE C. COLICO</p>
        <p class="bc-off-role">SK Chairperson</p>

        <p class="bc-off-name">ANALINE I. BENEGAS</p>
        <p class="bc-off-role">Barangay Secretary</p>

        <p class="bc-off-name">MARILYN P. INTIA</p>
        <p class="bc-off-role">Barangay Treasurer</p>

        <div style="margin-top:auto;padding-top:20px;">
          <p class="bc-not-valid">Not Valid Without Seal</p>
        </div>
      </div>

      <!-- RIGHT: Document body -->
      <div class="bc-right-col">
        <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>

        <div class="bc-doc-title" style="color:#1a3a8f;font-size:22px;font-weight:800;line-height:1.3;margin-bottom:32px;text-align:center;position:relative;z-index:1;">CERTIFICATE OF<br>GOOD MORAL CHARACTER</div>

        <div class="bc-body-text" style="position:relative;z-index:1;line-height:1.9;text-align:justify;font-size:14px;">
          <p><strong>TO WHOM IT MAY CONCERN,</strong></p>
          <p class="bc-indent">This is to certify that <strong>MARICON ELPEDES SU&Ntilde;AS,</strong> &nbsp;24 years old, a bonafide resident of &nbsp;<strong>Zone 2, Barangay Bacolod, Bato, Camarines Sur</strong> and personally known to me law abiding citizen and has Good Moral Character and has a good standing in this community.</p>
          <p class="bc-indent">She has never been acused of any crime nor any pending case filled against him.</p>
          <p class="bc-indent">This certification is being issued for requirements.</p>
          <p class="bc-indent">Given this <strong>12th</strong> day of &nbsp;<strong>December, 2025</strong> at <strong>Barangay Bacolod, Bato, Camarines Sur. Philippines.</strong></p>
        </div>

        <div style="display:flex;justify-content:flex-end;margin:60px 0 24px;position:relative;z-index:1;">
          <div style="text-align:center;min-width:220px;">
            <p style="margin:0 0 6px;font-size:14px;">Noted by:</p>
            <p style="margin:0;font-weight:700;font-size:15px;text-decoration:underline;letter-spacing:.3px;">HON. <?= esc($captainName ?? 'PUNONG BARANGAY') ?></p>
            <p style="margin:0;font-size:13px;color:#333;">Punong Barangay</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<style>
.bc-wrap{font-family:'Cambria',serif;font-size:14px;color:#111;background:#f0f0f0;display:flex;justify-content:center;padding:20px 0;}
.bc-page{width:794px;min-height:1123px;background:#fff;border:2px solid #3a6abf;box-sizing:border-box;display:flex;flex-direction:column;position:relative;}
.bc-top-box{border-bottom:2px solid #3a6abf;padding:24px 40px 0;}
.bc-header-row{display:flex;align-items:flex-start;justify-content:center;gap:32px;padding-bottom:14px;}
.bc-seal{width:90px;height:90px;object-fit:contain;border-radius:50%;}
.bc-header-center{text-align:center;font-size:13px;line-height:1.7;color:#111;}
.bc-header-center p{margin:0;}
.bc-header-center strong{font-size:14px;}
.bc-oOo{font-style:italic;color:#555;margin-top:3px!important;}
.bc-body-box{flex:1;position:relative;overflow:hidden;}
.bc-two-col{display:flex;flex-direction:row;padding:0!important;}
.bc-officials{width:200px;flex-shrink:0;border-right:1.5px solid #3a6abf;padding:18px 14px;display:flex;flex-direction:column;font-family:'Times New Roman',serif;}
.bc-off-head{font-size:11px;font-weight:700;color:#111;margin:0 0 4px;text-decoration:underline;}
.bc-off-name{font-size:11px;font-weight:700;color:#111;margin:6px 0 0;}
.bc-off-role{font-size:10px;color:#3a6abf;margin:0;}
.bc-right-col{flex:1;padding:28px 32px 28px;position:relative;overflow:hidden;}
.bc-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:0.07;pointer-events:none;z-index:0;}
.bc-watermark img{width:380px;height:380px;object-fit:contain;}
.bc-indent{text-indent:3em;}
.bc-not-valid{color:#c0392b;font-size:13px;font-weight:600;margin:0;}
</style>`
            },
            solo_parent: {
                title: 'Solo Parent Certificate',
                html: `<div class="doc-template" id="printable-doc">
                    <div class="doc-control">Control No.: <strong>SP-2026-____</strong></div>
                    <div class="doc-header">
                        <div class="doc-logo-row">
                            <img src="/bacolod.png" class="doc-logo" alt="Logo">
                            <div>
                                <p class="doc-republic">Republic of the Philippines</p>
                                <p class="doc-province">Province of Camarines Sur</p>
                                <p class="doc-barangay">BARANGAY BACOLOD</p>
                                <p class="doc-municipality">Municipality of Bato, Camarines Sur</p>
                            </div>
                        </div>
                    </div>
                    <div class="doc-title"><h2>Solo Parent Certificate</h2><p>Office of the Punong Barangay &mdash; R.A. 8972</p></div>
                    <div class="doc-body">
                        <p>TO WHOM IT MAY CONCERN:</p>
                        <p>This is to certify that <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;</span> years of age, a resident of <span class="doc-blank">Barangay Bacolod, Bato, Camarines Sur</span>, is a <strong>Solo Parent</strong> as defined under Republic Act No. 8972, otherwise known as the "Solo Parents' Welfare Act of 2000."</p>
                        <p>The above-named person is solely responsible for the care and upbringing of <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;</span> child/children.</p>
                        <p>This certification is issued upon the request of the above-named person for availment of solo parent benefits and for whatever legal intent it may serve.</p>
                        <p>Issued this <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;</span> day of <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, <span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> at Barangay Bacolod, Bato, Camarines Sur.</p>
                    </div>
                    <div class="doc-footer">
                        <div class="doc-sig">
                            <div class="doc-sig-line">HON. [CAPTAIN NAME]</div>
                            <div class="doc-sig-title">Punong Barangay</div>
                        </div>
                    </div>
                    <div class="doc-or"><strong>Note:</strong> This document is issued free of charge.</div>
                </div>`
            }
        };

        let currentDoc = null;

        function openDocModal(type) {
            const tpl = templates[type];
            if (!tpl) return;
            currentDoc = type;
            document.getElementById('docModalTitle').innerHTML = '<i class="fas fa-file-alt"></i> ' + tpl.title;
            document.getElementById('docPreviewArea').innerHTML = tpl.html;
            document.getElementById('docModal').classList.add('active');
        }

        function closeDocModal() {
            document.getElementById('docModal').classList.remove('active');
            currentDoc = null;
        }

        document.getElementById('docPrintBtn').addEventListener('click', function() {
            if (currentDoc) printDoc(currentDoc);
        });

        function printDoc(type) {
            const tpl = templates[type];
            if (!tpl) return;
            const win = window.open('', '_blank', 'width=900,height=800');
            win.document.write(`<!DOCTYPE html><html><head><title>${tpl.title}</title>
            <style>
                @page{size:A4 portrait;margin:0;}
                *{box-sizing:border-box;}
                body{margin:0;padding:0;background:#fff;}
                .doc-template{padding:40px 48px;font-family:'Times New Roman',serif;font-size:13px;color:#111;}
                .doc-header{text-align:center;margin-bottom:20px;border-bottom:2px solid #1d2448;padding-bottom:14px;}
                .doc-republic,.doc-province,.doc-municipality{font-size:11px;color:#555;margin:0;}
                .doc-barangay{font-size:18px;font-weight:700;color:#1d2448;margin:6px 0 2px;}
                .doc-logo-row{display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:8px;}
                .doc-logo{width:60px;height:60px;border-radius:50%;border:2px solid #1d2448;object-fit:contain;}
                .doc-title{text-align:center;margin:18px 0 6px;}
                .doc-title h2{font-size:16px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#1d2448;margin:0;text-decoration:underline;}
                .doc-title p{font-size:11px;color:#777;margin:4px 0 0;font-style:italic;}
                .doc-body{margin:20px 0;text-align:justify;}
                .doc-body p{margin:0 0 12px;}
                .doc-blank{display:inline-block;border-bottom:1px solid #111;min-width:180px;text-align:center;font-weight:600;}
                .doc-footer{margin-top:48px;display:flex;justify-content:flex-end;}
                .doc-sig{text-align:center;min-width:200px;}
                .doc-sig-line{border-top:1px solid #111;margin-top:48px;padding-top:4px;font-weight:700;font-size:13px;}
                .doc-sig-title{font-size:11px;color:#555;}
                .doc-or{margin-top:20px;font-size:11px;color:#555;border-top:1px dashed #ccc;padding-top:10px;}
                .doc-control{text-align:right;font-size:11px;color:#777;margin-bottom:8px;}
                .bc-wrap{font-family:'Times New Roman',serif;font-size:14px;color:#111;background:#fff;margin:0;padding:0;}
                .bc-page{width:210mm;min-height:297mm;background:#fff;border:2px solid #3a6abf;display:flex;flex-direction:column;}
                .bc-top-box{border-bottom:2px solid #3a6abf;padding:24px 40px 0;}
                .bc-header-row{display:flex;align-items:flex-start;justify-content:center;gap:32px;padding-bottom:14px;}
                .bc-seal{width:90px;height:90px;object-fit:contain;border-radius:50%;}
                .bc-header-center{text-align:center;font-size:13px;line-height:1.7;color:#111;}
                .bc-header-center p{margin:0;}
                .bc-header-center strong{font-size:14px;}
                .bc-oOo{font-style:italic;color:#555;}
                .bc-office-bar{font-size:17px;font-weight:700;letter-spacing:.5px;color:#111;padding:10px 0 12px;margin-top:10px;text-align:center;}
                .bc-body-box{flex:1;padding:28px 48px 36px;position:relative;overflow:hidden;}
                .bc-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:0.07;pointer-events:none;}
                .bc-watermark img{width:420px;height:420px;object-fit:contain;}
                .bc-doc-title{text-align:center;font-size:20px;font-weight:700;letter-spacing:.5px;margin-bottom:28px;}
                .bc-body-text{line-height:2;text-align:justify;font-size:14px;}
                .bc-body-text p{margin:0 0 14px;}
                .bc-indent{text-indent:3em;}
                .bc-line{display:inline-block;border-bottom:1px solid #111;vertical-align:bottom;height:1px;}
                .bc-sig-section{display:flex;justify-content:space-between;align-items:flex-end;margin:48px 0 32px;}
                .bc-sig-left{min-width:200px;}
                .bc-sig-line{border-bottom:1px solid #111;width:190px;margin-bottom:4px;}
                .bc-sig-sub{font-size:12px;color:#444;}
                .bc-sig-right{text-align:center;}
                .bc-approved-by{margin:0 0 4px;font-size:14px;}
                .bc-captain-name{margin:0;font-weight:700;font-size:15px;}
                .bc-captain-title{margin:0;font-size:13px;color:#333;}
                .bc-footer-info{font-size:13px;line-height:1.8;}
                .bc-footer-info p{margin:0;}
                .bc-photo-row{display:flex;gap:12px;margin:12px 0;}
                .bc-photo-box{width:90px;height:100px;border:1px solid #555;}
                .bc-not-valid{color:#c0392b;font-size:13px;font-weight:600;margin-top:24px;}
                .bc-two-col{display:flex;flex-direction:row;padding:0!important;}
                .bc-officials{width:195px;flex-shrink:0;border-right:1.5px solid #3a6abf;padding:18px 14px;display:flex;flex-direction:column;font-family:'Times New Roman',serif;}
                .bc-off-head{font-size:11px;font-weight:700;color:#111;margin:0 0 4px;text-decoration:underline;}
                .bc-off-name{font-size:11px;font-weight:700;color:#111;margin:6px 0 0;}
                .bc-off-role{font-size:10px;color:#3a6abf;margin:0;}
                .bc-right-col{flex:1;padding:22px 28px 28px;position:relative;overflow:hidden;}
            </style></head><body>${tpl.html.replace(/<style>[\s\S]*?<\/style>/g,'')}<script>window.onload=function(){window.print();window.close();}<\/script></body></html>`);
            win.document.close();
        }
    </script>
</body>

</html>