<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ── Public (no auth required) ─────────────────────────────────────────────────
$routes->get('/',            'UIController::home');
$routes->get('/index',       'UIController::home');
$routes->get('/login',       'UIController::login');
$routes->post('/login',      'AuthController::login');
$routes->get('/select_role', 'UIController::select_role');
$routes->get('/logout',      'AuthController::logout');
$routes->get('/verify-email',          'AuthController::showVerifyEmail');
$routes->post('/verify-email',         'AuthController::verifyEmail');
$routes->get('/resend-otp',            'AuthController::resendOtp');
$routes->post('/public/blotter/store', 'BlotterController::storePublic');
$routes->get('/public/blotter/busy-dates', 'BlotterController::busyDates');
$routes->get('/public/blotter/busy-slots', 'BlotterController::busySlots');
$routes->get('/faqs',           'UIController::faqs');
$routes->get('/privacy-policy', 'UIController::privacy_policy');
$routes->get('/terms',          'UIController::terms_of_use');

// Public chatbot API (for residents without login)
$routes->post('/api/chatbot/chat',        'ChatbotController::chat');
$routes->post('/api/chatbot/save-log',    'ChatbotController::saveLog');
$routes->get('/api/chatbot/logs',         'ChatbotController::getLogs');

// Public signup — Resident and SK only (Captain/Secretary/Treasurer are created by admin)
$routes->get('/signup',           'UIController::create_acc');
$routes->get('/signup/(:alpha)',  'UIController::create_acc/$1'); // keep for backwards compat
$routes->post('/signup/store',    'AuthController::register');

// Forgot password flow
$routes->get('/forgot-password',          'AuthController::showForgotPassword');
$routes->post('/forgot-password',         'AuthController::sendForgotPasswordOtp');
$routes->get('/forgot-password/verify',   'AuthController::showForgotPasswordOtp');
$routes->post('/forgot-password/verify',  'AuthController::verifyForgotPasswordOtp');
$routes->get('/forgot-password/resend',   'AuthController::resendForgotPasswordOtp');
$routes->get('/forgot-password/new-password',  'AuthController::showNewPassword');
$routes->post('/forgot-password/reset',   'AuthController::saveNewPassword');

