<?php namespace App\Controllers;

use App\Models\SepatuModel;
use App\Models\MerkModel;
use App\Models\KategoriModel;
use App\Models\SepatuMasukModel;

class Sepatu extends BaseController
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
        $listKategori = $this->kategoriModel->getKategori();
        $data = [
            'title' => 'Sepatu',
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'kategori' => $listKategori,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        // cara konek db tanpa model
        // $db = \Config\Database::connect();
        // $sepatu = $db->query("SELECT * FROM sepatu");
        // foreach($sepatu->getResultArray() as $row){
        //     d($row);
        // }
        
        //search
        $keyword = $this->request->getVar('keyword');
        if($keyword){
            $data['sepatu'] = $this->sepatuModel->search($keyword)->find();
        } else{
            $data['sepatu'] = $this->sepatuModel->getSepatu();
        }
        
		return view('sepatu/index',$data);
    }

    public function detail($slug)
    {
        $listMerk = $this->merkModel->getMerk();
        $sepatu = $this->sepatuModel->getSepatu($slug);
        $listKategori = $this->kategoriModel->getKategori();
        $data = [
            'title' => $sepatu['nama_sepatu'],
            'sepatu' => $sepatu,
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'kategori' => $listKategori,
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
            'title' => 'Tambah Sepatu',
            'validation'=> \Config\Services::validation(),
            'merk' => $listMerk,
            'kategori'  => $listKategori,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        // dd($data);
        return view('sepatu/create',$data);
    }

    public function store(){
        //validation
        if(!$this->validate([
            'nama_sepatu' => [
                'rules' => 'required|min_length[3]|is_unique[sepatu.nama_sepatu]',
                'errors' => [
                    // 'required' => '{field} nama sepatu harus diisi.',
                    'required' => 'Nama sepatu harus diisi.',
                    'is_unique' => 'Nama sepatu sudah terdaftar'
                ]
            ],
            'harga' => 'required|numeric',
            'merk' => 'required',
            'deskripsi' => 'required',
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
            return redirect()->to('/sepatu/create')->withInput();
        }

        // ambil gambar
        $filePhoto = $this->request->getFile('photo');
        //cek ada foto atau tidak
        if($filePhoto->getError() == 4){
            $namaGambar = 'default.png';
        }else{
            //generate nama photo random
            $namaGambar = $filePhoto->getRandomName();
            $filePhoto->move('img',$namaGambar);
        }

        // $namaGambar = $filePhoto->getName();

        $slug = url_title($this->request->getVar('nama_sepatu'),'-',true);
        $sepatu = $this->request->getVar();
        $id_merk = $sepatu['merk'];
        $merk_tabel = $this->merkModel->find($id_merk);
        $merk = $merk_tabel['nama_merk'];
        $kode=$this->sepatuModel->getIdSepatu();
        $kode_table = false;
        //generate kode sepatu
        while(!$kode_table){
            $kode++;
            if($kode < 10){
                $kode_gen = "000".$kode;
            } elseif($kode<100){
                $kode_gen = "00".$kode;
            } else{
                $kode_gen = "0".$kode;
            }
            $kode_sepatu = strtoupper($merk[0])."-".$kode_gen;
            if($this->sepatuModel->getKodeSepatu($kode_sepatu)){
                $kode_table = true;
            }
        }
        
        $sepatuBaru=$this->sepatuModel->save([
            'nama_sepatu' => $sepatu['nama_sepatu'],
            'kode_sepatu' => $kode_sepatu,
            'harga' => $sepatu['harga'],
            'deskripsi' => $sepatu['deskripsi'],
            'id_merk' => $id_merk,
            'id_kategori'   => $sepatu['kategori'],
            'slug' => $slug,
            'gambar' => $namaGambar,
            'created_by' => $this->session->get('id'),
            // 'stock' => $sepatu['stock']
        ]);

        
        // $this->sepatuMasukModel->save([
        //     'id_sepatu' => $sepatuBaru['id'],
        //     'total_harga'   => $sepatuBaru['stock'] * $sepatuBaru['harga'],
        //     'waktu_transaksi'   => $sepatuBaru['created_at'],
        // ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/sepatu');
    }

    public function delete($id){
        //cari gambar berdasasrkan id
        $sepatu = $this->sepatuModel->find($id);
        // delete gambar
        if($sepatu['gambar'] != 'default.png'){
            unlink('img/'.$sepatu['gambar']);
        }
        $this->sepatuModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/sepatu');
    }

    public function edit($slug){
        $listMerk = $this->merkModel->getMerk();
        $listKategori = $this->kategoriModel->getKategori();
        $data=[
            'title' => 'Edit Sepatu',
            'validation'=> \Config\Services::validation(),
            'sepatu' => $this->sepatuModel->getSepatu($slug),
            'merk' => $listMerk,
            'kategori' => $listKategori,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        return view('sepatu/edit',$data);
    }

    public function update($id){
        $sepatuLama = $this->sepatuModel->getSepatu($this->request->getVar('slug'));
        if($sepatuLama['nama_sepatu'] == $this->request->getVar('nama_sepatu')){
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|min_length[3]|is_unique[sepatu.nama_sepatu]';
        }
        //validation
        if(!$this->validate([
            'nama_sepatu' => [
                'rules' => $rule_nama,
                'errors' => [
                    // 'required' => '{field} nama sepatu harus diisi.',
                    'required' => 'Nama sepatu harus diisi.',
                    'is_unique' => 'Nama sepatu sudah terdaftar'
                ]
            ],
            'harga' => 'required|numeric',
            'merk' => 'required',
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
            return redirect()->to('/sepatu/edit/'.$this->request->getVar('slug'))->withInput();
            // $validation = \Config\Services::validation();
            // return redirect()->to('/sepatu/edit/'.$this->request->getVar('slug'))->withInput()->with('validation',$validation);
            // $data['validation']=$validation;
            // return view('/sepatu/edit/'.$this->request->getVar('slug'),$data);
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
            if($photoLama != 'default.png'){
                unlink('img/'.$photoLama);
            }
        }

        $slug = url_title($this->request->getVar('nama_sepatu'),'-',true);
        $sepatu = $this->request->getVar();
        $id_merk = $sepatu['merk'];
        $merk_tabel = $this->merkModel->find($id_merk);
        $merk = $merk_tabel['nama_merk'];
        $kode=$this->sepatuModel->getIdSepatu()+1;
        //generate kode sepatu
        if($kode < 10){
            $kode = "000".$kode;
        } elseif($kode<100){
            $kode = "00".$kode;
        } else{
            $kode = "0".$kode;
        }
        $kode_sepatu = strtoupper($merk[0])."-".$kode;
        
        $this->sepatuModel->save([
            'id' => $id,        //untuk menandakan edit
            'nama_sepatu' => $sepatu['nama_sepatu'],
            'kode_sepatu' => $kode_sepatu,
            'harga' => $sepatu['harga'],
            'deskripsi' => $sepatu['deskripsi'],
            'id_merk' => $id_merk,
            'slug' => $slug,
            'gambar' => $namaGambar,
            'updated_by' => $this->session->get('id')
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('/sepatu');
    }
    
	//--------------------------------------------------------------------

}
