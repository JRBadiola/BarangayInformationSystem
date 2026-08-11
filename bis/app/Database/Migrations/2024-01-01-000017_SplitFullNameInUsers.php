<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SplitFullNameInUsers extends Migration
{
    public function up()
    {
        // Add the three name columns after the id column
        $this->forge->addColumn('users', [
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
                'default'    => null,
                'after'      => 'id',
            ],
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
                'default'    => null,
                'after'      => 'last_name',
            ],
            'middle_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
                'default'    => null,
                'after'      => 'first_name',
            ],
        ]);

        // Migrate existing data: split full_name into last_name / first_name
        // Assumes "First [Middle] Last" order — we store first word as first_name, last word as last_name
        $this->db->query("
            UPDATE users
            SET
                first_name = TRIM(SUBSTRING_INDEX(full_name, ' ', 1)),
                last_name  = TRIM(SUBSTRING_INDEX(full_name, ' ', -1))
            WHERE full_name IS NOT NULL AND full_name != ''
        ");

        // Drop the old full_name column
        $this->forge->dropColumn('users', 'full_name');
    }

    public function down()
    {
        // Re-add full_name
        $this->forge->addColumn('users', [
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'default'    => null,
                'after'      => 'id',
            ],
        ]);

        // Restore full_name from parts
        $this->db->query("
            UPDATE users
            SET full_name = CONCAT_WS(' ', first_name, NULLIF(middle_name, ''), last_name)
        ");

        // Drop the three columns
        $this->forge->dropColumn('users', 'last_name');
        $this->forge->dropColumn('users', 'first_name');
        $this->forge->dropColumn('users', 'middle_name');
    }
}
