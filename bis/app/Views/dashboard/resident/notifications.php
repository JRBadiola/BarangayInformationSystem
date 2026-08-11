<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .notif-wrap {
            max-width: 720px;
        }

        .notif-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .notif-header-left h3 {
            font-size: 16px;
            font-weight: 700;
            color: #1a1d2e;
            margin: 0 0 2px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notif-count-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #1d2448;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            min-width: 20px;
            height: 20px;
            border-radius: 100px;
            padding: 0 6px;
        }

        .notif-header-left p {
            font-size: 12.5px;
            color: #9aa0b4;
            margin: 0;
        }

        .notif-mark-all {
            font-size: 12.5px;
            font-weight: 600;
            color: #1d2448;
            background: none;
            border: 1.5px solid #1d2448;
            border-radius: 7px;
            padding: 7px 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background .2s, color .2s;
            font-family: 'Poppins', sans-serif;
        }

        .notif-mark-all:hover {
            background: #1d2448;
            color: #fff;
        }

        .notif-tabs {
            display: flex;
            gap: 6px;
            margin-bottom: 16px;
        }

        .notif-tab {
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid #e2e5ef;
            background: #fff;
            color: #9aa0b4;
            transition: all .2s;
            font-family: 'Poppins', sans-serif;
        }

        .notif-tab.active {
            background: #1d2448;
            color: #fff;
            border-color: #1d2448;
        }

        .notif-tab:hover:not(.active) {
            border-color: #1d2448;
            color: #1d2448;
        }

        .notif-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 8px rgba(29, 36, 72, .06);
            overflow: hidden;
            margin-bottom: 10px;
            border: 1.5px solid transparent;
            transition: border-color .2s, box-shadow .2s;
            cursor: pointer;
            position: relative;
        }

        .notif-card.unread {
            border-color: #e8ecf4;
            background: #f8f9ff;
        }

        .notif-card.unread:hover {
            border-color: #1d2448;
            box-shadow: 0 4px 16px rgba(29, 36, 72, .1);
        }

        .notif-card.read {
            border-color: #f0f2f8;
            opacity: .78;
        }

        .notif-card.read:hover {
            opacity: 1;
            border-color: #e2e5ef;
        }

        .notif-card-inner {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 18px;
        }

        .notif-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .notif-icon-wrap.success {
            background: rgba(22, 199, 154, .12);
            color: #16c79a;
        }

        .notif-icon-wrap.danger {
            background: rgba(220, 53, 69, .12);
            color: #dc3545;
        }

        .notif-icon-wrap.warning {
            background: rgba(255, 193, 7, .12);
            color: #e6a817;
        }

        .notif-icon-wrap.info {
            background: rgba(91, 111, 214, .12);
            color: #5b6fd6;
        }

        .notif-icon-wrap.event {
            background: rgba(29, 36, 72, .08);
            color: #1d2448;
        }

        .notif-icon-wrap.announce {
            background: rgba(29, 36, 72, .08);
            color: #1d2448;
        }

        .notif-body {
            flex: 1;
            min-width: 0;
        }

        .notif-title {
            font-size: 13.5px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0 0 4px;
            line-height: 1.5;
        }

        .notif-card.read .notif-title {
            font-weight: 500;
            color: #4a5068;
        }

        .notif-desc {
            font-size: 12.5px;
            color: #6b7280;
            margin: 0 0 6px;
            line-height: 1.6;
        }

        .notif-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11.5px;
            color: #b0b6cc;
        }

        .notif-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #1d2448;
            flex-shrink: 0;
            margin-top: 6px;
            transition: opacity .3s;
        }

        .notif-card.read .notif-dot {
            opacity: 0;
        }

        .notif-empty {
            text-align: center;
            padding: 48px 20px;
            color: #9aa0b4;
        }

        .notif-empty i {
            font-size: 40px;
            margin-bottom: 12px;
            display: block;
            color: #d0d5e8;
        }

        .notif-empty p {
            font-size: 14px;
            margin: 0;
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'resident';
    $active    = 'notif';
    $pageTitle = 'Notifications';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $notifs      = $notifs      ?? [];
    $unreadCount = $unreadCount ?? 0;

    /* ── Icon/colour map ───────────────────────────────────────────────────────── */
    $typeMap = [
        'clearance_approved' => ['style' => 'success', 'icon' => 'fas fa-check-circle'],
        'clearance_rejected' => ['style' => 'danger',  'icon' => 'fas fa-times-circle'],
        'clearance_released' => ['style' => 'success', 'icon' => 'fas fa-file-check'],
        'event_reminder'     => ['style' => 'event',   'icon' => 'fas fa-calendar-alt'],
        'announcement'       => ['style' => 'announce', 'icon' => 'fas fa-bullhorn'],
        'info'               => ['style' => 'info',    'icon' => 'fas fa-info-circle'],
        'warning'            => ['style' => 'warning', 'icon' => 'fas fa-exclamation-triangle'],
    ];
    ?>

    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">
            <div class="notif-wrap">

                <!-- Header -->
                <div class="notif-header">
                    <div class="notif-header-left">
                        <h3>
                            Notifications
                            <span class="notif-count-badge" id="unreadBadge"
                                style="<?= $unreadCount === 0 ? 'display:none;' : '' ?>">
                                <?= $unreadCount ?>
                            </span>
                        </h3>
                        <p id="notifSubtitle"><?= count($notifs) ?> total · <?= $unreadCount ?> unread</p>
                    </div>
                    <button class="notif-mark-all" id="markAllBtn"
                        onclick="markAllRead()"
                        style="<?= $unreadCount === 0 ? 'display:none;' : '' ?>">
                        <i class="fas fa-check-double"></i> Mark all as read
                    </button>
                </div>

                <!-- Filter tabs -->
                <div class="notif-tabs">
                    <button class="notif-tab active" onclick="filterNotifs('all',this)">All</button>
                    <button class="notif-tab" onclick="filterNotifs('unread',this)">Unread</button>
                    <button class="notif-tab" onclick="filterNotifs('read',this)">Read</button>
                </div>

                <!-- List -->
                <div id="notifList">
                    <?php if (empty($notifs)): ?>
                        <div class="notif-empty">
                            <i class="fas fa-bell-slash"></i>
                            <p>No notifications yet. Check back later.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($notifs as $n):
                            $isUnread = empty($n['read_at']);
                            $t = $typeMap[$n['type']] ?? $typeMap['announcement'];
                            // Strip internal event_id marker from display
                            $bodyDisplay = preg_replace('/\s*\[event_id:\d+\]/', '', $n['body'] ?? '');
                            $timeDisplay = $n['created_at']
                                ? date('M j, Y · g:i A', strtotime($n['created_at']))
                                : '';
                        ?>
                            <div class="notif-card <?= $isUnread ? 'unread' : 'read' ?>"
                                id="notif-<?= $n['id'] ?>"
                                data-unread="<?= $isUnread ? '1' : '0' ?>"
                                onclick="markRead(<?= $n['id'] ?>, <?= esc(json_encode($n['link'] ?? '')) ?>)">
                                <div class="notif-card-inner">
                                    <div class="notif-icon-wrap <?= $t['style'] ?>">
                                        <i class="<?= $t['icon'] ?>"></i>
                                    </div>
                                    <div class="notif-body">
                                        <div class="notif-title"><?= esc($n['title']) ?></div>
                                        <?php if ($bodyDisplay): ?>
                                            <div class="notif-desc"><?= esc($bodyDisplay) ?></div>
                                        <?php endif; ?>
                                        <div class="notif-meta">
                                            <i class="fas fa-clock"></i> <?= esc($timeDisplay) ?>
                                            <?php if ($isUnread): ?>
                                                <span style="color:#1d2448;font-weight:600;">· Unread</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="notif-dot"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <script>
        const CSRF_NAME = '<?= csrf_token() ?>';
        const CSRF_HASH = '<?= csrf_hash() ?>';
        let unreadCount = <?= (int)$unreadCount ?>;
        let totalCount = <?= count($notifs) ?>;

        function csrfHeaders() {
            const h = {
                'Content-Type': 'application/x-www-form-urlencoded'
            };
            h[CSRF_NAME] = CSRF_HASH;
            return h;
        }

        function markRead(id, link) {
            const card = document.getElementById('notif-' + id);
            if (!card) return;

            if (card.dataset.unread === '1') {
                card.classList.remove('unread');
                card.classList.add('read');
                card.dataset.unread = '0';
                card.querySelector('.notif-dot').style.opacity = '0';
                unreadCount = Math.max(0, unreadCount - 1);
                updateBadge();

                fetch('/resident/notifications/read/' + id, {
                    method: 'POST',
                    headers: csrfHeaders(),
                }).catch(() => {});
            }

            if (link) setTimeout(() => window.location.href = link, 180);
        }

        function markAllRead() {
            document.querySelectorAll('.notif-card.unread').forEach(card => {
                card.classList.remove('unread');
                card.classList.add('read');
                card.dataset.unread = '0';
                const dot = card.querySelector('.notif-dot');
                if (dot) dot.style.opacity = '0';
            });
            unreadCount = 0;
            updateBadge();

            fetch('/resident/notifications/read-all', {
                method: 'POST',
                headers: csrfHeaders(),
            }).catch(() => {});
        }

        function updateBadge() {
            const badge = document.getElementById('unreadBadge');
            if (badge) {
                badge.textContent = unreadCount;
                badge.style.display = unreadCount > 0 ? '' : 'none';
            }
            const btn = document.getElementById('markAllBtn');
            if (btn) btn.style.display = unreadCount > 0 ? '' : 'none';

            const sub = document.getElementById('notifSubtitle');
            if (sub) sub.textContent = totalCount + ' total · ' + unreadCount + ' unread';

            // Also sync topbar bell
            const topBell = document.getElementById('topbarUnreadCount');
            if (topBell) {
                topBell.textContent = unreadCount;
                topBell.style.display = unreadCount > 0 ? '' : 'none';
            }
        }

        function filterNotifs(filter, btn) {
            document.querySelectorAll('.notif-tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.notif-card').forEach(card => {
                const isUnread = card.dataset.unread === '1';
                card.style.display = filter === 'all' ? '' :
                    filter === 'unread' ? (isUnread ? '' : 'none') :
                    (!isUnread ? '' : 'none');
            });
        }

        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>