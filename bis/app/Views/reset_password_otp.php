<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Reset Code - Barangay Management</title>
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
            max-width: 420px;
        }

        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 24px;
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
            margin-top: 4px;
            text-align: center;
            line-height: 1.5;
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

        .alert--success {
            background: #f0faf6;
            color: #1a7a55;
            border: 1px solid #c3e8d8;
        }

        /* OTP digits */
        .otp-row {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 20px 0;
        }

        .otp-digit {
            width: 48px;
            height: 56px;
            border: 2px solid #e2e5ef;
            border-radius: 10px;
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            color: #1d2448;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .otp-digit:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, .08);
        }

        .otp-digit.filled {
            border-color: #1d2448;
            background: #f0f2ff;
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
            margin-top: 16px;
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

        .resend-note {
            font-size: 12px;
            color: #9aa0b4;
            text-align: center;
            margin-top: 12px;
        }
    </style>
</head>

<body>
    <div style="width:100%;max-width:420px;padding:16px;">
        <div class="card">
            <div class="logo">
                <img src="/bacolod.png" alt="Logo">
                <h1>Enter Reset Code</h1>
                <p>We sent a 6-digit code to<br><strong style="color:#1d2448;"><?= esc(session()->get('fp_email') ?? '') ?></strong></p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert--error"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="/forgot-password/verify" method="post" id="otpForm">
                <?= csrf_field() ?>
                <input type="hidden" name="otp" id="otp_hidden">

                <div class="otp-row">
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                    <?php endfor; ?>
                </div>

                <button type="submit" class="submit-btn"><i class="fas fa-check"></i> &nbsp;Verify Code</button>
            </form>

            <div class="resend-note">
                Didn't receive it?
                <a href="/forgot-password/resend" style="color:#1d2448;font-weight:600;">Resend code</a>
            </div>

            <div class="footer" style="margin-top:16px;">
                <a href="/login"><i class="fas fa-arrow-left"></i> Back to Sign In</a>
            </div>
        </div>
    </div>

    <script>
        const digits = document.querySelectorAll('.otp-digit');
        const hidden = document.getElementById('otp_hidden');

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
                const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
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

        function syncOtp() {
            hidden.value = Array.from(digits).map(d => d.value).join('');
        }

        document.getElementById('otpForm').addEventListener('submit', e => {
            syncOtp();
            if (hidden.value.length < 6) {
                e.preventDefault();
                alert('Please enter the complete 6-digit code.');
            }
        });

        digits[0].focus();
    </script>
</body>

</html>