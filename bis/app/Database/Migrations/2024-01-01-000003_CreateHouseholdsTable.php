<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Stores one record per household (the head of the family).
 * household_no is the PRIMARY KEY — a system-generated 5-digit number
 * that residents use as their identifier before logging in.
 */
class CreateHouseholdsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            // ── Primary key — 5-digit system-generated household number ───
            'household_no' => [
                'type'       => 'CHAR',
                'constraint' => 5,
            ],

            'zone' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],

            // ── Head of family — name ─────────────────────────────────────
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
            ],
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
            ],
            'middle_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
            ],
            'suffix' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],

            // ── Head of family — personal details ────────────────────────
            'date_of_birth' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'place_of_birth' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['Male', 'Female'],
                'default'    => 'Male',
            ],
            'civil_status' => [
                'type'       => 'ENUM',
                'constraint' => ['Single', 'Married', 'Widowed', 'Separated', 'Annulled'],
                'default'    => 'Single',
            ],
            'nationality' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'default'    => 'Filipino',
            ],
            'religion' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
            ],
            'occupation' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'monthly_income' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => '0.00',
            ],
            'contact_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'educational_attainment' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
            ],
            'philhealth_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // ── Household classification ──────────────────────────────────
            'years_of_residency' => [
                'type'       => 'SMALLINT',
                'constraint' => 5,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'house_ownership' => [
                'type'       => 'ENUM',
                'constraint' => ['Owned', 'Rented', 'Shared', 'Informal Settler'],
                'default'    => 'Owned',
            ],
            'is_4ps'            => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_pwd'            => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_senior_citizen' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_solo_parent'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_indigenous'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],

            // ── Water & Sanitation ────────────────────────────────────────
            'water_source_level' => [
                'type'       => 'ENUM',
                'constraint' => ['I', 'II', 'III', 'none'],
                'null'       => true,
            ],
            'water_safety_managed' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'sanitation_basic' => [
                'type'       => 'ENUM',
                'constraint' => ['with', 'without'],
                'null'       => true,
            ],
            'sanitation_managed' => [
                'type'       => 'ENUM',
                'constraint' => ['with', 'without'],
                'null'       => true,
            ],

            // ── Record metadata ───────────────────────────────────────────
            'recorded_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'recorded_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('household_no');
        $this->forge->addKey('zone');
        $this->forge->addKey('last_name');
        $this->forge->createTable('households');
    }

    public function down()
    {
        $this->forge->dropTable('households');
    }
}
