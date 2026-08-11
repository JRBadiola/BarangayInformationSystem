<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Adds a gender column to household_members so members can be filtered
 * by gender the same way household heads are.
 */
class AddGenderToHouseholdMembers extends Migration
{
    public function up()
    {
        $fields = $this->db->getFieldNames('household_members');

        if (! in_array('gender', $fields)) {
            $this->forge->addColumn('household_members', [
                'gender' => [
                    'type'       => 'ENUM',
                    'constraint' => ['Male', 'Female'],
                    'null'       => true,
                    'after'      => 'date_of_birth',
                ],
            ]);
        }
    }

    public function down()
    {
        $fields = $this->db->getFieldNames('household_members');
        if (in_array('gender', $fields)) {
            $this->forge->dropColumn('household_members', 'gender');
        }
    }
}
