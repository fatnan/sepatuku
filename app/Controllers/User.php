<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MerkModel;
use App\Models\KategoriModel;
use App\Models\RoleModel;


class User extends BaseController
{
    protected $orangModel;
    public function __construct(){
        $this->session = session();
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->merkModel = new MerkModel();
        $this->kategoriModel = new KategoriModel();
        $this->listMerk = $this->merkModel->getMerk();
        $this->listKategori = $this->kategoriModel->getKategori();
    }

    public function index(){
        //pagination
        $data_perpage = 5;
        $currentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1 ;
        //search
        $keyword = $this->request->getVar('keyword');
        if($keyword){
            $user = $this->userModel->search($keyword);
        } else{
            $user = $this->userModel;
        }
        $data = [
            'title' => 'User',
            'user' => $user->paginate($data_perpage,'user'),
            'pager' => $this->userModel->pager,
            'current_page' => $currentPage,
            'data_perpage' => $data_perpage,
            'username' => ucfirst($this->session->get('username')),
            'merk'  => $this->listMerk,
            'kategori' => $this->listKategori,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];

		return view('user/index',$data);
    }

    public function detail($id)
    {
        $listMerk = $this->merkModel->getMerk();
        $data = [
            'title' => 'Detail User',
            'user' => $this->userModel->find($id),
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'kategori' => $this->listKategori,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        if(empty($data['user'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User '.$id.' tidak ditemukan.');
        }
        return view('user/detail',$data);
    }
    
    public function create()
    {
        $listMerk = $this->merkModel->getMerk();
        $listRole = $this->roleModel->getRole();
        $data=[
            'title' => 'Tambah User',
            'validation'=> \Config\Services::validation(),
            'role' => $listRole,
            'merk' => $listMerk,
            'kategori' => $this->listKategori,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        return view('user/create',$data);
    }

    public function store()
    {
        //validation
        if(!$this->validate([
            'username' => [
                'rules' => 'required|min_length[3]|is_unique[user.username]',
                'errors' => [
                    // 'required' => '{field} nama sepatu harus diisi.',
                    'required' => 'Username harus diisi.',
                    'is_unique' => 'Username sudah terdaftar'
                ]
            ],
            'name' => 'required|min_length[3]',
            'email' => 'required',
            'password' => 'required',
            'repeatPassword' => [
                'rules'=>'required|matches[password]',
                'errors'=>[
                    'required' => 'Repeat Password harus diisi',
                    'matches' => 'Repeat Password harus sama dengan password',
                ]
            ],
            'avatar' => [
                'rules' => 'max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => 'Pilih gambar terlebih dahulu',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'File yang anda upload bukan gambar',
                    'mime_in' => 'File yang anda upload bukan gambar (jpg,jpeg,png)'
                ]
            ],
            'role' => 'required'
        ])) {
            return redirect()->to('/user/create')->withInput();
        }
        // ambil avatar
        $fileAvatar = $this->request->getFile('avatar');
        //cek ada foto atau tidak
        if($fileAvatar->getError() == 4){
            $namaAvatar = 'avatar_default.jpg';
        }else{
            //generate nama photo random
            $namaAvatar = $fileAvatar->getRandomName();
            $fileAvatar->move('img/user',$fileAvatar);
        }
        $user = new \App\Entities\User();

        $user->username = $this->request->getVar('username');
        $user->password = $this->request->getVar('password');
        $user->email = $this->request->getVar('email');
        $user->name = $this->request->getVar('name');
        $user->avatar = $namaAvatar;
        $user->id_role = $this->request->getVar('role');
        $user->created_by = $this->session->get('id');
        $user->created_date = date("Y-m-d H:i:s");

        $this->userModel->save($user);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/user');
    }

    public function delete($id){
        //cari gambar berdasasrkan id
        $user = $this->userModel->find($id);
        // delete avatar
        if($user->avatar != 'avatar_default.jpg'){
            unlink('img/'.$user->avatar);
        }
        $this->userModel->delete($id);
        session()->setFlashdata('pesan', 'User berhasil dihapus');
        return redirect()->to('/user');
    }

    public function edit($id){
        $listMerk = $this->merkModel->getMerk();
        $listRole = $this->roleModel->getRole();
        $data=[
            'title' => 'Edit User',
            'validation'=> \Config\Services::validation(),
            'user' => $this->userModel->find($id),
            'role' => $listRole,
            'merk' => $listMerk,
            'kategori' => $this->listKategori,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        return view('user/edit',$data);
    }

    public function update($id){
        $userLama = $this->userModel->find($this->request->getVar('id_lama'));
        if($userLama->username == $this->request->getVar('username')){
            $rule_username = 'required';
        } else {
            $rule_username = 'required|min_length[3]|is_unique[user.username]';
        }
        if($this->request->getVar('password')){
            $rule_password='required';
            $rule_repeatPassword=[
                'rules'=>'required|matches[password]',
                'errors'=>[
                    'required' => 'Repeat Password harus diisi',
                    'matches' => 'Repeat Password harus sama dengan password',
                ]
            ];
        } else {
            $rule_password='permit_empty';
            $rule_repeatPassword='permit_empty';
        }
        //validation
        if(!$this->validate([
            'username' => [
                'rules' => $rule_username,
                'errors' => [
                    // 'required' => '{field} nama sepatu harus diisi.',
                    'required' => 'Username harus diisi.',
                    'is_unique' => 'Username sudah terdaftar'
                ]
            ],
            'name' => 'required|min_length[3]',
            'email' => 'required',
            'password' => $rule_password,
            'repeatPassword' => $rule_repeatPassword,
            'avatar' => [
                'rules' => 'max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => 'Pilih gambar terlebih dahulu',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'File yang anda upload bukan gambar',
                    'mime_in' => 'File yang anda upload bukan gambar (jpg,jpeg,png)'
                ]
            ],
            'role' => 'required'
        ])) {
            return redirect()->to('/user/edit/'.$this->request->getVar('id_lama'))->withInput();
        }
        $avatarLama = $this->request->getVar('avatarLama');
        // ambil gambar
        $fileAvatar = $this->request->getFile('avatar');
        //cek ada foto atau tidak
        if($fileAvatar->getError() == 4){
            $namaAvatar = $avatarLama;
        }else{
            //generate nama photo random
            $namaAvatar = $fileAvatar->getRandomName();
            $fileAvatar->move('img',$namaAvatar);
            //hapus file lama
            unlink('img/'.$avatarLama);
        }

        $user = new \App\Entities\User();
        $user->id = $id;
        $user->username = $this->request->getVar('username');
        $user->password = $this->request->getVar('password');
        $user->email = $this->request->getVar('email');
        $user->name = $this->request->getVar('name');
        $user->avatar = $namaAvatar;
        $user->id_role = $this->request->getVar('role');

        $user->updated_by = $this->session->get('id');
        $user->updated_date = date("Y-m-d H:i:s");

        $this->userModel->save($user);

        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('/user');
    }
	//--------------------------------------------------------------------

}
