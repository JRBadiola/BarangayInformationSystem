<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Official Account - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role      = 'captain';
    $active    = 'settings';
    $pageTitle = 'Create Official Account';
    include(APPPATH . 'Views/dashboard/sidebar.php');
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div class="db-page-header">
                <h2><i class="fas fa-user-plus"></i> Create Official Account</h2>
                <p>Create accounts for Secretary or Treasurer. These accounts are immediately active.</p>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="db-alert db-alert--success">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="db-alert db-alert--error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="db-settings-card" style="max-width:520px;">
                <h4><i class="fas fa-id-badge"></i> New Official Account</h4>
                <form action="/captain/create-account/store" method="post">
                    <?= csrf_field() ?>

                    <div class="db-form-grid">
                        <div class="db-form-group db-form-group--full">
                            <label>Role</label>
                            <select name="role" class="db-select" required>
                                <option value="">-- Select Role --</option>
                                <option value="secretary">Secretary</option>
                                <option value="treasurer">Treasurer</option>
                            </select>
                        </div>
                        <div class="db-form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" placeholder="Last name" required>
                        </div>
                        <div class="db-form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" placeholder="First name" required>
                        </div>
                        <div class="db-form-group">
                            <label>Middle Name <span style="color:#9aa0b4;font-weight:400;">(optional)</span></label>
                            <input type="text" name="middle_name" placeholder="Middle name">
                        </div>
                        <div class="db-form-group">
                            <label>Username</label>
                            <input type="text" name="username" placeholder="Username" required>
                        </div>
                        <div class="db-form-group db-form-group--full">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Email address" required>
                        </div>
                        <div class="db-form-group">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Minimum 8 characters" minlength="8" required>
                        </div>
                        <div class="db-form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" placeholder="Confirm password" required>
                        </div>
                    </div>

                    <button type="submit" class="db-btn db-btn--primary">
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                </form>
            </div>

        </div>
    </div>
    <script>
        document.querySelectorAll('.db-nav-item').forEach(i => i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open')));

        // Client-side password match check
        document.querySelector('form').addEventListener('submit', function(e) {
            const pw = this.querySelector('[name="password"]').value;
            const cpw = this.querySelector('[name="confirm_password"]').value;
            if (pw !== cpw) {
                e.preventDefault();
                alert('Passwords do not match.');
            }
        });
    </script>
</body>

</html>