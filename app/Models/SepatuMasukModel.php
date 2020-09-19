<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\SepatuModel;
class SepatuMasukModel extends Model
{
    protected $table = 'sepatumasuk';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_sepatu',
        'total_harga',
        'slug',
        'stock',
        'size',
        'jumlah',
        'waktu_transaksi',
        'created_by',
        'updated_by',
    ];
    protected $useTimestamps = true;

    public function getSepatuMasuk($id = false)
    {
        if($id == false){
            return $this->findAll();
        }
        $sepatu = $this->db->table('sepatumasuk')
            ->select('sepatumasuk.id AS id_sepatumasuk,sepatumasuk.total_harga,sepatumasuk.size,sepatumasuk.stock,sepatumasuk.waktu_transaksi,sepatu.gambar,sepatu.nama_sepatu,sepatu.slug,sepatu.id,sepatu.id_merk')
            ->where(['sepatumasuk.id'=>$id])
            ->join('sepatu','sepatu.id=sepatumasuk.id_sepatu')
            ->get()->getResultArray(); 
        return $sepatu[0];
    }

    public function getIdSepatu($id_sepatu)
    {
        $sepatu = $this->select('id')->orderBy('id','DESC')->where('id',$id_sepatu)->first();
        return $sepatu['id'];
    }
    public function sepatu($sepatumasuk){
        $sepatuModel= new SepatuModel();
        $allsepatu = array();
        foreach($sepatumasuk as $s){
            $sepatu=$sepatuModel->getNamaSepatu($s['id_sepatu']);
            $s['nama_sepatu']=$sepatu['nama_sepatu'];
            array_push($allsepatu,$s);
        }
        return $allsepatu;

    }

    public function getExportSepatuMasuk()
    {
        $sepatu = $this->db->table('sepatumasuk')
            ->select('sepatumasuk.id AS id_sepatumasuk,sepatumasuk.total_harga,sepatumasuk.size,sepatumasuk.stock,sepatumasuk.waktu_transaksi,sepatu.gambar,sepatu.nama_sepatu,sepatu.slug,sepatu.id,sepatu.id_merk')
            ->join('sepatu','sepatu.id=sepatumasuk.id_sepatu')
            ->get()->getResultArray(); 
        return $sepatu[0];
    }
}