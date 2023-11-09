<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;


class HomestayFacility extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH . 'seeds/' . 'homestay_facility.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'name' => $row[1],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('homestay_facility')->insert($data);
        }
    }
}
