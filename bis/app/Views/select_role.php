<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Role - Barangay Management</title>
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
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            width: 100%;
            max-width: 420px;
            margin: 16px;
            text-align: center;
        }

        .card-logo {
            margin-bottom: 24px;
        }

        .card-logo img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: contain;
        }

        .card h1 {
            font-size: 18px;
            font-weight: 700;
            color: #1d2448;
            margin-bottom: 6px;
        }

        .card p {
            font-size: 13px;
            color: #9aa0b4;
            margin-bottom: 28px;
        }

        .role-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .role-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding: 22px 12px;
            border: 1.5px solid #e2e5ef;
            border-radius: 12px;
            text-decoration: none;
            color: #4a5068;
            transition: border-color 0.2s, background 0.2s, color 0.2s, transform 0.2s;
        }

        .role-card:hover {
            border-color: #1d2448;
            background: #f5f6fa;
            color: #1d2448;
            transform: translateY(-2px);
        }

        .role-card i {
            font-size: 24px;
            color: #1d2448;
        }

        .role-card span {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .divider {
            height: 1px;
            background: #eef0f6;
            margin: 4px 0 20px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #9aa0b4;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #1d2448;
        }

        .notice {
            background: #f0f4ff;
            border: 1px solid #d0d8f5;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            color: #4a5068;
            margin-bottom: 20px;
            text-align: left;
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .notice i {
            color: #5b6fd6;
            margin-top: 1px;
            flex-shrink: 0;
        }

        @media (max-width: 400px) {
            .card {
                padding: 32px 20px;
            }

            .role-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-logo">
            <img src="/bacolod.png" alt="Bacolod Logo">
        </div>

        <h1>Create an Account</h1>
        <p>Select the role that best describes you</p>

        <div class="role-grid">
            <a href="/signup/resident" class="role-card">
                <i class="fas fa-users"></i>
                <span>Resident</span>
            </a>
            <a href="/signup/sk" class="role-card">
                <i class="fas fa-star"></i>
                <span>SK</span>
            </a>
        </div>

        <div class="notice">
            <i class="fas fa-info-circle"></i>
            Captain, Secretary, and Treasurer accounts are created by the barangay office. Contact them directly if you are an official.
        </div>

        <div class="divider"></div>

        <a href="/login" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to sign in
        </a>
    </div>
</body>

</html>