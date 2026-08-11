<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Census Export<?= $zone ? ' — ' . esc($zone) : '' ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 7.5pt;
            color: #000;
            background: #f0f2f8;
        }

        /* ── Toolbar (screen only) ── */
        #toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 52px;
            background: #1d2448;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 20px;
            z-index: 9999;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .25);
        }

        #toolbar span {
            color: rgba(255, 255, 255, .75);
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
            display: flex;
            align-items: center;
            gap: 7px;
            transition: opacity .2s;
        }

        .tb-btn:hover {
            opacity: .88;
        }

        .tb-btn--primary {
            background: #16c79a;
            color: #fff;
        }

        .tb-btn--back {
            background: rgba(255, 255, 255, .15);
            color: #fff;
        }

        #progress-wrap {
            display: none;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-size: 12px;
            font-family: Arial, sans-serif;
        }

        #progress-bar-track {
            width: 180px;
            height: 6px;
            background: rgba(255, 255, 255, .2);
            border-radius: 4px;
            overflow: hidden;
        }

        #progress-bar-fill {
            height: 100%;
            background: #16c79a;
            border-radius: 4px;
            width: 0%;
            transition: width .3s;
        }

        /* ── Content area ── */
        #content-area {
            margin-top: 60px;
            padding: 16px;
        }

        /* ── Zone page ── */
        .zone-page {
            background: #fff;
            width: 277mm;
            /* A4 landscape usable width */
            min-height: 185mm;
            margin: 0 auto 24px;
            padding: 8mm 6mm;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .12);
        }

        /* ── Zone title ── */
        .zone-title {
            text-align: center;
            font-size: 20pt;
            font-weight: bold;
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 5mm;
        }

        /* ── Meta header ── */
        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 3mm;
            font-size: 7pt;
        }

        .meta-left {
            line-height: 1.7;
        }

        .meta-ul {
            border-bottom: 1px solid #000;
            min-width: 130px;
            display: inline-block;
        }

        .meta-right {
            text-align: right;
            font-size: 6.5pt;
        }

        /* ── Census table ── */
        table.ct {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.ct th,
        table.ct td {
            border: 1px solid #555;
            padding: 1.5px 2px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        table.ct thead th {
            background: #d9d9d9;
            font-size: 5.5pt;
            font-weight: bold;
            text-align: center;
            line-height: 1.2;
        }

        table.ct tbody td {
            font-size: 6.5pt;
            line-height: 1.3;
        }

        tr.row-head td {
            background: #f2f2f2;
            font-weight: bold;
        }

        tr.hh-spacer td {
            border: none;
            height: 3px;
            background: #fff;
            padding: 0;
        }

        /* Column widths */
        .c-name {
            width: 15%;
        }

        .c-rel {
            width: 7%;
        }

        .c-bday {
            width: 7%;
        }

        .c-age {
            width: 3%;
        }

        .c-sex {
            width: 3%;
        }

        .c-occ {
            width: 10%;
        }

        .c-inc {
            width: 5%;
        }

        .c-rel2 {
            width: 5%;
        }

        .c-educ {
            width: 8%;
        }

        .c-phil {
            width: 8%;
        }

        .c-fp {
            width: 4%;
        }

        .c-unmet {
            width: 4%;
        }

        .c-pwd {
            width: 5%;
        }

        .c-morb {
            width: 5%;
        }

        .c-water {
            width: 5%;
        }

        .c-sanit {
            width: 5%;
        }
    </style>
</head>

<body>

    <!-- Toolbar -->
    <div id="toolbar">
        <button class="tb-btn tb-btn--back" onclick="history.back()">&#8592; Back</button>
        <span>Census Records Export<?= $zone ? ' — ' . esc($zone) : ' — All Zones' ?></span>
        <div id="progress-wrap">
            <div id="progress-bar-track">
                <div id="progress-bar-fill"></div>
            </div>
            <span id="progress-label">Generating PDF…</span>
        </div>
        <button class="tb-btn tb-btn--primary" id="downloadBtn" onclick="generatePdf()">
            &#8595; Download PDF
        </button>
    </div>

    <!-- Printable content -->
    <div id="content-area">
        <?php foreach ($byZone as $zoneName => $households):
            $totalActual = array_sum(array_map(fn($h) => 1 + count($h['members']), $households));
        ?>
            <div class="zone-page" id="zone-<?= esc(preg_replace('/\s+/', '-', strtolower($zoneName))) ?>">

                <div class="zone-title"><?= strtoupper(esc($zoneName)) ?></div>

                <div class="meta-row">
                    <div class="meta-left">
                        <div>BATO &nbsp; <span class="meta-ul">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                        <div>BACOLOD</div>
                    </div>
                    <div style="text-align:center;font-size:7pt;">
                        <div>Total Projected Population: <span class="meta-ul">&nbsp;<?= count($households) ?>&nbsp;</span></div>
                        <div style="margin-top:2px;">Total Actual Population: <span class="meta-ul">&nbsp;<?= $totalActual ?>&nbsp;</span></div>
                    </div>
                    <div class="meta-right">
                        Date Accomplished: <span class="meta-ul">&nbsp;<?= esc($dateAccomplished) ?>&nbsp;</span>
                    </div>
                </div>

                <?php if (! empty($activeFilters ?? [])): ?>
                    <div style="font-size:6.5pt;color:#555;margin-bottom:3mm;padding:4px 8px;background:#f5f5f5;border-radius:3px;border:1px solid #ddd;">
                        <strong>Filters:</strong> <?= esc(implode(' &middot; ', $activeFilters)) ?>
                    </div>
                <?php endif; ?>

                <table class="ct">
                    <thead>
                        <tr>
                            <th class="c-name">Name of Household Members<br>(Surname, First Name Middle Name)</th>
                            <th class="c-rel">Relationship to<br>Household Head</th>
                            <th class="c-bday">Birthday<br>(mm/dd/yy)</th>
                            <th class="c-age">Age</th>
                            <th class="c-sex">Sex<br>(M/F)</th>
                            <th class="c-occ">Occupation / Source<br>of Income (Individual)</th>
                            <th class="c-inc">Avg Monthly<br>Income (₱)</th>
                            <th class="c-rel2">Religion<br>(specify)</th>
                            <th class="c-educ">Educational<br>Attainment</th>
                            <th class="c-phil">PhilHealth<br>Number</th>
                            <th class="c-fp">FP User<br>(Yes/No)</th>
                            <th class="c-unmet">Unmet<br>Needs<br>(Yes/No)</th>
                            <th class="c-pwd">PWD<br>(specify)</th>
                            <th class="c-morb">Morbidity<br>(specify)</th>
                            <th class="c-water">Access to<br>Safe Water<br>(I, II, III)</th>
                            <th class="c-sanit">Sanitation<br>Facility</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($households as $hh):
                            $headName = esc($hh['last_name']) . ', ' . esc($hh['first_name'])
                                . (! empty($hh['middle_name']) ? ' ' . esc($hh['middle_name']) : '')
                                . (! empty($hh['suffix'])      ? ' ' . esc($hh['suffix'])      : '');
                            $headDob    = ! empty($hh['date_of_birth']) ? date('m-d-y', strtotime($hh['date_of_birth'])) : '';
                            $headAge    = ! empty($hh['date_of_birth']) ? (int) date_diff(date_create($hh['date_of_birth']), date_create('today'))->y : '';
                            $headSex    = strtolower($hh['gender'] ?? '') === 'female' ? 'F' : 'M';
                            $headIncome = ($hh['monthly_income'] ?? 0) > 0 ? number_format((float)$hh['monthly_income'], 0) : '';
                        ?>
                            <tr class="row-head">
                                <td><?= $headName ?></td>
                                <td style="text-align:center;">Head</td>
                                <td style="text-align:center;"><?= $headDob ?></td>
                                <td style="text-align:center;"><?= $headAge ?></td>
                                <td style="text-align:center;"><?= $headSex ?></td>
                                <td><?= esc($hh['occupation'] ?? '') ?></td>
                                <td style="text-align:right;"><?= $headIncome ?></td>
                                <td style="text-align:center;"><?= esc($hh['religion'] ?? '') ?></td>
                                <td><?= esc($hh['educational_attainment'] ?? '') ?></td>
                                <td style="text-align:center;"><?= esc($hh['philhealth_no'] ?? '') ?></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:center;"><?= $hh['is_pwd'] ? 'Yes' : '' ?></td>
                                <td></td>
                                <td style="text-align:center;"><?= esc($hh['water_source_level'] ?? '') ?></td>
                                <td style="text-align:center;"><?= esc($hh['sanitation_basic'] ?? '') ?></td>
                            </tr>
                            <?php foreach ($hh['members'] as $m):
                                $mName = esc($m['last_name']) . ', ' . esc($m['first_name'])
                                    . (! empty($m['middle_name']) ? ' ' . esc($m['middle_name']) : '')
                                    . (! empty($m['suffix'])      ? ' ' . esc($m['suffix'])      : '');
                                $mDob    = ! empty($m['date_of_birth']) ? date('m-d-y', strtotime($m['date_of_birth'])) : '';
                                $mAge    = ! empty($m['date_of_birth']) ? (int) date_diff(date_create($m['date_of_birth']), date_create('today'))->y : '';
                                $mIncome = ($m['monthly_income'] ?? 0) > 0 ? number_format((float)$m['monthly_income'], 0) : '';
                            ?>
                                <tr>
                                    <td><?= $mName ?></td>
                                    <td style="text-align:center;"><?= esc(ucfirst($m['relationship'])) ?></td>
                                    <td style="text-align:center;"><?= $mDob ?></td>
                                    <td style="text-align:center;"><?= $mAge ?></td>
                                    <td style="text-align:center;"></td>
                                    <td><?= esc($m['occupation'] ?? '') ?></td>
                                    <td style="text-align:right;"><?= $mIncome ?></td>
                                    <td></td>
                                    <td><?= esc($m['educational_attainment'] ?? '') ?></td>
                                    <td style="text-align:center;"><?= esc($m['philhealth_no'] ?? '') ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="hh-spacer">
                                <td colspan="16"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div><!-- end zone-page -->
        <?php endforeach; ?>
    </div><!-- end content-area -->

    <script>
        async function generatePdf() {
            const btn = document.getElementById('downloadBtn');
            const progWrap = document.getElementById('progress-wrap');
            const progFill = document.getElementById('progress-bar-fill');
            const progLbl = document.getElementById('progress-label');

            btn.disabled = true;
            btn.textContent = 'Generating…';
            progWrap.style.display = 'flex';

            const {
                jsPDF
            } = window.jspdf;
            // A4 landscape: 297mm × 210mm
            const pdf = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });
            const pages = document.querySelectorAll('.zone-page');
            const W = 297; // page width mm
            const H = 210; // page height mm
            const margin = 6; // mm each side

            for (let i = 0; i < pages.length; i++) {
                progFill.style.width = Math.round(((i) / pages.length) * 90) + '%';
                progLbl.textContent = `Rendering zone ${i + 1} of ${pages.length}…`;

                const canvas = await html2canvas(pages[i], {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: '#ffffff',
                    logging: false,
                });

                const imgData = canvas.toDataURL('image/jpeg', 0.92);
                const imgW = W - margin * 2;
                const imgH = (canvas.height * imgW) / canvas.width;

                if (i > 0) pdf.addPage('a4', 'landscape');

                // If content taller than page, scale down to fit
                const finalH = Math.min(imgH, H - margin * 2);
                pdf.addImage(imgData, 'JPEG', margin, margin, imgW, finalH);
            }

            progFill.style.width = '100%';
            progLbl.textContent = 'Saving…';

            const zone = <?= json_encode($zone ?: 'all-zones') ?>;
            const filename = 'census-' + zone.toLowerCase().replace(/\s+/g, '-') + '-<?= date('Y-m-d') ?>.pdf';
            pdf.save(filename);

            btn.disabled = false;
            btn.textContent = '↓ Download PDF';
            progWrap.style.display = 'none';
            progFill.style.width = '0%';
        }
    </script>
</body>

</html>