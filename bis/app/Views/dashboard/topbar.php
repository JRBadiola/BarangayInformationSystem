<!-- Floating Chat Widget -->
<div class="cw-wrap" id="cwWrap">

    <!-- Bubble toggle -->
    <button class="cw-toggle" id="cwToggle" onclick="cwOpen()" aria-label="Open chat">
        <span class="cw-toggle-icon" id="cwIcon">
            <i class="fas fa-comment-dots"></i>
        </span>
        <span class="cw-unread" id="cwUnread">1</span>
    </button>

    <!-- Panel -->
    <div class="cw-panel" id="cwPanel">

        <!-- Header -->
        <div class="cw-header">
            <div class="cw-header-left">
                <div class="cw-header-avatar">
                    <i class="fas fa-robot"></i>
                    <span class="cw-header-dot"></span>
                </div>
                <div class="cw-header-text">
                    <span class="cw-header-name">BIS Assistant</span>
                    <span class="cw-header-sub">Bacolod Barangay · Online</span>
                </div>
            </div>
            <div class="cw-header-actions">
                <button class="cw-hbtn" title="Minimize" onclick="cwOpen()"><i class="fas fa-minus"></i></button>
                <button class="cw-hbtn" title="Close" onclick="cwClose()"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <!-- Date divider -->
        <div class="cw-date-divider"><span>Today</span></div>

        <!-- Messages -->
        <div class="cw-messages" id="cwMessages">
            <div class="cw-row cw-row--bot">
                <div class="cw-avatar"><i class="fas fa-robot"></i></div>
                <div class="cw-body">
                    <div class="cw-bubble">Hello! I'm the <strong>BIS Assistant</strong> 👋<br>How can I help you today?</div>
                    <span class="cw-ts">Just now</span>
                </div>
            </div>
            <!-- Quick chips -->
            <div class="cw-chips" id="cwChips">
                <button class="cw-chip" onclick="cwQuick('How do I request a barangay clearance?')"><i class="fas fa-file-alt"></i> Request clearance</button>
                <button class="cw-chip" onclick="cwQuick('How do I create an account?')"><i class="fas fa-user-plus"></i> Create account</button>
                <button class="cw-chip" onclick="cwQuick('How do I file a blotter report?')"><i class="fas fa-book"></i> File blotter</button>
                <button class="cw-chip" onclick="cwQuick('What documents can I request?')"><i class="fas fa-file-contract"></i> Documents</button>
                <button class="cw-chip" onclick="cwQuick('What are the office hours?')"><i class="fas fa-clock"></i> Office hours</button>
                <button class="cw-chip" onclick="cwQuick('How do I reset my password?')"><i class="fas fa-key"></i> Reset password</button>
            </div>
        </div>

        <!-- Input -->
        <div class="cw-footer">
            <div class="cw-input-wrap">
                <input type="text" id="cwInput" class="cw-input" placeholder="Type a message…" onkeydown="if(event.key==='Enter')cwSend()">
                <button class="cw-send" onclick="cwSend()"><i class="fas fa-paper-plane"></i></button>
            </div>
            <p class="cw-powered">Powered by <strong>Bacolod BIS</strong></p>
        </div>

    </div>
