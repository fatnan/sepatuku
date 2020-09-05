<?php namespace App\Database\Migrations; 

class Role extends \CodeIgniter\Database\Migration{

	public function up(){
		$this->forge->addField([
			'id'=>[
				'type'=>'INT',
				'constraint'=>11,
				'unsigned'=>TRUE,
				'auto_increment'=>TRUE
			],
			'role'=>[
				'type'=>'VARCHAR',
				'constraint'=>'255',
			],
			'previlege'=>[
				'type'=>'VARCHAR',
				'constraint'=>'255',
				'null'=>TRUE
			],
			'created_date'=>[
				'type' => 'DATETIME',
				'null' =>TRUE,
			],
			'updated_date'=>[
				'type'=>'DATETIME',
				'null'=>TRUE,
			]
		]);

		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('role');
	}

	public function down(){
		$this->forge->dropTable('role');
	}
}
?>