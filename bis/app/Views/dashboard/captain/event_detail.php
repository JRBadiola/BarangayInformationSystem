<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .ev-wrap {
            max-width: 720px;
        }

        .ev-header {
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .1);
        }

        .ev-header-banner {
            padding: 28px 28px 20px;
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }

        .ev-type-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            flex-shrink: 0;
        }

        .ev-title {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin: 0 0 6px;
        }

        .ev-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .ev-meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: rgba(255, 255, 255, .8);
        }

        .ev-meta-item i {
            font-size: 12px;
            opacity: .8;
        }

        .ev-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .18);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .ev-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29, 36, 72, .06);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .ev-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f0f2f8;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ev-card-header h4 {
            font-size: 13.5px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0;
        }

        .ev-card-header i {
            color: #9aa0b4;
            font-size: 14px;
        }

        .ev-card-body {
            padding: 20px 22px;
        }

        .ev-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .ev-detail-item label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #9aa0b4;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 4px;
        }

        .ev-detail-item span {
            font-size: 14px;
            font-weight: 500;
            color: #1a1d2e;
        }

        .ev-description {
            font-size: 14px;
            color: #4a5068;
            line-height: 1.75;
            background: #f8f9fc;
            border-radius: 8px;
            padding: 14px 16px;
            border: 1px solid #e8ecf4;
        }

        /* Edit form */
        .ev-form-group {
            margin-bottom: 14px;
        }

        .ev-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #4a5068;
            margin-bottom: 5px;
        }

        .ev-input,
        .ev-select,
        .ev-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e2e5ef;
            border-radius: 8px;
            font-size: 13.5px;
            font-family: 'Poppins', sans-serif;
            color: #1a1d2e;
            background: #fff;
            outline: none;
            transition: border-color .2s;
            box-sizing: border-box;
        }

        .ev-input:focus,
        .ev-select:focus,
        .ev-textarea:focus {
            border-color: #1d2448;
            box-shadow: 0 0 0 3px rgba(29, 36, 72, .08);
        }

        .ev-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .ev-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .color-swatch-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .color-swatch-row label {
            cursor: pointer;
        }

        .color-swatch-row input[type="radio"] {
            display: none;
        }

        .color-swatch {
            display: block;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 3px solid transparent;
            transition: border-color .15s, transform .15s;
        }

        .color-swatch-row input[type="radio"]:checked+.color-swatch {
            border-color: #fff;
            outline: 2px solid #1d2448;
            transform: scale(1.15);
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = $role ?? session()->get('role') ?? 'captain';
    $active    = 'dashboard';
    $pageTitle = 'Event Details';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $ev = $event ?? [];
    $canEdit     = $canEdit     ?? true;
    $captainUser = $captainUser ?? null;
    $evId    = $ev['id'] ?? 0;
    $color   = $ev['color'] ?? '#1d2448';
    $evDate  = ! empty($ev['event_date']) ? date('l, F d, Y', strtotime($ev['event_date'])) : '—';
    $evStart = ! empty($ev['start_time']) ? date('h:i A', strtotime($ev['start_time'])) : '';
    $evEnd   = ! empty($ev['end_time'])   ? date('h:i A', strtotime($ev['end_time']))   : '';
    $timeStr = $evStart ? ($evEnd ? $evStart . ' – ' . $evEnd : $evStart) : 'All day';

    $typeIcons = [
        'hearing'     => 'fas fa-gavel',
        'meeting'     => 'fas fa-users',
        'appointment' => 'fas fa-calendar-check',
        'event'       => 'fas fa-star',
        'other'       => 'fas fa-circle',
    ];
    $typeIcon = $typeIcons[$ev['event_type'] ?? 'other'] ?? 'fas fa-circle';
    $typeLabel = ucfirst($ev['event_type'] ?? 'other');
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <?php if (session()->getFlashdata('cal_success')): ?>
                <div class="db-alert db-alert--success" style="margin-bottom:16px;"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('cal_success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('cal_error')): ?>
                <div class="db-alert db-alert--error" style="margin-bottom:16px;"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('cal_error') ?></div>
            <?php endif; ?>

            <!-- Back -->
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
                <a href="/<?= $role ?>/calendar?year=<?= date('Y', strtotime($ev['event_date'] ?? 'today')) ?>&month=<?= date('n', strtotime($ev['event_date'] ?? 'today')) ?>"
                    class="db-btn db-btn--outline" style="padding:7px 14px;font-size:13px;">
                    <i class="fas fa-arrow-left"></i> Back to Calendar
                </a>
                <div>
                    <h2 style="font-size:16px;font-weight:700;color:#1d2448;margin:0;">Event Details</h2>
                    <p style="font-size:12px;color:#9aa0b4;margin:0;">View and edit this event</p>
                </div>
            </div>

            <div class="ev-wrap">

                <!-- Header banner -->
                <div class="ev-header">
                    <div class="ev-header-banner" style="background:linear-gradient(135deg,<?= esc($color) ?>,<?= esc($color) ?>cc);">
                        <div class="ev-type-icon"><i class="<?= $typeIcon ?>"></i></div>
                        <div style="flex:1;min-width:0;">
                            <div class="ev-title"><?= esc($ev['title'] ?? '—') ?></div>
                            <div class="ev-meta">
                                <span class="ev-meta-item"><i class="fas fa-calendar"></i><?= $evDate ?></span>
                                <span class="ev-meta-item"><i class="fas fa-clock"></i><?= $timeStr ?></span>
                                <?php if (! empty($ev['location'])): ?>
                                    <span class="ev-meta-item"><i class="fas fa-map-marker-alt"></i><?= esc($ev['location']) ?></span>
                                <?php endif; ?>
                                <span class="ev-badge"><i class="<?= $typeIcon ?>"></i><?= $typeLabel ?></span>
                            </div>
                            <?php if (!empty($ev['shared_with'])): ?>
                                <div style="background:rgba(255,255,255,.15);border-radius:8px;padding:8px 14px;margin:0 28px 16px;display:flex;align-items:center;gap:8px;font-size:12.5px;color:#fff;">
                                    <i class="fas fa-share-alt"></i>
                                    <span>This event is shared with the Captain''s calendar</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Details card -->
                    <div class="ev-card">
                        <div class="ev-card-header">
                            <i class="fas fa-info-circle"></i>
                            <h4>Event Information</h4>
                        </div>
                        <div class="ev-card-body">
                            <div class="ev-detail-grid" style="margin-bottom:<?= ! empty($ev['description']) ? '16px' : '0' ?>;">
                                <div class="ev-detail-item">
                                    <label>Date</label>
                                    <span><?= $evDate ?></span>
                                </div>
                                <div class="ev-detail-item">
                                    <label>Time</label>
                                    <span><?= $timeStr ?></span>
                                </div>
                                <div class="ev-detail-item">
                                    <label>Type</label>
                                    <span><i class="<?= $typeIcon ?>" style="color:<?= esc($color) ?>;margin-right:5px;"></i><?= $typeLabel ?></span>
                                </div>
                                <div class="ev-detail-item">
                                    <label>Location</label>
                                    <span><?= esc($ev['location'] ?: '—') ?></span>
                                </div>
                            </div>
                            <?php if (! empty($ev['description'])): ?>
                                <div>
                                    <label style="display:block;font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Description / Notes</label>
                                    <div class="ev-description"><?= nl2br(esc($ev['description'])) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Edit card -->
                    <div class="ev-card">
                        <div class="ev-card-header">
                            <i class="fas fa-edit"></i>
                            <h4>Edit Event</h4>
                        </div>
                        <div class="ev-card-body">
                            <form action="/<?= $role ?>/calendar/update/<?= $evId ?>" method="post" id="editForm">
                                <?= csrf_field() ?>

                                <div class="ev-form-group">
                                    <label>Title <span style="color:#c0392b;">*</span></label>
                                    <input type="text" name="title" class="ev-input" value="<?= esc($ev['title'] ?? '') ?>" required>
                                </div>

                                <div class="ev-form-row" style="margin-bottom:14px;">
                                    <div class="ev-form-group" style="margin:0;">
                                        <label>Date <span style="color:#c0392b;">*</span></label>
                                        <input type="date" name="event_date" class="ev-input" value="<?= esc($ev['event_date'] ?? '') ?>" required>
                                    </div>
                                    <div class="ev-form-group" style="margin:0;">
                                        <label>Type</label>
                                        <select name="event_type" class="ev-select">
                                            <?php foreach (['appointment' => 'Appointment', 'meeting' => 'Meeting', 'hearing' => 'Hearing', 'event' => 'Event', 'other' => 'Other'] as $val => $lbl): ?>
                                                <option value="<?= $val ?>" <?= ($ev['event_type'] ?? '') === $val ? 'selected' : '' ?>><?= $lbl ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="ev-form-row" style="margin-bottom:14px;">
                                    <div class="ev-form-group" style="margin:0;">
                                        <label>Start Time</label>
                                        <input type="time" name="start_time" class="ev-input" value="<?= esc($ev['start_time'] ?? '') ?>">
                                    </div>
                                    <div class="ev-form-group" style="margin:0;">
                                        <label>End Time</label>
                                        <input type="time" name="end_time" class="ev-input" value="<?= esc($ev['end_time'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="ev-form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" class="ev-input" value="<?= esc($ev['location'] ?? '') ?>" placeholder="e.g. Barangay Hall">
                                </div>

                                <div class="ev-form-group">
                                    <label>Description / Notes</label>
                                    <textarea name="description" class="ev-textarea"><?= esc($ev['description'] ?? '') ?></textarea>
                                </div>

                                <div class="ev-form-group">
                                    <label>Color</label>
                                    <div class="color-swatch-row">
                                        <?php foreach (['#1d2448', '#c0392b', '#2980b9', '#16a085', '#e67e22', '#8e44ad', '#27ae60', '#7f8c8d'] as $clr): ?>
                                            <label>
                                                <input type="radio" name="color" value="<?= $clr ?>" <?= ($ev['color'] ?? '#1d2448') === $clr ? 'checked' : '' ?>>
                                                <span class="color-swatch" style="background:<?= $clr ?>;"></span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <?php if ($role === 'secretary' && $captainUser): ?>
                                    <div style="background:#f0f4ff;border:1px solid #d0d8f5;border-radius:8px;padding:10px 14px;margin-bottom:14px;display:flex;align-items:center;gap:10px;">
                                        <input type="checkbox" name="share_with_captain" id="editShareCaptain" value="1"
                                            <?= !empty($ev['shared_with']) ? 'checked' : '' ?>
                                            style="width:16px;height:16px;accent-color:#1d2448;cursor:pointer;">
                                        <label for="editShareCaptain" style="font-size:13px;color:#1d2448;font-weight:600;cursor:pointer;">
                                            <i class="fas fa-share-alt" style="margin-right:5px;color:#5b6fd6;"></i>
                                            Share with Captain's calendar (<?= esc(trim(($captainUser['first_name'] ?? '') . ' ' . ($captainUser['last_name'] ?? ''))) ?>)
                                        </label>
                                    </div>
                                <?php endif; ?>
                                <div style="display:flex;gap:10px;margin-top:20px;">
                                    <a href="/<?= $role ?>/calendar?year=<?= date('Y', strtotime($ev['event_date'] ?? 'today')) ?>&month=<?= date('n', strtotime($ev['event_date'] ?? 'today')) ?>"
                                        class="db-btn db-btn--outline" style="flex:1;justify-content:center;text-decoration:none;">
                                        Cancel
                                    </a>
                                    <button type="submit" class="db-btn db-btn--primary" style="flex:2;justify-content:center;">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete card -->
                    <div class="ev-card" style="border:1px solid #fad4d4;">
                        <div class="ev-card-header" style="border-bottom-color:#fad4d4;">
                            <i class="fas fa-trash" style="color:#c0392b;"></i>
                            <h4 style="color:#c0392b;">Delete Event</h4>
                        </div>
                        <div class="ev-card-body" style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
                            <p style="font-size:13.5px;color:#4a5068;margin:0;">
                                Permanently remove this event from the calendar. This action cannot be undone.
                            </p>
                            <form action="/<?= $role ?>/calendar/delete/<?= $evId ?>" method="post"
                                onsubmit="return confirm('Delete this event? This cannot be undone.')">
                                <?= csrf_field() ?>
                                <button type="submit" class="db-btn db-btn--danger" style="white-space:nowrap;">
                                    <i class="fas fa-trash"></i> Delete Event
                                </button>
                            </form>
                        </div>
                    </div>

                </div><!-- end ev-wrap -->
            </div>
        </div>

        <script>
            document.querySelectorAll('.db-nav-item').forEach(i =>
                i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
            );
        </script>
</body>

</html>