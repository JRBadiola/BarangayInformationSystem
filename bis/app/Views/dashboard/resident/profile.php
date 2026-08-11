<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .pf-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 20px;
            align-items: start;
        }

        /* Left column — avatar + account */
        .pf-left {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pf-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29, 36, 72, 0.06);
            overflow: hidden;
        }

        .pf-card-header {
            padding: 16px 20px 12px;
            border-bottom: 1px solid #f0f2f8;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pf-card-header-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #eef0fb;
            color: #1d2448;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .pf-card-header h4 {
            font-size: 13.5px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0;
        }

        .pf-card-header p {
            font-size: 11.5px;
            color: #9aa0b4;
            margin: 2px 0 0;
        }

        .pf-card-body {
            padding: 20px;
        }

        /* Avatar card */
        .pf-avatar-card {
            text-align: center;
            padding: 28px 20px 20px;
        }

        .pf-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            color: #fff;
            font-size: 32px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }

        .pf-avatar-name {
            font-size: 16px;
            font-weight: 700;
            color: #1a1d2e;
            margin: 0 0 4px;
        }

        .pf-avatar-role {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            color: #fff;
            background: #1d2448;
            padding: 3px 12px;
            border-radius: 100px;
            margin-bottom: 6px;
        }

        .pf-avatar-hh {
            font-size: 12px;
            color: #9aa0b4;
            margin-top: 4px;
        }

        .pf-avatar-hh strong {
            color: #1d2448;
        }

        /* Status badge */
        .pf-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 100px;
            margin-top: 8px;
        }

        .pf-status-badge.active {
            background: #f0faf6;
            color: #1a7a55;
            border: 1px solid #c3e8d8;
        }

        .pf-status-badge.pending {
            background: #fff8f0;
            color: #b7600a;
            border: 1px solid #fde8c8;
        }

        /* Info rows */
        .pf-info-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .pf-info-item {
            display: flex;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid #f5f6fa;
            gap: 12px;
        }

        .pf-info-item:last-child {
            border-bottom: none;
        }

        .pf-info-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #f0f2f8;
            color: #1d2448;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .pf-info-label {
            font-size: 10.5px;
            font-weight: 700;
            color: #9aa0b4;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .pf-info-value {
            font-size: 13.5px;
            color: #1a1d2e;
            font-weight: 500;
            margin-top: 1px;
        }

        .pf-info-value.empty {
            color: #b0b6cc;
            font-style: italic;
            font-weight: 400;
        }

        /* Census notice */
        .pf-census-notice {
            background: #f0f4ff;
            border: 1px solid #d0d8f5;
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 12.5px;
            color: #4a5068;
            line-height: 1.6;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .pf-census-notice i {
            color: #5b6fd6;
            margin-top: 1px;
            flex-shrink: 0;
        }

        /* No census warning */
        .pf-no-census {
            background: #fff8f0;
            border: 1px solid #fde8c8;
            border-radius: 10px;
            padding: 16px;
            font-size: 13px;
            color: #b7600a;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .pf-no-census i {
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Members table */
        .pf-members-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .pf-member-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            background: #f9fafb;
            border-radius: 9px;
            border: 1px solid #f0f2f8;
        }

        .pf-member-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #1d2448;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pf-member-name {
            font-size: 13px;
            font-weight: 600;
            color: #1a1d2e;
        }

        .pf-member-rel {
            font-size: 11px;
            color: #9aa0b4;
            margin-top: 1px;
        }

        .pf-member-badge {
            margin-left: auto;
            font-size: 10.5px;
            font-weight: 600;
            background: #eef0fb;
            color: #1d2448;
            padding: 2px 10px;
            border-radius: 100px;
        }

        .pf-member-badge.you {
            background: #1d2448;
            color: #fff;
        }

        /* Password section */
        .pf-pw-input-wrap {
            position: relative;
        }

        .pf-pw-input-wrap input {
            padding-right: 42px;
        }

        .pf-pw-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #b0b6cc;
            cursor: pointer;
            font-size: 13px;
            padding: 4px;
            transition: color .2s;
        }

        .pf-pw-eye:hover {
            color: #1d2448;
        }

        .pf-form-group {
            margin-bottom: 14px;
        }

        .pf-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #4a5068;
            margin-bottom: 5px;
        }

        .pf-form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e2e5ef;
            border-radius: 8px;
            font-size: 13.5px;
            font-family: 'Poppins', sans-serif;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box;
        }

        .pf-form-group input:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, 0.08);
        }

        .pf-btn {
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

        .pf-btn--primary {
            background: #1d2448;
            color: #fff;
        }

        .pf-btn--primary:hover {
            background: #2e3a6e;
        }

        .pf-btn--full {
            width: 100%;
            justify-content: center;
        }

        @media (max-width: 900px) {
            .pf-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'resident';
    $active    = 'profile';
    $pageTitle = 'My Profile';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $user         = $user         ?? [];
    $household    = $household    ?? null;
    $members      = $members      ?? [];
    $memberRecord = $memberRecord ?? null;

    // Use member record data if available, else fall back to user data
    $rec = $memberRecord ?? [];

    // Name
    $firstName    = $rec['first_name']  ?? ($user['first_name']  ?? '');
    $lastName     = $rec['last_name']   ?? ($user['last_name']   ?? '');
    $middleName   = $rec['middle_name'] ?? ($user['middle_name'] ?? '');
    $suffix       = $rec['suffix']      ?? '';
    $fullName     = trim($firstName . ' ' . ($middleName ? $middleName . ' ' : '') . $lastName) ?: '—';
    $initial      = strtoupper($fullName[0] ?? 'R');

    // Census personal fields
    $dob        = ! empty($rec['date_of_birth'])
        ? date('F d, Y', strtotime($rec['date_of_birth'])) : '—';
    $age        = ! empty($rec['date_of_birth'])
        ? (int) date_diff(date_create($rec['date_of_birth']), date_create('today'))->y : '—';
    $gender       = $rec['gender']      ?? '—';
    $civilStatus  = $rec['civil_status'] ?? '—';          // only on head row
    $occupation   = ! empty($rec['occupation'])   ? $rec['occupation']   : '—';
    $rawIncome    = $rec['monthly_income'] ?? null;
    $income       = ($rawIncome !== null && (float)$rawIncome > 0)
        ? '₱' . number_format((float)$rawIncome, 2) : '—';
    $education    = ! empty($rec['educational_attainment']) ? $rec['educational_attainment'] : '—';
    $philhealth   = ! empty($rec['philhealth_no'])           ? $rec['philhealth_no']          : '—';
    $relationship = ucfirst($rec['relationship'] ?? 'Household Head');

    // Contact — prefer user account value, fall back to household head record
    $contactNo    = ! empty($user['contact_number'])    ? $user['contact_number']
        : (! empty($household['contact_number']) ? $household['contact_number'] : '—');

    // Household head info
    $headName   = $household ? trim(($household['first_name'] ?? '') . ' ' . ($household['last_name'] ?? '')) : '—';
    $zone       = $household['zone'] ?? '—';
    $address    = $household['address'] ?? '—';
    $hhNo       = $user['household_no'] ?? '—';
    $memberCount = count($members) + 1; // +1 for head
    ?>

    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="db-alert db-alert--success" style="margin-bottom:16px;">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="pf-grid">

                <!-- ── LEFT COLUMN ── -->
                <div class="pf-left">

                    <!-- Avatar card -->
                    <div class="pf-card">
                        <div class="pf-avatar-card">
                            <div class="pf-avatar"><?= $initial ?></div>
                            <div class="pf-avatar-name"><?= esc($fullName) ?><?= $suffix ? ', ' . esc($suffix) : '' ?></div>
                            <div class="pf-avatar-role"><i class="fas fa-users"></i> Resident</div>
                            <?php if ($hhNo !== '—'): ?>
                                <div class="pf-avatar-hh">Household No. <strong><?= esc($hhNo) ?></strong></div>
                            <?php endif; ?>
                            <?php
                            $status = $user['status'] ?? 'pending';
                            $statusLabel = $status === 'active' ? 'Active Account' : 'Pending Approval';
                            $statusClass = $status === 'active' ? 'active' : 'pending';
                            ?>
                            <div>
                                <span class="pf-status-badge <?= $statusClass ?>">
                                    <i class="fas fa-<?= $status === 'active' ? 'check-circle' : 'clock' ?>"></i>
                                    <?= $statusLabel ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Account info -->
                    <div class="pf-card">
                        <div class="pf-card-header">
                            <div class="pf-card-header-icon"><i class="fas fa-id-card"></i></div>
                            <div>
                                <h4>Account Details</h4>
                                <p>Your login credentials</p>
                            </div>
                        </div>
                        <div class="pf-card-body">
                            <div class="pf-info-list">
                                <div class="pf-info-item">
                                    <div class="pf-info-icon"><i class="fas fa-at"></i></div>
                                    <div>
                                        <div class="pf-info-label">Username</div>
                                        <div class="pf-info-value"><?= esc($user['username'] ?? '—') ?></div>
                                    </div>
                                </div>
                                <div class="pf-info-item">
                                    <div class="pf-info-icon"><i class="fas fa-envelope"></i></div>
                                    <div>
                                        <div class="pf-info-label">Email</div>
                                        <div class="pf-info-value"><?= esc($user['email'] ?? '—') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="pf-card">
                        <div class="pf-card-header">
                            <div class="pf-card-header-icon" style="background:#fff0f1;color:#c0392b;">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div>
                                <h4>Change Password</h4>
                                <p>OTP sent to your email</p>
                            </div>
                        </div>
                        <div class="pf-card-body">
                            <form action="/resident/settings/request-otp" method="post">
                                <?= csrf_field() ?>
                                <div class="pf-form-group">
                                    <label>Current Password</label>
                                    <div class="pf-pw-input-wrap">
                                        <input type="password" name="current_password" placeholder="Enter current password" required>
                                        <button type="button" class="pf-pw-eye" onclick="togglePw('cur','eyeCur')">
                                            <i class="fas fa-eye" id="eyeCur"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="pf-form-group">
                                    <label>New Password</label>
                                    <div class="pf-pw-input-wrap">
                                        <input type="password" name="new_password" id="cur" placeholder="Minimum 8 characters" minlength="8" required>
                                        <button type="button" class="pf-pw-eye" onclick="togglePw('newPw','eyeNew')">
                                            <i class="fas fa-eye" id="eyeNew"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="pf-form-group">
                                    <label>Confirm New Password</label>
                                    <div class="pf-pw-input-wrap">
                                        <input type="password" name="confirm_password" id="newPw" placeholder="Re-enter new password" required>
                                        <button type="button" class="pf-pw-eye" onclick="togglePw('confPw','eyeConf')">
                                            <i class="fas fa-eye" id="eyeConf"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="pf-btn pf-btn--primary pf-btn--full">
                                    <i class="fas fa-paper-plane"></i> Send Verification Code
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

                <!-- ── RIGHT COLUMN ── -->
                <div style="display:flex;flex-direction:column;gap:20px;">

                    <?php if (! $household): ?>
                        <!-- No census record linked -->
                        <div class="pf-card">
                            <div class="pf-card-body">
                                <div class="pf-no-census">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <div>
                                        <strong>No census record linked to your account.</strong><br>
                                        Your account is not yet linked to a household in the census. Please contact the barangay office to have your record verified and linked.
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>

                        <!-- Personal Info from Census -->
                        <div class="pf-card">
                            <div class="pf-card-header">
                                <div class="pf-card-header-icon"><i class="fas fa-user-circle"></i></div>
                                <div>
                                    <h4>Personal Information</h4>
                                    <p>From the barangay census records — read only</p>
                                </div>
                            </div>
                            <div class="pf-card-body">
                                <div class="pf-census-notice" style="margin-bottom:16px;">
                                    <i class="fas fa-info-circle"></i>
                                    <span>This information is pulled directly from the barangay census. To update any details, please visit the barangay office.</span>
                                </div>
                                <div class="pf-info-list">
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-user"></i></div>
                                        <div>
                                            <div class="pf-info-label">Full Name</div>
                                            <div class="pf-info-value"><?= esc($fullName) ?><?= $suffix ? ', ' . esc($suffix) : '' ?></div>
                                        </div>
                                    </div>
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-birthday-cake"></i></div>
                                        <div>
                                            <div class="pf-info-label">Date of Birth</div>
                                            <div class="pf-info-value <?= $dob === '—' ? 'empty' : '' ?>"><?= $dob ?><?= $age !== '—' ? ' (' . $age . ' yrs old)' : '' ?></div>
                                        </div>
                                    </div>
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-venus-mars"></i></div>
                                        <div>
                                            <div class="pf-info-label">Gender</div>
                                            <div class="pf-info-value <?= $gender === '—' ? 'empty' : '' ?>"><?= esc($gender) ?></div>
                                        </div>
                                    </div>
                                    <?php if ($civilStatus !== '—'): ?>
                                        <div class="pf-info-item">
                                            <div class="pf-info-icon"><i class="fas fa-heart"></i></div>
                                            <div>
                                                <div class="pf-info-label">Civil Status</div>
                                                <div class="pf-info-value"><?= esc($civilStatus) ?></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-phone"></i></div>
                                        <div>
                                            <div class="pf-info-label">Contact Number</div>
                                            <div class="pf-info-value <?= $contactNo === '—' ? 'empty' : '' ?>"><?= esc($contactNo) ?></div>
                                        </div>
                                    </div>
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-briefcase"></i></div>
                                        <div>
                                            <div class="pf-info-label">Occupation</div>
                                            <div class="pf-info-value <?= $occupation === '—' ? 'empty' : '' ?>"><?= esc($occupation) ?></div>
                                        </div>
                                    </div>
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-coins"></i></div>
                                        <div>
                                            <div class="pf-info-label">Monthly Income</div>
                                            <div class="pf-info-value <?= $income === '—' ? 'empty' : '' ?>"><?= esc($income) ?></div>
                                        </div>
                                    </div>
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-graduation-cap"></i></div>
                                        <div>
                                            <div class="pf-info-label">Educational Attainment</div>
                                            <div class="pf-info-value <?= $education === '—' ? 'empty' : '' ?>"><?= esc($education) ?></div>
                                        </div>
                                    </div>
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-id-badge"></i></div>
                                        <div>
                                            <div class="pf-info-label">PhilHealth Number</div>
                                            <div class="pf-info-value <?= $philhealth === '—' ? 'empty' : '' ?>"><?= esc($philhealth) ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Household Info -->
                        <div class="pf-card">
                            <div class="pf-card-header">
                                <div class="pf-card-header-icon"><i class="fas fa-home"></i></div>
                                <div>
                                    <h4>Household Information</h4>
                                    <p>Household #<?= esc($hhNo) ?> — <?= esc($zone) ?></p>
                                </div>
                            </div>
                            <div class="pf-card-body">
                                <div class="pf-info-list" style="margin-bottom:16px;">
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-users"></i></div>
                                        <div>
                                            <div class="pf-info-label">Total Members</div>
                                            <div class="pf-info-value"><?= $memberCount ?> member<?= $memberCount !== 1 ? 's' : '' ?></div>
                                        </div>
                                    </div>
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                                        <div>
                                            <div class="pf-info-label">Zone</div>
                                            <div class="pf-info-value <?= ($household['zone'] ?? '—') === '—' ? 'empty' : '' ?>"><?= esc($household['zone'] ?? '—') ?></div>
                                        </div>
                                    </div>
                                    <?php if (! empty($household['address'])): ?>
                                        <div class="pf-info-item">
                                            <div class="pf-info-icon"><i class="fas fa-road"></i></div>
                                            <div>
                                                <div class="pf-info-label">Address</div>
                                                <div class="pf-info-value"><?= esc($household['address']) ?></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="pf-info-item">
                                        <div class="pf-info-icon"><i class="fas fa-home"></i></div>
                                        <div>
                                            <div class="pf-info-label">House Ownership</div>
                                            <div class="pf-info-value"><?= esc($household['house_ownership'] ?? '—') ?></div>
                                        </div>
                                    </div>
                                    <?php if (! empty($household['years_of_residency'])): ?>
                                        <div class="pf-info-item">
                                            <div class="pf-info-icon"><i class="fas fa-calendar-alt"></i></div>
                                            <div>
                                                <div class="pf-info-label">Years of Residency</div>
                                                <div class="pf-info-value"><?= (int)$household['years_of_residency'] ?> year<?= $household['years_of_residency'] != 1 ? 's' : '' ?></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Members list -->
                                <?php if (! empty($members)): ?>
                                    <div style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">
                                        Household Members
                                    </div>
                                    <div class="pf-members-list">
                                        <!-- Head -->
                                        <div class="pf-member-row">
                                            <div class="pf-member-avatar"><?= strtoupper($household['first_name'][0] ?? '?') ?></div>
                                            <div>
                                                <div class="pf-member-name"><?= esc($headName) ?></div>
                                                <div class="pf-member-rel">Household Head</div>
                                            </div>
                                            <?php
                                            $isMe = strtoupper(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''))) === strtoupper($headName);
                                            ?>
                                            <span class="pf-member-badge <?= $isMe ? 'you' : '' ?>"><?= $isMe ? 'You' : 'Head' ?></span>
                                        </div>
                                        <?php foreach ($members as $m):
                                            $mName = trim($m['first_name'] . ' ' . $m['last_name']);
                                            $mInit = strtoupper($m['first_name'][0] ?? '?');
                                            $isMe  = strtoupper(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''))) === strtoupper($mName);
                                        ?>
                                            <div class="pf-member-row">
                                                <div class="pf-member-avatar" style="<?= $isMe ? 'background:#16a085;' : '' ?>"><?= $mInit ?></div>
                                                <div>
                                                    <div class="pf-member-name"><?= esc($mName) ?></div>
                                                    <div class="pf-member-rel"><?= esc(ucfirst($m['relationship'])) ?></div>
                                                </div>
                                                <span class="pf-member-badge <?= $isMe ? 'you' : '' ?>"><?= $isMe ? 'You' : ucfirst($m['relationship']) ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endif; // end if household
                    ?>

                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>