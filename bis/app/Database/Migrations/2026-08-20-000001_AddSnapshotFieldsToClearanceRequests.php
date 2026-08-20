<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Stores the captain's name and issuance date at the moment of approval.
 * This ensures printed documents remain historically accurate even if
 * a new captain is appointed or the date changes after release.
 */
class AddSnapshotFieldsToClearanceRequests extends Migration
{
    public function up()
    {
        $fields = $this->db->getFieldNames('clearance_requests');

        if (! in_array('issued_captain_name', $fields)) {
            $this->forge->addColumn('clearance_requests', [
                'issued_captain_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                    'default'    => null,
                    'comment'    => 'Captain name snapshot at time of approval — never changes after issuance',
                    'after'      => 'processed_at',
                ],
            ]);
        }

        if (! in_array('issued_date', $fields)) {
            $this->forge->addColumn('clearance_requests', [
                'issued_date' => [
                    'type'    => 'DATE',
                    'null'    => true,
                    'default' => null,
                    'comment' => 'Issuance date snapshot at time of approval — never changes after issuance',
                    'after'   => 'issued_captain_name',
                ],
            ]);
        }
    }

    public function down()
    {
        $fields = $this->db->getFieldNames('clearance_requests');

        if (in_array('issued_captain_name', $fields)) {
            $this->forge->dropColumn('clearance_requests', 'issued_captain_name');
        }
        if (in_array('issued_date', $fields)) {
            $this->forge->dropColumn('clearance_requests', 'issued_date');
        }
    }
}
