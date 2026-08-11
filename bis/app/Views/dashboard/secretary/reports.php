<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Bacolod BIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        .rpt-wrap {
            max-width: 860px;
        }

        /* ── Summary stats ── */
        .rpt-summary {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 14px;
            margin-bottom: 28px;
        }

        .rpt-stat {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(29, 36, 72, .06);
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .rpt-stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .rpt-stat-num {
            font-size: 20px;
            font-weight: 700;
            color: #1a1d2e;
            line-height: 1.1;
        }

        .rpt-stat-label {
            font-size: 11px;
            color: #9aa0b4;
            font-weight: 500;
            margin-top: 2px;
        }

        /* ── Toolbar ── */
        .rpt-toolbar {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-bottom: 16px;
        }

        /* ── Demographic info block ── */
        .demo-block {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29, 36, 72, .06);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .demo-block-header {
            background: #1d2448;
            padding: 13px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .demo-block-header h4 {
            color: #fff;
            font-size: 13.5px;
            font-weight: 600;
            margin: 0;
        }

        .demo-block-header i {
            color: rgba(255, 255, 255, .7);
            font-size: 14px;
        }

        .demo-block-body {
            padding: 20px 24px;
        }

        .demo-row {
            display: flex;
            align-items: baseline;
            gap: 10px;
            padding: 9px 0;
            border-bottom: 1px solid #f0f2f8;
            font-size: 13.5px;
            color: #1a1d2e;
        }

        .demo-row:last-child {
            border-bottom: none;
        }

        .demo-label {
            font-weight: 600;
            color: #1d2448;
            min-width: 28px;
            flex-shrink: 0;
        }

        .demo-text {
            flex: 1;
            color: #4a5068;
        }

        .demo-val {
            font-weight: 700;
            color: #1d2448;
            background: #eef0fb;
            padding: 2px 12px;
            border-radius: 100px;
            font-size: 13px;
            min-width: 60px;
            text-align: center;
        }

        .demo-rbi-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 4px;
            font-size: 13px;
            color: #4a5068;
        }

        .demo-rbi-row label {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: default;
        }

        .demo-rbi-row input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: #1d2448;
            pointer-events: none;
        }

        .demo-sem-row {
            display: flex;
            gap: 32px;
            margin-top: 4px;
            font-size: 13px;
            color: #4a5068;
        }

        .demo-sem-row span {
            border-bottom: 1px solid #1d2448;
            min-width: 80px;
            display: inline-block;
        }

        /* ── Section card ── */
        .rpt-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29, 36, 72, .06);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .rpt-card-header {
            background: #1d2448;
            padding: 13px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .rpt-card-header h4 {
            color: #fff;
            font-size: 13.5px;
            font-weight: 600;
            margin: 0;
            letter-spacing: .3px;
        }

        .rpt-card-header i {
            color: rgba(255, 255, 255, .7);
            font-size: 14px;
        }

        /* ── Tables ── */
        .rpt-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .rpt-table thead tr {
            background: #f0f2f8;
        }

        .rpt-table thead th {
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 2px solid #e2e5ef;
            text-align: center;
        }

        .rpt-table thead th:first-child {
            text-align: left;
        }

        .rpt-table .th-group {
            background: #eef0fb;
        }

        .rpt-table .th-group th {
            font-size: 10.5px;
            color: #5b6fd6;
            padding: 6px 16px;
            border-bottom: 1px solid #d8dce8;
        }

        .rpt-table tbody tr {
            border-bottom: 1px solid #f0f2f8;
            transition: background .15s;
        }

        .rpt-table tbody tr:last-child {
            border-bottom: none;
        }

        .rpt-table tbody tr:hover {
            background: #f8f9ff;
        }

        .rpt-table td {
            padding: 10px 16px;
            color: #1a1d2e;
            text-align: center;
        }

        .rpt-table td:first-child {
            text-align: left;
            font-weight: 500;
            color: #2d3250;
        }

        .rpt-table td:first-child span.rpt-num {
            display: inline-block;
            width: 20px;
            color: #9aa0b4;
            font-weight: 400;
            font-size: 12px;
        }

        .rpt-table td.rpt-total,
        .rpt-table th.rpt-total {
            font-weight: 700;
            color: #1d2448;
            background: #f5f7ff;
        }

        .rpt-table tfoot tr {
            background: #1d2448;
        }

        .rpt-table tfoot td {
            color: #fff;
            font-weight: 700;
            font-size: 12.5px;
            padding: 10px 16px;
            text-align: center;
        }

        .rpt-table tfoot td:first-child {
            text-align: left;
            color: #fff;
        }

        /* ── Progress bar for PDF generation ── */
        #pdfProgress {
            display: none;
            align-items: center;
            gap: 10px;
            font-size: 12.5px;
            color: #1d2448;
        }

        #pdfProgressBar {
            width: 140px;
            height: 5px;
            background: #e2e5ef;
            border-radius: 4px;
            overflow: hidden;
        }

        #pdfProgressFill {
            height: 100%;
            background: #1d2448;
            border-radius: 4px;
            width: 0%;
            transition: width .3s;
        }

        /* ── Print styles ── */
        @media print {

            .db-sidebar,
            .db-topbar,
            .rpt-toolbar,
            .db-nav-item {
                display: none !important;
            }

            .db-main {
                margin: 0 !important;
            }

            .rpt-card,
            .demo-block {
                box-shadow: none;
                border: 1px solid #ccc;
            }

            body {
                background: #fff;
            }

            .rpt-wrap {
                max-width: 100%;
            }
        }
    </style>
