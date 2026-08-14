<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Template – BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        /* ── layout ── */
        .dte-grid {
            display: grid;
            grid-template-columns: 420px 1fr;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 1100px) {
            .dte-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── panel cards ── */
        .dte-panel {
            background: #fff;
            border: 1px solid #e8ecf4;
            border-radius: 14px;
            padding: 22px 24px;
        }

        .dte-panel-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1d2e;
            margin: 0 0 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dte-panel-title i {
            color: #9aa0b4;
        }

        /* ── form fields ── */
        .dte-field {
            margin-bottom: 14px;
        }

        .dte-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }

        .dte-input,
        .dte-textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13.5px;
            color: #1a1d2e;
            font-family: inherit;
            outline: none;
            transition: border-color .2s;
            box-sizing: border-box;
        }

        .dte-input:focus,
        .dte-textarea:focus {
            border-color: #5b6fd6;
        }

        .dte-textarea {
            font-family: 'Courier New', monospace;
            font-size: 12.5px;
            resize: vertical;
        }

        /* ── live preview frame ── */
        .dte-preview-wrap {
            background: #e8ecf4;
            border-radius: 10px;
            padding: 12px 0;
            overflow: auto;
            min-height: 500px;
            max-height: 80vh;
        }

        .dte-preview-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 300px;
            color: #9aa0b4;
            font-size: 13px;
            flex-direction: column;
            gap: 12px;
        }

        /* ── placeholder chips ── */
        .ph-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0f2ff;
            border: 1px solid #c9d0f5;
            color: #5b6fd6;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 11.5px;
            font-family: 'Courier New', monospace;
            cursor: pointer;
            margin: 3px;
            transition: background .15s;
        }

        .ph-chip:hover {
            background: #d8dcfc;
        }

        /* ── divider ── */
        .dte-divider {
            border: none;
            border-top: 1px solid #f0f2fa;
            margin: 18px 0;
        }

        /* ── tab bar ── */
        .dte-tabs {
            display: flex;
            gap: 4px;
            background: #f5f6fb;
            border-radius: 8px;
            padding: 4px;
            margin-bottom: 14px;
        }

        .dte-tab {
            flex: 1;
            padding: 7px 12px;
            border: none;
            background: transparent;
            border-radius: 6px;
            font-size: 12.5px;
            font-weight: 500;
            color: #6b7280;
            cursor: pointer;
            transition: background .15s, color .15s;
        }

        .dte-tab.active {
            background: #fff;
            color: #1a1d2e;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .08);
        }

        /* ── section ── */
        .dte-section {
            display: none;
        }

        .dte-section.active {
            display: block;
        }

        /* ── sticky preview header ── */
        .dte-preview-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'secretary';
    $active    = 'templates';
    $pageTitle = 'Edit Template';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $bs     = $barangaySettings ?? [];
    $fields = $template['fields'] ?? [];
    $html   = str_replace('\n', "\n", $template['html'] ?? '');  // decode literal \n from DB
    $key    = $template['template_key'];

    // Build the list of available {{placeholders}} from field names + barangay vars
    $fieldPlaceholders = array_map(fn($f) => '{{' . $f['name'] . '}}', $fields);
    $barangayPlaceholders = [
        '{{barangay_name}}',
        '{{municipality}}',
        '{{province}}',
        '{{region}}',
        '{{country}}',
        '{{full_address}}',
        '{{office_header}}',
        '{{captain_name}}',
        '{{captain_title}}',
    ];
    ?>

    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
                <div>
                    <div style="font-size:12px;color:#9aa0b4;margin-bottom:4px;">
                        <a href="<?= site_url('secretary/templates') ?>" style="color:#5b6fd6;text-decoration:none;">Templates</a>
                        <span style="margin:0 6px;">›</span>
                        <?= esc($template['name']) ?>
                    </div>
                    <h1 style="margin:0;font-size:20px;font-weight:700;color:#1a1d2e;"><?= esc($template['name']) ?></h1>
                </div>
                <a href="<?= site_url('secretary/templates') ?>" class="db-btn db-btn--outline" style="display:inline-flex;align-items:center;gap:8px;">
                    <i class="fas fa-arrow-left"></i> Back
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

            <form method="post" action="<?= site_url('secretary/templates/update/' . $key) ?>" id="templateForm">
                <?= csrf_field() ?>

                <div class="dte-grid">

                    <!-- ── LEFT PANEL: Fields + HTML editor ────────────────── -->
                    <div>
                        <!-- Tab bar -->
                        <div class="dte-tabs">
                            <button type="button" class="dte-tab active" onclick="switchTab('fields',this)">
                                <i class="fas fa-list-ul" style="margin-right:5px;"></i> Default Values
                            </button>
                            <button type="button" class="dte-tab" onclick="switchTab('html',this)">
                                <i class="fas fa-code" style="margin-right:5px;"></i> HTML Template
                            </button>
                        </div>

                        <!-- Fields tab -->
                        <div class="dte-section active" id="tab-fields">
                            <div class="dte-panel">
                                <p class="dte-panel-title"><i class="fas fa-list-ul"></i> Default Field Values</p>
                                <p style="font-size:12px;color:#9aa0b4;margin:0 0 16px;">These values pre-fill the document when a request is printed. They can be overridden per-request.</p>

                                <?php foreach ($fields as $field): ?>
                                    <div class="dte-field">
                                        <label class="dte-label" for="<?= esc($field['name']) ?>"><?= esc($field['label']) ?></label>
                                        <?php if (($field['type'] ?? 'text') === 'textarea'): ?>
                                            <textarea
                                                id="<?= esc($field['name']) ?>"
                                                name="<?= esc($field['name']) ?>"
                                                class="dte-textarea"
                                                rows="3"
                                                placeholder="<?= esc($field['label']) ?>"
                                                oninput="refreshPreview()"><?= esc($field['value'] ?? '') ?></textarea>
                                        <?php elseif (($field['type'] ?? 'text') === 'select' && !empty($field['options'])): ?>
                                            <select id="<?= esc($field['name']) ?>" name="<?= esc($field['name']) ?>" class="dte-input" onchange="refreshPreview()">
                                                <?php foreach ($field['options'] as $opt): ?>
                                                    <option value="<?= esc($opt) ?>" <?= ($field['value'] ?? '') === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php else: ?>
                                            <input
                                                type="text"
                                                id="<?= esc($field['name']) ?>"
                                                name="<?= esc($field['name']) ?>"
                                                class="dte-input"
                                                value="<?= esc($field['value'] ?? '') ?>"
                                                placeholder="<?= esc($field['label']) ?>"
                                                oninput="refreshPreview()" />
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>

                                <?php if (empty($fields)): ?>
                                    <p style="color:#9aa0b4;font-size:13px;">No editable fields for this template.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- HTML tab -->
                        <div class="dte-section" id="tab-html">
                            <div class="dte-panel">
                                <p class="dte-panel-title"><i class="fas fa-code"></i> Document HTML</p>

                                <!-- Available placeholders -->
                                <div style="margin-bottom:14px;">
                                    <div style="font-size:11px;font-weight:600;color:#9aa0b4;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">
                                        Available Placeholders — click to insert at cursor
                                    </div>
                                    <div>
                                        <?php if (!empty($fieldPlaceholders)): ?>
                                            <div style="font-size:11px;font-weight:600;color:#b0b6cc;margin-bottom:4px;">From fields:</div>
                                            <?php foreach ($fieldPlaceholders as $ph): ?>
                                                <span class="ph-chip" onclick="insertPlaceholder('<?= esc($ph) ?>')"><?= esc($ph) ?></span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <div style="font-size:11px;font-weight:600;color:#b0b6cc;margin:8px 0 4px;">Barangay info:</div>
                                        <?php foreach ($barangayPlaceholders as $ph): ?>
                                            <span class="ph-chip" onclick="insertPlaceholder('<?= esc($ph) ?>')"><?= esc($ph) ?></span>
                                        <?php endforeach; ?>
                                        <span class="ph-chip" onclick="insertPlaceholder('{{recipient_name}}')">{{recipient_name}}</span>
                                        <span class="ph-chip" onclick="insertPlaceholder('{{recipient_civil_status}}')">{{recipient_civil_status}}</span>
                                        <span class="ph-chip" onclick="insertPlaceholder('{{recipient_zone}}')">{{recipient_zone}}</span>
                                        <span class="ph-chip" onclick="insertPlaceholder('{{purpose}}')">{{purpose}}</span>
                                        <span class="ph-chip" onclick="insertPlaceholder('{{issued_ordinal_day}}')">{{issued_ordinal_day}}</span>
                                        <span class="ph-chip" onclick="insertPlaceholder('{{issued_month_year}}')">{{issued_month_year}}</span>
                                    </div>
                                </div>

                                <hr class="dte-divider">
                                <textarea
                                    id="htmlEditor"
                                    name="html"
                                    class="dte-textarea"
                                    rows="24"
                                    placeholder="Paste or write the document HTML here…"
                                    oninput="refreshPreview()"><?= esc($html) ?></textarea>
                                <p style="font-size:11px;color:#b0b6cc;margin:8px 0 0;">
                                    <i class="fas fa-info-circle"></i>
                                    Use <code>{{placeholder}}</code> tokens — they are replaced with real values when printing.
                                    Barangay info tokens like <code>{{barangay_name}}</code> pull from
                                    <a href="<?= site_url('secretary/barangay-settings') ?>" style="color:#5b6fd6;">Barangay Information settings</a>.
                                </p>
                            </div>
                        </div>

                        <!-- Save actions -->
                        <div style="display:flex;gap:12px;margin-top:14px;flex-wrap:wrap;">
                            <button type="submit" class="db-btn db-btn--primary" style="display:inline-flex;align-items:center;gap:8px;">
                                <i class="fas fa-save"></i> Save Template
                            </button>
                            <a href="<?= site_url('secretary/templates') ?>" class="db-btn db-btn--outline">Cancel</a>
                        </div>
                    </div>

                    <!-- ── RIGHT PANEL: Live preview ───────────────────────── -->
                    <div class="dte-panel" style="position:sticky;top:20px;">
                        <div class="dte-preview-header">
                            <p class="dte-panel-title" style="margin:0;"><i class="fas fa-eye"></i> Live Preview</p>
                            <button type="button" class="db-btn db-btn--sm db-btn--outline" onclick="printPreview()" style="display:inline-flex;align-items:center;gap:6px;">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>

                        <div class="dte-preview-wrap" id="previewWrap">
                            <div class="dte-preview-placeholder" id="previewPlaceholder">
                                <i class="fas fa-file-alt" style="font-size:32px;opacity:.3;"></i>
                                <span>Preview will appear here</span>
                            </div>
                            <div id="previewContent" style="display:none;"></div>
                        </div>

                        <!-- Barangay info summary -->
                        <div style="margin-top:14px;padding:12px 14px;background:#f8f9fc;border:1px solid #e8ecf4;border-radius:8px;font-size:12px;color:#6b7280;line-height:1.8;">
                            <strong style="color:#1a1d2e;display:block;margin-bottom:4px;">
                                <i class="fas fa-landmark" style="color:#9aa0b4;margin-right:5px;"></i>
                                Current Barangay Info
                            </strong>
                            <span><?= esc($bs['barangay_name'] ?? 'BARANGAY BACOLOD') ?></span><br>
                            <span><?= esc($bs['municipality'] ?? '') ?>, <?= esc($bs['province'] ?? '') ?></span><br>
                            <span><?= esc($bs['region'] ?? '') ?></span><br>
                            <span style="margin-top:4px;display:block;">
                                <strong>Captain:</strong> <?= esc($bs['captain_name'] ?? '—') ?>
                            </span>
                            <a href="<?= site_url('secretary/barangay-settings') ?>"
                                style="color:#5b6fd6;font-size:11.5px;margin-top:6px;display:inline-flex;align-items:center;gap:5px;">
                                <i class="fas fa-pen"></i> Edit Barangay Info
                            </a>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- ── Barangay settings injected for JS preview replacement ── -->
    <script>
        const _bs = <?= json_encode([
                        'barangay_name'  => $bs['barangay_name']  ?? 'BARANGAY BACOLOD',
                        'municipality'   => $bs['municipality']   ?? 'Municipality of Bato',
                        'province'       => $bs['province']       ?? 'Province of Camarines Sur',
                        'region'         => $bs['region']         ?? 'Region V',
                        'country'        => $bs['country']        ?? 'Republic of the Philippines',
                        'full_address'   => $bs['full_address']   ?? 'Barangay Bacolod, Bato, Camarines Sur',
                        'office_header'  => $bs['office_header']  ?? 'OFFICE OF THE PUNONG BARANGAY',
                        'captain_name'   => $bs['captain_name']   ?? 'PUNONG BARANGAY',
                        'captain_title'  => $bs['captain_title']  ?? 'Punong Barangay',
                    ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;

        // ── Tab switching ─────────────────────────────────────────────────────────
        function switchTab(tab, btn) {
            document.querySelectorAll('.dte-section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.dte-tab').forEach(b => b.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
            btn.classList.add('active');
        }

        // ── Insert placeholder at cursor in HTML editor ───────────────────────────
        function insertPlaceholder(ph) {
            const ta = document.getElementById('htmlEditor');
            if (!ta) return;
            const start = ta.selectionStart,
                end = ta.selectionEnd;
            ta.value = ta.value.substring(0, start) + ph + ta.value.substring(end);
            ta.selectionStart = ta.selectionEnd = start + ph.length;
            ta.focus();
            refreshPreview();
        }

        // ── Collect current field values from the form ────────────────────────────
        function collectFieldValues() {
            const vals = {};
            document.querySelectorAll('[name]').forEach(el => {
                if (el.name && el.name !== 'html' && !el.name.startsWith('csrf')) {
                    vals[el.name] = el.value || '';
                }
            });
            return vals;
        }

        // ── Ordinal helper ────────────────────────────────────────────────────────
        function ordinal(n) {
            const s = ['th', 'st', 'nd', 'rd'],
                v = n % 100;
            return n + (s[(v - 20) % 10] || s[v] || s[0]);
        }

        // ── Replace all {{tokens}} in the HTML ────────────────────────────────────
        function applyTokens(rawHtml) {
            const d = new Date();
            const month = d.toLocaleString('default', {
                month: 'long'
            });
            const year = d.getFullYear();
            const day = d.getDate();

            // Gather replacement map
            const replacements = {
                // Barangay settings
                ...Object.fromEntries(Object.entries(_bs)),
                // Issued date helpers
                issued_ordinal_day: ordinal(day),
                issued_month_year: month + ', ' + year,
                // Census / request context stubs (shown in preview)
                recipient_name: '[Resident Name]',
                recipient_civil_status: '[Civil Status]',
                recipient_zone: '[Zone]',
                purpose: '[Purpose]',
                // Field values from the form (override stubs)
                ...collectFieldValues(),
            };

            return rawHtml.replace(/\{\{(\w+)\}\}/g, (_, key) => {
                return key in replacements ? replacements[key] : '{{' + key + '}}';
            });
        }

        // ── Screen-preview CSS (appended so .bc-wrap / .bc-page render correctly) ─
        const BC_SCREEN_CSS = `<style>
.bc-wrap{font-family:'Cambria',serif;font-size:14px;color:#111;background:#f0f0f0;display:flex;justify-content:center;padding:20px 0;}
.bc-page{width:100%;min-height:600px;background:#fff;border:2px solid #3a6abf;box-sizing:border-box;display:flex;flex-direction:column;position:relative;}
.bc-top-box{border-bottom:2px solid #3a6abf;padding:20px 40px 0;}
.bc-header-row{display:flex;align-items:flex-start;justify-content:center;gap:32px;padding-bottom:14px;}
.bc-seal{width:80px;height:80px;object-fit:contain;border-radius:50%;}
.bc-header-center{text-align:center;font-family:'Times New Roman',serif;font-size:12px;font-weight:bold;line-height:1.6;color:#111;}
.bc-header-center p{margin:0;}.bc-oOo{font-weight:normal!important;font-style:italic;}
.bc-office-bar{font-family:'Times New Roman',serif;font-size:13px;font-weight:bold;color:#111;padding:8px 0 10px;text-align:center;}
.bc-body-box{flex:1;padding:24px 40px 28px;position:relative;overflow:hidden;}
.bc-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:0.06;pointer-events:none;z-index:0;}
.bc-watermark img{width:300px;height:300px;object-fit:contain;}
.bc-doc-title{text-align:center;font-family:'Times New Roman',serif;font-size:18px;font-weight:700;margin-bottom:22px;position:relative;z-index:1;letter-spacing:.5px;}
.bc-body-text{font-family:'Times New Roman',serif;font-size:13px;position:relative;z-index:1;line-height:1.9;text-align:justify;}
.bc-body-text p{margin:0 0 12px;}.bc-indent{text-indent:3em;}
.bc-line{display:inline-block;border-bottom:1px solid #111;vertical-align:bottom;height:1px;}
.bc-sig-section{display:flex;justify-content:space-between;align-items:flex-end;margin:36px 0 24px;position:relative;z-index:1;}
.bc-sig-left{min-width:180px;}.bc-sig-line{border-bottom:1px solid #111;width:170px;margin-bottom:4px;}
.bc-sig-sub{font-size:11px;color:#444;}.bc-sig-right{text-align:center;}
.bc-approved-by{margin:0 0 4px;font-size:13px;}.bc-captain-name{margin:0;font-weight:700;font-size:14px;letter-spacing:.3px;}
.bc-captain-title{margin:0;font-size:12px;color:#333;}
.bc-footer-info{margin-top:18px;font-family:'Times New Roman',serif;position:relative;z-index:1;font-size:11px;line-height:1.6;}
.bc-footer-info p{margin:0;}.bc-photo-row{display:flex;gap:10px;margin:8px 0;}
.bc-photo-box{width:70px;height:65px;border:1px solid #555;}
.bc-two-col{display:flex;flex-direction:row;padding:0!important;}
.bc-officials{width:180px;flex-shrink:0;border-right:1.5px solid #3a6abf;padding:14px 12px;display:flex;flex-direction:column;font-family:'Times New Roman',serif;}
.bc-off-head{font-size:10px;font-weight:700;color:#111;margin:0 0 3px;text-decoration:underline;}
.bc-off-name{font-size:10px;font-weight:700;color:#111;margin:5px 0 0;}.bc-off-role{font-size:9px;color:#3a6abf;margin:0;}
.bc-right-col{flex:1;padding:22px 28px;position:relative;overflow:hidden;}
.bc-not-valid{color:#c0392b;font-size:12px;font-weight:600;position:relative;z-index:1;margin:8px 0 0;}
.doc-template{padding:24px 28px;font-family:'Times New Roman',serif;font-size:12px;color:#111;line-height:1.7;}
.doc-header{text-align:center;margin-bottom:16px;border-bottom:2px solid #1d2448;padding-bottom:12px;}
.doc-republic,.doc-province,.doc-municipality{font-size:10px;color:#555;margin:0;}
.doc-barangay{font-size:15px;font-weight:700;color:#1d2448;margin:5px 0 2px;letter-spacing:.5px;}
.doc-logo-row{display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:6px;}
.doc-logo{width:50px;height:50px;border-radius:50%;border:2px solid #1d2448;object-fit:contain;}
.doc-title{text-align:center;margin:14px 0 5px;}
.doc-title h2{font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#1d2448;margin:0;text-decoration:underline;}
.doc-title p{font-size:10px;color:#777;margin:3px 0 0;font-style:italic;}
.doc-body{margin:16px 0;text-align:justify;}.doc-body p{margin:0 0 10px;}
.doc-blank{display:inline-block;border-bottom:1px solid #111;min-width:140px;text-align:center;}
.doc-footer{margin-top:28px;display:flex;justify-content:flex-end;}
.doc-sig{text-align:center;min-width:180px;}
.doc-sig-line{border-top:1px solid #111;margin-top:40px;padding-top:4px;font-weight:700;font-size:12px;}
.doc-sig-title{font-size:10px;color:#555;}
.doc-or{margin-top:16px;font-size:10px;color:#555;border-top:1px dashed #ccc;padding-top:8px;}
.doc-control{text-align:right;font-size:10px;color:#777;margin-bottom:6px;}
</style>`;

        // ── Refresh the live preview ──────────────────────────────────────────────
        function refreshPreview() {
            const ta = document.getElementById('htmlEditor');
            if (!ta) return;

            const raw = ta.value.trim();
            if (!raw) {
                document.getElementById('previewContent').style.display = 'none';
                document.getElementById('previewPlaceholder').style.display = 'flex';
                return;
            }

            const rendered = applyTokens(raw) + BC_SCREEN_CSS;
            document.getElementById('previewPlaceholder').style.display = 'none';
            const content = document.getElementById('previewContent');
            content.style.display = 'block';
            content.innerHTML = rendered;
        }

        // ── Print the rendered preview ────────────────────────────────────────────
        function printPreview() {
            const ta = document.getElementById('htmlEditor');
            if (!ta || !ta.value.trim()) {
                alert('No HTML to print.');
                return;
            }

            const rendered = applyTokens(ta.value);
            const win = window.open('', '_blank', 'width=900,height=900');
            win.document.write(`<!DOCTYPE html><html><head>
<title>${<?= json_encode(esc($template['name'])) ?>}</title>
<style>
@page{size:A4 portrait;margin:0;}*{box-sizing:border-box;}body{margin:0;padding:0;background:#fff;}
.bc-wrap{font-family:'Cambria',serif;font-size:14px;color:#111;width:210mm;height:297mm;padding:7mm;display:block;}
.bc-page{width:100%;height:100%;border:2.5px solid #3a6abf;display:flex;flex-direction:column;position:relative;overflow:hidden;padding:8mm 12mm;}
.bc-top-box{border-bottom:2px solid #3a6abf;padding:4mm 12mm 4mm;margin:0 -12mm;flex-shrink:0;}
.bc-header-row{display:flex;align-items:center;justify-content:center;gap:14px;padding-bottom:3px;}
.bc-seal{width:82px;height:82px;object-fit:contain;border-radius:50%;}
.bc-header-center{text-align:center;font-family:'Times New Roman',serif;font-size:12pt;font-weight:bold;line-height:1.5;}
.bc-header-center p{margin:0;}.bc-oOo{font-weight:normal!important;font-style:italic;}
.bc-office-bar{text-align:center;font-family:'Times New Roman',serif;font-size:14pt;font-weight:bold;padding:4px 0 0;flex-shrink:0;}
.bc-body-box{flex:1;display:flex;flex-direction:column;padding:0;position:relative;}
.bc-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:0.07;pointer-events:none;z-index:0;}
.bc-watermark img{width:150mm;height:150mm;object-fit:contain;}
.bc-doc-title{text-align:center;font-family:'Times New Roman',serif;font-size:22pt;font-weight:bold;margin:8mm 0 7mm;position:relative;z-index:1;flex-shrink:0;}
.bc-body-text{font-family:'Times New Roman',serif;font-size:14pt;line-height:2.2;text-align:justify;position:relative;z-index:1;flex:1;}
.bc-body-text p{margin:0 0 4mm;}.bc-indent{text-indent:3em;}
.bc-line{display:inline-block;border-bottom:1px solid #111;vertical-align:bottom;height:1px;}
.bc-sig-section{display:flex;justify-content:space-between;align-items:flex-end;margin-top:auto;padding-top:14mm;position:relative;z-index:1;flex-shrink:0;}
.bc-sig-left{min-width:180px;}.bc-sig-line{border-bottom:1px solid #111;width:180px;margin-bottom:3px;}
.bc-sig-sub{font-size:12pt;color:#444;}.bc-sig-right{text-align:center;}
.bc-approved-by{margin:0 0 3px;font-size:13pt;}.bc-captain-name{margin:0;font-weight:bold;font-size:14pt;}
.bc-captain-title{margin:0;font-size:13pt;color:#333;}
.bc-footer-info{font-family:'Times New Roman',serif;font-size:12pt;line-height:1.7;position:relative;z-index:1;flex-shrink:0;margin-top:5mm;}
.bc-footer-info p{margin:0;}.bc-photo-row{display:flex;gap:10px;margin:5px 0;}
.bc-photo-box{width:80px;height:90px;border:1px solid #555;}
.bc-two-col{display:flex;flex-direction:row;padding:0!important;}
.bc-officials{width:180px;flex-shrink:0;border-right:1.5px solid #3a6abf;padding:14px 12px;display:flex;flex-direction:column;font-family:'Times New Roman',serif;}
.bc-off-head{font-size:11px;font-weight:700;color:#111;margin:0 0 4px;text-decoration:underline;}
.bc-off-name{font-size:11px;font-weight:700;color:#111;margin:6px 0 0;}.bc-off-role{font-size:10px;color:#3a6abf;margin:0;}
.bc-right-col{flex:1;padding:22px 28px 28px;position:relative;overflow:hidden;}
.bc-not-valid{color:#c0392b;font-size:13pt;font-weight:600;margin-top:10mm;position:relative;z-index:1;flex-shrink:0;}
.doc-template{padding:40px 48px;font-family:'Times New Roman',serif;font-size:13px;color:#111;}
.doc-header{text-align:center;margin-bottom:20px;border-bottom:2px solid #1d2448;padding-bottom:14px;}
.doc-republic,.doc-province,.doc-municipality{font-size:11px;color:#555;margin:0;}
.doc-barangay{font-size:18px;font-weight:700;color:#1d2448;margin:6px 0 2px;}
.doc-logo-row{display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:8px;}
.doc-logo{width:60px;height:60px;border-radius:50%;border:2px solid #1d2448;object-fit:contain;}
.doc-title{text-align:center;margin:18px 0 6px;}
.doc-title h2{font-size:16px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#1d2448;margin:0;text-decoration:underline;}
.doc-title p{font-size:11px;color:#777;margin:4px 0 0;font-style:italic;}
.doc-body{margin:20px 0;text-align:justify;}.doc-body p{margin:0 0 12px;}
.doc-blank{display:inline-block;border-bottom:1px solid #111;min-width:180px;text-align:center;}
.doc-footer{margin-top:48px;display:flex;justify-content:flex-end;}
.doc-sig{text-align:center;min-width:200px;}
.doc-sig-line{border-top:1px solid #111;margin-top:48px;padding-top:4px;font-weight:700;font-size:13px;}
.doc-sig-title{font-size:11px;color:#555;}
.doc-or{margin-top:20px;font-size:11px;color:#555;border-top:1px dashed #ccc;padding-top:10px;}
.doc-control{text-align:right;font-size:11px;color:#777;margin-bottom:8px;}
</style>
</head><body>${rendered}<script>window.onload=function(){window.print();window.close();}<\/script></body></html>`);
            win.document.close();
        }

        // ── Initial render on page load ───────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            refreshPreview();
        });
    </script>
</body>

</html>