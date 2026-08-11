<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQs - Barangay Bacolod BIS</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    :root {
      --navy: #1d2448;
      --navy-mid: #2e3a6e;
      --navy-dark: #0f1117;
      --accent: #5b6fd6;
      --accent-light: #7b8fe8;
      --white: #ffffff;
      --gray-light: #f4f6fb;
      --gray-mid: #e8ecf4;
      --text-dark: #1a1d2e;
      --text-muted: #6b7280;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
      overflow-x: hidden;
    }

    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      background: #fff;
      transition: box-shadow .3s;
    }

    .navbar.scrolled {
      box-shadow: 0 2px 20px rgba(0, 0, 0, .10);
    }

    .nav-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
      height: 68px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .nav-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .nav-brand img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: contain;
    }

    .nav-brand span {
      font-size: 16px;
      font-weight: 700;
      color: var(--navy);
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .nav-links a {
      font-size: 14px;
      font-weight: 500;
      color: var(--text-dark);
      text-decoration: none;
      padding: 8px 14px;
      border-radius: 8px;
      transition: background .2s, color .2s;
    }

    .nav-links a:hover,
    .nav-links a.active {
      background: var(--gray-light);
      color: var(--navy);
    }

    .nav-divider {
      width: 1px;
      height: 24px;
      background: var(--gray-mid);
      margin: 0 8px;
    }

    .btn-login {
      background: var(--navy);
      color: #fff !important;
      padding: 9px 20px !important;
      border-radius: 8px !important;
      font-weight: 600 !important;
    }

    .btn-login:hover {
      background: var(--navy-mid) !important;
    }

    .btn-signup {
      border: 2px solid var(--navy);
      color: var(--navy) !important;
      padding: 7px 18px !important;
      border-radius: 8px !important;
      font-weight: 600 !important;
    }

    .btn-signup:hover {
      background: var(--navy);
      color: #fff !important;
    }

    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      padding: 8px;
      border: none;
      background: none;
    }

    .hamburger span {
      display: block;
      width: 24px;
      height: 2px;
      background: var(--navy);
      border-radius: 2px;
    }

    .mobile-menu {
      display: none;
      position: fixed;
      top: 68px;
      left: 0;
      right: 0;
      background: #fff;
      border-top: 1px solid var(--gray-mid);
      padding: 16px 24px;
      z-index: 999;
      box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
    }

    .mobile-menu.open {
      display: block;
    }

    .mobile-menu a {
      display: block;
      padding: 12px 0;
      font-size: 15px;
      font-weight: 500;
      color: var(--text-dark);
      text-decoration: none;
      border-bottom: 1px solid var(--gray-mid);
    }

    .mobile-menu a:last-child {
      border-bottom: none;
    }

    .mobile-menu .btn-login,
    .mobile-menu .btn-signup {
      display: block;
      text-align: center;
      margin-top: 8px;
      padding: 12px !important;
      border-radius: 8px !important;
    }

    .page-hero {
      background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
      padding: 100px 24px 60px;
      text-align: center;
      margin-top: 68px;
    }

    .page-hero h1 {
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: 800;
      color: #fff;
      margin-bottom: 12px;
    }

    .page-hero p {
      font-size: 16px;
      color: rgba(255, 255, 255, .75);
      max-width: 520px;
      margin: 0 auto;
    }

    .faq-main {
      max-width: 860px;
      margin: 0 auto;
      padding: 60px 24px;
    }

    .search-wrap {
      position: relative;
      margin-bottom: 48px;
    }

    .search-wrap input {
      width: 100%;
      padding: 14px 20px 14px 50px;
      border: 2px solid var(--gray-mid);
      border-radius: 12px;
      font-size: 15px;
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    .search-wrap input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(91, 111, 214, .1);
    }

    .search-wrap i {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 16px;
    }

    .faq-category {
      margin-bottom: 48px;
    }

    .faq-category-title {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 18px;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 2px solid var(--gray-mid);
    }

    .faq-category-title i {
      width: 36px;
      height: 36px;
      background: var(--navy);
      color: #fff;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
    }

    .accordion-item {
      border: 1px solid var(--gray-mid);
      border-radius: 12px;
      margin-bottom: 10px;
      overflow: hidden;
      transition: box-shadow .2s;
    }

    .accordion-item:hover {
      box-shadow: 0 4px 16px rgba(29, 36, 72, .07);
    }

    .accordion-item.hidden {
      display: none;
    }

    .accordion-header {
      padding: 18px 20px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      background: #fff;
      user-select: none;
    }

    .accordion-header:hover {
      background: var(--gray-light);
    }

    .accordion-question {
      font-size: 15px;
      font-weight: 600;
      color: var(--navy);
      flex: 1;
    }

    .accordion-icon {
      width: 28px;
      height: 28px;
      border-radius: 6px;
      background: var(--gray-light);
      color: var(--navy);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      flex-shrink: 0;
      transition: background .2s, transform .3s;
    }

    .accordion-item.open .accordion-icon {
      background: var(--navy);
      color: #fff;
      transform: rotate(180deg);
    }

    .accordion-body {
      max-height: 0;
      overflow: hidden;
      transition: max-height .35s ease, padding .35s ease;
    }

    .accordion-item.open .accordion-body {
      max-height: 400px;
    }

    .accordion-body-inner {
      padding: 0 20px 20px;
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.8;
      border-top: 1px solid var(--gray-mid);
    }

    .no-results {
      text-align: center;
      padding: 48px 24px;
      color: var(--text-muted);
    }

    .no-results i {
      font-size: 40px;
      margin-bottom: 12px;
      color: var(--gray-mid);
    }

    footer {
      background: var(--navy-dark);
      padding: 60px 24px 0;
    }

    .footer-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.5fr 1fr 1.2fr;
      gap: 48px;
      padding-bottom: 48px;
    }

    .footer-brand img {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      margin-bottom: 14px;
    }

    .footer-brand h3 {
      font-size: 17px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 8px;
    }

    .footer-brand p {
      font-size: 13px;
      color: rgba(255, 255, 255, .5);
      line-height: 1.7;
      margin-bottom: 20px;
    }

    .social-links {
      display: flex;
      gap: 10px;
    }

    .social-links a {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      background: rgba(255, 255, 255, .08);
      color: rgba(255, 255, 255, .6);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      text-decoration: none;
      transition: background .2s, color .2s;
    }

    .social-links a:hover {
      background: var(--accent);
      color: #fff;
    }

    .footer-col h4 {
      font-size: 14px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 18px;
      text-transform: uppercase;
      letter-spacing: .5px;
    }

    .footer-col ul {
      list-style: none;
    }

    .footer-col ul li {
      margin-bottom: 10px;
    }

    .footer-col ul li a {
      font-size: 13px;
      color: rgba(255, 255, 255, .5);
      text-decoration: none;
      transition: color .2s;
    }

    .footer-col ul li a:hover {
      color: #fff;
    }

    .footer-contact-item {
      display: flex;
      gap: 12px;
      margin-bottom: 14px;
    }

    .footer-contact-item i {
      color: var(--accent);
      font-size: 14px;
      margin-top: 2px;
      flex-shrink: 0;
    }

    .footer-contact-item span {
      font-size: 13px;
      color: rgba(255, 255, 255, .5);
      line-height: 1.6;
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, .08);
      padding: 20px 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
    }

    .footer-bottom p {
      font-size: 12px;
      color: rgba(255, 255, 255, .35);
    }

    .footer-bottom-links {
      display: flex;
      gap: 20px;
    }

    .footer-bottom-links a {
      font-size: 12px;
      color: rgba(255, 255, 255, .35);
      text-decoration: none;
      transition: color .2s;
    }

    .footer-bottom-links a:hover {
      color: rgba(255, 255, 255, .7);
    }

    @media(max-width:768px) {
      .nav-links {
        display: none;
      }

      .hamburger {
        display: flex;
      }

      .footer-inner {
        grid-template-columns: 1fr;
        gap: 32px;
      }

      .footer-bottom {
        flex-direction: column;
        text-align: center;
      }
    }
  </style>
