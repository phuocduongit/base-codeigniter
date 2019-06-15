<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
*   @date       :   20 May, 2019
*   @author     :   WIN10
*   @description:   required => [id, date_create, date_update, date_delete]
*/
class Permission_model extends TK_model
{
    var $table = "permission";
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
				),'module' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
                    'null'=>true,
				),'module_name' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
                    'null'=>true,
				),'action' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
                    'null'=>true,
				),'action_name' => array(
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
		}
    }

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */