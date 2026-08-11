<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Support - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php $role = 'resident';
    $active = 'chatbot';
    $pageTitle = 'Chatbot Support';
    include(APPPATH . 'Views/dashboard/sidebar.php'); ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div class="db-stats" style="margin-bottom:24px;">
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-robot"></i></div>
                    <div><span class="db-stat-num">BIS Bot</span><span class="db-stat-label">AI Assistant</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(22,199,154,0.15);color:#16c79a;"><i class="fas fa-circle"></i></div>
                    <div><span class="db-stat-num">Online</span><span class="db-stat-label">Available 24/7</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(255,193,7,0.15);color:#ffc107;"><i class="fas fa-comments"></i></div>
                    <div><span class="db-stat-num">6</span><span class="db-stat-label">Quick Topics</span></div>
                </div>
                <div class="db-stat-card">
                    <div class="db-stat-icon" style="background:rgba(91,111,214,0.15);color:#5b6fd6;"><i class="fas fa-clock"></i></div>
                    <div><span class="db-stat-num">&lt;1s</span><span class="db-stat-label">Response Time</span></div>
                </div>
            </div>

            <div class="chatbot-intro-card">
                <div class="chatbot-intro-left">
                    <div class="chatbot-intro-avatar"><i class="fas fa-robot"></i></div>
                    <div>
                        <h3>BIS Chatbot Assistant</h3>
                        <p>Get instant answers about barangay services, clearances, census, and more. Click the chat button at the bottom-right to start.</p>
                    </div>
                </div>
                <button class="chatbot-open-btn" onclick="toggleChat()">
                    <i class="fas fa-comment-dots"></i> Start Chat
                </button>
            </div>

            <h3 class="db-section-title">Quick Topics</h3>
            <div class="chatbot-topics-grid">
                <div class="chatbot-topic-card" onclick="sendQuick('How do I apply for barangay clearance?');toggleChat();">
                    <div class="chatbot-topic-icon"><i class="fas fa-file-alt"></i></div>
                    <h4>Barangay Clearance</h4>
                    <p>Requirements, fees, and processing time</p>
                </div>
                <div class="chatbot-topic-card" onclick="sendQuick('What are the requirements for certificate of residency?');toggleChat();">
                    <div class="chatbot-topic-icon"><i class="fas fa-home"></i></div>
                    <h4>Certificate of Residency</h4>
                    <p>How to get proof of residence</p>
                </div>
                <div class="chatbot-topic-card" onclick="sendQuick('How do I update my census information?');toggleChat();">
                    <div class="chatbot-topic-icon"><i class="fas fa-users"></i></div>
                    <h4>Census Update</h4>
                    <p>Update your household data</p>
                </div>
                <div class="chatbot-topic-card" onclick="sendQuick('What are the barangay office hours?');toggleChat();">
                    <div class="chatbot-topic-icon"><i class="fas fa-clock"></i></div>
                    <h4>Office Hours</h4>
                    <p>When is the barangay hall open?</p>
                </div>
                <div class="chatbot-topic-card" onclick="sendQuick('What is the fee for barangay clearance?');toggleChat();">
                    <div class="chatbot-topic-icon"><i class="fas fa-coins"></i></div>
                    <h4>Fees & Payments</h4>
                    <p>Cost of documents and services</p>
                </div>
                <div class="chatbot-topic-card" onclick="sendQuick('How do I file a complaint?');toggleChat();">
                    <div class="chatbot-topic-icon"><i class="fas fa-exclamation-circle"></i></div>
                    <h4>File a Complaint</h4>
                    <p>Report issues to the barangay</p>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.querySelectorAll('.db-nav-item').forEach(i => i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open')));
    </script>
</body>

</html>