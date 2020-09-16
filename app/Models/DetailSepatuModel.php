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

}