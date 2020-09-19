<?php namespace App\Controllers;

use App\Models\SepatuModel;
use App\Models\SepatuKeluarModel;
use App\Models\MerkModel;
use App\Models\KategoriModel;
use App\Models\DetailSepatuModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SepatuKeluar extends BaseController
{
    protected $sepatuModel;
    public function __construct(){
        $this->session = session();
        $this->sepatuModel = new SepatuModel();
        $this->merkModel = new MerkModel();
        $this->kategoriModel = new KategoriModel();
        $this->sepatuKeluarModel = new SepatuKeluarModel();
        $this->detailSepatuModel = new DetailSepatuModel();
    }

    public function index()
	{
        $listMerk = $this->merkModel->getMerk();
        $listKategori = $this->kategoriModel->getKategori();
        $data = [
            'title' => 'Sepatu Keluar',
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'kategori' => $listKategori,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];

        $allsepatukeluar = $this->sepatuKeluarModel->getSepatuKeluar();
        $data['sepatukeluar']=$this->sepatuKeluarModel->sepatu($allsepatukeluar);
        
		return view('sepatukeluar/index',$data);
    }

    public function detail($id)
    {
        $listMerk = $this->merkModel->getMerk();
        $sepatu = $this->sepatuKeluarModel->getSepatuKeluar($id);
        $data = [
            'title' => $sepatu['nama_sepatu'],
            'sepatu' => $sepatu,
            'username' => ucfirst($this->session->get('username')),
            'merk' => $listMerk,
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        if(empty($data['sepatu'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sepatu '.$id.' tidak ditemukan.');
        }
        
        return view('sepatukeluar/detail',$data);
    }

    public function create()
    {
        $listMerk = $this->merkModel->getMerk();
        $listSepatu = $this->sepatuModel->getSepatu();
        $listSize = $this->sepatuKeluarModel->getSize();
        $listBatch = $this->sepatuKeluarModel->getBatch();
        $data=[
            'title' => 'Tambah Sepatu Keluar',
            'validation'=> \Config\Services::validation(),
            'merk' => $listMerk,
            'sepatu'=> $listSepatu,
            'listsize' => $listSize,
            'listbatch' => $listBatch,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        return view('sepatukeluar/create',$data);
    }

    public function store(){
        //validation
        if(!$this->validate([
            'merk' => 'required',
            'sepatu'    => 'required',
            'size'  => 'required|numeric|less_than[50]|greater_than[18]',
            'batch' => 'required',
            'stock' => 'required|numeric|greater_than[0]',
            'diskon' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'harga' => 'required|numeric',
            'waktu_transaksi'   =>'required',
            'keterangan' => 'required'
        ])) {
            return redirect()->to('/sepatukeluar/create')->withInput();
        }
        $sepatuKeluar= $this->request->getVar();
        $this->sepatuKeluarModel->save([
            'id_sepatu' => $sepatuKeluar['sepatu'],
            'total_harga'   => $sepatuKeluar['harga'],
            'size' => $sepatuKeluar['size'],
            'batch' => $sepatuKeluar['batch'],
            'stock' => $sepatuKeluar['stock'],
            'waktu_transaksi' => $sepatuKeluar['waktu_transaksi'],
            'created_at' => date('Y-m-d h:i:s'),
            'created_by' => $this->session->get('id'),
            'keterangan' => $sepatuKeluar['keterangan']
        ]);
        if($this->detailSepatuModel->where([
                'id_sepatu'=>$sepatuKeluar['sepatu'],
                'size'=>  $sepatuKeluar['size'],
                'batch'=>   $sepatuKeluar['batch']
            ])->first()){
            $detailSepatu=$this->detailSepatuModel->where([
                'id_sepatu'=>$sepatuKeluar['sepatu'],
                'size'=>  $sepatuKeluar['size'],
                'batch'=>$sepatuKeluar['batch']
                ])
                ->first();
            $this->detailSepatuModel->save([
                'id'=>$detailSepatu['id'],
                'stock'=>$detailSepatu['stock'] - $this->request->getVar('stock')
            ]);
        }else{
            $this->detailSepatuModel->save([
                'id_sepatu' => $sepatuKeluar['sepatu'],
                'size'  => $sepatuKeluar['size'],
                'stock'=> $sepatuKeluar['stock'],
                'batch' => $sepatuKeluar['batch'],
                'created_date' => date('Y-m-d h:i:s'),
            ]);
        }
        $sepatu = $this->sepatuModel->find($sepatuKeluar['sepatu']);
        $this->sepatuModel->save([
            'id'    => $sepatuKeluar['sepatu'],
            'stock'=> $sepatu['stock'] - $sepatuKeluar['stock']
        ]);
        

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/sepatukeluar');
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

    public function edit($id){
        $listMerk = $this->merkModel->getMerk();
        $listSepatu = $this->sepatuModel->getSepatu();
        $data=[
            'title' => 'Edit Sepatu Masuk',
            'validation'=> \Config\Services::validation(),
            'listsepatu' => $listSepatu,
            'sepatu' => $this->sepatuMasukModel->getSepatuMasuk($id),
            'merk' => $listMerk,
            'username' => ucfirst($this->session->get('username')),
            'roleId' => $this->session->get('role'),
            'user_login' => $this->session->get('user_login')
        ];
        
        $data['sepatu']['harga'] = $data['sepatu']['total_harga']/$data['sepatu']['stock'];
        return view('sepatumasuk/edit',$data);
    }

    public function update($id){
         //validation
         if(!$this->validate([
            'merk' => 'required',
            'sepatu'    => 'required',
            'size'  => 'required|numeric|less_than[50]|greater_than[18]',
            'harga' => 'required|numeric',
            'stock' => 'required|numeric',
            'waktu_transaksi'   =>'required'
        ])) {
            return redirect()->to('/sepatumasuk/edit/'.$id)->withInput();
        }
        $total_harga = $this->request->getVar('harga') * $this->request->getVar('stock');

        $this->sepatuMasukModel->save([
            'id' => $id,
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

        if(($this->request->getVar('sepatuLama') != $this->request->getVar('sepatu')) || 
        ($this->request->getVar('sizeLama') != $this->request->getVar('size')) || 
        ($this->request->getVar('stockLama') != $this->request->getVar('stock')) ){
             //hapus stock sebelumnya pada sepatu
             $sepatu = $this->sepatuModel->find($this->request->getVar('sepatuLama'));
             $this->sepatuModel->save([
                 'id'    => $this->request->getVar('sepatuLama'),
                 'stock'=> $sepatu['stock'] - $this->request->getVar('stockLama')
             ]);

            //hapus stock sebelumnya pada detail sepatu
            $detailSepatu=$this->detailSepatuModel->where(['id_sepatu'=>$this->request->getVar('sepatuLama'),'size'=>  $this->request->getVar('sizeLama')])->first();
            $this->detailSepatuModel->save([
                'id'=>$detailSepatu['id'],
                'stock'=>$detailSepatu['stock'] - $this->request->getVar('stockLama')
            ]);
            //add or update detail sepatu
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
            //update stock sepatu
            $sepatu = $this->sepatuModel->find($this->request->getVar('sepatu'));
            $this->sepatuModel->save([
                'id'    => $this->request->getVar('sepatu'),
                'stock'=> $sepatu['stock'] + $this->request->getVar('stock')
            ]);
        }

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/sepatumasuk');
    }

    public function export()
    {
        // ambil data transaction dari database
        $transactions = $this->sepatuKeluarModel->getExportSepatuKeluar();
        // panggil class Sreadsheet baru
        $spreadsheet = new Spreadsheet;
        // Buat custom header pada file excel
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Sepatu')
                    ->setCellValue('C1', 'Batch')
                    ->setCellValue('D1', 'Waktu Transaksi')
                    ->setCellValue('E1', 'Jumlah')
                    ->setCellValue('F1', 'Total Harga');
        // define kolom dan nomor
        $kolom = 2;
        $nomor = 1;
        // tambahkan data transaction ke dalam file excel
        foreach($transactions as $data) {
    
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $data['nama_sepatu'])
                        ->setCellValue('C' . $kolom, $data['batch'])
                        ->setCellValue('D' . $kolom, $data['waktu_transaksi'])
                        ->setCellValue('E' . $kolom, $data['stock'])
                        ->setCellValue('F' . $kolom, "Rp. ".number_format($data['total_harga']));
    
            $kolom++;
            $nomor++;
    
        }
        // download spreadsheet dalam bentuk excel .xlsx
        $writer = new Xlsx($spreadsheet);
    
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_Transaction.xlsx"');
        // header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
    }
    
	//--------------------------------------------------------------------

}
