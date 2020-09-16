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

    public function getSepatuMasuk($slug = false)
    {
        if($slug == false){
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
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
}