</head>

<body class="db-body">
    <?php
    $role      = 'secretary';
    $active    = 'reports';
    $pageTitle = 'Reports & Analytics';
    include(APPPATH . 'Views/dashboard/sidebar.php');

    $totalPop         = $totalPop         ?? 0;
    $totalMale        = $totalMale        ?? 0;
    $totalFemale      = $totalFemale      ?? 0;
    $totalHouseholds  = $totalHouseholds  ?? 0;
    $totalClearances  = $totalClearances  ?? 0;
    $avgHHSize        = $avgHHSize        ?? 0;
    $ageBrackets      = $ageBrackets      ?? [];
    $sectorRows       = $sectorRows       ?? [];
    $registeredVoters = $registeredVoters ?? 0;
    $totalFamilies    = $totalFamilies    ?? 0;
    $currentYear      = date('Y');
    ?>
    <div class="db-main">
        <?php include(APPPATH . 'Views/dashboard/topbar.php'); ?>
        <div class="db-content">

            <!-- ── Summary stats ── -->
            <div class="rpt-summary">
                <div class="rpt-stat">
                    <div class="rpt-stat-icon" style="background:rgba(91,111,214,.12);color:#5b6fd6;"><i class="fas fa-users"></i></div>
                    <div>
                        <div class="rpt-stat-num"><?= number_format($totalPop) ?></div>
                        <div class="rpt-stat-label">Total Population</div>
                    </div>
                </div>
                <div class="rpt-stat">
                    <div class="rpt-stat-icon" style="background:rgba(91,111,214,.12);color:#5b6fd6;"><i class="fas fa-male"></i></div>
                    <div>
                        <div class="rpt-stat-num"><?= number_format($totalMale) ?></div>
                        <div class="rpt-stat-label">Male (Heads)</div>
                    </div>
                </div>
                <div class="rpt-stat">
                    <div class="rpt-stat-icon" style="background:rgba(220,53,69,.12);color:#dc3545;"><i class="fas fa-female"></i></div>
                    <div>
                        <div class="rpt-stat-num"><?= number_format($totalFemale) ?></div>
                        <div class="rpt-stat-label">Female (Heads)</div>
                    </div>
                </div>
                <div class="rpt-stat">
                    <div class="rpt-stat-icon" style="background:rgba(255,193,7,.12);color:#ffc107;"><i class="fas fa-home"></i></div>
                    <div>
                        <div class="rpt-stat-num"><?= number_format($totalHouseholds) ?></div>
                        <div class="rpt-stat-label">Households</div>
                    </div>
                </div>
                <div class="rpt-stat">
                    <div class="rpt-stat-icon" style="background:rgba(22,199,154,.12);color:#16c79a;"><i class="fas fa-file-alt"></i></div>
                    <div>
                        <div class="rpt-stat-num"><?= number_format($totalClearances) ?></div>
                        <div class="rpt-stat-label">Clearances Issued</div>
                    </div>
                </div>
                <div class="rpt-stat">
                    <div class="rpt-stat-icon" style="background:rgba(29,36,72,.08);color:#1d2448;"><i class="fas fa-chart-bar"></i></div>
                    <div>
                        <div class="rpt-stat-num"><?= $avgHHSize ?></div>
                        <div class="rpt-stat-label">Avg. Household Size</div>
                    </div>
                </div>
            </div>

            <div class="rpt-wrap" id="reportContent">

                <!-- ── Toolbar ── -->
                <div class="rpt-toolbar" id="rptToolbar">
                    <button class="db-btn db-btn--outline" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="db-btn db-btn--primary" onclick="window.open('/secretary/reports/export','_blank')">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </button>
                </div>

                <!-- ── IV. Demographic Information ── -->
                <div class="demo-block">
                    <div class="demo-block-header">
                        <i class="fas fa-info-circle"></i>
                        <h4>IV. &nbsp;Demographic Information &mdash; CY <?= $currentYear ?></h4>
                    </div>
                    <div class="demo-block-body">

                        <div class="demo-row">
                            <span class="demo-label">A.</span>
                            <span class="demo-text">No. of Registered Voters:</span>
                            <span class="demo-val"><?= number_format($registeredVoters) ?></span>
                        </div>

                        <div class="demo-row">
                            <span class="demo-label">B.</span>
                            <span class="demo-text">No. of Population:</span>
                            <span class="demo-val"><?= number_format($totalPop) ?></span>
                        </div>

                        <div class="demo-row" style="flex-direction:column;align-items:flex-start;gap:6px;">
                            <div style="display:flex;align-items:baseline;gap:10px;width:100%;">
                                <span class="demo-label">C.</span>
                                <span class="demo-text">With RBIs?</span>
                                <div class="demo-rbi-row">
                                    <label><input type="checkbox" disabled> Yes</label>
                                    <label><input type="checkbox" checked disabled> No</label>
                                </div>
                            </div>
                            <div style="padding-left:38px;font-size:12.5px;color:#9aa0b4;">
                                If yes, No. of Inhabitants (RBI):
                                <div class="demo-sem-row" style="margin-top:4px;">
                                    <span>1<sup>st</sup> Sem.: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <span>2<sup>nd</sup> Sem.: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </div>
                            </div>
                        </div>

                        <div class="demo-row">
                            <span class="demo-label">D.</span>
                            <span class="demo-text">No. of Households:</span>
                            <span class="demo-val"><?= number_format($totalHouseholds) ?></span>
                        </div>

                        <div class="demo-row">
                            <span class="demo-label">E.</span>
                            <span class="demo-text">No. of Families:</span>
                            <span class="demo-val"><?= number_format($totalFamilies) ?></span>
                        </div>

                        <div class="demo-row" style="border-bottom:none;">
                            <span class="demo-label">F.</span>
                            <span class="demo-text">Population by Age Bracket</span>
                            <span style="font-size:11.5px;color:#9aa0b4;font-style:italic;">(see table below)</span>
                        </div>

                    </div>
                </div>

                <!-- ── F. Population by Age Bracket ── -->
                <div class="rpt-card">
                    <div class="rpt-card-header">
                        <i class="fas fa-table"></i>
                        <h4>F. &nbsp;Population by Age Bracket</h4>
                    </div>
                    <table class="rpt-table">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align:left;vertical-align:middle;">AGE</th>
                                <th colspan="2">S E X</th>
                                <th rowspan="2" class="rpt-total" style="vertical-align:middle;">TOTAL</th>
                            </tr>
                            <tr class="th-group">
                                <th>Male</th>
                                <th>Female</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ageBrackets as $i => $row): ?>
                                <tr>
                                    <td><span class="rpt-num"><?= $i + 1 ?>.</span><?= esc($row['label']) ?></td>
                                    <td><?= number_format($row['male']) ?></td>
                                    <td><?= number_format($row['female']) ?></td>
                                    <td class="rpt-total"><?= number_format($row['total']) ?></td>
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

                <!-- ── G. Population by Sector ── -->
                <div class="rpt-card">
                    <div class="rpt-card-header">
                        <i class="fas fa-table"></i>
                        <h4>G. &nbsp;Population by Sector</h4>
                    </div>
                    <table class="rpt-table">
                        <thead>
                            <tr>
                                <th style="text-align:left;">SECTOR</th>
                                <th class="rpt-total">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sectorRows as $row): ?>
                                <tr>
                                    <td><?= esc($row['label']) ?></td>
                                    <td class="rpt-total"><?= number_format($row['total']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div><!-- end rpt-wrap -->
        </div>
    </div>

    <script>
        document.querySelectorAll('.db-nav-item').forEach(i =>
            i.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'))
        );
    </script>
</body>

</html>