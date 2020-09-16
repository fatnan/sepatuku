<?php namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

class KategoriSeeder extends \CodeIgniter\Database\Seeder
{
        public function run()
        {
                $data = [
                    [
                        'nama_kategori'=> 'Sepatu Lari',
                        'created_date'=> Time::now(),
                        'updated_date'=> Time::now()
                    ],
                    [
                        'nama_kategori'=> 'Sepatu Futsal',
                        'created_date'=> Time::now(),
                        'updated_date'=> Time::now()
                    ],
                    [
                        'nama_kategori'=> 'Sepatu Casual',
                        'created_date'=> Time::now(),
                        'updated_date'=> Time::now()
                    ],
                    [
                        'nama_kategori'=> 'Sepatu Pria',
                        'created_date'=> Time::now(),
                        'updated_date'=> Time::now()
                    ],
                    [
                        'nama_kategori'=> 'Sepatu Wanita',
                        'created_date'=> Time::now(),
                        'updated_date'=> Time::now()
                    ],
                ];
                
                $this->db->table('kategori')->insertBatch($data);
                
        }
}