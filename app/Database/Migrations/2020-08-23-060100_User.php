<?php namespace App\Database\Migrations; 

class User extends \CodeIgniter\Database\Migration{

	public function up(){
		$this->forge->addField([
			'id'=>[
				'type'=>'INT',
				'constraint'=>11,
				'unsigned'=>TRUE,
				'auto_increment'=>TRUE
			],
			'username'=>[
				'type'=>'VARCHAR',
				'constraint'=>'255',
			],
			'name'=>[
				'type'=>'VARCHAR',
				'constraint'=>'255',
			],
			'email'=>[
				'type'=>'VARCHAR',
				'constraint'=>'255',
			],
			'password'=>[
				'type'=>'TEXT',
			],
			'salt'=>[
				'type'=>'TEXT'
			],
			'avatar'=>[
				'type'=>'TEXT',
				'null'=>TRUE,
			],
			'id_role'=>[
				'type'=>'INT',
				'constraint'=>1,
				'default'=>2,
				'unsigned'=>TRUE
			],
			'created_by'=>[
				'type' => 'INT',
				'constraint' => 11,
			],
			'created_date'=>[
				'type' => 'DATETIME',
			],
			'updated_by'=>[
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
			],
			'updated_date'=>[
				'type'=>'DATETIME',
				'null'=>TRUE,
			]
		]);

		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('id_role','role','id');
		$this->forge->createTable('user');
	}

	public function down(){
		$this->forge->dropTable('user');
	}
}
?>