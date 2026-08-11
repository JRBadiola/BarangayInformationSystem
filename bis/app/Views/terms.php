<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Terms of Use - Barangay Bacolod BIS</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
:root{--navy:#1d2448;--navy-mid:#2e3a6e;--navy-dark:#0f1117;--accent:#5b6fd6;--accent-light:#7b8fe8;--white:#ffffff;--gray-light:#f4f6fb;--gray-mid:#e8ecf4;--text-dark:#1a1d2e;--text-muted:#6b7280;}
*{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
body{font-family:'Poppins',sans-serif;color:var(--text-dark);overflow-x:hidden;}
.navbar{position:fixed;top:0;left:0;right:0;z-index:1000;background:#fff;transition:box-shadow .3s;}
.navbar.scrolled{box-shadow:0 2px 20px rgba(0,0,0,.10);}
.nav-inner{max-width:1200px;margin:0 auto;padding:0 24px;height:68px;display:flex;align-items:center;justify-content:space-between;}
.nav-brand{display:flex;align-items:center;gap:10px;text-decoration:none;}
.nav-brand img{width:40px;height:40px;border-radius:50%;object-fit:contain;}
.nav-brand span{font-size:16px;font-weight:700;color:var(--navy);}
.nav-links{display:flex;align-items:center;gap:6px;}
.nav-links a{font-size:14px;font-weight:500;color:var(--text-dark);text-decoration:none;padding:8px 14px;border-radius:8px;transition:background .2s,color .2s;}
.nav-links a:hover{background:var(--gray-light);color:var(--navy);}
.nav-divider{width:1px;height:24px;background:var(--gray-mid);margin:0 8px;}
.btn-login{background:var(--navy);color:#fff!important;padding:9px 20px!important;border-radius:8px!important;font-weight:600!important;}
.btn-login:hover{background:var(--navy-mid)!important;}
.btn-signup{border:2px solid var(--navy);color:var(--navy)!important;padding:7px 18px!important;border-radius:8px!important;font-weight:600!important;}
.btn-signup:hover{background:var(--navy);color:#fff!important;}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:8px;border:none;background:none;}
.hamburger span{display:block;width:24px;height:2px;background:var(--navy);border-radius:2px;}
.mobile-menu{display:none;position:fixed;top:68px;left:0;right:0;background:#fff;border-top:1px solid var(--gray-mid);padding:16px 24px;z-index:999;box-shadow:0 8px 24px rgba(0,0,0,.08);}
.mobile-menu.open{display:block;}
.mobile-menu a{display:block;padding:12px 0;font-size:15px;font-weight:500;color:var(--text-dark);text-decoration:none;border-bottom:1px solid var(--gray-mid);}
.mobile-menu a:last-child{border-bottom:none;}
.mobile-menu .btn-login,.mobile-menu .btn-signup{display:block;text-align:center;margin-top:8px;padding:12px!important;border-radius:8px!important;}
.page-hero{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-mid) 100%);padding:100px 24px 60px;text-align:center;margin-top:68px;}
.page-hero h1{font-size:clamp(1.8rem,4vw,2.8rem);font-weight:800;color:#fff;margin-bottom:12px;}
.page-hero p{font-size:15px;color:rgba(255,255,255,.65);}
.content-wrap{max-width:1200px;margin:0 auto;padding:60px 24px;display:grid;grid-template-columns:260px 1fr;gap:48px;align-items:start;}
.sidebar{position:sticky;top:88px;}
.sidebar-nav{background:#fff;border:1px solid var(--gray-mid);border-radius:14px;overflow:hidden;}
.sidebar-nav-title{padding:16px 20px;font-size:12px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.8px;background:var(--gray-light);border-bottom:1px solid var(--gray-mid);}
.sidebar-nav a{display:flex;align-items:center;gap:10px;padding:13px 20px;font-size:13px;font-weight:500;color:var(--text-muted);text-decoration:none;border-bottom:1px solid var(--gray-mid);transition:background .2s,color .2s;}
.sidebar-nav a:last-child{border-bottom:none;}
.sidebar-nav a:hover,.sidebar-nav a.active{background:var(--gray-light);color:var(--navy);}
.sidebar-nav a i{width:16px;text-align:center;color:var(--accent);}
.main-content{}
.policy-section{margin-bottom:48px;scroll-margin-top:88px;}
.policy-section-header{display:flex;align-items:center;gap:14px;margin-bottom:20px;padding-bottom:14px;border-bottom:2px solid var(--gray-mid);}
.policy-section-icon{width:44px;height:44px;background:var(--navy);color:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.policy-section-header h2{font-size:20px;font-weight:700;color:var(--navy);}
.policy-section p{font-size:14px;color:var(--text-muted);line-height:1.85;margin-bottom:14px;}
.policy-section p:last-child{margin-bottom:0;}
.policy-section ul{margin:12px 0 14px 20px;}
.policy-section ul li{font-size:14px;color:var(--text-muted);line-height:1.8;margin-bottom:6px;}
.highlight-box{background:var(--gray-light);border-left:4px solid var(--accent);border-radius:0 10px 10px 0;padding:16px 20px;margin:16px 0;}
.highlight-box p{margin:0;font-size:13px;color:var(--text-dark);}
footer{background:var(--navy-dark);padding:60px 24px 0;}
.footer-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1.5fr 1fr 1.2fr;gap:48px;padding-bottom:48px;}
.footer-brand img{width:48px;height:48px;border-radius:50%;margin-bottom:14px;}
.footer-brand h3{font-size:17px;font-weight:700;color:#fff;margin-bottom:8px;}
.footer-brand p{font-size:13px;color:rgba(255,255,255,.5);line-height:1.7;margin-bottom:20px;}
.social-links{display:flex;gap:10px;}
.social-links a{width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,.08);color:rgba(255,255,255,.6);display:flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none;transition:background .2s,color .2s;}
.social-links a:hover{background:var(--accent);color:#fff;}
.footer-col h4{font-size:14px;font-weight:700;color:#fff;margin-bottom:18px;text-transform:uppercase;letter-spacing:.5px;}
.footer-col ul{list-style:none;}
.footer-col ul li{margin-bottom:10px;}
.footer-col ul li a{font-size:13px;color:rgba(255,255,255,.5);text-decoration:none;transition:color .2s;}
.footer-col ul li a:hover{color:#fff;}
.footer-contact-item{display:flex;gap:12px;margin-bottom:14px;}
.footer-contact-item i{color:var(--accent);font-size:14px;margin-top:2px;flex-shrink:0;}
.footer-contact-item span{font-size:13px;color:rgba(255,255,255,.5);line-height:1.6;}
.footer-bottom{border-top:1px solid rgba(255,255,255,.08);padding:20px 0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.footer-bottom p{font-size:12px;color:rgba(255,255,255,.35);}
.footer-bottom-links{display:flex;gap:20px;}
.footer-bottom-links a{font-size:12px;color:rgba(255,255,255,.35);text-decoration:none;transition:color .2s;}
.footer-bottom-links a:hover{color:rgba(255,255,255,.7);}
@media(max-width:900px){.content-wrap{grid-template-columns:1fr;}.sidebar{position:static;}.footer-inner{grid-template-columns:1fr;gap:32px;}.footer-bottom{flex-direction:column;text-align:center;}}
@media(max-width:768px){.nav-links{display:none;}.hamburger{display:flex;}}
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
  <h1><i class="fas fa-file-contract" style="margin-right:12px;opacity:.8;"></i>Terms of Use</h1>
  <p>Last updated: January 1, 2024</p>
</div>

<div class="content-wrap">
  <aside class="sidebar">
    <nav class="sidebar-nav">
      <div class="sidebar-nav-title">Contents</div>
      <a href="#acceptance" class="active"><i class="fas fa-check-circle"></i> Acceptance of Terms</a>
      <a href="#use-system"><i class="fas fa-desktop"></i> Use of the System</a>
      <a href="#user-accounts"><i class="fas fa-user"></i> User Accounts</a>
      <a href="#prohibited"><i class="fas fa-ban"></i> Prohibited Activities</a>
      <a href="#intellectual-property"><i class="fas fa-copyright"></i> Intellectual Property</a>
      <a href="#liability"><i class="fas fa-balance-scale"></i> Limitation of Liability</a>
      <a href="#changes"><i class="fas fa-edit"></i> Changes to Terms</a>
      <a href="#contact"><i class="fas fa-envelope"></i> Contact</a>
    </nav>
  </aside>

  <main class="main-content">
    <div class="highlight-box">
      <p><strong>Please read these Terms of Use carefully.</strong> By accessing or using the Barangay Bacolod Information System (BIS), you agree to be bound by these terms. If you do not agree, please do not use the portal.</p>
    </div>

    <div class="policy-section" id="acceptance">
      <div class="policy-section-header">
        <div class="policy-section-icon"><i class="fas fa-check-circle"></i></div>
        <h2>1. Acceptance of Terms</h2>
      </div>
      <p>By accessing and using the Barangay Bacolod Information System (BIS) portal, you acknowledge that you have read, understood, and agree to be bound by these Terms of Use and our Privacy Policy. These terms constitute a legally binding agreement between you and Barangay Bacolod, Bato, Camarines Sur.</p>
      <p>These Terms of Use apply to all users of the portal, including residents, barangay officials, and any other persons who access or use the system. If you are using the portal on behalf of an organization, you represent that you have the authority to bind that organization to these terms.</p>
      <p>We reserve the right to modify these terms at any time. Continued use of the portal after any changes constitutes your acceptance of the new terms. We will notify users of significant changes via email or a prominent notice on the portal.</p>
    </div>

    <div class="policy-section" id="use-system">
      <div class="policy-section-header">
        <div class="policy-section-icon"><i class="fas fa-desktop"></i></div>
        <h2>2. Use of the System</h2>
      </div>
      <p>The BIS portal is provided for the exclusive purpose of facilitating access to barangay services for residents of Barangay Bacolod, Bato, Camarines Sur. You agree to use the portal only for lawful purposes and in accordance with these Terms of Use.</p>
      <p>You are responsible for ensuring that all information you provide through the portal is accurate, complete, and up to date. Providing false or misleading information may result in the suspension of your account and may have legal consequences under applicable Philippine laws.</p>
      <p>The portal is intended for personal, non-commercial use only. You may not use the portal for any commercial purpose or for any public display, performance, sale, or rental without the express written consent of Barangay Bacolod.</p>
    </div>

    <div class="policy-section" id="user-accounts">
      <div class="policy-section-header">
        <div class="policy-section-icon"><i class="fas fa-user"></i></div>
        <h2>3. User Accounts</h2>
      </div>
      <p>To access most features of the BIS portal, you must create an account. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. You agree to notify us immediately of any unauthorized use of your account.</p>
      <p>Each resident may only maintain one account. Creating multiple accounts for the same person is prohibited. Barangay officials are assigned accounts by the system administrator and may not create additional accounts without authorization.</p>
      <p>We reserve the right to suspend or terminate your account if we determine that you have violated these Terms of Use, provided false information during registration, or engaged in any activity that is harmful to the portal or other users. Account termination does not affect any legal obligations you may have incurred.</p>
    </div>

    <div class="policy-section" id="prohibited">
      <div class="policy-section-header">
        <div class="policy-section-icon"><i class="fas fa-ban"></i></div>
        <h2>4. Prohibited Activities</h2>
      </div>
      <p>The following activities are strictly prohibited when using the BIS portal:</p>
      <ul>
        <li>Providing false, inaccurate, or misleading information in any form or request</li>
        <li>Impersonating another person or entity, or misrepresenting your affiliation</li>
        <li>Attempting to gain unauthorized access to any part of the portal or its systems</li>
        <li>Using automated tools, bots, or scripts to access or scrape the portal</li>
        <li>Uploading or transmitting malicious code, viruses, or harmful content</li>
        <li>Filing false or frivolous blotter reports or document requests</li>
        <li>Harassing, threatening, or intimidating other users or barangay officials</li>
        <li>Using the portal for any illegal purpose under Philippine law</li>
      </ul>
      <p>Violation of these prohibitions may result in immediate account suspension, referral to law enforcement authorities, and civil or criminal liability under applicable Philippine laws including the Cybercrime Prevention Act of 2012 (RA 10175).</p>
    </div>

    <div class="policy-section" id="intellectual-property">
      <div class="policy-section-header">
        <div class="policy-section-icon"><i class="fas fa-copyright"></i></div>
        <h2>5. Intellectual Property</h2>
      </div>
      <p>The BIS portal, including its design, content, software, and all materials contained therein, is the property of Barangay Bacolod, Bato, Camarines Sur and is protected by applicable intellectual property laws. The Barangay Bacolod seal and logo are official government symbols and may not be reproduced without authorization.</p>
      <p>You are granted a limited, non-exclusive, non-transferable license to access and use the portal for its intended purpose. This license does not include the right to copy, modify, distribute, sell, or create derivative works from any content on the portal.</p>
      <p>Documents issued through the portal (such as barangay clearances) are official government documents. Reproduction, alteration, or misuse of these documents is a criminal offense under Philippine law.</p>
    </div>

    <div class="policy-section" id="liability">
      <div class="policy-section-header">
        <div class="policy-section-icon"><i class="fas fa-balance-scale"></i></div>
        <h2>6. Limitation of Liability</h2>
      </div>
      <p>The BIS portal is provided on an "as is" and "as available" basis. Barangay Bacolod makes no warranties, express or implied, regarding the portal's availability, accuracy, or fitness for a particular purpose. We do not guarantee uninterrupted or error-free operation of the portal.</p>
      <p>To the maximum extent permitted by law, Barangay Bacolod shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of or inability to use the portal, including but not limited to loss of data, service interruptions, or delays in document processing.</p>
      <p>Our total liability for any claim arising from your use of the portal shall not exceed the amount of fees, if any, paid by you for the specific service giving rise to the claim. This limitation applies regardless of the form of action, whether in contract, tort, or otherwise.</p>
    </div>

    <div class="policy-section" id="changes">
      <div class="policy-section-header">
        <div class="policy-section-icon"><i class="fas fa-edit"></i></div>
        <h2>7. Changes to Terms</h2>
      </div>
      <p>Barangay Bacolod reserves the right to modify these Terms of Use at any time. Changes will be effective immediately upon posting to the portal. We will make reasonable efforts to notify registered users of material changes via email or a prominent notice on the portal.</p>
      <p>Your continued use of the portal after any changes to these Terms of Use constitutes your acceptance of the revised terms. If you do not agree to the revised terms, you must discontinue use of the portal and may request deletion of your account.</p>
      <p>We recommend that you review these Terms of Use periodically to stay informed of any updates. The "Last updated" date at the top of this page indicates when the terms were last revised.</p>
    </div>

    <div class="policy-section" id="contact">
      <div class="policy-section-header">
        <div class="policy-section-icon"><i class="fas fa-envelope"></i></div>
        <h2>8. Contact</h2>
      </div>
      <p>If you have questions or concerns about these Terms of Use, or if you wish to report a violation, please contact us through any of the following channels:</p>
      <ul>
        <li><strong>In Person:</strong> Barangay Hall, Barangay Bacolod, Bato, Camarines Sur</li>
        <li><strong>Email:</strong> barangaybacolod@bato.gov.ph</li>
        <li><strong>Phone:</strong> +63 (054) 000-0000</li>
        <li><strong>Office Hours:</strong> Monday to Friday, 8:00 AM – 5:00 PM</li>
      </ul>
      <p>These Terms of Use shall be governed by and construed in accordance with the laws of the Republic of the Philippines. Any disputes arising from these terms shall be subject to the jurisdiction of the appropriate courts in Camarines Sur.</p>
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
window.addEventListener('scroll',function(){
  var n=document.getElementById('navbar');
  n.classList.toggle('scrolled',window.scrollY>10);
  var sections=document.querySelectorAll('.policy-section');
  var links=document.querySelectorAll('.sidebar-nav a');
  var current='';
  sections.forEach(function(s){if(window.scrollY>=s.offsetTop-100)current='#'+s.id;});
  links.forEach(function(l){l.classList.toggle('active',l.getAttribute('href')===current);});
});
document.getElementById('hamburger').addEventListener('click',function(){document.getElementById('mobileMenu').classList.toggle('open');});
</script>
</body>
</html>
