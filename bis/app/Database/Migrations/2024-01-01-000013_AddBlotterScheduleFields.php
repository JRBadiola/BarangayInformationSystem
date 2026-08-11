<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Adds hearing_notes and scheduled_by to blotter_reports for schedule management.
 */
class AddBlotterScheduleFields extends Migration
{
    public function up()
    {
        $fields = $this->db->getFieldNames('blotter_reports');

        if (! in_array('hearing_notes', $fields)) {
            $this->forge->addColumn('blotter_reports', [
                'hearing_notes' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'hearing_time',
                ],
            ]);
        }

        if (! in_array('scheduled_by', $fields)) {
            $this->forge->addColumn('blotter_reports', [
                'scheduled_by' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'hearing_notes',
                ],
            ]);
        }

        if (! in_array('letter_issued_at', $fields)) {
            $this->forge->addColumn('blotter_reports', [
                'letter_issued_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'scheduled_by',
                ],
            ]);
        }
    }

    public function down()
    {
        $fields = $this->db->getFieldNames('blotter_reports');
        foreach (['hearing_notes', 'scheduled_by', 'letter_issued_at'] as $col) {
            if (in_array($col, $fields)) {
                $this->forge->dropColumn('blotter_reports', $col);
            }
        }
    }
}
