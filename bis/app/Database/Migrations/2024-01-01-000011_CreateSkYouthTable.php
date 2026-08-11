<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Stores SK youth profiling records (KK Profiling Form / LYDO Form 1).
 * Age range: 15–30 years old.
 */
class CreateSkYouthTable extends Migration
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

            // ── Section 1: Personal Information ──────────────────────────
            'last_name'   => ['type' => 'VARCHAR', 'constraint' => 80],
            'first_name'  => ['type' => 'VARCHAR', 'constraint' => 80],
            'middle_name' => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
            'suffix'      => ['type' => 'VARCHAR', 'constraint' => 10,  'null' => true],

            'date_of_birth'  => ['type' => 'DATE',    'null' => true],
            'place_of_birth' => ['type' => 'VARCHAR',  'constraint' => 150, 'null' => true],
            'gender'         => ['type' => 'ENUM',     'constraint' => ['Male', 'Female'], 'null' => true],
            'religion'       => ['type' => 'VARCHAR',  'constraint' => 80,  'null' => true],
            'citizenship'    => ['type' => 'VARCHAR',  'constraint' => 60,  'default' => 'Filipino'],
            'contact_number' => ['type' => 'VARCHAR',  'constraint' => 20,  'null' => true],
            'email'          => ['type' => 'VARCHAR',  'constraint' => 150, 'null' => true],
            'address'        => ['type' => 'TEXT',     'null' => true],
            'zone'           => ['type' => 'VARCHAR',  'constraint' => 50,  'null' => true],
            'months_in_brgy' => ['type' => 'VARCHAR',  'constraint' => 50,  'null' => true],
            'skills'         => ['type' => 'TEXT',     'null' => true],
            'hobbies'        => ['type' => 'TEXT',     'null' => true],

            'mother_name'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'mother_occupation' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'father_name'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'father_occupation' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],

            // ── Section 2: Organization membership (JSON) ─────────────────
            'organizations' => ['type' => 'TEXT', 'null' => true],

            // ── Section 3: Age group ──────────────────────────────────────
            'age_group' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],

            // ── Section 4: Civil status ───────────────────────────────────
            'civil_status' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],

            // ── Section 5: Educational background ────────────────────────
            'educational_background' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'school_type'            => ['type' => 'ENUM', 'constraint' => ['Public School', 'Private School'], 'null' => true],
            'school_detail'          => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],

            // ── Section 6: Governance ─────────────────────────────────────
            'governance' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],

            // ── Section 7: Physical & Mental Health (JSON array) ──────────
            'health_concerns' => ['type' => 'TEXT', 'null' => true],

            // ── Section 8: Social Inclusion (JSON array) ──────────────────
            'social_inclusion' => ['type' => 'TEXT', 'null' => true],

            // ── Section 9: Economic Empowerment ──────────────────────────
            'economic_status' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'monthly_income'  => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],

            // ── Section 10–11: Advocacy & Volunteer ──────────────────────
            'advocacy'   => ['type' => 'TEXT', 'null' => true],
            'volunteer'  => ['type' => 'TEXT', 'null' => true],

            // ── Section 12: Issues & Suggestions ─────────────────────────
            'issue_1'     => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'issue_2'     => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'issue_3'     => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'suggestions' => ['type' => 'TEXT', 'null' => true],

            // ── Record metadata ───────────────────────────────────────────
            'recorded_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('last_name');
        $this->forge->addKey('gender');
        $this->forge->addKey('date_of_birth');
        $this->forge->createTable('sk_youth');
    }

    public function down()
    {
        $this->forge->dropTable('sk_youth');
    }
}
