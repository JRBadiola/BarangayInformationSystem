<?php

namespace App\Libraries;

use CodeIgniter\Email\Email;

class EmailService
{
    protected Email $mailer;

    public function __construct()
    {
        $this->mailer = \Config\Services::email();
    }

    /**
     * Send a 6-digit OTP verification email.
     */
    public function sendVerificationEmail(string $toEmail, string $toName, string $otp): bool
    {
        $subject = 'Email Verification - BIS';

        $body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { margin:0; padding:0; background:#0f1117; font-family: Arial, sans-serif; }
                .outer { background:#0f1117; padding: 40px 16px; }
                .wrap { max-width: 540px; margin: 0 auto; background:#161b27; border-radius: 12px; overflow:hidden; }

                /* Header */
                .header {
                    background: linear-gradient(135deg, #4f5bd5 0%, #7b5ea7 100%);
                    padding: 32px 36px;
                    text-align: center;
                }
                .header h1 { color:#fff; font-size:26px; font-weight:700; margin:0 0 4px; letter-spacing:1px; }
                .header p  { color:rgba(255,255,255,0.75); font-size:13px; margin:0; }

                /* Body */
                .body { padding: 36px 36px 28px; color:#e2e5ef; }
                .body h2 { font-size:20px; font-weight:700; color:#fff; margin:0 0 16px; }
                .body p  { font-size:14px; line-height:1.7; color:#9aa0b4; margin:0 0 24px; }

                /* OTP Box */
                .otp-box {
                    background:#0f1117;
                    border-radius:10px;
                    padding: 28px 20px;
                    text-align:center;
                    margin-bottom:24px;
                }
                .otp-label {
                    font-size:11px;
                    letter-spacing:2px;
                    text-transform:uppercase;
                    color:#9aa0b4;
                    margin-bottom:14px;
                }
                .otp-code {
                    font-size:42px;
                    font-weight:700;
                    letter-spacing:10px;
                    color:#6c7ff2;
                    font-family: "Courier New", monospace;
                }
                .otp-expiry {
                    font-size:12px;
                    color:#9aa0b4;
                    margin-top:12px;
                }

                /* Security tip */
                .tip {
                    background:#1e2538;
                    border-left: 3px solid #6c7ff2;
                    border-radius:6px;
                    padding:14px 16px;
                    font-size:12px;
                    color:#9aa0b4;
                    line-height:1.6;
                }
                .tip strong { color:#e2e5ef; }

                /* Footer */
                .footer {
                    background:#0f1117;
                    padding:20px 36px;
                    text-align:center;
                    font-size:11px;
                    color:#4a5068;
                    line-height:1.8;
                }
            </style>
        </head>
        <body>
            <div class="outer">
                <div class="wrap">
                    <div class="header">
                        <h1>BIS</h1>
                        <p>Barangay Management</p>
                    </div>
                    <div class="body">
                        <h2>Welcome to BIS!</h2>
                        <p>Hello ' . htmlspecialchars($toName) . ',<br><br>
                        Thank you for registering with the Barangay Management. To complete your registration, please verify your email address using the code below:</p>

                        <div class="otp-box">
                            <div class="otp-label">Your Verification Code</div>
                            <div class="otp-code">' . $otp . '</div>
                            <div class="otp-expiry">This code will expire in 15 minutes.</div>
                        </div>

                        <div class="tip">
                            <strong>Security Tip:</strong> Never share this code with anyone. BIS staff will never ask for your verification code.
                        </div>
                    </div>
                    <div class="footer">
                        This is an automated message from BIS.<br>
                        Please do not reply to this email.<br>
                        &copy; ' . date('Y') . ' BIS. All rights reserved.
                    </div>
                </div>
            </div>
        </body>
        </html>';

        $this->mailer->setTo($toEmail, $toName);
        $this->mailer->setSubject($subject);
        $this->mailer->setMessage($body);

        return $this->mailer->send();
    }

    /**
     * Send a 6-digit OTP for password change verification.
     */
    public function sendPasswordChangeOtp(string $toEmail, string $toName, string $otp): bool
    {
        $subject = 'Password Change Verification - BIS';

        $body = '<!DOCTYPE html><html><head><meta charset="UTF-8">
        <style>
            body{margin:0;padding:0;background:#0f1117;font-family:Arial,sans-serif;}
            .outer{background:#0f1117;padding:40px 16px;}
            .wrap{max-width:540px;margin:0 auto;background:#161b27;border-radius:12px;overflow:hidden;}
            .header{background:linear-gradient(135deg,#c0392b 0%,#922b21 100%);padding:32px 36px;text-align:center;}
            .header h1{color:#fff;font-size:26px;font-weight:700;margin:0 0 4px;letter-spacing:1px;}
            .header p{color:rgba(255,255,255,0.75);font-size:13px;margin:0;}
            .body{padding:36px 36px 28px;color:#e2e5ef;}
            .body h2{font-size:20px;font-weight:700;color:#fff;margin:0 0 16px;}
            .body p{font-size:14px;line-height:1.7;color:#9aa0b4;margin:0 0 24px;}
            .otp-box{background:#0f1117;border-radius:10px;padding:28px 20px;text-align:center;margin-bottom:24px;}
            .otp-label{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#9aa0b4;margin-bottom:14px;}
            .otp-code{font-size:42px;font-weight:700;letter-spacing:10px;color:#e74c3c;font-family:"Courier New",monospace;}
            .otp-expiry{font-size:12px;color:#9aa0b4;margin-top:12px;}
            .tip{background:#1e2538;border-left:3px solid #e74c3c;border-radius:6px;padding:14px 16px;font-size:12px;color:#9aa0b4;line-height:1.6;}
            .tip strong{color:#e2e5ef;}
            .footer{background:#0f1117;padding:20px 36px;text-align:center;font-size:11px;color:#4a5068;line-height:1.8;}
        </style></head>
        <body><div class="outer"><div class="wrap">
            <div class="header"><h1>BIS</h1><p>Barangay Management</p></div>
            <div class="body">
                <h2>Password Change Request</h2>
                <p>Hi <strong>' . htmlspecialchars($toName) . '</strong>,<br><br>
                We received a request to change your account password. Use the code below to verify:</p>
                <div class="otp-box">
                    <div class="otp-label">Your Verification Code</div>
                    <div class="otp-code">' . $otp . '</div>
                    <div class="otp-expiry">This code will expire in 15 minutes.</div>
                </div>
                <div class="tip">
                    <strong>Security Alert:</strong> If you did not request a password change, please ignore this email and secure your account immediately.
                </div>
            </div>
            <div class="footer">This is an automated message from BIS.<br>Please do not reply to this email.<br>&copy; ' . date('Y') . ' BIS. All rights reserved.</div>
        </div></div></body></html>';

        $this->mailer->setTo($toEmail, $toName);
        $this->mailer->setSubject($subject);
        $this->mailer->setMessage($body);

        return $this->mailer->send();
    }

    /**
     * Send a 6-digit OTP for password reset (forgot password flow).
     */
    public function sendPasswordResetOtp(string $toEmail, string $toName, string $otp): bool
    {
        $subject = 'Password Reset Code - BIS';

        $body = '<!DOCTYPE html><html><head><meta charset="UTF-8">
        <style>
            body{margin:0;padding:0;background:#0f1117;font-family:Arial,sans-serif;}
            .outer{background:#0f1117;padding:40px 16px;}
            .wrap{max-width:540px;margin:0 auto;background:#161b27;border-radius:12px;overflow:hidden;}
            .header{background:linear-gradient(135deg,#1d2448 0%,#2e3a6e 100%);padding:32px 36px;text-align:center;}
            .header h1{color:#fff;font-size:26px;font-weight:700;margin:0 0 4px;letter-spacing:1px;}
            .header p{color:rgba(255,255,255,0.75);font-size:13px;margin:0;}
            .body{padding:36px 36px 28px;color:#e2e5ef;}
            .body h2{font-size:20px;font-weight:700;color:#fff;margin:0 0 16px;}
            .body p{font-size:14px;line-height:1.7;color:#9aa0b4;margin:0 0 24px;}
            .otp-box{background:#0f1117;border-radius:10px;padding:28px 20px;text-align:center;margin-bottom:24px;}
            .otp-label{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#9aa0b4;margin-bottom:14px;}
            .otp-code{font-size:42px;font-weight:700;letter-spacing:10px;color:#16c79a;font-family:"Courier New",monospace;}
            .otp-expiry{font-size:12px;color:#9aa0b4;margin-top:12px;}
            .tip{background:#1e2538;border-left:3px solid #16c79a;border-radius:6px;padding:14px 16px;font-size:12px;color:#9aa0b4;line-height:1.6;}
            .tip strong{color:#e2e5ef;}
            .footer{background:#0f1117;padding:20px 36px;text-align:center;font-size:11px;color:#4a5068;line-height:1.8;}
        </style></head>
        <body><div class="outer"><div class="wrap">
            <div class="header"><h1>BIS</h1><p>Barangay Management</p></div>
            <div class="body">
                <h2>Password Reset Request</h2>
                <p>Hi <strong>' . htmlspecialchars($toName) . '</strong>,<br><br>
                We received a request to reset your password. Use the code below to set a new password:</p>
                <div class="otp-box">
                    <div class="otp-label">Your Password Reset Code</div>
                    <div class="otp-code">' . $otp . '</div>
                    <div class="otp-expiry">This code will expire in 15 minutes.</div>
                </div>
                <div class="tip">
                    <strong>Security Note:</strong> If you did not request a password reset, you can safely ignore this email. Your password will not change.
                </div>
            </div>
            <div class="footer">This is an automated message from BIS.<br>Please do not reply to this email.<br>&copy; ' . date('Y') . ' BIS. All rights reserved.</div>
        </div></div></body></html>';

        $this->mailer->setTo($toEmail, $toName);
        $this->mailer->setSubject($subject);
        $this->mailer->setMessage($body);

        return $this->mailer->send();
    }

    /**
     * Send a summons letter to a party involved in a blotter case.
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
        $subject = 'SUMMONS — Barangay Blotter Case #' . $caseNo;

        $body = '<!DOCTYPE html><html><head><meta charset="UTF-8">
        <style>
            body{margin:0;padding:0;background:#f5f6fa;font-family:Arial,sans-serif;}
            .outer{background:#f5f6fa;padding:40px 16px;}
            .wrap{max-width:560px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);}
            .header{background:linear-gradient(135deg,#1d2448 0%,#2e3a6e 100%);padding:32px 36px;text-align:center;}
            .header h1{color:#fff;font-size:22px;font-weight:700;margin:0 0 4px;}
            .header p{color:rgba(255,255,255,0.7);font-size:13px;margin:0;}
            .body{padding:32px 36px;color:#1a1d2e;}
            .body h2{font-size:18px;font-weight:700;color:#1d2448;margin:0 0 16px;}
            .body p{font-size:14px;line-height:1.7;color:#4a5068;margin:0 0 14px;}
            .case-box{background:#f0f4ff;border:1px solid #d0d8f5;border-radius:8px;padding:16px 20px;margin:20px 0;}
            .case-box table{width:100%;border-collapse:collapse;}
            .case-box td{padding:5px 0;font-size:13px;color:#4a5068;}
            .case-box td:first-child{font-weight:700;color:#1d2448;width:140px;}
            .hearing-box{background:#fff8f0;border:1px solid #fde8c8;border-radius:8px;padding:16px 20px;margin:20px 0;text-align:center;}
            .hearing-box .date{font-size:22px;font-weight:700;color:#1d2448;margin:4px 0;}
            .hearing-box .time{font-size:16px;color:#b7600a;font-weight:600;}
            .hearing-box .label{font-size:11px;color:#9aa0b4;text-transform:uppercase;letter-spacing:.5px;}
            .warning{background:#fff0f1;border-left:4px solid #c0392b;padding:12px 16px;font-size:13px;color:#c0392b;margin:20px 0;border-radius:0 6px 6px 0;}
            .footer{background:#f5f6fa;padding:20px 36px;text-align:center;font-size:11px;color:#9aa0b4;line-height:1.8;}
        </style></head>
        <body><div class="outer"><div class="wrap">
            <div class="header">
                <h1>BARANGAY BACOLOD</h1>
                <p>Bato, Camarines Sur — Office of the Punong Barangay</p>
            </div>
            <div class="body">
                <h2>SUMMONS</h2>
                <p>Dear <strong>' . htmlspecialchars($toName) . '</strong>,</p>
                <p>You are hereby summoned to appear before the <strong>Barangay Lupon ng Tagapamayapa</strong> in connection with the following blotter case filed against you / involving you:</p>

                <div class="case-box">
                    <table>
                        <tr><td>Case No.</td><td>#' . htmlspecialchars($caseNo) . '</td></tr>
                        <tr><td>Incident Type</td><td>' . htmlspecialchars($incidentType) . '</td></tr>
                        <tr><td>Your Role</td><td>' . ucfirst(htmlspecialchars($role)) . '</td></tr>
                    </table>
                </div>

                <p>You are required to attend the scheduled hearing on:</p>

                <div class="hearing-box">
                    <div class="label">Hearing Schedule</div>
                    <div class="date">' . htmlspecialchars($hearingDate) . '</div>
                    <div class="time">' . htmlspecialchars($hearingTime) . '</div>
                    <div style="font-size:12px;color:#9aa0b4;margin-top:6px;">Barangay Hall, Bacolod, Bato, Camarines Sur</div>
                </div>

                <div class="warning">
                    <strong>Important:</strong> Failure to appear without valid reason may result in further legal action in accordance with the Katarungang Pambarangay Law (RA 7160).
                </div>

                <p>Please bring a valid government-issued ID and any relevant documents or evidence related to this case.</p>
                <p>For inquiries, contact the Barangay Hall at (054) 123-4567 or visit during office hours (Mon–Fri, 8:00 AM – 5:00 PM).</p>
            </div>
            <div class="footer">
                This is an official communication from Barangay Bacolod, Bato, Camarines Sur.<br>
                Issued by the Office of the Punong Barangay.<br>
                &copy; ' . date('Y') . ' Barangay Bacolod. All rights reserved.
            </div>
        </div></div></body></html>';

        $this->mailer->setTo($toEmail, $toName);
        $this->mailer->setSubject($subject);
        $this->mailer->setMessage($body);

        return $this->mailer->send();
    }
}
