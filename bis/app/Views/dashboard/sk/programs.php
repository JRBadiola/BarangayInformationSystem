<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Programs & Events - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .sk-form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #4a5068;
            margin-bottom: 5px;
        }

        .sk-form-input {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #e2e5ef;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: #1d2448;
            background: #fff;
            box-sizing: border-box;
            transition: border-color .2s;
            outline: none;
        }

        .sk-form-input:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, .07);
        }

        .sk-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }

        .sk-form-row--full {
            grid-template-columns: 1fr;
        }

        .db-action-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .prog-cat-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .prog-cat-sports {
            background: rgba(91, 111, 214, .12);
            color: #5b6fd6;
        }

        .prog-cat-livelihood {
            background: rgba(255, 193, 7, .12);
            color: #e6a800;
        }

        .prog-cat-health {
            background: rgba(220, 53, 69, .12);
            color: #dc3545;
        }

        .prog-cat-education {
            background: rgba(22, 199, 154, .12);
            color: #16c79a;
        }

        .prog-cat-environment {
            background: rgba(40, 167, 69, .12);
            color: #28a745;
        }

        .prog-cat-cultural {
            background: rgba(111, 66, 193, .12);
            color: #6f42c1;
        }

        .prog-cat-other {
            background: rgba(29, 36, 72, .08);
            color: #1d2448;
        }

        .db-badge--completed {
            background: rgba(108, 117, 125, .12);
            color: #6c757d;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .db-badge--cancelled {
            background: rgba(220, 53, 69, .1);
            color: #c0392b;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'sk';
    $active    = 'programs';
    $pageTitle = 'Programs & Events';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $programs  = $programs  ?? [];
    $counts    = $counts    ?? ['total' => 0, 'Active' => 0, 'Upcoming' => 0, 'Completed' => 0, 'Cancelled' => 0];
    $search    = $search    ?? '';
    $catF      = $catF      ?? '';
    $statusF   = $statusF   ?? '';

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
        'Cancelled' => 'db-badge--cancelled',
    ];
    $categories = ['Sports', 'Livelihood', 'Health', 'Education', 'Environment', 'Cultural', 'Other'];
    $statuses   = ['Upcoming', 'Active', 'Completed', 'Cancelled'];
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

            <!-- Stats -->
            <div class="db-stats" style="margin-bottom:24px;">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,.15);color:#5b6fd6;"><i class="fas fa-calendar-alt"></i></div>
                    <div><span class="db-stat-num"><?= $counts['total'] ?></span><span class="db-stat-label">Total Programs</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,.15);color:#16c79a;"><i class="fas fa-play-circle"></i></div>
                    <div><span class="db-stat-num"><?= $counts['Active'] ?></span><span class="db-stat-label">Active</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,.15);color:#e6a800;"><i class="fas fa-clock"></i></div>
                    <div><span class="db-stat-num"><?= $counts['Upcoming'] ?></span><span class="db-stat-label">Upcoming</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(108,117,125,.15);color:#6c757d;"><i class="fas fa-check-double"></i></div>
                    <div><span class="db-stat-num"><?= $counts['Completed'] ?></span><span class="db-stat-label">Completed</span></div>
                </div>
            </div>

            <!-- Toolbar -->
            <form method="get" action="" id="filterForm">
                <div class="db-toolbar">
                    <div class="db-search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Search programs..."
                            value="<?= esc($search) ?>" onchange="this.form.submit()">
                    </div>
                    <div class="db-toolbar-actions">
                        <select name="category" class="db-filter-select" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $c): ?>
                                <option <?= $catF === $c ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="status" class="db-filter-select" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <?php foreach ($statuses as $s): ?>
                                <option <?= $statusF === $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($search || $catF || $statusF): ?>
                            <a href="/sk/programs" class="db-btn db-btn--outline"><i class="fas fa-times"></i> Clear</a>
                        <?php endif; ?>
                        <button type="button" class="db-btn db-btn--primary" onclick="openModal('addProgramModal')">
                            <i class="fas fa-plus"></i> Add Program
                        </button>
                    </div>
                </div>
            </form>

            <!-- Table -->
            <div class="db-table-wrap">
                <table class="db-table" id="programsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Program Name</th>
                            <th>Category</th>
                            <th>Start Date</th>
                            <th>Venue</th>
                            <th>Target</th>
                            <th>Actual</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($programs)): ?>
                            <tr>
                                <td colspan="9" style="text-align:center;padding:32px;color:#9aa0b4;">
                                    <i class="fas fa-calendar-times" style="font-size:28px;display:block;margin-bottom:10px;color:#d0d5e8;"></i>
                                    No programs yet. Click <strong>Add Program</strong> to get started.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($programs as $i => $p):
                                $catKey = strtolower($p['category']);
                                $icon   = $catIcons[$p['category']] ?? 'fa-calendar';
                                $badge  = $badgeMap[$p['status']] ?? 'db-badge--pending';
                                $dateStr = $p['start_date'] ? date('M d, Y', strtotime($p['start_date'])) : '—';
                            ?>
                                <tr>
                                    <td><?= str_pad($i + 1, 3, '0', STR_PAD_LEFT) ?></td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px;">
                                            <div class="prog-cat-icon prog-cat-<?= $catKey ?>">
                                                <i class="fas <?= $icon ?>"></i>
                                            </div>
                                            <div>
                                                <div style="font-weight:600;color:#1a1d2e;"><?= esc($p['name']) ?></div>
                                                <?php if (!empty($p['description'])): ?>
                                                    <div style="font-size:11.5px;color:#9aa0b4;"><?= esc(mb_strimwidth($p['description'], 0, 60, '…')) ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc($p['category']) ?></td>
                                    <td><?= $dateStr ?></td>
                                    <td><?= esc($p['venue'] ?? '—') ?></td>
                                    <td><?= $p['target_participants'] ?: '—' ?></td>
                                    <td><?= $p['actual_participants'] > 0 ? $p['actual_participants'] : '—' ?></td>
                                    <td><span class="db-badge <?= $badge ?>"><?= esc($p['status']) ?></span></td>
                                    <td>
                                        <div class="db-action-group">
                                            <a href="/sk/programs/registrations/<?= $p['id'] ?>"
                                                class="db-icon-btn" title="View Registrations"
                                                style="color:#5b6fd6;">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <button class="db-icon-btn" title="Edit"
                                                onclick="openEditModal(<?= htmlspecialchars(json_encode($p), ENT_QUOTES) ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="/sk/programs/delete/<?= $p['id'] ?>" method="post" style="display:inline;"
                                                onsubmit="return confirm('Delete \'<?= esc(addslashes($p['name'])) ?>\'? This cannot be undone.')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="db-icon-btn" style="color:#dc3545;" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div><!-- /.db-content -->
    </div><!-- /.db-main -->

    <!-- ═══ ADD PROGRAM MODAL ═══ -->
    <div class="db-modal-overlay" id="addProgramModal" onclick="if(event.target===this)closeModal('addProgramModal')">
        <div class="db-modal" style="max-width:620px;width:96%;">
            <div class="db-modal-header">
                <h3><i class="fas fa-calendar-plus" style="color:#5b6fd6;margin-right:8px;"></i>Add Program / Event</h3>
                <button class="db-modal-close" onclick="closeModal('addProgramModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="db-modal-body" style="max-height:65vh;overflow-y:auto;">
                <form id="addProgramForm" action="/sk/programs/store" method="post">
                    <?= csrf_field() ?>

                    <div class="sk-form-row sk-form-row--full" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">Program Name <span style="color:#dc3545;">*</span></label>
                            <input type="text" name="name" class="sk-form-input" placeholder="e.g. Youth Leadership Summit" required>
                        </div>
                    </div>
                    <div class="sk-form-row" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">Category <span style="color:#dc3545;">*</span></label>
                            <select name="category" class="sk-form-input" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $c): ?>
                                    <option><?= $c ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="sk-form-label">Status</label>
                            <select name="status" class="sk-form-input">
                                <?php foreach ($statuses as $s): ?>
                                    <option><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="sk-form-row sk-form-row--full" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">Description</label>
                            <textarea name="description" class="sk-form-input" rows="2" placeholder="Brief description..." style="resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div class="sk-form-row sk-form-row--full" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">
                                Requirements
                                <span style="font-size:11px;font-weight:400;color:#b0b6cc;">(one per line — residents must confirm these to join)</span>
                            </label>
                            <textarea name="requirements" class="sk-form-input" rows="3"
                                placeholder="e.g.&#10;Barangay ID&#10;Medical Certificate&#10;Waiver Form"
                                style="resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div class="sk-form-row" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">Start Date <span style="color:#dc3545;">*</span></label>
                            <input type="date" name="start_date" class="sk-form-input" required>
                        </div>
                        <div>
                            <label class="sk-form-label">End Date</label>
                            <input type="date" name="end_date" class="sk-form-input">
                        </div>
                    </div>
                    <div class="sk-form-row sk-form-row--full" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">Venue <span style="color:#dc3545;">*</span></label>
                            <input type="text" name="venue" class="sk-form-input" placeholder="e.g. Barangay Hall, Bacolod" required>
                        </div>
                    </div>
                    <div class="sk-form-row" style="margin-bottom:4px;">
                        <div>
                            <label class="sk-form-label">Target Participants</label>
                            <input type="number" name="target_participants" class="sk-form-input" placeholder="e.g. 50" min="0">
                        </div>
                        <div>
                            <label class="sk-form-label">Actual Participants</label>
                            <input type="number" name="actual_participants" class="sk-form-input" placeholder="e.g. 45" min="0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="db-modal-footer">
                <button class="db-btn db-btn--outline" onclick="closeModal('addProgramModal')">Cancel</button>
                <button class="db-btn db-btn--primary" onclick="document.getElementById('addProgramForm').submit()">
                    <i class="fas fa-save"></i> Save Program
                </button>
            </div>
        </div>
    </div>

    <!-- ═══ EDIT PROGRAM MODAL ═══ -->
    <div class="db-modal-overlay" id="editProgramModal" onclick="if(event.target===this)closeModal('editProgramModal')">
        <div class="db-modal" style="max-width:620px;width:96%;">
            <div class="db-modal-header">
                <h3><i class="fas fa-edit" style="color:#5b6fd6;margin-right:8px;"></i>Edit Program</h3>
                <button class="db-modal-close" onclick="closeModal('editProgramModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="db-modal-body" style="max-height:65vh;overflow-y:auto;">
                <form id="editProgramForm" method="post">
                    <?= csrf_field() ?>

                    <div class="sk-form-row sk-form-row--full" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">Program Name <span style="color:#dc3545;">*</span></label>
                            <input type="text" name="name" id="edit_name" class="sk-form-input" required>
                        </div>
                    </div>
                    <div class="sk-form-row" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">Category</label>
                            <select name="category" id="edit_category" class="sk-form-input">
                                <?php foreach ($categories as $c): ?>
                                    <option><?= $c ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="sk-form-label">Status</label>
                            <select name="status" id="edit_status" class="sk-form-input">
                                <?php foreach ($statuses as $s): ?>
                                    <option><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="sk-form-row sk-form-row--full" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">Description</label>
                            <textarea name="description" id="edit_description" class="sk-form-input" rows="2" style="resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div class="sk-form-row sk-form-row--full" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">
                                Requirements
                                <span style="font-size:11px;font-weight:400;color:#b0b6cc;">(one per line)</span>
                            </label>
                            <textarea name="requirements" id="edit_requirements" class="sk-form-input" rows="3" style="resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div class="sk-form-row" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">Start Date</label>
                            <input type="date" name="start_date" id="edit_start_date" class="sk-form-input">
                        </div>
                        <div>
                            <label class="sk-form-label">End Date</label>
                            <input type="date" name="end_date" id="edit_end_date" class="sk-form-input">
                        </div>
                    </div>
                    <div class="sk-form-row sk-form-row--full" style="margin-bottom:14px;">
                        <div>
                            <label class="sk-form-label">Venue</label>
                            <input type="text" name="venue" id="edit_venue" class="sk-form-input">
                        </div>
                    </div>
                    <div class="sk-form-row" style="margin-bottom:4px;">
                        <div>
                            <label class="sk-form-label">Target Participants</label>
                            <input type="number" name="target_participants" id="edit_target" class="sk-form-input" min="0">
                        </div>
                        <div>
                            <label class="sk-form-label">Actual Participants</label>
                            <input type="number" name="actual_participants" id="edit_actual" class="sk-form-input" min="0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="db-modal-footer">
                <button class="db-btn db-btn--outline" onclick="closeModal('editProgramModal')">Cancel</button>
                <button class="db-btn db-btn--primary" onclick="document.getElementById('editProgramForm').submit()">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        function openEditModal(prog) {
            const form = document.getElementById('editProgramForm');
            form.action = '/sk/programs/update/' + prog.id;

            document.getElementById('edit_name').value = prog.name || '';
            document.getElementById('edit_description').value = prog.description || '';
            // Convert comma-separated requirements to one-per-line
            const reqs = prog.requirements ? prog.requirements.split(',').map(r => r.trim()).join('\n') : '';
            document.getElementById('edit_requirements').value = reqs;
            document.getElementById('edit_start_date').value = prog.start_date || '';
            document.getElementById('edit_end_date').value = prog.end_date || '';
            document.getElementById('edit_venue').value = prog.venue || '';
            document.getElementById('edit_target').value = prog.target_participants || '';
            document.getElementById('edit_actual').value = prog.actual_participants || '';

            // Select category
            const catSel = document.getElementById('edit_category');
            for (let o of catSel.options) o.selected = (o.value === prog.category);

            // Select status
            const stSel = document.getElementById('edit_status');
            for (let o of stSel.options) o.selected = (o.value === prog.status);

            openModal('editProgramModal');
        }

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>