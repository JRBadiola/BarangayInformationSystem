<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAvatarToUsers extends Migration
{
    public function up()
    {
        $fields = $this->db->getFieldNames('users');
        if (! in_array('avatar', $fields)) {
            $this->forge->addColumn('users', [
                'avatar' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'contact_number',
                ],
            ]);
        }
    }

    public function down()
    {
        $fields = $this->db->getFieldNames('users');
        if (in_array('avatar', $fields)) {
            $this->forge->dropColumn('users', 'avatar');
        }
    }
}
