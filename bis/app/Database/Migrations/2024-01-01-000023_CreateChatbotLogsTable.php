<?php

use CodeIgniter\Database\Migration;

class CreateChatbotLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'resident_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'topic' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'response' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Resolved', 'Unanswered'],
                'default'    => 'Resolved',
            ],
            'rating' => [
                'type'       => 'DECIMAL',
                'constraint' => '2,1',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('resident_id');
        $this->forge->addKey('created_at');
        $this->forge->createTable('chatbot_logs');
    }

    public function down()
    {
        $this->forge->dropTable('chatbot_logs');
    }
}
