<?php namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
	protected $table = 'role';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'role','previlege','created_date','updated_date'
	];
	protected $useTimestamps = false;
	public function getRole($id = 0)
    {
        if($id == 0){
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}