<?php namespace App\Controllers;

use App\Models\SepatuModel;

class Sepatu extends BaseController
{
    protected $sepatuModel;
    public function __construct(){
        $this->sepatuModel = new SepatuModel();
    }

    public function index()
	{
        $data = [
            'title' => 'Sepatu'
        ];

        // cara konek db tanpa model
        // $db = \Config\Database::connect();
        // $sepatu = $db->query("SELECT * FROM sepatu");
        // foreach($sepatu->getResultArray() as $row){
        //     d($row);
        // }

        $data['sepatu'] = $this->sepatuModel->getSepatu();
		return view('sepatu/index',$data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'sepatu' => $this->sepatuModel->getSepatu($slug),
        ];
        return view('sepatu/detail',$data);
    }

    public function create()
    {
        $data=[
            'title' => 'Tambah Sepatu'
        ];

        return view('sepatu/create',$data);
    }
    
	//--------------------------------------------------------------------

}
