<?php namespace App\Controllers;

use App\Models\OrangModel;
use App\Models\MerkModel;


class Orang extends BaseController
{
    protected $orangModel;
    public function __construct(){
        $this->session = session();
        $this->orangModel = new OrangModel();
        $this->merkModel = new MerkModel();
        $this->listMerk = $this->merkModel->getMerk();
    }

    public function index()
	{
        //pagination
        $data_perpage = 5;
        $currentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1 ;
        //search
        $keyword = $this->request->getVar('keyword');
        if($keyword){
            $orang = $this->orangModel->search($keyword);
        } else{
            $orang = $this->orangModel;
        }
        $data = [
            'title' => 'Orang',
            // 'orang' => $this->orangModel->findAll()
            'orang' => $orang->paginate($data_perpage,'orang'),
            'pager' => $this->orangModel->pager,
            'current_page' => $currentPage,
            'data_perpage' => $data_perpage,
            'username' => ucfirst($this->session->get('username')),
            'merk'  => $this->listMerk
        ];
        
		return view('orang/index',$data);
    }    
	//--------------------------------------------------------------------

}
