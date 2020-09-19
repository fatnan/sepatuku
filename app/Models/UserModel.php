<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table = 'user';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'username','email','name','avatar','password','salt','id_role','created_date','created_by','updated_date','updated_by'
	];
	protected $returnType = 'App\Entities\User';
	protected $useTimestamps = false;

	public function search($keyword){
        return $this->table('user')->like('name',$keyword);
	}
	public function countAllUser(){
        $user = $this->db->table('user')
            ->select('*');
        $countUser=$user->countAllResults();
        return $countUser;
    }
}