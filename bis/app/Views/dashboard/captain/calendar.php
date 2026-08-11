<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role      = $role  ?? session()->get('role') ?? 'captain';
    $active    = 'dashboard';
    $pageTitle = 'Calendar';
    include(APPPATH . 'Views/dashboard/sidebar.php');
    $year     = $year     ?? (int)date('Y');
    $month    = $month    ?? (int)date('n');
    $byDate   = $byDate   ?? [];
    $upcoming = $upcoming ?? [];
    $captainUser = $captainUser ?? null;
    $monthName   = date('F', mktime(0, 0, 0, $month, 1, $year));
    $daysInMonth = (int)date('t', mktime(0, 0, 0, $month, 1, $year));
    $firstDow    = (int)date('w', mktime(0, 0, 0, $month, 1, $year));
    $prevMonth = $month - 1;
    $prevYear = $year;
    if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear--;
    }
    $nextMonth = $month + 1;
    $nextYear = $year;
    if ($nextMonth > 12) {
        $nextMonth = 1;
        $nextYear++;
    }
    $typeColors = [
        'hearing'     => '#c0392b',
        'meeting'     => '#2980b9',
        'appointment' => '#1d2448',
        'event'       => '#16a085',
        'other'       => '#7f8c8d',
    ];
    $typeLabels = [
        'hearing'     => 'Hearing',
        'meeting'     => 'Meeting',
        'appointment' => 'Appointment',
        'event'       => 'Event',
        'other'       => 'Other',
    ];
    $today = date('Y-m-d');
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
            <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">
                <!-- LEFT: Calendar -->
                <div>
                    <!-- Calendar header -->
                    <div style="background:#fff;border-radius:14px;box-shadow:0 2px 12px rgba(29,36,72,.06);overflow:hidden;margin-bottom:20px;">
                        <div style="background:linear-gradient(135deg,#1d2448,#2e3a6e);padding:18px 24px;display:flex;align-items:center;justify-content:space-between;">
                            <a href="?year=<?= $prevYear ?>&month=<?= $prevMonth ?>" style="color:rgba(255,255,255,.7);text-decoration:none;font-size:18px;padding:4px 10px;border-radius:6px;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='transparent'"><i class="fas fa-chevron-left"></i></a>
                            <div style="text-align:center;">
                                <div style="color:#fff;font-size:20px;font-weight:700;"><?= $monthName ?> <?= $year ?></div>
                                <div style="color:rgba(255,255,255,.6);font-size:12px;margin-top:2px;"><?= date('l, F d, Y') ?></div>
                            </div>
                            <a href="?year=<?= $nextYear ?>&month=<?= $nextMonth ?>" style="color:rgba(255,255,255,.7);text-decoration:none;font-size:18px;padding:4px 10px;border-radius:6px;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='transparent'"><i class="fas fa-chevron-right"></i></a>
                        </div>
                        <!-- Day headers -->
                        <div style="display:grid;grid-template-columns:repeat(7,1fr);background:#f0f2f8;">
                            <?php foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $d): ?>
                                <div style="text-align:center;padding:10px 4px;font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.5px;"><?= $d ?></div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Calendar grid -->
                        <div style="display:grid;grid-template-columns:repeat(7,1fr);border-top:1px solid #f0f2f8;">
                            <?php
                            // Empty cells before first day
                            for ($i = 0; $i < $firstDow; $i++):
                            ?>
                                <div style="min-height:90px;border-right:1px solid #f0f2f8;border-bottom:1px solid #f0f2f8;background:#fafbfd;"></div>
                            <?php endfor;
                            // Day cells
                            for ($day = 1; $day <= $daysInMonth; $day++):
                                $dateStr  = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                $isToday  = ($dateStr === $today);
                                $dayEvents = $byDate[$dateStr] ?? [];
                                $dow = ($firstDow + $day - 1) % 7;
                                $isSun = ($dow === 0);
                                $isSat = ($dow === 6);
                            ?>
                                <div style="min-height:90px;border-right:1px solid #f0f2f8;border-bottom:1px solid #f0f2f8;padding:6px 5px;cursor:pointer;transition:background .15s;<?= $isToday ? 'background:#f0f4ff;' : ($isSun || $isSat ? 'background:#fafbfd;' : '') ?>"
                                    onclick="openAddModal('<?= $dateStr ?>')"
                                    onmouseover="this.style.background='#f5f7ff'" onmouseout="this.style.background='<?= $isToday ? '#f0f4ff' : ($isSun || $isSat ? '#fafbfd' : '#fff') ?>'">
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                                        <span style="font-size:13px;font-weight:<?= $isToday ? '700' : '500' ?>;color:<?= $isToday ? '#fff' : ($isSun ? '#c0392b' : '#1a1d2e') ?>;<?= $isToday ? 'background:#1d2448;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;' : '' ?>"><?= $day ?></span>
                                        <?php if (! empty($dayEvents)): ?>
                                            <span style="font-size:9px;background:#1d2448;color:#fff;border-radius:100px;padding:1px 6px;font-weight:700;"><?= count($dayEvents) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php foreach (array_slice($dayEvents, 0, 2) as $ev): ?>
                                        <div style="background:<?= esc($ev['color'] ?? '#1d2448') ?>;color:#fff;font-size:10px;font-weight:600;padding:2px 6px;border-radius:4px;margin-bottom:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;cursor:pointer;"
                                            onclick="event.stopPropagation(); handleEventClick(<?= json_encode($ev) ?>)">
                                            <?= esc(mb_strimwidth($ev['title'], 0, 18, '…')) ?>
                                        </div>
                                    <?php endforeach; ?>
                                    <?php if (count($dayEvents) > 2): ?>
                                        <div style="font-size:10px;color:#9aa0b4;padding:1px 4px;">+<?= count($dayEvents) - 2 ?> more</div>
                                    <?php endif; ?>
                                </div>
                            <?php endfor;
                            // Trailing empty cells
                            $trailing = (7 - ($firstDow + $daysInMonth) % 7) % 7;
                            for ($i = 0; $i < $trailing; $i++):
                            ?>
                                <div style="min-height:90px;border-right:1px solid #f0f2f8;border-bottom:1px solid #f0f2f8;background:#fafbfd;"></div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <!-- Legend -->
                    <div style="background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(29,36,72,.06);padding:14px 18px;display:flex;flex-wrap:wrap;gap:12px;align-items:center;">
                        <span style="font-size:11px;font-weight:700;color:#9aa0b4;text-transform:uppercase;letter-spacing:.5px;">Legend:</span>
                        <?php foreach ($typeColors as $type => $color): ?>
                            <span style="display:flex;align-items:center;gap:5px;font-size:12px;color:#4a5068;">
                                <span style="width:12px;height:12px;border-radius:3px;background:<?= $color ?>;flex-shrink:0;"></span>
                                <?= $typeLabels[$type] ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- RIGHT: Upcoming + Add -->
                <div>
                    <!-- Add Event button -->
                    <button onclick="openAddModal('<?= date('Y-m-d') ?>')" class="db-btn db-btn--primary" style="width:100%;justify-content:center;margin-bottom:10px;padding:12px;">
                        <i class="fas fa-plus"></i> Add Event / Appointment
                    </button>
                    <a href="/<?= $role ?>/calendar/events" class="db-btn db-btn--outline" style="width:100%;justify-content:center;margin-bottom:16px;text-decoration:none;">
                        <i class="fas fa-list"></i> Manage All Events
                    </a>
                    <!-- Upcoming events -->
                    <div style="background:#fff;border-radius:14px;box-shadow:0 2px 12px rgba(29,36,72,.06);overflow:hidden;">
                        <div style="background:#1d2448;padding:14px 18px;">
                            <h4 style="color:#fff;font-size:13.5px;font-weight:600;margin:0;"><i class="fas fa-clock" style="margin-right:8px;opacity:.7;"></i>Upcoming Events</h4>
                        </div>
                        <div style="padding:0;">
                            <?php if (empty($upcoming)): ?>
                                <div style="text-align:center;padding:32px 16px;color:#9aa0b4;">
                                    <i class="fas fa-calendar-times" style="font-size:28px;display:block;margin-bottom:8px;color:#d0d5e8;"></i>
                                    <p style="font-size:13px;">No upcoming events.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($upcoming as $ev):
                                    $evDate = date('M d, Y', strtotime($ev['event_date']));
                                    $evTime = $ev['start_time'] ? date('h:i A', strtotime($ev['start_time'])) : '';
                                    $isEvToday = ($ev['event_date'] === $today);
                                ?>
                                    <div style="display:flex;gap:12px;padding:12px 16px;border-bottom:1px solid #f0f2f8;cursor:pointer;" onclick="handleEventClick(<?= json_encode($ev) ?>)">
                                        <div style="width:4px;border-radius:4px;background:<?= esc($ev['color'] ?? '#1d2448') ?>;flex-shrink:0;"></div>
                                        <div style="flex:1;min-width:0;">
                                            <div style="font-size:13px;font-weight:600;color:#1a1d2e;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= esc($ev['title']) ?></div>
                                            <div style="font-size:11.5px;color:#9aa0b4;margin-top:2px;">
                                                <i class="fas fa-calendar" style="margin-right:4px;"></i><?= $evDate ?>
                                                <?php if ($evTime): ?> &nbsp;·&nbsp; <i class="fas fa-clock" style="margin-right:4px;"></i><?= $evTime ?><?php endif; ?>
                                            </div>
                                            <?php if ($ev['location']): ?>
                                                <div style="font-size:11px;color:#b0b6cc;margin-top:1px;"><i class="fas fa-map-marker-alt" style="margin-right:3px;"></i><?= esc($ev['location']) ?></div>
                                            <?php endif; ?>
                                            <?php if ($ev['description']): ?>
                                                <div style="font-size:11px;color:#b0b6cc;margin-top:1px;"><i class="fas fa-map-marker-alt" style="margin-right:3px;"></i><?= esc($ev['description']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($isEvToday): ?>
                                            <span style="background:#eef0fb;color:#1d2448;font-size:10px;font-weight:700;padding:2px 8px;border-radius:100px;align-self:flex-start;flex-shrink:0;">Today</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── ADD EVENT MODAL ── -->
    <div id="addModal" style="display:none;position:fixed;inset:0;background:rgba(15,17,30,.55);backdrop-filter:blur(3px);z-index:1000;align-items:center;justify-content:center;padding:16px;">
        <div style="background:#fff;border-radius:18px;width:100%;max-width:480px;box-shadow:0 20px 60px rgba(0,0,0,.18);overflow:hidden;animation:calPop .18s ease;">
            <div style="background:linear-gradient(135deg,#1d2448,#2e3a6e);padding:20px 24px;display:flex;align-items:center;justify-content:space-between;">
                <h3 style="color:#fff;font-size:16px;font-weight:700;margin:0;"><i class="fas fa-calendar-plus" style="margin-right:8px;opacity:.8;"></i>Add Event</h3>
                <button onclick="closeModal('addModal')" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:30px;height:30px;border-radius:50%;cursor:pointer;font-size:14px;">×</button>
            </div>
            <form action="/<?= $role ?>/calendar/store" method="post" style="padding:22px 24px;">
                <?= csrf_field() ?>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#4a5068;margin-bottom:5px;">Title <span style="color:#c0392b;">*</span></label>
                    <input type="text" name="title" id="addTitle" class="db-input" placeholder="e.g. Barangay Meeting" required style="width:100%;padding:10px 14px;border:1.5px solid #e2e5ef;border-radius:8px;font-size:13.5px;font-family:'Poppins',sans-serif;color:#1a1d2e;outline:none;box-sizing:border-box;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#4a5068;margin-bottom:5px;">Date <span style="color:#c0392b;">*</span></label>
                        <input type="date" name="event_date" id="addDate" class="db-input" required style="width:100%;padding:10px 14px;border:1.5px solid #e2e5ef;border-radius:8px;font-size:13px;font-family:'Poppins',sans-serif;color:#1a1d2e;outline:none;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#4a5068;margin-bottom:5px;">Type</label>
                        <select name="event_type" style="width:100%;padding:10px 14px;border:1.5px solid #e2e5ef;border-radius:8px;font-size:13px;font-family:'Poppins',sans-serif;color:#1a1d2e;outline:none;box-sizing:border-box;background:#fff;">
                            <option value="appointment">Appointment</option>
                            <option value="meeting">Meeting</option>
                            <option value="hearing">Hearing</option>
                            <option value="event">Event</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#4a5068;margin-bottom:5px;">Start Time</label>
                        <input type="time" name="start_time" style="width:100%;padding:10px 14px;border:1.5px solid #e2e5ef;border-radius:8px;font-size:13px;font-family:'Poppins',sans-serif;color:#1a1d2e;outline:none;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#4a5068;margin-bottom:5px;">End Time</label>
                        <input type="time" name="end_time" style="width:100%;padding:10px 14px;border:1.5px solid #e2e5ef;border-radius:8px;font-size:13px;font-family:'Poppins',sans-serif;color:#1a1d2e;outline:none;box-sizing:border-box;">
                    </div>
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#4a5068;margin-bottom:5px;">Location</label>
                    <input type="text" name="location" placeholder="e.g. Barangay Hall" style="width:100%;padding:10px 14px;border:1.5px solid #e2e5ef;border-radius:8px;font-size:13.5px;font-family:'Poppins',sans-serif;color:#1a1d2e;outline:none;box-sizing:border-box;">
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#4a5068;margin-bottom:5px;">Description</label>
                    <textarea name="description" rows="2" placeholder="Optional notes..." style="width:100%;padding:10px 14px;border:1.5px solid #e2e5ef;border-radius:8px;font-size:13px;font-family:'Poppins',sans-serif;color:#1a1d2e;outline:none;resize:vertical;box-sizing:border-box;"></textarea>
                </div>
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#4a5068;margin-bottom:8px;">Color</label>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <?php foreach (['#1d2448', '#c0392b', '#2980b9', '#16a085', '#e67e22', '#8e44ad', '#27ae60', '#7f8c8d'] as $clr): ?>
                            <label style="cursor:pointer;">
                                <input type="radio" name="color" value="<?= $clr ?>" style="display:none;" <?= $clr === '#1d2448' ? 'checked' : '' ?>>
                                <span style="display:block;width:26px;height:26px;border-radius:50%;background:<?= $clr ?>;border:3px solid transparent;transition:border-color .15s;" onclick="this.style.borderColor='#fff';this.style.outline='2px solid <?= $clr ?>';"></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php if ($role === 'secretary' && $captainUser): ?>
                    <div style="background:#f0f4ff;border:1px solid #d0d8f5;border-radius:8px;padding:10px 14px;margin-bottom:14px;display:flex;align-items:center;gap:10px;">
                        <input type="checkbox" name="share_with_captain" id="shareWithCaptain" value="1" style="width:16px;height:16px;accent-color:#1d2448;cursor:pointer;">
                        <label for="shareWithCaptain" style="font-size:13px;color:#1d2448;font-weight:600;cursor:pointer;">
                            <i class="fas fa-share-alt" style="margin-right:5px;color:#5b6fd6;"></i>
                            Also add to Captain's calendar (<?= esc(trim(($captainUser['first_name'] ?? '') . ' ' . ($captainUser['last_name'] ?? ''))) ?>)
                        </label>
                    </div>
                <?php endif; ?>
                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeModal('addModal')" style="flex:1;padding:11px;background:#f0f2f8;color:#4a5068;border:none;border-radius:9px;font-size:13.5px;font-weight:600;font-family:'Poppins',sans-serif;cursor:pointer;">Cancel</button>
                    <button type="submit" style="flex:2;padding:11px;background:#1d2448;color:#fff;border:none;border-radius:9px;font-size:13.5px;font-weight:600;font-family:'Poppins',sans-serif;cursor:pointer;"><i class="fas fa-save"></i> Save Event</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ── VIEW/EDIT EVENT MODAL ── -->
    <div id="viewModal" style="display:none;position:fixed;inset:0;background:rgba(15,17,30,.55);backdrop-filter:blur(3px);z-index:1000;align-items:center;justify-content:center;padding:16px;">
        <div style="background:#fff;border-radius:18px;width:100%;max-width:440px;box-shadow:0 20px 60px rgba(0,0,0,.18);overflow:hidden;animation:calPop .18s ease;">
            <div id="viewModalHeader" style="padding:20px 24px;display:flex;align-items:center;justify-content:space-between;">
                <h3 id="viewModalTitle" style="color:#fff;font-size:16px;font-weight:700;margin:0;"></h3>
                <button onclick="closeModal('viewModal')" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:30px;height:30px;border-radius:50%;cursor:pointer;font-size:14px;">×</button>
            </div>
            <div style="padding:20px 24px;">
                <div id="viewModalBody"></div>
                <div id="viewModalActions" style="display:flex;gap:10px;margin-top:16px;"></div>
            </div>
        </div>
    </div>

    <style>
        @keyframes calPop {
            from {
                transform: scale(.94);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    <script>
        function openAddModal(dateStr) {
            document.getElementById('addDate').value = dateStr;
            document.getElementById('addTitle').value = '';
            const m = document.getElementById('addModal');
            m.style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        document.getElementById('addModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal('addModal');
        });
        document.getElementById('viewModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal('viewModal');
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('addModal');
                closeModal('viewModal');
            }
        });

        function openViewModal(ev) {
            const isBlotter = ev.is_blotter || false;
            const color = ev.color || '#1d2448';
            const header = document.getElementById('viewModalHeader');
            header.style.background = 'linear-gradient(135deg,' + color + ',' + color + 'cc)';
            document.getElementById('viewModalTitle').textContent = ev.title;

            const date = ev.event_date ? new Date(ev.event_date + 'T00:00:00').toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) : '';
            const startT = ev.start_time ? formatTime(ev.start_time) : '';
            const endT = ev.end_time ? ' – ' + formatTime(ev.end_time) : '';

            let body = '';
            if (date) body += '<div style="display:flex;gap:8px;margin-bottom:10px;font-size:13px;color:#4a5068;"><i class="fas fa-calendar" style="color:' + color + ';margin-top:2px;flex-shrink:0;"></i><span>' + date + '</span></div>';
            if (startT) body += '<div style="display:flex;gap:8px;margin-bottom:10px;font-size:13px;color:#4a5068;"><i class="fas fa-clock" style="color:' + color + ';margin-top:2px;flex-shrink:0;"></i><span>' + startT + endT + '</span></div>';
            if (ev.location) body += '<div style="display:flex;gap:8px;margin-bottom:10px;font-size:13px;color:#4a5068;"><i class="fas fa-map-marker-alt" style="color:' + color + ';margin-top:2px;flex-shrink:0;"></i><span>' + ev.location + '</span></div>';
            if (ev.description) body += '<div style="background:#f8f9fc;border-radius:8px;padding:10px 12px;font-size:13px;color:#555;line-height:1.6;margin-top:4px;">' + ev.description + '</div>';

            document.getElementById('viewModalBody').innerHTML = body;

            let actions = '<button onclick="closeModal(\'viewModal\')" style="flex:1;padding:10px;background:#f0f2f8;color:#4a5068;border:none;border-radius:8px;font-size:13px;font-weight:600;font-family:\'Poppins\',sans-serif;cursor:pointer;">Close</button>';
            if (!isBlotter && ev.id) {
                const role = '<?= $role ?>';
                actions += '<a href="/' + role + '/calendar/view/' + ev.id + '" style="flex:1;padding:10px;background:#1d2448;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;font-family:\'Poppins\',sans-serif;cursor:pointer;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;"><i class="fas fa-edit"></i> Edit</a>';
                actions += '<form action="/' + role + '/calendar/delete/' + ev.id + '" method="post" style="flex:1;" onsubmit="return confirm(\'Delete this event? This cannot be undone.\')">' +
                    '<?= csrf_field() ?>' +
                    '<button type="submit" style="width:100%;padding:10px;background:#c0392b;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;font-family:\'Poppins\',sans-serif;cursor:pointer;"><i class="fas fa-trash"></i> Delete</button>' +
                    '</form>';
            }
            if (isBlotter && ev.blotter_id) {
                actions += '<a href="/<?= $role ?>/blotter/' + ev.blotter_id + '" style="flex:1;padding:10px;background:#1d2448;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;font-family:\'Poppins\',sans-serif;cursor:pointer;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;"><i class="fas fa-eye"></i> View Case</a>';
            }
            document.getElementById('viewModalActions').innerHTML = '<div style="display:flex;gap:10px;width:100%;">' + actions + '</div>';

            document.getElementById('viewModal').style.display = 'flex';
        }

        function formatTime(t) {
            if (!t) return '';
            const parts = t.split(':');
            let h = parseInt(parts[0]),
                m = parts[1];
            const ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12 || 12;
            return h + ':' + m + ' ' + ampm;
        }

        document.querySelectorAll('.db-nav-item').forEach(i => i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open')));
    </script>
</body>

</html>