<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class DetailFacilityAtractionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_facility_atraction';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'id_atraction', 'id_atraction_facility'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // API
    public function get_facility_by_a_api($atraction_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('atraction_facility.name')
            ->where('id_atraction', $atraction_id)
            ->join('atraction_facility', 'detail_facility_atraction.id_atraction_facility = atraction_facility.id')
            ->get();
        return $query;
    }

    public function get_facility_by_fc_api($facility_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('id', $facility_id)
            ->get();
        return $query;
    }


    public function get_new_id_api()
    {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        if ($lastId != null) {
            $count = (int)substr($lastId['id'], 0);
            $id = sprintf('%02d', $count + 1);
        } else {
            $count = 0;
            $id = sprintf('%02d', $count + 1);
        }

        return $id;
    }

    public function add_facility_api($id = null, $data = null)
    {
        $query = false;
        foreach ($data as $facility) {
            $new_id = $this->get_new_id_api();
            $content = [
                'id' => $new_id,
                'id_atraction' => $id,
                'id_atraction_facility' => $facility,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_facility_api($id = null, $data = null)
    {
        $queryDel = $this->db->table($this->table)->delete(['id_atraction' => $id]);
        $queryIns = $this->add_facility_api($id, $data);
        return $queryDel && $queryIns;
    }
}
