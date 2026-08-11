<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Household Members - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role        = $role ?? 'captain';
    $active      = 'census';
    $pageTitle   = 'Household Members';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $householdId = $householdId ?? '—';
    $head        = $household   ?? [];
    $headName    = trim(($head['first_name'] ?? '') . ' ' . ($head['last_name'] ?? ''));
    $headAddress = $head['address'] ?? ($head['zone'] ?? '—');
    $headContact = $head['contact_number'] ?? '—';
    $headGender  = $head['gender'] ?? '—';
    $headDob     = !empty($head['date_of_birth']) ? date('M d, Y', strtotime($head['date_of_birth'])) : '—';
    $headDobVal  = $head['date_of_birth'] ?? '';
    $headAge     = !empty($head['date_of_birth']) ? (int)date_diff(date_create($head['date_of_birth']), date_create('today'))->y : '—';
    $headCivil   = $head['civil_status'] ?? '—';
    $members     = $members ?? [];

    // Education options
    $eduOptions = ['No Formal Education', 'Elementary Level', 'Elementary Graduate', 'High School Level', 'High School Graduate', 'College Level', 'College Graduate', 'Vocational / Tech-Voc', 'Post Graduate'];
    ?>

    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div class="hh-breadcrumb">
                <a href="/<?= esc($role) ?>/census" class="hh-back"><i class="fas fa-arrow-left"></i> Back to Census Records</a>
                <span class="hh-bc-sep">/</span>
                <span>Household #<?= esc($householdId) ?></span>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="db-alert db-alert--success" style="margin-bottom:16px;">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Head card -->
            <div class="hh-head-card">
                <div class="hh-head-avatar"><?= strtoupper($head['first_name'][0] ?? '?') ?></div>
                <div class="hh-head-info">
                    <h2><?= esc($headName) ?> <span class="hh-head-badge">Household Head</span></h2>
                    <div class="hh-head-meta">
                        <span><i class="fas fa-map-marker-alt"></i> <?= esc($head['zone'] ?? '—') ?></span>
                        <span><i class="fas fa-phone"></i> <?= esc($headContact) ?></span>
                        <span><i class="fas fa-venus-mars"></i> <?= esc($headGender) ?>, <?= $headAge ?> yrs</span>
                        <span><i class="fas fa-heart"></i> <?= esc($headCivil) ?></span>
                        <span><i class="fas fa-birthday-cake"></i> <?= $headDob ?></span>
                    </div>
                </div>
                <div class="hh-head-actions">
                    <button class="db-btn db-btn--outline db-btn--sm" onclick="openModal('editHeadModal')">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="db-btn db-btn--primary db-btn--sm" onclick="openModal('addMemberModal')">
                        <i class="fas fa-user-plus"></i> Add Member
                    </button>
                </div>
            </div>

            <!-- Members table -->
            <div class="hh-members-header">
                <h3 class="db-section-title" style="margin:0;">
                    <i class="fas fa-users" style="color:#1d2448;margin-right:6px;"></i>
                    Household Members <span class="hh-count"><?= count($members) ?></span>
                </h3>
            </div>

            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Relationship</th>
                            <th>Birthday</th>
                            <th>Age</th>
                            <th>Occupation</th>
                            <th>Monthly Income</th>
                            <th>Education</th>
                            <th>PhilHealth #</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($members)): ?>
                            <tr>
                                <td colspan="9" style="text-align:center;padding:24px;color:#9aa0b4;">
                                    No household members recorded yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($members as $m):
                                $mName   = esc($m['first_name']) . ' ' . esc($m['last_name']);
                                $mInit   = strtoupper($m['first_name'][0] ?? '?');
                                $mDob    = !empty($m['date_of_birth']) ? date('M d, Y', strtotime($m['date_of_birth'])) : '—';
                                $mAge    = !empty($m['date_of_birth']) ? (int)date_diff(date_create($m['date_of_birth']), date_create('today'))->y : '—';
                                $mData   = json_encode($m, JSON_HEX_APOS | JSON_HEX_QUOT);
                            ?>
                                <tr>
                                    <td>
                                        <div class="db-resident-name">
                                            <div class="db-avatar-sm"><?= $mInit ?></div><span><?= $mName ?></span>
                                        </div>
                                    </td>
                                    <td><span class="hh-rel-badge"><?= esc(ucfirst($m['relationship'])) ?></span></td>
                                    <td><?= $mDob ?></td>
                                    <td><?= $mAge ?></td>
                                    <td><?= esc($m['occupation'] ?? '—') ?></td>
                                    <td><?= $m['monthly_income'] ? '₱' . number_format($m['monthly_income'], 2) : '₱0.00' ?></td>
                                    <td><?= esc($m['educational_attainment'] ?? '—') ?></td>
                                    <td><code class="hh-philhealth"><?= esc($m['philhealth_no'] ?? '—') ?></code></td>
                                    <td>
                                        <div class="db-action-group">
                                            <button class="db-icon-btn db-icon-btn--edit" title="Edit"
                                                onclick='openEditMember(<?= $mData ?>)'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="/<?= $role ?>/census/member/delete/<?= $m['id'] ?>" method="post" style="display:inline;"
                                                onsubmit="return confirm('Remove this member?')">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="household_no" value="<?= esc($householdId) ?>">
                                                <button type="submit" class="db-icon-btn db-icon-btn--del" title="Remove"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ══ EDIT HOUSEHOLD HEAD MODAL ══ -->
    <div class="db-modal-overlay" id="editHeadModal">
        <div class="db-modal pf-modal">
            <form action="/<?= $role ?>/census/update/<?= esc($householdId) ?>" method="post" id="editHeadForm">
                <?= csrf_field() ?>

                <div class="pf-modal-header">
                    <div class="pf-modal-title-wrap">
                        <div class="pf-modal-logo"><img src="/bacolod.png" alt="Seal"></div>
                        <div>
                            <div class="pf-modal-republic">Republic of the Philippines</div>
                            <div class="pf-modal-barangay">Barangay Bacolod, Bato, Camarines Sur</div>
                            <div class="pf-modal-formtitle">EDIT HOUSEHOLD HEAD — CENSUS FORM</div>
                        </div>
                    </div>
                    <button type="button" class="pf-close-btn" onclick="closeModal('editHeadModal')"><i class="fas fa-times"></i></button>
                </div>

                <div class="pf-body">
                    <div class="pf-section">
                        <div class="pf-section-bar"><i class="fas fa-user"></i> PERSONAL INFORMATION</div>
                        <div class="pf-field-row pf-cols-4">
                            <div class="pf-field">
                                <div class="pf-field-label">Last Name</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="last_name" value="<?= esc($head['last_name'] ?? '') ?>" required>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">First Name</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="first_name" value="<?= esc($head['first_name'] ?? '') ?>" required>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Middle Name</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="middle_name" value="<?= esc($head['middle_name'] ?? '') ?>">
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Suffix</div>
                                <select class="pf-input" name="suffix">
                                    <option value="">— NONE —</option>
                                    <?php foreach (['Jr', 'Sr', 'II', 'III', 'IV'] as $s): ?>
                                        <option <?= ($head['suffix'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="pf-field-row pf-cols-4">
                            <div class="pf-field">
                                <div class="pf-field-label">Date of Birth</div>
                                <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="date_of_birth" value="<?= esc($headDobVal) ?>"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Place of Birth</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="place_of_birth" value="<?= esc($head['place_of_birth'] ?? '') ?>">
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Gender</div>
                                <select class="pf-input" name="gender">
                                    <option <?= ($head['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option <?= ($head['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Civil Status</div>
                                <select class="pf-input" name="civil_status">
                                    <?php foreach (['Single', 'Married', 'Widowed', 'Separated', 'Annulled'] as $cs): ?>
                                        <option <?= ($head['civil_status'] ?? '') === $cs ? 'selected' : '' ?>><?= $cs ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="pf-field-row pf-cols-4">
                            <div class="pf-field">
                                <div class="pf-field-label">Nationality</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="nationality" value="<?= esc($head['nationality'] ?? 'FILIPINO') ?>">
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Religion</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="religion" value="<?= esc($head['religion'] ?? '') ?>">
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Occupation</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="occupation" value="<?= esc($head['occupation'] ?? '') ?>">
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Monthly Income (₱)</div>
                                <input type="number" class="pf-input" name="monthly_income" value="<?= esc($head['monthly_income'] ?? '0') ?>" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="pf-field-row pf-cols-3">
                            <div class="pf-field">
                                <div class="pf-field-label">Contact Number</div>
                                <input type="text" class="pf-input" name="contact_number" value="<?= esc($head['contact_number'] ?? '') ?>">
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Educational Attainment</div>
                                <select class="pf-input" name="educational_attainment">
                                    <option value="">— Select —</option>
                                    <?php foreach ($eduOptions as $e): ?>
                                        <option <?= ($head['educational_attainment'] ?? '') === $e ? 'selected' : '' ?>><?= $e ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">PhilHealth Number</div>
                                <input type="text" class="pf-input pf-philhealth" name="philhealth_no" value="<?= esc($head['philhealth_no'] ?? '') ?>" maxlength="12" inputmode="numeric">
                            </div>
                        </div>
                        <div class="pf-field-row pf-cols-1">
                            <div class="pf-field">
                                <div class="pf-field-label">Complete Address</div>
                                <input type="text" class="pf-input pf-upper" name="address" value="<?= esc($head['address'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="pf-section">
                        <div class="pf-section-bar"><i class="fas fa-tags"></i> HOUSEHOLD CLASSIFICATION</div>
                        <div class="pf-field-row pf-cols-4">
                            <div class="pf-field">
                                <div class="pf-field-label">Zone / Purok</div>
                                <select class="pf-input" name="zone">
                                    <option value="">— Select —</option>
                                    <?php foreach (['Zone 1', 'Zone 2', 'Zone 3', 'Zone 4', 'Zone 5', 'Zone 6', 'Zone 7',] as $z): ?>
                                        <option <?= ($head['zone'] ?? '') === $z ? 'selected' : '' ?>><?= $z ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Years of Residency</div>
                                <input type="number" class="pf-input" name="years_of_residency" value="<?= esc($head['years_of_residency'] ?? '0') ?>" min="0">
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">House Ownership</div>
                                <select class="pf-input" name="house_ownership">
                                    <?php foreach (['Owned', 'Rented', 'Shared', 'Informal Settler'] as $ho): ?>
                                        <option <?= ($head['house_ownership'] ?? '') === $ho ? 'selected' : '' ?>><?= $ho ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="pf-check-row">
                            <span class="pf-check-label">Belongs to:</span>
                            <label class="pf-check"><input type="checkbox" name="is_4ps" value="1" <?= !empty($head['is_4ps']) ? 'checked' : '' ?>> <span>4Ps</span></label>
                            <label class="pf-check"><input type="checkbox" name="is_pwd" value="1" <?= !empty($head['is_pwd']) ? 'checked' : '' ?>> <span>PWD</span></label>
                            <label class="pf-check"><input type="checkbox" name="is_senior_citizen" value="1" <?= !empty($head['is_senior_citizen']) ? 'checked' : '' ?>> <span>Senior Citizen</span></label>
                            <label class="pf-check"><input type="checkbox" name="is_solo_parent" value="1" <?= !empty($head['is_solo_parent']) ? 'checked' : '' ?>> <span>Solo Parent</span></label>
                            <label class="pf-check"><input type="checkbox" name="is_indigenous" value="1" <?= !empty($head['is_indigenous']) ? 'checked' : '' ?>> <span>Indigenous</span></label>
                        </div>

                        <!-- Registered Voter + No. of Families -->
                        <div class="pf-field-row pf-cols-2" style="margin-top:12px;">
                            <div class="pf-field">
                                <div class="pf-field-label">Registered Voter?</div>
                                <div class="pf-radio-row" style="flex-direction:row;gap:20px;padding:8px 0;">
                                    <label class="pf-radio">
                                        <input type="radio" name="registered_voter" value="1" <?= !empty($head['registered_voter']) ? 'checked' : '' ?>>
                                        <span>Yes</span>
                                    </label>
                                    <label class="pf-radio">
                                        <input type="radio" name="registered_voter" value="0" <?= empty($head['registered_voter']) ? 'checked' : '' ?>>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">No. of Families in Household</div>
                                <input type="number" class="pf-input" name="num_families"
                                    value="<?= esc($head['num_families'] ?? 1) ?>" min="1" max="20"
                                    style="max-width:120px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pf-footer">
                    <div style="flex:1;"></div>
                    <button type="button" class="pf-btn pf-btn--outline" onclick="closeModal('editHeadModal')">Cancel</button>
                    <button type="submit" class="pf-btn pf-btn--primary"><i class="fas fa-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══ ADD MEMBER MODAL ══ -->
    <div class="db-modal-overlay" id="addMemberModal">
        <div class="db-modal pf-modal">
            <form action="/<?= $role ?>/census/members/add/<?= esc($householdId) ?>" method="post" id="addMemberForm">
                <?= csrf_field() ?>

                <div class="pf-modal-header">
                    <div class="pf-modal-title-wrap">
                        <div class="pf-modal-logo"><img src="/bacolod.png" alt="Seal"></div>
                        <div>
                            <div class="pf-modal-republic">Republic of the Philippines</div>
                            <div class="pf-modal-barangay">Barangay Bacolod, Bato, Camarines Sur</div>
                            <div class="pf-modal-formtitle">ADD HOUSEHOLD MEMBER — Household #<?= esc($householdId) ?></div>
                        </div>
                    </div>
                    <button type="button" class="pf-close-btn" onclick="closeModal('addMemberModal')"><i class="fas fa-times"></i></button>
                </div>

                <div class="pf-body">

                    <!-- Spouse -->
                    <div class="pf-section">
                        <div class="pf-section-bar"><i class="fas fa-ring"></i> SPOUSE</div>
                        <div class="pf-family-card">
                            <div class="pf-field-row pf-cols-4">
                                <div class="pf-field">
                                    <div class="pf-field-label">Last Name</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="spouse_last_name" placeholder="LAST NAME">
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">First Name</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="spouse_first_name" placeholder="FIRST NAME">
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Middle Name</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="spouse_middle_name" placeholder="MIDDLE NAME">
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Suffix</div>
                                    <select class="pf-input" name="spouse_suffix">
                                        <option value="">— NONE —</option>
                                        <option>Jr</option>
                                        <option>Sr</option>
                                        <option>II</option>
                                        <option>III</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pf-field-row pf-cols-4">
                                <div class="pf-field">
                                    <div class="pf-field-label">Date of Birth</div>
                                    <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="spouse_dob"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Gender</div>
                                    <select class="pf-input" name="spouse_gender">
                                        <option value="">— Select —</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Occupation</div>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="spouse_occupation" placeholder="E.G. HOUSEWIFE, TEACHER">
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Monthly Income (₱)</div>
                                    <input type="number" class="pf-input" name="spouse_income" placeholder="0.00" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="pf-field-row pf-cols-3">
                                <div class="pf-field">
                                    <div class="pf-field-label">Educational Attainment</div>
                                    <select class="pf-input" name="spouse_educational_attainment">
                                        <option value="">— Select —</option>
                                        <?php foreach ($eduOptions as $e): ?><option><?= $e ?></option><?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">PhilHealth Number</div>
                                    <input type="text" class="pf-input pf-philhealth" name="spouse_philhealth" placeholder="00000000000" maxlength="12" inputmode="numeric">
                                </div>
                                <div class="pf-field">
                                    <div class="pf-field-label">Registered Voter?</div>
                                    <div class="pf-radio-row" style="flex-direction:row;gap:20px;padding:8px 10px;">
                                        <label class="pf-radio"><input type="radio" name="spouse_registered_voter" value="1"> <span>Yes</span></label>
                                        <label class="pf-radio"><input type="radio" name="spouse_registered_voter" value="0" checked> <span>No</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Children -->
                    <div class="pf-section">
                        <div class="pf-section-bar" style="display:flex;align-items:center;justify-content:space-between;">
                            <span><i class="fas fa-child"></i> CHILD(REN)</span>
                            <button type="button" class="pf-add-row-btn" onclick="addChildRowModal()">
                                <i class="fas fa-plus"></i> Add Row
                            </button>
                        </div>
                        <div id="modalChildrenRows">
                            <div class="pf-member-card">
                                <div class="pf-member-card-inner">
                                    <div class="pf-member-fields">
                                        <div class="pf-field pf-field--inline">
                                            <div class="pf-field-label">Last Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="child_last_name[]" placeholder="LAST NAME">
                                        </div>
                                        <div class="pf-field pf-field--inline">
                                            <div class="pf-field-label">First Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="child_first_name[]" placeholder="FIRST NAME">
                                        </div>
                                        <div class="pf-field pf-field--inline">
                                            <div class="pf-field-label">Middle Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="child_middle_name[]" placeholder="MIDDLE NAME">
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--xs">
                                            <div class="pf-field-label">Suffix</div>
                                            <select class="pf-input" name="child_suffix[]">
                                                <option value="">—NONE—</option>
                                                <option>Jr</option>
                                                <option>Sr</option>
                                                <option>II</option>
                                                <option>III</option>
                                            </select>
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--sm">
                                            <div class="pf-field-label">Date of Birth</div>
                                            <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="child_dob[]"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--xs">
                                            <div class="pf-field-label">Gender</div>
                                            <select class="pf-input" name="child_gender[]">
                                                <option value="">—Select—</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                        <div class="pf-field pf-field--inline">
                                            <div class="pf-field-label">Occupation</div>
                                            <div class="pf-occ-wrap">
                                                <div class="pf-occ-pills">
                                                    <button type="button" class="pf-occ-pill" data-val="STUDENT" onclick="setOcc(this,'STUDENT')">Student</button>
                                                    <button type="button" class="pf-occ-pill" data-val="OUT OF SCHOOL" onclick="setOcc(this,'OUT OF SCHOOL')">Out of School</button>
                                                </div>
                                                <input type="text" class="pf-input pf-upper pf-alpha" name="child_occupation[]" placeholder="OR TYPE EXACT OCCUPATION">
                                                <div class="pf-grade-wrap">
                                                    <div class="pf-grade-label">Current Grade / Year</div>
                                                    <select class="pf-input" name="child_grade[]">
                                                        <option value="">— Select Grade / Year —</option>
                                                        <optgroup label="Elementary">
                                                            <option>Grade 1</option>
                                                            <option>Grade 2</option>
                                                            <option>Grade 3</option>
                                                            <option>Grade 4</option>
                                                            <option>Grade 5</option>
                                                            <option>Grade 6</option>
                                                        </optgroup>
                                                        <optgroup label="Junior High School">
                                                            <option>Grade 7</option>
                                                            <option>Grade 8</option>
                                                            <option>Grade 9</option>
                                                            <option>Grade 10</option>
                                                        </optgroup>
                                                        <optgroup label="Senior High School">
                                                            <option>Grade 11</option>
                                                            <option>Grade 12</option>
                                                        </optgroup>
                                                        <optgroup label="College / University">
                                                            <option>1st Year College</option>
                                                            <option>2nd Year College</option>
                                                            <option>3rd Year College</option>
                                                            <option>4th Year College</option>
                                                            <option>5th Year College</option>
                                                        </optgroup>
                                                        <optgroup label="Vocational / Technical">
                                                            <option>1st Year Tech-Voc</option>
                                                            <option>2nd Year Tech-Voc</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--sm">
                                            <div class="pf-field-label">Monthly Income (₱)</div><input type="number" class="pf-input" name="child_income[]" placeholder="0.00" min="0" step="0.01">
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--sm">
                                            <div class="pf-field-label">PhilHealth No.</div><input type="text" class="pf-input pf-philhealth" name="child_philhealth[]" placeholder="00000000000" maxlength="12" inputmode="numeric">
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--sm">
                                            <div class="pf-field-label">Voter?</div>
                                            <div style="display:flex;gap:12px;padding:7px 10px;">
                                                <label class="pf-radio"><input type="radio" name="child_voter[0]" value="1"> <span>Yes</span></label>
                                                <label class="pf-radio"><input type="radio" name="child_voter[0]" value="0" checked> <span>No</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="pf-member-del" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Other Household Members -->
                    <div class="pf-section">
                        <div class="pf-section-bar" style="display:flex;align-items:center;justify-content:space-between;">
                            <span><i class="fas fa-users"></i> OTHER HOUSEHOLD MEMBERS <em style="font-weight:400;">(other than Spouse/Children)</em></span>
                            <button type="button" class="pf-add-row-btn" onclick="addOtherRowModal()">
                                <i class="fas fa-plus"></i> Add Row
                            </button>
                        </div>
                        <div id="modalOtherRows">
                            <div class="pf-member-card">
                                <div class="pf-member-card-inner">
                                    <div class="pf-member-fields">
                                        <div class="pf-field pf-field--inline">
                                            <div class="pf-field-label">Last Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="other_last_name[]" placeholder="LAST NAME">
                                        </div>
                                        <div class="pf-field pf-field--inline">
                                            <div class="pf-field-label">First Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="other_first_name[]" placeholder="FIRST NAME">
                                        </div>
                                        <div class="pf-field pf-field--inline">
                                            <div class="pf-field-label">Middle Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="other_middle_name[]" placeholder="MIDDLE NAME">
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--xs">
                                            <div class="pf-field-label">Suffix</div>
                                            <select class="pf-input" name="other_suffix[]">
                                                <option value="">—NONE—</option>
                                                <option>Jr</option>
                                                <option>Sr</option>
                                                <option>II</option>
                                                <option>III</option>
                                            </select>
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--sm">
                                            <div class="pf-field-label">Date of Birth</div>
                                            <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="other_dob[]"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--xs">
                                            <div class="pf-field-label">Gender</div>
                                            <select class="pf-input" name="other_gender[]">
                                                <option value="">—Select—</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--sm">
                                            <div class="pf-field-label">Relationship</div>
                                            <select class="pf-input" name="other_relationship[]">
                                                <option value="">— Select —</option>
                                                <option>Father</option>
                                                <option>Mother</option>
                                                <option>Sibling</option>
                                                <option>Grandparent</option>
                                                <option>Grandchild</option>
                                                <option>Aunt/Uncle</option>
                                                <option>Cousin</option>
                                                <option>Other Relative</option>
                                                <option>Non-relative</option>
                                            </select>
                                        </div>
                                        <div class="pf-field pf-field--inline pf-field--sm">
                                            <div class="pf-field-label">Voter?</div>
                                            <div style="display:flex;gap:12px;padding:7px 10px;">
                                                <label class="pf-radio"><input type="radio" name="other_voter[0]" value="1"> <span>Yes</span></label>
                                                <label class="pf-radio"><input type="radio" name="other_voter[0]" value="0" checked> <span>No</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="pf-member-del" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certification -->
                    <div class="pf-cert-box">
                        <p>I hereby certify that the information provided above is true and correct to the best of my knowledge.</p>
                        <div class="pf-cert-date-only">
                            <div class="pf-cert-recorded-label">Date of Transaction</div>
                            <div class="pf-date-wrap" style="border-bottom:1px solid #333;display:inline-flex;min-width:180px;">
                                <input type="date" class="pf-input pf-date-input pf-cert-date-input" name="recorded_date" style="background:transparent;border:none;padding:4px 32px 4px 0;font-size:13px;" value="<?= date('Y-m-d') ?>">
                                <i class="fas fa-calendar-alt pf-date-icon" style="color:#1d2448;"></i>
                            </div>
                        </div>
                    </div>

                </div><!-- /.pf-body -->

                <div class="pf-footer">
                    <div style="flex:1;"></div>
                    <button type="button" class="pf-btn pf-btn--outline" onclick="closeModal('addMemberModal')">Cancel</button>
                    <button type="submit" class="pf-btn pf-btn--primary"><i class="fas fa-save"></i> Save Members</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══ EDIT MEMBER MODAL ══ -->
    <div class="db-modal-overlay" id="editMemberModal">
        <div class="db-modal pf-modal">
            <form action="/<?= $role ?>/census/member/update/0" method="post" id="editMemberForm">
                <?= csrf_field() ?>
                <input type="hidden" name="household_no" value="<?= esc($householdId) ?>">

                <div class="pf-modal-header">
                    <div class="pf-modal-title-wrap">
                        <div class="pf-modal-logo"><img src="/bacolod.png" alt="Seal"></div>
                        <div>
                            <div class="pf-modal-republic">Republic of the Philippines</div>
                            <div class="pf-modal-barangay">Barangay Bacolod, Bato, Camarines Sur</div>
                            <div class="pf-modal-formtitle">EDIT HOUSEHOLD MEMBER</div>
                        </div>
                    </div>
                    <button type="button" class="pf-close-btn" onclick="closeModal('editMemberModal')"><i class="fas fa-times"></i></button>
                </div>

                <div class="pf-body">
                    <div class="pf-section">
                        <div class="pf-section-bar"><i class="fas fa-user-edit"></i> MEMBER INFORMATION</div>
                        <div class="pf-field-row pf-cols-4">
                            <div class="pf-field">
                                <div class="pf-field-label">Last Name</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="last_name" id="em_last_name" required>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">First Name</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="first_name" id="em_first_name" required>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Middle Name</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="middle_name" id="em_middle_name">
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Suffix</div>
                                <select class="pf-input" name="suffix" id="em_suffix">
                                    <option value="">— NONE —</option>
                                    <option>Jr</option>
                                    <option>Sr</option>
                                    <option>II</option>
                                    <option>III</option>
                                </select>
                            </div>
                        </div>
                        <div class="pf-field-row pf-cols-3">
                            <div class="pf-field">
                                <div class="pf-field-label">Relationship to Head</div>
                                <select class="pf-input" name="relationship" id="em_relationship" required>
                                    <option value="">— Select —</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="child">Child</option>
                                    <option value="father">Father</option>
                                    <option value="mother">Mother</option>
                                    <option value="sibling">Sibling</option>
                                    <option value="grandparent">Grandparent</option>
                                    <option value="grandchild">Grandchild</option>
                                    <option value="aunt_uncle">Aunt/Uncle</option>
                                    <option value="cousin">Cousin</option>
                                    <option value="other_relative">Other Relative</option>
                                    <option value="non_relative">Non-relative</option>
                                </select>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Date of Birth</div>
                                <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="date_of_birth" id="em_dob"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Occupation</div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="occupation" id="em_occupation">
                            </div>
                        </div>
                        <div class="pf-field-row pf-cols-3">
                            <div class="pf-field">
                                <div class="pf-field-label">Monthly Income (₱)</div>
                                <input type="number" class="pf-input" name="monthly_income" id="em_income" value="0" min="0" step="0.01">
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">Educational Attainment</div>
                                <select class="pf-input" name="educational_attainment" id="em_education">
                                    <option value="">— Select —</option>
                                    <?php foreach ($eduOptions as $e): ?>
                                        <option><?= $e ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="pf-field">
                                <div class="pf-field-label">PhilHealth Number</div>
                                <input type="text" class="pf-input pf-philhealth" name="philhealth_no" id="em_philhealth" maxlength="12" inputmode="numeric">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pf-footer">
                    <div style="flex:1;"></div>
                    <button type="button" class="pf-btn pf-btn--outline" onclick="closeModal('editMemberModal')">Cancel</button>
                    <button type="submit" class="pf-btn pf-btn--primary"><i class="fas fa-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* ── Paper Form Modal (shared with census) ── */
        .pf-modal {
            max-width: 860px;
            width: 96%;
            border-radius: 4px;
            padding: 0;
            display: flex;
            flex-direction: column;
            max-height: 92vh;
            font-family: 'Arial', sans-serif;
        }

        .pf-modal-header {
            background: #1d2448;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .pf-modal-title-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .pf-modal-logo img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .pf-modal-republic {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .pf-modal-barangay {
            font-size: 12px;
            color: #fff;
            font-weight: 600;
        }

        .pf-modal-formtitle {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .pf-close-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
        }

        .pf-close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .pf-body {
            overflow-y: auto;
            flex: 1;
            background: #f9f9f7;
            padding: 0;
        }

        .pf-section {
            background: #fff;
            border: 1px solid #d0d5e0;
            margin: 14px 16px;
            border-radius: 2px;
        }

        .pf-section-bar {
            background: #1d2448;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            padding: 7px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pf-field-row {
            display: grid;
            gap: 0;
            border-bottom: 1px solid #e8eaf0;
        }

        .pf-field-row:last-child {
            border-bottom: none;
        }

        .pf-cols-1 {
            grid-template-columns: 1fr;
        }

        .pf-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .pf-cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .pf-cols-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .pf-field {
            border-right: 1px solid #e8eaf0;
            padding: 0;
        }

        .pf-field:last-child {
            border-right: none;
        }

        .pf-field-label {
            font-size: 9.5px;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 5px 10px 2px;
            background: #fafbfd;
            border-bottom: 1px solid #eee;
        }

        .pf-input {
            width: 100%;
            border: none;
            outline: none;
            padding: 7px 10px;
            font-size: 13px;
            font-family: Arial, sans-serif;
            color: #1a1d2e;
            background: #fff;
            box-sizing: border-box;
            transition: background .15s;
        }

        .pf-input:focus {
            background: #f0f4ff;
        }

        select.pf-input {
            appearance: auto;
            cursor: pointer;
        }

        .pf-date-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .pf-date-wrap .pf-date-input {
            padding-right: 32px;
            cursor: pointer;
        }

        .pf-date-icon {
            position: absolute;
            right: 10px;
            color: #9aa0b4;
            font-size: 13px;
            pointer-events: none;
        }

        .pf-date-input::-webkit-calendar-picker-indicator {
            opacity: 0;
            position: absolute;
            right: 0;
            width: 32px;
            height: 100%;
            cursor: pointer;
        }

        .pf-check-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            padding: 10px 14px;
            font-size: 12px;
            color: #4a5068;
            border-top: 1px solid #eee;
        }

        .pf-check-label {
            font-weight: 700;
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .pf-check {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            font-size: 12px;
        }

        .pf-check input[type="checkbox"] {
            width: 13px;
            height: 13px;
            cursor: pointer;
        }

        .pf-footer {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: #f0f2f8;
            border-top: 2px solid #1d2448;
            flex-shrink: 0;
        }

        .pf-btn {
            padding: 8px 20px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: all .2s;
            font-family: 'Poppins', sans-serif;
        }

        .pf-btn--primary {
            background: #1d2448;
            color: #fff;
            border: 2px solid #1d2448;
        }

        .pf-btn--primary:hover {
            background: #2e3a6e;
            border-color: #2e3a6e;
        }

        .pf-btn--outline {
            background: #fff;
            color: #1d2448;
            border: 2px solid #1d2448;
        }

        .pf-btn--outline:hover {
            background: #f0f2f8;
        }

        .pf-upper {
            text-transform: uppercase;
        }

        .pf-upper::placeholder {
            text-transform: uppercase;
        }

        /* Household head card */
        .hh-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #9aa0b4;
            margin-bottom: 20px;
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

        .hh-head-card {
            background: #fff;
            border: 1px solid #e8ecf4;
            border-radius: 14px;
            padding: 24px 28px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .hh-head-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #1d2448;
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .hh-head-info {
            flex: 1;
            min-width: 200px;
        }

        .hh-head-info h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1a1d2e;
            margin: 0 0 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .hh-head-badge {
            font-size: 11px;
            font-weight: 600;
            background: #eef0fb;
            color: #1d2448;
            padding: 3px 10px;
            border-radius: 100px;
        }

        .hh-head-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            font-size: 13px;
            color: #6b7280;
        }

        .hh-head-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .hh-head-meta i {
            color: #9aa0b4;
            font-size: 12px;
        }

        .hh-head-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .hh-members-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .hh-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #eef0fb;
            color: #1d2448;
            font-size: 12px;
            font-weight: 700;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            margin-left: 6px;
        }

        .hh-rel-badge {
            font-size: 11px;
            font-weight: 600;
            background: #f5f6fa;
            color: #4a5068;
            padding: 3px 10px;
            border-radius: 100px;
            border: 1px solid #e2e5ef;
        }

        .hh-philhealth {
            font-family: monospace;
            font-size: 12px;
            background: #f5f6fa;
            padding: 2px 6px;
            border-radius: 4px;
            color: #4a5068;
        }
    </style>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        function openEditMember(m) {
            // Set form action with member id
            document.getElementById('editMemberForm').action =
                '/<?= $role ?>/census/member/update/' + m.id;
            // Fill fields
            document.getElementById('em_last_name').value = m.last_name || '';
            document.getElementById('em_first_name').value = m.first_name || '';
            document.getElementById('em_middle_name').value = m.middle_name || '';
            document.getElementById('em_suffix').value = m.suffix || '';
            document.getElementById('em_relationship').value = m.relationship || '';
            document.getElementById('em_dob').value = m.date_of_birth || '';
            document.getElementById('em_occupation').value = m.occupation || '';
            document.getElementById('em_income').value = m.monthly_income || 0;
            document.getElementById('em_education').value = m.educational_attainment || '';
            document.getElementById('em_philhealth').value = m.philhealth_no || '';
            openModal('editMemberModal');
        }

        // Live uppercase + alpha-only + philhealth-only
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('pf-upper')) {
                const pos = e.target.selectionStart;
                e.target.value = e.target.value.toUpperCase();
                e.target.setSelectionRange(pos, pos);
            }
            if (e.target.classList.contains('pf-alpha')) {
                const pos = e.target.selectionStart;
                e.target.value = e.target.value.replace(/[^A-Za-zÀ-ÖØ-öø-ÿ\s\-'.]/g, '');
                e.target.setSelectionRange(pos, pos);
            }
            if (e.target.classList.contains('pf-philhealth')) {
                e.target.value = e.target.value.replace(/\D/g, '');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.target.classList.contains('pf-alpha')) {
                if (e.ctrlKey || e.metaKey || e.altKey) return;
                const allowed = [8, 9, 13, 27, 32, 37, 38, 39, 40, 35, 36, 45, 46];
                if (allowed.includes(e.keyCode)) return;
                if (e.key >= '0' && e.key <= '9') e.preventDefault();
            }
            if (e.target.classList.contains('pf-philhealth')) {
                const allowed = [8, 9, 13, 27, 46, 37, 38, 39, 40, 35, 36];
                if ((e.ctrlKey || e.metaKey) && [65, 67, 86, 88].includes(e.keyCode)) return;
                if (allowed.includes(e.keyCode)) return;
                if (e.key < '0' || e.key > '9') e.preventDefault();
            }
        });

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );

        // ── Add Member Modal row helpers ───────────────────────────────────────
        let _mChildIdx = 1;
        let _mOtherIdx = 1;

        function modalChildRowHTML() {
            const i = _mChildIdx++;
            return `<div class="pf-member-card">
                <div class="pf-member-card-inner">
                    <div class="pf-member-fields">
                        <div class="pf-field pf-field--inline"><div class="pf-field-label">Last Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="child_last_name[]" placeholder="LAST NAME"></div>
                        <div class="pf-field pf-field--inline"><div class="pf-field-label">First Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="child_first_name[]" placeholder="FIRST NAME"></div>
                        <div class="pf-field pf-field--inline"><div class="pf-field-label">Middle Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="child_middle_name[]" placeholder="MIDDLE NAME"></div>
                        <div class="pf-field pf-field--inline pf-field--xs">
                            <div class="pf-field-label">Suffix</div>
                            <select class="pf-input" name="child_suffix[]"><option value="">—NONE—</option><option>Jr</option><option>Sr</option><option>II</option><option>III</option></select>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Date of Birth</div>
                            <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="child_dob[]"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--xs">
                            <div class="pf-field-label">Gender</div>
                            <select class="pf-input" name="child_gender[]"><option value="">—Select—</option><option>Male</option><option>Female</option></select>
                        </div>
                        <div class="pf-field pf-field--inline">
                            <div class="pf-field-label">Occupation</div>
                            <div class="pf-occ-wrap">
                                <div class="pf-occ-pills">
                                    <button type="button" class="pf-occ-pill" data-val="STUDENT" onclick="setOcc(this,'STUDENT')">Student</button>
                                    <button type="button" class="pf-occ-pill" data-val="OUT OF SCHOOL" onclick="setOcc(this,'OUT OF SCHOOL')">Out of School</button>
                                </div>
                                <input type="text" class="pf-input pf-upper pf-alpha" name="child_occupation[]" placeholder="OR TYPE EXACT OCCUPATION">
                                <div class="pf-grade-wrap">
                                    <div class="pf-grade-label">Current Grade / Year</div>
                                    <select class="pf-input" name="child_grade[]">
                                        <option value="">— Select Grade / Year —</option>
                                        <optgroup label="Elementary"><option>Grade 1</option><option>Grade 2</option><option>Grade 3</option><option>Grade 4</option><option>Grade 5</option><option>Grade 6</option></optgroup>
                                        <optgroup label="Junior High School"><option>Grade 7</option><option>Grade 8</option><option>Grade 9</option><option>Grade 10</option></optgroup>
                                        <optgroup label="Senior High School"><option>Grade 11</option><option>Grade 12</option></optgroup>
                                        <optgroup label="College / University"><option>1st Year College</option><option>2nd Year College</option><option>3rd Year College</option><option>4th Year College</option><option>5th Year College</option></optgroup>
                                        <optgroup label="Vocational / Technical"><option>1st Year Tech-Voc</option><option>2nd Year Tech-Voc</option></optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm"><div class="pf-field-label">Monthly Income (₱)</div><input type="number" class="pf-input" name="child_income[]" placeholder="0.00" min="0" step="0.01"></div>
                        <div class="pf-field pf-field--inline pf-field--sm"><div class="pf-field-label">PhilHealth No.</div><input type="text" class="pf-input pf-philhealth" name="child_philhealth[]" placeholder="00000000000" maxlength="12" inputmode="numeric"></div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Voter?</div>
                            <div style="display:flex;gap:12px;padding:7px 10px;">
                                <label class="pf-radio"><input type="radio" name="child_voter[${i}]" value="1"> <span>Yes</span></label>
                                <label class="pf-radio"><input type="radio" name="child_voter[${i}]" value="0" checked> <span>No</span></label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="pf-member-del" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                </div>
            </div>`;
        }

        function modalOtherRowHTML() {
            const i = _mOtherIdx++;
            return `<div class="pf-member-card">
                <div class="pf-member-card-inner">
                    <div class="pf-member-fields">
                        <div class="pf-field pf-field--inline"><div class="pf-field-label">Last Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="other_last_name[]" placeholder="LAST NAME"></div>
                        <div class="pf-field pf-field--inline"><div class="pf-field-label">First Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="other_first_name[]" placeholder="FIRST NAME"></div>
                        <div class="pf-field pf-field--inline"><div class="pf-field-label">Middle Name</div><input type="text" class="pf-input pf-upper pf-alpha" name="other_middle_name[]" placeholder="MIDDLE NAME"></div>
                        <div class="pf-field pf-field--inline pf-field--xs">
                            <div class="pf-field-label">Suffix</div>
                            <select class="pf-input" name="other_suffix[]"><option value="">—NONE—</option><option>Jr</option><option>Sr</option><option>II</option><option>III</option></select>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Date of Birth</div>
                            <div class="pf-date-wrap"><input type="date" class="pf-input pf-date-input" name="other_dob[]"><i class="fas fa-calendar-alt pf-date-icon"></i></div>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--xs">
                            <div class="pf-field-label">Gender</div>
                            <select class="pf-input" name="other_gender[]"><option value="">—Select—</option><option>Male</option><option>Female</option></select>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Relationship</div>
                            <select class="pf-input" name="other_relationship[]">
                                <option value="">— Select —</option>
                                <option>Father</option><option>Mother</option><option>Sibling</option><option>Grandparent</option>
                                <option>Grandchild</option><option>Aunt/Uncle</option><option>Cousin</option>
                                <option>Other Relative</option><option>Non-relative</option>
                            </select>
                        </div>
                        <div class="pf-field pf-field--inline pf-field--sm">
                            <div class="pf-field-label">Voter?</div>
                            <div style="display:flex;gap:12px;padding:7px 10px;">
                                <label class="pf-radio"><input type="radio" name="other_voter[${i}]" value="1"> <span>Yes</span></label>
                                <label class="pf-radio"><input type="radio" name="other_voter[${i}]" value="0" checked> <span>No</span></label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="pf-member-del" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                </div>
            </div>`;
        }

        function addChildRowModal() {
            document.getElementById('modalChildrenRows').insertAdjacentHTML('beforeend', modalChildRowHTML());
        }

        function addOtherRowModal() {
            document.getElementById('modalOtherRows').insertAdjacentHTML('beforeend', modalOtherRowHTML());
        }

        function removeRow(btn) {
            btn.closest('.pf-member-card').remove();
        }

        // Occupation quick-pick: toggle grade field visibility
        function setOcc(btn, value) {
            const wrap = btn.closest('.pf-occ-wrap');
            const input = wrap.querySelector('input[name="child_occupation[]"]');
            const pills = wrap.querySelectorAll('.pf-occ-pill');
            const alreadyActive = btn.classList.contains('active');
            pills.forEach(p => p.classList.remove('active'));
            if (alreadyActive) {
                input.value = '';
            } else {
                btn.classList.add('active');
                input.value = value;
            }
            input.dispatchEvent(new Event('input'));
            toggleGradeField(wrap, input.value);
        }

        function toggleGradeField(wrap, occValue) {
            const gradeWrap = wrap.querySelector('.pf-grade-wrap');
            if (!gradeWrap) return;
            gradeWrap.classList.toggle('visible', occValue.trim().toUpperCase() === 'STUDENT');
        }

        // Sync pill active state + grade field when typing manually
        document.addEventListener('input', function(e) {
            if (e.target.name === 'child_occupation[]') {
                const wrap = e.target.closest('.pf-occ-wrap');
                if (!wrap) return;
                const val = e.target.value.trim().toUpperCase();
                wrap.querySelectorAll('.pf-occ-pill').forEach(p => {
                    p.classList.toggle('active', p.dataset.val === val);
                });
                toggleGradeField(wrap, val);
            }
        });
    </script>
</body>

</html>