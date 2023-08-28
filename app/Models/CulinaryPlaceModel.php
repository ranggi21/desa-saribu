<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class CulinaryPlaceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'culinary_place';
    protected $primaryKey       = 'id_culinary_place';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_culinary_place', 'name', 'address', 'cp', 'open', 'close', 'geom', 'description', 'lat', 'lng'];

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
    public function get_list_cp_api() {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id_culinary_place as id,{$this->table}.name,{$this->table}.address,{$this->table}.cp as contact_person,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $vilGeom = "regional.id_regional = '1' AND ST_Contains(regional.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, culinary_place.lat, culinary_place.lng")
            ->from('regional')
            ->where($vilGeom)
            ->get();
        return $query;
    }

    public function list_by_owner($id = null) {
        $query = $this->db->table($this->table)
            ->select('culinary_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('owner', $id)
            ->join('account', 'culinary_place.owner = account.id')
            ->get();
        return $query;
    }

    public function get_cp_by_id_api($id = null) {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id_culinary_place as id,{$this->table}.name,{$this->table}.address,{$this->table}.cp as contact_person,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $vilGeom = "regional.id_regional = '1' AND ST_Contains(regional.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, culinary_place.lat, culinary_place.lng")
            ->from('regional')
            ->where('culinary_place.id_culinary_place', $id)
            ->where($vilGeom)
            ->get();
        return $query;
    }

    public function get_cp_in_id_api($id = null) {
        $query = $this->db->table($this->table)
            ->select('culinary_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->whereIn('culinary_place.id_culinary_place', $id)
            ->join('account', 'culinary_place.owner = account.id')
            ->get();
        return $query;
    }

    public function get_cp_by_name_api($name = null) {
        $query = $this->db->table($this->table)
            ->select('culinary_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('account', 'culinary_place.owner = account.id')
            ->like('name', $name)
            ->get();
        return $query;
    }
    
    public function get_cp_by_radius_api($data = null) {
        $radius = (int)$data['radius'] / 1000;
        $lat = $data['lat'];
        $long = $data['long'];
        $jarak = "(6371 * acos(cos(radians({$lat})) * cos(radians({$this->table}.lat)) * cos(radians({$this->table}.lng) - radians({$long})) + sin(radians({$lat}))* sin(radians({$this->table}.lat))))";
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id_culinary_place as id,{$this->table}.name,{$this->table}.address,{$this->table}.cp as contact_person,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $vilGeom = "regional.id_regional = '1' AND ST_Contains(regional.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, culinary_place.lat, culinary_place.lng, {$jarak} as jarak")
            ->from('regional')
            ->where($vilGeom)
            ->having(['jarak <=' => $radius])
            ->get();
        return $query;
    }

    public function get_new_id_api() {
        $lastId = $this->db->table($this->table)->select('id_culinary_place')->orderBy('id_culinary_place', 'ASC')->get()->getLastRow('array');
        $count = (int)substr($lastId['id_culinary_place'], 1);
        $id = sprintf('C%01d', $count + 1);
        return $id;
    }

    public function add_cp_api($culinary_place = null) {
        foreach ($culinary_place as $key => $value) {
            if(empty($value)) {
                unset($culinary_place[$key]);
            }
        }
        $culinary_place['created_at'] = Time::now();
        $culinary_place['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->insert($culinary_place);
        return $query;
    }

    public function update_cp_api($id = null, $culinary_place = null) {
        foreach ($culinary_place as $key => $value) {
            if(empty($value)) {
                unset($culinary_place[$key]);
            }
        }
        $culinary_place['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id_culinary_place', $id)
            ->update($culinary_place);
        return $query;
    }
}
