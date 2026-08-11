<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBlotterContactAndAppointment extends Migration
{
    public function up()
    {
        $fields = $this->db->getFieldNames('blotter_reports');

        if (! in_array('complainant_contact', $fields)) {
            $this->forge->addColumn('blotter_reports', [
                'complainant_contact' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 30,
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'complainant_email',
                ],
            ]);
        }

        if (! in_array('appointment_date', $fields)) {
            $this->forge->addColumn('blotter_reports', [
                'appointment_date' => [
                    'type'    => 'DATE',
                    'null'    => true,
                    'default' => null,
                    'after'   => 'complainant_contact',
                ],
            ]);
        }

        if (! in_array('appointment_time', $fields)) {
            $this->forge->addColumn('blotter_reports', [
                'appointment_time' => [
                    'type'    => 'TIME',
                    'null'    => true,
                    'default' => null,
                    'after'   => 'appointment_date',
                ],
            ]);
        }
    }

    public function down()
    {
        $fields = $this->db->getFieldNames('blotter_reports');
        foreach (['complainant_contact', 'appointment_date', 'appointment_time'] as $col) {
            if (in_array($col, $fields)) {
                $this->forge->dropColumn('blotter_reports', $col);
            }
        }
    }
}
