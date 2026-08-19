<?php

namespace App\Libraries;

/**
 * EmailService — Gmail SMTP via CodeIgniter's Email library.
 *
 * Setup (one-time):
 *  1. Enable 2-Step Verification on your Google account.
 *  2. Go to myaccount.google.com → Security → App Passwords.
 *  3. Generate a 16-character App Password for "Mail".
 *  4. Set in .env:
 *       email.SMTPUser   = your_gmail@gmail.com
 *       email.SMTPPass   = xxxx xxxx xxxx xxxx   (App Password, no spaces)
 *       email.fromEmail  = your_gmail@gmail.com
 *       email.fromName   = "Bacolod BIS"
 *       email.SMTPPort   = 465
 *       email.SMTPCrypto = ssl
 */
class EmailService
{
    /**
     * Build a fresh, fully-configured mailer from .env values.
     */
    private function mailer(): \CodeIgniter\Email\Email
    {
        $mailer = \Config\Services::email(null, false);
        $mailer->initialize([
            'protocol'    => 'smtp',
            'SMTPHost'    => env('email.SMTPHost',   'smtp.gmail.com'),
            'SMTPUser'    => env('email.SMTPUser',   ''),
            'SMTPPass'    => env('email.SMTPPass',   ''),
            'SMTPPort'    => (int) env('email.SMTPPort',   465),
            'SMTPCrypto'  => env('email.SMTPCrypto', 'ssl'),
            'SMTPTimeout' => 10,
            'mailType'    => 'html',
            'charset'     => 'UTF-8',
            'wordWrap'    => true,
            'newline'     => "\r\n",
            'CRLF'        => "\r\n",
        ]);
        $mailer->setFrom(
            env('email.fromEmail', env('email.SMTPUser', '')),
            env('email.fromName',  'Bacolod BIS')
        );
        return $mailer;
    }

    /**
     * Send and log any failure.
     */
    private function dispatch(\CodeIgniter\Email\Email $mailer, string $to): bool
    {
        $ok = $mailer->send(false);
        if (! $ok) {
            log_message('error', '[EmailService] Failed sending to ' . $to . ' — ' . $mailer->printDebugger(['headers']));
        }
        return $ok;
    }

    // ── Shared HTML shell ─────────────────────────────────────────────────────

