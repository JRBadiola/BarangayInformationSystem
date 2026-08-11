<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlotterReportsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'complainant_user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'default' => null],
            'complainant_name'    => ['type' => 'VARCHAR', 'constraint' => 150],
            'complainant_email'   => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'incident_type'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'incident_date'       => ['type' => 'DATE', 'null' => true],
            'incident_time'       => ['type' => 'TIME', 'null' => true],
            'location'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'persons_involved'    => ['type' => 'TEXT', 'null' => true],
            'narrative'           => ['type' => 'TEXT'],
            // Respondent info (filled by captain/secretary)
            'respondent_name'     => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'respondent_email'    => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'respondent_address'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            // Status tracking
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'under_investigation', 'resolved', 'dismissed'],
                'default'    => 'pending',
            ],
            'remarks'          => ['type' => 'TEXT', 'null' => true],
            'processed_by'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'summons_sent_at'  => ['type' => 'DATETIME', 'null' => true],
            'hearing_date'     => ['type' => 'DATE', 'null' => true],
            'hearing_time'     => ['type' => 'TIME', 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('complainant_user_id');
        $this->forge->addKey('status');
        // FK only when user_id is not null
        $this->forge->createTable('blotter_reports');
    }

    public function down()
    {
        $this->forge->dropTable('blotter_reports');
    }
}
