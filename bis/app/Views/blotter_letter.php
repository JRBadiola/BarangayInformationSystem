<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm 18mm 20mm 18mm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
        }

        /* ── Screen toolbar ── */
        .toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #1d2448;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 999;
        }

        .toolbar span {
            color: rgba(255, 255, 255, .7);
            font-family: Arial, sans-serif;
            font-size: 13px;
            flex: 1;
        }

        .tb-btn {
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .tb-btn--primary {
            background: #16c79a;
            color: #fff;
        }

        .tb-btn--back {
            background: rgba(255, 255, 255, .15);
            color: #fff;
        }

        .tb-tip {
            position: fixed;
            top: 52px;
            left: 0;
            right: 0;
            background: #1d2448;
            border-bottom: 3px solid #16c79a;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #fff;
            z-index: 998;
        }

        .tb-tip strong {
            color: #16c79a;
        }

        @media print {

            .toolbar,
            .tb-tip {
                display: none !important;
            }

            body {
                margin: 0;
            }
        }

        /* ── Letter wrapper ── */
        .letter {
            max-width: 170mm;
            margin: 110px auto 40px;
            padding: 0;
        }

        @media print {
            .letter {
                margin: 0;
                max-width: 100%;
            }
        }

        /* ── Header ── */
        .letter-header {
            text-align: center;
            margin-bottom: 20pt;
            border-bottom: 3px double #000;
            padding-bottom: 12pt;
        }

        .letter-header .republic {
            font-size: 10pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4pt;
        }

        .letter-header .brgy-name {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .letter-header .brgy-address {
            font-size: 10pt;
            margin-top: 2pt;
        }

        .letter-header .office-line {
            font-size: 10pt;
            font-style: italic;
            margin-top: 4pt;
            color: #333;
        }

        /* ── Letter meta ── */
        .letter-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20pt;
            font-size: 11pt;
        }

        .letter-meta .case-no {
            font-weight: bold;
        }

        /* ── Letter title ── */
        .letter-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 20pt;
            text-decoration: underline;
        }

        /* ── Salutation & body ── */
        .letter-salutation {
            margin-bottom: 14pt;
            font-size: 12pt;
        }

        .letter-body {
            font-size: 12pt;
            line-height: 1.8;
            text-align: justify;
            margin-bottom: 14pt;
        }

        /* ── Hearing box ── */
        .hearing-box {
            border: 2px solid #000;
            padding: 12pt 16pt;
            margin: 16pt 0;
            background: #f9f9f9;
        }

        .hearing-box .hb-title {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8pt;
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 6pt;
        }

        .hearing-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .hearing-box td {
            padding: 4pt 8pt;
            font-size: 11pt;
            vertical-align: top;
        }

        .hearing-box td:first-child {
            font-weight: bold;
            width: 120pt;
            color: #333;
        }

        /* ── Warning ── */
        .letter-warning {
            font-size: 11pt;
            font-style: italic;
            margin: 14pt 0;
            padding: 8pt 12pt;
            border-left: 4px solid #000;
            background: #f5f5f5;
            line-height: 1.6;
        }

        /* ── Signature block ── */
        .signature-block {
            margin-top: 32pt;
            display: flex;
            justify-content: space-between;
            gap: 40pt;
        }

        .sig-col {
            flex: 1;
            text-align: center;
        }

        .sig-line {
            border-bottom: 1px solid #000;
            margin-bottom: 4pt;
            height: 32pt;
        }

        .sig-name {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .sig-title {
            font-size: 10pt;
            font-style: italic;
            color: #444;
        }

        /* ── Footer ── */
        .letter-footer {
            margin-top: 24pt;
            border-top: 1px solid #ccc;
            padding-top: 8pt;
            font-size: 9pt;
            color: #666;
            text-align: center;
        }

        /* ── Copy section ── */
        .copy-section {
            margin-top: 20pt;
            font-size: 10pt;
        }

        .copy-section p {
            margin-bottom: 4pt;
        }
    </style>
</head>

<body>

    <!-- Screen toolbar -->
    <div class="toolbar">
        <button class="tb-btn tb-btn--back" onclick="history.back()">&#8592; Back</button>
        <button class="tb-btn tb-btn--primary" onclick="printLetter()">&#128438; Save as PDF / Print</button>
    </div>
    <div class="tb-tip">
        <span>💡</span>
        <span>Click <strong>Save as PDF / Print</strong> → set <strong>Destination</strong> to <strong>"Save as PDF"</strong> → click <strong>Save</strong>.</span>
    </div>

    <?php
    $r       = $report;
    $caseNo  = str_pad($r['id'], 4, '0', STR_PAD_LEFT);
    $today   = date('F d, Y');
    $hDate   = ! empty($r['hearing_date']) ? date('F d, Y', strtotime($r['hearing_date'])) : '___________________';
    $hTime   = ! empty($r['hearing_time']) ? date('h:i A', strtotime($r['hearing_time']))  : '___________';
    $incDate = ! empty($r['incident_date']) ? date('F d, Y', strtotime($r['incident_date'])) : 'an unspecified date';
    $complainantName  = esc($r['complainant_full_name'] ?? $r['complainant_name'] ?? '—');
    $respondentName   = esc($r['persons_involved'] ?? '___________________________');
    $respondentAddr   = esc($r['respondent_address'] ?? 'Barangay Bacolod, Bato, Camarines Sur');
    $incidentType     = esc($r['incident_type']);
    $location         = esc($r['location'] ?? 'Barangay Bacolod');
    $hearingNotes     = esc($r['hearing_notes'] ?? '');
    ?>

    <!-- ── COMPLAINANT COPY ── -->
    <div class="letter">

        <!-- Header -->
        <div class="letter-header">
            <div class="republic">Republic of the Philippines</div>
            <div class="brgy-name">Barangay Bacolod</div>
            <div class="brgy-address">Bato, Camarines Sur, Philippines</div>
            <div class="office-line">Office of the Punong Barangay</div>
        </div>
        <!-- Title -->
        <div class="letter-title">Summons</div>

        <!-- Salutation -->
        <div class="letter-salutation">
            To: <strong><?= $complainantName ?></strong><br>
            Barangay Bacolod, Bato, Camarines Sur
        </div>

        <!-- Body -->
        <div class="letter-body">
            <p>Greetings!</p>
            <br>
            <p>
                You are hereby summoned to appear before the <strong>Lupong Tagapamayapa</strong> of
                Barangay Bacolod, Bato, Camarines Sur, in connection with the blotter complaint
                you filed on <strong><?= date('F d, Y', strtotime($r['created_at'])) ?></strong>
                involving a case of <strong><?= $incidentType ?></strong> that allegedly occurred on
                <strong><?= $incDate ?></strong> at <strong><?= $location ?></strong>.
            </p>
            <br>
            <p>
                The hearing has been scheduled as follows:
            </p>
        </div>

        <!-- Hearing box -->
        <div class="hearing-box">
            <div class="hb-title">Hearing Schedule</div>
            <table>
                <tr>
                    <td>Date:</td>
                    <td><strong><?= $hDate ?></strong></td>
                </tr>
                <tr>
                    <td>Time:</td>
                    <td><strong><?= $hTime ?></strong></td>
                </tr>
                <tr>
                    <td>Venue:</td>
                    <td><strong>Barangay Hall, Bacolod, Bato, Camarines Sur</strong></td>
                </tr>
                <tr>
                    <td>Case No.:</td>
                    <td><strong>BL-<?= $caseNo ?></strong></td>
                </tr>
                <?php if ($hearingNotes): ?>
                    <tr>
                        <td>Notes:</td>
                        <td><?= $hearingNotes ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="letter-body">
            <p>
                For inquiries, please contact the Barangay Hall during office hours
                (Monday to Friday, 8:00 AM – 5:00 PM).
            </p>
            <br>
            <p>Thank you for your cooperation.</p>
        </div>

        <!-- Signature -->
        <div class="signature-block">
            <div class="sig-col">
                <div class="sig-line"></div>
                <div class="sig-name">Punong Barangay</div>
                <div class="sig-title">Barangay Bacolod, Bato, Camarines Sur</div>
            </div>
            <div class="sig-col">
                <div class="sig-line"></div>
                <div class="sig-name">Barangay Secretary</div>
                <div class="sig-title">Barangay Bacolod, Bato, Camarines Sur</div>
            </div>
        </div>

    </div>

    <!-- ── PAGE BREAK ── -->
    <div style="page-break-after: always;"></div>

    <!-- ── RESPONDENT COPY ── -->
    <div class="letter">

        <!-- Header -->
        <div class="letter-header">
            <div class="republic">Republic of the Philippines</div>
            <div class="brgy-name">Barangay Bacolod</div>
            <div class="brgy-address">Bato, Camarines Sur, Philippines</div>
            <div class="office-line">Office of the Punong Barangay</div>
        </div>
        <!-- Title -->
        <div class="letter-title">Summons</div>

        <!-- Salutation -->
        <div class="letter-salutation">
            To: <strong><?= $respondentName ?></strong><br>
            <?= $respondentAddr ?>
        </div>

        <!-- Body -->
        <div class="letter-body">
            <p>Greetings!</p>
            <br>
            <p>
                You are hereby summoned to appear before the <strong>Lupong Tagapamayapa</strong> of
                Barangay Bacolod, Bato, Camarines Sur, in connection with a complaint filed against you
                by <strong><?= $complainantName ?></strong> involving a case of
                <strong><?= $incidentType ?></strong> that allegedly occurred on
                <strong><?= $incDate ?></strong> at <strong><?= $location ?></strong>.
            </p>
            <br>
            <p>
                The hearing has been scheduled as follows:
            </p>
        </div>

        <!-- Hearing box -->
        <div class="hearing-box">
            <div class="hb-title">Hearing Schedule</div>
            <table>
                <tr>
                    <td>Date:</td>
                    <td><strong><?= $hDate ?></strong></td>
                </tr>
                <tr>
                    <td>Time:</td>
                    <td><strong><?= $hTime ?></strong></td>
                </tr>
                <tr>
                    <td>Venue:</td>
                    <td><strong>Barangay Hall, Bacolod, Bato, Camarines Sur</strong></td>
                </tr>
                <tr>
                    <td>Case No.:</td>
                    <td><strong>BL-<?= $caseNo ?></strong></td>
                </tr>
                <?php if ($hearingNotes): ?>
                    <tr>
                        <td>Notes:</td>
                        <td><?= $hearingNotes ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        <div class="letter-body">
            <p>
                For inquiries, please contact the Barangay Hall during office hours
                (Monday to Friday, 8:00 AM – 5:00 PM).
            </p>
            <br>
            <p>Thank you for your cooperation.</p>
        </div>

        <!-- Signature -->
        <div class="signature-block">
            <div class="sig-col">
                <div class="sig-line"></div>
                <div class="sig-name">Punong Barangay</div>
                <div class="sig-title">Barangay Bacolod, Bato, Camarines Sur</div>
            </div>
            <div class="sig-col">
                <div class="sig-line"></div>
                <div class="sig-name">Barangay Secretary</div>
                <div class="sig-title">Barangay Bacolod, Bato, Camarines Sur</div>
            </div>
        </div>

    </div>

    <script>
        function printLetter() {
            document.querySelector('.tb-tip').style.display = 'flex';
            setTimeout(function() {
                window.print();
            }, 300);
        }
        // Auto-open print on load
        window.addEventListener('load', function() {
            setTimeout(printLetter, 700);
        });
    </script>
</body>

</html>