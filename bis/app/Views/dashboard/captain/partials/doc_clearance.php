<div class="bc-wrap">
    <div class="bc-page">
        <div class="bc-top-box">
            <div class="bc-header-row">
                <img src="/bacolod.png" class="bc-seal" alt="Seal">
                <div class="bc-header-center">
                    <p>Republic of the Philippines</p>
                    <p>Region V &nbsp;·&nbsp; Province of Camarines Sur</p>
                    <p>Municipality of Bato</p>
                    <p><strong>BARANGAY BACOLOD</strong></p>
                    <p class="bc-oOo">-oOo-</p>
                    <div class="bc-office-bar"><strong>OFFICE OF THE PUNONG BARANGAY</strong></div>
                </div>
                <img src="/bacolod.png" class="bc-seal" alt="Seal">
            </div>
        </div>
        <div class="bc-body-box">
            <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>
            <div class="bc-doc-title">BARANGAY CLEARANCE</div>
            <div class="bc-body-text">
                <p><strong>TO WHOM IT MAY CONCERN,</strong></p>
                <p class="bc-indent">This is to certify that <span class="bc-line" style="width:220px;">&nbsp;<?= esc($r['resident']) ?>&nbsp;</span>, <?= esc($r['age']) ?> years of age, <?= esc($r['civil_status']) ?>, and a bonafide resident of <strong><?= esc($r['address']) ?></strong>.</p>
                <p class="bc-indent">He/She possesses good moral character, is trustworthy, a law-abiding Filipino citizen, and cooperative to all undertakings for the progress of the community.</p>
                <p class="bc-indent">This Barangay Clearance is being issued upon the request of the above-named person for <strong><?= esc($r['purpose']) ?></strong> and for whatever legal purposes it may serve.</p>
                <p class="bc-indent">Given this <span class="bc-line" style="width:40px;">&nbsp;</span> day of <span class="bc-line" style="width:120px;">&nbsp;</span> at <strong>Barangay Bacolod, Bato, Camarines Sur, Philippines.</strong></p>
            </div>
            <div class="bc-sig-section">
                <div class="bc-sig-left">
                    <div class="bc-sig-line"></div>
                    <div class="bc-sig-sub">(Signature of Applicant)</div>
                </div>
                <div class="bc-sig-right">
                    <p class="bc-approved-by">Approved by:</p>
                    <p class="bc-captain-name"><?= esc($captainName ?? 'PUNONG BARANGAY') ?></p>
                    <p class="bc-captain-title">Punong Barangay</p>
                </div>
            </div>
            <div class="bc-footer-info">
                <p>OR No.&nbsp;&nbsp; : <?= esc($r['or_number'] ?: '_______________') ?></p>
                <p>Amount&nbsp;: <?= esc($r['fee']) ?></p>
                <div class="bc-photo-row">
                    <div class="bc-photo-box"></div>
                    <div class="bc-photo-box"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .bc-wrap {
        font-family: 'Cambria', serif;
        font-size: 13px;
        color: #111;
        display: flex;
        justify-content: center;
        padding: 8px 0;
    }

    .bc-page {
        width: 680px;
        background: #fff;
        border: 2px solid #3a6abf;
        display: flex;
        flex-direction: column;
    }

    .bc-top-box {
        border-bottom: 2px solid #3a6abf;
        padding: 18px 32px 0;
    }

    .bc-header-row {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        gap: 24px;
        padding-bottom: 12px;
    }

    .bc-seal {
        width: 72px;
        height: 72px;
        object-fit: contain;
        border-radius: 50%;
    }

    .bc-header-center {
        text-align: center;
        font-size: 12px;
        line-height: 1.6;
    }

    .bc-header-center p {
        margin: 0;
    }

    .bc-oOo {
        font-style: italic;
        color: #555;
    }

    .bc-office-bar {
        font-size: 14px;
        font-weight: 700;
        padding: 8px 0 10px;
        margin-top: 8px;
    }

    .bc-body-box {
        flex: 1;
        padding: 20px 36px 28px;
        position: relative;
        overflow: hidden;
    }

    .bc-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: .07;
        pointer-events: none;
    }

    .bc-watermark img {
        width: 320px;
        height: 320px;
        object-fit: contain;
    }

    .bc-doc-title {
        text-align: center;
        font-size: 17px;
        font-weight: 700;
        letter-spacing: .5px;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .bc-body-text {
        position: relative;
        z-index: 1;
        line-height: 1.9;
        text-align: justify;
        font-size: 13px;
    }

    .bc-body-text p {
        margin: 0 0 12px;
    }

    .bc-indent {
        text-indent: 3em;
    }

    .bc-line {
        display: inline-block;
        border-bottom: 1px solid #111;
        vertical-align: bottom;
        height: 1px;
    }

    .bc-sig-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin: 36px 0 24px;
        position: relative;
        z-index: 1;
    }

    .bc-sig-left {
        min-width: 180px;
    }

    .bc-sig-line {
        border-bottom: 1px solid #111;
        width: 170px;
        margin-bottom: 4px;
    }

    .bc-sig-sub {
        font-size: 11px;
        color: #444;
    }

    .bc-sig-right {
        text-align: center;
    }

    .bc-approved-by {
        margin: 0 0 4px;
        font-size: 13px;
    }

    .bc-captain-name {
        margin: 0;
        font-weight: 700;
        font-size: 14px;
    }

    .bc-captain-title {
        margin: 0;
        font-size: 12px;
        color: #333;
    }

    .bc-footer-info {
        position: relative;
        z-index: 1;
        font-size: 12px;
        line-height: 1.7;
    }

    .bc-footer-info p {
        margin: 0;
    }

    .bc-photo-row {
        display: flex;
        gap: 10px;
        margin: 10px 0;
    }

    .bc-photo-box {
        width: 80px;
        height: 90px;
        border: 1px solid #555;
    }
</style>