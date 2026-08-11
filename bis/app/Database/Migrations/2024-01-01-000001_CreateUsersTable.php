<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'unique'     => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            // 'captain','secretary','treasurer','sk','resident'
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['captain', 'secretary', 'treasurer', 'sk', 'resident'],
                'default'    => 'resident',
            ],
            // 'unverified' = email not yet verified
            // 'pending' = email verified, waiting for captain/secretary approval
            // 'active'  = can log in
            // 'rejected'= denied
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['unverified', 'pending', 'active', 'rejected'],
                'default'    => 'unverified',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'verify_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
                'default'    => null,
            ],
            'verify_token_expires' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'email_verified' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'contact_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'default'    => null,
            ],
            'household_no' => [
                'type'       => 'CHAR',
                'constraint' => 5,
                'null'       => true,
                'default'    => null,
                'comment'    => 'For residents — links to households.household_no',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
