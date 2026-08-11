<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - BIS</title>
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
            padding: 24px 16px;
            color: #1a1d2e;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 44px 40px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        .icon-wrap {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #4f5bd5, #7b5ea7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .icon-wrap i {
            font-size: 26px;
            color: #fff;
        }

        h1 {
            font-size: 20px;
            font-weight: 700;
            color: #1d2448;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 13px;
            color: #9aa0b4;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .subtitle strong {
            color: #4a5068;
        }

        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            text-align: left;
        }

        .alert--error {
            background: #fff0f1;
            color: #c0392b;
            border: 1px solid #fad4d4;
        }

        .alert--success {
            background: #f0faf6;
            color: #1a7a55;
            border: 1px solid #c3e8d8;
        }

        /* OTP input group */
        .otp-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 28px;
        }

        .otp-group input {
            width: 52px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            border: 2px solid #e2e5ef;
            border-radius: 10px;
            outline: none;
            color: #1d2448;
            transition: border-color 0.2s, box-shadow 0.2s;
            caret-color: transparent;
        }

        .otp-group input:focus {
            border-color: #4f5bd5;
            box-shadow: 0 0 0 3px rgba(79, 91, 213, 0.12);
        }

        .otp-group input.filled {
            border-color: #4f5bd5;
            background: #f5f6ff;
        }

        /* Hidden full OTP input for form submission */
        #otp_hidden {
            display: none;
        }

        .submit-btn {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #4f5bd5, #7b5ea7);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            margin-bottom: 20px;
        }

        .submit-btn:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .divider {
            height: 1px;
            background: #eef0f6;
            margin: 4px 0 18px;
        }

        .resend-row {
            font-size: 13px;
            color: #9aa0b4;
        }

        .resend-row a {
            color: #4f5bd5;
            font-weight: 500;
            text-decoration: none;
        }

        .resend-row a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #9aa0b4;
            text-decoration: none;
            margin-top: 16px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #1d2448;
        }

        @media (max-width: 480px) {
            .card {
                padding: 36px 24px;
            }

            .otp-group input {
                width: 44px;
                height: 52px;
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="card">

        <div class="icon-wrap">
            <i class="fas fa-envelope-open-text"></i>
        </div>

        <h1>Check Your Email</h1>
        <p class="subtitle">
            We sent a 6-digit verification code to<br>
            <strong><?= esc(session()->get('pending_verify_email') ?? 'your email') ?></strong><br>
            Enter it below. The code expires in 15 minutes.
        </p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert--error">
                <i class="fas fa-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert--success">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="/verify-email" method="post" id="otpForm">
            <?= csrf_field() ?>
            <input type="hidden" name="otp" id="otp_hidden">

            <div class="otp-group" id="otpGroup">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" class="otp-digit">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" class="otp-digit">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" class="otp-digit">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" class="otp-digit">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" class="otp-digit">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" class="otp-digit">
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-check-circle"></i> Verify Email
            </button>
        </form>

        <div class="divider"></div>

        <div class="resend-row">
            Didn't receive the code? <a href="/resend-otp">Resend</a>
        </div>

        <a href="/login" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to sign in
        </a>

    </div>

    <script>
        const digits = document.querySelectorAll('.otp-digit');
        const hidden = document.getElementById('otp_hidden');
        const form = document.getElementById('otpForm');

        digits.forEach((input, idx) => {
            input.addEventListener('input', (e) => {
                // Allow only digits
                input.value = input.value.replace(/\D/g, '');

                if (input.value) {
                    input.classList.add('filled');
                    if (idx < digits.length - 1) digits[idx + 1].focus();
                } else {
                    input.classList.remove('filled');
                }
                syncHidden();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && idx > 0) {
                    digits[idx - 1].focus();
                    digits[idx - 1].value = '';
                    digits[idx - 1].classList.remove('filled');
                    syncHidden();
                }
            });

            // Handle paste on any digit
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
                syncHidden();
                const next = Math.min(pasted.length, digits.length - 1);
                digits[next].focus();
            });
        });

        function syncHidden() {
            hidden.value = Array.from(digits).map(d => d.value).join('');
        }

        form.addEventListener('submit', (e) => {
            syncHidden();
            if (hidden.value.length < 6) {
                e.preventDefault();
                alert('Please enter the complete 6-digit code.');
            }
        });

        // Auto-focus first input
        digits[0].focus();
    </script>
</body>

</html>