<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_kategori',
        'created_date',
        'updated_date'
    ];
    protected $useTimestamps = false;

    public function getKategori($id = 0)
    {
        if($id == 0){
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

    public function getIdKategori()
    {
        $kategori = $this->select('kategori')->orderBy('id','DESC')->first();
        return $kategori['id'];
    }
    public function countAllKategori(){
        $kategori = $this->db->table('kategori')
            ->select('*');
        $countKategori=$kategori->countAllResults();
        return $countKategori;
    }
}