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
        /* ── Layout ── */
        .st-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start;
        }

        /* ── Card ── */
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

        /* ── Avatar row ── */
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
            background: linear-gradient(135deg, #5b6fd6, #3a4fa8);
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

        .st-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #eef0fb;
            color: #1d2448;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 100px;
            margin-top: 6px;
        }

        /* ── Form fields ── */
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
            border-color: #5b6fd6;
            box-shadow: 0 0 0 3px rgba(91, 111, 214, 0.1);
        }

        .st-input::placeholder {
            color: #c0c6d8;
        }

        .st-input[disabled] {
            background: #f5f7fb;
            color: #9aa0b4;
            cursor: not-allowed;
        }

        /* ── Password eye toggle ── */
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
            line-height: 1;
        }

        .st-eye-btn:hover {
            color: #5b6fd6;
        }

        /* ── Password strength ── */
        .pw-strength-wrap {
            margin-top: 6px;
        }

        .pw-bar-track {
            height: 4px;
            background: #e2e5ef;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .pw-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s, background 0.3s;
            width: 0%;
        }

        .pw-bar-label {
            font-size: 11px;
            color: #9aa0b4;
        }

        /* ── OTP step indicator ── */
        .otp-step-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            font-size: 12.5px;
            color: #9aa0b4;
        }

        .otp-step {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .otp-step-num {
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

        .otp-step.active .otp-step-num {
            background: #5b6fd6;
            color: #fff;
        }

        .otp-step.active {
            color: #1a1d2e;
        }

        .otp-step-sep {
            flex: 1;
            height: 1px;
            background: #e2e5ef;
        }

        /* ── OTP digit inputs ── */
        .otp-digits {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
        }

        .otp-digit {
            width: 46px;
            height: 52px;
            border: 2px solid #e2e5ef;
            border-radius: 10px;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            color: #1d2448;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .otp-digit:focus {
            border-color: #5b6fd6;
            box-shadow: 0 0 0 3px rgba(91, 111, 214, 0.1);
        }

        .otp-digit.filled {
            border-color: #5b6fd6;
            background: #f0f2ff;
        }

        /* ── SK info card ── */
        .sk-info-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f2f8;
        }

        .sk-info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .sk-info-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #eef0fb;
            color: #5b6fd6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .sk-info-label {
            font-size: 11px;
            font-weight: 700;
            color: #9aa0b4;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .sk-info-value {
            font-size: 13.5px;
            font-weight: 500;
            color: #1a1d2e;
        }

        /* ── Save button ── */
        .st-save-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid #f0f2f8;
        }

        /* ── Alert ── */
        .st-alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
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

        @media (max-width: 900px) {
            .st-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'sk';
    $active    = 'settings';
    $pageTitle = 'Settings';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $username  = session()->get('username')  ?? 'SK Officer';
    $firstName = session()->get('first_name') ?? '';
    $lastName  = session()->get('last_name')  ?? '';
    $middleName = session()->get('middle_name') ?? '';
    $fullName  = session()->get('full_name') ?? trim("$firstName $lastName") ?: $username;
    $initial   = strtoupper(substr($firstName ?: $fullName, 0, 1));

    $pwOtpSent = session()->getFlashdata('pw_otp_sent');
    $pwError   = session()->getFlashdata('pw_error');
    $success   = session()->getFlashdata('success');
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <?php if ($success): ?>
                <div class="st-alert st-alert--success" style="margin-bottom:20px;">
                    <i class="fas fa-check-circle"></i> <?= $success ?>
                </div>
            <?php endif; ?>

            <div class="st-grid">

                <!-- ── Profile Card ── -->
                <div class="st-card">
                    <div class="st-card-header">
                        <div class="st-card-header-icon"><i class="fas fa-user"></i></div>
                        <div>
                            <h4>My Profile</h4>
                            <p>Update your personal information</p>
                        </div>
                    </div>
                    <div class="st-card-body">

                        <!-- Avatar -->
                        <div class="st-avatar-row">
                            <div class="st-avatar" id="avatarPreviewWrap" style="overflow:hidden;position:relative;">
                                <?php
                                $avatarFile = session()->get('avatar');
                                if ($avatarFile && file_exists(FCPATH . 'uploads/avatars/' . $avatarFile)):
                                ?>
                                    <img id="avatarPreview" src="/uploads/avatars/<?= esc($avatarFile) ?>"
                                        alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                                <?php else: ?>
                                    <span id="avatarInitial"><?= $initial ?></span>
                                    <img id="avatarPreview" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:50%;">
                                <?php endif; ?>
                            </div>
                            <div class="st-avatar-info">
                                <h5><?= esc($fullName) ?></h5>
                                <span>@<?= esc($username) ?></span>
                                <div style="margin-top:8px;display:flex;gap:8px;flex-wrap:wrap;">
                                    <label for="avatarInput" class="db-btn db-btn--outline" style="font-size:12px;padding:5px 12px;cursor:pointer;margin:0;">
                                        <i class="fas fa-camera"></i> Change Photo
                                    </label>
                                    <input type="file" id="avatarInput" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                                </div>
                                <div id="avatarUploadActions" style="display:none;margin-top:8px;">
                                    <form action="/<?= $role ?>/settings/avatar" method="post" enctype="multipart/form-data" id="avatarForm">
                                        <?= csrf_field() ?>
                                        <input type="file" name="avatar" id="avatarFormInput" style="display:none;" accept="image/*">
                                        <button type="submit" class="db-btn db-btn--primary" style="font-size:12px;padding:5px 12px;">
                                            <i class="fas fa-upload"></i> Upload
                                        </button>
                                        <button type="button" onclick="cancelAvatar()" class="db-btn db-btn--outline" style="font-size:12px;padding:5px 12px;">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                                <div style="font-size:11px;color:#9aa0b4;margin-top:4px;">JPG, PNG, GIF or WebP · Max 2MB</div>
                            </div>
                        </div>

                        <form action="/sk/settings/profile" method="post">
                            <?= csrf_field() ?>

                            <div class="st-form-row">
                                <div class="st-form-group">
                                    <label>Last Name</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-user st-input-icon"></i>
                                        <input type="text" class="st-input" name="last_name"
                                            value="<?= esc($lastName) ?>" placeholder="Last name" required>
                                    </div>
                                </div>
                                <div class="st-form-group">
                                    <label>First Name</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-user st-input-icon"></i>
                                        <input type="text" class="st-input" name="first_name"
                                            value="<?= esc($firstName) ?>" placeholder="First name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="st-form-row">
                                <div class="st-form-group">
                                    <label>Middle Name <span style="color:#9aa0b4;font-weight:400;">(optional)</span></label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-user st-input-icon"></i>
                                        <input type="text" class="st-input" name="middle_name"
                                            value="<?= esc($middleName) ?>" placeholder="Middle name">
                                    </div>
                                </div>
                                <div class="st-form-group">
                                    <label>Username</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-at st-input-icon"></i>
                                        <input type="text" class="st-input" value="<?= esc($username) ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="st-form-row">
                                <div class="st-form-group">
                                    <label>Email Address</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-envelope st-input-icon"></i>
                                        <input type="email" class="st-input" name="email"
                                            value="<?= esc(session()->get('email') ?? '') ?>"
                                            placeholder="your@email.com">
                                    </div>
                                </div>
                                <div class="st-form-group">
                                    <label>Contact Number</label>
                                    <div class="st-input-wrap">
                                        <i class="fas fa-phone st-input-icon"></i>
                                        <input type="text" class="st-input" name="contact_number"
                                            placeholder="09XXXXXXXXX">
                                    </div>
                                </div>
                            </div>

                            <div class="st-save-row">
                                <button type="submit" class="db-btn db-btn--primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ── Password Card ── -->
                <div class="st-card">
                    <div class="st-card-header">
                        <div class="st-card-header-icon"><i class="fas fa-lock"></i></div>
                        <div>
                            <h4>Change Password</h4>
                            <p>Verify via email OTP before updating</p>
                        </div>
                    </div>
                    <div class="st-card-body">

                        <?php if ($pwError): ?>
                            <div class="st-alert st-alert--error">
                                <i class="fas fa-exclamation-circle"></i> <?= esc($pwError) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Step indicator -->
                        <div class="otp-step-indicator">
                            <div class="otp-step <?= ! $pwOtpSent ? 'active' : '' ?>">
                                <span class="otp-step-num">1</span> Enter Password
                            </div>
                            <div class="otp-step-sep"></div>
                            <div class="otp-step <?= $pwOtpSent ? 'active' : '' ?>">
                                <span class="otp-step-num">2</span> Verify Code
                            </div>
                        </div>

                        <?php if (! $pwOtpSent): ?>
                            <!-- Step 1: Enter current + new password -->
                            <form action="/sk/settings/request-otp" method="post" id="pwForm">
                                <?= csrf_field() ?>

                                <div class="st-form-row st-form-row--full" style="margin-bottom:14px;">
                                    <div class="st-form-group">
                                        <label>Current Password</label>
                                        <div class="st-input-wrap st-pw-wrap">
                                            <i class="fas fa-lock st-input-icon"></i>
                                            <input type="password" class="st-input" name="current_password"
                                                id="cur_pw" placeholder="Enter current password" required>
                                            <button type="button" class="st-eye-btn" onclick="togglePw('cur_pw','cur_eye')">
                                                <i class="fas fa-eye" id="cur_eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="st-form-row">
                                    <div class="st-form-group">
                                        <label>New Password</label>
                                        <div class="st-input-wrap st-pw-wrap">
                                            <i class="fas fa-lock st-input-icon"></i>
                                            <input type="password" class="st-input" name="new_password"
                                                id="new_pw" placeholder="Min. 8 characters" minlength="8"
                                                required oninput="checkStrength(this.value)">
                                            <button type="button" class="st-eye-btn" onclick="togglePw('new_pw','new_eye')">
                                                <i class="fas fa-eye" id="new_eye"></i>
                                            </button>
                                        </div>
                                        <div class="pw-strength-wrap" id="pwStrength" style="display:none;">
                                            <div class="pw-bar-track">
                                                <div class="pw-bar-fill" id="pwBar"></div>
                                            </div>
                                            <span class="pw-bar-label" id="pwLabel"></span>
                                        </div>
                                    </div>
                                    <div class="st-form-group">
                                        <label>Confirm New Password</label>
                                        <div class="st-input-wrap st-pw-wrap">
                                            <i class="fas fa-lock st-input-icon"></i>
                                            <input type="password" class="st-input" name="confirm_password"
                                                id="conf_pw" placeholder="Re-enter password" required>
                                            <button type="button" class="st-eye-btn" onclick="togglePw('conf_pw','conf_eye')">
                                                <i class="fas fa-eye" id="conf_eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="st-save-row">
                                    <button type="submit" class="db-btn db-btn--primary">
                                        <i class="fas fa-paper-plane"></i> Send Verification Code
                                    </button>
                                </div>
                            </form>

                        <?php else: ?>
                            <!-- Step 2: Enter OTP -->
                            <p style="font-size:13px;color:#4a5068;margin:0 0 16px;">
                                A 6-digit code was sent to your registered email. Enter it below to confirm your new password.
                            </p>
                            <form action="/sk/settings/verify-otp" method="post" id="otpForm">
                                <?= csrf_field() ?>
                                <input type="hidden" name="otp" id="otp_hidden">

                                <div class="otp-digits">
                                    <?php for ($i = 0; $i < 6; $i++): ?>
                                        <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                                    <?php endfor; ?>
                                </div>

                                <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
                                    <form action="/sk/settings/change-password" method="post" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <button type="submit" style="background:none;border:none;color:#5b6fd6;font-size:13px;font-weight:600;cursor:pointer;font-family:'Poppins',sans-serif;padding:0;">
                                            <i class="fas fa-redo" style="font-size:11px;"></i> Resend code
                                        </button>
                                    </form>
                                    <button type="submit" class="db-btn db-btn--primary" form="otpForm">
                                        <i class="fas fa-check"></i> Verify & Change Password
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- ── SK Information Card ── -->
                <div class="st-card" style="grid-column: 1 / -1;">
                    <div class="st-card-header">
                        <div class="st-card-header-icon" style="background:rgba(91,111,214,.12);color:#5b6fd6;">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <h4>SK Information</h4>
                            <p>Barangay Sangguniang Kabataan details</p>
                        </div>
                    </div>
                    <div class="st-card-body">
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:0;">

                            <div class="sk-info-row">
                                <div class="sk-info-icon"><i class="fas fa-calendar-alt"></i></div>
                                <div>
                                    <div class="sk-info-label">SK Term</div>
                                    <div class="sk-info-value">2023 – 2026</div>
                                </div>
                            </div>

                            <div class="sk-info-row">
                                <div class="sk-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div>
                                    <div class="sk-info-label">Barangay</div>
                                    <div class="sk-info-value">Bacolod</div>
                                </div>
                            </div>

                            <div class="sk-info-row">
                                <div class="sk-info-icon"><i class="fas fa-city"></i></div>
                                <div>
                                    <div class="sk-info-label">Municipality / Province</div>
                                    <div class="sk-info-value">Bato, Camarines Sur</div>
                                </div>
                            </div>

                            <div class="sk-info-row">
                                <div class="sk-info-icon"><i class="fas fa-user-tie"></i></div>
                                <div>
                                    <div class="sk-info-label">SK Chairperson</div>
                                    <div class="sk-info-value"><?= esc($fullName) ?></div>
                                </div>
                            </div>

                            <div class="sk-info-row">
                                <div class="sk-info-icon"><i class="fas fa-phone"></i></div>
                                <div>
                                    <div class="sk-info-label">Contact / Hotline</div>
                                    <div class="sk-info-value">—</div>
                                </div>
                            </div>

                            <div class="sk-info-row">
                                <div class="sk-info-icon"><i class="fas fa-envelope"></i></div>
                                <div>
                                    <div class="sk-info-label">SK Email</div>
                                    <div class="sk-info-value">—</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div><!-- end st-grid -->
        </div>
    </div>

    <script>
        // ── Password eye toggle ──────────────────────────────────────────────
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

        // ── Password strength ────────────────────────────────────────────────
        function checkStrength(val) {
            const wrap = document.getElementById('pwStrength');
            const bar = document.getElementById('pwBar');
            const label = document.getElementById('pwLabel');
            if (!val) {
                wrap.style.display = 'none';
                return;
            }
            wrap.style.display = 'block';
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

        // ── Password form validation ─────────────────────────────────────────
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

        // ── OTP digit inputs ─────────────────────────────────────────────────
        const digits = document.querySelectorAll('.otp-digit');
        const hidden = document.getElementById('otp_hidden');
        const otpForm = document.getElementById('otpForm');

        if (digits.length) {
            digits.forEach((input, idx) => {
                input.addEventListener('input', e => {
                    input.value = input.value.replace(/\D/g, '');
                    if (input.value) {
                        input.classList.add('filled');
                        if (idx < digits.length - 1) digits[idx + 1].focus();
                    } else {
                        input.classList.remove('filled');
                    }
                    syncOtp();
                });
                input.addEventListener('keydown', e => {
                    if (e.key === 'Backspace' && !input.value && idx > 0) {
                        digits[idx - 1].focus();
                        digits[idx - 1].value = '';
                        digits[idx - 1].classList.remove('filled');
                        syncOtp();
                    }
                });
                input.addEventListener('paste', e => {
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
            otpForm.addEventListener('submit', e => {
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
    </script>
</body>

</html>