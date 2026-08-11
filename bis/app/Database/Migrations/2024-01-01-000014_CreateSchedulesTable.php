<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 200],
            'description' => ['type' => 'TEXT', 'null' => true],
            'event_date'  => ['type' => 'DATE'],
            'start_time'  => ['type' => 'TIME', 'null' => true],
            'end_time'    => ['type' => 'TIME', 'null' => true],
            'event_type'  => [
                'type'       => 'ENUM',
                'constraint' => ['hearing', 'meeting', 'appointment', 'event', 'other'],
                'default'    => 'appointment',
            ],
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => '#1d2448',
            ],
            'location'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'blotter_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_by'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('event_date');
        $this->forge->addKey('created_by');
        $this->forge->createTable('schedules');
    }

    public function down()
    {
        $this->forge->dropTable('schedules');
    }
}
