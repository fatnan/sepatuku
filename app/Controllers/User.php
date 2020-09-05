<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KategoriModel;


class User extends BaseController
{
    protected $orangModel;
    public function __construct(){
        $this->session = session();
        $this->userModel = new UserModel();
        $this->kategoriModel = new KategoriModel();
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
            // 'orang' => $this->userModel->findAll()
            'user' => $user->paginate($data_perpage,'user'),
            'pager' => $this->userModel->pager,
            'current_page' => $currentPage,
            'data_perpage' => $data_perpage,
            'username' => ucfirst($this->session->get('username')),
            'kategori'  => $this->listKategori
        ];

		return view('user/index',$data);
    }
    
    public function create()
    {
        $listKategori = $this->kategoriModel->getKategori();
        $data=[
            'title' => 'Tambah User',
            'validation'=> \Config\Services::validation(),
            'kategori' => $listKategori,
            'username' => ucfirst($this->session->get('username'))
        ];
        
        return view('user/create',$data);
    }
	//--------------------------------------------------------------------

}