</div>
<script>
    (function() {

        // ── BIS Knowledge Base ────────────────────────────────────────────────
        const KB = [

            // ── ACCOUNT & LOGIN ──────────────────────────────────────────────
            {
                keys: ['create account', 'sign up', 'register', 'how to register', 'new account'],
                answer: '📝 <strong>Creating an Account:</strong><br>1. Go to the homepage and click <strong>Sign Up</strong> or visit <em>/signup</em>.<br>2. Select your role: <strong>Resident</strong> or <strong>SK</strong>.<br>3. Fill in your full name, email, username, and password.<br>4. For Residents: enter your <strong>5-digit household number</strong> (ask the barangay office if you don\'t know it).<br>5. Check your email for a <strong>6-digit verification code</strong> (valid for 15 minutes).<br>6. After verifying, your account goes to <strong>Pending</strong> — wait for the Captain or Secretary to approve it.'
            },
            {
                keys: ['login', 'sign in', 'cannot login', 'can\'t login', 'account pending', 'account rejected'],
                answer: '🔐 <strong>Logging In:</strong><br>Go to <em>/login</em> and enter your username and password.<br><br><strong>Common issues:</strong><br>• <em>Unverified</em> — check your email for the OTP code.<br>• <em>Pending</em> — your account is awaiting approval by the Captain or Secretary.<br>• <em>Rejected</em> — contact the barangay office for assistance.<br>• Wrong password — use the <strong>Forgot Password</strong> link on the login page.'
            },
            {
                keys: ['forgot password', 'reset password', 'change password', 'lost password'],
                answer: '🔑 <strong>Forgot Password:</strong><br>1. Click <strong>"Forgot password?"</strong> on the login page.<br>2. Enter your registered email address.<br>3. Check your email for a <strong>6-digit reset code</strong> (valid 15 minutes).<br>4. Enter the code and set your new password (minimum 8 characters).<br><br>To change your password while logged in, go to <strong>Settings → Change Password</strong>. A verification code will be sent to your email.'
            },
            {
                keys: ['profile photo', 'avatar', 'change photo', 'upload photo', 'profile picture'],
                answer: '📷 <strong>Profile Photo:</strong><br>Go to <strong>Settings</strong> (click your avatar in the top-right corner).<br>Click <strong>"Change Photo"</strong>, select an image (JPG, PNG, GIF, or WebP — max 2MB), preview it, then click <strong>"Upload Photo"</strong>.<br>Your photo will appear in the navigation bar.'
            },

            // ── CLEARANCE / DOCUMENTS ────────────────────────────────────────
            {
                keys: ['request clearance', 'apply clearance', 'barangay clearance', 'how to get clearance', 'clearance request'],
                answer: '📄 <strong>Requesting a Barangay Clearance:</strong><br>1. Log in to your account.<br>2. Go to <strong>My Clearances</strong> in the sidebar.<br>3. Click <strong>"New Request"</strong>.<br>4. Select who the document is for (you or a household member).<br>5. Choose <strong>Barangay Clearance</strong> as the document type.<br>6. Enter the purpose and submit.<br>7. Processing takes <strong>1–2 business days</strong>. You\'ll be notified when it\'s ready for pickup.'
            },
            {
                keys: ['certificate of residency', 'residency certificate', 'proof of residence'],
                answer: '🏠 <strong>Certificate of Residency:</strong><br>Log in → My Clearances → New Request → Select <strong>Certificate of Residency</strong>.<br>Enter the purpose and submit. Processing takes 1–2 business days.<br><br>This document certifies that you are a resident of Barangay Bacolod, Bato, Camarines Sur.'
            },
            {
                keys: ['certificate of indigency', 'indigency', 'indigent', 'low income certificate'],
                answer: '💙 <strong>Certificate of Indigency:</strong><br>This document is <strong>free of charge</strong>.<br><br>⚠️ <strong>Income Qualification:</strong> Your household\'s total net monthly income must be <strong>₱12,000 or below</strong>. If your household income exceeds this, the request will be automatically rejected.<br><br>To request: Log in → My Clearances → New Request → Select <strong>Certificate of Indigency</strong>.'
            },
            {
                keys: ['good moral', 'certificate of good moral', 'moral character'],
                answer: '✅ <strong>Certificate of Good Moral Character:</strong><br>Log in → My Clearances → New Request → Select <strong>Certificate of Good Moral</strong>.<br>Enter the purpose (e.g., employment, scholarship) and submit. Processing takes 1–2 business days.'
            },
            {
                keys: ['first time job seeker', 'first time job', 'job seeker certificate', 'ftjs'],
                answer: '💼 <strong>First Time Job Seeker Certificate:</strong><br>Available under the Barangay Clearance module.<br>Log in → My Clearances → New Request → Select <strong>First Time Job Seekers</strong>.<br>This is issued under Republic Act 11261 and is free of charge for first-time job seekers.'
            },
            {
                keys: ['what documents', 'available documents', 'types of documents', 'what can i request', 'document types'],
                answer: '📋 <strong>Available Documents:</strong><br>1. 🏅 Barangay Clearance<br>2. 🏠 Certificate of Residency<br>3. 💙 Certificate of Indigency (income ≤ ₱12,000/mo)<br>4. ✅ Certificate of Good Moral<br>5. 💼 First Time Job Seekers Certificate<br><br>All documents are processed within <strong>1–2 business days</strong>. Log in and go to <strong>My Clearances → New Request</strong> to apply.'
            },
            {
                keys: ['cancel request', 'cancel clearance', 'withdraw request'],
                answer: '❌ <strong>Cancelling a Request:</strong><br>You can cancel a <strong>pending</strong> request from your <strong>My Clearances</strong> page by clicking the ✕ button next to the request.<br><br>Once a request is <strong>approved or rejected</strong>, it cannot be cancelled online — contact the barangay office for assistance.'
            },
            {
                keys: ['status of request', 'track request', 'request status', 'where is my clearance'],
                answer: '🔍 <strong>Tracking Your Request:</strong><br>Go to <strong>My Clearances</strong> in the sidebar. Each request shows its current status:<br>• 🟡 <em>Pending</em> — waiting for review<br>• 🟢 <em>Approved</em> — ready for pickup at the barangay hall<br>• 🔴 <em>Rejected</em> — see the remarks for the reason<br><br>Estimated release is shown on each request (usually 1–2 business days).'
            },
            {
                keys: ['fee', 'cost', 'how much', 'price', 'payment', 'free'],
                answer: '💰 <strong>Document Fees:</strong><br>• Barangay Clearance — standard fee applies<br>• Certificate of Residency — standard fee applies<br>• Certificate of Indigency — <strong>FREE</strong><br>• Certificate of Good Moral — standard fee applies<br>• First Time Job Seekers — <strong>FREE</strong><br><br>Fees are paid at the barangay hall when you pick up your document. Contact the office for the current fee schedule.'
            },

            // ── BLOTTER ──────────────────────────────────────────────────────
            {
                keys: ['file blotter', 'blotter report', 'file complaint', 'report incident', 'file a report', 'how to file'],
                answer: '📋 <strong>Filing a Blotter Report:</strong><br><strong>Option 1 (No account needed):</strong> Use the public blotter form on the homepage — click <strong>"File a Report"</strong> under Services.<br><br><strong>Option 2 (Logged in):</strong> Go to your dashboard and click <strong>"File Blotter"</strong>.<br><br>Provide: your name, contact, incident type, date/time, location, persons involved, and a detailed description. The barangay will review and schedule a hearing if needed.'
            },
            {
                keys: ['blotter status', 'hearing', 'summons', 'hearing schedule', 'when is my hearing'],
                answer: '📅 <strong>Blotter Hearing:</strong><br>After filing a blotter report, the barangay will review it and may schedule a <strong>hearing</strong> at the Barangay Hall.<br><br>Both the complainant and respondent will receive an official <strong>Summons Letter</strong> via email with the hearing date, time, and venue.<br><br>Hearings are conducted under the <em>Katarungang Pambarangay Law (RA 7160)</em>. Failure to appear may result in a certification to file action in court.'
            },

            // ── CENSUS ───────────────────────────────────────────────────────
            {
                keys: ['census', 'household number', 'household no', 'what is my household number', 'census record'],
                answer: '🏘️ <strong>Census Records:</strong><br>The census contains household information for all residents of Barangay Bacolod.<br><br>Your <strong>5-digit household number</strong> is assigned by the barangay. If you don\'t know it, visit the barangay hall or ask the Secretary.<br><br>You need your household number to register as a Resident in the BIS system.'
            },
            {
                keys: ['update census', 'update household', 'change address', 'update information'],
                answer: '✏️ <strong>Updating Census Information:</strong><br>Census records are managed by the Barangay Captain and Secretary.<br><br>To update your household information (address, members, etc.), visit the <strong>Barangay Hall</strong> with a valid ID and request an update. The Secretary will make the changes in the system.'
            },

            // ── ACCOUNTS (ADMIN) ─────────────────────────────────────────────
            {
                keys: ['approve account', 'pending account', 'account approval', 'how long approval'],
                answer: '⏳ <strong>Account Approval:</strong><br>After verifying your email, your account goes to <strong>Pending</strong> status.<br><br>The Barangay Captain or Secretary reviews and approves accounts. This typically takes <strong>1–3 business days</strong>.<br><br>You\'ll be able to log in once your account is approved. If it\'s been more than 3 days, contact the barangay office.'
            },
            {
                keys: ['sk account', 'sk registration', 'sangguniang kabataan', 'youth account'],
                answer: '🌟 <strong>SK Account Registration:</strong><br>SK (Sangguniang Kabataan) members can register at <em>/signup</em> by selecting <strong>SK</strong> as their role.<br><br>After email verification, the account requires approval from the Captain or Secretary.<br><br>SK accounts have access to: Youth Profiling, Programs & Events, Reports, and Settings.'
            },

            // ── CALENDAR ─────────────────────────────────────────────────────
            {
                keys: ['calendar', 'schedule', 'appointment', 'add event', 'hearing schedule', 'schedule management'],
                answer: '📅 <strong>Calendar & Schedule:</strong><br>The Captain and Secretary have a shared calendar as their main dashboard.<br><br><strong>Features:</strong><br>• Add appointments, meetings, hearings, and events<br>• Blotter hearing dates appear automatically<br>• Secretary can share events with the Captain\'s calendar<br>• Captain\'s schedule is visible to the Secretary<br>• Secretary\'s personal events are private<br><br>Click any day on the calendar to add an event, or click an existing event to view/edit/delete it.'
            },

            // ── SK MODULE ────────────────────────────────────────────────────
            {
                keys: ['sk profiling', 'youth profiling', 'sk module', 'youth records'],
                answer: '👥 <strong>SK Youth Profiling:</strong><br>The SK module shows youth aged <strong>15–30</strong> from the barangay census.<br><br>You can filter by: Zone, Age Group, Gender, Status (Student/Employed/Unemployed/Out-of-School), and Civil Status.<br><br>Click the 👁️ eye icon on any youth to view their full profile — shown from the <strong>youth\'s perspective</strong> with their personal details, household head (parent/guardian), and other household members.'
            },

            // ── REPORTS ──────────────────────────────────────────────────────
            {
                keys: ['reports', 'population report', 'demographic', 'download report', 'print report'],
                answer: '📊 <strong>Reports & Analytics:</strong><br>Available to Captain and Secretary at <strong>Reports</strong> in the sidebar.<br><br>The report includes:<br>• Summary statistics (population, households, clearances)<br>• Section IV Demographic Information (registered voters, families, etc.)<br>• Population by Age Bracket (Male/Female/Total)<br>• Population by Sector (Labor Force, PWDs, Solo Parents, etc.)<br><br>Click <strong>"Download PDF"</strong> to save as a PDF file, or <strong>"Print"</strong> to print directly.'
            },

            // ── GENERAL ──────────────────────────────────────────────────────
            {
                keys: ['office hours', 'open', 'when is the office', 'barangay hall hours'],
                answer: '🕐 <strong>Office Hours:</strong><br>The Barangay Hall of Bacolod, Bato, Camarines Sur is open:<br><br>📅 <strong>Monday to Friday</strong><br>⏰ <strong>8:00 AM – 5:00 PM</strong><br><br>Closed on weekends and public holidays.<br><br>The BIS online portal is available <strong>24/7</strong> for submitting requests, but processing is done during office hours only.'
            },
            {
                keys: ['contact', 'phone number', 'email', 'address', 'where is the barangay'],
                answer: '📍 <strong>Contact Information:</strong><br>🏢 Barangay Hall, Bacolod, Bato, Camarines Sur<br>📞 +63 (054) 000-0000<br>📧 barangaybacolod@bato.gov.ph<br>🕐 Mon–Fri, 8:00 AM – 5:00 PM<br><br>You can also reach us through our Facebook page or visit the barangay hall in person.'
            },
            {
                keys: ['what is bis', 'about bis', 'about the system', 'what is this system', 'barangay information system'],
                answer: '🏛️ <strong>About the BIS:</strong><br>The <strong>Barangay Information System (BIS)</strong> is the official digital platform of Barangay Bacolod, Bato, Camarines Sur.<br><br>It allows residents to:<br>• Request barangay documents online<br>• File blotter reports<br>• Track request status in real time<br><br>Officials can manage census records, clearances, blotter cases, reports, and schedules — all in one secure system.'
            },
            {
                keys: ['privacy', 'data privacy', 'personal data', 'data protection', 'ra 10173'],
                answer: '🔒 <strong>Data Privacy:</strong><br>The BIS complies with the <strong>Data Privacy Act of 2012 (RA 10173)</strong>.<br><br>Your personal information is:<br>• Encrypted and stored securely<br>• Only accessed by authorized barangay officials<br>• Never sold or shared with third parties without consent<br><br>You have the right to access, correct, or request deletion of your data. Visit <strong>Privacy Policy</strong> in the footer for full details.'
            },
            {
                keys: ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening', 'kumusta'],
                answer: '👋 Hello! I\'m the <strong>BIS Assistant</strong> for Barangay Bacolod, Bato, Camarines Sur.<br><br>I can help you with:<br>• Requesting documents (clearance, residency, indigency)<br>• Filing blotter reports<br>• Account registration and login<br>• Understanding how the system works<br><br>What would you like to know?'
            },
            {
                keys: ['thank', 'thanks', 'salamat', 'thank you'],
                answer: '😊 You\'re welcome! If you have more questions about the BIS system, feel free to ask anytime. You can also visit the barangay hall during office hours (Mon–Fri, 8AM–5PM) for in-person assistance.'
            }
        ];

        function getR(msg) {
            const m = msg.toLowerCase().trim();

            // ── 1. Gibberish / too short ──────────────────────────────────────
            if (m.length < 2) {
                return '😊 Please type a complete question so I can help you better.';
            }
            const alphaRatio = (m.match(/[a-z]/g) || []).length / m.length;
            const hasRepeats = /(.)\1{4,}/.test(m);
            if (alphaRatio < 0.4 || hasRepeats) {
                return '🤖 I didn\'t quite catch that. Please type a clear question about barangay services and I\'ll be happy to help!';
            }
            // Detect nonsense words: no word is a recognizable real word
            const realWords = ['how', 'what', 'when', 'where', 'who', 'why', 'can', 'do', 'i', 'is', 'are', 'the', 'a', 'an', 'my', 'me', 'to', 'for', 'in', 'of', 'and', 'or', 'not', 'yes', 'no', 'please', 'help', 'need', 'want', 'get', 'have', 'make', 'file', 'apply', 'request', 'barangay', 'clearance', 'account', 'register', 'login', 'password', 'blotter', 'census', 'document', 'certificate', 'office', 'hours', 'fee', 'cost', 'requirement', 'household', 'resident', 'sk', 'captain', 'secretary', 'report', 'complaint', 'hearing', 'schedule', 'appointment', 'create', 'update', 'change', 'reset', 'forgot', 'lost', 'pending', 'approved', 'rejected', 'status', 'track', 'cancel', 'submit', 'upload', 'photo', 'profile', 'contact', 'address', 'phone', 'email', 'name', 'number', 'zone', 'purok', 'indigency', 'residency', 'moral', 'job', 'seeker', 'good', 'first', 'time', 'about', 'tell', 'explain', 'show', 'give', 'send', 'receive', 'pick', 'up', 'visit', 'hall', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'open', 'close', 'available', 'free', 'paid', 'process', 'days', 'business', 'valid', 'id', 'form', 'fill', 'bring', 'required', 'requirements', 'ano', 'paano', 'saan', 'kailan', 'sino', 'bakit', 'pwede', 'hindi', 'oo', 'salamat', 'po', 'ako', 'ikaw', 'siya', 'kami', 'kayo', 'sila', 'ng', 'sa', 'at', 'na', 'ay', 'ang', 'mga', 'ito', 'may', 'wala', 'calendar', 'reports', 'settings', 'profile', 'dashboard', 'census', 'household', 'member', 'youth', 'sk', 'profiling'];
            const msgWords = m.split(/\s+/);
            const hasRealWord = msgWords.some(w => realWords.includes(w) || w.length <= 2);
            const inKB = KB.some(e => e.keys.some(k => k.split(/\s+/).some(kw => msgWords.some(w => w === kw))));
            if (!hasRealWord && !inKB && m.length < 20) {
                return '🤖 That doesn\'t look like a question I can understand. Please type a clear question in English or Filipino about barangay services.<br><br>Example: <em>"How do I get a barangay clearance?"</em>';
            }

            // ── 2. Inappropriate / rude language ─────────────────────────────
            const rude = ['putang', 'gago', 'bobo', 'tanga', 'ulol', 'puta', 'fuck', 'shit', 'damn', 'idiot', 'stupid', 'dumb', 'ass', 'bitch', 'hate', 'kill', 'die'];
            if (rude.some(w => m.includes(w))) {
                return '🙏 I understand you may be frustrated, but I\'m here to help with barangay services. Please keep our conversation respectful so I can assist you better.<br><br>If you have an urgent concern, please visit the <strong>Barangay Hall</strong> (Mon–Fri, 8AM–5PM) or call <strong>+63 (054) 000-0000</strong>.';
            }

            // ── 3. Spam / test messages ───────────────────────────────────────
            const spam = ['test', 'testing', 'asdf', 'qwerty', 'lorem', '1234', 'abcd', 'xyz', 'aaa', 'bbb'];
            if (spam.some(w => m === w || m.startsWith(w + ' '))) {
                return '👋 It looks like you\'re testing the chat! I\'m ready to answer real questions about Barangay Bacolod\'s services.<br><br>Try asking: <em>"How do I request a barangay clearance?"</em> or <em>"How do I update my census record?"</em>';
            }

            // ── 4. Out-of-scope topics ────────────────────────────────────────
            const outOfScope = [{
                    keys: ['weather', 'forecast', 'temperature', 'rain', 'typhoon'],
                    reply: '🌤️ I can only answer questions about barangay services. For weather updates, please check <strong>PAGASA</strong> or your local news.'
                },
                {
                    keys: ['news', 'politics', 'election', 'president', 'mayor', 'governor'],
                    reply: '📰 I\'m focused on Barangay Bacolod services and can\'t discuss political topics. For local government news, visit the official municipal website.'
                },
                {
                    keys: ['recipe', 'food', 'cook', 'restaurant', 'eat'],
                    reply: '🍽️ I\'m a barangay services assistant and can\'t help with food-related questions. Is there anything about barangay documents or services I can help you with?'
                },
                {
                    keys: ['game', 'play', 'movie', 'music', 'song', 'netflix', 'youtube', 'tiktok', 'facebook'],
                    reply: '🎮 I\'m here specifically to help with barangay services. I can\'t assist with entertainment topics. Try asking about clearances, blotter reports, or account registration!'
                },
                {
                    keys: ['joke', 'funny', 'laugh', 'meme'],
                    reply: '😄 I appreciate the fun spirit, but I\'m a barangay services assistant! I\'m best at answering questions about documents, accounts, and barangay processes. How can I help you today?'
                },
                {
                    keys: ['love', 'relationship', 'boyfriend', 'girlfriend', 'crush', 'marry'],
                    reply: '💙 That\'s sweet, but I\'m a barangay services assistant! I can help you with clearances, blotter reports, account registration, and more. What barangay service do you need?'
                },
                {
                    keys: ['money', 'loan', 'borrow', 'invest', 'stock', 'crypto', 'bitcoin'],
                    reply: '💰 I can only assist with barangay services. For financial concerns, please contact the appropriate government agencies (SSS, Pag-IBIG, BIR) or your local bank.'
                },
                {
                    keys: ['medical', 'doctor', 'hospital', 'medicine', 'sick', 'health', 'covid'],
                    reply: '🏥 For medical concerns, please contact your nearest health center or hospital. I can only answer questions about barangay documents and services.'
                },
                {
                    keys: ['school', 'college', 'university', 'enroll', 'tuition', 'scholarship'],
                    reply: '🎓 For educational concerns, please contact your school or DepEd. I can only assist with barangay services like clearances, blotter reports, and account registration.'
                },
                {
                    keys: ['police', 'crime', 'arrest', 'nbi', 'pnp', 'court', 'lawyer', 'legal advice'],
                    reply: '⚖️ For serious legal or criminal matters, please contact the <strong>Philippine National Police (PNP)</strong> or consult a lawyer. The barangay can assist with community disputes through the blotter system.'
                },
                {
                    keys: ['who are you', 'what are you', 'are you human', 'are you ai', 'are you a robot'],
                    reply: '🤖 I\'m the <strong>BIS Assistant</strong> — an automated chatbot for Barangay Bacolod, Bato, Camarines Sur. I\'m not a human, but I\'m here to help you with barangay services 24/7!<br><br>For complex concerns, visit the barangay hall (Mon–Fri, 8AM–5PM).'
                },
                {
                    keys: ['what can you do', 'what do you know', 'help me', 'i need help'],
                    reply: '🙋 I can help you with:<br><br>• 📄 <strong>Documents</strong> — clearance, residency, indigency, good moral<br>• 👤 <strong>Account</strong> — registration, login, password reset<br>• 📋 <strong>Blotter</strong> — filing a report, hearing schedule<br>• 🏘️ <strong>Census</strong> — household number, updating records<br>• 📅 <strong>Calendar</strong> — schedules and appointments<br>• 🕐 <strong>Office hours</strong> and contact information<br><br>Just type your question!'
                },
            ];
            for (const entry of outOfScope) {
                if (entry.keys.some(k => m.includes(k))) return entry.reply;
            }

            // ── 5. Knowledge base matching ────────────────────────────────────
            for (const entry of KB) {
                for (const key of entry.keys) {
                    if (m.includes(key)) return entry.answer;
                }
            }
            // Partial word fallback
            const words = m.split(/\s+/);
            for (const entry of KB) {
                for (const key of entry.keys) {
                    const keyWords = key.split(/\s+/);
                    if (keyWords.some(kw => kw.length > 3 && words.some(w => w.includes(kw) || kw.includes(w)))) {
                        return entry.answer;
                    }
                }
            }

            // ── 6. Final fallback ─────────────────────────────────────────────
            return '🤔 I\'m not sure how to answer that. I\'m specialized in <strong>Barangay Bacolod services</strong>.<br><br>Here\'s what I can help with:<br>• 📄 Document requests (clearance, residency, indigency)<br>• 👤 Account registration and login<br>• 📋 Filing blotter reports<br>• 🕐 Office hours and contact info<br><br>Try rephrasing your question, or visit the <strong>Barangay Hall</strong> (Mon–Fri, 8AM–5PM) for direct assistance.';
        }

        function now() {
            const d = new Date();
            return d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
        }

        function addMsg(text, isUser) {
            const wrap = document.getElementById('cwMessages');
            const chips = document.getElementById('cwChips');
            if (chips) chips.remove();
            const row = document.createElement('div');
            row.className = 'cw-row ' + (isUser ? 'cw-row--user' : 'cw-row--bot');
            if (isUser) {
                row.innerHTML = `<div class="cw-body"><div class="cw-bubble">${text}</div><span class="cw-ts">${now()}</span></div>`;
            } else {
                row.innerHTML = `<div class="cw-avatar"><i class="fas fa-robot"></i></div><div class="cw-body"><div class="cw-bubble">${text}</div><span class="cw-ts">${now()}</span></div>`;
            }
            wrap.appendChild(row);
            wrap.scrollTop = wrap.scrollHeight;
        }

        function typing() {
            const wrap = document.getElementById('cwMessages');
            const t = document.createElement('div');
            t.className = 'cw-row cw-row--bot cw-typing-row';
            t.id = 'cwTyping';
            t.innerHTML = `<div class="cw-avatar"><i class="fas fa-robot"></i></div><div class="cw-body"><div class="cw-bubble cw-typing"><span></span><span></span><span></span></div></div>`;
            wrap.appendChild(t);
            wrap.scrollTop = wrap.scrollHeight;
        }

        window.cwSend = function() {
            const inp = document.getElementById('cwInput');
            const msg = inp.value.trim();
            if (!msg) return;
            addMsg(msg, true);
            inp.value = '';
            document.getElementById('cwUnread').style.display = 'none';
            typing();
            setTimeout(() => {
                const t = document.getElementById('cwTyping');
                if (t) t.remove();
                addMsg(getR(msg), false);
            }, 800);
        };

        window.cwQuick = function(msg) {
            const chips = document.getElementById('cwChips');
            if (chips) chips.remove();
            addMsg(msg, true);
            document.getElementById('cwUnread').style.display = 'none';
            typing();
            setTimeout(() => {
                const t = document.getElementById('cwTyping');
                if (t) t.remove();
                addMsg(getR(msg), false);
            }, 800);
        };

        window.cwOpen = function() {
            const panel = document.getElementById('cwPanel');
            const wrap = document.getElementById('cwWrap');
            const unread = document.getElementById('cwUnread');
            panel.classList.toggle('cw-open');
            wrap.classList.toggle('cw-active');
            if (panel.classList.contains('cw-open')) unread.style.display = 'none';
        };

        window.cwClose = function() {
            document.getElementById('cwPanel').classList.remove('cw-open');
            document.getElementById('cwWrap').classList.remove('cw-active');
        };

        // Legacy aliases for chatbot page topic cards
        window.toggleChat = window.cwOpen;
        window.sendQuick = window.cwQuick;
    })();
