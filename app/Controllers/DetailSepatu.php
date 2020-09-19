<?php namespace App\Controllers;

use App\Models\SepatuModel;
use App\Models\MerkModel;
use App\Models\KategoriModel;
use App\Models\DetailSepatuModel;

class DetailSepatu extends BaseController
{
    protected $sepatuModel;
    public function __construct(){
        $this->session = session();
        $this->sepatuModel = new SepatuModel();
        $this->merkModel = new MerkModel();
        $this->kategoriModel = new KategoriModel();
        $this->detailsepatuModel = new DetailSepatuModel();
    }

    public function index()
	{
        $listMerk = $this->merkModel->getMerk();
        $data = [
            'title' => 'Detail Sepatu',
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        //search
        // $keyword = $this->request->getVar('keyword');
        // if($keyword){
            // $data['detailsepatu'] = $this->detailsepatuModel->search($keyword)->find();
        // } else{
            $data['sepatu'] = $this->detailsepatuModel->getAllDetailSepatu();
        // }
        
		return view('detailsepatu/index',$data);
    }

    public function detail($slug)
    {
        $listMerk = $this->merkModel->getMerk();
        $data = [
            'title' => 'Detail Sepatu',
            'sepatu' => $this->sepatuModel->getSepatu($slug),
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        if(empty($data['sepatu'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sepatu '.$slug.' tidak ditemukan.');
        }
        return view('detailsepatu/detail',$data);
    }
	//--------------------------------------------------------------------

}
