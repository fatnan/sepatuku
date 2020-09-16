<?php namespace App\Database\Seeds;

class AllSeeder extends \CodeIgniter\Database\Seeder
{
        public function run()
        {
                $this->call('MerkSeeder');
                $this->call('KategoriSeeder');
                $this->call('RoleSeeder');
                $this->call('UserSeeder');
        }
}