<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Adds:
 *  - registered_voter  (TINYINT) — whether the household head is a registered voter
 *  - num_families      (TINYINT) — number of families sharing the household
 */
class AddHouseholdExtras extends Migration
{
    public function up()
    {
        $fields = $this->db->getFieldNames('households');

        if (! in_array('registered_voter', $fields)) {
            $this->forge->addColumn('households', [
                'registered_voter' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                    'after'      => 'philhealth_no',
                ],
            ]);
        }

        if (! in_array('num_families', $fields)) {
            $this->forge->addColumn('households', [
                'num_families' => [
                    'type'       => 'TINYINT',
                    'constraint' => 3,
                    'unsigned'   => true,
                    'default'    => 1,
                    'after'      => 'registered_voter',
                ],
            ]);
        }
    }

    public function down()
    {
        $fields = $this->db->getFieldNames('households');
        if (in_array('registered_voter', $fields)) {
            $this->forge->dropColumn('households', 'registered_voter');
        }
        if (in_array('num_families', $fields)) {
            $this->forge->dropColumn('households', 'num_families');
        }
    }
}
