<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\SepatuModel;
class SepatuKeluarModel extends Model
{
    protected $table = 'sepatukeluar';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_sepatu',
        'total_harga',
        'batch',
        'slug',
        'stock',
        'size',
        'jumlah',
        'diskon',
        'keterangan',
        'status',
        'waktu_transaksi',
        'created_by',
        'updated_by',
    ];
    protected $useTimestamps = true;

    public function getSepatuKeluar($id = false)
    {
        if($id == false){
            return $this->orderBy('waktu_transaksi','DESC')->findAll();
        }
        $sepatu = $this->db->table('sepatukeluar')
            ->select('
            sepatukeluar.id AS id_sepatukeluar,
            sepatukeluar.total_harga,
            sepatukeluar.size,
            sepatukeluar.stock,
            sepatukeluar.waktu_transaksi,
            sepatukeluar.keterangan,
            sepatukeluar.diskon,
            sepatukeluar.batch,
            sepatu.gambar,
            sepatu.nama_sepatu,
            sepatu.slug,
            sepatu.id,
            sepatu.id_merk
            ')
            ->where(['sepatukeluar.id'=>$id])
            ->join('sepatu','sepatu.id=sepatukeluar.id_sepatu')
            ->get()->getResultArray(); 
        return $sepatu[0];
    }

    public function getIdSepatu($id_sepatu)
    {
        $sepatu = $this->select('id')->orderBy('id','DESC')->where('id',$id_sepatu)->first();
        return $sepatu['id'];
    }
    public function sepatu($sepatukeluar){
        $sepatuModel= new SepatuModel();
        $allsepatu = array();
        foreach($sepatukeluar as $s){
            $sepatu=$sepatuModel->getNamaSepatu($s['id_sepatu']);
            $s['nama_sepatu']=$sepatu['nama_sepatu'];
            array_push($allsepatu,$s);
        }
        return $allsepatu;
    }
    public function getSize(){
        $size = $this->db->table('detailsepatu')
        ->select('size')
        ->groupBy('size')
        ->orderBy('size ASC')
        ->get()
        ->getResultArray() ;
        return $size;
    }
    public function getBatch(){
        $size = $this->db->table('detailsepatu')
        ->select('batch')
        ->groupBy('batch')
        ->orderBy('batch ASC')
        ->get()
        ->getResultArray() ;
        return $size;
    }

    public function getExportSepatuKeluar($startdate=null,$enddate=null)
    {
        if($startdate==null && $enddate==null){
            $sepatu = $this->db->table('sepatukeluar')
                ->select('
                sepatukeluar.id AS id_sepatukeluar,
                sepatukeluar.total_harga,
                sepatukeluar.size,
                sepatukeluar.stock,
                sepatukeluar.waktu_transaksi,
                sepatukeluar.keterangan,
                sepatukeluar.diskon,
                sepatukeluar.batch,
                sepatu.gambar,
                sepatu.nama_sepatu,
                sepatu.slug,
                sepatu.id,
                sepatu.id_merk
                ')
                ->join('sepatu','sepatu.id=sepatukeluar.id_sepatu')
                ->get()->getResultArray(); 
            return $sepatu;
        } else if($startdate == null) {
            $sepatu = $this->db->table('sepatukeluar')
                ->select('
                sepatukeluar.id AS id_sepatukeluar,
                sepatukeluar.total_harga,
                sepatukeluar.size,
                sepatukeluar.stock,
                sepatukeluar.waktu_transaksi,
                sepatukeluar.keterangan,
                sepatukeluar.diskon,
                sepatukeluar.batch,
                sepatu.gambar,
                sepatu.nama_sepatu,
                sepatu.slug,
                sepatu.id,
                sepatu.id_merk
                ')
                ->join('sepatu','sepatu.id=sepatukeluar.id_sepatu')
                ->where('waktu_transaksi <',$enddate)
                ->get()->getResultArray(); 
            return $sepatu;
        } else if($enddate == null){
            $sepatu = $this->db->table('sepatukeluar')
            ->select('
            sepatukeluar.id AS id_sepatukeluar,
            sepatukeluar.total_harga,
            sepatukeluar.size,
            sepatukeluar.stock,
            sepatukeluar.waktu_transaksi,
            sepatukeluar.keterangan,
            sepatukeluar.diskon,
            sepatukeluar.batch,
            sepatu.gambar,
            sepatu.nama_sepatu,
            sepatu.slug,
            sepatu.id,
            sepatu.id_merk
            ')
            ->join('sepatu','sepatu.id=sepatukeluar.id_sepatu')
                ->where('waktu_transaksi >',$startdate)
                ->get()->getResultArray(); 
            return $sepatu;
        } else {
            $sepatu = $this->db->table('sepatukeluar')
                ->select('
                sepatukeluar.id AS id_sepatukeluar,
                sepatukeluar.total_harga,
                sepatukeluar.size,
                sepatukeluar.stock,
                sepatukeluar.waktu_transaksi,
                sepatukeluar.keterangan,
                sepatukeluar.diskon,
                sepatukeluar.batch,
                sepatu.gambar,
                sepatu.nama_sepatu,
                sepatu.slug,
                sepatu.id,
                sepatu.id_merk
                ')
                ->join('sepatu','sepatu.id=sepatukeluar.id_sepatu')
                ->where('waktu_transaksi >',$startdate)
                ->where('waktu_transaksi <',$enddate)
                ->get()->getResultArray(); 
            return $sepatu;
        }
    }
}