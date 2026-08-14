<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Household Census — Add Record - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role      = $role ?? 'secretary';
    $active    = 'census';
    $pageTitle = 'Add Household Record';
    include(APPPATH . 'Views/dashboard/sidebar.php');
    ?>

    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div class="db-page-header" style="margin-bottom:12px;">
                <h2>Add Household Record</h2>
                <p>Fill in the household census form. This replaces the old modal with a full page layout for easier data entry.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="db-alert db-alert--error" style="margin-bottom:18px;"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="ca-card" style="padding:0;border-radius:12px;overflow:hidden;">
                <form action="/<?= session()->get('role') ?>/census/store" method="post" id="censusForm">

                    <div style="padding:20px;">
                        <?= csrf_field() ?>

                        <div style="display:flex;gap:18px;align-items:center;margin-bottom:12px;">
                            <div style="width:72px;height:72px;border-radius:8px;background:linear-gradient(135deg,#1d2448,#2e3a6e);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:20px;">PG</div>
                            <div>
                                <div style="font-weight:700;color:#1d2448;font-size:14px;">HOUSEHOLD CENSUS REGISTRATION</div>
                                <div style="color:#9aa0b4;font-size:13px;">Barangay Bacolod — Household Registration Form</div>
                            </div>
                            <div style="margin-left:auto;"><a href="/<?= session()->get('role') ?>/census" class="db-btn db-btn--outline"><i class="fas fa-arrow-left"></i> Back</a></div>
                        </div>

                        <!-- We'll reuse the same markup as the modal but as a full page. For brevity only key sections are included here. -->

                        <!-- Personal Information (Head) -->
                        <div style="border-top:1px solid #eef2fb;padding-top:18px;">
                            <h4 style="margin:0 0 12px 0;color:#1d2448;">1 — Household Head (Personal Information)</h4>
                            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
                                <div>
                                    <label class="pf-field-label">Last Name</label>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="last_name" required>
                                </div>
                                <div>
                                    <label class="pf-field-label">First Name</label>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="first_name" required>
                                </div>
                                <div>
                                    <label class="pf-field-label">Middle Name</label>
                                    <input type="text" class="pf-input pf-upper pf-alpha" name="middle_name">
                                </div>
                                <div>
                                    <label class="pf-field-label">Suffix</label>
                                    <select class="pf-input" name="suffix">
                                        <option value="">— NONE —</option>
                                        <option>Jr</option>
                                        <option>Sr</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Classification -->
                        <div style="margin-top:18px;border-top:1px solid #eef2fb;padding-top:18px;">
                            <h4 style="margin:0 0 12px 0;color:#1d2448;">2 — Household Classification</h4>
                            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;align-items:center;">
                                <div>
                                    <label class="pf-field-label">Household No. (AUTO)</label>
                                    <input type="text" class="pf-input" name="household_no" id="householdNo" readonly style="background:#f0f4ff;font-weight:700;">
                                </div>
                                <div>
                                    <label class="pf-field-label">Zone / Purok</label>
                                    <select class="pf-input" name="zone">
                                        <option value="">— Select —</option><?php for ($z = 1; $z <= 7; $z++) echo "<option>Zone $z</option>"; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="pf-field-label">Years of Residency</label>
                                    <input type="number" class="pf-input" name="years_of_residency" value="0" min="0">
                                </div>
                                <div>
                                    <label class="pf-field-label">House Ownership</label>
                                    <select class="pf-input" name="house_ownership">
                                        <option>Owned</option>
                                        <option>Rented</option>
                                        <option>Shared</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Family Info (simplified) -->
                        <div style="margin-top:18px;border-top:1px solid #eef2fb;padding-top:18px;">
                            <h4 style="margin:0 0 12px 0;color:#1d2448;">3 — Family Information</h4>
                            <div id="familyRows">
                                <p style="color:#9aa0b4;margin:0 0 8px 0;">Add spouse, children and other household members below.</p>
                                <button type="button" class="db-btn db-btn--outline" onclick="addChildRow()"><i class="fas fa-plus"></i> Add Child</button>
                            </div>
                        </div>

                        <div style="margin-top:20px;display:flex;gap:12px;">
                            <a href="/<?= session()->get('role') ?>/census" class="db-btn db-btn--outline">Cancel</a>
                            <button type="submit" class="db-btn db-btn--primary"><i class="fas fa-save"></i> Save Record</button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        // Initialize household number and other helpers used in the form
        (function() {
            const hhNoEl = document.getElementById('householdNo');
            if (hhNoEl) hhNoEl.value = String(Math.floor(10000 + Math.random() * 90000));
        })();

        function addChildRow() {
            const wrap = document.getElementById('familyRows');
            const div = document.createElement('div');
            div.style.marginTop = '10px';
            div.innerHTML = `
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;align-items:center;">
                    <input type="text" name="child_last_name[]" placeholder="Last name" class="pf-input pf-upper pf-alpha">
                    <input type="text" name="child_first_name[]" placeholder="First name" class="pf-input pf-upper pf-alpha">
                    <input type="date" name="child_dob[]" class="pf-input">
                    <select name="child_gender[]" class="pf-input"><option value="">—Select—</option><option>Male</option><option>Female</option></select>
                </div>`;
            wrap.appendChild(div);
        }
    </script>
</body>

</html>