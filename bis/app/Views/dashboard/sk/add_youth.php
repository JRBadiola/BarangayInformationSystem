<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($editMode ?? false) ? 'Edit' : 'Add' ?> Youth Profile - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .kk-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29, 36, 72, .06);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .kk-card-header {
            background: #1d2448;
            padding: 14px 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .kk-card-header h4 {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            margin: 0;
            letter-spacing: .3px;
        }

        .kk-card-header i {
            color: rgba(255, 255, 255, .7);
        }

        .kk-card-body {
            padding: 22px;
        }

        .kk-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .kk-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .kk-grid-4 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .kk-full {
            margin-bottom: 16px;
        }

        .kk-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #4a5068;
            margin-bottom: 5px;
        }

        .kk-input {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #e2e5ef;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box;
        }

        .kk-input:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, .08);
        }

        .kk-input[readonly] {
            background: #f5f7fb;
            color: #9aa0b4;
        }

        .kk-check-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .kk-check {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            color: #1a1d2e;
            cursor: pointer;
        }

        .kk-check input {
            width: 15px;
            height: 15px;
            accent-color: #1d2448;
            cursor: pointer;
        }

        .kk-org-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kk-org-table th {
            background: #f0f2f8;
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 8px 12px;
            border: 1px solid #e2e5ef;
        }

        .kk-org-table td {
            padding: 6px 8px;
            border: 1px solid #e2e5ef;
        }

        .kk-org-table td input {
            width: 100%;
            border: none;
            outline: none;
            font-family: 'Poppins', sans-serif;
            font-size: 12.5px;
            color: #1a1d2e;
            background: transparent;
            padding: 4px;
        }

        .kk-section-note {
            font-size: 11.5px;
            color: #9aa0b4;
            margin-bottom: 12px;
        }

        @media(max-width:700px) {

            .kk-grid-2,
            .kk-grid-3,
            .kk-grid-4 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'sk';
    $active    = 'profiling';
    $pageTitle = ($editMode ?? false) ? 'Edit Youth Profile' : 'Add Youth Profile';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $y       = $youth ?? [];
    $edit    = $editMode ?? false;
    $action  = $edit ? '/sk/profiling/update/' . ($y['id'] ?? '') : '/sk/profiling/store';

    // Decode JSON fields for edit mode
    $orgs    = $edit && ! empty($y['organizations'])   ? json_decode($y['organizations'],   true) : [[], [], [], []];
    $health  = $edit && ! empty($y['health_concerns']) ? json_decode($y['health_concerns'], true) : [];
    $social  = $edit && ! empty($y['social_inclusion']) ? json_decode($y['social_inclusion'], true) : [];
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div style="display:flex;align-items:center;gap:14px;margin-bottom:22px;">
                <a href="/sk/profiling" class="db-btn db-btn--outline" style="padding:7px 14px;font-size:13px;">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div>
                    <h2 style="font-size:16px;font-weight:700;color:#1d2448;margin:0;">
                        <?= $edit ? 'Edit Youth Profile' : 'New Youth Profile' ?>
                    </h2>
                    <p style="font-size:12px;color:#9aa0b4;margin:0;">KK Profiling Form — LYDO Form 1</p>
                </div>
            </div>

            <form action="<?= $action ?>" method="post" id="kkForm">
                <?= csrf_field() ?>

                <!-- ── Section 1: Personal Information ── -->
                <div class="kk-card">
                    <div class="kk-card-header"><i class="fas fa-user"></i>
                        <h4>Section 1 — Personal Information</h4>
                    </div>
                    <div class="kk-card-body">
                        <div class="kk-grid-4">
                            <div><label class="kk-label">Last Name *</label><input type="text" class="kk-input" name="last_name" value="<?= esc($y['last_name'] ?? '') ?>" placeholder="DELA CRUZ" required></div>
                            <div><label class="kk-label">First Name *</label><input type="text" class="kk-input" name="first_name" value="<?= esc($y['first_name'] ?? '') ?>" placeholder="JUAN" required></div>
                            <div><label class="kk-label">Middle Name</label><input type="text" class="kk-input" name="middle_name" value="<?= esc($y['middle_name'] ?? '') ?>" placeholder="SANTOS"></div>
                            <div><label class="kk-label">Suffix</label>
                                <select class="kk-input" name="suffix">
                                    <option value="">— None —</option>
                                    <?php foreach (['Jr', 'Sr', 'II', 'III', 'IV'] as $s): ?>
                                        <option <?= ($y['suffix'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="kk-grid-3">
                            <div><label class="kk-label">Date of Birth *</label><input type="date" class="kk-input" name="date_of_birth" id="dob" value="<?= esc($y['date_of_birth'] ?? '') ?>" oninput="calcAge()" required></div>
                            <div><label class="kk-label">Age (auto)</label><input type="number" class="kk-input" id="ageOut" readonly value="<?= isset($y['age']) ? $y['age'] : '' ?>" placeholder="—"></div>
                            <div><label class="kk-label">Sex *</label>
                                <select class="kk-input" name="gender" required>
                                    <option value="">— Select —</option>
                                    <option value="Male" <?= ($y['gender'] ?? '') === 'Male'   ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= ($y['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="kk-grid-3">
                            <div><label class="kk-label">Place of Birth</label><input type="text" class="kk-input" name="place_of_birth" value="<?= esc($y['place_of_birth'] ?? '') ?>" placeholder="Bato, Camarines Sur"></div>
                            <div><label class="kk-label">Religion</label><input type="text" class="kk-input" name="religion" value="<?= esc($y['religion'] ?? '') ?>" placeholder="Roman Catholic"></div>
                            <div><label class="kk-label">Citizenship</label><input type="text" class="kk-input" name="citizenship" value="<?= esc($y['citizenship'] ?? 'Filipino') ?>"></div>
                        </div>
                        <div class="kk-grid-2">
                            <div><label class="kk-label">Contact Number</label><input type="text" class="kk-input" name="contact_number" value="<?= esc($y['contact_number'] ?? '') ?>" placeholder="09XXXXXXXXX"></div>
                            <div><label class="kk-label">Email Address</label><input type="email" class="kk-input" name="email" value="<?= esc($y['email'] ?? '') ?>" placeholder="email@example.com"></div>
                        </div>
                        <div class="kk-full"><label class="kk-label">Complete Address</label><input type="text" class="kk-input" name="address" value="<?= esc($y['address'] ?? '') ?>" placeholder="House No., Street, Barangay, Municipality, Province"></div>
                        <div class="kk-grid-2">
                            <div><label class="kk-label">Zone / Purok</label>
                                <select class="kk-input" name="zone">
                                    <option value="">— Select —</option>
                                    <?php foreach (['Zone 1', 'Zone 2', 'Zone 3', 'Zone 4', 'Zone 5', 'Zone 6', 'Zone 7'] as $z): ?>
                                        <option <?= ($y['zone'] ?? '') === $z ? 'selected' : '' ?>><?= $z ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div><label class="kk-label">No. of Months/Years in Brgy.</label><input type="text" class="kk-input" name="months_in_brgy" value="<?= esc($y['months_in_brgy'] ?? '') ?>" placeholder="e.g. 5 years"></div>
                        </div>
                        <div class="kk-grid-2">
                            <div><label class="kk-label">Talent / Skills</label><input type="text" class="kk-input" name="skills" value="<?= esc($y['skills'] ?? '') ?>" placeholder="e.g. Drawing, Singing"></div>
                            <div><label class="kk-label">Interests / Hobbies</label><input type="text" class="kk-input" name="hobbies" value="<?= esc($y['hobbies'] ?? '') ?>" placeholder="e.g. Reading, Sports"></div>
                        </div>
                        <div class="kk-grid-2">
                            <div><label class="kk-label">Mother's Maiden Name</label><input type="text" class="kk-input" name="mother_name" value="<?= esc($y['mother_name'] ?? '') ?>"></div>
                            <div><label class="kk-label">Mother's Occupation</label><input type="text" class="kk-input" name="mother_occupation" value="<?= esc($y['mother_occupation'] ?? '') ?>"></div>
                        </div>
                        <div class="kk-grid-2">
                            <div><label class="kk-label">Father's Name</label><input type="text" class="kk-input" name="father_name" value="<?= esc($y['father_name'] ?? '') ?>"></div>
                            <div><label class="kk-label">Father's Occupation</label><input type="text" class="kk-input" name="father_occupation" value="<?= esc($y['father_occupation'] ?? '') ?>"></div>
                        </div>
                    </div>
                </div>

                <!-- ── Section 2: Organization Membership ── -->
                <div class="kk-card">
                    <div class="kk-card-header"><i class="fas fa-sitemap"></i>
                        <h4>Section 2 — Membership in Organization</h4>
                    </div>
                    <div class="kk-card-body">
                        <table class="kk-org-table">
                            <thead>
                                <tr>
                                    <th>Name of Organization</th>
                                    <th>Position</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($r = 0; $r < 4; $r++): ?>
                                    <tr>
                                        <td><input type="text" name="org_name[]" value="<?= esc($orgs[$r]['name']     ?? '') ?>" placeholder="Organization name"></td>
                                        <td><input type="text" name="org_position[]" value="<?= esc($orgs[$r]['position'] ?? '') ?>" placeholder="Position held"></td>
                                        <td><input type="text" name="org_year[]" value="<?= esc($orgs[$r]['year']     ?? '') ?>" placeholder="Year"></td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ── Section 3 & 4: Age Group & Civil Status ── -->
                <div class="kk-card">
                    <div class="kk-card-header"><i class="fas fa-id-card"></i>
                        <h4>Section 3 & 4 — Age Group & Civil Status</h4>
                    </div>
                    <div class="kk-card-body">
                        <div class="kk-grid-2">
                            <div>
                                <label class="kk-label">Age Group</label>
                                <select class="kk-input" name="age_group">
                                    <option value="">— Auto from DOB —</option>
                                    <?php foreach (['15-17' => 'Child Youth (15–17)', '18-21' => '18–21 y/o', '22-24' => '22–24 y/o', '25-30' => 'Adult Youth (25–30)'] as $v => $l): ?>
                                        <option value="<?= $v ?>" <?= ($y['age_group'] ?? '') === $v ? 'selected' : '' ?>><?= $l ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="kk-label">Civil Status</label>
                                <select class="kk-input" name="civil_status">
                                    <option value="">— Select —</option>
                                    <?php foreach (['Single', 'Married', 'With live-in partner', 'Teenage Mom/Dad', 'Solo Parent'] as $cs): ?>
                                        <option <?= ($y['civil_status'] ?? '') === $cs ? 'selected' : '' ?>><?= $cs ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Section 5: Educational Background ── -->
                <div class="kk-card">
                    <div class="kk-card-header"><i class="fas fa-graduation-cap"></i>
                        <h4>Section 5 — Educational Background</h4>
                    </div>
                    <div class="kk-card-body">
                        <div class="kk-grid-2">
                            <div>
                                <label class="kk-label">Educational Background</label>
                                <select class="kk-input" name="educational_background">
                                    <option value="">— Select —</option>
                                    <?php foreach (['Junior High School', 'Senior High School', 'Technical/Vocational', 'College', 'Out-of-School Youth', 'Alternative Learning System', 'Young Professional'] as $e): ?>
                                        <option <?= ($y['educational_background'] ?? '') === $e ? 'selected' : '' ?>><?= $e ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="kk-label">School Type</label>
                                <select class="kk-input" name="school_type">
                                    <option value="">— Select —</option>
                                    <option value="Public School" <?= ($y['school_type'] ?? '') === 'Public School'  ? 'selected' : '' ?>>Public School</option>
                                    <option value="Private School" <?= ($y['school_type'] ?? '') === 'Private School' ? 'selected' : '' ?>>Private School</option>
                                </select>
                            </div>
                        </div>
                        <div class="kk-full"><label class="kk-label">Grade Level / Year Level / Course / Specialization</label><input type="text" class="kk-input" name="school_detail" value="<?= esc($y['school_detail'] ?? '') ?>" placeholder="e.g. Grade 11 / 2nd Year / BS Nursing"></div>
                    </div>
                </div>

                <!-- ── Section 6 & 9: Governance & Economic Status ── -->
                <div class="kk-card">
                    <div class="kk-card-header"><i class="fas fa-briefcase"></i>
                        <h4>Section 6 & 9 — Governance & Economic Status</h4>
                    </div>
                    <div class="kk-card-body">
                        <div class="kk-grid-3">
                            <div>
                                <label class="kk-label">Governance</label>
                                <select class="kk-input" name="governance">
                                    <option value="">— Select —</option>
                                    <option value="COMELEC Registered" <?= ($y['governance'] ?? '') === 'COMELEC Registered'     ? 'selected' : '' ?>>COMELEC Registered</option>
                                    <option value="COMELEC Non-Registered" <?= ($y['governance'] ?? '') === 'COMELEC Non-Registered' ? 'selected' : '' ?>>COMELEC Non-Registered</option>
                                </select>
                            </div>
                            <div>
                                <label class="kk-label">Economic Status</label>
                                <select class="kk-input" name="economic_status">
                                    <option value="">— Select —</option>
                                    <?php foreach (['Student', 'Employed', 'Unemployed', 'Out-of-School', 'Self-Employed'] as $es): ?>
                                        <option <?= ($y['economic_status'] ?? '') === $es ? 'selected' : '' ?>><?= $es ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="kk-label">Monthly Income</label>
                                <select class="kk-input" name="monthly_income">
                                    <option value="">— Select —</option>
                                    <?php foreach (['Below ₱5,000', '₱5,000 – ₱10,000', '₱10,000 – ₱20,000', '₱20,000 – ₱40,000', 'Above ₱40,000'] as $inc): ?>
                                        <option <?= ($y['monthly_income'] ?? '') === $inc ? 'selected' : '' ?>><?= $inc ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Section 7 & 8: Health & Social Inclusion ── -->
                <div class="kk-card">
                    <div class="kk-card-header"><i class="fas fa-heartbeat"></i>
                        <h4>Section 7 & 8 — Health Concerns & Social Inclusion</h4>
                    </div>
                    <div class="kk-card-body">
                        <label class="kk-label" style="margin-bottom:10px;">Physical & Mental Health (check all that apply)</label>
                        <div class="kk-check-row" style="margin-bottom:20px;">
                            <?php foreach (['Engage in Smoking', 'Engage in Alcohol', 'Experience Depression', 'Attempt Suicide', 'Health Problem', 'HIV/AIDS'] as $h): ?>
                                <label class="kk-check">
                                    <input type="checkbox" name="health[]" value="<?= $h ?>" <?= in_array($h, $health) ? 'checked' : '' ?>>
                                    <?= $h ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <label class="kk-label" style="margin-bottom:10px;">Social Inclusion & Equity (check all that apply)</label>
                        <div class="kk-check-row">
                            <?php foreach (['4Ps Beneficiary', 'UCT Beneficiary', 'IP', 'PWD'] as $s): ?>
                                <label class="kk-check">
                                    <input type="checkbox" name="social[]" value="<?= $s ?>" <?= in_array($s, $social) ? 'checked' : '' ?>>
                                    <?= $s ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- ── Section 10–12: Advocacy, Volunteer, Issues ── -->
                <div class="kk-card">
                    <div class="kk-card-header"><i class="fas fa-hands-helping"></i>
                        <h4>Section 10–12 — Advocacy, Volunteer & Issues</h4>
                    </div>
                    <div class="kk-card-body">
                        <div class="kk-grid-2">
                            <div><label class="kk-label">Center of Youth Participation / Advocacy</label><input type="text" class="kk-input" name="advocacy" value="<?= esc($y['advocacy'] ?? '') ?>" placeholder="e.g. Education, Sports"></div>
                            <div><label class="kk-label">Volunteer Interests</label><input type="text" class="kk-input" name="volunteer" value="<?= esc($y['volunteer'] ?? '') ?>" placeholder="e.g. SK Activities, Barangay Events"></div>
                        </div>
                        <div class="kk-grid-3">
                            <div><label class="kk-label">Issue / Concern #1</label><input type="text" class="kk-input" name="issue_1" value="<?= esc($y['issue_1'] ?? '') ?>" placeholder="e.g. Unemployment"></div>
                            <div><label class="kk-label">Issue / Concern #2</label><input type="text" class="kk-input" name="issue_2" value="<?= esc($y['issue_2'] ?? '') ?>" placeholder="e.g. Drug Abuse"></div>
                            <div><label class="kk-label">Issue / Concern #3</label><input type="text" class="kk-input" name="issue_3" value="<?= esc($y['issue_3'] ?? '') ?>" placeholder="e.g. Lack of Programs"></div>
                        </div>
                        <div class="kk-full">
                            <label class="kk-label">Suggested Programs / Projects / Activities</label>
                            <textarea class="kk-input" name="suggestions" rows="3" placeholder="Describe your suggestions..."><?= esc($y['suggestions'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Footer buttons -->
                <div style="display:flex;justify-content:flex-end;gap:12px;margin-bottom:32px;">
                    <a href="/sk/profiling" class="db-btn db-btn--outline">Cancel</a>
                    <button type="submit" class="db-btn db-btn--primary">
                        <i class="fas fa-save"></i> <?= $edit ? 'Update Profile' : 'Save Profile' ?>
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function calcAge() {
            const dob = document.getElementById('dob').value;
            if (!dob) {
                document.getElementById('ageOut').value = '';
                return;
            }
            const today = new Date();
            const birth = new Date(dob);
            let age = today.getFullYear() - birth.getFullYear();
            const m = today.getMonth() - birth.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
            document.getElementById('ageOut').value = age >= 0 ? age : '';
        }
        calcAge(); // run on load for edit mode

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>