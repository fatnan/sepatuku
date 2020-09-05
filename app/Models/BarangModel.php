<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_barang',
        'kode_barang',
        'harga',
        'deskripsi',
        'kategori',
        'slug',
        'gambar'
    ];
    protected $useTimestamps = true;

    public function getBarang($slug = false)
    {
        if($slug == false){
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }

    public function getIdBarang()
    {
        $barang = $this->select('id')->orderBy('id','DESC')->first();
        return $barang['id'];
    }
    public function getKodeBarang($kode_barang){
        $barang = $this->select('kode_barang')->where('kode_barang',$kode_barang)->first();
        if($barang) {
            return false;
        } else {
            return true;
        }
    }
}