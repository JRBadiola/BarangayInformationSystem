<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Adds grade_level to household_members so the census form can record
 * a child's current grade (e.g. "Grade 3", "1st Year College") when they are a student.
 */
class AddGradeLevelToMembers extends Migration
{
    public function up()
    {
        $fields = $this->db->getFieldNames('household_members');
        if (! in_array('grade_level', $fields)) {
            $this->forge->addColumn('household_members', [
                'grade_level' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 80,
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'occupation',
                ],
            ]);
        }
    }

    public function down()
    {
        $fields = $this->db->getFieldNames('household_members');
        if (in_array('grade_level', $fields)) {
            $this->forge->dropColumn('household_members', 'grade_level');
        }
    }
}
