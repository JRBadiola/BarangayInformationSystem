/**
 * doc-templates.js
 * Barangay Document Template Engine
 *
 * Usage:
 *   BisDoc.setCensus({ name, age, civil, zone, occupation });
 *   const html = BisDoc.build('clearance', 'Juan Dela Cruz', 'Employment');
 *   document.getElementById('preview').innerHTML = html;
 *   BisDoc.print('clearance', 'Juan Dela Cruz', 'Employment');
 */

const BisDoc = (function () {

    // ── Census data (set per page load) ──────────────────────────────────────
    let _census = { name: '', age: '', civil: '', zone: '', occupation: '' };
    let _captain = 'Punong Barangay';   // overridden by setCaptain()

    function setCensus(data) {
        _census = Object.assign(_census, data);
    }

    function setCaptain(name) {
        if (name) _captain = name;
    }

    // ── Helpers ───────────────────────────────────────────────────────────────
    function ordinal(n) {
        const s = ['th', 'st', 'nd', 'rd'], v = n % 100;
        return n + (s[(v - 20) % 10] || s[v] || s[0]);
    }

    function today() {
        const d = new Date();
        return {
            day:   d.getDate(),
            month: d.toLocaleString('default', { month: 'long' }),
            year:  d.getFullYear(),
        };
    }

    // ── Shared screen-preview CSS ─────────────────────────────────────────────
    const SCREEN_STYLES = `<style>
.bc-wrap{font-family:'Cambria',serif;font-size:14px;color:#111;background:#f0f0f0;display:flex;justify-content:center;padding:20px 0;}
.bc-page{width:794px;min-height:1123px;background:#fff;border:2px solid #3a6abf;box-sizing:border-box;display:flex;flex-direction:column;position:relative;}
.bc-top-box{border-bottom:2px solid #3a6abf;padding:20px 40px 0;}
.bc-header-row{display:flex;align-items:flex-start;justify-content:center;gap:32px;padding-bottom:14px;}
.bc-seal{width:90px;height:90px;object-fit:contain;border-radius:50%;}
.bc-header-center{text-align:center;font-family:'Times New Roman',serif;font-size:11px;font-weight:bold;line-height:1.5;color:#111;}
.bc-header-center p{margin:0;}.bc-oOo{font-weight:normal!important;font-style:italic;}
.bc-office-bar{font-family:'Times New Roman',serif;font-size:13px;font-weight:bold;color:#111;padding:8px 0 10px;text-align:center;}
.bc-body-box{flex:1;padding:28px 48px 36px;position:relative;overflow:hidden;}
.bc-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:0.06;pointer-events:none;z-index:0;}
.bc-watermark img{width:150mm;height:150mm;object-fit:contain;}
.bc-doc-title{text-align:center;font-family:'Times New Roman',serif;font-size:20px;font-weight:700;margin-bottom:28px;position:relative;z-index:1;}
.bc-body-text{font-family:'Times New Roman',serif;font-size:14px;position:relative;z-index:1;line-height:2;text-align:justify;}
.bc-body-text p{margin:0 0 14px;}.bc-indent{text-indent:3em;}
.bc-line{display:inline-block;border-bottom:1px solid #111;vertical-align:bottom;height:1px;}
.bc-sig-section{display:flex;justify-content:space-between;align-items:flex-end;margin:48px 0 32px;position:relative;z-index:1;}
.bc-sig-left{min-width:200px;}.bc-sig-line{border-bottom:1px solid #111;width:190px;margin-bottom:4px;}
.bc-sig-sub{font-size:12px;color:#444;}.bc-sig-right{text-align:center;}
.bc-approved-by{margin:0 0 4px;font-size:14px;}.bc-captain-name{margin:0;font-weight:700;font-size:15px;letter-spacing:.3px;}
.bc-captain-title{margin:0;font-size:13px;color:#333;}
.bc-footer-info{margin-top:24px;font-family:'Times New Roman',serif;position:relative;z-index:1;font-size:12px;line-height:1.6;}
.bc-footer-info p{margin:0;}.bc-photo-row{display:flex;gap:12px;margin:10px 0;}
.bc-photo-box{width:90px;height:80px;border:1px solid #555;}
</style>`;

    // ── Shared print CSS ──────────────────────────────────────────────────────
    const PRINT_STYLES = `<style>
@page { size: A4 portrait; margin: 0; }
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { width: 210mm; height: 297mm; background: #fff; }
.bc-wrap { width: 210mm; height: 297mm; padding: 7mm; display: block; }
.bc-page {
  width: 100%; height: 100%;
  border: 2.5px solid #3a6abf;
  display: flex; flex-direction: column;
  position: relative; overflow: hidden;
  padding: 8mm 12mm 8mm 12mm;
}
.bc-watermark {
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  opacity: 0.07; pointer-events: none; z-index: 0;
}
.bc-watermark img { width: 150mm; height: 150mm; object-fit: contain; }
.bc-top-box { border-bottom: 2px solid #3a6abf; padding: 4mm 12mm 4mm; margin: 0 -12mm; flex-shrink: 0; }
.bc-header-row { display: flex; align-items: center; justify-content: center; gap: 14px; padding-bottom: 3px; }
.bc-seal { width: 82px; height: 82px; object-fit: contain; border-radius: 50%; }
.bc-header-center { text-align: center; font-family: 'Times New Roman', serif; font-size: 12pt; font-weight: bold; line-height: 1.5; }
.bc-header-center p { margin: 0; }
.bc-oOo { font-weight: normal !important; font-style: italic; }
.bc-office-bar { text-align: center; font-family: 'Times New Roman', serif; font-size: 14pt; font-weight: bold; padding: 4px 0 0; flex-shrink: 0; }
.bc-body-box { flex: 1; display: flex; flex-direction: column; padding: 0; position: relative; }
.bc-doc-title { text-align: center; font-family: 'Times New Roman', serif; font-size: 22pt; font-weight: bold; margin: 8mm 0 7mm; position: relative; z-index: 1; flex-shrink: 0; }
.bc-body-text { font-family: 'Times New Roman', serif; font-size: 14pt; line-height: 2.4; text-align: justify; position: relative; z-index: 1; flex: 1; }
.bc-body-text p { margin: 0 0 5mm; }
.bc-indent { text-indent: 3em; }
.bc-sig-section { display: flex; justify-content: space-between; align-items: flex-end; margin-top: auto; padding-top: 18mm; position: relative; z-index: 1; flex-shrink: 0; }
.bc-sig-left { min-width: 180px; }
.bc-sig-line { border-bottom: 1px solid #111; width: 180px; margin-bottom: 3px; }
.bc-sig-sub { font-size: 12pt; color: #444; }
.bc-sig-right { text-align: center; }
.bc-approved-by { margin: 0 0 3px; font-size: 13pt; }
.bc-captain-name { margin: 0; font-weight: bold; font-size: 14pt; }
.bc-captain-title { margin: 0; font-size: 13pt; color: #333; }
.bc-footer-info { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.7; position: relative; z-index: 1; flex-shrink: 0; margin-top: 6mm; }
.bc-footer-info p { margin: 0; }
.bc-photo-row { display: flex; gap: 10px; margin: 6px 0; }
.bc-photo-box { width: 80px; height: 90px; border: 1px solid #555; }
.bc-indigency-sig { text-align: right; font-family: Cambria, serif; font-size: 13pt; margin-top: auto; padding-top: 20mm; position: relative; z-index: 1; flex-shrink: 0; line-height: 1.7; }
.bc-indigency-sig p { margin: 0; }
.bc-not-valid { font-family: Cambria, serif; font-size: 13pt; font-weight: normal; font-style: normal; color: #c0392b; margin-top: 10mm; position: relative; z-index: 1; flex-shrink: 0; }
.bc-residency-sig { display: flex; justify-content: flex-end; margin-top: auto; padding-top: 20mm; position: relative; z-index: 1; flex-shrink: 0; }
.bc-residency-sig div { text-align: center; min-width: 220px; font-family: Cambria, serif; font-size: 13pt; line-height: 1.7; }
</style>`;

    // ── Shared header HTML ────────────────────────────────────────────────────
    function _header() {
        return `<div class="bc-top-box">
  <div class="bc-header-row">
    <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">
    <div class="bc-header-center">
      <p>Republic of the Philippines</p><p>Region V</p>
      <p>Province of Camarines Sur</p><p>Municipality of Bato</p>
      <p><strong>BARANGAY BACOLOD</strong></p>
      <p class="bc-oOo">-oOo-</p>
    </div>
    <img src="/picture1.png" class="bc-seal" alt="Bato Seal">
  </div>
  <div class="bc-office-bar"><strong>OFFICE OF THE PUNONG BARANGAY</strong></div>
</div>`;
    }

    // ── Document body builders ────────────────────────────────────────────────

    function _clearance(name, civil, zone, purpose, d) {
        return `<div class="bc-doc-title">BARANGAY CLEARANCE</div>
<div class="bc-body-text">
  <p><strong>TO WHOM IT MAY CONCERN,</strong></p>
  <p class="bc-indent">This is to certify that <strong>${name}</strong>, a legal age, ${civil} and a bonafide resident of ${zone ? zone + ', ' : ''}<strong>Barangay Bacolod, Bato, Camarines Sur.</strong></p>
  <p class="bc-indent">He/She possessed good moral character trustworthy, a law-abiding Filipino Citizen and cooperative to all undertakings for the progress of the community.</p>
  <p class="bc-indent">This Barangay Clearance is being issued upon the request of the above-named person for <strong>${purpose}</strong> and for whatever legal purposes it may serve.</p>
  <p class="bc-indent">Given this <strong>${ordinal(d.day)}</strong> day of <strong>${d.month}, ${d.year}</strong> at <strong>Barangay Bacolod, Bato, Camarines Sur, Philippines.</strong></p>
</div>
<div class="bc-sig-section">
  <div class="bc-sig-left"><div class="bc-sig-line"></div><div class="bc-sig-sub">(Signature of Applicant)</div></div>
  <div class="bc-sig-right">
    <p class="bc-approved-by">Approved by:</p>
    <p class="bc-captain-name">${_captain}</p>
    <p class="bc-captain-title">Punong Barangay</p>
  </div>
</div>
<div class="bc-footer-info">
  <p>CTC No.&nbsp; : _______________</p>
  <p>Issued at : <strong><u>Bacolod, Bato, Camarines Sur</u></strong></p>
  <p>Issued on: <strong><u>${d.month} ${d.day}, ${d.year}</u></strong></p>
  <div class="bc-photo-row"><div class="bc-photo-box"></div><div class="bc-photo-box"></div></div>
  <p>OR. No.&nbsp;&nbsp; : _______________</p>
  <p>Issued at : <strong><u>Bacolod, Bato, Camarines Sur</u></strong></p>
  <p>Issued on: <strong><u>${d.month} ${d.day}, ${d.year}</u></strong></p>
</div>`;
    }

    function _residency(name, civil, zone, purpose, d) {
        return `<div class="bc-doc-title" style="color:#1a3a8f;">BARANGAY CERTIFICATION</div>
<div class="bc-body-text">
  <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
  <p class="bc-indent">This is to certify that <strong>${name.toUpperCase()}</strong>, of legal age, ${civil}, Filipino and a Bonafide resident of ${zone ? zone + ', ' : ''}<strong>Barangay Bacolod, Bato, Camarines Sur.</strong></p>
  <p class="bc-indent">This further certifies that according to the records, the above-mentioned name is a registered resident living at the address stated above.</p>
  <p class="bc-indent">This certification is issued upon the request of the interested party for <strong>${purpose}</strong> and for whatever legal intent this may serve.</p>
  <p class="bc-indent">Issued this <strong>${ordinal(d.day)}</strong> day of <strong>${d.month}, ${d.year}</strong> at <strong>Barangay Bacolod, Bato, Camarines Sur. Philippines.</strong></p>
</div>
<div class="bc-sig-section" style="justify-content:flex-end;margin-top:auto;padding-top:18mm;">
  <div style="text-align:center;min-width:220px;font-family:Cambria,serif;font-size:13pt;line-height:1.7;">
    <p style="margin:0;">Attested by:</p>
    <p style="margin:0;font-weight:700;text-decoration:underline;">${_captain}</p>
    <p style="margin:0;">Punong Barangay</p>
  </div>
</div>`;
    }

    function _indigency(name, civil, zone, purpose, d) {
        return `<div class="bc-doc-title" style="color:#1a3a8f;">CERTIFICATE OF INDIGENCY</div>
<div class="bc-body-text" style="flex:1;">
  <p><strong>To Whom It May Concern,</strong></p>
  <p class="bc-indent">This is to certify that <strong>${name.toUpperCase()}</strong>, legal age, ${civil.toLowerCase()}, bonafide resident of ${zone ? zone + ', ' : ''}<strong>Barangay Bacolod, Bato, Camarines Sur</strong> and are identified belonging to the "Indigent family" in this community as per record in this office.</p>
  <p class="bc-indent">This further certifies that the above-named and whose family earned meager income not enough to augment their basic needs and financial, hence an indigent and qualified to avail for <strong>${purpose}</strong>.</p>
  <p class="bc-indent">Given this <strong>${ordinal(d.day)}</strong> day of <strong>${d.month}, ${d.year}</strong> at <strong>Barangay Bacolod, Bato, Camarines Sur. Philippines.</strong></p>
</div>
<div style="margin-top:auto;padding-top:20mm;text-align:right;font-family:Cambria,serif;font-size:12pt;position:relative;z-index:1;line-height:1.7;flex-shrink:0;">
  <p style="margin:0;">Attested by:</p>
  <p style="margin:0;font-weight:700;text-decoration:underline;">${_captain}</p>
  <p style="margin:0;">Punong Barangay</p>
</div>
<p style="margin-top:10mm;font-family:Cambria,serif;font-size:12pt;color:#c0392b;position:relative;z-index:1;flex-shrink:0;">Not Valid Without Seal</p>`;
    }

    // ── Public API ────────────────────────────────────────────────────────────

    /**
     * Build a screen-preview HTML string.
     * @param {string} docKey  'clearance' | 'residency' | 'indigency'
     * @param {string} forMember  Name of the person the document is for
     * @param {string} purpose    Purpose of the request
     * @returns {string} Full HTML including styles
     */
    function build(docKey, forMember, purpose) {
        const name  = forMember || _census.name;
        const civil = _census.civil;
        const zone  = _census.zone;
        const d     = today();

        let body = '';
        if      (docKey === 'clearance') body = _clearance(name, civil, zone, purpose, d);
        else if (docKey === 'residency') body = _residency(name, civil, zone, purpose, d);
        else                             body = _indigency(name, civil, zone, purpose, d);

        return `<div class="bc-wrap"><div class="bc-page">
  ${_header()}
  <div class="bc-body-box">
    <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>
    ${body}
  </div>
</div></div>${SCREEN_STYLES}`;
    }

    /**
     * Open a print window with the document.
     * @param {string} docKey
     * @param {string} forMember
     * @param {string} purpose
     */
    function print(docKey, forMember, purpose) {
        const name  = forMember || _census.name;
        const civil = _census.civil;
        const zone  = _census.zone;
        const d     = today();

        let body = '';
        if      (docKey === 'clearance') body = _clearance(name, civil, zone, purpose, d);
        else if (docKey === 'residency') body = _residency(name, civil, zone, purpose, d);
        else                             body = _indigency(name, civil, zone, purpose, d);

        const html = `<!DOCTYPE html><html><head><title>Document</title>${PRINT_STYLES}</head>
<body>
<div class="bc-wrap"><div class="bc-page">
  ${_header()}
  <div class="bc-body-box">
    <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>
    ${body}
  </div>
</div></div>
<script>window.onload=function(){window.print();window.close();}<\/script>
</body></html>`;

        const win = window.open('', '_blank', 'width=900,height=900');
        win.document.write(html);
        win.document.close();
    }

    return { setCensus, setCaptain, build, print };

})();
