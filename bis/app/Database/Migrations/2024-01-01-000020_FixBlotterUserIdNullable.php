<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Ensures complainant_user_id in blotter_reports allows NULL.
 * Public blotter submissions (from non-logged-in visitors) set this to NULL.
 */
class FixBlotterUserIdNullable extends Migration
{
    public function up()
    {
        // Modify the column to explicitly allow NULL
        $this->forge->modifyColumn('blotter_reports', [
            'complainant_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
        ]);
    }

    public function down()
    {
        // Revert to NOT NULL (only safe if no null rows exist)
        $this->forge->modifyColumn('blotter_reports', [
            'complainant_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);
    }
}
