<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SepatuKeluarChangeStatusToKeterangan extends Migration
{
	public function up()
	{
		$fields = [
			'status' => [
				'name' => 'keterangan',
				'type' => 'varchar',
				'constraint' => 255
			]
		];
		$this->forge->modifyColumn('sepatukeluar',$fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$fields = [
			'keterangan' => [
				'name' => 'status',
				'type' => 'varchar',
				'constraint' => 255
			]
		];
		$this->forge->modifyColumn('sepatukeluar',$fields);
	}
}
