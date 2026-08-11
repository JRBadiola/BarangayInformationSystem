<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treasurer Dashboard - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role      = 'treasurer';
    $active    = 'dashboard';
    $pageTitle = 'Treasurer Dashboard';
    include(APPPATH . 'Views/dashboard/sidebar.php');
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div class="db-welcome">
                <div>
                    <h2>Welcome back, <?= esc(session()->get('username') ?? 'Treasurer') ?> 👋</h2>
                    <p>Barangay Bacolod, Bato, Camarines Sur — Barangay Information System</p>
                </div>
                <div class="db-welcome-icon"><i class="fas fa-coins"></i></div>
            </div>

            <div class="db-stats">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,0.15);color:#16c79a;">
                        <i class="fas fa-peso-sign"></i>
                    </div>
                    <div>
                        <span class="db-stat-num">₱24,500</span>
                        <span class="db-stat-label">Total Collections</span>
                    </div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div>
                        <span class="db-stat-num">89</span>
                        <span class="db-stat-label">Clearance Fees Paid</span>
                    </div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,0.15);color:#ffc107;">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div>
                        <span class="db-stat-num">12</span>
                        <span class="db-stat-label">Unpaid Requests</span>
                    </div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(220,53,69,0.15);color:#dc3545;">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <span class="db-stat-num">₱3,200</span>
                        <span class="db-stat-label">This Month</span>
                    </div>
                </div>
            </div>

            <h3 class="db-section-title">Modules</h3>
            <div class="db-modules">
                <a href="/treasurer/payments" class="db-module-card">
                    <div class="db-module-icon"><i class="fas fa-coins"></i></div>
                    <h4>Fees & Payments</h4>
                    <p>Record and track clearance fees and other barangay payments.</p>
                </a>
                <a href="/treasurer/clearance" class="db-module-card">
                    <div class="db-module-icon"><i class="fas fa-file-invoice"></i></div>
                    <h4>Clearance Fees</h4>
                    <p>Manage fee collection for barangay clearance documents.</p>
                </a>
                <a href="/treasurer/reports" class="db-module-card">
                    <div class="db-module-icon"><i class="fas fa-chart-pie"></i></div>
                    <h4>Financial Reports</h4>
                    <p>Generate monthly and annual financial summaries.</p>
                </a>
            </div>

            <h3 class="db-section-title">Recent Transactions</h3>
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Resident</th>
                            <th>Document</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>001</td>
                            <td>Juan Dela Cruz</td>
                            <td>Barangay Clearance</td>
                            <td>₱50.00</td>
                            <td>Mar 17, 2026</td>
                            <td><span class="db-badge db-badge--approved">Paid</span></td>
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>Maria Santos</td>
                            <td>Certificate of Residency</td>
                            <td>₱30.00</td>
                            <td>Mar 16, 2026</td>
                            <td><span class="db-badge db-badge--approved">Paid</span></td>
                        </tr>
                        <tr>
                            <td>003</td>
                            <td>Pedro Reyes</td>
                            <td>Business Permit</td>
                            <td>₱200.00</td>
                            <td>Mar 15, 2026</td>
                            <td><span class="db-badge db-badge--pending">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script>
        document.querySelectorAll('.db-nav-item').forEach(item => {
            item.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'));
        });
    </script>
</body>

</html>