<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        /* ── Settings layout ── */
        .st-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start;
        }

        .st-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29, 36, 72, 0.06);
            overflow: hidden;
        }

        .st-card-header {
            padding: 18px 24px 14px;
            border-bottom: 1px solid #f0f2f8;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .st-card-header-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: #eef0fb;
            color: #1d2448;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .st-card-header h4 {
            font-size: 14px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0;
        }

        .st-card-header p {
            font-size: 12px;
            color: #9aa0b4;
            margin: 2px 0 0;
        }

        .st-card-body {
            padding: 22px 24px;
        }

        /* Avatar */
        .st-avatar-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
            padding-bottom: 18px;
            border-bottom: 1px solid #f0f2f8;
        }

        .st-avatar {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            color: #fff;
            font-size: 26px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .st-avatar-info h5 {
            font-size: 15px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0 0 2px;
        }

        .st-avatar-info span {
            font-size: 12px;
            color: #9aa0b4;
        }

        /* Form fields */
        .st-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }

        .st-form-row--full {
            grid-template-columns: 1fr;
        }

        .st-form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .st-form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #4a5068;
        }

        .st-input-wrap {
            position: relative;
        }

        .st-input-wrap .st-input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0b6cc;
            font-size: 13px;
            pointer-events: none;
        }

        .st-input {
            width: 100%;
            padding: 10px 12px 10px 36px;
            border: 1.5px solid #e2e5ef;
            border-radius: 8px;
            font-size: 13.5px;
            font-family: 'Poppins', sans-serif;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }

        .st-input:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, 0.08);
        }

        .st-input::placeholder {
            color: #c0c6d8;
        }

        .st-pw-wrap {
            position: relative;
        }

        .st-pw-wrap .st-input {
            padding-right: 42px;
        }

        .st-eye-btn {
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
            transition: color 0.2s;
        }

        .st-eye-btn:hover {
            color: #1d2448;
        }

        /* Buttons */
        .st-btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.2s;
            border: none;
        }

        .st-btn--primary {
            background: #1d2448;
            color: #fff;
        }

        .st-btn--primary:hover {
            background: #2e3a6e;
        }

        .st-btn--outline {
            background: #fff;
            color: #1d2448;
            border: 1.5px solid #1d2448;
        }

        .st-btn--outline:hover {
            background: #f0f2f8;
        }

        .st-btn--danger {
            background: #fff0f1;
            color: #c0392b;
            border: 1.5px solid #fad4d4;
        }

        .st-btn--danger:hover {
            background: #fad4d4;
        }

        /* Alerts */
        .st-alert {
            padding: 11px 14px;
            border-radius: 8px;
            font-size: 13px;
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 18px;
        }

        .st-alert--success {
            background: #f0faf6;
            color: #1a7a55;
            border: 1px solid #c3e8d8;
        }

        .st-alert--error {
            background: #fff0f1;
            color: #c0392b;
            border: 1px solid #fad4d4;
        }

        .st-alert--info {
            background: #f0f4ff;
            color: #1d2448;
            border: 1px solid #d0d8f5;
        }

        /* OTP input */
        .st-otp-group {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin: 16px 0;
        }

        .st-otp-group input {
            width: 46px;
            height: 54px;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            border: 2px solid #e2e5ef;
            border-radius: 9px;
            outline: none;
            color: #1d2448;
            transition: border-color 0.2s, box-shadow 0.2s;
            caret-color: transparent;
        }

        .st-otp-group input:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, 0.1);
        }

        .st-otp-group input.filled {
            border-color: #1d2448;
            background: #f0f2ff;
        }

        /* Password strength */
        .st-pw-strength {
            margin-top: 6px;
        }

        .st-pw-bar-track {
            height: 4px;
            background: #e2e5ef;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .st-pw-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s, background 0.3s;
            width: 0%;
        }

        .st-pw-label {
            font-size: 11px;
            color: #9aa0b4;
        }

        /* Toggle */
        .st-toggle-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .st-toggle-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid #f0f2f8;
        }

        .st-toggle-item:last-child {
            border-bottom: none;
        }

        .st-toggle-label {
            font-size: 13.5px;
            color: #1a1d2e;
            font-weight: 500;
        }

        .st-toggle-sub {
            font-size: 11.5px;
            color: #9aa0b4;
            margin-top: 2px;
        }

        .db-toggle {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .db-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .db-toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #e2e5ef;
            border-radius: 24px;
            transition: .3s;
        }

        .db-toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background: #fff;
            border-radius: 50%;
            transition: .3s;
        }

        .db-toggle input:checked+.db-toggle-slider {
            background: #1d2448;
        }

        .db-toggle input:checked+.db-toggle-slider:before {
            transform: translateX(20px);
        }

        /* Step indicator */
        .st-steps {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
        }

        .st-step {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #9aa0b4;
        }

        .st-step.active {
            color: #1d2448;
            font-weight: 600;
        }

        .st-step-num {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #e2e5ef;
            color: #9aa0b4;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .st-step.active .st-step-num {
            background: #1d2448;
            color: #fff;
        }

        .st-step.done .st-step-num {
            background: #16c79a;
            color: #fff;
        }

        .st-step-sep {
            flex: 1;
            height: 1px;
            background: #e2e5ef;
        }

        @media (max-width: 900px) {
            .st-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = $role ?? 'secretary';
    $active    = 'settings';
    $pageTitle = 'Settings';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $user     = session()->get('user_id') ? (new \App\Models\UserModel())->find(session()->get('user_id')) : [];
    $otpSent  = session()->getFlashdata('pw_otp_sent');
    $otpPending = session()->get('pw_otp_pending');
    $initial  = strtoupper(($user['first_name'][0] ?? 'S'));
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="st-alert st-alert--success" style="margin-bottom:20px;">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="st-grid">

                <!-- ── Profile Card ── -->
                <div class="st-card">
                    <div class="st-card-header">
                        <div class="st-card-header-icon"><i class="fas fa-user-circle"></i></div>
                        <div>
                            <h4>Profile Information</h4>
                            <p>Update your name, email and contact details</p>
                        </div>
                    </div>
                    <div class="st-card-body">

                        <?php if (session()->getFlashdata('profile_error')): ?>
                            <div class="st-alert st-alert--error">
                                <i class="fas fa-exclamation-circle"></i>
                                <?= session()->getFlashdata('profile_error') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Avatar row -->
                        <div class="st-avatar-row">
                            <div class="st-avatar" style="overflow:hidden;position:relative;flex-shrink:0;">
                                <?php
                                $avatarFile = session()->get('avatar');
                                if ($avatarFile && file_exists(FCPATH . 'uploads/avatars/' . $avatarFile)):
                                ?>
                                    <img id="avatarPreview" src="/uploads/avatars/<?= esc($avatarFile) ?>"
                                        alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                                <?php else: ?>
                                    <span id="avatarInitial" style="font-size:26px;font-weight:700;"><?= $initial ?></span>
                                    <img id="avatarPreview" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:50%;position:absolute;inset:0;">
                                <?php endif; ?>
                            </div>
                            <div class="st-avatar-info">
                                <h5><?= esc(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: 'Secretary') ?></h5>
                                <span><?= esc($user['email'] ?? '') ?></span>
                                <div style="margin-top:8px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                                    <label for="avatarInput" class="db-btn db-btn--outline" style="font-size:12px;padding:5px 12px;cursor:pointer;margin:0;">
                                        <i class="fas fa-camera"></i> Change Photo
                                    </label>
                                    <input type="file" id="avatarInput" accept="image/jpeg,image/png,image/gif,image/webp" style="display:none;" onchange="previewAvatar(this)">
                                    <span style="font-size:11px;color:#9aa0b4;">JPG, PNG, GIF or WebP · Max 2MB</span>
                                </div>
                                <div id="avatarUploadActions" style="display:none;margin-top:8px;">
                                    <form action="/<?= $role ?>/settings/avatar" method="post" enctype="multipart/form-data" id="avatarForm">
                                        <?= csrf_field() ?>
                                        <input type="file" name="avatar" id="avatarFormInput" style="display:none;" accept="image/*">
                                        <button type="submit" class="db-btn db-btn--primary" style="font-size:12px;padding:5px 14px;">
                                            <i class="fas fa-upload"></i> Upload Photo
                                        </button>
                                        <button type="button" onclick="cancelAvatar()" class="db-btn db-btn--outline" style="font-size:12px;padding:5px 12px;">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <form action="/<?= $role ?>/settings/profile" method="post">
                            <?= csrf_field() ?>
                            <div class="st-form-row">
                                <div class="st-form-group">
                                    <label>Last Name</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-user st-input-icon"></i>
                                        <input type="text" class="st-input" name="last_name"
                                            value="<?= esc($user['last_name'] ?? '') ?>" required>
                                    </div>
                                </div>
                                <div class="st-form-group">
                                    <label>First Name</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-user st-input-icon"></i>
                                        <input type="text" class="st-input" name="first_name"
                                            value="<?= esc($user['first_name'] ?? '') ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="st-form-row">
                                <div class="st-form-group">
                                    <label>Middle Name <span style="color:#9aa0b4;font-weight:400;">(optional)</span></label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-user st-input-icon"></i>
                                        <input type="text" class="st-input" name="middle_name"
                                            value="<?= esc($user['middle_name'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="st-form-group">
                                    <label>Username</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-at st-input-icon"></i>
                                        <input type="text" class="st-input" value="<?= esc($user['username'] ?? '') ?>" disabled
                                            style="background:#f5f6fa;cursor:not-allowed;">
                                    </div>
                                </div>
                            </div>
                            <div class="st-form-row st-form-row--full" style="margin-bottom:14px;">
                                <div class="st-form-group">
                                    <label>Email Address</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-envelope st-input-icon"></i>
                                        <input type="email" class="st-input" name="email"
                                            value="<?= esc($user['email'] ?? '') ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="st-form-row st-form-row--full" style="margin-bottom:20px;">
                                <div class="st-form-group">
                                    <label>Contact Number</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-phone st-input-icon"></i>
                                        <input type="text" class="st-input" name="contact_number"
                                            value="<?= esc($user['contact_number'] ?? '') ?>"
                                            placeholder="09XXXXXXXXX">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="st-btn st-btn--primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- ── Password Card ── -->
                <div class="st-card">
                    <div class="st-card-header">
                        <div class="st-card-header-icon" style="background:#fff0f1;color:#c0392b;">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div>
                            <h4>Change Password</h4>
                            <p>A verification code will be sent to your Gmail</p>
                        </div>
                    </div>
                    <div class="st-card-body">

                        <?php if (session()->getFlashdata('pw_error')): ?>
                            <div class="st-alert st-alert--error">
                                <i class="fas fa-exclamation-circle"></i>
                                <?= session()->getFlashdata('pw_error') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Step indicator -->
                        <div class="st-steps">
                            <div class="st-step <?= (!$otpSent && !$otpPending) ? 'active' : 'done' ?>">
                                <span class="st-step-num"><i class="fas <?= (!$otpSent && !$otpPending) ? 'fa-1' : 'fa-check' ?>"></i></span>
                                <span>Enter Password</span>
                            </div>
                            <div class="st-step-sep"></div>
                            <div class="st-step <?= ($otpSent || $otpPending) ? 'active' : '' ?>">
                                <span class="st-step-num">2</span>
                                <span>Verify Code</span>
                            </div>
                        </div>

                        <?php if (! $otpSent && ! $otpPending): ?>
                            <!-- Step 1: Enter current + new password -->
                            <form action="/<?= $role ?>/settings/request-otp" method="post" id="pwForm">
                                <?= csrf_field() ?>

                                <div class="st-form-group" style="margin-bottom:14px;">
                                    <label>Current Password</label>
                                    <div class="st-input-wrap st-pw-wrap">
                                        <i class="fas fa-lock st-input-icon"></i>
                                        <input type="password" class="st-input" name="current_password"
                                            id="cur_pw" placeholder="Enter current password" required>
                                        <button type="button" class="st-eye-btn" onclick="togglePw('cur_pw','eye_cur')">
                                            <i class="fas fa-eye" id="eye_cur"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="st-form-group" style="margin-bottom:6px;">
                                    <label>New Password</label>
                                    <div class="st-input-wrap st-pw-wrap">
                                        <i class="fas fa-key st-input-icon"></i>
                                        <input type="password" class="st-input" name="new_password"
                                            id="new_pw" placeholder="Minimum 8 characters" minlength="8"
                                            required oninput="checkStrength(this.value)">
                                        <button type="button" class="st-eye-btn" onclick="togglePw('new_pw','eye_new')">
                                            <i class="fas fa-eye" id="eye_new"></i>
                                        </button>
                                    </div>
                                    <div class="st-pw-strength" id="pwStrength" style="display:none;">
                                        <div class="st-pw-bar-track">
                                            <div class="st-pw-bar-fill" id="pwBar"></div>
                                        </div>
                                        <span class="st-pw-label" id="pwLabel"></span>
                                    </div>
                                </div>

                                <div class="st-form-group" style="margin-bottom:20px;">
                                    <label>Confirm New Password</label>
                                    <div class="st-input-wrap st-pw-wrap">
                                        <i class="fas fa-key st-input-icon"></i>
                                        <input type="password" class="st-input" name="confirm_password"
                                            id="conf_pw" placeholder="Re-enter new password" required>
                                        <button type="button" class="st-eye-btn" onclick="togglePw('conf_pw','eye_conf')">
                                            <i class="fas fa-eye" id="eye_conf"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="st-alert st-alert--info" style="margin-bottom:16px;">
                                    <i class="fas fa-info-circle"></i>
                                    <span>A 6-digit verification code will be sent to <strong><?= esc($user['email'] ?? 'your email') ?></strong> to confirm the change.</span>
                                </div>

                                <button type="submit" class="st-btn st-btn--primary" style="width:100%;">
                                    <i class="fas fa-paper-plane"></i> Send Verification Code
                                </button>
                            </form>

                        <?php else: ?>
                            <!-- Step 2: Enter OTP -->
                            <div class="st-alert st-alert--info">
                                <i class="fas fa-envelope-open-text"></i>
                                <span>A 6-digit code was sent to <strong><?= esc($user['email'] ?? 'your email') ?></strong>. Enter it below.</span>
                            </div>

                            <form action="/<?= $role ?>/settings/verify-otp" method="post" id="otpForm">
                                <?= csrf_field() ?>
                                <input type="hidden" name="otp" id="otp_hidden">

                                <div class="st-otp-group" id="otpGroup">
                                    <?php for ($i = 0; $i < 6; $i++): ?>
                                        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                                            autocomplete="off" class="otp-digit">
                                    <?php endfor; ?>
                                </div>

                                <button type="submit" class="st-btn st-btn--primary" style="width:100%;margin-bottom:12px;">
                                    <i class="fas fa-check-circle"></i> Verify & Change Password
                                </button>
                            </form>

                            <div style="text-align:center;font-size:13px;color:#9aa0b4;">
                                Didn't receive the code?
                                <a href="/<?= $role ?>/settings/change-password" style="color:#1d2448;font-weight:600;text-decoration:none;">Resend</a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- ── System Settings Card ── -->
                <div class="st-card" style="grid-column: 1 / -1;">
                    <div class="st-card-header">
                        <div class="st-card-header-icon"><i class="fas fa-cog"></i></div>
                        <div>
                            <h4>System Settings</h4>
                            <p>Configure system-wide preferences</p>
                        </div>
                    </div>
                    <div class="st-card-body">
                        <div class="st-toggle-list">
                            <div class="st-toggle-item">
                                <div>
                                    <div class="st-toggle-label">Email Notifications</div>
                                    <div class="st-toggle-sub">Receive email alerts for new clearance requests and approvals</div>
                                </div>
                                <label class="db-toggle">
                                    <input type="checkbox" checked>
                                    <span class="db-toggle-slider"></span>
                                </label>
                            </div>
                            <div class="st-toggle-item">
                                <div>
                                    <div class="st-toggle-label">Auto-approve Clearances</div>
                                    <div class="st-toggle-sub">Automatically approve clearance requests that meet all criteria</div>
                                </div>
                                <label class="db-toggle">
                                    <input type="checkbox">
                                    <span class="db-toggle-slider"></span>
                                </label>
                            </div>
                            <div class="st-toggle-item">
                                <div>
                                    <div class="st-toggle-label">Account Approval Alerts</div>
                                    <div class="st-toggle-sub">Get notified when new resident or SK accounts are pending approval</div>
                                </div>
                                <label class="db-toggle">
                                    <input type="checkbox" checked>
                                    <span class="db-toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Reset User Password Card (Secretary only) ── -->
                <div class="st-card" style="grid-column: 1 / -1;">
                    <div class="st-card-header">
                        <div class="st-card-header-icon" style="background:#fff0f1;color:#c0392b;"><i class="fas fa-key"></i></div>
                        <div>
                            <h4>Reset User Password</h4>
                            <p>Set a new password for any active account — no verification required</p>
                        </div>
                    </div>
                    <div class="st-card-body">

                        <?php if (session()->getFlashdata('reset_error')): ?>
                            <div class="db-alert db-alert--error" style="margin-bottom:16px;">
                                <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('reset_error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="post" id="resetPwForm" onsubmit="return prepareResetForm(event)">
                            <?= csrf_field() ?>

                            <div class="st-form-row" style="align-items:end;">
                                <div class="st-form-group" style="grid-column:1/-1;">
                                    <label>Select User</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-user st-input-icon"></i>
                                        <select class="st-input" id="resetUserId" name="_user_select" onchange="updateResetAction(this.value)" required>
                                            <option value="">— Choose a user —</option>
                                            <?php foreach ($allUsers ?? [] as $u): ?>
                                                <option value="<?= $u['id'] ?>">
                                                    <?= esc(trim($u['first_name'] . ' ' . $u['last_name'])) ?> (<?= esc($u['username']) ?> · <?= strtoupper(esc($u['role'])) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="st-form-row" style="margin-top:14px;">
                                <div class="st-form-group">
                                    <label>New Password</label>
                                    <div class="st-input-wrap st-pw-wrap">
                                        <i class="fas fa-lock st-input-icon"></i>
                                        <input type="password" class="st-input" name="new_password" id="reset_pw1"
                                            placeholder="Minimum 8 characters" minlength="8" required>
                                        <button type="button" class="st-eye-btn" onclick="togglePw('reset_pw1','reset_eye1')" aria-label="Toggle">
                                            <i class="fas fa-eye" id="reset_eye1"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="st-form-group">
                                    <label>Confirm New Password</label>
                                    <div class="st-input-wrap st-pw-wrap">
                                        <i class="fas fa-lock st-input-icon"></i>
                                        <input type="password" class="st-input" name="confirm_password" id="reset_pw2"
                                            placeholder="Re-enter password" required>
                                        <button type="button" class="st-eye-btn" onclick="togglePw('reset_pw2','reset_eye2')" aria-label="Toggle">
                                            <i class="fas fa-eye" id="reset_eye2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div style="margin-top:16px;">
                                <button type="submit" class="db-btn db-btn--danger" style="gap:8px;">
                                    <i class="fas fa-key"></i> Reset Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Password toggle
        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Password strength
        function checkStrength(val) {
            const el = document.getElementById('pwStrength');
            const bar = document.getElementById('pwBar');
            const label = document.getElementById('pwLabel');
            if (!val) {
                el.style.display = 'none';
                return;
            }
            el.style.display = 'block';
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const levels = [{
                    w: '25%',
                    bg: '#e74c3c',
                    text: 'Weak'
                },
                {
                    w: '50%',
                    bg: '#e67e22',
                    text: 'Fair'
                },
                {
                    w: '75%',
                    bg: '#f1c40f',
                    text: 'Good'
                },
                {
                    w: '100%',
                    bg: '#16c79a',
                    text: 'Strong'
                },
            ];
            const lvl = levels[score - 1] || levels[0];
            bar.style.width = lvl.w;
            bar.style.background = lvl.bg;
            label.textContent = lvl.text;
            label.style.color = lvl.bg;
        }

        // Password form validation
        const pwForm = document.getElementById('pwForm');
        if (pwForm) {
            pwForm.addEventListener('submit', function(e) {
                const pw = document.getElementById('new_pw').value;
                const cpw = document.getElementById('conf_pw').value;
                if (pw !== cpw) {
                    e.preventDefault();
                    alert('New passwords do not match.');
                }
            });
        }

        // OTP digit inputs
        const digits = document.querySelectorAll('.otp-digit');
        const hidden = document.getElementById('otp_hidden');
        const otpForm = document.getElementById('otpForm');

        if (digits.length) {
            digits.forEach((input, idx) => {
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/\D/g, '');
                    if (input.value) {
                        input.classList.add('filled');
                        if (idx < digits.length - 1) digits[idx + 1].focus();
                    } else {
                        input.classList.remove('filled');
                    }
                    syncOtp();
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && idx > 0) {
                        digits[idx - 1].focus();
                        digits[idx - 1].value = '';
                        digits[idx - 1].classList.remove('filled');
                        syncOtp();
                    }
                });
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasted = (e.clipboardData || window.clipboardData)
                        .getData('text').replace(/\D/g, '').slice(0, 6);
                    pasted.split('').forEach((ch, i) => {
                        if (digits[i]) {
                            digits[i].value = ch;
                            digits[i].classList.add('filled');
                        }
                    });
                    syncOtp();
                    digits[Math.min(pasted.length, digits.length - 1)].focus();
                });
            });
            digits[0].focus();
        }

        function syncOtp() {
            if (hidden) hidden.value = Array.from(digits).map(d => d.value).join('');
        }

        if (otpForm) {
            otpForm.addEventListener('submit', (e) => {
                syncOtp();
                if (hidden.value.length < 6) {
                    e.preventDefault();
                    alert('Please enter the complete 6-digit code.');
                }
            });
        }

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );

        // ── Avatar preview & upload ──────────────────────────────────────────
        function previewAvatar(input) {
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('Image must be smaller than 2MB.');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                const initial = document.getElementById('avatarInitial');
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (initial) initial.style.display = 'none';
                // Copy file to the hidden form input
                const dt = new DataTransfer();
                dt.items.add(file);
                document.getElementById('avatarFormInput').files = dt.files;
                document.getElementById('avatarUploadActions').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        function cancelAvatar() {
            const preview = document.getElementById('avatarPreview');
            const initial = document.getElementById('avatarInitial');
            const avatarFile = '<?= esc(session()->get('avatar') ?? '') ?>';
            if (avatarFile) {
                preview.src = '/uploads/avatars/' + avatarFile;
                preview.style.display = 'block';
                if (initial) initial.style.display = 'none';
            } else {
                preview.src = '';
                preview.style.display = 'none';
                if (initial) initial.style.display = '';
            }
            document.getElementById('avatarUploadActions').style.display = 'none';
            document.getElementById('avatarInput').value = '';
        }

        // Reset password form — set action dynamically based on selected user
        function updateResetAction(userId) {
            const form = document.getElementById('resetPwForm');
            if (userId) {
                form.action = '/secretary/reset-password/' + userId;
            } else {
                form.action = '';
            }
        }

        function prepareResetForm(e) {
            const userId = document.getElementById('resetUserId').value;
            if (!userId) {
                e.preventDefault();
                alert('Please select a user.');
                return false;
            }
            const pw = document.getElementById('reset_pw1').value;
            const cpw = document.getElementById('reset_pw2').value;
            if (pw !== cpw) {
                e.preventDefault();
                alert('Passwords do not match.');
                return false;
            }
            if (pw.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters.');
                return false;
            }
            return confirm('Reset password for this user? They will need to use the new password to log in.');
        }
    </script>
</body>

</html>