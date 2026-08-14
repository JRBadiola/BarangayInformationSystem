<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Settings - BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role      = 'secretary';
    $active    = 'templates';
    $pageTitle = 'Barangay Settings';
    include(APPPATH . 'Views/dashboard/sidebar.php');
    ?>

    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div class="db-page-title">
                <h1>Barangay Information</h1>
                <p class="db-page-subtitle">Update the barangay identity, officials, and fees that appear on all documents.</p>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="db-alert db-alert--success" style="margin-bottom:18px;">
                    <i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="db-alert db-alert--danger" style="margin-bottom:18px;">
                    <i class="fas fa-exclamation-circle"></i> <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <div style="margin-bottom:20px;">
                <a href="<?= site_url('secretary/templates') ?>" class="db-btn db-btn--outline" style="display:inline-flex;align-items:center;gap:8px;">
                    <i class="fas fa-arrow-left"></i> Back to Templates
                </a>
            </div>

            <?php if (empty($settingsGrouped)): ?>
                <div class="db-alert db-alert--danger">
                    <i class="fas fa-database"></i>
                    The <strong>barangay_settings</strong> table does not exist yet.
                    Please run <code>php spark migrate</code> in the terminal first.
                </div>
            <?php else: ?>

                <!-- Active Captain notice (read-only, auto-managed) -->
                <div style="background:#f0f2ff;border:1.5px solid #c9d0f5;border-radius:12px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:14px;">
                    <div style="width:38px;height:38px;border-radius:10px;background:#5b6fd6;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-user-tie" style="color:#fff;font-size:16px;"></i>
                    </div>
                    <div>
                        <div style="font-size:11.5px;font-weight:600;color:#5b6fd6;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px;">
                            Active Punong Barangay
                        </div>
                        <div style="font-size:15px;font-weight:700;color:#1a1d2e;">
                            <?= esc($barangaySettings['captain_name'] ?: '— No active captain appointed —') ?>
                        </div>
                        <div style="font-size:12px;color:#6b7280;margin-top:2px;">
                            <i class="fas fa-info-circle" style="margin-right:4px;color:#9aa0b4;"></i>
                            Automatically updated when a Captain account is appointed.
                            To change, go to
                            <a href="<?= site_url('secretary/create-account') ?>" style="color:#5b6fd6;">Create Official</a>.
                        </div>
                    </div>
                </div>

                <form method="post" action="<?= site_url('secretary/barangay-settings/save') ?>">
                    <?= csrf_field() ?>

                    <?php
                    $groupLabels = [
                        'identity' => ['icon' => 'fa-landmark',   'title' => 'Barangay Identity',   'desc' => 'Name, location, and header text used on document letterheads.'],
                        'officials' => ['icon' => 'fa-user-tie',    'title' => 'Barangay Officials',  'desc' => 'Names displayed on document signatures.'],
                        'fees'     => ['icon' => 'fa-peso-sign',   'title' => 'Document Fees',       'desc' => 'Default fees shown to residents when requesting documents.'],
                    ];

                    foreach ($settingsGrouped as $group => $rows):
                        $meta = $groupLabels[$group] ?? ['icon' => 'fa-cog', 'title' => ucfirst($group), 'desc' => ''];
                    ?>
                        <div class="bset-card" style="background:#fff;border:1px solid #e8ecf4;border-radius:14px;padding:24px 28px;margin-bottom:20px;">
                            <div class="bset-card-header" style="display:flex;align-items:center;gap:12px;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid #f0f2fa;">
                                <div style="width:40px;height:40px;border-radius:10px;background:#f0f2ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas <?= $meta['icon'] ?>" style="color:#5b6fd6;font-size:16px;"></i>
                                </div>
                                <div>
                                    <h3 style="margin:0;font-size:15px;font-weight:600;color:#1a1d2e;"><?= esc($meta['title']) ?></h3>
                                    <p style="margin:0;font-size:12px;color:#9aa0b4;"><?= esc($meta['desc']) ?></p>
                                </div>
                            </div>

                            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:14px;">
                                <?php foreach ($rows as $row): ?>
                                    <div class="db-form-group" style="margin:0;">
                                        <label for="<?= esc($row['setting_key']) ?>" style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;display:block;">
                                            <?= esc($row['label']) ?>
                                        </label>
                                        <input
                                            type="text"
                                            id="<?= esc($row['setting_key']) ?>"
                                            name="<?= esc($row['setting_key']) ?>"
                                            value="<?= esc($row['setting_value'] ?? '') ?>"
                                            placeholder="<?= esc($row['label']) ?>"
                                            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13.5px;color:#1a1d2e;outline:none;transition:border-color .2s;"
                                            onfocus="this.style.borderColor='#5b6fd6'"
                                            onblur="this.style.borderColor='#e2e8f0'" />
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div style="display:flex;gap:12px;margin-top:8px;">
                        <button type="submit" class="db-btn db-btn--primary" style="display:inline-flex;align-items:center;gap:8px;">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <a href="<?= site_url('secretary/templates') ?>" class="db-btn db-btn--outline">Cancel</a>
                    </div>
                </form>

            <?php endif; ?>

        </div>
    </div>
</body>

</html>