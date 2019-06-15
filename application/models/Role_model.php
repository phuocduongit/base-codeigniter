<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
*   @date       :   20 May, 2019
*   @author     :   WIN10
*   @description:   required => [id, date_create, date_update, date_delete]
*/
class Role_model extends TK_model
{
    var $table = "role";
    function __construct() {
        parent::__construct();
        $this->table = $this->fix.$this->table;
        $this->createTable();
	}

    public function createTable() {
		if(!$this->validateTable())
		{
			#region Add Field
			$this->dbforge->add_field(array(
				'id' => array(
					'type' => 'INT',
					'unsigned' => TRUE,
					'auto_increment' => TRUE
				),'name' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
                    'null'=>true,
				),'description' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
                    'null'=>true,
				)
			));
			$this->dbforge->add_field('date_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
   			$this->dbforge->add_field('date_update DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
   			$this->dbforge->add_field('date_delete DATETIME NULL');
			#endregion
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table($this->table);
			$this->create([
				"id"=>ROLE_SUPER_ADMIN,
				"name"=>"supper_admin",
				"description"=>"Tối thượng",
			]);
			$this->create([
				"id"=>ROLE_ADMIN,
				"name"=>"admin",
				"description"=>"Người quản trị",
			]);
			$this->create([
				"id"=>ROLE_USER,
				"name"=>"user",
				"description"=>"Thành viên đăng ký",
			]);

		}
    }
}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */