<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FacilityRumahGadang extends Migration
{
    public function up()
    {
        $fields = [
            'id_facility_rumah_gadang' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'unique' => true,
            ],
            'facility' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ];
    
        $this->db->disableForeignKeyChecks();
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id_facility_rumah_gadang');
        $this->forge->createTable('facility_rumah_gadang');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('facility_rumah_gadang');
    }
}
