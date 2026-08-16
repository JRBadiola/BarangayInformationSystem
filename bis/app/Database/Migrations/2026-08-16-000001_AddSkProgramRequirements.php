<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Adds requirements and notify_residents columns to sk_programs,
 * and creates sk_program_registrations for resident participation tracking.
 */
class AddSkProgramRequirements extends Migration
{
    public function up()
    {
        // ── Add requirements + notify flag to sk_programs ─────────────────────
        $progFields = $this->db->getFieldNames('sk_programs');

        if (! in_array('requirements', $progFields)) {
            $this->forge->addColumn('sk_programs', [
                'requirements' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'comment' => 'Comma-separated list of requirements to join',
                    'after' => 'description',
                ],
            ]);
        }

        if (! in_array('notify_residents', $progFields)) {
            $this->forge->addColumn('sk_programs', [
                'notify_residents' => [
                    'type'    => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                    'null'    => false,
                    'comment' => '1 = residents have been notified about this program',
                    'after'   => 'requirements',
                ],
            ]);
        }

        // ── sk_program_registrations ──────────────────────────────────────────
        if (! $this->db->tableExists('sk_program_registrations')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'program_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'user_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'comment'    => 'FK → users.id',
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['pending', 'approved', 'rejected'],
                    'default'    => 'pending',
                ],
                'requirements_submitted' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'comment' => 'Comma-separated list of submitted requirement items',
                ],
                'notes' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);

            $this->forge->addKey('id', true);
            $this->forge->addKey('program_id');
            $this->forge->addKey('user_id');
            $this->forge->addUniqueKey(['program_id', 'user_id']);
            $this->forge->addForeignKey('program_id', 'sk_programs', 'id', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('user_id',    'users',       'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('sk_program_registrations');
        }
    }

    public function down()
    {
        if ($this->db->tableExists('sk_program_registrations')) {
            $this->forge->dropTable('sk_program_registrations');
        }
        $fields = $this->db->getFieldNames('sk_programs');
        foreach (['requirements', 'notify_residents'] as $col) {
            if (in_array($col, $fields)) {
                $this->forge->dropColumn('sk_programs', $col);
            }
        }
    }
}
