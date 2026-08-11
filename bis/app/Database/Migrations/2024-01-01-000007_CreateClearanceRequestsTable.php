<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Stores barangay document requests submitted by residents.
 */
class CreateClearanceRequestsTable extends Migration
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
            // The resident user who filed the request
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            // Household the request belongs to
            'household_no' => [
                'type'       => 'CHAR',
                'constraint' => 5,
                'null'       => true,
            ],
            // Which family member the document is for
            'for_member' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'comment'    => 'Full name of the family member the document is for',
            ],
            'member_relationship' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'Relationship to household head (e.g. self, spouse, child)',
            ],
            // Document details
            'document_type' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'Barangay Clearance',
                    'Certificate of Residency',
                    'Certificate of Indigency',
                ],
                'default' => 'Barangay Clearance',
            ],
            'purpose' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Status tracking
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected', 'released'],
                'default'    => 'pending',
            ],
            'remarks' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Captain/secretary remarks on approval or rejection',
            ],
            'processed_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'FK → users.id (captain/secretary who processed)',
            ],
            'processed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'est_release_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('clearance_requests');
    }

    public function down()
    {
        $this->forge->dropTable('clearance_requests');
    }
}
