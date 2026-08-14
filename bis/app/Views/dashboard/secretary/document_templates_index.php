<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Templates - BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="db-body">
    <?php
    $role      = 'secretary';
    $active    = 'templates';
    $pageTitle = 'Document Templates';
    include(APPPATH . 'Views/dashboard/sidebar.php');
    ?>

    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:24px;">
                <div class="db-page-title" style="margin:0;">
                    <h1 style="margin:0 0 4px;">Document Template Manager</h1>
                    <p class="db-page-subtitle" style="margin:0;">Edit the default document fields and HTML used for issuance and printing.</p>
                </div>
                <a href="<?= site_url('secretary/barangay-settings') ?>"
                    class="db-btn db-btn--primary"
                    style="display:inline-flex;align-items:center;gap:8px;white-space:nowrap;flex-shrink:0;">
                    <i class="fas fa-landmark"></i> Barangay Information
                </a>
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

            <?php
            $iconMap = [
                'clearance'  => ['icon' => 'fa-file-alt',      'color' => '#5b6fd6', 'bg' => '#f0f2ff'],
                'residency'  => ['icon' => 'fa-home',           'color' => '#16c79a', 'bg' => '#edfaf5'],
                'indigency'  => ['icon' => 'fa-hands-helping',  'color' => '#f6a623', 'bg' => '#fff8ee'],
                'business'   => ['icon' => 'fa-store',          'color' => '#e25474', 'bg' => '#fff0f3'],
                'good_moral' => ['icon' => 'fa-award',          'color' => '#7c5cbf', 'bg' => '#f5f0ff'],
                'solo_parent' => ['icon' => 'fa-child',          'color' => '#3a8fd9', 'bg' => '#eef6fd'],
            ];
            ?>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;">
                <?php foreach ($templates as $template):
                    $key  = $template['template_key'];
                    $meta = $iconMap[$key] ?? ['icon' => 'fa-file', 'color' => '#9aa0b4', 'bg' => '#f8f9fc'];
                ?>
                    <div style="background:#fff;border:1px solid #e8ecf4;border-radius:14px;padding:20px 22px;display:flex;flex-direction:column;gap:14px;transition:box-shadow .2s;"
                        onmouseenter="this.style.boxShadow='0 4px 18px rgba(91,111,214,.13)'"
                        onmouseleave="this.style.boxShadow='none'">

                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:42px;height:42px;border-radius:10px;background:<?= $meta['bg'] ?>;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas <?= $meta['icon'] ?>" style="color:<?= $meta['color'] ?>;font-size:18px;"></i>
                            </div>
                            <div>
                                <h3 style="margin:0 0 2px;font-size:14px;font-weight:600;color:#1a1d2e;"><?= esc($template['name']) ?></h3>
                                <code style="font-size:11px;color:#9aa0b4;background:#f5f6fa;padding:1px 6px;border-radius:4px;"><?= esc($key) ?></code>
                            </div>
                        </div>

                        <?php if (! empty($template['fields'])): ?>
                            <div style="font-size:12px;color:#6b7280;line-height:1.7;">
                                <span style="font-weight:600;color:#9aa0b4;font-size:11px;text-transform:uppercase;letter-spacing:.5px;">Editable fields</span><br>
                                <?= implode(', ', array_column($template['fields'], 'label')) ?>
                            </div>
                        <?php endif; ?>

                        <a href="<?= site_url('secretary/templates/edit/' . $key) ?>"
                            class="db-btn db-btn--outline"
                            style="display:inline-flex;align-items:center;gap:8px;margin-top:auto;font-size:13px;">
                            <i class="fas fa-pen"></i> Edit Template
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</body>

</html>