// ── Captain ───────────────────────────────────────────────────────────────────
$routes->group('/captain', ['filter' => ['auth', 'role:captain']], function ($routes) {
    $routes->get('dashboard',                    'UIController::captain_dashboard');
    $routes->get('census',                       'UIController::captain_census');
    $routes->get('household/(:segment)',         'UIController::captain_household/$1');
    $routes->get('clearance',                    'ClearanceController::adminIndex/captain');
    $routes->get('clearance/request/(:num)',     'ClearanceController::residentDetail/$1');
    $routes->post('clearance/approve/(:num)',     'ClearanceController::approve/$1');
    $routes->post('clearance/reject/(:num)',      'ClearanceController::reject/$1');
    $routes->get('reports',                      'UIController::captain_reports');
    $routes->get('reports/export',               'ReportsExportController::export/captain');
    $routes->get('chatbot',                      'UIController::captain_chatbot');
    $routes->post('chatbot/api/chat',           'ChatbotController::chat');
    $routes->post('chatbot/api/save-log',       'ChatbotController::saveLog');
    $routes->get('chatbot/api/logs',            'ChatbotController::getLogs');
    $routes->get('blotter',                      'BlotterController::adminIndex/captain');
    $routes->get('blotter/(:num)',               'BlotterController::show/$1');
    $routes->post('blotter/status/(:num)',        'BlotterController::updateStatus/$1');
    $routes->post('blotter/summons/(:num)',       'BlotterController::sendSummons/$1');
    $routes->post('blotter/reschedule/(:num)',    'BlotterController::reschedule/$1');
    $routes->get('blotter/letter/(:num)',         'BlotterController::viewLetter/$1');
    $routes->get('settings',                     'UIController::captain_settings');

    // Calendar / Schedule
    $routes->get('calendar',                     'ScheduleController::index');
    $routes->get('calendar/events',              'ScheduleController::listAll');
    $routes->get('calendar/view/(:num)',          'ScheduleController::view/$1');
    $routes->post('calendar/store',              'ScheduleController::store');
    $routes->post('calendar/update/(:num)',      'ScheduleController::update/$1');
    $routes->post('calendar/delete/(:num)',      'ScheduleController::delete/$1');

    // Captain can approve/reject pending accounts
    $routes->get('pending-accounts',        'AuthController::pendingAccounts');
    $routes->post('approve-account/(:num)', 'AuthController::approveAccount/$1');
    $routes->post('reject-account/(:num)',  'AuthController::rejectAccount/$1');

    // Notifications
    $routes->get('notifications',       'AdminNotificationController::index/captain');
    $routes->get('notifications/poll',  'AdminNotificationController::poll');

    // Captain creates Secretary, Treasurer accounts
    $routes->get('create-account',        'UIController::captain_create_account');
    $routes->post('create-account/store', 'AuthController::createOfficialAccount');

    // Settings
    $routes->post('settings/profile',         'SettingsController::updateProfile');
    $routes->post('settings/request-otp',     'SettingsController::requestPasswordOtp');
    $routes->post('settings/verify-otp',      'SettingsController::verifyPasswordOtp');
    $routes->post('settings/change-password', 'SettingsController::changePassword');
    $routes->post('settings/avatar',          'SettingsController::uploadAvatar');

    // Settings
    $routes->post('settings/profile',          'SettingsController::updateProfile');
    $routes->post('settings/request-otp',      'SettingsController::requestPasswordOtp');
    $routes->post('settings/verify-otp',       'SettingsController::verifyPasswordOtp');
    $routes->post('settings/change-password',  'SettingsController::changePassword');
    $routes->post('settings/avatar',           'SettingsController::uploadAvatar');

    // Census CRUD
    $routes->get('census/new',                     'CensusController::create');
    $routes->post('census/store',                    'CensusController::store');
    $routes->post('census/update/(:segment)',         'CensusController::updateHousehold/$1');
    $routes->post('census/delete/(:segment)',         'CensusController::delete/$1');
    $routes->post('census/member/add/(:segment)',     'CensusController::addMember/$1');
    $routes->post('census/members/add/(:segment)',    'CensusController::addFamilyMembers/$1');
    $routes->post('census/member/update/(:num)',      'CensusController::updateMember/$1');
    $routes->post('census/member/delete/(:num)',      'CensusController::deleteMember/$1');

    // Census PDF export
    $routes->get('census/export/pdf', 'CensusExportController::exportPdf');
});

