<?php namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
        public function run()
        {
                $data = [
                    [
                        'username'          => 'admin',
                        'name'              => 'admin',
                        'email'             => 'admin@example.com',
                        'password'          => '5d5897e3366b0d7cb5cac1da484659cf',
                        'salt'              => '5f41e37b0530c1.92171397',
                        'avatar'            => 'avatar_default.jpg',
                        'id_role'              => '1',
                        'created_date'        => Time::now(),
                        'updated_date'        => Time::now()
                    ],
                    [
                        'username'          => 'fatnan',
                        'name'              => 'fatnan',
                        'email'             => 'fatnan@example.com',
                        'password'          => 'a84dfc35413ec9016c1ce319faa8c7df',
                        'salt'              => '5f41b3170f0ce4.02711449',
                        'avatar'            => 'avatar_default.jpg',
                        'id_role'              => '1',
                        'created_date'        => Time::now(),
                        'updated_date'        => Time::now()
                    ],
                    [
                        'username'          => 'ulfah',
                        'name'              => 'ulfah',
                        'email'             => 'ulfah@example.com',
                        'password'          => 'a84dfc35413ec9016c1ce319faa8c7df',
                        'salt'              => '5f41b3170f0ce4.02711449',
                        'avatar'            => 'avatar_default.jpg',
                        'id_role'              => '2',
                        'created_date'        => Time::now(),
                        'updated_date'        => Time::now()
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
                $this->db->table('user')->insertBatch($data);
                // $this->db->table('user')->insert($data);
                
        }
}