<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSkProgramsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 200],
            'category'     => [
                'type'       => 'ENUM',
                'constraint' => ['Sports', 'Livelihood', 'Health', 'Education', 'Environment', 'Cultural', 'Other'],
                'default'    => 'Other',
            ],
            'description'  => ['type' => 'TEXT',    'null' => true],
            'start_date'   => ['type' => 'DATE',     'null' => true],
            'end_date'     => ['type' => 'DATE',     'null' => true],
            'venue'        => ['type' => 'VARCHAR',  'constraint' => 255, 'null' => true],
            'target_participants' => ['type' => 'INT', 'constraint' => 6, 'unsigned' => true, 'default' => 0],
            'actual_participants' => ['type' => 'INT', 'constraint' => 6, 'unsigned' => true, 'default' => 0],
            'budget'       => ['type' => 'DECIMAL',  'constraint' => '12,2', 'default' => '0.00'],
            'status'       => [
                'type'       => 'ENUM',
                'constraint' => ['Upcoming', 'Active', 'Completed', 'Cancelled'],
                'default'    => 'Upcoming',
            ],
            'created_by'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('status');
        $this->forge->addKey('start_date');
        $this->forge->createTable('sk_programs');
    }

    public function down()
    {
        $this->forge->dropTable('sk_programs');
    }
}
