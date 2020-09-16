<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailSepatu extends Migration
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
			'id_sepatu'=>[
				'type' 			=> 'INT',
				'constraint'	=> '255',
				'unsigned'		=>	TRUE

			],
			'size'=>[
				'type'			=>	'VARCHAR',
				'constraint'	=>	'255',
			],
			'stock'=>[
				'type'			=> 'INT',
				'constraint'	=> 11
			],
			'batch'=>[
				'type'			=> 'VARCHAR',
				'constraint'	=> '255'
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
		$this->forge->addForeignKey('id_sepatu','sepatu','id');
		$this->forge->createTable('detailsepatu');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('detailsepatu');
	}
}
