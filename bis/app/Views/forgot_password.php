<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Barangay Management</title>
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

        .alert--success {
            background: #f0faf6;
            color: #1a7a55;
            border: 1px solid #c3e8d8;
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

        .form-group input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e5ef;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-group input:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, .08);
        }

        .form-group input::placeholder {
            color: #b0b6cc;
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

        .hint {
            font-size: 12px;
            color: #9aa0b4;
            margin-top: 6px;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div style="width:100%;max-width:400px;padding:16px;">
        <div class="card">
            <div class="logo">
                <img src="/bacolod.png" alt="Logo">
                <h1>Forgot Password</h1>
                <p>Enter your registered email address and we'll send you a reset code.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert--error"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert--success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <form action="/forgot-password" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your registered email" required autofocus>
                    <div class="hint">We'll send a 6-digit code to this address. Expires in 15 minutes.</div>
                </div>
                <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> &nbsp;Send Reset Code</button>
            </form>

            <div class="footer" style="margin-top:20px;">
                <a href="/login"><i class="fas fa-arrow-left"></i> Back to Sign In</a>
            </div>
        </div>
    </div>
</body>

</html>