// ── Secretary (Super Admin) ───────────────────────────────────────────────────
$routes->group('/secretary', ['filter' => ['auth', 'role:secretary']], function ($routes) {
    $routes->get('dashboard',          'UIController::secretary_dashboard');
    $routes->get('census',             'UIController::secretary_census');
    $routes->get('household/(:segment)', 'UIController::secretary_household/$1');
    $routes->get('clearance',          'ClearanceController::adminIndex/secretary');
    $routes->get('clearance/request/(:num)',     'ClearanceController::residentDetail/$1');
    $routes->post('clearance/approve/(:num)',     'ClearanceController::approve/$1');
    $routes->post('clearance/reject/(:num)',      'ClearanceController::reject/$1');
    $routes->get('templates',                        'DocumentTemplateController::index');
    $routes->get('templates/edit/(:segment)',        'DocumentTemplateController::edit/$1');
    $routes->post('templates/update/(:segment)',     'DocumentTemplateController::update/$1');
    $routes->get('barangay-settings',                'DocumentTemplateController::barangaySettings');
    $routes->post('barangay-settings/save',          'DocumentTemplateController::saveBarangaySettings');
    $routes->get('requests',           'UIController::secretary_requests');
    $routes->get('reports',            'UIController::secretary_reports');
    $routes->get('reports/export',     'ReportsExportController::export/secretary');
    $routes->get('chatbot',            'UIController::secretary_chatbot');
    $routes->post('chatbot/api/chat',           'ChatbotController::chat');
    $routes->post('chatbot/api/save-log',       'ChatbotController::saveLog');
    $routes->get('chatbot/api/logs',            'ChatbotController::getLogs');
    $routes->get('blotter',            'BlotterController::adminIndex/secretary');
    $routes->get('blotter/(:num)',     'BlotterController::show/$1');
    $routes->post('blotter/status/(:num)',  'BlotterController::updateStatus/$1');
    $routes->post('blotter/summons/(:num)', 'BlotterController::sendSummons/$1');
    $routes->post('blotter/reschedule/(:num)', 'BlotterController::reschedule/$1');
    $routes->get('blotter/letter/(:num)',   'BlotterController::viewLetter/$1');
    $routes->get('settings',           'UIController::secretary_settings');

    // Calendar / Schedule
    $routes->get('calendar',                'ScheduleController::index');
    $routes->get('calendar/events',         'ScheduleController::listAll');
    $routes->get('calendar/view/(:num)',    'ScheduleController::view/$1');
    $routes->post('calendar/store',         'ScheduleController::store');
    $routes->post('calendar/update/(:num)', 'ScheduleController::update/$1');
    $routes->post('calendar/delete/(:num)', 'ScheduleController::delete/$1');

    // Secretary (super admin) — approve/reject pending accounts
    $routes->get('pending-accounts',        'AuthController::pendingAccounts');
    $routes->post('approve-account/(:num)', 'AuthController::approveAccount/$1');
    $routes->post('reject-account/(:num)',  'AuthController::rejectAccount/$1');

    // Notifications
    $routes->get('notifications',       'AdminNotificationController::index/secretary');
    $routes->get('notifications/poll',  'AdminNotificationController::poll');

    // Secretary creates Captain, Resident, SK accounts
    $routes->get('create-account',        'UIController::secretary_create_account');
    $routes->post('create-account/store', 'AuthController::createOfficialAccount');

    // Secretary promotes existing resident to official role
    $routes->post('promote-resident',          'AuthController::promoteResident');

    // Secretary demotes official back to resident
    $routes->post('demote-official/(:num)',    'AuthController::demoteOfficial/$1');

    // Secretary resets any user's password (no verification required)
    $routes->post('reset-password/(:num)',  'SettingsController::adminResetPassword/$1');

    // Secretary deactivates a captain or secretary account
    $routes->post('deactivate-user/(:num)', 'SettingsController::deactivateUser/$1');

    // Settings
    $routes->post('settings/profile',          'SettingsController::updateProfile');
    $routes->post('settings/request-otp',      'SettingsController::requestPasswordOtp');
    $routes->post('settings/verify-otp',       'SettingsController::verifyPasswordOtp');
    $routes->post('settings/change-password',  'SettingsController::changePassword');
    $routes->post('settings/avatar',           'SettingsController::uploadAvatar');

    // Census CRUD
    $routes->post('census/store',                    'CensusController::store');
    $routes->post('census/update/(:segment)',         'CensusController::updateHousehold/$1');
    $routes->post('census/delete/(:segment)',         'CensusController::delete/$1');
    $routes->post('census/member/add/(:segment)',     'CensusController::addMember/$1');
    $routes->post('census/members/add/(:segment)',    'CensusController::addFamilyMembers/$1');
    $routes->post('census/member/update/(:num)',      'CensusController::updateMember/$1');
    $routes->post('census/member/delete/(:num)',      'CensusController::deleteMember/$1');

    // Census PDF export
    $routes->get('census/export/pdf', 'CensusExportController::exportPdf');
});

// ── Treasurer ─────────────────────────────────────────────────────────────────
$routes->group('/treasurer', ['filter' => ['auth', 'role:treasurer']], function ($routes) {
    $routes->get('dashboard', 'UIController::treasurer_dashboard');
    $routes->get('payments',  'UIController::treasurer_payments');
    $routes->get('clearance', 'UIController::treasurer_clearance');
    $routes->get('reports',   'UIController::treasurer_reports');
    $routes->get('settings',  'UIController::treasurer_settings');
});

