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
        'id_merk',
        'id_kategori',
        'slug',
        'gambar',
        'created_by',
        'updated_by',
        'stock'
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
    public function getNamaSepatu($id)
    {
        return $this->where(['id' => $id])->first();
    }
    
    public function search($keyword){
        return $this->table('sepatu')->like('nama_sepatu',$keyword);
    }

    public function countAllSepatu(){
        $sepatu = $this->db->table('sepatu')
            ->select('*');
        $countSepatu=$sepatu->countAllResults();
        return $countSepatu;
    }

    public function getSepatuPerMerk($id_merk){
        $sepatu = $this->table('sepatu')->where('id_merk',$id_merk)->findAll();
        return $sepatu;
    }

    public function getSepatuPerKategori($id_kategori){
        $sepatu = $this->table('sepatu')->where('id_kategori',$id_kategori)->findAll();
        return $sepatu;
    }

    // public function comboSepatu($params)
    // {
    //     return static::select('id as id', 'nama_sepatu as text')
    //                     ->where([
    //                         ['nama_sepatu','LIKE','%'.$params['search'].'%'],
    //                         ['id_merk',$params['id_merk']],
    //                         ])
    //                     ->get()
    //                     ->toArray();
    // }
}