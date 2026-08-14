<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Stores editable barangay identity and official info used across all document templates.
 */
class CreateBarangaySettingsTable extends Migration
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
            'setting_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'setting_value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
                'comment'    => 'Human-readable label for the UI',
            ],
            'group' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => false,
                'default'    => 'general',
                'comment'    => 'Grouping for the settings form (general, official, etc.)',
            ],
            'sort_order' => [
                'type'     => 'TINYINT',
                'null'     => false,
                'default'  => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('setting_key');
        $this->forge->createTable('barangay_settings');

        // Seed default values
        $this->db->table('barangay_settings')->insertBatch([
            // ── Barangay Identity ─────────────────────────────────────────────
            ['setting_key' => 'barangay_name',    'setting_value' => 'BARANGAY BACOLOD',         'label' => 'Barangay Name',     'group' => 'identity', 'sort_order' => 1],
            ['setting_key' => 'municipality',     'setting_value' => 'Municipality of Bato',     'label' => 'Municipality',      'group' => 'identity', 'sort_order' => 2],
            ['setting_key' => 'province',         'setting_value' => 'Province of Camarines Sur', 'label' => 'Province',         'group' => 'identity', 'sort_order' => 3],
            ['setting_key' => 'region',           'setting_value' => 'Region V',                 'label' => 'Region',            'group' => 'identity', 'sort_order' => 4],
            ['setting_key' => 'country',          'setting_value' => 'Republic of the Philippines', 'label' => 'Country',        'group' => 'identity', 'sort_order' => 5],
            ['setting_key' => 'full_address',     'setting_value' => 'Barangay Bacolod, Bato, Camarines Sur', 'label' => 'Full Address (for documents)', 'group' => 'identity', 'sort_order' => 6],
            ['setting_key' => 'office_header',    'setting_value' => 'OFFICE OF THE PUNONG BARANGAY', 'label' => 'Office Header Line', 'group' => 'identity', 'sort_order' => 7],

            // ── Officials ─────────────────────────────────────────────────────
            ['setting_key' => 'captain_name',     'setting_value' => 'MARK ARGARIN',             'label' => 'Punong Barangay (Full Name)', 'group' => 'officials', 'sort_order' => 10],
            ['setting_key' => 'captain_title',    'setting_value' => 'Punong Barangay',           'label' => 'Captain Title',     'group' => 'officials', 'sort_order' => 11],
            ['setting_key' => 'secretary_name',   'setting_value' => '',                          'label' => 'Barangay Secretary', 'group' => 'officials', 'sort_order' => 12],
            ['setting_key' => 'treasurer_name',   'setting_value' => '',                          'label' => 'Barangay Treasurer', 'group' => 'officials', 'sort_order' => 13],

            // ── Document Defaults ─────────────────────────────────────────────
            ['setting_key' => 'clearance_fee',    'setting_value' => '₱50.00',                   'label' => 'Clearance Fee',     'group' => 'fees', 'sort_order' => 20],
            ['setting_key' => 'residency_fee',    'setting_value' => '₱30.00',                   'label' => 'Certification Fee', 'group' => 'fees', 'sort_order' => 21],
            ['setting_key' => 'indigency_fee',    'setting_value' => 'Free',                      'label' => 'Indigency Fee',     'group' => 'fees', 'sort_order' => 22],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('barangay_settings');
    }
}
