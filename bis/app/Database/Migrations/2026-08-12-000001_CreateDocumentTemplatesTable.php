<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentTemplatesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'template_key' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => false,
            ],
            'fields' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'html' => [
                'type' => 'LONGTEXT',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('template_key');
        $this->forge->createTable('document_templates');

        $now = date('Y-m-d H:i:s');
        $templates = [
            [
                'template_key' => 'clearance',
                'name' => 'Barangay Clearance',
                'fields' => json_encode([
                    ['name' => 'recipient_name', 'label' => 'Resident Name', 'type' => 'text', 'value' => 'Juan Dela Cruz'],
                    ['name' => 'recipient_age', 'label' => 'Age', 'type' => 'text', 'value' => '30'],
                    ['name' => 'recipient_civil_status', 'label' => 'Civil Status', 'type' => 'text', 'value' => 'Single'],
                    ['name' => 'recipient_address', 'label' => 'Address', 'type' => 'text', 'value' => 'Zone 2, Barangay Bacolod, Bato, Camarines Sur'],
                    ['name' => 'purpose', 'label' => 'Purpose', 'type' => 'text', 'value' => 'employment requirements'],
                    ['name' => 'issued_day', 'label' => 'Issued Day', 'type' => 'text', 'value' => '12th'],
                    ['name' => 'issued_month', 'label' => 'Issued Month', 'type' => 'text', 'value' => 'April, 2026'],
                    ['name' => 'issued_year', 'label' => 'Issued Year', 'type' => 'text', 'value' => '2026'],
                ], JSON_UNESCAPED_UNICODE),
                'html' => '<div class="bc-wrap" id="printable-doc">\n  <div class="bc-page">\n    <div class="bc-top-box">\n      <div class="bc-header-row">\n        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">\n        <div class="bc-header-center">\n          <p>Republic of the Philippines</p>\n          <p>Region V</p>\n          <p>Province of Camarines Sur</p>\n          <p>Municipality of Bato</p>\n          <p><strong>BARANGAY BACOLOD</strong></p>\n          <p class="bc-oOo">-oOo-</p>\n        </div>\n        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">\n      </div>\n      <div class="bc-office-bar">OFFICE OF THE PUNONG BARANGAY</div>\n    </div>\n    <div class="bc-body-box">\n      <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>\n      <div class="bc-doc-title">BARANGAY CLEARANCE</div>\n      <div class="bc-body-text">\n        <p><strong>TO WHOM IT MAY CONCERN,</strong></p>\n        <p class="bc-indent">This is to certify that <strong>{{recipient_name}}</strong>, <strong>{{recipient_age}}</strong> years old, <strong>{{recipient_civil_status}}</strong>, and a bonafide resident of <strong>{{recipient_address}}</strong>.</p>\n        <p class="bc-indent">This Barangay Clearance is issued upon request for <strong>{{purpose}}</strong>.</p>\n        <p class="bc-indent">Issued this <strong>{{issued_day}}</strong> day of <strong>{{issued_month}}</strong>, <strong>{{issued_year}}</strong> at Barangay Bacolod, Bato, Camarines Sur.</p>\n      </div>\n      <div class="bc-sig-section">\n        <div class="bc-sig-left">\n          <div class="bc-sig-line"></div>\n          <div class="bc-sig-sub">(Signature of Applicant)</div>\n        </div>\n        <div class="bc-sig-right">\n          <p class="bc-approved-by">Approved by:</p>\n          <p class="bc-captain-name">{{captain_name}}</p>\n          <p class="bc-captain-title">Punong Barangay</p>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'template_key' => 'residency',
                'name' => 'Barangay Certification',
                'fields' => json_encode([
                    ['name' => 'resident_name', 'label' => 'Resident Name', 'type' => 'text', 'value' => 'Maria Santos'],
                    ['name' => 'resident_address', 'label' => 'Address', 'type' => 'text', 'value' => 'Zone 3, Barangay Bacolod, Bato, Camarines Sur'],
                    ['name' => 'purpose', 'label' => 'Purpose', 'type' => 'text', 'value' => 'reference'],
                    ['name' => 'issued_day', 'label' => 'Issued Day', 'type' => 'text', 'value' => '16th'],
                    ['name' => 'issued_month', 'label' => 'Issued Month', 'type' => 'text', 'value' => 'April, 2026'],
                    ['name' => 'issued_year', 'label' => 'Issued Year', 'type' => 'text', 'value' => '2026'],
                ], JSON_UNESCAPED_UNICODE),
                'html' => '<div class="bc-wrap" id="printable-doc">\n  <div class="bc-page">\n    <div class="bc-top-box">\n      <div class="bc-header-row">\n        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">\n        <div class="bc-header-center">\n          <p>Republic of the Philippines</p>\n          <p>Region V</p>\n          <p>Province of Camarines Sur</p>\n          <p>Municipality of Bato</p>\n          <p><strong>BARANGAY BACOLOD</strong></p>\n          <p class="bc-oOo">-oOo-</p>\n        </div>\n        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">\n      </div>\n      <div class="bc-office-bar">OFFICE OF THE PUNONG BARANGAY</div>\n    </div>\n    <div class="bc-body-box">\n      <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>\n      <div class="bc-doc-title">BARANGAY CERTIFICATION</div>\n      <div class="bc-body-text">\n        <p><strong>TO WHOM IT MAY CONCERN:</strong></p>\n        <p class="bc-indent">This is to certify that <strong>{{resident_name}}</strong>, a bonafide resident of <strong>{{resident_address}}</strong>, lives in Barangay Bacolod, Bato, Camarines Sur.</p>\n        <p class="bc-indent">This certification is issued for <strong>{{purpose}}</strong> and whatever legal purposes it may serve.</p>\n        <p class="bc-indent">Issued this <strong>{{issued_day}}</strong> day of <strong>{{issued_month}}</strong>, <strong>{{issued_year}}</strong>.</p>\n      </div>\n      <div class="bc-sig-section" style="justify-content:flex-end;">\n        <div style="text-align:center;">\n          <p class="bc-approved-by">Attested by:</p>\n          <p class="bc-captain-name">{{captain_name}}</p>\n          <p class="bc-captain-title">Punong Barangay</p>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'template_key' => 'indigency',
                'name' => 'Certificate of Indigency',
                'fields' => json_encode([
                    ['name' => 'resident_name', 'label' => 'Resident Name', 'type' => 'text', 'value' => 'Emelda Benegas'],
                    ['name' => 'resident_address', 'label' => 'Address', 'type' => 'text', 'value' => 'Zone 5, Barangay Bacolod, Bato, Camarines Sur'],
                    ['name' => 'assistance_type', 'label' => 'Assistance Type', 'type' => 'text', 'value' => 'PhilHealth Assistance (YAKAP)'],
                    ['name' => 'issued_day', 'label' => 'Issued Day', 'type' => 'text', 'value' => '13th'],
                    ['name' => 'issued_month', 'label' => 'Issued Month', 'type' => 'text', 'value' => 'April, 2026'],
                    ['name' => 'issued_year', 'label' => 'Issued Year', 'type' => 'text', 'value' => '2026'],
                ], JSON_UNESCAPED_UNICODE),
                'html' => '<div class="bc-wrap" id="printable-doc">\n  <div class="bc-page">\n    <div class="bc-top-box">\n      <div class="bc-header-row">\n        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">\n        <div class="bc-header-center">\n          <p>Republic of the Philippines</p>\n          <p>Region V</p>\n          <p>Province of Camarines Sur</p>\n          <p>Municipality of Bato</p>\n          <p><strong>BARANGAY BACOLOD</strong></p>\n          <p class="bc-oOo">-oOo-</p>\n        </div>\n        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">\n      </div>\n      <div class="bc-office-bar">OFFICE OF THE PUNONG BARANGAY</div>\n    </div>\n    <div class="bc-body-box">\n      <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>\n      <div class="bc-doc-title">CERTIFICATE OF INDIGENCY</div>\n      <div class="bc-body-text">\n        <p><strong>TO WHOM IT MAY CONCERN,</strong></p>\n        <p class="bc-indent">This is to certify that <strong>{{resident_name}}</strong>, a bonafide resident of <strong>{{resident_address}}</strong>, is identified as belonging to an indigent family in this community.</p>\n        <p class="bc-indent">This certificate is issued to support <strong>{{assistance_type}}</strong> and for whatever legal purposes it may serve.</p>\n        <p class="bc-indent">Issued this <strong>{{issued_day}}</strong> day of <strong>{{issued_month}}</strong>, <strong>{{issued_year}}</strong> at Barangay Bacolod, Bato, Camarines Sur.</p>\n      </div>\n      <div class="bc-sig-section" style="justify-content:flex-end;">\n        <div style="text-align:center;">\n          <p class="bc-approved-by">Attested by:</p>\n          <p class="bc-captain-name">{{captain_name}}</p>\n          <p class="bc-captain-title">Punong Barangay</p>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'template_key' => 'business',
                'name' => 'Business Permit Clearance',
                'fields' => json_encode([
                    ['name' => 'control_no', 'label' => 'Control No.', 'type' => 'text', 'value' => 'BP-2026-001'],
                    ['name' => 'business_owner', 'label' => 'Owner Name', 'type' => 'text', 'value' => 'Jose Mercado'],
                    ['name' => 'business_name', 'label' => 'Business Name', 'type' => 'text', 'value' => 'Mercado Store'],
                    ['name' => 'business_address', 'label' => 'Business Address', 'type' => 'text', 'value' => 'Barangay Bacolod, Bato, Camarines Sur'],
                    ['name' => 'issued_day', 'label' => 'Issued Day', 'type' => 'text', 'value' => '12th'],
                    ['name' => 'issued_month', 'label' => 'Issued Month', 'type' => 'text', 'value' => 'April, 2026'],
                    ['name' => 'issued_year', 'label' => 'Issued Year', 'type' => 'text', 'value' => '2026'],
                ], JSON_UNESCAPED_UNICODE),
                'html' => '<div class="doc-template" id="printable-doc">\n  <div class="doc-control">Control No.: <strong>{{control_no}}</strong></div>\n  <div class="doc-header">\n    <div class="doc-logo-row">\n      <img src="/bacolod.png" class="doc-logo" alt="Logo">\n      <div>\n        <p class="doc-republic">Republic of the Philippines</p>\n        <p class="doc-province">Province of Camarines Sur</p>\n        <p class="doc-barangay">BARANGAY BACOLOD</p>\n        <p class="doc-municipality">Municipality of Bato, Camarines Sur</p>\n      </div>\n    </div>\n  </div>\n  <div class="doc-title"><h2>Business Permit Clearance</h2><p>Office of the Punong Barangay</p></div>\n  <div class="doc-body">\n    <p><strong>TO WHOM IT MAY CONCERN:</strong></p>\n    <p>This is to certify that <strong>{{business_owner}}</strong>, owner/operator of <strong>{{business_name}}</strong> located at <strong>{{business_address}}</strong>, has been granted barangay clearance to operate said business.</p>\n    <p>This clearance is issued upon request for business permit application purposes.</p>\n    <p>Issued this <strong>{{issued_day}}</strong> day of <strong>{{issued_month}}</strong>, <strong>{{issued_year}}</strong> at Barangay Bacolod, Bato, Camarines Sur.</p>\n  </div>\n  <div class="doc-footer">\n    <div class="doc-sig">\n      <div class="doc-sig-line">{{captain_name}}</div>\n      <div class="doc-sig-title">Punong Barangay</div>\n    </div>\n  </div>\n</div>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'template_key' => 'good_moral',
                'name' => 'Certificate of Good Moral Character',
                'fields' => json_encode([
                    ['name' => 'resident_name', 'label' => 'Resident Name', 'type' => 'text', 'value' => 'Maricon Suñas'],
                    ['name' => 'resident_age', 'label' => 'Age', 'type' => 'text', 'value' => '24'],
                    ['name' => 'resident_address', 'label' => 'Address', 'type' => 'text', 'value' => 'Zone 2, Barangay Bacolod, Bato, Camarines Sur'],
                    ['name' => 'issued_day', 'label' => 'Issued Day', 'type' => 'text', 'value' => '12th'],
                    ['name' => 'issued_month', 'label' => 'Issued Month', 'type' => 'text', 'value' => 'December, 2025'],
                    ['name' => 'issued_year', 'label' => 'Issued Year', 'type' => 'text', 'value' => '2025'],
                ], JSON_UNESCAPED_UNICODE),
                'html' => '<div class="bc-wrap" id="printable-doc">\n  <div class="bc-page">\n    <div class="bc-top-box">\n      <div class="bc-header-row">\n        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">\n        <div class="bc-header-center">\n          <p>Republic of the Philippines</p>\n          <p>Region V</p>\n          <p>Province of Camarines Sur</p>\n          <p>Municipality of Bato</p>\n          <p><strong>BARANGAY BACOLOD</strong></p>\n          <p class="bc-oOo">-oOo-</p>\n        </div>\n        <img src="/bacolod.png" class="bc-seal" alt="Bacolod Seal">\n      </div>\n      <div class="bc-office-bar">OFFICE OF THE PUNONG BARANGAY</div>\n    </div>\n    <div class="bc-body-box bc-two-col">\n      <div class="bc-officials">\n        <p class="bc-off-head">BARANGAY OFFICIALS</p>\n        <p class="bc-off-name">{{captain_name}}</p>\n        <p class="bc-off-role">Punong Barangay</p>\n        <div style="margin-top:auto;padding-top:20px;">\n          <p class="bc-not-valid">Not Valid Without Seal</p>\n        </div>\n      </div>\n      <div class="bc-right-col">\n        <div class="bc-watermark"><img src="/bacolod.png" alt="watermark"></div>\n        <div class="bc-doc-title">CERTIFICATE OF GOOD MORAL CHARACTER</div>\n        <div class="bc-body-text">\n          <p><strong>TO WHOM IT MAY CONCERN,</strong></p>\n          <p class="bc-indent">This is to certify that <strong>{{resident_name}}</strong>, <strong>{{resident_age}}</strong> years old, a bonafide resident of <strong>{{resident_address}}</strong>, is known to have good moral character and good standing in the community.</p>\n          <p class="bc-indent">This certification is issued for whatever legal purposes it may serve.</p>\n          <p class="bc-indent">Issued this <strong>{{issued_day}}</strong> day of <strong>{{issued_month}}</strong>, <strong>{{issued_year}}</strong> at Barangay Bacolod, Bato, Camarines Sur.</p>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'template_key' => 'solo_parent',
                'name' => 'Solo Parent Certificate',
                'fields' => json_encode([
                    ['name' => 'parent_name', 'label' => 'Parent Name', 'type' => 'text', 'value' => 'Dona Perez'],
                    ['name' => 'parent_age', 'label' => 'Age', 'type' => 'text', 'value' => '38'],
                    ['name' => 'parent_address', 'label' => 'Address', 'type' => 'text', 'value' => 'Barangay Bacolod, Bato, Camarines Sur'],
                    ['name' => 'number_of_children', 'label' => 'Number of Children', 'type' => 'text', 'value' => '2'],
                    ['name' => 'issued_day', 'label' => 'Issued Day', 'type' => 'text', 'value' => '20th'],
                    ['name' => 'issued_month', 'label' => 'Issued Month', 'type' => 'text', 'value' => 'May, 2026'],
                    ['name' => 'issued_year', 'label' => 'Issued Year', 'type' => 'text', 'value' => '2026'],
                ], JSON_UNESCAPED_UNICODE),
                'html' => '<div class="doc-template" id="printable-doc">\n  <div class="doc-control">Control No.: <strong>SP-2026-001</strong></div>\n  <div class="doc-header">\n    <div class="doc-logo-row">\n      <img src="/bacolod.png" class="doc-logo" alt="Logo">\n      <div>\n        <p class="doc-republic">Republic of the Philippines</p>\n        <p class="doc-province">Province of Camarines Sur</p>\n        <p class="doc-barangay">BARANGAY BACOLOD</p>\n        <p class="doc-municipality">Municipality of Bato, Camarines Sur</p>\n      </div>\n    </div>\n  </div>\n  <div class="doc-title"><h2>Solo Parent Certificate</h2><p>Office of the Punong Barangay — R.A. 8972</p></div>\n  <div class="doc-body">\n    <p><strong>TO WHOM IT MAY CONCERN:</strong></p>\n    <p>This is to certify that <strong>{{parent_name}}</strong>, <strong>{{parent_age}}</strong> years old, a resident of <strong>{{parent_address}}</strong>, is a Solo Parent as defined under Republic Act No. 8972.</p>\n    <p>The above-named person is solely responsible for the care and upbringing of <strong>{{number_of_children}}</strong> child/children.</p>\n    <p>This certificate is issued to support their application for solo parent benefits.</p>\n    <p>Issued this <strong>{{issued_day}}</strong> day of <strong>{{issued_month}}</strong>, <strong>{{issued_year}}</strong> at Barangay Bacolod, Bato, Camarines Sur.</p>\n  </div>\n  <div class="doc-footer">\n    <div class="doc-sig">\n      <div class="doc-sig-line">{{captain_name}}</div>\n      <div class="doc-sig-title">Punong Barangay</div>\n    </div>\n  </div>\n</div>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('document_templates')->insertBatch($templates);
    }

    public function down()
    {
        $this->forge->dropTable('document_templates');
    }
}