    private function html(string $gradientCss, string $content): string
    {
        return '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  *{box-sizing:border-box;margin:0;padding:0;}
  body{background:#0f1117;font-family:Arial,Helvetica,sans-serif;color:#e2e5ef;}
  .outer{padding:40px 16px;background:#0f1117;}
  .card{max-width:540px;margin:0 auto;background:#161b27;border-radius:14px;overflow:hidden;}
  .hdr{background:' . $gradientCss . ';padding:32px 36px;text-align:center;}
  .hdr-title{color:#fff;font-size:26px;font-weight:700;letter-spacing:1px;margin-bottom:4px;}
  .hdr-sub{color:rgba(255,255,255,.7);font-size:13px;}
  .body{padding:36px 36px 28px;}
  .body-h2{font-size:20px;font-weight:700;color:#fff;margin-bottom:16px;}
  .body-p{font-size:14px;line-height:1.75;color:#9aa0b4;margin-bottom:20px;}
  .otp-box{background:#0f1117;border-radius:10px;padding:28px 20px;text-align:center;margin-bottom:24px;}
  .otp-lbl{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#9aa0b4;margin-bottom:14px;}
  .otp-num{font-size:46px;font-weight:700;letter-spacing:12px;font-family:"Courier New",Courier,monospace;}
  .otp-exp{font-size:12px;color:#9aa0b4;margin-top:12px;}
  .tip{background:#1e2538;border-left:3px solid currentColor;border-radius:6px;padding:14px 16px;font-size:12.5px;color:#9aa0b4;line-height:1.6;}
  .tip b{color:#e2e5ef;}
  .footer{background:#0f1117;padding:20px 36px;text-align:center;font-size:11px;color:#4a5068;line-height:1.9;}
</style>
</head>
<body>
<div class="outer">
  <div class="card">
    <div class="hdr">
      <div class="hdr-title">Bacolod BIS</div>
      <div class="hdr-sub">Barangay Information System &mdash; Barangay Bacolod, Bato, Camarines Sur</div>
    </div>
    <div class="body">' . $content . '</div>
    <div class="footer">
      This is an automated message &mdash; please do not reply directly to this email.<br>
      &copy; ' . date('Y') . ' Barangay Bacolod. All rights reserved.
    </div>
  </div>
</div>
</body>
</html>';
    }

    // ── OTP emails ────────────────────────────────────────────────────────────

    /**
     * Send account email-verification OTP after registration.
     */
    public function sendVerificationEmail(string $toEmail, string $toName, string $otp): bool
    {
        $name    = htmlspecialchars($toName, ENT_QUOTES);
        $content = '
<div class="body-h2">Verify your email address</div>
<p class="body-p">
  Hello <strong>' . $name . '</strong>,<br><br>
  Thank you for creating an account with the Barangay Management System.
  Use the verification code below to confirm your email address and complete your registration.
</p>
<div class="otp-box">
  <div class="otp-lbl">Your Verification Code</div>
  <div class="otp-num" style="color:#6c7ff2;">' . $otp . '</div>
  <div class="otp-exp">This code expires in <strong>15 minutes</strong>.</div>
</div>
<div class="tip" style="color:#6c7ff2;">
  <b>Security Tip:</b> Never share this code with anyone.
  BIS staff will never ask you for your verification code.
</div>';

        $m = $this->mailer();
        $m->setTo($toEmail, $toName);
        $m->setSubject('Verify your email — Bacolod BIS');
        $m->setMessage($this->html('linear-gradient(135deg,#4f5bd5,#7b5ea7)', $content));
        return $this->dispatch($m, $toEmail);
    }

    /**
     * Send OTP to confirm a password change while logged in.
     */
    public function sendPasswordChangeOtp(string $toEmail, string $toName, string $otp): bool
    {
        $name    = htmlspecialchars($toName, ENT_QUOTES);
        $content = '
<div class="body-h2">Password Change Request</div>
<p class="body-p">
  Hi <strong>' . $name . '</strong>,<br><br>
  We received a request to change your account password.
  Enter the code below to confirm this change.
  If you did not request this, you can safely ignore this email.
</p>
<div class="otp-box">
  <div class="otp-lbl">Your Verification Code</div>
  <div class="otp-num" style="color:#e74c3c;">' . $otp . '</div>
  <div class="otp-exp">This code expires in <strong>15 minutes</strong>.</div>
</div>
<div class="tip" style="color:#e74c3c;">
  <b>Security Alert:</b> If you did not request a password change, please secure your account immediately.
</div>';

        $m = $this->mailer();
        $m->setTo($toEmail, $toName);
        $m->setSubject('Password Change Verification — Bacolod BIS');
        $m->setMessage($this->html('linear-gradient(135deg,#c0392b,#922b21)', $content));
        return $this->dispatch($m, $toEmail);
    }

    /**
     * Send OTP for the forgot-password reset flow.
     */
    public function sendPasswordResetOtp(string $toEmail, string $toName, string $otp): bool
    {
        $name    = htmlspecialchars($toName, ENT_QUOTES);
        $content = '
<div class="body-h2">Reset your password</div>
<p class="body-p">
  Hi <strong>' . $name . '</strong>,<br><br>
  We received a request to reset your Bacolod BIS password.
  Use the code below to set a new password.
</p>
<div class="otp-box">
  <div class="otp-lbl">Your Password Reset Code</div>
  <div class="otp-num" style="color:#16c79a;">' . $otp . '</div>
  <div class="otp-exp">This code expires in <strong>15 minutes</strong>.</div>
</div>
<div class="tip" style="color:#16c79a;">
  <b>Security Note:</b> If you did not request a password reset, you can ignore this email — your password will not change.
</div>';

        $m = $this->mailer();
        $m->setTo($toEmail, $toName);
        $m->setSubject('Reset your password — Bacolod BIS');
        $m->setMessage($this->html('linear-gradient(135deg,#1d2448,#2e3a6e)', $content));
        return $this->dispatch($m, $toEmail);
    }

    // ── Blotter summons ───────────────────────────────────────────────────────

    /**
     * Send an official summons email for a blotter hearing.
     */
    public function sendSummons(
        string $toEmail,
        string $toName,
        string $caseNo,
        string $incidentType,
        string $hearingDate,
        string $hearingTime,
        string $role = 'respondent'
    ): bool {
        $name     = htmlspecialchars($toName,        ENT_QUOTES);
        $caseEsc  = htmlspecialchars($caseNo,        ENT_QUOTES);
        $typeEsc  = htmlspecialchars($incidentType,  ENT_QUOTES);
        $dateEsc  = htmlspecialchars($hearingDate,   ENT_QUOTES);
        $timeEsc  = htmlspecialchars($hearingTime,   ENT_QUOTES);
        $roleEsc  = ucfirst(htmlspecialchars($role,  ENT_QUOTES));

        $body = '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
  *{box-sizing:border-box;margin:0;padding:0;}
  body{background:#f5f6fa;font-family:Arial,Helvetica,sans-serif;}
  .outer{padding:40px 16px;background:#f5f6fa;}
  .card{max-width:560px;margin:0 auto;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.08);}
  .hdr{background:linear-gradient(135deg,#1d2448,#2e3a6e);padding:32px 36px;text-align:center;}
  .hdr-title{color:#fff;font-size:22px;font-weight:700;margin-bottom:4px;}
  .hdr-sub{color:rgba(255,255,255,.7);font-size:13px;}
  .body{padding:32px 36px;color:#1a1d2e;}
  .body h2{font-size:18px;font-weight:700;color:#1d2448;margin-bottom:16px;}
  .body p{font-size:14px;line-height:1.75;color:#4a5068;margin-bottom:14px;}
  .case-table{width:100%;background:#f0f4ff;border:1px solid #d0d8f5;border-radius:8px;border-collapse:collapse;overflow:hidden;margin:18px 0;}
  .case-table td{padding:9px 14px;font-size:13px;color:#4a5068;border-bottom:1px solid #e0e6f8;}
  .case-table td:first-child{font-weight:700;color:#1d2448;width:130px;}
  .case-table tr:last-child td{border-bottom:none;}
  .hearing-box{background:#fff8f0;border:1px solid #fde8c8;border-radius:8px;padding:18px 20px;margin:18px 0;text-align:center;}
  .h-label{font-size:10px;color:#9aa0b4;text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px;}
  .h-date{font-size:22px;font-weight:700;color:#1d2448;margin-bottom:2px;}
  .h-time{font-size:16px;color:#b7600a;font-weight:600;}
  .h-venue{font-size:12px;color:#9aa0b4;margin-top:6px;}
  .warning{background:#fff0f1;border-left:4px solid #c0392b;border-radius:0 8px 8px 0;padding:12px 16px;font-size:13px;color:#c0392b;margin:18px 0;line-height:1.6;}
  .footer{background:#f5f6fa;padding:18px 36px;text-align:center;font-size:11px;color:#9aa0b4;line-height:1.9;}
</style>
</head>
<body>
<div class="outer">
  <div class="card">
    <div class="hdr">
      <div class="hdr-title">BARANGAY BACOLOD</div>
      <div class="hdr-sub">Bato, Camarines Sur &mdash; Office of the Punong Barangay</div>
    </div>
    <div class="body">
      <h2>SUMMONS</h2>
      <p>Dear <strong>' . $name . '</strong>,</p>
      <p>
        You are hereby summoned to appear before the <strong>Barangay Lupon ng Tagapamayapa</strong>
        in connection with the following blotter case:
      </p>
      <table class="case-table">
        <tr><td>Case No.</td><td><strong>BL-' . $caseEsc . '</strong></td></tr>
        <tr><td>Incident Type</td><td>' . $typeEsc . '</td></tr>
        <tr><td>Your Role</td><td>' . $roleEsc . '</td></tr>
      </table>
      <p>The hearing has been scheduled as follows:</p>
      <div class="hearing-box">
        <div class="h-label">Hearing Schedule</div>
        <div class="h-date">' . $dateEsc . '</div>
        <div class="h-time">' . $timeEsc . '</div>
        <div class="h-venue">Barangay Hall, Bacolod, Bato, Camarines Sur</div>
      </div>
      <div class="warning">
        <strong>Important:</strong> Failure to appear without valid reason may result in
        further legal action under RA 7160 (Katarungang Pambarangay Law).
      </div>
      <p>Please bring a valid government-issued ID and any relevant documents or evidence.</p>
      <p>For inquiries, contact the Barangay Hall during office hours (Monday to Friday, 8:00 AM – 5:00 PM).</p>
    </div>
    <div class="footer">
      Official communication from Barangay Bacolod, Bato, Camarines Sur.<br>
      Issued by the Office of the Punong Barangay.<br>
      &copy; ' . date('Y') . ' Barangay Bacolod. All rights reserved.
    </div>
  </div>
</div>
</body>
</html>';

        $m = $this->mailer();
        $m->setTo($toEmail, $toName);
        $m->setSubject('SUMMONS — Barangay Blotter Case #' . $caseNo);
        $m->setMessage($body);
        return $this->dispatch($m, $toEmail);
    }
}
