<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SepatuKeluarAddBatch extends Migration
{
	public function up()
	{
		$fields = [
			'batch' => [
				'type' => 'varchar',
				'constraint' => 255
			]
		];
		$this->forge->addColumn('sepatukeluar',$fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$forge->dropColumn('sepatukeluar', 'batch');
	}
}
