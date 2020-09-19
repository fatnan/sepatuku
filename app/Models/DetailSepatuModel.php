<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\SepatuModel;
class DetailSepatuModel extends Model
{
    protected $table = 'detailsepatu';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_sepatu',
        'size',
        'stock',
        'batch',
        'created_date',
        'updated_date'
    ];
    // protected $useTimestamps = true;

    public function getAllDetailSepatu()
    {   
        $sepatu = $this->db->table('detailsepatu')
         ->select('detailsepatu.id_sepatu,detailsepatu.stock as detailstock,detailsepatu.size,detailsepatu.batch,sepatu.nama_sepatu')
         ->join('sepatu','sepatu.id=detailsepatu.id_sepatu')
         ->get()->getResultArray(); 
        return $sepatu;
    }

    public function search($keyword){
        // $this->db->select('prod_id, prod_name, prod_link, prod_description, prod_status, prod_price, brand_link, link, cat_link, normal');
        // $this->db->join('category', 'cat_id = prod_category');
        // $this->db->join('brands', 'brand_id = prod_brand');
        
        // $this->table('sepatu')->select('id');
        // $query = $this->db->get('product')->result_array();
        return $this->table('detailsepatu')->like('nama_sepatu',$keyword);
    }

}