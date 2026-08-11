<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youth Profile - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .yp-hero {
            background: linear-gradient(135deg, #1d2448 0%, #2e3a6e 100%);
            border-radius: 16px;
            padding: 28px 28px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            flex-wrap: wrap;
        }

        .yp-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 3px solid rgba(255, 255, 255, .25);
        }

        .yp-name {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin: 0 0 6px;
        }

        .yp-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .yp-meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: rgba(255, 255, 255, .75);
        }

        .yp-meta-item i {
            font-size: 12px;
            opacity: .8;
        }

        .yp-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .15);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .yp-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29, 36, 72, .06);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .yp-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f0f2f8;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .yp-card-header h4 {
            font-size: 13.5px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0;
        }

        .yp-card-header i {
            color: #9aa0b4;
            font-size: 14px;
        }

        .yp-card-body {
            padding: 20px 22px;
        }

        .yp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }

        .yp-field label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #9aa0b4;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 4px;
        }

        .yp-field span {
            font-size: 14px;
            font-weight: 500;
            color: #1a1d2e;
        }

        .yp-hh-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            background: #f8f9fc;
            border-radius: 10px;
            border: 1px solid #e8ecf4;
        }

        .yp-hh-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #1d2448;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .yp-siblings-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .yp-siblings-table th {
            padding: 8px 14px;
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .5px;
            background: #f0f2f8;
            border-bottom: 2px solid #e2e5ef;
            text-align: left;
        }

        .yp-siblings-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #f0f2f8;
            color: #1a1d2e;
        }

        .yp-siblings-table tr:last-child td {
            border-bottom: none;
        }

        .yp-siblings-table tr:hover td {
            background: #f8f9ff;
        }

        .yp-rel-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 100px;
            background: #eef0fb;
            color: #1d2448;
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role        = 'sk';
    $active      = 'profiling';
    $pageTitle   = 'Youth Profile';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $householdId = $householdId ?? '—';
    $head        = $household   ?? [];
    $members     = $members     ?? [];
    $youthMember = $youthMember ?? null;

    // If no specific youth passed, find the first youth (15–30) in members
    if (! $youthMember) {
        foreach ($members as $m) {
            if (! empty($m['date_of_birth'])) {
                $a = (int) date_diff(date_create($m['date_of_birth']), date_create('today'))->y;
                if ($a >= 15 && $a <= 30) {
                    $youthMember = $m;
                    break;
                }
            }
        }
    }

    // Fallback: check if the head is youth
    if (! $youthMember && ! empty($head['date_of_birth'])) {
        $ha = (int) date_diff(date_create($head['date_of_birth']), date_create('today'))->y;
        if ($ha >= 15 && $ha <= 30) {
            $youthMember = array_merge($head, ['relationship' => 'Household Head', 'id' => null]);
        }
    }

    // Youth details
    $yName   = $youthMember ? trim(esc($youthMember['first_name'] ?? '') . ' ' . esc($youthMember['last_name'] ?? '')) : '—';
    $yInit   = strtoupper(($youthMember['first_name'] ?? '?')[0]);
    $yDob    = ! empty($youthMember['date_of_birth']) ? date('F d, Y', strtotime($youthMember['date_of_birth'])) : '—';
    $yAge    = ! empty($youthMember['date_of_birth']) ? (int) date_diff(date_create($youthMember['date_of_birth']), date_create('today'))->y : '—';
    $yGender = esc($youthMember['gender'] ?? $head['gender'] ?? '—');
    $yOcc    = esc($youthMember['occupation'] ?? '—');
    $yEduc   = esc($youthMember['educational_attainment'] ?? '—');
    $yPhil   = esc($youthMember['philhealth_no'] ?? '—');
    $yIncome = ($youthMember['monthly_income'] ?? 0) > 0 ? '₱' . number_format((float)$youthMember['monthly_income'], 2) : '—';
    $yRel    = esc(ucfirst($youthMember['relationship'] ?? '—'));

    // Age group label
    $ageGroup = '';
    if (is_numeric($yAge)) {
        if ($yAge >= 15 && $yAge <= 17)      $ageGroup = 'Child Youth (15–17)';
        elseif ($yAge >= 18 && $yAge <= 21)  $ageGroup = '18–21 y/o';
        elseif ($yAge >= 22 && $yAge <= 24)  $ageGroup = '22–24 y/o';
        elseif ($yAge >= 25 && $yAge <= 30)  $ageGroup = 'Adult Youth (25–30)';
    }

    // Economic status
    $occ = strtolower($youthMember['occupation'] ?? '');
    if (str_contains($occ, 'student'))                                         $econStatus = 'Student';
    elseif (str_contains($occ, 'unemploy'))                                    $econStatus = 'Unemployed';
    elseif (str_contains($occ, 'out-of-school') || str_contains($occ, 'osy')) $econStatus = 'Out-of-School';
    elseif (! empty($occ) && $occ !== 'none' && $occ !== 'n/a')               $econStatus = 'Employed';
    else                                                                        $econStatus = '—';

    $statusStyle = [
        'Student'       => 'background:#f0faf6;color:#1a7a55;border:1px solid #c3e8d8;',
        'Employed'      => 'background:#eef0fb;color:#1d2448;border:1px solid #d0d8f5;',
        'Unemployed'    => 'background:#fff8f0;color:#b7600a;border:1px solid #fde8c8;',
        'Out-of-School' => 'background:#fff0f1;color:#c0392b;border:1px solid #fad4d4;',
    ][$econStatus] ?? 'background:#f0f2f8;color:#6b7280;border:1px solid #e2e5ef;';

    // Other members (excluding the youth being viewed)
    $otherMembers = array_filter($members, function ($m) use ($youthMember) {
        return ! $youthMember || ($m['id'] ?? null) !== ($youthMember['id'] ?? null);
    });
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <!-- Breadcrumb -->
            <div class="hh-breadcrumb" style="margin-bottom:20px;">
                <a href="/sk/profiling" class="hh-back"><i class="fas fa-arrow-left"></i> Back to SK Profiling</a>
                <span class="hh-bc-sep">/</span>
                <span>Household #<?= esc($householdId) ?></span>
                <?php if ($youthMember): ?>
                    <span class="hh-bc-sep">/</span>
                    <span><?= $yName ?></span>
                <?php endif; ?>
            </div>

            <?php if (! $youthMember): ?>
                <!-- No youth found -->
                <div style="text-align:center;padding:60px 20px;color:#9aa0b4;">
                    <i class="fas fa-user-times" style="font-size:40px;display:block;margin-bottom:12px;color:#d0d5e8;"></i>
                    <h3 style="font-size:16px;color:#1d2448;margin-bottom:8px;">No Youth Member Found</h3>
                    <p style="font-size:13.5px;">No household member aged 15–30 was found in Household #<?= esc($householdId) ?>.</p>
                    <a href="/sk/profiling" class="db-btn db-btn--primary" style="margin-top:16px;display:inline-flex;">
                        <i class="fas fa-arrow-left"></i> Back to Profiling
                    </a>
                </div>
            <?php else: ?>

                <!-- ── Youth Hero Card ── -->
                <div class="yp-hero">
                    <div class="yp-avatar"><?= $yInit ?></div>
                    <div style="flex:1;min-width:0;">
                        <div class="yp-name"><?= $yName ?></div>
                        <div class="yp-meta">
                            <span class="yp-meta-item"><i class="fas fa-birthday-cake"></i><?= $yDob ?></span>
                            <span class="yp-meta-item"><i class="fas fa-venus-mars"></i><?= $yGender ?></span>
                            <span class="yp-meta-item"><i class="fas fa-map-marker-alt"></i><?= esc($head['zone'] ?? '—') ?></span>
                            <?php if ($ageGroup): ?>
                                <span class="yp-badge"><i class="fas fa-users"></i><?= $ageGroup ?></span>
                            <?php endif; ?>
                            <span class="yp-badge" style="<?= $statusStyle ?>"><?= $econStatus ?></span>
                        </div>
                        <div style="margin-top:10px;font-size:12px;color:rgba(255,255,255,.55);">
                            Relationship to Household Head: <strong style="color:rgba(255,255,255,.85);"><?= $yRel ?></strong>
                            &nbsp;·&nbsp; Household #<?= esc($householdId) ?>
                        </div>
                    </div>
                </div>

                <!-- ── Youth Personal Details ── -->
                <div class="yp-card">
                    <div class="yp-card-header">
                        <i class="fas fa-id-card"></i>
                        <h4>Personal Information</h4>
                    </div>
                    <div class="yp-card-body">
                        <div class="yp-grid">
                            <div class="yp-field"><label>Full Name</label><span><?= $yName ?></span></div>
                            <div class="yp-field"><label>Date of Birth</label><span><?= $yDob ?></span></div>
                            <div class="yp-field"><label>Age</label><span><?= $yAge ?> years old</span></div>
                            <div class="yp-field"><label>Gender</label><span><?= $yGender ?></span></div>
                            <div class="yp-field"><label>Age Group</label><span><?= $ageGroup ?: '—' ?></span></div>
                            <div class="yp-field"><label>Occupation / Status</label><span><?= $yOcc ?></span></div>
                            <div class="yp-field">
                                <label>Economic Status</label>
                                <span style="display:inline-flex;align-items:center;font-size:12px;font-weight:600;padding:3px 10px;border-radius:100px;<?= $statusStyle ?>"><?= $econStatus ?></span>
                            </div>
                            <div class="yp-field"><label>Monthly Income</label><span><?= $yIncome ?></span></div>
                            <div class="yp-field"><label>Educational Attainment</label><span><?= $yEduc ?></span></div>
                            <div class="yp-field"><label>PhilHealth Number</label><span><?= $yPhil ?></span></div>
                            <div class="yp-field"><label>Zone / Purok</label><span><?= esc($head['zone'] ?? '—') ?></span></div>
                            <div class="yp-field"><label>Address</label><span><?= esc($head['address'] ?? '—') ?></span></div>
                        </div>
                    </div>
                </div>

            <?php endif; // end if youthMember
            ?>

        </div>
    </div>

    <script>
        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>