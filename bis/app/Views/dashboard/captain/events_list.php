<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Events - Bacolod BIS</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="/style.css">
</head>
<body class="db-body">
<?php
$role      = $role ?? session()->get('role') ?? 'captain';
$active    = 'dashboard';
$pageTitle = 'All Events';
include(APPPATH . 'Views/dashboard/sidebar.php');
$events = $events ?? [];
$search = $search ?? '';
$type   = $type   ?? '';
$today  = date('Y-m-d');
$typeColors = [
    'hearing'     => '#c0392b',
    'meeting'     => '#2980b9',
    'appointment' => '#1d2448',
    'event'       => '#16a085',
    'other'       => '#7f8c8d',
];
$typeIcons = [
    'hearing'     => 'fas fa-gavel',
    'meeting'     => 'fas fa-users',
    'appointment' => 'fas fa-calendar-check',
    'event'       => 'fas fa-star',
    'other'       => 'fas fa-circle',
];
?>
<div class="db-main">
<?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
<div class="db-content">

<?php if (session()->getFlashdata('cal_success')): ?>
<div class="db-alert db-alert--success" style="margin-bottom:16px;"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('cal_success') ?></div>
<?php endif; ?>

<!-- Toolbar -->
<form method="get" action="" id="filterForm">
<div class="db-toolbar" style="margin-bottom:20px;">
    <div class="db-search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="Search events..." value="<?= esc($search) ?>"
               onchange="document.getElementById('filterForm').submit()">
    </div>
    <div class="db-toolbar-actions">
        <select name="type" class="db-filter-select" onchange="this.form.submit()">
            <option value="">All Types</option>
            <option value="appointment" <?= $type === 'appointment' ? 'selected' : '' ?>>Appointment</option>
            <option value="meeting"     <?= $type === 'meeting'     ? 'selected' : '' ?>>Meeting</option>
            <option value="hearing"     <?= $type === 'hearing'     ? 'selected' : '' ?>>Hearing</option>
            <option value="event"       <?= $type === 'event'       ? 'selected' : '' ?>>Event</option>
            <option value="other"       <?= $type === 'other'       ? 'selected' : '' ?>>Other</option>
        </select>
        <?php if ($search !== '' || $type !== ''): ?>
        <a href="/<?= $role ?>/calendar/events" class="db-btn db-btn--outline">
            <i class="fas fa-times"></i> Clear
        </a>
        <?php endif; ?>
        <a href="/<?= $role ?>/calendar" class="db-btn db-btn--outline">
            <i class="fas fa-calendar-alt"></i> Calendar View
        </a>
    </div>
</div>
</form>

<!-- Events table -->
<div class="db-table-wrap">
<table class="db-table">
    <thead>
        <tr>
            <th>Event</th>
            <th>Date</th>
            <th>Time</th>
            <th>Type</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($events)): ?>
        <tr>
            <td colspan="6" style="text-align:center;padding:40px;color:#9aa0b4;">
                <i class="fas fa-calendar-times" style="font-size:28px;display:block;margin-bottom:10px;color:#d0d5e8;"></i>
                <?= ($search || $type) ? 'No events match the current filters.' : 'No events yet. Go to the calendar to add one.' ?>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($events as $ev):
            $evColor = $ev['color'] ?? '#1d2448';
            $evIcon  = $typeIcons[$ev['event_type'] ?? 'other'] ?? 'fas fa-circle';
            $evDate  = ! empty($ev['event_date']) ? date('M d, Y', strtotime($ev['event_date'])) : '—';
            $evStart = ! empty($ev['start_time']) ? date('h:i A', strtotime($ev['start_time'])) : '';
            $evEnd   = ! empty($ev['end_time'])   ? ' – ' . date('h:i A', strtotime($ev['end_time'])) : '';
            $isPast  = ! empty($ev['event_date']) && $ev['event_date'] < $today;
        ?>
        <tr style="<?= $isPast ? 'opacity:.65;' : '' ?>">
            <td>
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:36px;height:36px;border-radius:9px;background:<?= esc($evColor) ?>;display:flex;align-items:center;justify-content:center;font-size:14px;color:#fff;flex-shrink:0;">
                        <i class="<?= $evIcon ?>"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;color:#1a1d2e;font-size:13.5px;"><?= esc($ev['title']) ?></div>
                        <?php if (! empty($ev['description'])): ?>
                        <div style="font-size:11.5px;color:#9aa0b4;margin-top:1px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:220px;"><?= esc($ev['description']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
            <td>
                <?= $evDate ?>
                <?php if ($ev['event_date'] === $today): ?>
                <span style="background:#eef0fb;color:#1d2448;font-size:10px;font-weight:700;padding:1px 7px;border-radius:100px;margin-left:4px;">Today</span>
                <?php elseif (! $isPast && ! empty($ev['event_date'])): ?>
                <span style="background:#f0faf6;color:#1a7a55;font-size:10px;font-weight:700;padding:1px 7px;border-radius:100px;margin-left:4px;">Upcoming</span>
                <?php endif; ?>
            </td>
            <td><?= $evStart ? $evStart . $evEnd : '—' ?></td>
            <td>
                <span style="display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;padding:3px 10px;border-radius:100px;background:<?= esc($evColor) ?>18;color:<?= esc($evColor) ?>;border:1px solid <?= esc($evColor) ?>33;">
                    <i class="<?= $evIcon ?>" style="font-size:10px;"></i>
                    <?= ucfirst(esc($ev['event_type'] ?? 'other')) ?>
                </span>
            </td>
            <td><?= esc($ev['location'] ?: '—') ?></td>
            <td>
                <div class="db-action-group">
                    <a href="/<?= $role ?>/calendar/view/<?= $ev['id'] ?>" class="db-icon-btn db-icon-btn--view" title="View & Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="/<?= $role ?>/calendar/delete/<?= $ev['id'] ?>" method="post" style="display:inline;"
                          onsubmit="return confirm('Delete \'<?= esc(addslashes($ev['title'])) ?>\'? This cannot be undone.')">
                        <?= csrf_field() ?>
                        <button type="submit" class="db-icon-btn db-icon-btn--del" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
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
