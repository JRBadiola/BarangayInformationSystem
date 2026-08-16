<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Blotter - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .bl-wrap {
            max-width: 760px;
        }

        .bl-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29, 36, 72, .07);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .bl-header {
            background: linear-gradient(135deg, #c0392b, #922b21);
            padding: 20px 28px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .bl-header-icon {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, .15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            flex-shrink: 0;
        }

        .bl-header h3 {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 2px;
        }

        .bl-header p {
            color: rgba(255, 255, 255, .65);
            font-size: 12px;
            margin: 0;
        }

        .bl-body {
            padding: 24px 28px;
        }

        .bl-section {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #9aa0b4;
            margin: 0 0 10px;
        }

        .bl-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .bl-row.full {
            grid-template-columns: 1fr;
        }

        .bl-group {
            margin-bottom: 0;
        }

        .bl-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #4a5068;
            margin-bottom: 5px;
        }

        .bl-group label span.req {
            color: #e74c3c;
        }

        .bl-group input,
        .bl-group select,
        .bl-group textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #e2e5ef;
            border-radius: 8px;
            font-size: 13.5px;
            font-family: 'Poppins', sans-serif;
            color: #1a1d2e;
            outline: none;
            transition: border-color .2s;
            box-sizing: border-box;
        }

        .bl-group input:focus,
        .bl-group select:focus,
        .bl-group textarea:focus {
            border-color: #c0392b;
            box-shadow: 0 0 0 3px rgba(192, 57, 43, .08);
        }

        .bl-group textarea {
            resize: vertical;
            min-height: 88px;
        }

        .bl-divider {
            border: none;
            border-top: 1px solid #f0f2f8;
            margin: 18px 0;
        }

        .bl-appt-box {
            background: #f5f7ff;
            border: 1px solid #dde2f5;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .bl-appt-box p {
            font-size: 12px;
            color: #4a5068;
            margin: 0 0 10px;
        }

        .bl-submit {
            width: 100%;
            padding: 12px;
            background: #c0392b;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .bl-submit:hover {
            background: #a93226;
        }

        @media(max-width:600px) {
            .bl-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'sk';
    $active    = 'blotter';
    $pageTitle = 'File Blotter Report';
    include(APPPATH . 'Views/dashboard/sidebar.php');
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="db-alert db-alert--success" style="margin-bottom:16px;">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('blotter_error')): ?>
                <div class="db-alert db-alert--danger" style="margin-bottom:16px;">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('blotter_error') ?>
                </div>
            <?php endif; ?>

            <div class="bl-wrap">

                <!-- Info notice -->
                <div style="background:#f0f2ff;border:1.5px solid #c9d0f5;border-radius:12px;padding:14px 18px;margin-bottom:22px;display:flex;gap:12px;align-items:flex-start;">
                    <i class="fas fa-info-circle" style="color:#5b6fd6;font-size:16px;margin-top:2px;flex-shrink:0;"></i>
                    <div>
                        <div style="font-size:13px;font-weight:600;color:#1a1d2e;margin-bottom:2px;">About Blotter Reports</div>
                        <div style="font-size:12.5px;color:#6b7280;line-height:1.6;">
                            File an official incident report with the Barangay. The Captain and Secretary will review your report and may schedule a hearing under the <em>Katarungang Pambarangay Law (RA 7160)</em>.
                        </div>
                    </div>
                </div>

                <!-- Blotter form card -->
                <div class="bl-card">
                    <div class="bl-header">
                        <div class="bl-header-icon"><i class="fas fa-file-signature"></i></div>
                        <div>
                            <h3>File a Blotter Report</h3>
                            <p>Barangay Bacolod — Official Incident Record</p>
                        </div>
                    </div>
                    <div class="bl-body">
                        <form action="/sk/blotter/store" method="post" id="blotterForm">
                            <?= csrf_field() ?>

                            <!-- Complainant -->
                            <p class="bl-section">Complainant Information</p>
                            <div class="bl-row">
                                <div class="bl-group">
                                    <label>Last Name <span class="req">*</span></label>
                                    <input type="text" name="complainant_last_name"
                                        value="<?= esc(session()->get('last_name') ?? '') ?>"
                                        placeholder="Last name" required>
                                </div>
                                <div class="bl-group">
                                    <label>First Name <span class="req">*</span></label>
                                    <input type="text" name="complainant_first_name"
                                        value="<?= esc(session()->get('first_name') ?? '') ?>"
                                        placeholder="First name" required>
                                </div>
                            </div>
                            <div class="bl-row">
                                <div class="bl-group">
                                    <label>Middle Name <span style="font-size:11px;color:#b0b6cc;font-weight:400;">(optional)</span></label>
                                    <input type="text" name="complainant_middle_name" placeholder="Middle name">
                                </div>
                                <div class="bl-group">
                                    <label>Contact Number <span class="req">*</span></label>
                                    <input type="text" name="contact_number" placeholder="09XX-XXX-XXXX" required>
                                </div>
                            </div>
                            <div class="bl-row full">
                                <div class="bl-group">
                                    <label>Email Address <span class="req">*</span></label>
                                    <input type="email" name="complainant_email"
                                        value="<?= esc(session()->get('email') ?? '') ?>"
                                        placeholder="your@email.com" required>
                                </div>
                            </div>

                            <hr class="bl-divider">

                            <!-- Incident -->
                            <p class="bl-section">Incident Details</p>
                            <div class="bl-row full">
                                <div class="bl-group">
                                    <label>Respondent Name <span class="req">*</span></label>
                                    <input type="text" name="respondent_name" placeholder="Full name of the person being reported" required>
                                </div>
                            </div>
                            <div class="bl-row">
                                <div class="bl-group">
                                    <label>Incident Type <span class="req">*</span></label>
                                    <select name="incident_type" required>
                                        <option value="" disabled selected>Select type</option>
                                        <option>Dispute</option>
                                        <option>Physical Assault</option>
                                        <option>Verbal Abuse</option>
                                        <option>Theft</option>
                                        <option>Trespassing</option>
                                        <option>Noise Complaint</option>
                                        <option>Domestic Violence</option>
                                        <option>Cyberbullying</option>
                                        <option>Harassment</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="bl-group">
                                    <label>Incident Date</label>
                                    <input type="date" name="incident_date" max="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="bl-row full">
                                <div class="bl-group">
                                    <label>Incident Description <span class="req">*</span></label>
                                    <textarea name="narrative" rows="4" placeholder="Describe what happened in detail…" required></textarea>
                                </div>
                            </div>

                            <hr class="bl-divider">

                            <!-- Appointment -->
                            <p class="bl-section">Appointment Scheduling <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#b0b6cc;">(optional)</span></p>
                            <div class="bl-appt-box">
                                <p><i class="fas fa-calendar-check" style="color:#5b6fd6;margin-right:6px;"></i>Optionally request a hearing appointment with the Barangay Captain.</p>
                                <div class="bl-row">
                                    <div class="bl-group">
                                        <label>Preferred Date</label>
                                        <input type="date" name="appointment_date" id="appointmentDate"
                                            min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                                    </div>
                                    <div class="bl-group">
                                        <label>Preferred Time</label>
                                        <input type="time" name="appointment_time" min="08:00" max="17:00">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="bl-submit">
                                <i class="fas fa-paper-plane"></i> Submit Blotter Report
                            </button>
                        </form>
                    </div>
                </div>

            </div><!-- /.bl-wrap -->
        </div>
    </div>

    <script>
        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>