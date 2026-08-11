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
        .yp-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29, 36, 72, .06);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .yp-card-header {
            background: #1d2448;
            padding: 13px 20px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .yp-card-header h4 {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            margin: 0;
        }

        .yp-card-header i {
            color: rgba(255, 255, 255, .7);
        }

        .yp-card-body {
            padding: 20px 22px;
        }

        .yp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .yp-field label {
            font-size: 11px;
            font-weight: 700;
            color: #9aa0b4;
            text-transform: uppercase;
            letter-spacing: .4px;
            display: block;
            margin-bottom: 3px;
        }

        .yp-field span {
            font-size: 13.5px;
            color: #1a1d2e;
            font-weight: 500;
        }

        .yp-badge {
            display: inline-flex;
            align-items: center;
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 100px;
        }

        .yp-divider {
            height: 1px;
            background: #f0f2f8;
            margin: 16px 0;
        }

        .yp-tag {
            display: inline-block;
            background: #eef0fb;
            color: #1d2448;
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 100px;
            margin: 2px;
        }

        .yp-tag--warn {
            background: #fff8f0;
            color: #b7600a;
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'sk';
    $active    = 'profiling';
    $pageTitle = 'Youth Profile';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $y       = $youth ?? [];
    $initial = strtoupper(($y['first_name'][0] ?? '?'));
    $name    = esc($y['first_name'] ?? '') . ' ' . esc($y['last_name'] ?? '');
    $dob     = ! empty($y['date_of_birth']) ? date('F d, Y', strtotime($y['date_of_birth'])) : '—';
    $age     = $y['age'] ?? '—';

    $orgs   = ! empty($y['organizations'])    ? json_decode($y['organizations'],    true) : [];
    $health = ! empty($y['health_concerns'])  ? json_decode($y['health_concerns'],  true) : [];
    $social = ! empty($y['social_inclusion']) ? json_decode($y['social_inclusion'], true) : [];

    $statusStyle = [
        'Student'       => 'background:#f0faf6;color:#1a7a55;border:1px solid #c3e8d8;',
        'Employed'      => 'background:#eef0fb;color:#1d2448;border:1px solid #d0d8f5;',
        'Unemployed'    => 'background:#fff8f0;color:#b7600a;border:1px solid #fde8c8;',
        'Out-of-School' => 'background:#fff0f1;color:#c0392b;border:1px solid #fad4d4;',
    ][$y['economic_status'] ?? ''] ?? 'background:#f0f2f8;color:#6b7280;border:1px solid #e2e5ef;';
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <!-- Header bar -->
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
                <div style="display:flex;align-items:center;gap:14px;">
                    <a href="/sk/profiling" class="db-btn db-btn--outline" style="padding:7px 14px;font-size:13px;">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <div>
                        <h2 style="font-size:16px;font-weight:700;color:#1d2448;margin:0;">Youth Profile</h2>
                        <p style="font-size:12px;color:#9aa0b4;margin:0;">KK Profiling Record — LYDO Form 1</p>
                    </div>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="/sk/profiling/edit/<?= $y['id'] ?>" class="db-btn db-btn--primary">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
            </div>

            <!-- Profile hero -->
            <div class="yp-card">
                <div style="background:linear-gradient(135deg,#1d2448,#2e3a6e);padding:28px 28px 20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                    <div style="width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,.15);color:#fff;font-size:28px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <?= $initial ?>
                    </div>
                    <div>
                        <div style="font-size:20px;font-weight:700;color:#fff;"><?= $name ?></div>
                        <div style="font-size:13px;color:rgba(255,255,255,.65);margin-top:4px;">
                            <?= esc($y['gender'] ?? '') ?> · <?= $age ?> years old · <?= esc($y['zone'] ?? '') ?>
                        </div>
                        <div style="margin-top:10px;">
                            <span class="yp-badge" style="<?= $statusStyle ?>"><?= esc($y['economic_status'] ?? '—') ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 1: Personal Info -->
            <div class="yp-card">
                <div class="yp-card-header"><i class="fas fa-user"></i>
                    <h4>Personal Information</h4>
                </div>
                <div class="yp-card-body">
                    <div class="yp-grid">
                        <div class="yp-field"><label>Date of Birth</label><span><?= $dob ?></span></div>
                        <div class="yp-field"><label>Place of Birth</label><span><?= esc($y['place_of_birth'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Religion</label><span><?= esc($y['religion'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Citizenship</label><span><?= esc($y['citizenship'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Civil Status</label><span><?= esc($y['civil_status'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Contact Number</label><span><?= esc($y['contact_number'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Email</label><span><?= esc($y['email'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Months/Years in Brgy.</label><span><?= esc($y['months_in_brgy'] ?? '—') ?></span></div>
                    </div>
                    <div class="yp-divider"></div>
                    <div class="yp-grid">
                        <div class="yp-field" style="grid-column:1/-1;"><label>Address</label><span><?= esc($y['address'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Skills / Talents</label><span><?= esc($y['skills'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Hobbies / Interests</label><span><?= esc($y['hobbies'] ?? '—') ?></span></div>
                    </div>
                    <div class="yp-divider"></div>
                    <div class="yp-grid">
                        <div class="yp-field"><label>Mother's Name</label><span><?= esc($y['mother_name'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Mother's Occupation</label><span><?= esc($y['mother_occupation'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Father's Name</label><span><?= esc($y['father_name'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Father's Occupation</label><span><?= esc($y['father_occupation'] ?? '—') ?></span></div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Organizations -->
            <?php if (! empty($orgs)): ?>
                <div class="yp-card">
                    <div class="yp-card-header"><i class="fas fa-sitemap"></i>
                        <h4>Membership in Organizations</h4>
                    </div>
                    <div class="yp-card-body" style="padding:0;">
                        <table class="db-table">
                            <thead>
                                <tr>
                                    <th>Organization</th>
                                    <th>Position</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orgs as $o): if (empty($o['name'])) continue; ?>
                                    <tr>
                                        <td><?= esc($o['name']) ?></td>
                                        <td><?= esc($o['position'] ?? '—') ?></td>
                                        <td><?= esc($o['year'] ?? '—') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Section 5–9: Education, Governance, Economic -->
            <div class="yp-card">
                <div class="yp-card-header"><i class="fas fa-graduation-cap"></i>
                    <h4>Education, Governance & Economic</h4>
                </div>
                <div class="yp-card-body">
                    <div class="yp-grid">
                        <div class="yp-field"><label>Educational Background</label><span><?= esc($y['educational_background'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>School Type</label><span><?= esc($y['school_type'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Grade/Year/Course</label><span><?= esc($y['school_detail'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Governance</label><span><?= esc($y['governance'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Economic Status</label><span><?= esc($y['economic_status'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Monthly Income</label><span><?= esc($y['monthly_income'] ?? '—') ?></span></div>
                    </div>
                </div>
            </div>

            <!-- Section 7–8: Health & Social -->
            <div class="yp-card">
                <div class="yp-card-header"><i class="fas fa-heartbeat"></i>
                    <h4>Health & Social Inclusion</h4>
                </div>
                <div class="yp-card-body">
                    <label class="yp-field" style="display:block;margin-bottom:10px;"><label>Health Concerns</label></label>
                    <div style="margin-bottom:16px;">
                        <?php if (empty($health)): ?>
                            <span style="color:#9aa0b4;font-size:13px;">None reported</span>
                        <?php else: ?>
                            <?php foreach ($health as $h): ?>
                                <span class="yp-tag yp-tag--warn"><?= esc($h) ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <label class="yp-field" style="display:block;margin-bottom:10px;"><label>Social Inclusion</label></label>
                    <div>
                        <?php if (empty($social)): ?>
                            <span style="color:#9aa0b4;font-size:13px;">None</span>
                        <?php else: ?>
                            <?php foreach ($social as $s): ?>
                                <span class="yp-tag"><?= esc($s) ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Section 10–12: Advocacy, Issues -->
            <div class="yp-card">
                <div class="yp-card-header"><i class="fas fa-hands-helping"></i>
                    <h4>Advocacy, Volunteer & Issues</h4>
                </div>
                <div class="yp-card-body">
                    <div class="yp-grid">
                        <div class="yp-field"><label>Advocacy</label><span><?= esc($y['advocacy'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Volunteer Interests</label><span><?= esc($y['volunteer'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Issue #1</label><span><?= esc($y['issue_1'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Issue #2</label><span><?= esc($y['issue_2'] ?? '—') ?></span></div>
                        <div class="yp-field"><label>Issue #3</label><span><?= esc($y['issue_3'] ?? '—') ?></span></div>
                    </div>
                    <?php if (! empty($y['suggestions'])): ?>
                        <div class="yp-divider"></div>
                        <div class="yp-field"><label>Suggestions</label><span><?= esc($y['suggestions']) ?></span></div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>