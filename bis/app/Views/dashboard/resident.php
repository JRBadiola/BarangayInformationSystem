 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Resident Dashboard - Bacolod BIS</title>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
     <link rel="stylesheet" href="/style.css">
     <style>
         /* ── Service Cards ── */
         .svc-grid {
             display: grid;
             grid-template-columns: repeat(3, 1fr);
             gap: 20px;
             margin-bottom: 32px;
         }

         .svc-card {
             background: #fff;
             border: 1.5px solid #e8ecf4;
             border-radius: 16px;
             padding: 32px 24px 24px;
             display: flex;
             flex-direction: column;
             align-items: center;
             text-align: center;
             transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
             cursor: default;
         }

         .svc-card:hover {
             border-color: #1d2448;
             box-shadow: 0 6px 24px rgba(29, 36, 72, 0.1);
             transform: translateY(-2px);
         }

         .svc-card.active-card {
             border-color: #1d2448;
             box-shadow: 0 4px 20px rgba(29, 36, 72, 0.12);
         }

         .svc-icon-wrap {
             width: 64px;
             height: 64px;
             border-radius: 50%;
             background: #1d2448;
             color: #fff;
             display: flex;
             align-items: center;
             justify-content: center;
             font-size: 26px;
             margin-bottom: 18px;
             flex-shrink: 0;
         }

         .svc-card h4 {
             font-size: 15px;
             font-weight: 700;
             color: #1a1d2e;
             margin: 0 0 10px;
         }

         .svc-card p {
             font-size: 13px;
             color: #6b7280;
             line-height: 1.6;
             margin: 0 0 20px;
             flex: 1;
         }

         .svc-btn {
             display: inline-flex;
             align-items: center;
             gap: 6px;
             padding: 9px 20px;
             border: 1.5px solid #1d2448;
             border-radius: 8px;
             font-size: 13px;
             font-weight: 600;
             color: #1d2448;
             background: #fff;
             text-decoration: none;
             cursor: pointer;
             transition: background 0.2s, color 0.2s;
             font-family: 'Poppins', sans-serif;
         }

         .svc-btn:hover {
             background: #1d2448;
             color: #fff;
         }

         .svc-btn i {
             font-size: 12px;
         }

         /* Recent requests table section */
         .res-section-header {
             display: flex;
             align-items: center;
             justify-content: space-between;
             margin-bottom: 14px;
         }

         .form-group {
             margin-bottom: 16px;
         }

         .form-group label {
             display: block;
             font-size: 13px;
             font-weight: 600;
             color: #4a5068;
             margin-bottom: 6px;
         }

         .form-group input,
         .form-group textarea,
         .form-group select {
             width: 100%;
             padding: 10px 14px;
             border: 1.5px solid #e2e5ef;
             border-radius: 8px;
             font-size: 14px;
             font-family: 'Poppins', sans-serif;
             color: var(--text-dark);
             outline: none;
             transition: border-color .2s;
         }

         .form-group input:focus,
         .form-group textarea:focus,
         .form-group select:focus {
             border-color: var(--navy);
             box-shadow: 0 0 0 3px rgba(29, 36, 72, .07);
         }

         .form-group textarea {
             resize: vertical;
             min-height: 90px;
         }

         .form-row {
             display: grid;
             grid-template-columns: 1fr 1fr;
             gap: 14px;
         }

         .btn-submit {
             width: 100%;
             padding: 12px;
             background: var(--navy);
             color: #fff;
             border: none;
             border-radius: 8px;
             font-size: 14px;
             font-weight: 700;
             font-family: 'Poppins', sans-serif;
             cursor: pointer;
             transition: background .2s;
         }

         .btn-submit:hover {
             background: var(--navy-mid);
         }

         /* ── FADE-IN ANIMATION ── */
         .fade-in {
             opacity: 0;
             transform: translateY(24px);
             transition: opacity .6s ease, transform .6s ease;
         }

         .fade-in.visible {
             opacity: 1;
             transform: translateY(0);
         }

         @media (max-width: 900px) {
             .svc-grid {
                 grid-template-columns: 1fr;
             }
         }

         @media (min-width: 600px) and (max-width: 900px) {
             .svc-grid {
                 grid-template-columns: repeat(2, 1fr);
             }
         }

         @media(max-width:480px) {
             .stats-inner {
                 grid-template-columns: 1fr 1fr;
             }

             .form-row {
                 grid-template-columns: 1fr;
             }
         }
     </style>
 </head>

 <body class="db-body">
     <?php
        $role      = 'resident';
        $active    = 'dashboard';
        $pageTitle = 'Resident Dashboard';
        include(APPPATH . 'Views/dashboard/sidebar.php');
        ?>
     <div class="db-main">
         <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
         <div class="db-content">

             <!-- Welcome -->
             <div class="db-welcome">

                 <?php if (session()->getFlashdata('success')): ?>
                     <div class="db-alert db-alert--success" style="margin-bottom:16px;">
                         <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                     </div>
                 <?php endif; ?>
                 <?php if (session()->getFlashdata('blotter_error')): ?>
                     <div class="db-alert db-alert--error" style="margin-bottom:16px;">
                         <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('blotter_error') ?>
                     </div>
                 <?php endif; ?>
                 <div>
                     <?php
                        $firstName   = session()->get('first_name') ?? '';
                        $lastName    = session()->get('last_name')  ?? '';
                        $displayName = trim("$firstName $lastName") ?: (session()->get('username') ?? 'Resident');
                        ?>
                     <h2>Hello, <?= esc($displayName) ?> 👋</h2>
                     <p>Barangay Bacolod, Bato, Camarines Sur — Barangay Information System</p>
                 </div>
                 <div class="db-welcome-icon"><i class="fas fa-users"></i></div>
             </div>

             <!-- Stats -->
             <div class="db-stats" style="margin-bottom:32px;">
                 <?php
                    $totalRequests  = $totalRequests  ?? 0;
                    $approved       = $approved       ?? 0;
                    $pending        = $pending        ?? 0;
                    $blotterCount   = $blotterCount   ?? 0;
                    $recentRequests = $recentRequests ?? [];
                    ?>
                 <div class="db-stat-card">
                     <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;">
                         <i class="fas fa-file-alt"></i>
                     </div>
                     <div>
                         <span class="db-stat-num"><?= $totalRequests ?></span>
                         <span class="db-stat-label">My Requests</span>
                     </div>
                 </div>
                 <div class="db-stat-card">
                     <div class="db-stat-icon" style="background:rgba(22,199,154,0.15);color:#16c79a;">
                         <i class="fas fa-check-circle"></i>
                     </div>
                     <div>
                         <span class="db-stat-num"><?= $approved ?></span>
                         <span class="db-stat-label">Approved</span>
                     </div>
                 </div>
                 <div class="db-stat-card">
                     <div class="db-stat-icon" style="background:rgba(255,193,7,0.15);color:#ffc107;">
                         <i class="fas fa-clock"></i>
                     </div>
                     <div>
                         <span class="db-stat-num"><?= $pending ?></span>
                         <span class="db-stat-label">Pending</span>
                     </div>
                 </div>
                 <div class="db-stat-card">
                     <div class="db-stat-icon" style="background:rgba(220,53,69,0.15);color:#dc3545;">
                         <i class="fas fa-exclamation-circle"></i>
                     </div>
                     <div>
                         <span class="db-stat-num"><?= $blotterCount ?></span>
                         <span class="db-stat-label">Blotter Cases</span>
                     </div>
                 </div>
             </div>

             <!-- Barangay Services -->
             <h3 class="db-section-title">Barangay Services</h3>
             <div class="svc-grid">

                 <!-- Barangay Clearances -->
                 <div class="svc-card active-card">
                     <div class="svc-icon-wrap">
                         <i class="fas fa-certificate"></i>
                     </div>
                     <h4>Barangay Clearances</h4>
                     <p>Issuance of barangay clearance, certificate of indigency, or certificate of residency for residents' official transactions.</p>
                     <a href="/resident/clearance" class="svc-btn">
                         Request Now <i class="fas fa-arrow-right"></i>
                     </a>
                 </div>

                 <!-- Blotter / File Concern -->
                 <div class="svc-card">
                     <div class="svc-icon-wrap" style="background:#c0392b;">
                         <i class="fas fa-file-signature"></i>
                     </div>
                     <h4>Blotters</h4>
                     <p>Recording of incidents, complaints, or community disputes reported to the barangay for documentation and resolution.</p>
                     <button class="svc-btn" onclick="openModal('blotterModal')">
                         File Report <i class="fas fa-arrow-right"></i>
                     </button>
                 </div>

                 <!-- Raise a Concern -->
                 <div class="svc-card">
                     <div class="svc-icon-wrap" style="background:#16a085;">
                         <i class="fas fa-comments"></i>
                     </div>
                     <h4>Raise a Concern</h4>
                     <p>Submit feedback, suggestions, or concerns directly to the barangay officials for prompt attention and action.</p>
                     <button class="svc-btn" onclick="openModal('concernModal')">
                         Submit <i class="fas fa-arrow-right"></i>
                     </button>
                 </div>

             </div>

             <!-- Recent Requests -->
             <div class="res-section-header">
                 <h3 class="db-section-title" style="margin:0;">My Recent Requests</h3>
                 <a href="/resident/clearance" class="db-btn db-btn--outline db-btn--sm">View All</a>
             </div>
             <div class="db-table-wrap">
                 <table class="db-table">
                     <thead>
                         <tr>
                             <th>#</th>
                             <th>Document</th>
                             <th>For</th>
                             <th>Purpose</th>
                             <th>Date Filed</th>
                             <th>Est. Release</th>
                             <th>Status</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $totalRequests  = $totalRequests  ?? 0;
                            $approved       = $approved       ?? 0;
                            $pending        = $pending        ?? 0;
                            $blotterCount   = $blotterCount   ?? 0;
                            $recentRequests = $recentRequests ?? [];

                            $badgeMap = [
                                'pending'  => 'db-badge--pending',
                                'approved' => 'db-badge--approved',
                                'rejected' => 'db-badge--danger',
                                'released' => 'db-badge--info',
                            ];
                            if (empty($recentRequests)): ?>
                             <tr>
                                 <td colspan="7" style="text-align:center;padding:28px;color:#9aa0b4;">
                                     <i class="fas fa-file-alt" style="font-size:22px;display:block;margin-bottom:8px;color:#d0d5e8;"></i>
                                     No requests yet. <a href="/resident/clearance" style="color:#1d2448;font-weight:600;">Request a document</a> to get started.
                                 </td>
                             </tr>
                         <?php else: ?>
                             <?php foreach ($recentRequests as $r):
                                    $badgeClass = $badgeMap[$r['status']] ?? 'db-badge--pending';
                                    $label      = ucfirst($r['status']);
                                    $filed      = date('M d, Y', strtotime($r['created_at']));
                                    $estRelease = !empty($r['est_release_date'])
                                        ? date('M d, Y', strtotime($r['est_release_date']))
                                        : '—';
                                ?>
                                 <tr>
                                     <td><strong>#<?= str_pad($r['id'], 3, '0', STR_PAD_LEFT) ?></strong></td>
                                     <td><?= esc($r['document_type']) ?></td>
                                     <td style="font-size:12px;color:#6b7280;"><?= esc($r['for_member'] ?? '—') ?></td>
                                     <td><?= esc($r['purpose']) ?></td>
                                     <td><?= $filed ?></td>
                                     <td style="font-size:12px;color:#6b7280;"><?= $estRelease ?></td>
                                     <td>
                                         <span class="db-badge <?= $badgeClass ?>"><?= $label ?></span>
                                         <?php if ($r['status'] === 'rejected' && !empty($r['remarks'])): ?>
                                             <span title="<?= esc($r['remarks']) ?>" style="cursor:help;color:#dc3545;font-size:11px;display:block;margin-top:2px;">
                                                 <i class="fas fa-info-circle"></i> <?= esc(mb_strimwidth($r['remarks'], 0, 40, '…')) ?>
                                             </span>
                                         <?php endif; ?>
                                     </td>
                                 </tr>
                             <?php endforeach; ?>
                         <?php endif; ?>
                     </tbody>
                 </table>
             </div>

         </div>
     </div>

     <!-- ══ BLOTTER MODAL ══ -->
     <div class="db-modal-overlay" id="blotterModal">
         <div class="db-modal" style="max-width:580px;border-radius:14px;overflow:hidden;display:flex;flex-direction:column;max-height:90vh;">
             <!-- Header -->
             <div style="background:linear-gradient(135deg,#c0392b,#922b21);padding:20px 24px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
                 <div style="display:flex;align-items:center;gap:12px;">
                     <div style="width:40px;height:40px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;">
                         <i class="fas fa-file-signature"></i>
                     </div>
                     <div>
                         <h3 style="color:#fff;font-size:15px;font-weight:700;margin:0 0 2px;">File a Blotter Report</h3>
                         <p style="color:rgba(255,255,255,0.65);font-size:12px;margin:0;">Barangay Bacolod — Official Record</p>
                     </div>
                 </div>
                 <button class="db-modal-close" onclick="closeModal('blotterModal')" style="background:rgba(255,255,255,0.15);color:#fff;"><i class="fas fa-times"></i></button>
             </div>

             <!-- Scrollable body -->
             <div style="overflow-y:auto;padding:20px 24px 24px;flex:1;">
                 <form action="/public/blotter/store" method="post" id="blotterForm">
                     <?= csrf_field() ?>

                     <!-- ── Complainant Name ── -->
                     <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9aa0b4;margin-bottom:8px;">Complainant Information</p>
                     <div class="form-row" style="grid-template-columns:1fr 1fr;gap:10px;">
                         <div class="form-group" style="margin-bottom:10px;">
                             <label>Last Name <span style="color:#e74c3c;">*</span></label>
                             <input type="text" name="complainant_last_name" placeholder="Last name" required>
                         </div>
                         <div class="form-group" style="margin-bottom:10px;">
                             <label>First Name <span style="color:#e74c3c;">*</span></label>
                             <input type="text" name="complainant_first_name" placeholder="First name" required>
                         </div>
                     </div>
                     <div class="form-row" style="grid-template-columns:1fr 1fr;gap:10px;">
                         <div class="form-group" style="margin-bottom:10px;">
                             <label>Middle Name <span style="font-size:11px;color:#b0b6cc;font-weight:400;">(optional)</span></label>
                             <input type="text" name="complainant_middle_name" placeholder="Middle name">
                         </div>
                         <div class="form-group" style="margin-bottom:10px;">
                             <label>Contact Number <span style="color:#e74c3c;">*</span></label>
                             <input type="text" name="contact_number" placeholder="e.g. 09XX-XXX-XXXX" required>
                         </div>
                     </div>
                     <div class="form-group" style="margin-bottom:10px;">
                         <label>Email Address <span style="color:#e74c3c;">*</span></label>
                         <input type="email" name="complainant_email" placeholder="your@email.com" required>
                     </div>

                     <!-- ── Incident Details ── -->
                     <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9aa0b4;margin:14px 0 8px;">Incident Details</p>
                     <div class="form-group" style="margin-bottom:10px;">
                         <label>Respondent Name <span style="color:#e74c3c;">*</span></label>
                         <input type="text" name="respondent_name" placeholder="Name of the person being reported" required>
                     </div>
                     <div class="form-row" style="grid-template-columns:1fr 1fr;gap:10px;">
                         <div class="form-group" style="margin-bottom:10px;">
                             <label>Incident Type <span style="color:#e74c3c;">*</span></label>
                             <select name="incident_type" required>
                                 <option value="" disabled selected>Select type</option>
                                 <option value="Dispute">Dispute</option>
                                 <option value="Physical Assault">Physical Assault</option>
                                 <option value="Verbal Abuse">Verbal Abuse</option>
                                 <option value="Theft">Theft</option>
                                 <option value="Trespassing">Trespassing</option>
                                 <option value="Noise Complaint">Noise Complaint</option>
                                 <option value="Domestic Violence">Domestic Violence</option>
                                 <option value="Other">Other</option>
                             </select>
                         </div>
                         <div class="form-group" style="margin-bottom:10px;">
                             <label>Incident Date</label>
                             <input type="date" name="incident_date">
                         </div>
                     </div>
                     <div class="form-group" style="margin-bottom:10px;">
                         <label>Incident Description <span style="color:#e74c3c;">*</span></label>
                         <textarea name="narrative" rows="3" placeholder="Describe the incident in detail..." required style="resize:vertical;"></textarea>
                     </div>

                     <!-- ── Appointment Scheduling ── -->
                     <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9aa0b4;margin:14px 0 8px;">Appointment Scheduling</p>
                     <div style="background:#f5f7ff;border:1px solid #dde2f5;border-radius:10px;padding:12px 14px;margin-bottom:16px;">
                         <p style="font-size:12px;color:#4a5068;margin-bottom:10px;"><i class="fas fa-calendar-check" style="color:#5b6fd6;margin-right:6px;"></i>Optionally request an appointment with the Barangay Captain. Dates with existing events are marked and unavailable.</p>
                         <div class="form-row" style="grid-template-columns:1fr 1fr;gap:10px;">
                             <div class="form-group" style="margin-bottom:0;">
                                 <label>Preferred Date</label>
                                 <input type="date" name="appointment_date" id="appointmentDate"
                                     min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                             </div>
                             <div class="form-group" style="margin-bottom:0;">
                                 <label>Preferred Time</label>
                                 <input type="time" name="appointment_time" id="appointmentTime"
                                     min="08:00" max="17:00">
                             </div>
                         </div>
                         <div id="apptDateHint" style="margin-top:8px;font-size:12px;display:none;"></div>
                     </div>

                     <button type="submit" class="btn-submit"><i class="fas fa-paper-plane" style="margin-right:8px;"></i>Submit Blotter Report</button>
                 </form>
             </div><!-- /scrollable body -->
         </div>
     </div>

     <!-- ══ CONCERN MODAL ══ -->
     <div class="db-modal-overlay" id="concernModal">
         <div class="db-modal" style="max-width:520px;">
             <div class="db-modal-header">
                 <h3><i class="fas fa-comments"></i> Raise a Concern</h3>
                 <button class="db-modal-close" onclick="closeModal('concernModal')"><i class="fas fa-times"></i></button>
             </div>
             <div class="db-modal-body">
                 <div class="db-form-grid">
                     <div class="db-form-group db-form-group--full">
                         <label>Category</label>
                         <select>
                             <option value="">-- Select Category --</option>
                             <option>Infrastructure / Roads</option>
                             <option>Garbage / Sanitation</option>
                             <option>Street Lighting</option>
                             <option>Water Supply</option>
                             <option>Peace and Order</option>
                             <option>Barangay Services</option>
                             <option>Health and Sanitation</option>
                             <option>Suggestion / Feedback</option>
                             <option>Other</option>
                         </select>
                     </div>
                     <div class="db-form-group db-form-group--full">
                         <label>Subject</label>
                         <input type="text" placeholder="Brief subject of your concern">
                     </div>
                     <div class="db-form-group db-form-group--full">
                         <label>Details</label>
                         <textarea rows="4" placeholder="Describe your concern or suggestion in detail..."></textarea>
                     </div>
                     <div class="db-form-group db-form-group--full">
                         <label>Preferred Contact Method</label>
                         <select>
                             <option>Email</option>
                             <option>In-person at Barangay Hall</option>
                             <option>No follow-up needed</option>
                         </select>
                     </div>
                 </div>
             </div>
             <div class="db-modal-footer">
                 <button class="db-btn db-btn--outline" onclick="closeModal('concernModal')">Cancel</button>
                 <button class="db-btn db-btn--primary"><i class="fas fa-paper-plane"></i> Submit Concern</button>
             </div>
         </div>
     </div>

     <script>
         function openModal(id) {
             document.getElementById(id).classList.add('active');
         }

         function closeModal(id) {
             document.getElementById(id).classList.remove('active');
         }

         document.querySelectorAll('.db-nav-item').forEach(item => {
             item.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'));
         });
     </script>
 </body>

 </html>