</script>

<header class="db-topbar">
    <button class="db-menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')" aria-label="Toggle menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="db-topbar-title">
        <h1><?= $pageTitle ?? 'Dashboard' ?></h1>
        <span><?= date('l, F j, Y') ?></span>
    </div>
    <div class="db-topbar-right">
        <button class="db-notif-btn" onclick="window.location.href='/<?= session()->get('role') ?>/notifications'" aria-label="Notifications">
            <i class="fas fa-bell"></i>
            <span class="db-notif-dot" id="topbarNotifDot" style="display:none;"></span>
            <span id="topbarUnreadCount" class="db-notif-count" style="display:none;"></span>
        </button>
        <div class="db-avatar" onclick="window.location.href='/<?= esc((string)(session()->get('role') ?? 'resident')) ?>/<?= session()->get('role') === 'resident' ? 'profile' : 'settings' ?>'" style="cursor:pointer;">
            <?php
            $avatarFile = session()->get('avatar');
            if ($avatarFile && file_exists(FCPATH . 'uploads/avatars/' . $avatarFile)):
            ?>
                <img src="/uploads/avatars/<?= esc($avatarFile) ?>" alt="Avatar"
                    style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            <?php else: ?>
                <i class="fas fa-user"></i>
            <?php endif; ?>
        </div>
        <span class="db-username"><?= esc((string)(session()->get('username') ?? 'User')) ?></span>
    </div>
</header>
<?php if (session()->get('role') === 'resident'): ?>
    <style>
        .db-notif-count {
            position: absolute;
            top: 2px;
            right: 2px;
            min-width: 17px;
            height: 17px;
            background: #c0392b;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            pointer-events: none;
        }
    </style>
    <script>
        (function() {
            function pollUnread() {
                fetch('/resident/notifications/poll', {
                        credentials: 'same-origin'
                    })
                    .then(r => r.json())
                    .then(data => {
                        const count = data.unread || 0;
                        const dot = document.getElementById('topbarNotifDot');
                        const badge = document.getElementById('topbarUnreadCount');
                        if (dot) dot.style.display = count > 0 ? '' : 'none';
                        if (badge) {
                            badge.textContent = count > 9 ? '9+' : count;
                            badge.style.display = count > 0 ? 'flex' : 'none';
                        }
                    })
                    .catch(() => {});
            }
            pollUnread();
            setInterval(pollUnread, 30000); // every 30 seconds
        })();
    </script>
<?php endif; ?>