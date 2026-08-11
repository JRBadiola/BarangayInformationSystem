<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Stores all household members linked to a household via household_no (PK).
 */
class CreateHouseholdMembersTable extends Migration
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

            // FK → households.household_no
            'household_no' => [
                'type'       => 'CHAR',
                'constraint' => 5,
            ],

            'relationship' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            // ── Name ──────────────────────────────────────────────────────
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

            // ── Personal details ──────────────────────────────────────────
            'date_of_birth' => [
                'type' => 'DATE',
                'null' => true,
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
            'philhealth_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'educational_attainment' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
            ],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('household_no');
        $this->forge->addForeignKey('household_no', 'households', 'household_no', 'CASCADE', 'CASCADE');
        $this->forge->createTable('household_members');
    }

    public function down()
    {
        $this->forge->dropTable('household_members');
    }
}
