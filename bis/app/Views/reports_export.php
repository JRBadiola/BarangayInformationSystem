<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Bacolod — Reports CY <?= date('Y') ?></title>
    <style>
        /* ── Page setup ── */
        @page {
            size: A4 portrait;
            margin: 15mm 14mm 15mm 14mm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #000;
            background: #fff;
        }

        /* ── Screen-only toolbar ── */
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, .3);
        }

        .toolbar span {
            color: rgba(255, 255, 255, .7);
            font-size: 13px;
            font-family: Arial, sans-serif;
            flex: 1;
        }

        .tb-btn {
            padding: 8px 20px;
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

        @media print {
            .toolbar {
                display: none !important;
            }

            body {
                margin: 0;
            }
        }

        /* ── Content wrapper ── */
        .page {
            max-width: 180mm;
            margin: 130px auto 40px;
            padding: 0 10px;
        }

        @media print {
            .page {
                margin: 0;
                max-width: 100%;
                padding: 0;
            }

            #saveTip {
                display: none !important;
            }
        }

        /* ── Document header ── */
        .doc-header {
            text-align: center;
            margin-bottom: 16pt;
            border-bottom: 2px solid #1d2448;
            padding-bottom: 10pt;
        }

        .doc-header .brgy-name {
            font-size: 14pt;
            font-weight: bold;
            color: #1d2448;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .doc-header .brgy-address {
            font-size: 9pt;
            color: #555;
            margin-top: 2pt;
        }

        .doc-header .report-title {
            font-size: 12pt;
            font-weight: bold;
            color: #1d2448;
            margin-top: 8pt;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .doc-header .report-sub {
            font-size: 9pt;
            color: #777;
            margin-top: 2pt;
        }

        /* ── Summary row ── */
        .summary-row {
            display: flex;
            gap: 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 16pt;
        }

        .summary-cell {
            flex: 1;
            text-align: center;
            padding: 8pt 6pt;
            border-right: 1px solid #ccc;
        }

        .summary-cell:last-child {
            border-right: none;
        }

        .summary-cell .s-num {
            font-size: 16pt;
            font-weight: bold;
            color: #1d2448;
        }

        .summary-cell .s-label {
            font-size: 7.5pt;
            color: #666;
            margin-top: 2pt;
        }

        /* ── Section heading ── */
        .section-heading {
            background: #1d2448;
            color: #fff;
            font-size: 10pt;
            font-weight: bold;
            padding: 6pt 10pt;
            margin-bottom: 0;
            letter-spacing: .3px;
        }

        /* ── Demographic info block ── */
        .demo-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16pt;
            border: 1px solid #ccc;
        }

        .demo-table td {
            padding: 6pt 10pt;
            border-bottom: 1px solid #e8e8e8;
            font-size: 10pt;
            vertical-align: top;
        }

        .demo-table tr:last-child td {
            border-bottom: none;
        }

        .demo-table .d-label {
            font-weight: bold;
            color: #1d2448;
            width: 24pt;
        }

        .demo-table .d-key {
            color: #333;
            width: 160pt;
        }

        .demo-table .d-val {
            font-weight: bold;
            color: #1d2448;
            text-align: right;
            white-space: nowrap;
        }

        .rbi-row {
            display: flex;
            gap: 20pt;
            margin-top: 4pt;
            font-size: 9pt;
            color: #555;
        }

        .rbi-row .sem-line {
            border-bottom: 1px solid #333;
            min-width: 60pt;
            display: inline-block;
        }

        .checkbox-row {
            display: flex;
            gap: 16pt;
            font-size: 9.5pt;
        }

        .checkbox-row label {
            display: flex;
            align-items: center;
            gap: 4pt;
        }

        /* ── Data tables ── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16pt;
            font-size: 9.5pt;
        }

        .data-table th {
            background: #1d2448;
            color: #fff;
            padding: 6pt 10pt;
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            border: 1px solid #1d2448;
        }

        .data-table th.left {
            text-align: left;
        }

        .data-table .th-sub {
            background: #2e3a6e;
            color: rgba(255, 255, 255, .85);
            font-size: 8.5pt;
            font-weight: normal;
        }

        .data-table td {
            padding: 5pt 10pt;
            border: 1px solid #ddd;
            text-align: center;
            color: #1a1d2e;
        }

        .data-table td.left {
            text-align: left;
        }

        .data-table td.num-label {
            color: #888;
            font-size: 8.5pt;
            width: 18pt;
        }

        .data-table tbody tr:nth-child(even) {
            background: #f8f9ff;
        }

        .data-table tbody tr:hover {
            background: #eef0fb;
        }

        .data-table .total-row td {
            background: #1d2448;
            color: #fff;
            font-weight: bold;
            border-color: #1d2448;
        }

        .data-table .total-col {
            background: #f0f2ff;
            font-weight: bold;
            color: #1d2448;
        }

        /* ── Footer ── */
        .doc-footer {
            margin-top: 20pt;
            border-top: 1px solid #ccc;
            padding-top: 8pt;
            font-size: 8pt;
            color: #888;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Screen toolbar -->
    <div class="toolbar">
        <button class="tb-btn tb-btn--back" onclick="history.back()">&#8592; Back</button>
        <span>Barangay Bacolod — Reports CY <?= date('Y') ?></span>
        <button class="tb-btn tb-btn--primary" id="saveBtn" onclick="savePdf()">
            &#128438; &nbsp;Save as PDF
        </button>
    </div>

    <!-- Save tip banner (screen only) -->
    <div id="saveTip" style="
        position:fixed;top:52px;left:0;right:0;
        background:#1d2448;
        border-bottom:3px solid #16c79a;
        padding:12px 20px;
        display:flex;align-items:center;gap:14px;
        font-family:Arial,sans-serif;font-size:13px;color:#fff;
        z-index:998;
    ">
        <span style="font-size:22px;flex-shrink:0;">💡</span>
        <div style="flex:1;line-height:1.6;">
            <strong style="color:#16c79a;">How to save as PDF:</strong>
            &nbsp; When the print dialog opens &rarr; click the <strong>Destination</strong> dropdown &rarr; select
            <strong style="background:rgba(255,255,255,.15);padding:1px 8px;border-radius:4px;">Save as PDF</strong>
            &rarr; click <strong>Save</strong>.
            <span style="color:rgba(255,255,255,.55);margin-left:8px;font-size:12px;">
                (Tip: set Layout to <em>Portrait</em> and Margins to <em>None</em> for best results)
            </span>
        </div>
        <button onclick="document.getElementById('saveTip').style.display='none'"
            style="background:rgba(255,255,255,.15);border:none;color:#fff;font-size:14px;cursor:pointer;padding:4px 10px;border-radius:4px;flex-shrink:0;">
            ✕ Dismiss
        </button>
    </div>

    <div class="page">

        <!-- ── Document Header ── -->
        <div class="doc-header">
            <div class="brgy-name">Barangay Bacolod</div>
            <div class="brgy-address">Bato, Camarines Sur, Philippines</div>
            <div class="report-title">Reports &amp; Analytics</div>
            <div class="report-sub">Calendar Year <?= date('Y') ?> &nbsp;&middot;&nbsp; Generated: <?= date('F d, Y') ?></div>
        </div>

        <!-- ── Summary Stats ── -->
        <div class="summary-row">
            <div class="summary-cell">
                <div class="s-num"><?= number_format($totalPop) ?></div>
                <div class="s-label">Total Population</div>
            </div>
            <div class="summary-cell">
                <div class="s-num"><?= number_format($totalMale) ?></div>
                <div class="s-label">Male (Heads)</div>
            </div>
            <div class="summary-cell">
                <div class="s-num"><?= number_format($totalFemale) ?></div>
                <div class="s-label">Female (Heads)</div>
            </div>
            <div class="summary-cell">
                <div class="s-num"><?= number_format($totalHouseholds) ?></div>
                <div class="s-label">Households</div>
            </div>
            <div class="summary-cell">
                <div class="s-num"><?= number_format($totalClearances) ?></div>
                <div class="s-label">Clearances Issued</div>
            </div>
            <div class="summary-cell">
                <div class="s-num"><?= $avgHHSize ?></div>
                <div class="s-label">Avg. HH Size</div>
            </div>
        </div>

        <!-- ── IV. Demographic Information ── -->
        <div class="section-heading">IV. &nbsp;Demographic Information &mdash; CY <?= date('Y') ?></div>
        <table class="demo-table">
            <tr>
                <td class="d-label">A.</td>
                <td class="d-key">No. of Registered Voters:</td>
                <td class="d-val"><?= number_format($registeredVoters) ?></td>
            </tr>
            <tr>
                <td class="d-label">B.</td>
                <td class="d-key">No. of Population:</td>
                <td class="d-val"><?= number_format($totalPop) ?></td>
            </tr>
            <tr>
                <td class="d-label">C.</td>
                <td colspan="2">
                    With RBIs?
                    <span class="checkbox-row" style="display:inline-flex;margin-left:12pt;">
                        <label><input type="checkbox" disabled> Yes</label>
                        <label><input type="checkbox" checked disabled> No</label>
                    </span>
                    <div class="rbi-row" style="margin-top:5pt;">
                        If yes, No. of Inhabitants (RBI):
                        &nbsp; 1<sup>st</sup> Sem.: <span class="sem-line">&nbsp;</span>
                        &nbsp; 2<sup>nd</sup> Sem.: <span class="sem-line">&nbsp;</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="d-label">D.</td>
                <td class="d-key">No. of Households:</td>
                <td class="d-val"><?= number_format($totalHouseholds) ?></td>
            </tr>
            <tr>
                <td class="d-label">E.</td>
                <td class="d-key">No. of Families:</td>
                <td class="d-val"><?= number_format($totalFamilies) ?></td>
            </tr>
            <tr>
                <td class="d-label">F.</td>
                <td class="d-key">Population by Age Bracket:</td>
                <td class="d-val" style="font-weight:normal;color:#555;font-size:8.5pt;">see table below</td>
            </tr>
        </table>

        <!-- ── F. Population by Age Bracket ── -->
        <div class="section-heading">F. &nbsp;Population by Age Bracket</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th class="left" rowspan="2" style="vertical-align:middle;">AGE</th>
                    <th colspan="2">S &nbsp; E &nbsp; X</th>
                    <th rowspan="2" class="total-col" style="vertical-align:middle;background:#2e3a6e;">TOTAL</th>
                </tr>
                <tr>
                    <th class="th-sub">Male</th>
                    <th class="th-sub">Female</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ageBrackets as $i => $row): ?>
                    <tr>
                        <td class="left">
                            <span class="num-label"><?= $i + 1 ?>.</span>
                            <?= esc($row['label']) ?>
                        </td>
                        <td><?= number_format($row['male']) ?></td>
                        <td><?= number_format($row['female']) ?></td>
                        <td class="total-col"><?= number_format($row['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td class="left">TOTAL</td>
                    <td><?= number_format(array_sum(array_column($ageBrackets, 'male'))) ?></td>
                    <td><?= number_format(array_sum(array_column($ageBrackets, 'female'))) ?></td>
                    <td><?= number_format(array_sum(array_column($ageBrackets, 'total'))) ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- ── G. Population by Sector ── -->
        <div class="section-heading">G. &nbsp;Population by Sector</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th class="left">SECTOR</th>
                    <th style="width:80pt;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sectorRows as $row): ?>
                    <tr>
                        <td class="left"><?= esc($row['label']) ?></td>
                        <td><?= number_format($row['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- ── Document Footer ── -->
        <div class="doc-footer">
            Barangay Bacolod, Bato, Camarines Sur &nbsp;&middot;&nbsp;
            Prepared by: Barangay Information System (BIS) &nbsp;&middot;&nbsp;
            <?= date('F d, Y \a\t h:i A') ?>
        </div>

    </div>

        <script>
        function savePdf() {
            const btn = document.getElementById('saveBtn');
            btn.disabled = true;
            btn.innerHTML = 'Opening&hellip;';
            document.getElementById('saveTip').style.display = 'flex';
            setTimeout(function() {
                window.print();
                btn.disabled = false;
                btn.innerHTML = '&#128438; &nbsp;Save as PDF';
            }, 400);
        }
        // Do NOT auto-print — let user read the tip first and click the button
    </script>
</body>

</html>
