<?php namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\MerkModel;

class Barang extends BaseController
{
    protected $barangModel;
    public function __construct(){
        $this->barangModel = new barangModel();
        $this->merkModel = new MerkModel();
    }

    public function index()
	{
        $data = [
            'title' => 'Barang'
        ];

        // cara konek db tanpa model
        // $db = \Config\Database::connect();
        // $barang = $db->query("SELECT * FROM barang");
        // foreach($barang->getResultArray() as $row){
        //     d($row);
        // }

        $data['barang'] = $this->barangModel->getBarang();
		return view('barang/index',$data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Barang',
            'barang' => $this->barangModel->getBarang($slug),
        ];
        if(empty($data['barang'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang '.$slug.' tidak ditemukan.');
        }
        return view('barang/detail',$data);
    }

    public function create()
    {
        $listMerk = $this->merkModel->getMerk();
        $data=[
            'title' => 'Tambah Barang',
            'validation'=> \Config\Services::validation(),
            'merk' => $listMerk
        ];
        // dd($data);
        return view('barang/create',$data);
    }

    public function store(){
        //validation
        if(!$this->validate([
            'nama_barang' => [
                'rules' => 'required|min_length[3]|is_unique[barang.nama_barang]',
                'errors' => [
                    // 'required' => '{field} nama barang harus diisi.',
                    'required' => 'Nama barang harus diisi.',
                    'is_unique' => 'Nama barang sudah terdaftar'
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
            return redirect()->to('/barang/create')->withInput();

            // $validation = \Config\Services::validation();
            // return redirect()->to('/barang/create')->withInput()->with('validation',$validation);
            // $data['validation']=$validation;
            // return view('/barang/create',$data);
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

        $slug = url_title($this->request->getVar('nama_barang'),'-',true);
        $barang = $this->request->getVar();
        $merk = $barang['merk'];
        $kode=$this->barangModel->getIdBarang();
        $kode_table = false;
        //generate kode barang
        while(!$kode_table){
            $kode++;
            if($kode < 10){
                $kode_gen = "000".$kode;
            } elseif($kode<100){
                $kode_gen = "00".$kode;
            } else{
                $kode_gen = "0".$kode;
            }
            $kode_barang = strtoupper($merk[0])."-".$kode_gen;
            if($this->barangModel->getKodeBarang($kode_barang)){
                $kode_table = true;
            }
        }
        $this->barangModel->save([
            'nama_barang' => $barang['nama_barang'],
            'kode_barang' => $kode_barang,
            'harga' => $barang['harga'],
            'deskripsi' => $barang['deskripsi'],
            'merk' => $merk,
            'slug' => $slug,
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/barang');
    }

    public function delete($id){
        //cari gambar berdasasrkan id
        $barang = $this->barangModel->find($id);
        // delete gambar
        if($barang['gambar'] != 'default.png'){
            unlink('img/'.$barang['gambar']);
        }
        $this->barangModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/barang');
    }

    public function edit($slug){
        $listMerk = $this->merkModel->getMerk();
        $data=[
            'title' => 'Edit Barang',
            'validation'=> \Config\Services::validation(),
            'barang' => $this->barangModel->getBarang($slug),
            'merk' => $listMerk
        ];
        
        return view('barang/edit',$data);
    }

    public function update($id){
        $barangLama = $this->barangModel->getBarang($this->request->getVar('slug'));
        if($barangLama['nama_barang'] == $this->request->getVar('nama_barang')){
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|min_length[3]|is_unique[barang.nama_barang]';
        }
        //validation
        if(!$this->validate([
            'nama_barang' => [
                'rules' => $rule_nama,
                'errors' => [
                    // 'required' => '{field} nama barang harus diisi.',
                    'required' => 'Nama barang harus diisi.',
                    'is_unique' => 'Nama barang sudah terdaftar'
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
            return redirect()->to('/barang/create')->withInput();
            // $validation = \Config\Services::validation();
            // return redirect()->to('/barang/edit/'.$this->request->getVar('slug'))->withInput()->with('validation',$validation);
            // $data['validation']=$validation;
            // return view('/barang/edit/'.$this->request->getVar('slug'),$data);
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
            unlink('img/'.$photoLama);
        }

        $slug = url_title($this->request->getVar('nama_barang'),'-',true);
        $barang = $this->request->getVar();
        $merk = $barang['merk'];
        $kode=$this->barangModel->getIdBarang()+1;
        //generate kode barang
        if($kode < 10){
            $kode = "000".$kode;
        } elseif($kode<100){
            $kode = "00".$kode;
        } else{
            $kode = "0".$kode;
        }
        $kode_barang = strtoupper($merk[0])."-".$kode;
        
        $this->barangModel->save([
            'id' => $id,        //untuk menandakan edit
            'nama_barang' => $barang['nama_barang'],
            'kode_barang' => $kode_barang,
            'harga' => $barang['harga'],
            'deskripsi' => $barang['deskripsi'],
            'merk' => $merk,
            'slug' => $slug,
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('/barang');
    }
    
	//--------------------------------------------------------------------

}
