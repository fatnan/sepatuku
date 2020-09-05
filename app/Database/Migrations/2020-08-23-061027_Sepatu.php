<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sepatu extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'=>[
				'type'			=>'INT',
				'constraint'	=>11,
				'unsigned'		=>TRUE,
				'auto_increment'=>TRUE
			],
			'nama_sepatu'=>[
				'type' 			=> 'VARCHAR',
				'constraint'	=> '255'
			],
			'kode_sepatu' => [
				'type'			=>	'VARCHAR',
				'constraint'	=>	'255'
			],
			'harga'	=>[
				'type'			=>	'BIGINT'
			],
			'deskripsi'	=>[
				'type'			=> 'TEXT'
			],
			'id_kategori'	=>[
				'type'			=>	'INT',
				'constraint'	=>	'11',
				'unsigned'		=>	TRUE
			],
			'slug'	=>[
				'type'			=>	'VARCHAR',
				'constraint'	=>	'255'
			],
			'gambar'=>[
				'type'			=>	'VARCHAR',
				'constraint'	=>	'255'
			],
			'created_by'=>[
				'type' => 'INT',
				'constraint' => 11,
			],
			'created_at'=>[
				'type' => 'DATETIME',
			],
			'updated_by'=>[
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
			],
			'updated_at'=>[
				'type'=>'DATETIME',
				'null'=>TRUE,
			]
		]);

		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('id_kategori','kategori','id');
		$this->forge->createTable('sepatu');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('sepatu');
	}
}