</head>

<body>
  <nav class="navbar" id="navbar">
    <div class="nav-inner">
      <a href="/" class="nav-brand"><img src="/bacolod.png" alt="Bacolod Logo"><span>Bacolod BIS</span></a>
      <div class="nav-links">
        <a href="/">Home</a><a href="/#services">Services</a><a href="/#about">About</a><a href="/faqs" class="active">FAQs</a>
        <div class="nav-divider"></div>
        <a href="/login" class="btn-login">Login</a><a href="/signup" class="btn-signup">Sign Up</a>
      </div>
      <button class="hamburger" id="hamburger"><span></span><span></span><span></span></button>
    </div>
  </nav>
  <div class="mobile-menu" id="mobileMenu">
    <a href="/">Home</a><a href="/#services">Services</a><a href="/#about">About</a><a href="/faqs">FAQs</a>
    <a href="/login" class="btn-login">Login</a><a href="/signup" class="btn-signup">Sign Up</a>
  </div>

  <div class="page-hero">
    <h1><i class="fas fa-question-circle" style="margin-right:12px;opacity:.8;"></i>Frequently Asked Questions</h1>
    <p>Find answers to common questions about the Barangay Bacolod Information System and our services.</p>
  </div>

  <main class="faq-main">
    <div class="search-wrap">
      <i class="fas fa-search"></i>
      <input type="text" id="faqSearch" placeholder="Search questions..." oninput="filterFAQs(this.value)">
    </div>

    <div id="noResults" class="no-results" style="display:none;">
      <i class="fas fa-search"></i>
      <p>No questions found matching your search.</p>
    </div>

    <!-- General -->
    <div class="faq-category" data-category="general">
      <div class="faq-category-title"><i class="fas fa-info"></i> General</div>
      <div class="accordion-item" data-question="what is barangay information system bis">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">What is the Barangay Information System (BIS)?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">The Barangay Information System (BIS) is the official digital platform of Barangay Bacolod, Bato, Camarines Sur. It allows residents to request barangay documents, file blotter reports, and access community information online — reducing the need for in-person visits to the barangay hall. Barangay officials use the system to manage the census, process requests, handle blotter cases, publish community schedules, and generate demographic reports.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="who can use the bis portal residents roles captain secretary sk treasurer">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">Who can use the BIS portal?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">
            The portal serves five user roles:
            <ul style="margin-top:8px;padding-left:18px;">
              <li><strong>Residents</strong> — Request clearances, file blotter reports, view notifications, and manage their profile.</li>
              <li><strong>SK (Sangguniang Kabataan)</strong> — Access the SK youth profiling module and community programs.</li>
              <li><strong>Captain</strong> — Approve/reject clearances and accounts, manage the census, oversee blotter cases, publish schedules, and view demographic reports.</li>
              <li><strong>Secretary</strong> — Full administrative access including census management, clearance processing, blotter management, account management, and report generation.</li>
              <li><strong>Treasurer</strong> — Access payment and clearance-related financial records.</li>
            </ul>
            Non-residents may also file a public blotter report without creating an account.
          </div>
        </div>
      </div>
      <div class="accordion-item" data-question="is the bis portal free to use cost">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">Is the BIS portal free to use?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Yes, creating an account and using the BIS portal is completely free. However, some barangay documents may have standard processing fees as mandated by local ordinance. These fees are paid at the barangay hall when you pick up your document.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="what services are available online barangay features census calendar schedule reports sk">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">What services are available through the portal?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">
            The BIS portal currently provides the following services:
            <ul style="margin-top:8px;padding-left:18px;">
              <li><strong>Barangay Clearance</strong> — Request, track, and receive notifications on clearance requests online.</li>
              <li><strong>Blotter Reports</strong> — File incident reports and track their status. Open to both registered residents and the general public.</li>
              <li><strong>Census Management</strong> — Officials manage household records and member data. Residents can view their own household profile.</li>
              <li><strong>Community Calendar</strong> — Officials can publish and manage barangay events and schedules.</li>
              <li><strong>SK Youth Profiling</strong> — SK officers can manage youth records linked to the barangay census.</li>
              <li><strong>Demographic Reports</strong> — Officials can generate and export population and sectoral reports.</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="accordion-item" data-question="what are the office hours barangay hall schedule">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">What are the barangay hall office hours?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">The Barangay Hall of Bacolod, Bato, Camarines Sur is open Monday to Friday, 8:00 AM to 5:00 PM. The online portal is available 24/7 for submitting requests, but processing is done during office hours only.</div>
        </div>
      </div>
    </div>

    <!-- Account & Registration -->
    <div class="faq-category" data-category="account">
      <div class="faq-category-title"><i class="fas fa-user"></i> Account &amp; Registration</div>
      <div class="accordion-item" data-question="how to create account register sign up resident sk">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">How can I create an account?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">
            Residents and SK (Sangguniang Kabataan) members can self-register through the Sign Up page (<strong>/signup</strong>). Here's how the process works:
            <br><br>
            <strong>Step 1 — Fill out the form.</strong> Provide your full name, email address, a unique username, your desired password, and — for residents — your Household Number as recorded in the barangay census. Your full name must exactly match the name on record under that household.
            <br><br>
            <strong>Step 2 — Verify your email.</strong> A 6-digit One-Time Password (OTP) is sent to your email address. Enter it on the verification page within 15 minutes. You can request a new code if it expires.
            <br><br>
            <strong>Step 3 — Wait for approval.</strong> Once your email is verified, your account status becomes <em>Pending</em>. The Barangay Captain or Secretary will review and approve it, typically within 1–3 business days. You will receive an email once your account is approved and active.
            <br><br>
            <strong>Captain, Secretary, and Treasurer accounts</strong> are not self-registered. They are created directly by authorized barangay officials (the Secretary creates Captain and SK accounts; the Captain creates Secretary and Treasurer accounts).
          </div>
        </div>
      </div>
      <div class="accordion-item" data-question="who can self register sign up account roles">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">Who can register through the Sign Up page?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Only <strong>Residents</strong> and <strong>SK (Sangguniang Kabataan)</strong> members can create their own accounts via the public Sign Up page. Accounts for the Barangay Captain, Secretary, and Treasurer are created internally by authorized officials and are not available for public self-registration.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="household number census verification resident registration">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">Where can I find my Household Number?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Your Household Number is assigned during the barangay census. You can find it on any previously issued barangay document (such as a Barangay Clearance or Certificate of Residency), or by visiting the barangay hall and asking the Secretary to look it up. The number must match an existing entry in the census for your registration to proceed.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="forgot password reset account login otp">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">What should I do if I forgot my password?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">On the login page, click <strong>"Forgot password?"</strong> and enter your registered email address. A 6-digit OTP will be sent to your inbox. Enter the code to verify your identity, then set a new password. The code is valid for 15 minutes — you can request a new one if needed. If you no longer have access to your registered email, please visit the barangay hall in person for assistance.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="how long account approval pending waiting">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">How long does account approval take?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Account approval typically takes 1–3 business days. The Barangay Captain or Secretary reviews each registration to confirm residency and census details. You will receive an email notification once your account is approved. If your account has not been approved after 3 business days, please contact the barangay hall directly.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="can i update my profile information personal details avatar password">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">Can I update my profile and change my password?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Yes. Once logged in, go to your Settings page to update your profile details, upload a profile photo (avatar), and change your password. Password changes require OTP verification sent to your registered email for security. For changes to your name or address in the official census record, please visit the barangay hall with a valid ID.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="is my personal data safe secure privacy">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">Is my personal data safe on the portal?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Yes. The BIS portal complies with the Data Privacy Act of 2012 (RA 10173). Passwords are stored using secure hashing and are never saved in plain text. Your personal information is only accessible to authorized barangay officials for legitimate purposes. We do not share your data with third parties without your consent. Please review our <a href="/privacy-policy" style="color:var(--accent);">Privacy Policy</a> for full details.</div>
        </div>
      </div>
    </div>

    <!-- Documents & Clearances -->
    <div class="faq-category" data-category="documents">
      <div class="faq-category-title"><i class="fas fa-file-alt"></i> Documents &amp; Clearances</div>
      <div class="accordion-item" data-question="how to request barangay clearance certificate">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">How do I request a Barangay Clearance?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Log in to your account and go to the Clearance section. Click "Request Clearance" and fill out the required form, including the purpose of the clearance. Submit your request and wait for approval from barangay officials. You will be notified via email when your clearance is ready for pickup.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="what documents requirements needed clearance">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">What are the requirements for requesting documents?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Requirements vary by document type. Generally, you need: (1) A verified BIS account, (2) Valid government-issued ID (presented upon pickup), and (3) Proof of residency if not yet in the census. For Certificate of Indigency, additional proof of income may be required. Specific requirements are shown during the request process.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="how long processing time document clearance">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">How long does document processing take?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Standard processing time is 1–3 business days from the date of submission. Urgent requests may be accommodated at the barangay hall's discretion. You can track the status of your request in real time through your account dashboard.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="fees cost barangay clearance certificate payment">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">Are there fees for barangay documents?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Standard fees apply as set by local ordinance. Barangay Clearance typically costs PHP 50–100. Certificate of Residency and Certificate of Indigency may have minimal fees. Indigent residents may be exempt from fees upon verification. Fees are paid at the barangay hall when you pick up your document.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="can i cancel request clearance document">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">Can I cancel a document request?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Yes, you can cancel a pending request from your account dashboard as long as it has not yet been approved. Once a request is approved or in processing, cancellation must be done in person at the barangay hall. Approved documents that are not picked up within 30 days will be voided.</div>
        </div>
      </div>
    </div>

    <!-- Blotter Reports -->
    <div class="faq-category" data-category="blotter">
      <div class="faq-category-title"><i class="fas fa-file-signature"></i> Blotter Reports</div>
      <div class="accordion-item" data-question="how to file blotter report incident complaint">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">How do I file a blotter report?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">You can file a blotter report in two ways: (1) As a registered resident, log in and use the Blotter option in your dashboard. (2) As a non-resident or without an account, use the public blotter form available on the homepage — no login required. In both cases, provide complete details including the complainant name, respondent name, incident type, incident date, and a full description of what happened.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="what happens after blotter report filed process status summons">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">What happens after I file a blotter report?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">After filing, your report is reviewed by the Barangay Captain or Secretary. The case status is updated as it progresses: <strong>Pending → Under Review → Scheduled → Resolved</strong> or <strong>Referred</strong> (to a higher authority). Officials may issue summons to the respondent and schedule a hearing. Hearing schedules can be rescheduled by the official when needed. If you have a registered account, you will be notified of status updates via email.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="is blotter report confidential anonymous privacy official record">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">Is my blotter report kept confidential?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">Blotter reports are official barangay records and are treated with confidentiality. Access is restricted to authorized barangay officials only. However, as official records, they may be disclosed in legal proceedings or upon lawful order. We recommend providing accurate information, as filing false reports may have legal consequences.</div>
        </div>
      </div>
    </div>

    <!-- SK Youth -->
    <div class="faq-category" data-category="sk">
      <div class="faq-category-title"><i class="fas fa-users"></i> SK &amp; Youth</div>
      <div class="accordion-item" data-question="sk sangguniang kabataan account register youth">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">How do SK members create an account?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">SK members can register through the same public Sign Up page (<strong>/signup</strong>) as residents. The process is identical: fill in your details, verify your email via OTP, and wait for approval by the Barangay Captain or Secretary. No household number is required for SK registration.</div>
        </div>
      </div>
      <div class="accordion-item" data-question="sk youth profiling what is it census records">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span class="accordion-question">What is the SK Youth Profiling module?</span>
          <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="accordion-body">
          <div class="accordion-body-inner">The SK Youth Profiling module allows SK officers to manage and track records of the barangay's youth population. Records can be pulled directly from the barangay census (households and members) or added manually. SK officers can view, add, edit, and delete youth profiles, and generate reports for SK programs and government submissions.</div>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <div class="footer-inner">
      <div class="footer-brand">
        <img src="/bacolod.png" alt="Bacolod Logo">
        <h3>Barangay Bacolod BIS</h3>
        <p>Official Barangay Information System of Barangay Bacolod, Bato, Camarines Sur.</p>
        <div class="social-links">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fas fa-envelope"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="/">Home</a></li>
          <li><a href="/#services">Services</a></li>
          <li><a href="/faqs">FAQs</a></li>
          <li><a href="/privacy-policy">Privacy Policy</a></li>
          <li><a href="/terms">Terms of Use</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Contact Us</h4>
        <div class="footer-contact-item"><i class="fas fa-map-marker-alt"></i><span>Barangay Bacolod, Bato, Camarines Sur, Philippines</span></div>
        <div class="footer-contact-item"><i class="fas fa-phone"></i><span>+63 (054) 000-0000</span></div>
        <div class="footer-contact-item"><i class="fas fa-envelope"></i><span>barangaybacolod@bato.gov.ph</span></div>
        <div class="footer-contact-item"><i class="fas fa-clock"></i><span>Mon – Fri: 8:00 AM – 5:00 PM</span></div>
      </div>
    </div>
    <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
      <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Barangay Bacolod, Bato, Camarines Sur. All rights reserved.</p>
        <div class="footer-bottom-links">
          <a href="/privacy-policy">Privacy Policy</a>
          <a href="/terms">Terms of Use</a>
          <a href="/faqs">FAQs</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    window.addEventListener('scroll', function() {
      var n = document.getElementById('navbar');
      n.classList.toggle('scrolled', window.scrollY > 10);
    });
    document.getElementById('hamburger').addEventListener('click', function() {
      document.getElementById('mobileMenu').classList.toggle('open');
    });

    function toggleAccordion(header) {
      var item = header.closest('.accordion-item');
      var isOpen = item.classList.contains('open');
      document.querySelectorAll('.accordion-item.open').forEach(function(i) {
        i.classList.remove('open');
      });
      if (!isOpen) item.classList.add('open');
    }

    function filterFAQs(q) {
      var query = q.toLowerCase().trim();
      var items = document.querySelectorAll('.accordion-item');
      var anyVisible = false;
      items.forEach(function(item) {
        var question = item.getAttribute('data-question') || '';
        var bodyText = item.querySelector('.accordion-body-inner').textContent.toLowerCase();
        var match = !query || question.includes(query) || bodyText.includes(query);
        item.classList.toggle('hidden', !match);
        if (match) anyVisible = true;
      });
      document.querySelectorAll('.faq-category').forEach(function(cat) {
        var visible = cat.querySelectorAll('.accordion-item:not(.hidden)').length > 0;
        cat.style.display = visible ? '' : 'none';
      });
      document.getElementById('noResults').style.display = anyVisible ? 'none' : 'block';
    }
  </script>
</body>

</html>