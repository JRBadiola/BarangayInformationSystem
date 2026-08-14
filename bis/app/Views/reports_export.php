<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Barangay Report — CY <?= date('Y') ?></title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4 portrait;
            margin: 15mm 14mm;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #111;
            background: #fff;
        }

        /* ── Header ── */
        .rpt-header {
            text-align: center;
            border-bottom: 2px solid #1d2448;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        .rpt-header h1 {
            font-size: 15px;
            font-weight: 700;
            color: #1d2448;
            letter-spacing: .5px;
            margin-bottom: 2px;
        }

        .rpt-header p {
            font-size: 11px;
            color: #444;
            margin: 1px 0;
        }

        /* ── Summary grid ── */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 16px;
        }

        .summary-cell {
            border: 1px solid #d0d5e8;
            border-radius: 6px;
            padding: 8px 10px;
        }

        .summary-cell .num {
            font-size: 18px;
            font-weight: 700;
            color: #1d2448;
            line-height: 1.1;
        }

        .summary-cell .label {
            font-size: 10px;
            color: #555;
            margin-top: 1px;
        }

        /* ── Section cards ── */
        .section {
            border: 1px solid #ccc;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 14px;
            page-break-inside: avoid;
        }

        .section-header {
            background: #1d2448;
            color: #fff;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        /* ── Demographic rows ── */
        .demo-body {
            padding: 8px 12px;
        }

        .demo-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
            padding: 6px 0;
            border-bottom: 1px solid #f0f2f8;
            font-size: 11px;
        }

        .demo-row:last-child {
            border-bottom: none;
        }

        .demo-lbl {
            font-weight: 700;
            color: #1d2448;
            min-width: 22px;
            flex-shrink: 0;
        }

        .demo-txt {
            flex: 1;
            color: #333;
        }

        .demo-val {
            font-weight: 700;
            background: #eef0fb;
            padding: 1px 8px;
            border-radius: 20px;
            min-width: 44px;
            text-align: center;
        }

        /* ── Tables ── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        thead tr {
            background: #f0f2f8;
        }

        thead th {
            padding: 7px 10px;
            font-size: 10px;
            font-weight: 700;
            color: #555;
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 1.5px solid #d0d5e8;
            text-align: center;
        }

        thead th:first-child {
            text-align: left;
        }

        .th-group {
            background: #eef0fb;
        }

        .th-group th {
            font-size: 9.5px;
            color: #5b6fd6;
            padding: 5px 10px;
            border-bottom: 1px solid #d8dce8;
        }

        tbody tr {
            border-bottom: 1px solid #f0f2f8;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 7px 10px;
            text-align: center;
            color: #1a1d2e;
        }

        td:first-child {
            text-align: left;
        }

        td.tot,
        th.tot {
            font-weight: 700;
            color: #1d2448;
            background: #f5f7ff;
        }

        tfoot tr {
            background: #1d2448;
        }

        tfoot td {
            color: #fff;
            font-weight: 700;
            padding: 7px 10px;
            text-align: center;
        }

        tfoot td:first-child {
            text-align: left;
        }

        /* ── Two-col layout ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        .two-col>div:last-child {
            border-left: 1px solid #f0f2f8;
        }

        .sub-header {
            padding: 7px 10px 5px;
            font-size: 10px;
            font-weight: 700;
            color: #5b6fd6;
            text-transform: uppercase;
            letter-spacing: .4px;
            background: #eef0fb;
            border-bottom: 1px solid #d8dce8;
        }

        /* ── Row counter ── */
        span.n {
            display: inline-block;
            width: 18px;
            color: #999;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="rpt-header">
        <h1>Barangay Bacolod — Demographic Report</h1>
        <p>Municipality of Bato, Province of Camarines Sur &nbsp;|&nbsp; Calendar Year <?= date('Y') ?></p>
        <p>Generated: <?= date('F d, Y \a\t h:i A') ?></p>
    </div>

    <!-- Summary grid -->
    <?php
    $totalPop         = $totalPop         ?? 0;
    $totalMale        = $totalMale        ?? 0;
    $totalFemale      = $totalFemale      ?? 0;
    $totalHouseholds  = $totalHouseholds  ?? 0;
    $totalClearances  = $totalClearances  ?? 0;
    $avgHHSize        = $avgHHSize        ?? 0;
    $ageBrackets      = $ageBrackets      ?? [];
    $sectorRows       = $sectorRows       ?? [];
    $waterRows        = $waterRows        ?? [];
    $sanitationRows   = $sanitationRows   ?? [];
    $eduRows          = $eduRows          ?? [];
    $registeredVoters = $registeredVoters ?? 0;
    $totalFamilies    = $totalFamilies    ?? 0;
    ?>

    <!-- IV. Demographic Information -->
    <div class="section">
        <div class="section-header">IV. Demographic Information</div>
        <div class="demo-body">
            <div class="demo-row"><span class="demo-lbl">A.</span><span class="demo-txt">No. of Registered Voters:</span><span class="demo-val"><?= number_format($registeredVoters) ?></span></div>
            <div class="demo-row"><span class="demo-lbl">B.</span><span class="demo-txt">No. of Population:</span><span class="demo-val"><?= number_format($totalPop) ?></span></div>
            <div class="demo-row"><span class="demo-lbl">C.</span><span class="demo-txt">With RBIs? &nbsp; ☐ Yes &nbsp; ☑ No</span></div>
            <div class="demo-row"><span class="demo-lbl">D.</span><span class="demo-txt">No. of Households:</span><span class="demo-val"><?= number_format($totalHouseholds) ?></span></div>
            <div class="demo-row"><span class="demo-lbl">E.</span><span class="demo-txt">No. of Families:</span><span class="demo-val"><?= number_format($totalFamilies) ?></span></div>
            <div class="demo-row"><span class="demo-lbl">F.</span><span class="demo-txt">Population by Age Bracket — see table below</span></div>
        </div>
    </div>

    <!-- F. Population by Age Bracket -->
    <div class="section">
        <div class="section-header">F. Population by Age Bracket</div>
        <table>
            <thead>
                <tr>
                    <th rowspan="2" style="text-align:left;vertical-align:middle;">AGE GROUP</th>
                    <th colspan="2">S E X</th>
                    <th rowspan="2" class="tot" style="vertical-align:middle;">TOTAL</th>
                </tr>
                <tr class="th-group">
                    <th>Male</th>
                    <th>Female</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ageBrackets as $i => $row): ?>
                    <tr>
                        <td><span class="n"><?= $i + 1 ?>.</span><?= esc($row['label']) ?></td>
                        <td><?= number_format($row['male']) ?></td>
                        <td><?= number_format($row['female']) ?></td>
                        <td class="tot"><?= number_format($row['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>TOTAL</td>
                    <td><?= number_format(array_sum(array_column($ageBrackets, 'male'))) ?></td>
                    <td><?= number_format(array_sum(array_column($ageBrackets, 'female'))) ?></td>
                    <td><?= number_format(array_sum(array_column($ageBrackets, 'total'))) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- G. Population by Sector -->
    <div class="section">
        <div class="section-header">G. Population by Sector</div>
        <table>
            <thead>
                <tr>
                    <th style="text-align:left;">SECTOR</th>
                    <th class="tot">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sectorRows as $row): ?>
                    <tr>
                        <td><?= esc($row['label']) ?></td>
                        <td class="tot"><?= number_format($row['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- H. Water & Sanitation -->
    <!-- <div class="section">
        <div class="section-header">H. Water Source &amp; Sanitation</div>
        <div class="two-col">
            <div>
                <div class="sub-header">Water Source Level</div>
                <table>
                    <tbody>
                        <?php foreach ($waterRows as $row): ?>
                            <tr>
                                <td><?= esc($row['label']) ?></td>
                                <td class="tot"><?= number_format($row['total']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div>
                <div class="sub-header">Sanitation</div>
                <table>
                    <tbody>
                        <?php foreach ($sanitationRows as $row): ?>
                            <tr>
                                <td><?= esc($row['label']) ?></td>
                                <td class="tot"><?= number_format($row['total']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>-->

    <!-- I. Educational Attainment -->
    <!-- <?php if (!empty($eduRows)): ?>
        <div class="section">
            <div class="section-header">I. Educational Attainment</div>
            <table>
                <thead>
                    <tr>
                        <th style="text-align:left;">LEVEL</th>
                        <th class="tot">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eduRows as $row): ?>
                        <tr>
                            <td><?= esc($row['label']) ?></td>
                            <td class="tot"><?= number_format($row['total']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>TOTAL</td>
                        <td><?= number_format(array_sum(array_column($eduRows, 'total'))) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php endif; ?>-->

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>