<?php
$role   = $role   ?? 'resident';
$active = $active ?? 'dashboard';

$menus = [
    'captain' => [
        ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard',        'key' => 'dashboard',        'href' => '/captain/dashboard'],
        ['icon' => 'fas fa-calendar-alt',   'label' => 'Calendar',         'key' => 'calendar',         'href' => '/captain/calendar'],
        ['icon' => 'fas fa-users',           'label' => 'Census Records',   'key' => 'census',           'href' => '/captain/census'],
        ['icon' => 'fas fa-file-alt',        'label' => 'Clearance',        'key' => 'clearance',        'href' => '/captain/clearance'],
        ['icon' => 'fas fa-book',            'label' => 'Blotter Reports',  'key' => 'blotter',          'href' => '/captain/blotter'],
        ['icon' => 'fas fa-chart-bar',       'label' => 'Reports',          'key' => 'reports',          'href' => '/captain/reports'],
        ['icon' => 'fas fa-user-clock',      'label' => 'Pending Accounts', 'key' => 'pending_accounts', 'href' => '/captain/pending-accounts'],
        ['icon' => 'fas fa-cog',             'label' => 'Settings',         'key' => 'settings',         'href' => '/captain/settings'],
    ],
    'secretary' => [
        ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard',        'key' => 'dashboard',        'href' => '/secretary/dashboard'],
        ['icon' => 'fas fa-calendar-alt',   'label' => 'Calendar',         'key' => 'calendar',         'href' => '/secretary/calendar'],
        ['icon' => 'fas fa-users',           'label' => 'Census Records',   'key' => 'census',           'href' => '/secretary/census'],
        ['icon' => 'fas fa-file-alt',        'label' => 'Clearance',        'key' => 'clearance',        'href' => '/secretary/clearance'],
        ['icon' => 'fas fa-book',            'label' => 'Blotter Reports',  'key' => 'blotter',          'href' => '/secretary/blotter'],
        ['icon' => 'fas fa-chart-bar',       'label' => 'Reports',          'key' => 'reports',          'href' => '/secretary/reports'],
        ['icon' => 'fas fa-user-clock',      'label' => 'Pending Accounts', 'key' => 'pending_accounts', 'href' => '/secretary/pending-accounts'],
        ['icon' => 'fas fa-user-plus',       'label' => 'Create Official',  'key' => 'create_account',   'href' => '/secretary/create-account'],
    ],
    'resident' => [
        ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard',       'key' => 'dashboard',   'href' => '/resident/dashboard'],
        ['icon' => 'fas fa-user',            'label' => 'My Profile',      'key' => 'profile',     'href' => '/resident/profile'],
        ['icon' => 'fas fa-bell',            'label' => 'Notifications',   'key' => 'notif',       'href' => '/resident/notifications'],
    ],
    'sk' => [
        ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard',         'key' => 'dashboard',  'href' => '/sk/dashboard'],
        ['icon' => 'fas fa-id-card',         'label' => 'SK Profiling',     'key' => 'profiling',  'href' => '/sk/profiling'],
        ['icon' => 'fas fa-calendar-alt',    'label' => 'Programs & Events', 'key' => 'programs',   'href' => '/sk/programs'],
        ['icon' => 'fas fa-chart-bar',       'label' => 'Reports',           'key' => 'reports',    'href' => '/sk/reports'],
        ['icon' => 'fas fa-file-alt',        'label' => 'Document Request',  'key' => 'clearance',  'href' => '/sk/clearance'],
        ['icon' => 'fas fa-book',            'label' => 'Blotter Report',    'key' => 'blotter',    'href' => '/sk/blotter'],
        ['icon' => 'fas fa-cog',             'label' => 'Settings',          'key' => 'settings',   'href' => '/sk/settings'],
    ],
];

$roleMenu = $menus[strtolower($role)] ?? $menus['resident'];
$roleLabel = ucfirst($role);
$roleIcons = ['captain' => 'fas fa-user-tie', 'secretary' => 'fas fa-user-edit', 'treasurer' => 'fas fa-coins', 'resident' => 'fas fa-users', 'sk' => 'fas fa-star'];
$roleIcon = $roleIcons[strtolower($role)] ?? 'fas fa-user';
?>

<aside class="db-sidebar" id="sidebar">
    <div class="db-sidebar-brand">
        <div class="db-brand-logo">
            <img src="/bacolod.png" alt="Logo">
        </div>
        <div class="db-brand-text">
            <span class="db-brand-name">Bacolod BIS</span>
            <span class="db-brand-role"><i class="<?= $roleIcon ?>"></i> <?= $roleLabel ?></span>
        </div>
    </div>

    <nav class="db-nav">
        <?php foreach ($roleMenu as $item): ?>
            <a href="<?= $item['href'] ?>" class="db-nav-item <?= $active === $item['key'] ? 'active' : '' ?>">
                <i class="<?= $item['icon'] ?>"></i>
                <span><?= $item['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <a href="/logout" class="db-logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
</aside>