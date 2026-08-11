<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Privacy Policy - Barangay Bacolod BIS</title>
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

    .nav-links a:hover {
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
      font-size: 15px;
      color: rgba(255, 255, 255, .65);
    }

    .content-wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 60px 24px;
      display: grid;
      grid-template-columns: 260px 1fr;
      gap: 48px;
      align-items: start;
    }

    .sidebar {
      position: sticky;
      top: 88px;
    }

    .sidebar-nav {
      background: #fff;
      border: 1px solid var(--gray-mid);
      border-radius: 14px;
      overflow: hidden;
    }

    .sidebar-nav-title {
      padding: 16px 20px;
      font-size: 12px;
      font-weight: 700;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: .8px;
      background: var(--gray-light);
      border-bottom: 1px solid var(--gray-mid);
    }

    .sidebar-nav a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 13px 20px;
      font-size: 13px;
      font-weight: 500;
      color: var(--text-muted);
      text-decoration: none;
      border-bottom: 1px solid var(--gray-mid);
      transition: background .2s, color .2s;
    }

    .sidebar-nav a:last-child {
      border-bottom: none;
    }

    .sidebar-nav a:hover,
    .sidebar-nav a.active {
      background: var(--gray-light);
      color: var(--navy);
    }

    .sidebar-nav a i {
      width: 16px;
      text-align: center;
      color: var(--accent);
    }

    .main-content {}

    .policy-section {
      margin-bottom: 48px;
      scroll-margin-top: 88px;
    }

    .policy-section-header {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 20px;
      padding-bottom: 14px;
      border-bottom: 2px solid var(--gray-mid);
    }

    .policy-section-icon {
      width: 44px;
      height: 44px;
      background: var(--navy);
      color: #fff;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
    }

    .policy-section-header h2 {
      font-size: 20px;
      font-weight: 700;
      color: var(--navy);
    }

    .policy-section p {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.85;
      margin-bottom: 14px;
    }

    .policy-section p:last-child {
      margin-bottom: 0;
    }

    .policy-section ul {
      margin: 12px 0 14px 20px;
    }

    .policy-section ul li {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.8;
      margin-bottom: 6px;
    }

    .highlight-box {
      background: var(--gray-light);
      border-left: 4px solid var(--accent);
      border-radius: 0 10px 10px 0;
      padding: 16px 20px;
      margin: 16px 0;
    }

    .highlight-box p {
      margin: 0;
      font-size: 13px;
      color: var(--text-dark);
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

    @media(max-width:900px) {
      .content-wrap {
        grid-template-columns: 1fr;
      }

      .sidebar {
        position: static;
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

    @media(max-width:768px) {
      .nav-links {
        display: none;
      }

      .hamburger {
        display: flex;
      }
    }
  </style>
</head>

<body>
  <nav class="navbar" id="navbar">
    <div class="nav-inner">
      <a href="/" class="nav-brand"><img src="/bacolod.png" alt="Bacolod Logo"><span>Bacolod BIS</span></a>
      <div class="nav-links">
        <a href="/">Home</a><a href="/#services">Services</a><a href="/#about">About</a><a href="/faqs">FAQs</a>
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
    <h1><i class="fas fa-shield-alt" style="margin-right:12px;opacity:.8;"></i>Privacy Policy</h1>
    <p>Last updated: June 2026</p>
  </div>

  <div class="content-wrap">
    <aside class="sidebar">
      <nav class="sidebar-nav">
        <div class="sidebar-nav-title">Contents</div>
        <a href="#info-collect" class="active"><i class="fas fa-database"></i> Information We Collect</a>
        <a href="#how-use"><i class="fas fa-cogs"></i> How We Use Your Info</a>
        <a href="#data-sharing"><i class="fas fa-share-alt"></i> Data Sharing</a>
        <a href="#data-security"><i class="fas fa-lock"></i> Data Security</a>
        <a href="#your-rights"><i class="fas fa-user-shield"></i> Your Rights (RA 10173)</a>
        <a href="#cookies"><i class="fas fa-cookie-bite"></i> Cookies</a>
        <a href="#contact-us"><i class="fas fa-envelope"></i> Contact Us</a>
      </nav>
    </aside>

    <main class="main-content">
      <div class="highlight-box">
        <p><strong>Your privacy matters to us.</strong> This Privacy Policy explains how Barangay Bacolod, Bato, Camarines Sur collects, uses, and protects your personal information in compliance with the Data Privacy Act of 2012 (Republic Act No. 10173).</p>
      </div>

      <div class="policy-section" id="info-collect">
        <div class="policy-section-header">
          <div class="policy-section-icon"><i class="fas fa-database"></i></div>
          <h2>1. Information We Collect</h2>
        </div>
        <p>We collect personal information that you voluntarily provide when you register for an account, request barangay documents, or file a blotter report. This includes your full name, date of birth, address, household number, contact number, email address, username, and profile photo (avatar) if uploaded.</p>
        <p>For resident account registration, we verify your identity by matching your submitted name against the barangay census record associated with your household number. This is required to confirm that only actual residents of Barangay Bacolod can self-register.</p>
        <p>We also collect household and census information including household composition, civil status, occupation, educational attainment, and socioeconomic indicators such as income, PWD status, senior citizen status, 4Ps membership, and indigency. This information is used solely for barangay governance and service delivery purposes.</p>
        <p>Additionally, we automatically collect certain technical information when you use our portal, such as your IP address, browser type, and pages visited. This data is used for system security and performance monitoring only.</p>
      </div>

      <div class="policy-section" id="how-use">
        <div class="policy-section-header">
          <div class="policy-section-icon"><i class="fas fa-cogs"></i></div>
          <h2>2. How We Use Your Information</h2>
        </div>
        <p>Your personal information is used to process and fulfill your requests for barangay documents and services, verify your identity and residency status against the barangay census, and communicate with you about your account, document requests, and blotter cases.</p>
        <p>We use your email address to send One-Time Passwords (OTPs) for account registration verification, email verification, password resets, and password change requests. These are security measures to protect your account from unauthorized access.</p>
        <p>We use census and household data to generate statistical and demographic reports for barangay planning, identify residents eligible for government programs and benefits, manage the SK youth profiling module, and comply with reporting requirements from higher government units.</p>
        <p>Profile photos (avatars) you upload are stored and displayed within the portal for identification purposes only and are not shared externally. We will not use your information for commercial marketing purposes.</p>
      </div>

      <div class="policy-section" id="data-sharing">
        <div class="policy-section-header">
          <div class="policy-section-icon"><i class="fas fa-share-alt"></i></div>
          <h2>3. Data Sharing</h2>
        </div>
        <p>We do not sell, trade, or rent your personal information to third parties. Your data may be shared with other government agencies (such as the Municipal Government of Bato, DSWD, or PhilHealth) only when required by law or when necessary to deliver government services you have requested.</p>
        <p>Blotter reports and related information may be shared with law enforcement agencies when required by legal process or when there is an imminent threat to public safety. Such disclosures are made in accordance with applicable laws and regulations.</p>
        <p>Aggregated, anonymized statistical data (with no personally identifiable information) may be shared with government planning bodies for community development purposes.</p>
      </div>

      <div class="policy-section" id="data-security">
        <div class="policy-section-header">
          <div class="policy-section-icon"><i class="fas fa-lock"></i></div>
          <h2>4. Data Security</h2>
        </div>
        <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. Passwords are stored using industry-standard bcrypt hashing algorithms and are never stored in plain text.</p>
        <p>Account access is protected by role-based authentication. Each user role (Resident, SK, Captain, Secretary, Treasurer) can only access the sections of the system relevant to their duties. The system enforces access controls at the route level to prevent unauthorized access to administrative functions.</p>
        <p>Account approval is required before any newly registered account can log in, adding an additional verification layer to prevent unauthorized access. Password changes require OTP verification sent to your registered email address.</p>
        <p>While we strive to protect your personal information, no method of transmission over the internet or electronic storage is 100% secure. We encourage you to use strong, unique passwords and to log out after each session, especially on shared or public devices.</p>
      </div>

      <div class="policy-section" id="your-rights">
        <div class="policy-section-header">
          <div class="policy-section-icon"><i class="fas fa-user-shield"></i></div>
          <h2>5. Your Rights Under RA 10173</h2>
        </div>
        <p>Under the Data Privacy Act of 2012 (Republic Act No. 10173), you have the following rights regarding your personal data:</p>
        <ul>
          <li><strong>Right to be Informed</strong> — You have the right to know how your personal data is being collected and processed.</li>
          <li><strong>Right to Access</strong> — You may request a copy of your personal data held by the barangay.</li>
          <li><strong>Right to Rectification</strong> — You may request correction of inaccurate or incomplete personal data.</li>
          <li><strong>Right to Erasure</strong> — You may request deletion of your personal data, subject to legal retention requirements.</li>
          <li><strong>Right to Object</strong> — You may object to the processing of your personal data for specific purposes.</li>
          <li><strong>Right to Data Portability</strong> — You may request your personal data in a structured, commonly used format.</li>
        </ul>
        <p>To exercise any of these rights, please contact the Barangay Secretary at the barangay hall or via email. We will respond to your request within 15 business days.</p>
      </div>

      <div class="policy-section" id="cookies">
        <div class="policy-section-header">
          <div class="policy-section-icon"><i class="fas fa-cookie-bite"></i></div>
          <h2>6. Cookies</h2>
        </div>
        <p>The BIS portal uses session cookies to maintain your login state and provide a seamless experience. These cookies are temporary and are deleted when you close your browser. We do not use tracking cookies or third-party advertising cookies.</p>
        <p>We may use functional cookies to remember your preferences, such as language settings. These cookies do not collect personally identifiable information and are used solely to improve your experience on the portal.</p>
        <p>You can configure your browser to refuse cookies, but this may affect the functionality of the portal, including your ability to log in and access services.</p>
      </div>

      <div class="policy-section" id="contact-us">
        <div class="policy-section-header">
          <div class="policy-section-icon"><i class="fas fa-envelope"></i></div>
          <h2>7. Contact Us</h2>
        </div>
        <p>If you have questions, concerns, or requests regarding this Privacy Policy or the handling of your personal data, please contact us through any of the following channels:</p>
        <ul>
          <li><strong>In Person:</strong> Barangay Hall, Barangay Bacolod, Bato, Camarines Sur</li>
          <li><strong>Email:</strong> barangaybacolod@bato.gov.ph</li>
          <li><strong>Phone:</strong> +63 (054) 000-0000</li>
          <li><strong>Office Hours:</strong> Monday to Friday, 8:00 AM – 5:00 PM</li>
        </ul>
        <p>We reserve the right to update this Privacy Policy from time to time. Any changes will be posted on this page with an updated revision date. We encourage you to review this policy periodically.</p>
      </div>
    </main>
  </div>

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
      // Update active sidebar link
      var sections = document.querySelectorAll('.policy-section');
      var links = document.querySelectorAll('.sidebar-nav a');
      var current = '';
      sections.forEach(function(s) {
        if (window.scrollY >= s.offsetTop - 100) current = '#' + s.id;
      });
      links.forEach(function(l) {
        l.classList.toggle('active', l.getAttribute('href') === current);
      });
    });
    document.getElementById('hamburger').addEventListener('click', function() {
      document.getElementById('mobileMenu').classList.toggle('open');
    });
  </script>
</body>

</html>