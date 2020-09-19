<?php namespace App\Controllers;

use App\Models\SepatuModel;
use App\Models\MerkModel;
use App\Models\KategoriModel;
use App\Models\SepatuMasukModel;

class Merk extends BaseController
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
        $listMerk = $this->merkModel->getMerk();
        $data = [
            'title' => 'Merk',
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        //search
        $keyword = $this->request->getVar('keyword');
        
		return view('merk/index',$data);
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
        $listMerk = $this->merkModel->getMerk();
        $listKategori = $this->kategoriModel->getKategori();
        $data=[
            'title' => 'Tambah Merk',
            'validation'=> \Config\Services::validation(),
            'merk' => $listMerk,
            'kategori'  => $listKategori,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        // dd($data);
        return view('merk/create',$data);
    }

    public function store(){
        //validation
        if(!$this->validate([
            'nama_merk' => [
                'rules' => 'required|min_length[3]|is_unique[merk.nama_merk]',
                'errors' => [
                    // 'required' => '{field} nama sepatu harus diisi.',
                    'required' => 'Nama merk harus diisi.',
                    'is_unique' => 'Nama merk sudah terdaftar'
                ]
            ],
            'photo' => [
                'rules' => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => 'Pilih gambar terlebih dahulu',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'File yang anda upload bukan gambar',
                    'mime_in' => 'File yang anda upload bukan gambar (jpg,jpeg,png)'
                ]
            ],
            // 'stock' => 'required|numeric'
        ])) {
            return redirect()->to('/merk/create')->withInput();
        }
        // dd($this->request->getVar());
        // ambil gambar
        $filePhoto = $this->request->getFile('photo');
        //cek ada foto atau tidak
        if($filePhoto->getError() == 4){
            $namaGambar = 'default_logo.jpg';
        }else{
            //generate nama photo random
            $namaGambar = $filePhoto->getRandomName();
            $filePhoto->move('img',$namaGambar);
        }
        
        $merkBaru=$this->merkModel->save([
            'nama_merk' => $this->request->getVar('nama_merk'),
            'logo' => $namaGambar,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/merk');
    }

    public function delete($id){
        //cari gambar berdasasrkan id
        $merk = $this->merkModel->find($id);
        // delete gambar
        if($merk['logo'] != 'default_logo.jpg'){
            unlink('img/'.$merk['logo']);
        }
        $this->merkModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/merk');
    }

    public function edit($id){
        $listMerk = $this->merkModel->getMerk($id);
        $data=[
            'title' => 'Edit Merk',
            'validation'=> \Config\Services::validation(),
            'merk' => $listMerk,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        return view('merk/edit',$data);
    }

    public function update($id){
        $merkLama = $this->merkModel->getMerk($id);
        if($merkLama['nama_merk'] == $this->request->getVar('nama_merk')){
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|min_length[3]|is_unique[merk.nama_merk]';
        }
        //validation
        if(!$this->validate([
            'nama_merk' => [
                'rules' => $rule_nama,
                'errors' => [
                    // 'required' => '{field} nama sepatu harus diisi.',
                    'required' => 'Nama merk harus diisi.',
                    'is_unique' => 'Nama merk sudah terdaftar'
                ]
            ],
            'photo' => [
                'rules' => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => 'Pilih gambar terlebih dahulu',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'File yang anda upload bukan gambar',
                    'mime_in' => 'File yang anda upload bukan gambar (jpg,jpeg,png)'
                ]
            ]
        ])) {
            return redirect()->to('/merk/edit/'.$id)->withInput();
        }
        $photoLama = $this->request->getVar('photoLama');
        // ambil gambar
        $filePhoto = $this->request->getFile('photo');
        //cek ada foto atau tidak
        if($filePhoto->getError() == 4){
            $namaGambar = $photoLama;
        }else{
            //generate nama photo random
            $namaGambar = $filePhoto->getRandomName();
            $filePhoto->move('img',$namaGambar);
            //hapus file lama
            if($photoLama != 'default_logo.jpg'){
                unlink('img/'.$photoLama);
            }
        }
        
        $this->merkModel->save([
            'id' => $id,        //untuk menandakan edit
            'nama_merk' => $this->request->getVar('nama_merk'),
            'logo' => $namaGambar,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('/merk');
    }
    
	//--------------------------------------------------------------------

}
