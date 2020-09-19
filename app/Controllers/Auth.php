<?php namespace App\Controllers;

use App\Models\RoleModel;

class Auth extends BaseController
{
	public function __construct()
	{
		helper('form');
		$this->validation = \Config\Services::validation();
		$this->session = session();
	}

	public function register(){
		
		if($this->request->getPost())
		{
			//lakukan validasi untuk data yang di post
			$data = $this->request->getPost();
			$validate = $this->validation->run($data, 'register');
			$errors = $this->validation->getErrors();

			//jika tidak ada errors jalanakan
			if(!$errors){
				$userModel = new \App\Models\UserModel();

				$user = new \App\Entities\User();

				$user->username = $this->request->getPost('username');
				$user->password = $this->request->getPost('password');
				$user->name = $this->request->getPost('username');
				$user->email = $this->request->getPost('email');
				$user->avatar = "avatar_default.jpg";

				$user->created_by = 0;
				$user->created_date = date("Y-m-d H:i:s");

				$userModel->save($user);

				return view('auth/login');
			}

			$this->session->setFlashdata('errors', $errors);
		}

		return view('auth/register');
	}

	public function login(){
		if($this->request->getPost())
		{
			//lakukan validasi untuk data yang di post
			$data = $this->request->getPost();
			$validate = $this->validation->run($data, 'login');
			$errors = $this->validation->getErrors();

			if($errors)
			{
				return view('login');
			}

			$userModel = new \App\Models\UserModel();

			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');

			$user = $userModel->where('username', $username)->first();

			if($user)
			{
				$salt = $user->salt;
				if($user->password!==md5($salt.$password))
				{
					$this->session->setFlashdata('errors', ['Password Salah']);
				}else{
					$sessData = [
						'username' => $user->username,
						'id' => $user->id,
						'role' => $user->id_role,
						'user_login' => $user,
						'isLoggedIn' => TRUE
					];

					$this->session->set($sessData);
					
					return redirect()->to('/dashboard');
				}
			}else{
				$this->session->setFlashdata('errors', ['User Tidak Ditemukan']);
			}
		}
		return view('auth/login');
	}

	public function logout()
	{
		$this->session->destroy();
		return redirect()->to('/auth/login');
	}
	
	//--------------------------------------------------------------------

}
