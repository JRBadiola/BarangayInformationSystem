<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Adds visibility and shared_with to schedules table.
 *
 * visibility:
 *   'private'  — only visible to the creator
 *   'shared'   — visible to both captain and secretary
 *
 * shared_with:
 *   user_id of the person this event was shared TO
 *   (e.g. secretary creates event for captain → shared_with = captain's user_id)
 */
class AddScheduleVisibility extends Migration
{
    public function up()
    {
        $fields = $this->db->getFieldNames('schedules');

        if (! in_array('visibility', $fields)) {
            $this->forge->addColumn('schedules', [
                'visibility' => [
                    'type'       => 'ENUM',
                    'constraint' => ['private', 'shared'],
                    'default'    => 'private',
                    'after'      => 'blotter_id',
                ],
            ]);
        }

        if (! in_array('shared_with', $fields)) {
            $this->forge->addColumn('schedules', [
                'shared_with' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'visibility',
                ],
            ]);
        }
    }

    public function down()
    {
        $fields = $this->db->getFieldNames('schedules');
        foreach (['visibility', 'shared_with'] as $col) {
            if (in_array($col, $fields)) {
                $this->forge->dropColumn('schedules', $col);
            }
        }
    }
}
