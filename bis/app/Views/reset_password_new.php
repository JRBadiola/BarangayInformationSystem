<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password - Barangay Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f6fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1d2e;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 40px 36px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
            width: 100%;
            max-width: 400px;
        }

        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 28px;
        }

        .logo img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .logo h1 {
            font-size: 18px;
            font-weight: 700;
            color: #1d2448;
        }

        .logo p {
            font-size: 13px;
            color: #9aa0b4;
            margin-top: 2px;
            text-align: center;
        }

        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .alert--error {
            background: #fff0f1;
            color: #c0392b;
            border: 1px solid #fad4d4;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #4a5068;
            margin-bottom: 6px;
        }

        .pw-wrap {
            position: relative;
        }

        .pw-wrap input {
            width: 100%;
            padding: 11px 44px 11px 14px;
            border: 1.5px solid #e2e5ef;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .pw-wrap input:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, .08);
        }

        .pw-wrap input::placeholder {
            color: #b0b6cc;
        }

        .eye-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #b0b6cc;
            cursor: pointer;
            font-size: 14px;
            padding: 4px;
            transition: color .2s;
        }

        .eye-btn:hover {
            color: #1d2448;
        }

        /* Strength bar */
        .pw-strength {
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
            transition: width .3s, background .3s;
            width: 0%;
        }

        .pw-label {
            font-size: 11px;
            color: #9aa0b4;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #1d2448;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            margin-top: 8px;
            transition: background .2s, transform .15s;
        }

        .submit-btn:hover {
            background: #2e3a6e;
            transform: translateY(-1px);
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
            color: #9aa0b4;
        }

        .footer a {
            color: #1d2448;
            font-weight: 500;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div style="width:100%;max-width:400px;padding:16px;">
        <div class="card">
            <div class="logo">
                <img src="/bacolod.png" alt="Logo">
                <h1>Set New Password</h1>
                <p>Choose a strong password for your account.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert--error"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="/forgot-password/reset" method="post" id="resetForm">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label>New Password</label>
                    <div class="pw-wrap">
                        <input type="password" name="new_password" id="pw1" placeholder="Minimum 8 characters" minlength="8" required oninput="checkStrength(this.value)">
                        <button type="button" class="eye-btn" onclick="togglePw('pw1','eye1')"><i class="fas fa-eye" id="eye1"></i></button>
                    </div>
                    <div class="pw-strength">
                        <div class="pw-bar-track">
                            <div class="pw-bar-fill" id="pwBar"></div>
                        </div>
                        <span class="pw-label" id="pwLabel"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <div class="pw-wrap">
                        <input type="password" name="confirm_password" id="pw2" placeholder="Re-enter password" required>
                        <button type="button" class="eye-btn" onclick="togglePw('pw2','eye2')"><i class="fas fa-eye" id="eye2"></i></button>
                    </div>
                </div>

                <button type="submit" class="submit-btn"><i class="fas fa-lock"></i> &nbsp;Reset Password</button>
            </form>

            <div class="footer">
                <a href="/login"><i class="fas fa-arrow-left"></i> Back to Sign In</a>
            </div>
        </div>
    </div>

    <script>
        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }

        function checkStrength(val) {
            const bar = document.getElementById('pwBar');
            const label = document.getElementById('pwLabel');
            if (!val) {
                bar.style.width = '0%';
                label.textContent = '';
                return;
            }
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

        document.getElementById('resetForm').addEventListener('submit', e => {
            if (document.getElementById('pw1').value !== document.getElementById('pw2').value) {
                e.preventDefault();
                alert('Passwords do not match.');
            }
        });
    </script>
</body>

</html>