<?php

namespace App\Models;

use CodeIgniter\Model;

class SepatuModel extends Model
{
    protected $table = 'sepatu';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_sepatu',
        'kode_sepatu',
        'harga',
        'deskripsi',
        'kategori',
        'slug',
        'gambar'
    ];
    protected $useTimestamps = true;

    public function getSepatu($slug = false)
    {
        if($slug == false){
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }

    public function getIdSepatu()
    {
        $sepatu = $this->select('id')->orderBy('id','DESC')->first();
        return $sepatu['id'];
    }
    public function getKodeSepatu($kode_sepatu){
        $sepatu = $this->select('kode_sepatu')->where('kode_sepatu',$kode_sepatu)->first();
        if($sepatu) {
            return false;
        } else {
            return true;
        }
    }
}