// ── Resident ──────────────────────────────────────────────────────────────────
$routes->group('/resident', ['filter' => ['auth', 'role:resident']], function ($routes) {
    $routes->get('dashboard',     'UIController::resident_dashboard');
    $routes->get('clearance',     'ClearanceController::residentIndex');
    $routes->post('clearance/store',       'ClearanceController::store');
    $routes->post('clearance/cancel/(:num)', 'ClearanceController::cancel/$1');
    $routes->get('profile',       'UIController::resident_profile');
    $routes->get('chatbot',       'UIController::resident_chatbot');
    $routes->post('chatbot/api/chat',           'ChatbotController::chat');
    $routes->post('chatbot/api/save-log',       'ChatbotController::saveLog');
    $routes->get('chatbot/api/logs',            'ChatbotController::getLogs');
    $routes->get('notifications', 'UIController::resident_notifications');
    $routes->get('notifications/poll',        'NotificationController::poll');
    $routes->post('notifications/read/(:num)', 'NotificationController::markRead/$1');
    $routes->post('notifications/read-all',    'NotificationController::markAllRead');
    $routes->post('blotter/store', 'BlotterController::store');

    // Password change via OTP
    $routes->post('settings/request-otp',     'SettingsController::requestPasswordOtp');
    $routes->post('settings/verify-otp',      'SettingsController::verifyPasswordOtp');
    $routes->post('settings/change-password', 'SettingsController::changePassword');
    $routes->post('settings/avatar',          'SettingsController::uploadAvatar');
});

// ── SK ────────────────────────────────────────────────────────────────────────
$routes->group('/sk', ['filter' => ['auth', 'role:sk']], function ($routes) {
    $routes->get('dashboard',             'UIController::sk_dashboard');

    // Profiling — read from census (households + household_members)
    $routes->get('profiling',             'SkController::profiling');
    $routes->get('household/(:segment)',  'UIController::sk_household/$1');

    // sk_youth CRUD (manual add/edit still available)
    $routes->get('profiling/add',         'SkController::addForm');
    $routes->post('profiling/store',      'SkController::store');
    $routes->get('profiling/view/(:num)', 'SkController::view/$1');
    $routes->get('profiling/edit/(:num)', 'SkController::editForm/$1');
    $routes->post('profiling/update/(:num)', 'SkController::update/$1');
    $routes->post('profiling/delete/(:num)', 'SkController::delete/$1');

    $routes->get('programs',              'SkController::programs');
    $routes->post('programs/store',       'SkController::storeProgram');
    $routes->post('programs/update/(:num)', 'SkController::updateProgram/$1');
    $routes->post('programs/delete/(:num)', 'SkController::deleteProgram/$1');
    $routes->get('chatbot',               'UIController::sk_chatbot');
    $routes->post('chatbot/api/chat',           'ChatbotController::chat');
    $routes->post('chatbot/api/save-log',       'ChatbotController::saveLog');
    $routes->get('chatbot/api/logs',            'ChatbotController::getLogs');
    $routes->get('reports',               'UIController::sk_reports');
    $routes->get('settings',              'UIController::sk_settings');

    // Document requests (clearance) — same as resident flow
    $routes->get('clearance',                    'UIController::sk_clearance');
    $routes->post('clearance/store',             'ClearanceController::store');
    $routes->post('clearance/cancel/(:num)',     'ClearanceController::cancel/$1');

    // Blotter filing
    $routes->get('blotter',                      'UIController::sk_blotter');
    $routes->post('blotter/store',               'BlotterController::store');

    // Settings — password change via OTP
    $routes->post('settings/request-otp',     'SettingsController::requestPasswordOtp');
    $routes->post('settings/verify-otp',      'SettingsController::verifyPasswordOtp');
    $routes->post('settings/change-password', 'SettingsController::changePassword');
    $routes->post('settings/profile',         'SettingsController::updateProfile');
    $routes->post('settings/avatar',          'SettingsController::uploadAvatar');
});
