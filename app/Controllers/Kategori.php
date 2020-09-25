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
            'merk' => $this->merkModel->getMerk(),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login'),
            'yesKategori' => true
        ];
        
        //search
        $keyword = $this->request->getVar('keyword');
        
		return view('kategori/index',$data);
    }

    public function detail($id)
    {
        $listMerk = $this->merkModel->getMerk();
        $sepatu = $this->sepatuModel->getSepatuPerKategori($id);
        $kategoriNow = $this->kategoriModel->getKategori($id);
        $listKategori = $this->kategoriModel->getKategori();
        $data = [
            'title' => $kategoriNow['nama_kategori'],
            'sepatu' => $sepatu,
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'kategori' => $listKategori,
            'kategoriNow' => $kategoriNow,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login'),
            'yesKategori' => true
        ];
        if(empty($data['kategoriNow'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori '.$id.' tidak ditemukan.');
        }
        return view('kategori/detail',$data);
    }
    public function create()
    {
        $data=[
            'title' => 'Tambah Kategori',
            'merk' => $this->merkModel->getMerk(),
            'validation'=> \Config\Services::validation(),
            'kategori' => $this->kategoriModel->getKategori(),
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
        $sepatu = $this->sepatuModel->getSepatuPerKategori($id);
        if($sepatu){
            session()->setFlashdata('pesan', 'Data tidak dapat dihapus karena masih ada sepatu');    
        } else {
            $this->kategoriModel->delete($id);
            session()->setFlashdata('pesan', 'Data berhasil dihapus');
        }
        return redirect()->to('/kategori');
    }

    public function edit($id){
        $listKategori = $this->kategoriModel->getKategori();
        $kategoriNow = $this->kategoriModel->getKategori($id);
        $data=[
            'title' => 'Edit Kategori',
            'validation'=> \Config\Services::validation(),
            'kategoriNow' => $kategoriNow,
            'kategori'  => $listKategori,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login'),
            'merk' => $this->merkModel->getMerk(),
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
