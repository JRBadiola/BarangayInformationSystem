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
    <?php $role = 'secretary';
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
                    <div><span class="db-stat-num"><?= $approved ?? 0 ?></span><span class="db-stat-label">Released</span></div>
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
                        $roleVal   = 'secretary';
                        if (empty($residents)): ?>
                            <tr>
                                <td colspan="5" style="text-align:center;padding:32px;color:#9aa0b4;">
                                    <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                    No requests found.
                                </td>
                            </tr>
                            <?php else: foreach ($residents as $res):
                                $initial   = strtoupper(($res['resident_name'] ?? 'U')[0]);
                                $filed     = date('M d, Y', strtotime($res['latest_filed']));
                                $pendingC  = (int)$res['pending_count'];
                                $approvedC = (int)$res['approved_count'];
                                $rejectedC = (int)$res['rejected_count'];
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
                                            <?php if ($approvedC > 0): ?><span class="db-badge db-badge--approved"><?= $approvedC ?> Released</span><?php endif; ?>
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
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-top:28px;margin-bottom:12px;">
                <h3 class="db-section-title" style="margin:0;"><i class="fas fa-file-alt" style="color:#5b6fd6;margin-right:8px;"></i>Document Templates</h3>
                <a href="/secretary/templates"
                    class="db-btn db-btn--outline db-btn--sm"
                    style="display:inline-flex;align-items:center;gap:7px;font-size:12.5px;">
                    <i class="fas fa-landmark"></i> Edit Barangay Info
                </a>
            </div>
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
                        <h4>Barangay Residency</h4>
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
                <div class="doc-tpl-card" onclick="openDocModal('solo_parent')">
                    <div class="doc-tpl-icon" style="background:rgba(22,199,154,0.12);color:#16c79a;"><i class="fas fa-user-friends"></i></div>
                    <div class="doc-tpl-info">
                        <h4>First Time Job Seekers</h4>
                        <p>Certifies the resident's status as a solo parent for government benefits.</p>
                    </div>
                    <div class="doc-tpl-actions">
                        <button class="db-btn db-btn--sm db-btn--outline" onclick="event.stopPropagation();openDocModal('solo_parent')"><i class="fas fa-eye"></i> Preview</button>
                        <button class="db-btn db-btn--sm db-btn--primary" onclick="event.stopPropagation();printDoc('solo_parent')"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>

        </div><!-- /.db-content -->
    </div><!-- /.db-main -->

    <!-- Document Preview Modal -->
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
        /* ── Template grid ── */
        .doc-templates-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        @media (max-width: 900px) {
            .doc-templates-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .doc-templates-grid {
                grid-template-columns: 1fr;
            }
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

        /* ── Table helper ── */
        .res-name-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #1a1d2e;
            font-weight: 500;
        }

        /* ── Print ── */
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
        }
    </style>

    <script>
        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );

        function openRejectModal(id, role) {
            document.getElementById('rejectForm').action = '/' + role + '/clearance/reject/' + id;
            document.getElementById('rejectModal').classList.add('active');
        }

        // ── Templates loaded from DB (no hardcoded strings) ───────────────────
        const templates = <?= json_encode($templates ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

        // ── Barangay settings + captain name for token replacement ────────────
        const pageVars = <?= json_encode(array_merge(
                                $barangaySettings ?? [],
                                ['captain_name' => $captainName ?? 'PUNONG BARANGAY']
                            ), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

        // ── Screen-preview CSS injected alongside rendered template HTML ──────
        const BC_SCREEN_CSS = `<style>
.bc-wrap{font-family:'Cambria',serif;font-size:14px;color:#111;background:#f0f0f0;display:flex;justify-content:center;padding:20px 0;}
.bc-page{width:794px;min-height:1123px;background:#fff;border:2px solid #3a6abf;box-sizing:border-box;display:flex;flex-direction:column;position:relative;}
.bc-top-box{border-bottom:2px solid #3a6abf;padding:20px 40px 0;}
.bc-header-row{display:flex;align-items:flex-start;justify-content:center;gap:32px;padding-bottom:14px;}
.bc-seal{width:90px;height:90px;object-fit:contain;border-radius:50%;}
.bc-header-center{text-align:center;font-family:'Times New Roman',serif;font-size:12px;font-weight:bold;line-height:1.6;color:#111;}
.bc-header-center p{margin:0;}.bc-oOo{font-weight:normal!important;font-style:italic;}
.bc-office-bar{font-family:'Times New Roman',serif;font-size:14px;font-weight:bold;color:#111;padding:8px 0 10px;text-align:center;}
.bc-body-box{flex:1;padding:28px 48px 36px;position:relative;overflow:hidden;}
.bc-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:0.06;pointer-events:none;z-index:0;}
.bc-watermark img{width:420px;height:420px;object-fit:contain;}
.bc-doc-title{text-align:center;font-family:'Times New Roman',serif;font-size:20px;font-weight:700;margin-bottom:28px;position:relative;z-index:1;letter-spacing:.5px;}
.bc-body-text{font-family:'Times New Roman',serif;font-size:14px;position:relative;z-index:1;line-height:2;text-align:justify;}
.bc-body-text p{margin:0 0 14px;}.bc-indent{text-indent:3em;}
.bc-line{display:inline-block;border-bottom:1px solid #111;vertical-align:bottom;height:1px;}
.bc-sig-section{display:flex;justify-content:space-between;align-items:flex-end;margin:48px 0 32px;position:relative;z-index:1;}
.bc-sig-left{min-width:200px;}.bc-sig-line{border-bottom:1px solid #111;width:190px;margin-bottom:4px;}
.bc-sig-sub{font-size:12px;color:#444;}.bc-sig-right{text-align:center;}
.bc-approved-by{margin:0 0 4px;font-size:14px;}.bc-captain-name{margin:0;font-weight:700;font-size:15px;letter-spacing:.3px;}
.bc-captain-title{margin:0;font-size:13px;color:#333;}
.bc-footer-info{margin-top:24px;font-family:'Times New Roman',serif;position:relative;z-index:1;font-size:12px;line-height:1.6;}
.bc-footer-info p{margin:0;}.bc-photo-row{display:flex;gap:12px;margin:10px 0;}
.bc-photo-box{width:90px;height:80px;border:1px solid #555;}
.bc-two-col{display:flex;flex-direction:row;padding:0!important;}
.bc-officials{width:200px;flex-shrink:0;border-right:1.5px solid #3a6abf;padding:18px 14px;display:flex;flex-direction:column;font-family:'Times New Roman',serif;}
.bc-off-head{font-size:11px;font-weight:700;color:#111;margin:0 0 4px;text-decoration:underline;}
.bc-off-name{font-size:11px;font-weight:700;color:#111;margin:6px 0 0;}.bc-off-role{font-size:10px;color:#3a6abf;margin:0;}
.bc-right-col{flex:1;padding:28px 32px 28px;position:relative;overflow:hidden;}
.bc-not-valid{color:#c0392b;font-size:13px;font-weight:600;position:relative;z-index:1;margin:10px 0 0;}
.doc-template{padding:32px 36px;font-family:'Times New Roman',serif;font-size:13px;color:#111;line-height:1.7;}
.doc-header{text-align:center;margin-bottom:20px;border-bottom:2px solid #1d2448;padding-bottom:14px;}
.doc-republic,.doc-province,.doc-municipality{font-size:11px;color:#555;margin:0;}
.doc-barangay{font-size:18px;font-weight:700;color:#1d2448;margin:6px 0 2px;letter-spacing:.5px;}
.doc-logo-row{display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:8px;}
.doc-logo{width:60px;height:60px;border-radius:50%;border:2px solid #1d2448;object-fit:contain;}
.doc-title{text-align:center;margin:18px 0 6px;}
.doc-title h2{font-size:16px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#1d2448;margin:0;text-decoration:underline;}
.doc-title p{font-size:11px;color:#777;margin:4px 0 0;font-style:italic;}
.doc-body{margin:20px 0;text-align:justify;}.doc-body p{margin:0 0 12px;}
.doc-blank{display:inline-block;border-bottom:1px solid #111;min-width:160px;text-align:center;}
.doc-footer{margin-top:32px;display:flex;justify-content:flex-end;}
.doc-sig{text-align:center;min-width:200px;}
.doc-sig-line{border-top:1px solid #111;margin-top:48px;padding-top:4px;font-weight:700;font-size:13px;}
.doc-sig-title{font-size:11px;color:#555;}
.doc-or{margin-top:20px;font-size:11px;color:#555;border-top:1px dashed #ccc;padding-top:10px;}
.doc-control{text-align:right;font-size:11px;color:#777;margin-bottom:8px;}
</style>`;

        /**
         * Replace {{tokens}} in the template HTML with real values.
         * Field-level defaults are applied first, then barangay settings.
         */
        function renderTemplate(template) {
            // The DB stores \n as literal escape sequences — convert to real newlines
            let html = (template.html || '').replace(/\\n/g, '\n').replace(/\\t/g, '\t');

            // Field-level tokens (e.g. {{recipient_name}})
            if (Array.isArray(template.fields)) {
                template.fields.forEach(field => {
                    const val = field.value ?? '';
                    html = html.replace(
                        new RegExp('\\{\\{\\s*' + field.name + '\\s*\\}\\}', 'g'),
                        val || '<span class="doc-blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
                    );
                });
            }

            // Barangay settings tokens (e.g. {{barangay_name}}, {{captain_name}})
            Object.entries(pageVars).forEach(([key, value]) => {
                html = html.replace(new RegExp('\\{\\{\\s*' + key + '\\s*\\}\\}', 'g'), value);
            });

            // Wrap with the screen-preview CSS so .bc-wrap/.bc-page render correctly in the modal
            return html + BC_SCREEN_CSS;
        }

        let currentDoc = null;

        function openDocModal(type) {
            const tpl = templates[type];
            if (!tpl) return;
            currentDoc = type;
            document.getElementById('docModalTitle').innerHTML = '<i class="fas fa-file-alt"></i> ' + (tpl.name || tpl.title || type);
            document.getElementById('docPreviewArea').innerHTML = renderTemplate(tpl);
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
            const rendered = renderTemplate(tpl);
            const title = tpl.name || tpl.title || type;

            const win = window.open('', '_blank', 'width=900,height=800');
            win.document.write(`<!DOCTYPE html><html><head><title>${title}</title>
<style>
@page{size:A4 portrait;margin:0;}*{box-sizing:border-box;}body{margin:0;padding:0;background:#fff;}
.doc-template{padding:40px 48px;font-family:'Times New Roman',serif;font-size:13px;color:#111;}
.doc-header{text-align:center;margin-bottom:20px;border-bottom:2px solid #1d2448;padding-bottom:14px;}
.doc-republic,.doc-province,.doc-municipality{font-size:11px;color:#555;margin:0;}
.doc-barangay{font-size:18px;font-weight:700;color:#1d2448;margin:6px 0 2px;}
.doc-logo-row{display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:8px;}
.doc-logo{width:60px;height:60px;border-radius:50%;border:2px solid #1d2448;object-fit:contain;}
.doc-title{text-align:center;margin:18px 0 6px;}
.doc-title h2{font-size:16px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#1d2448;margin:0;text-decoration:underline;}
.doc-title p{font-size:11px;color:#777;margin:4px 0 0;font-style:italic;}
.doc-body{margin:20px 0;text-align:justify;}.doc-body p{margin:0 0 12px;}
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
.bc-header-center p{margin:0;}.bc-header-center strong{font-size:14px;}
.bc-oOo{font-style:italic;color:#555;}
.bc-office-bar{font-size:17px;font-weight:700;letter-spacing:.5px;color:#111;padding:10px 0 12px;margin-top:10px;text-align:center;}
.bc-body-box{flex:1;padding:28px 48px 36px;position:relative;overflow:hidden;}
.bc-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:0.07;pointer-events:none;}
.bc-watermark img{width:420px;height:420px;object-fit:contain;}
.bc-doc-title{text-align:center;font-size:20px;font-weight:700;letter-spacing:.5px;margin-bottom:28px;}
.bc-body-text{line-height:2;text-align:justify;font-size:14px;}.bc-body-text p{margin:0 0 14px;}
.bc-indent{text-indent:3em;}
.bc-line{display:inline-block;border-bottom:1px solid #111;vertical-align:bottom;height:1px;}
.bc-sig-section{display:flex;justify-content:space-between;align-items:flex-end;margin:48px 0 32px;}
.bc-sig-left{min-width:200px;}.bc-sig-line{border-bottom:1px solid #111;width:190px;margin-bottom:4px;}
.bc-sig-sub{font-size:12px;color:#444;}.bc-sig-right{text-align:center;}
.bc-approved-by{margin:0 0 4px;font-size:14px;}.bc-captain-name{margin:0;font-weight:700;font-size:15px;}
.bc-captain-title{margin:0;font-size:13px;color:#333;}
.bc-footer-info{font-size:13px;line-height:1.8;}.bc-footer-info p{margin:0;}
.bc-photo-row{display:flex;gap:12px;margin:12px 0;}.bc-photo-box{width:90px;height:100px;border:1px solid #555;}
.bc-not-valid{color:#c0392b;font-size:13px;font-weight:600;margin-top:24px;}
.bc-two-col{display:flex;flex-direction:row;padding:0!important;}
.bc-officials{width:195px;flex-shrink:0;border-right:1.5px solid #3a6abf;padding:18px 14px;display:flex;flex-direction:column;font-family:'Times New Roman',serif;}
.bc-off-head{font-size:11px;font-weight:700;color:#111;margin:0 0 4px;text-decoration:underline;}
.bc-off-name{font-size:11px;font-weight:700;color:#111;margin:6px 0 0;}.bc-off-role{font-size:10px;color:#3a6abf;margin:0;}
.bc-right-col{flex:1;padding:22px 28px 28px;position:relative;overflow:hidden;}
</style></head><body>${rendered}<script>window.onload=function(){window.print();window.close();}<\/script></body></html>`);
            win.document.close();
        }
    </script>
</body>

</html>