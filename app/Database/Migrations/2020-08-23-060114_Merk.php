<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Merk extends Migration
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
			'nama_merk'=>[
				'type' 			=> 'VARCHAR',
				'constraint'	=> '255'
			],
			'logo'=>[
				'type'			=>	'VARCHAR',
				'constraint'	=>	'255',
				'null'			=>	TRUE
			],
			'created_date'=>[
				'type' 			=> 'DATETIME',
				'null'			=>	TRUE
			],
			'updated_date'=>[
				'type'			=>	'DATETIME',
				'null'			=>	TRUE,
			]
		]);

		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('merk');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('merk');
	}
}
