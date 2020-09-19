<?php namespace App\Controllers;

use App\Models\SepatuModel;
use App\Models\MerkModel;
use App\Models\KategoriModel;
use App\Models\SepatuMasukModel;

class Kategori extends BaseController
{
    protected $sepatuModel;
    public function __construct(){
        $this->session = session();
        $this->sepatuModel = new SepatuModel();
        $this->merkModel = new MerkModel();
        $this->kategoriModel = new KategoriModel();
        $this->sepatuMasukModel = new SepatuMasukModel();
    }

    public function index()
	{
        $data = [
            'title' => 'Kategori',
            'username' => ucfirst($this->session->get('username')),
            'kategori' => $this->kategoriModel->getKategori(),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        //search
        $keyword = $this->request->getVar('keyword');
        
		return view('kategori/index',$data);
    }

    public function detail($slug)
    {
        $listMerk = $this->merkModel->getMerk();
        $sepatu = $this->sepatuModel->getSepatu($slug);
        $data = [
            'title' => $sepatu['nama_sepatu'],
            'sepatu' => $sepatu,
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        if(empty($data['sepatu'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sepatu '.$slug.' tidak ditemukan.');
        }
        return view('sepatu/detail',$data);
    }

    public function create()
    {
        $data=[
            'title' => 'Tambah Kategori',
            'validation'=> \Config\Services::validation(),
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        return view('kategori/create',$data);
    }

    public function store(){
        //validation
        if(!$this->validate([
            'nama_kategori' => [
                'rules' => 'required|min_length[3]|is_unique[kategori.nama_kategori]',
                'errors' => [
                    // 'required' => '{field} nama sepatu harus diisi.',
                    'required' => 'Nama kategori harus diisi.',
                    'is_unique' => 'Nama kategori sudah terdaftar'
                ]
            ]
            // 'stock' => 'required|numeric'
        ])) {
            return redirect()->to('/kategori/create')->withInput();
        }
        
        $kategoriBaru=$this->kategoriModel->save([
            'nama_kategori' => $this->request->getVar('nama_kategori'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/kategori');
    }

    public function delete($id){
        //cari gambar berdasasrkan id
        $kategori = $this->kategoriModel->find($id);
        $this->kategoriModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/kategori');
    }

    public function edit($id){
        $listKategori = $this->kategoriModel->getKategori($id);
        $data=[
            'title' => 'Edit Kategori',
            'validation'=> \Config\Services::validation(),
            'kategori' => $listKategori,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        return view('kategori/edit',$data);
    }

    public function update($id){
        $kategoriLama = $this->kategoriModel->getKategori($id);
        if($kategoriLama['nama_kategori'] == $this->request->getVar('nama_kategori')){
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|min_length[3]|is_unique[kategori.nama_kategori]';
        }
        //validation
        if(!$this->validate([
            'nama_kategori' => [
                'rules' => $rule_nama,
                'errors' => [
                    // 'required' => '{field} nama sepatu harus diisi.',
                    'required' => 'Nama kategori harus diisi.',
                    'is_unique' => 'Nama kategori sudah terdaftar'
                ]
            ],
        ])) {
            return redirect()->to('/kategori/edit/'.$id)->withInput();
        }
        
        $this->kategoriModel->save([
            'id' => $id,        //untuk menandakan edit
            'nama_kategori' => $this->request->getVar('nama_kategori'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('/kategori');
    }
    
	//--------------------------------------------------------------------

}
