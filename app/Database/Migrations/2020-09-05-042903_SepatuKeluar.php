<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SepatuKeluar extends Migration
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
			'id_sepatu' => [
				'type'			=>	'VARCHAR',
				'constraint'	=>	'255'
			],
			'total_harga'	=>[
				'type'			=>	'BIGINT'
			],
			'slug'	=>[
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
		$this->forge->addForeignKey('id_sepatu','sepatu','id');
		$this->forge->createTable('sepatuMasuk');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('sepatuMasuk');
	}
}
