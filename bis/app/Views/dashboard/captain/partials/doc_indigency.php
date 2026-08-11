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
            <div class="bc-doc-title">CERTIFICATE OF INDIGENCY</div>
            <div class="bc-body-text">
                <p><strong>To Whom It May Concern,</strong></p>
                <p class="bc-indent">This is to certify that <strong><?= esc($r['resident']) ?></strong>, <?= esc($r['age']) ?> years of age, <?= esc($r['civil_status']) ?>, bonafide resident of <strong><?= esc($r['address']) ?></strong>, is identified as belonging to an <strong>"Indigent Family"</strong> in this community as per records in this office.</p>
                <p class="bc-indent">This further certifies that the above-named person and his/her family earn meager income not enough to augment their basic needs and financial requirements, hence is indigent and qualified to avail of government assistance.</p>
                <p class="bc-indent">This certification is issued upon the request of the above-named person for <strong><?= esc($r['purpose']) ?></strong> and for whatever legal intent it may serve.</p>
                <p class="bc-indent">Given this <span class="bc-line" style="width:40px;">&nbsp;</span> day of <span class="bc-line" style="width:110px;">&nbsp;</span> at <strong>Barangay Bacolod, Bato, Camarines Sur, Philippines.</strong></p>
            </div>
            <div class="bc-sig-section">
                <div></div>
                <div class="bc-sig-right">
                    <p class="bc-approved-by">Attested by:</p>
                    <p class="bc-captain-name"><?= esc($captainName ?? 'PUNONG BARANGAY') ?></p>
                    <p class="bc-captain-title">Punong Barangay</p>
                </div>
            </div>
            <p class="bc-not-valid">Not Valid Without Official Seal</p>
            <div class="bc-footer-info" style="margin-top:12px;">
                <p>Fee: Free of Charge</p>
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
        margin: 36px 0 16px;
        position: relative;
        z-index: 1;
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

    .bc-not-valid {
        color: #c0392b;
        font-size: 12px;
        font-weight: 600;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .bc-footer-info {
        font-size: 12px;
        line-height: 1.7;
    }

    .bc-footer-info p {
        margin: 0;
    }
</style>