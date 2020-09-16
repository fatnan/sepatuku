<?php namespace App\Controllers;

use App\Models\SepatuModel;
use App\Models\SepatuMasukModel;
use App\Models\MerkModel;
use App\Models\KategoriModel;
use App\Models\DetailSepatuModel;

class SepatuMasuk extends BaseController
{
    protected $sepatuModel;
    public function __construct(){
        $this->session = session();
        $this->sepatuModel = new SepatuModel();
        $this->merkModel = new MerkModel();
        $this->kategoriModel = new KategoriModel();
        $this->sepatuMasukModel = new SepatuMasukModel();
        $this->detailSepatuModel = new DetailSepatuModel();
    }

    public function index()
	{
        $listMerk = $this->merkModel->getMerk();
        $listKategori = $this->kategoriModel->getKategori();
        $data = [
            'title' => 'Sepatu Masuk',
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'kategori' => $listKategori,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];

        $allsepatumasuk = $this->sepatuMasukModel->getSepatuMasuk();
        $data['sepatumasuk']=$this->sepatuMasukModel->sepatu($allsepatumasuk);
        
		return view('sepatumasuk/index',$data);
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
        return view('sepatu/detail',$data);
    }

    public function create()
    {
        $listMerk = $this->merkModel->getMerk();
        $listSepatu = $this->sepatuModel->getSepatu();
        $data=[
            'title' => 'Tambah Sepatu Masuk',
            'validation'=> \Config\Services::validation(),
            'merk' => $listMerk,
            'sepatu'=> $listSepatu,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        // dd($data);
        return view('sepatumasuk/create',$data);
    }

    public function store(){
        //validation
        if(!$this->validate([
            'merk' => 'required',
            'sepatu'    => 'required',
            'size'  => 'required|numeric|less_than[50]',
            'harga' => 'required|numeric',
            'stock' => 'required|numeric',
            'waktu_transaksi'   =>'required'
        ])) {
            return redirect()->to('/sepatumasuk/create')->withInput();

            // $validation = \Config\Services::validation();
            // return redirect()->to('/sepatu/create')->withInput()->with('validation',$validation);
            // $data['validation']=$validation;
            // return view('/sepatu/create',$data);
        }
        $total_harga = $this->request->getVar('harga') * $this->request->getVar('stock');

        $this->sepatuMasukModel->save([
            'id_sepatu' => $this->request->getVar('sepatu'),
            'total_harga'   => $total_harga,
            'size' => $this->request->getVar('size'),
            'stock' => $this->request->getVar('stock'),
            'waktu_transaksi' => $this->request->getVar('waktu_transaksi'),
            'created_at' => date('Y-m-d h:i:s'),
            'created_by' => $this->session->get('id'),
        ]);
        
        $month=date("m",strtotime($this->request->getVar('waktu_transaksi')));
        $year=date("Y",strtotime($this->request->getVar('waktu_transaksi')));
        if($month <= 3) {
            $batch = "1-".$year;
        }
        else if($month <= 6 ) {
            $batch = "2-".$year;
        } else{
            $batch = "3-".$year;
        }

        if($this->detailSepatuModel->where([
                'id_sepatu'=>$this->request->getVar('sepatu'),
                'size'=>  $this->request->getVar('size'),
                'batch'=>   $batch
            ])->first()){
            $detailSepatu=$this->detailSepatuModel->where(['id_sepatu'=>$this->request->getVar('sepatu'),'size'=>  $this->request->getVar('size')])->first();
            $this->detailSepatuModel->save([
                'id'=>$detailSepatu['id'],
                'stock'=>$detailSepatu['stock'] + $this->request->getVar('stock')
            ]);
        }else{
            $this->detailSepatuModel->save([
                'id_sepatu' => $this->request->getVar('sepatu'),
                'size'  => $this->request->getVar('size'),
                'stock'=> $this->request->getVar('stock'),
                'batch' => $batch,
                'created_date' => date('Y-m-d h:i:s'),
            ]);
        }
        $sepatu = $this->sepatuModel->find($this->request->getVar('sepatu'));
        $this->sepatuModel->save([
            'id'    => $this->request->getVar('sepatu'),
            'stock'=> $sepatu['stock'] + $this->request->getVar('stock')
        ]);
        

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/sepatumasuk');
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
        $data=[
            'title' => 'Edit Sepatu',
            'validation'=> \Config\Services::validation(),
            'sepatu' => $this->sepatuModel->getSepatu($slug),
            'merk' => $listMerk,
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
            unlink('img/'.$photoLama);
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
