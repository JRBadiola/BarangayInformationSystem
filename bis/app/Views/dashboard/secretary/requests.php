<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Requests - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php $role = 'secretary';
    $active = 'requests';
    $pageTitle = 'Document Requests';
    include(APPPATH . 'Views/dashboard/sidebar.php'); ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">
            <div class="db-stats" style="margin-bottom:24px;">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,0.15);color:#ffc107;"><i class="fas fa-inbox"></i></div>
                    <div><span class="db-stat-num">18</span><span class="db-stat-label">New Requests</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-spinner"></i></div>
                    <div><span class="db-stat-num">9</span><span class="db-stat-label">In Progress</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,0.15);color:#16c79a;"><i class="fas fa-check-circle"></i></div>
                    <div><span class="db-stat-num">142</span><span class="db-stat-label">Completed Today</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(220,53,69,0.15);color:#dc3545;"><i class="fas fa-clock"></i></div>
                    <div><span class="db-stat-num">5</span><span class="db-stat-label">Overdue</span></div>
                </div>
            </div>
            <div class="db-toolbar">
                <div class="db-search-wrap"><i class="fas fa-search"></i><input type="text" placeholder="Search requests..."></div>
                <div class="db-toolbar-actions">
                    <select class="db-filter-select">
                        <option>All Types</option>
                        <option>Barangay Clearance</option>
                        <option>Certificate of Residency</option>
                        <option>Certificate of Indigency</option>
                        <option>Business Permit</option>
                    </select>
                </div>
            </div>
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Resident</th>
                            <th>Document</th>
                            <th>Contact</th>
                            <th>Submitted</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $reqs = [
                            ['001', 'Ana Gomez', 'Barangay Clearance', '09451234567', 'Mar 17, 2026', 'High', 'New'],
                            ['002', 'Carlos Lim', 'Certificate of Residency', '09561234567', 'Mar 17, 2026', 'Normal', 'New'],
                            ['003', 'Rosa Bautista', 'Certificate of Indigency', '09671234567', 'Mar 16, 2026', 'High', 'In Progress'],
                            ['004', 'Jose Ramos', 'Business Permit', '09781234567', 'Mar 15, 2026', 'Normal', 'In Progress'],
                            ['005', 'Liza Cruz', 'Barangay Clearance', '09891234567', 'Mar 14, 2026', 'Normal', 'Completed'],
                            ['006', 'Ben Torres', 'Certificate of Residency', '09901234567', 'Mar 13, 2026', 'Low', 'Completed'],
                        ];
                        $bm = ['New' => 'db-badge--pending', 'In Progress' => 'db-badge--pending', 'Completed' => 'db-badge--approved', 'Overdue' => 'db-badge--rejected'];
                        $pm = ['High' => 'db-badge--rejected', 'Normal' => 'db-badge--pending', 'Low' => 'db-badge--approved'];
                        foreach ($reqs as $r): ?>
                            <tr>
                                <td><?= $r[0] ?></td>
                                <td>
                                    <div class="db-resident-name">
                                        <div class="db-avatar-sm"><?= strtoupper($r[1][0]) ?></div><?= $r[1] ?>
                                    </div>
                                </td>
                                <td><?= $r[2] ?></td>
                                <td><?= $r[3] ?></td>
                                <td><?= $r[4] ?></td>
                                <td><span class="db-badge <?= $pm[$r[5]] ?>"><?= $r[5] ?></span></td>
                                <td><span class="db-badge <?= $bm[$r[6]] ?>"><?= $r[6] ?></span></td>
                                <td>
                                    <div class="db-action-group">
                                        <button class="db-icon-btn db-icon-btn--view"><i class="fas fa-eye"></i></button>
                                        <button class="db-icon-btn db-icon-btn--edit"><i class="fas fa-edit"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.db-nav-item').forEach(i => i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open')));
    </script>
</body>

</html>