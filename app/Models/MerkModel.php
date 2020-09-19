<?php

namespace App\Models;

use CodeIgniter\Model;

class MerkModel extends Model
{
    protected $table = 'merk';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_merk',
        'logo',
        'created_date',
        'updated_date'
    ];
    protected $useTimestamps = false;

    public function getMerk($id = 0)
    {
        if($id == 0){
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

    public function getIdMerk()
    {
        $merk = $this->select('merk')->orderBy('id','DESC')->first();
        return $merk['id'];
    }
    public function countAllMerk(){
        $merk = $this->db->table('merk')
            ->select('*');
        $countMerk=$merk->countAllResults();
        return $countMerk;
    }
}