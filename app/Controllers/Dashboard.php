<?php namespace App\Controllers;

use App\Models\SepatuModel;
use App\Models\MerkModel;
use App\Models\KategoriModel;
use App\Models\SepatuMasukModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $sepatuModel;
    public function __construct(){
        $this->session = session();
        $this->sepatuModel = new SepatuModel();
        $this->merkModel = new MerkModel();
        $this->kategoriModel = new KategoriModel();
        $this->sepatuMasukModel = new SepatuMasukModel();
        $this->userModel = new UserModel();
    }

    public function index()
	{
        $listMerk = $this->merkModel->getMerk();
        $listKategori = $this->kategoriModel->getKategori();

        $data = [
            'title' => 'Dashboard',
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'kategori' => $listKategori,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login'),
            'countSepatu' => $this->sepatuModel->countAllSepatu(),
            'countMerk' => $this->merkModel->countAllMerk(),
            'countKategori' => $this->kategoriModel->countAllKategori(),
            'countUser' => $this->userModel->countAllUser(),
        ];
        
		return view('dashboard/index',$data);
    }
}