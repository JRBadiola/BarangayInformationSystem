<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Official Account - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .ca-wrap {
            max-width: 700px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .ca-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(29, 36, 72, .07);
            overflow: hidden;
        }

        .ca-card-header {
            background: linear-gradient(135deg, #1d2448 0%, #2e3a6e 100%);
            padding: 24px 28px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .ca-card-header-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, .12);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            flex-shrink: 0;
        }

        .ca-card-header-text h3 {
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 3px;
        }

        .ca-card-header-text p {
            color: rgba(255, 255, 255, .65);
            font-size: 12px;
            margin: 0;
        }

        .ca-body {
            padding: 24px 28px 28px;
        }

        .ca-section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #9aa0b4;
            margin: 0 0 14px;
        }

        .ca-divider {
            height: 1px;
            background: #f0f2f8;
            margin: 20px 0;
        }

        .ca-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }

        .ca-form-row--full {
            grid-template-columns: 1fr;
        }

        .ca-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .ca-form-group label {
            font-size: 12.5px;
            font-weight: 600;
            color: #4a5068;
        }

        .ca-input-wrap {
            position: relative;
        }

        .ca-input-wrap .ca-input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0b6cc;
            font-size: 13px;
            pointer-events: none;
        }

        .ca-form-group input,
        .ca-form-group select {
            width: 100%;
            padding: 10px 14px 10px 36px;
            border: 1.5px solid #e2e5ef;
            border-radius: 9px;
            font-size: 13.5px;
            font-family: 'Poppins', sans-serif;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box;
        }

        .ca-form-group input:focus,
        .ca-form-group select:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, .08);
        }

        .ca-form-group input::placeholder {
            color: #c0c6d8;
        }

        .ca-pw-wrap {
            position: relative;
        }

        .ca-pw-wrap input {
            padding-right: 42px;
        }

        .ca-eye-btn {
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
            line-height: 1;
        }

        .ca-eye-btn:hover {
            color: #1d2448;
        }

        .ca-pw-strength {
            margin-top: 6px;
            display: none;
        }

        .ca-pw-strength.visible {
            display: block;
        }

        .ca-pw-bar-track {
            height: 4px;
            background: #e2e5ef;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .ca-pw-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width .3s, background .3s;
            width: 0%;
        }

        .ca-pw-label {
            font-size: 11px;
            color: #9aa0b4;
        }

        .ca-alert {
            padding: 11px 14px;
            border-radius: 9px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 20px;
        }

        .ca-alert--success {
            background: #f0faf6;
            color: #1a7a55;
            border: 1px solid #c3e8d8;
        }

        .ca-alert--error {
            background: #fff0f1;
            color: #c0392b;
            border: 1px solid #fad4d4;
        }

        .ca-submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
            transition: opacity .2s, transform .15s;
        }

        .ca-submit-btn:hover {
            opacity: .92;
            transform: translateY(-1px);
        }

        .ca-submit-btn:active {
            transform: translateY(0);
        }

        .ca-info-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #f5f7ff;
            border: 1px solid #dde2f5;
            border-radius: 9px;
            padding: 12px 14px;
            font-size: 12.5px;
            color: #4a5068;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .ca-info-note i {
            color: #5b6fd6;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .ca-role-pills {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .ca-role-pill {
            flex: 1;
            border: 2px solid #e2e5ef;
            border-radius: 12px;
            padding: 12px 14px;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
        }

        .ca-role-pill:hover {
            border-color: #1d2448;
            background: #f8f9ff;
        }

        .ca-role-pill.selected {
            border-color: #1d2448;
            background: #f0f2ff;
        }

        .ca-role-pill input[type="radio"] {
            display: none;
        }

        .ca-role-pill-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .ca-role-pill--captain .ca-role-pill-icon {
            background: rgba(29, 36, 72, .1);
            color: #1d2448;
        }

        .ca-role-pill--resident .ca-role-pill-icon {
            background: rgba(91, 111, 214, .12);
            color: #5b6fd6;
        }

        .ca-role-pill--sk .ca-role-pill-icon {
            background: rgba(22, 199, 154, .12);
            color: #16a085;
        }

        .ca-role-pill-label {
            font-size: 13px;
            font-weight: 600;
            color: #1a1d2e;
        }

        .ca-role-pill-sub {
            font-size: 11px;
            color: #9aa0b4;
            margin-top: 1px;
        }

        .ca-role-pill--blocked {
            opacity: .6;
            cursor: not-allowed !important;
            pointer-events: none;
            border-color: #fad4d4 !important;
            background: #fff5f5 !important;
        }

        .ca-role-pill--blocked .ca-role-pill-icon {
            background: rgba(192, 57, 43, .1) !important;
            color: #c0392b !important;
        }

        .ca-role-pill .ca-check {
            margin-left: auto;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #e2e5ef;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            flex-shrink: 0;
        }

        .ca-role-pill.selected .ca-check {
            background: #1d2448;
            border-color: #1d2448;
            color: #fff;
            font-size: 10px;
        }

        .ca-active-warn {
            background: #fff8f0;
            border: 1px solid #fde8c8;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 12.5px;
            color: #7a4200;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 18px;
        }

        .ca-active-warn i {
            color: #e67e22;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .ca-active-warn strong {
            color: #5a3000;
        }

        .ca-deactivate-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            padding: 5px 12px;
            background: #c0392b;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: opacity .2s;
        }

        .ca-deactivate-btn:hover {
            opacity: .88;
        }

        /* ── Assign Role Card ───────────────────────── */
        .ar-officials-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .ar-official-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            border: 1.5px solid #e8eaf2;
            border-radius: 11px;
            background: #fafbff;
        }

        .ar-official-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .ar-official-avatar.ar-sk {
            background: linear-gradient(135deg, #16a085, #1abc9c);
        }

        .ar-official-avatar.ar-sec {
            background: linear-gradient(135deg, #8e44ad, #9b59b6);
        }

        .ar-official-info {
            flex: 1;
            min-width: 0;
        }

        .ar-official-name {
            font-size: 13.5px;
            font-weight: 600;
            color: #1a1d2e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ar-official-meta {
            font-size: 11.5px;
            color: #9aa0b4;
            margin-top: 1px;
        }

        .ar-role-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            letter-spacing: .4px;
        }

        .ar-role-badge--captain {
            background: rgba(29, 36, 72, .1);
            color: #1d2448;
        }

        .ar-role-badge--secretary {
            background: rgba(142, 68, 173, .12);
            color: #8e44ad;
        }

        .ar-role-badge--sk {
            background: rgba(22, 199, 154, .13);
            color: #16a085;
        }

        .ar-revoke-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            background: #fff;
            border: 1.5px solid #e0e3ee;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            color: #c0392b;
            cursor: pointer;
            transition: all .2s;
            flex-shrink: 0;
        }

        .ar-revoke-btn:hover {
            background: #fff0f1;
            border-color: #fad4d4;
        }

        .ar-empty-slot {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border: 1.5px dashed #dde2f5;
            border-radius: 11px;
            color: #b0b6cc;
            font-size: 12.5px;
        }

        .ar-empty-slot i {
            font-size: 16px;
        }

        .ar-promote-form {
            background: #f8f9ff;
            border: 1.5px solid #dde2f5;
            border-radius: 12px;
            padding: 18px 20px;
        }

        .ar-promote-form .ca-section-label {
            margin-bottom: 12px;
        }

        .ar-role-select-row {
            display: flex;
            gap: 8px;
            margin-bottom: 14px;
        }

        .ar-role-btn {
            flex: 1;
            padding: 9px 8px;
            border: 1.5px solid #e2e5ef;
            border-radius: 9px;
            background: #fff;
            font-size: 12px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            color: #4a5068;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .ar-role-btn:hover {
            border-color: #1d2448;
            background: #f0f2ff;
        }

        .ar-role-btn.active {
            border-color: #1d2448;
            background: #f0f2ff;
            color: #1d2448;
        }

        .ar-role-btn i {
            font-size: 16px;
        }

        .ar-role-btn--blocked {
            opacity: .5;
            cursor: not-allowed;
            pointer-events: none;
            border-color: #fad4d4 !important;
            background: #fff5f5 !important;
        }

        .ar-resident-select {
            width: 100%;
            padding: 10px 14px 10px 36px;
            border: 1.5px solid #e2e5ef;
            border-radius: 9px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            box-sizing: border-box;
            transition: border-color .2s, box-shadow .2s;
        }

        .ar-resident-select:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, .08);
        }

        /* ── Resident combobox ───────────────────────────────────────────────── */
        .ar-combo-wrap {
            position: relative;
        }

        .ar-combo-input {
            width: 100%;
            padding: 10px 34px 10px 36px;
            border: 1.5px solid #e2e5ef;
            border-radius: 9px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            box-sizing: border-box;
            transition: border-color .2s, box-shadow .2s;
        }

        .ar-combo-input:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, .08);
        }

        .ar-combo-input::placeholder {
            color: #c0c6d8;
        }

        .ar-combo-clear {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #b0b6cc;
            font-size: 12px;
            cursor: pointer;
            padding: 4px;
            line-height: 1;
            transition: color .15s;
        }

        .ar-combo-clear:hover {
            color: #c0392b;
        }

        .ar-combo-dropdown {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            right: 0;
            background: #fff;
            border: 1.5px solid #dde2f5;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(29, 36, 72, .12);
            z-index: 500;
            max-height: 220px;
            overflow-y: auto;
            padding: 4px 0;
        }

        .ar-combo-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            cursor: pointer;
            transition: background .12s;
        }

        .ar-combo-item:hover,
        .ar-combo-item.focused {
            background: #f0f2ff;
        }

        .ar-combo-item-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ar-combo-item-name {
            font-size: 13px;
            font-weight: 600;
            color: #1a1d2e;
            line-height: 1.3;
        }

        .ar-combo-item-name mark {
            background: #fef3c7;
            color: #92400e;
            border-radius: 2px;
            padding: 0 1px;
        }

        .ar-combo-item-meta {
            font-size: 11px;
            color: #9aa0b4;
            margin-top: 1px;
        }

        .ar-combo-empty {
            padding: 14px 16px;
            font-size: 12.5px;
            color: #9aa0b4;
            text-align: center;
        }

        .ar-combo-selected-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f0f2ff;
            border: 1.5px solid #dde2f5;
            border-radius: 9px;
            padding: 8px 12px;
            font-size: 13px;
            color: #1a1d2e;
            margin-top: 6px;
        }

        .ar-combo-selected-pill i {
            color: #5b6fd6;
        }

        .ar-assign-btn {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 12px;
            transition: opacity .2s;
        }

        .ar-assign-btn:hover {
            opacity: .9;
        }

        .ar-assign-btn:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .ar-no-residents {
            text-align: center;
            padding: 18px 10px;
            color: #9aa0b4;
            font-size: 13px;
        }

        .ar-no-residents i {
            font-size: 28px;
            display: block;
            margin-bottom: 8px;
            color: #d0d4e8;
        }

        /* ── Confirmation Modal ───────────────────────────────────────────────── */
        .conf-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 20, 50, .45);
            backdrop-filter: blur(3px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            animation: confFadeIn .18s ease;
        }

        @keyframes confFadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .conf-box {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 16px 48px rgba(15, 20, 50, .22);
            padding: 32px 28px 26px;
            max-width: 380px;
            width: 100%;
            text-align: center;
            animation: confSlideUp .2s ease;
        }

        @keyframes confSlideUp {
            from {
                transform: translateY(14px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .conf-icon-wrap {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 16px;
        }

        .conf-icon-wrap--revoke {
            background: #fff0f0;
            color: #c0392b;
        }

        .conf-icon-wrap--assign {
            background: #f0f5ff;
            color: #1d2448;
        }

        .conf-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1d2e;
            margin: 0 0 8px;
        }

        .conf-body {
            font-size: 13.5px;
            color: #5a5f78;
            line-height: 1.6;
            margin: 0 0 10px;
        }

        .conf-meta {
            background: #f5f7ff;
            border: 1px solid #dde2f5;
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 13px;
            color: #4a5068;
            margin-bottom: 20px;
            text-align: left;
        }

        .conf-meta strong {
            color: #1a1d2e;
        }

        .conf-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .conf-btn {
            flex: 1;
            padding: 11px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            border: none;
            transition: all .18s;
        }

        .conf-btn--cancel {
            background: #f0f2f8;
            color: #4a5068;
            border: 1.5px solid #e2e5ef;
        }

        .conf-btn--cancel:hover {
            background: #e8eaf2;
        }

        .conf-btn--confirm {
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            color: #fff;
        }

        .conf-btn--confirm:hover {
            opacity: .9;
        }

        .conf-btn--confirm--danger {
            background: linear-gradient(135deg, #c0392b, #e74c3c) !important;
        }

        @media (max-width: 560px) {
            .ca-form-row {
                grid-template-columns: 1fr;
            }

            .ca-role-pills,
            .ar-role-select-row {
                flex-direction: column;
            }

            .ca-body {
                padding: 18px 16px 22px;
            }

            .ca-card-header {
                padding: 18px 16px;
            }

            .ar-promote-form {
                padding: 14px 14px;
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'secretary';
    $active    = 'create_account';
    $pageTitle = 'Create Official Account';
    include(APPPATH . 'Views/dashboard/sidebar.php');
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div class="db-page-header" style="margin-bottom:24px;">
                <h2>Create Official Account</h2>
                <p>Set up a new Captain, Resident, or SK account, or assign an existing resident to an official role.</p>
            </div>

            <?php
            $activeCaptain     = $activeCaptain   ?? null;
            $activeSecretaries = $activeSecretaries ?? [];
            $activeSk          = $activeSk        ?? null;
            $eligibleResidents = $eligibleResidents ?? [];
            ?>

            <div class="ca-wrap">

                <!-- ── Flash alerts ── -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="ca-alert ca-alert--success" style="margin-bottom:0;">
                        <i class="fas fa-check-circle"></i>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="ca-alert ca-alert--error" style="margin-bottom:0;">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- ══════════════════════════════════════════════════════════
                     CARD 1 — ASSIGN ROLE TO EXISTING RESIDENT
                ════════════════════════════════════════════════════════════ -->
                <div class="ca-card">
                    <div class="ca-card-header">
                        <div class="ca-card-header-icon"><i class="fas fa-user-tag"></i></div>
                        <div class="ca-card-header-text">
                            <h3>Assign Official Role</h3>
                            <p>Upgrade an existing resident account to Captain, Secretary, or SK.</p>
                        </div>
                    </div>
                    <div class="ca-body">

                        <!-- Current Officials -->
                        <p class="ca-section-label">Current Officials</p>
                        <div class="ar-officials-grid">

                            <!-- Captain slot -->
                            <?php if ($activeCaptain): ?>
                                <div class="ar-official-row">
                                    <div class="ar-official-avatar">
                                        <?= strtoupper(substr($activeCaptain['first_name'], 0, 1)) ?>
                                    </div>
                                    <div class="ar-official-info">
                                        <div class="ar-official-name"><?= esc(trim($activeCaptain['first_name'] . ' ' . $activeCaptain['last_name'])) ?></div>
                                        <div class="ar-official-meta">@<?= esc($activeCaptain['username']) ?></div>
                                    </div>
                                    <span class="ar-role-badge ar-role-badge--captain">Captain</span>
                                    <form action="/secretary/demote-official/<?= $activeCaptain['id'] ?>" method="post" id="revokeForm-captain">
                                        <?= csrf_field() ?>
                                        <button type="button" class="ar-revoke-btn"
                                            onclick="confirmRevoke('captain','<?= esc(trim($activeCaptain['first_name'] . ' ' . $activeCaptain['last_name'])) ?>')">
                                            <i class="fas fa-user-minus"></i> Revoke
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="ar-empty-slot">
                                    <i class="fas fa-user-tie"></i>
                                    <span>No active Captain — assign one below.</span>
                                </div>
                            <?php endif; ?>

                            <!-- Secretary slot (supports default admin + one resident secretary) -->
                            <?php
                            $hasNonAdminSecretary = false;
                            foreach ($activeSecretaries as $s) {
                                if (! empty($s['username']) && $s['username'] !== 'secretary_admin') {
                                    $hasNonAdminSecretary = true;
                                    break;
                                }
                            }
                            ?>

                            <?php if (! empty($activeSecretaries)): ?>
                                <?php foreach ($activeSecretaries as $activeSecretary): ?>
                                    <div class="ar-official-row">
                                        <div class="ar-official-avatar ar-sec">
                                            <?= strtoupper(substr($activeSecretary['first_name'], 0, 1)) ?>
                                        </div>
                                        <div class="ar-official-info">
                                            <div class="ar-official-name"><?= esc(trim($activeSecretary['first_name'] . ' ' . $activeSecretary['last_name'])) ?></div>
                                            <div class="ar-official-meta">@<?= esc($activeSecretary['username']) ?></div>
                                        </div>
                                        <span class="ar-role-badge ar-role-badge--secretary">Secretary</span>
                                        <?php if (! empty($activeSecretary['username']) && $activeSecretary['username'] === 'secretary_admin'): ?>
                                            <!-- Default admin cannot be revoked -->
                                            <div style="padding:6px 8px;color:#9aa0b4;font-size:12px;">Default</div>
                                        <?php else: ?>
                                            <form action="/secretary/demote-official/<?= $activeSecretary['id'] ?>" method="post" id="revokeForm-secretary-<?= $activeSecretary['id'] ?>">
                                                <?= csrf_field() ?>
                                                <button type="button" class="ar-revoke-btn"
                                                    onclick="confirmRevoke('secretary','<?= esc(trim($activeSecretary['first_name'] . ' ' . $activeSecretary['last_name'])) ?>')">
                                                    <i class="fas fa-user-minus"></i> Revoke
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="ar-empty-slot">
                                    <i class="fas fa-user-shield"></i>
                                    <span>No active Secretary — assign one below.</span>
                                </div>
                            <?php endif; ?>

                            <!-- SK slot -->
                            <?php if ($activeSk): ?>
                                <div class="ar-official-row">
                                    <div class="ar-official-avatar ar-sk">
                                        <?= strtoupper(substr($activeSk['first_name'], 0, 1)) ?>
                                    </div>
                                    <div class="ar-official-info">
                                        <div class="ar-official-name"><?= esc(trim($activeSk['first_name'] . ' ' . $activeSk['last_name'])) ?></div>
                                        <div class="ar-official-meta">@<?= esc($activeSk['username']) ?></div>
                                    </div>
                                    <span class="ar-role-badge ar-role-badge--sk">SK</span>
                                    <form action="/secretary/demote-official/<?= $activeSk['id'] ?>" method="post" id="revokeForm-sk">
                                        <?= csrf_field() ?>
                                        <button type="button" class="ar-revoke-btn"
                                            onclick="confirmRevoke('sk','<?= esc(trim($activeSk['first_name'] . ' ' . $activeSk['last_name'])) ?>')">
                                            <i class="fas fa-user-minus"></i> Revoke
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="ar-empty-slot">
                                    <i class="fas fa-users"></i>
                                    <span>No active SK — assign one below.</span>
                                </div>
                            <?php endif; ?>

                        </div><!-- /.ar-officials-grid -->

                        <div class="ca-divider"></div>

                        <!-- Promote Form -->
                        <p class="ca-section-label">Assign Role to a Resident</p>

                        <?php if (empty($eligibleResidents)): ?>
                            <div class="ar-no-residents">
                                <i class="fas fa-users-slash"></i>
                                No eligible residents found. Residents must be registered, active, and linked to a household in the census.
                            </div>
                        <?php else: ?>
                            <div class="ar-promote-form">
                                <form action="/secretary/promote-resident" method="post" id="promoteForm">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="role" id="promoteRoleInput" value="">

                                    <p class="ca-section-label" style="margin-bottom:10px;">1. Select the role to assign</p>
                                    <div class="ar-role-select-row">
                                        <button type="button" class="ar-role-btn <?= $activeCaptain ? 'ar-role-btn--blocked' : '' ?>"
                                            id="arBtn-captain" onclick="selectPromoteRole('captain')">
                                            <i class="fas fa-user-tie"></i>
                                            Captain
                                            <?php if ($activeCaptain): ?>
                                                <span style="font-size:10px;color:#c0392b;">Slot filled</span>
                                            <?php endif; ?>
                                        </button>
                                        <button type="button" class="ar-role-btn <?= $hasNonAdminSecretary ? 'ar-role-btn--blocked' : '' ?>"
                                            id="arBtn-secretary" onclick="selectPromoteRole('secretary')">
                                            <i class="fas fa-user-shield"></i>
                                            Secretary
                                            <?php if ($hasNonAdminSecretary): ?>
                                                <span style="font-size:10px;color:#c0392b;">Slot filled</span>
                                            <?php endif; ?>
                                        </button>
                                        <button type="button" class="ar-role-btn <?= $activeSk ? 'ar-role-btn--blocked' : '' ?>"
                                            id="arBtn-sk" onclick="selectPromoteRole('sk')">
                                            <i class="fas fa-users"></i>
                                            SK
                                            <?php if ($activeSk): ?>
                                                <span style="font-size:10px;color:#c0392b;">Slot filled</span>
                                            <?php endif; ?>
                                        </button>
                                    </div>

                                    <p class="ca-section-label" style="margin-bottom:10px;">2. Select the resident to assign</p>
                                    <!-- hidden real value submitted to server -->
                                    <input type="hidden" name="user_id" id="promoteUserSelect">

                                    <div class="ar-combo-wrap" id="residentComboWrap">
                                        <i class="fas fa-user ca-input-icon"></i>
                                        <input type="text"
                                            id="residentSearch"
                                            class="ar-combo-input"
                                            placeholder="Type a name to search…"
                                            autocomplete="off"
                                            aria-label="Search resident"
                                            aria-autocomplete="list"
                                            aria-controls="residentDropdown"
                                            aria-expanded="false">
                                        <button type="button" class="ar-combo-clear" id="residentClearBtn" onclick="clearResident()" title="Clear" style="display:none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <div class="ar-combo-dropdown" id="residentDropdown" role="listbox" style="display:none;"></div>
                                    </div>
                                    <div style="font-size:11.5px;color:#9aa0b4;margin-top:5px;margin-bottom:4px;">
                                        <?= count($eligibleResidents) ?> resident<?= count($eligibleResidents) !== 1 ? 's' : '' ?> aged 18+ linked to the census.
                                    </div>

                                    <button type="button" class="ar-assign-btn" id="assignBtn" disabled
                                        onclick="confirmAssign()">
                                        <i class="fas fa-user-check"></i> Assign Role
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>

                    </div><!-- /.ca-body -->
                </div><!-- /.ca-card (assign role) -->

                <!-- ══════════════════════════════════════════════════════════
                     CARD 2 — CREATE NEW ACCOUNT
                ════════════════════════════════════════════════════════════ -->
                <div class="ca-card">
                    <div class="ca-card-header">
                        <div class="ca-card-header-icon"><i class="fas fa-user-plus"></i></div>
                        <div class="ca-card-header-text">
                            <h3>Create New Account</h3>
                            <p>Register a brand-new Captain, Resident, or SK account from scratch.</p>
                        </div>
                    </div>
                    <div class="ca-body">

                        <form action="/secretary/create-account/store" method="post" id="createForm">
                            <?= csrf_field() ?>
                            <input type="hidden" name="role" id="roleInput" value="captain">

                            <!-- Role selection -->
                            <p class="ca-section-label">Select Role</p>

                            <!-- Active-account warnings (for blocking captain creation) -->
                            <?php if ($activeCaptain): ?>
                                <div class="ca-active-warn" id="warnCaptain">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <div>
                                        <strong>Active Captain exists:</strong>
                                        <?= esc(trim($activeCaptain['first_name'] . ' ' . $activeCaptain['last_name'])) ?>
                                        (<?= esc($activeCaptain['username']) ?>)<br>
                                        <span style="font-size:11.5px;">Revoke their role above before creating a new Captain account.</span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="ca-role-pills">
                                <label class="ca-role-pill ca-role-pill--captain <?= $activeCaptain ? 'ca-role-pill--blocked' : 'selected' ?>"
                                    id="pill-captain"
                                    <?= $activeCaptain ? '' : 'onclick="selectRole(\'captain\')"' ?>>
                                    <input type="radio" name="_role_ui" value="captain" <?= $activeCaptain ? 'disabled' : '' ?>>
                                    <div class="ca-role-pill-icon"><i class="fas fa-user-tie"></i></div>
                                    <div>
                                        <div class="ca-role-pill-label">Captain</div>
                                        <div class="ca-role-pill-sub"><?= $activeCaptain ? 'Slot already filled' : 'Barangay Captain' ?></div>
                                    </div>
                                    <div class="ca-check" id="check-captain"><i class="fas fa-check"></i></div>
                                </label>
                                <label class="ca-role-pill ca-role-pill--resident selected" id="pill-resident" onclick="selectRole('resident')">
                                    <input type="radio" name="_role_ui" value="resident">
                                    <div class="ca-role-pill-icon"><i class="fas fa-user"></i></div>
                                    <div>
                                        <div class="ca-role-pill-label">Resident</div>
                                        <div class="ca-role-pill-sub">Barangay Resident</div>
                                    </div>
                                    <div class="ca-check" id="check-resident"><i class="fas fa-check"></i></div>
                                </label>
                                <label class="ca-role-pill ca-role-pill--sk" id="pill-sk" onclick="selectRole('sk')">
                                    <input type="radio" name="_role_ui" value="sk">
                                    <div class="ca-role-pill-icon"><i class="fas fa-users"></i></div>
                                    <div>
                                        <div class="ca-role-pill-label">SK</div>
                                        <div class="ca-role-pill-sub">Sangguniang Kabataan</div>
                                    </div>
                                    <div class="ca-check" id="check-sk"><i class="fas fa-check"></i></div>
                                </label>
                            </div>

                            <div class="ca-divider"></div>

                            <div class="ca-info-note">
                                <i class="fas fa-info-circle"></i>
                                <span>This account will be <strong>immediately active</strong> — no email verification or approval required. Share the credentials directly with the user.</span>
                            </div>

                            <p class="ca-section-label">Account Details</p>

                            <div class="ca-form-row">
                                <div class="ca-form-group">
                                    <label>Last Name</label>
                                    <div class="ca-input-wrap">
                                        <i class="fas fa-user ca-input-icon"></i>
                                        <input type="text" name="last_name" placeholder="e.g. Dela Cruz" required>
                                    </div>
                                </div>
                                <div class="ca-form-group">
                                    <label>First Name</label>
                                    <div class="ca-input-wrap">
                                        <i class="fas fa-user ca-input-icon"></i>
                                        <input type="text" name="first_name" placeholder="e.g. Juan" required>
                                    </div>
                                </div>
                            </div>
                            <div class="ca-form-row">
                                <div class="ca-form-group">
                                    <label>Middle Name <span style="color:#9aa0b4;font-weight:400;">(optional)</span></label>
                                    <div class="ca-input-wrap">
                                        <i class="fas fa-user ca-input-icon"></i>
                                        <input type="text" name="middle_name" placeholder="e.g. Santos">
                                    </div>
                                </div>
                                <div class="ca-form-group">
                                    <label>Username</label>
                                    <div class="ca-input-wrap">
                                        <i class="fas fa-at ca-input-icon"></i>
                                        <input type="text" name="username" placeholder="e.g. juan_delacruz" required>
                                    </div>
                                </div>
                            </div>
                            <div class="ca-form-row ca-form-row--full" style="margin-bottom:14px;">
                                <div class="ca-form-group">
                                    <label>Email Address</label>
                                    <div class="ca-input-wrap">
                                        <i class="fas fa-envelope ca-input-icon"></i>
                                        <input type="email" name="email" placeholder="e.g. juan@email.com" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Household No — shown only for Resident -->
                            <div class="ca-form-row ca-form-row--full" id="householdRow" style="display:none;margin-bottom:14px;">
                                <div class="ca-form-group">
                                    <label>Household Number <span style="color:#9aa0b4;font-weight:400;">(optional — links resident to census)</span></label>
                                    <div class="ca-input-wrap">
                                        <i class="fas fa-home ca-input-icon"></i>
                                        <input type="text" name="household_no" id="householdNo" placeholder="e.g. 12345" maxlength="5">
                                    </div>
                                </div>
                            </div>
                            <div class="ca-form-row">
                                <div class="ca-form-group">
                                    <label>Password</label>
                                    <div class="ca-input-wrap ca-pw-wrap">
                                        <i class="fas fa-lock ca-input-icon"></i>
                                        <input type="password" name="password" id="pw1" placeholder="Minimum 8 characters" minlength="8" required oninput="checkStrength(this.value)">
                                        <button type="button" class="ca-eye-btn" onclick="togglePw('pw1','eye1')" aria-label="Toggle password">
                                            <i class="fas fa-eye" id="eye1"></i>
                                        </button>
                                    </div>
                                    <div class="ca-pw-strength" id="pwStrength">
                                        <div class="ca-pw-bar-track">
                                            <div class="ca-pw-bar-fill" id="pwBar"></div>
                                        </div>
                                        <span class="ca-pw-label" id="pwLabel"></span>
                                    </div>
                                </div>
                                <div class="ca-form-group">
                                    <label>Confirm Password</label>
                                    <div class="ca-input-wrap ca-pw-wrap">
                                        <i class="fas fa-lock ca-input-icon"></i>
                                        <input type="password" name="confirm_password" id="pw2" placeholder="Re-enter password" required>
                                        <button type="button" class="ca-eye-btn" onclick="togglePw('pw2','eye2')" aria-label="Toggle confirm password">
                                            <i class="fas fa-eye" id="eye2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="ca-submit-btn">
                                <i class="fas fa-user-plus"></i> Create Account
                            </button>
                        </form>

                    </div><!-- /.ca-body -->
                </div><!-- /.ca-card (create new) -->

            </div><!-- /.ca-wrap -->
        </div><!-- /.db-content -->
    </div><!-- /.db-main -->

    <!-- ── Custom Confirmation Modal ─────────────────────────────────────── -->
    <div id="confirmModal" class="conf-overlay" role="dialog" aria-modal="true" aria-labelledby="confTitle" style="display:none;">
        <div class="conf-box">
            <div class="conf-icon-wrap" id="confIconWrap">
                <i class="fas fa-user-minus" id="confIcon"></i>
            </div>
            <h3 class="conf-title" id="confTitle">Confirm Action</h3>
            <p class="conf-body" id="confBody"></p>
            <div class="conf-meta" id="confMeta" style="display:none;"></div>
            <div class="conf-actions">
                <button type="button" class="conf-btn conf-btn--cancel" onclick="closeModal()">Cancel</button>
                <button type="button" class="conf-btn conf-btn--confirm" id="confOkBtn">Confirm</button>
            </div>
        </div>
    </div>

    <script>
        // ── Resident combobox data (PHP → JS) ────────────────────────────────────
        const RESIDENTS = <?= json_encode(array_map(fn($r) => [
                                'id'       => $r['id'],
                                'label'    => trim($r['last_name'] . ', ' . $r['first_name'] . ($r['middle_name'] ? ' ' . $r['middle_name'] : '')),
                                'username' => $r['username'],
                                'age'      => (int)$r['age'],
                            ], $eligibleResidents ?? []), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

        // ── Custom confirmation modal ────────────────────────────────────────────
        let _pendingAction = null;

        function openModal({
            iconClass,
            iconWrapClass,
            title,
            body,
            meta,
            okLabel,
            okDanger
        }) {
            document.getElementById('confIcon').className = 'fas ' + iconClass;
            document.getElementById('confIconWrap').className = 'conf-icon-wrap ' + (iconWrapClass || '');
            document.getElementById('confTitle').textContent = title;
            document.getElementById('confBody').textContent = body;

            const metaEl = document.getElementById('confMeta');
            if (meta) {
                metaEl.innerHTML = meta;
                metaEl.style.display = '';
            } else {
                metaEl.style.display = 'none';
            }

            const okBtn = document.getElementById('confOkBtn');
            okBtn.textContent = okLabel || 'Confirm';
            okBtn.className = 'conf-btn conf-btn--confirm' + (okDanger ? ' conf-btn--confirm--danger' : '');

            document.getElementById('confirmModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.querySelector('.conf-btn--cancel').focus(), 50);
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
            document.body.style.overflow = '';
            _pendingAction = null;
        }

        document.getElementById('confOkBtn').addEventListener('click', function() {
            if (typeof _pendingAction === 'function') _pendingAction();
            closeModal();
        });

        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });

        // ── Revoke confirmation ──────────────────────────────────────────────────
        function confirmRevoke(roleKey, name) {
            const roleLabel = {
                captain: 'Captain',
                secretary: 'Secretary',
                sk: 'SK'
            } [roleKey] || roleKey;
            _pendingAction = () => document.getElementById('revokeForm-' + roleKey).submit();
            openModal({
                iconClass: 'fa-user-minus',
                iconWrapClass: 'conf-icon-wrap--revoke',
                title: 'Revoke ' + roleLabel + ' Access?',
                body: 'This will remove their official role. They will keep their account but lose access to the ' + roleLabel + ' dashboard.',
                meta: '<strong>' + name + '</strong> will be downgraded to a regular Resident.',
                okLabel: 'Yes, Revoke Access',
                okDanger: true,
            });
        }

        // ── Assign confirmation ──────────────────────────────────────────────────
        function confirmAssign() {
            const roleKey = selectedPromoteRole;
            const hiddenEl = document.getElementById('promoteUserSelect');
            const searchEl = document.getElementById('residentSearch');

            if (!roleKey || !hiddenEl || !hiddenEl.value) return;

            const rawText = (searchEl ? searchEl.value : '').trim();
            const residentName = rawText.split('(')[0].trim() || 'this resident';
            const roleLabel = {
                captain: 'Captain',
                secretary: 'Secretary',
                sk: 'SK'
            } [roleKey] || roleKey;

            _pendingAction = () => document.getElementById('promoteForm').submit();
            openModal({
                iconClass: 'fa-user-check',
                iconWrapClass: 'conf-icon-wrap--assign',
                title: 'Assign ' + roleLabel + ' Role?',
                body: 'The selected resident will immediately gain access to the ' + roleLabel + ' dashboard.',
                meta: '<strong>' + residentName + '</strong> → <strong>' + roleLabel + '</strong>',
                okLabel: 'Yes, Assign Role',
                okDanger: false,
            });
        }

        // ── Create-new-account form ──────────────────────────────────────────────
        const allRoles = ['captain', 'resident', 'sk'];
        const captainBlocked = <?= $activeCaptain ? 'true' : 'false' ?>;

        function selectRole(role) {
            allRoles.forEach(r => {
                const pill = document.getElementById('pill-' + r);
                if (pill) pill.classList.toggle('selected', r === role);
            });
            document.getElementById('roleInput').value = role;
            document.getElementById('householdRow').style.display = (role === 'resident') ? '' : 'none';
        }

        (function() {
            selectRole(captainBlocked ? 'resident' : 'captain');
        })();

        document.getElementById('createForm').addEventListener('submit', function(e) {
            const sel = document.getElementById('roleInput').value;
            if (sel === 'captain' && captainBlocked) {
                e.preventDefault();
                _pendingAction = null;
                openModal({
                    iconClass: 'fa-exclamation-circle',
                    iconWrapClass: 'conf-icon-wrap--revoke',
                    title: 'Captain Slot Filled',
                    body: 'An active Captain already exists. Revoke their role first before creating a new one.',
                    okLabel: 'OK',
                    okDanger: false,
                });
                return;
            }
            const pw = document.getElementById('pw1').value;
            const cpw = document.getElementById('pw2').value;
            if (pw !== cpw) {
                e.preventDefault();
                _pendingAction = null;
                openModal({
                    iconClass: 'fa-lock',
                    iconWrapClass: 'conf-icon-wrap--revoke',
                    title: 'Passwords Do Not Match',
                    body: 'Please make sure both password fields contain the same value before submitting.',
                    okLabel: 'OK',
                    okDanger: false,
                });
            }
        });

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

        function checkStrength(val) {
            const el = document.getElementById('pwStrength');
            const bar = document.getElementById('pwBar');
            const label = document.getElementById('pwLabel');
            if (!val) {
                el.classList.remove('visible');
                return;
            }
            el.classList.add('visible');
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

        // ── Assign-role form ─────────────────────────────────────────────────────
        let selectedPromoteRole = '';

        function selectPromoteRole(role) {
            selectedPromoteRole = role;
            document.getElementById('promoteRoleInput').value = role;
            ['captain', 'secretary', 'sk'].forEach(r => {
                const btn = document.getElementById('arBtn-' + r);
                if (btn) btn.classList.toggle('active', r === role);
            });
            updateAssignBtn();
        }

        function updateAssignBtn() {
            const btn = document.getElementById('assignBtn');
            const hidden = document.getElementById('promoteUserSelect');
            if (!btn || !hidden) return;
            btn.disabled = !(selectedPromoteRole && hidden.value);
        }

        // ── Resident combobox ─────────────────────────────────────────────────────
        (function() {
            const searchEl = document.getElementById('residentSearch');
            const dropdown = document.getElementById('residentDropdown');
            const hiddenEl = document.getElementById('promoteUserSelect');
            const clearBtn = document.getElementById('residentClearBtn');
            if (!searchEl) return;
            let focusedIdx = -1;
            let isOpen = false;

            function esc(s) {
                return String(s)
                    .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
            }

            function highlight(text, q) {
                if (!q) return esc(text);
                const re = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
                return esc(text).replace(re, '<mark>$1</mark>');
            }

            function buildList(query) {
                const q = query.trim().toLowerCase();
                return q ?
                    RESIDENTS.filter(r =>
                        r.label.toLowerCase().includes(q) ||
                        r.username.toLowerCase().includes(q)) :
                    RESIDENTS.slice();
            }

            function render(query) {
                const matches = buildList(query);
                const q = query.trim().toLowerCase();
                dropdown.innerHTML = '';
                focusedIdx = -1;

                if (matches.length === 0) {
                    dropdown.innerHTML =
                        '<div class="ar-combo-empty"><i class="fas fa-search"></i> No match for "' + esc(query) + '"</div>';
                } else {
                    matches.forEach(r => {
                        const item = document.createElement('div');
                        item.className = 'ar-combo-item';
                        item.dataset.id = r.id;
                        item.setAttribute('role', 'option');
                        item.innerHTML =
                            '<div class="ar-combo-item-avatar">' + esc(r.label.charAt(0).toUpperCase()) + '</div>' +
                            '<div>' +
                            '<div class="ar-combo-item-name">' + highlight(r.label, q) + '</div>' +
                            '<div class="ar-combo-item-meta">@' + esc(r.username) + ' &nbsp;·&nbsp; Age ' + r.age + '</div>' +
                            '</div>';
                        item.addEventListener('mousedown', function(e) {
                            e.preventDefault();
                            pickResident(r);
                        });
                        dropdown.appendChild(item);
                    });
                }
                open();
            }

            function open() {
                dropdown.style.display = 'block';
                searchEl.setAttribute('aria-expanded', 'true');
                isOpen = true;
            }

            function close() {
                dropdown.style.display = 'none';
                searchEl.setAttribute('aria-expanded', 'false');
                isOpen = false;
                focusedIdx = -1;
            }

            function pickResident(r) {
                hiddenEl.value = r.id;
                searchEl.value = r.label + '  (@' + r.username + ')  — Age ' + r.age;
                clearBtn.style.display = '';
                close();
                updateAssignBtn();
            }

            window.clearResident = function() {
                hiddenEl.value = '';
                searchEl.value = '';
                clearBtn.style.display = 'none';
                close();
                searchEl.focus();
                updateAssignBtn();
            };

            searchEl.addEventListener('input', function() {
                hiddenEl.value = '';
                clearBtn.style.display = this.value ? '' : 'none';
                updateAssignBtn();
                render(this.value);
            });

            searchEl.addEventListener('focus', function() {
                render(this.value);
            });

            searchEl.addEventListener('blur', function() {
                setTimeout(() => {
                    close();
                    if (!hiddenEl.value) {
                        searchEl.value = '';
                        clearBtn.style.display = 'none';
                        updateAssignBtn();
                    }
                }, 160);
            });

            searchEl.addEventListener('keydown', function(e) {
                const items = dropdown.querySelectorAll('.ar-combo-item');
                if (!isOpen || items.length === 0) return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    focusedIdx = Math.min(focusedIdx + 1, items.length - 1);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    focusedIdx = Math.max(focusedIdx - 1, 0);
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (focusedIdx >= 0 && items[focusedIdx]) {
                        const r = RESIDENTS.find(x => String(x.id) === items[focusedIdx].dataset.id);
                        if (r) pickResident(r);
                    }
                    return;
                } else if (e.key === 'Escape') {
                    close();
                    return;
                } else {
                    return;
                }

                items.forEach((el, i) => el.classList.toggle('focused', i === focusedIdx));
                if (items[focusedIdx]) items[focusedIdx].scrollIntoView({
                    block: 'nearest'
                });
            });
        })();

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>