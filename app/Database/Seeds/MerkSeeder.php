<?php namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

class MerkSeeder extends \CodeIgniter\Database\Seeder
{
        public function run()
        {
                $data = [
                    [
                        'nama_merk'=> 'Adidas',
                        'logo'=> null,
                        'created_date'=> Time::now(),
                        'updated_date'=> Time::now()
                    ],
                    [
                        'nama_merk'=> 'Nike',
                        'logo'=> null,
                        'created_date'=> Time::now(),
                        'updated_date'=> Time::now()
                    ],
                ];
                
                // $faker = \Faker\Factory::create('id_ID');
                // for($i=0; $i<100;$i++){
                //     $data = [
                //         'nama'          => $faker->name,
                //         'alamat'        => $faker->address,
                //         'created_at'    => Time::createFromTimestamp($faker->unixTime()),
                //         'updated_at'    => Time::now()
                //     ];
                // }
                $this->db->table('merk')->insertBatch($data);
                
        }
}