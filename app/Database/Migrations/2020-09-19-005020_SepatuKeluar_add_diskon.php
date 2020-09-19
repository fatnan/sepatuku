<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SepatuKeluarAddDiskon extends Migration
{
	public function up()
	{
		$fields = [
			'diskon' => [
				'type' => 'int',
				'constraint' => 11,
				'default'	=> 0
			]
		];
		$this->forge->addColumn('sepatukeluar',$fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$forge->dropColumn('sepatukeluar', 'diskon');
	}
}
