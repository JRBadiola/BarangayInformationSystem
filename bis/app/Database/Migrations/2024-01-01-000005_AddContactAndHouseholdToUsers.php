<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Adds contact_number and household_no columns to the users table.
 * Safe to run on existing data — only adds columns if they don't exist.
 */
class AddContactAndHouseholdToUsers extends Migration
{
    public function up()
    {
        // Only add if not already present (safe re-run)
        $fields = $this->db->getFieldNames('users');

        if (! in_array('contact_number', $fields)) {
            $this->forge->addColumn('users', [
                'contact_number' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'email_verified',
                ],
            ]);
        }

        if (! in_array('household_no', $fields)) {
            $this->forge->addColumn('users', [
                'household_no' => [
                    'type'       => 'CHAR',
                    'constraint' => 5,
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'contact_number',
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['contact_number', 'household_no']);
    }
}
