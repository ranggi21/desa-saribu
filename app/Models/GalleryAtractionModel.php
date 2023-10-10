<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class GalleryAtractionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'atraction_gallery';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'id_atraction', 'url'];

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
    public function get_new_id_api()
    {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        if ($lastId != null) {
            $count = (int)substr($lastId['id'], 0);
            $id = sprintf('%03d', $count + 1);
        } else {
            $count = 0;
            $id = sprintf('%03d', $count + 1);
        }

        return $id;
    }

    public function get_gallery_api($atraction__id = null)
    {
        $query = $this->db->table($this->table)
            ->select('url')
            ->orderBy('id', 'ASC')
            ->where('id_atraction', $atraction__id)
            ->get();
        return $query;
    }

    public function add_gallery_api($id = null, $data = null)
    {
        $query = false;
        foreach ($data as $gallery) {
            $new_id = $this->get_new_id_api();
            $content = [
                'id' => $new_id,
                'id_atraction' => $id,
                'url' => $gallery,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_gallery_api($id = null, $data = null)
    {
        $queryDel = $this->delete_gallery_api($id);

        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
        $queryIns = $this->add_gallery_api($id, $data);
        return $queryDel && $queryIns;
    }

    public function delete_gallery_api($id = null)
    {
        return $this->db->table($this->table)->delete(['id_atraction' => $id]);
    }
}
