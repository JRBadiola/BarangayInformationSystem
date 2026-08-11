<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Logs - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php $role = 'secretary';
    $active = 'chatbot';
    $pageTitle = 'Chatbot Logs';
    include(APPPATH . 'Views/dashboard/sidebar.php'); ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div class="db-stats" style="margin-bottom:24px;">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-comments"></i></div>
                    <div><span class="db-stat-num">342</span><span class="db-stat-label">Total Conversations</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,0.15);color:#16c79a;"><i class="fas fa-check-circle"></i></div>
                    <div><span class="db-stat-num">298</span><span class="db-stat-label">Resolved</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,0.15);color:#ffc107;"><i class="fas fa-question-circle"></i></div>
                    <div><span class="db-stat-num">44</span><span class="db-stat-label">Unanswered</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(220,53,69,0.15);color:#dc3545;"><i class="fas fa-star"></i></div>
                    <div><span class="db-stat-num">4.7</span><span class="db-stat-label">Avg. Rating</span></div>
                </div>
            </div>

            <div class="db-toolbar">
                <div class="db-search-wrap"><i class="fas fa-search"></i><input type="text" placeholder="Search conversations..."></div>
                <div class="db-toolbar-actions">
                    <select class="db-filter-select">
                        <option>All Topics</option>
                        <option>Clearance</option>
                        <option>Census</option>
                        <option>Complaints</option>
                        <option>General</option>
                    </select>
                </div>
            </div>

            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Resident</th>
                            <th>Topic</th>
                            <th>Message Preview</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $logs = [
                            ['001', 'Juan Dela Cruz', 'Clearance', 'How do I apply for barangay clearance?', 'Mar 17, 2026', 'Resolved'],
                            ['002', 'Maria Santos', 'Census', 'How do I update my household information?', 'Mar 17, 2026', 'Resolved'],
                            ['003', 'Pedro Reyes', 'General', 'What are the office hours?', 'Mar 16, 2026', 'Resolved'],
                            ['004', 'Ana Gomez', 'Complaints', 'I want to file a noise complaint.', 'Mar 16, 2026', 'Unanswered'],
                            ['005', 'Carlos Lim', 'Clearance', 'What documents do I need for clearance?', 'Mar 15, 2026', 'Resolved'],
                            ['006', 'Rosa Bautista', 'General', 'Is the barangay hall open on Saturday?', 'Mar 15, 2026', 'Unanswered'],
                        ];
                        foreach ($logs as $l): ?>
                            <tr>
                                <td><?= $l[0] ?></td>
                                <td>
                                    <div class="db-resident-name">
                                        <div class="db-avatar-sm"><?= strtoupper($l[1][0]) ?></div><?= $l[1] ?>
                                    </div>
                                </td>
                                <td><span class="db-tag"><?= $l[2] ?></span></td>
                                <td class="db-text-muted"><?= $l[3] ?></td>
                                <td><?= $l[4] ?></td>
                                <td><span class="db-badge <?= $l[5] === 'Resolved' ? 'db-badge--approved' : 'db-badge--pending' ?>"><?= $l[5] ?></span></td>
                                <td><button class="db-icon-btn db-icon-btn--view"><i class="fas fa-eye"></i></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <script>
        document.querySelectorAll('.db-nav-item').forEach(i => i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open')));
    </script>
</body>

</html>