<?php

/**
 * Quick SMTP connection test — DELETE THIS FILE after testing!
 * Access via: http://localhost:8080/test_email.php?to=your@email.com
 */

// Bootstrap CodeIgniter
chdir(__DIR__);
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require_once 'vendor/autoload.php';

$app = new \CodeIgniter\App\Config\App();
$CI  = \CodeIgniter\Config\Factories::config('App');
require_once APPPATH . '../vendor/codeigniter4/framework/system/bootstrap.php';

$to   = $_GET['to'] ?? '';
$test = $_GET['test'] ?? 'otp';

if (empty($to)) {
    echo '<p style="font-family:monospace;padding:20px;">
        Usage: <code>/test_email.php?to=recipient@gmail.com</code><br>
        Optional: <code>&test=otp</code> or <code>&test=summons</code>
    </p>';
    exit;
}

try {
    $service = new \App\Libraries\EmailService();

    if ($test === 'summons') {
        $ok = $service->sendSummons($to, 'Test User', '0001', 'Physical Assault', 'August 20, 2026', '10:00 AM');
    } else {
        $ok = $service->sendVerificationEmail($to, 'Test User', '123456');
    }

    if ($ok) {
        echo '<p style="font-family:monospace;padding:20px;color:green;">
            ✅ Email sent successfully to <strong>' . htmlspecialchars($to) . '</strong>.<br>
            Check the inbox (and spam folder).
        </p>';
    } else {
        echo '<p style="font-family:monospace;padding:20px;color:red;">
            ❌ Email send returned false. Check <code>writable/logs/</code> for SMTP error details.
        </p>';
    }
} catch (\Throwable $e) {
    echo '<pre style="font-family:monospace;padding:20px;color:red;">'
        . 'ERROR: ' . htmlspecialchars($e->getMessage()) . "\n\n"
        . htmlspecialchars($e->getTraceAsString())
        . '</pre>';
}
