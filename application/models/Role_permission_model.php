<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
*   @date       :   20 May, 2019
*   @author     :   WIN10
*   @description:   required => [id, date_create, date_update, date_delete]
*/
class Role_permission_model extends TK_model
{
    var $table = "permission_role";
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
				),'role_id' => array(
					'type' => 'int',
                    'null'=>false
				),'permission_id' => array(
					'type' => 'int',
                    'null'=>false
				),'access' => array(
					'type' => 'tinyint',
                    'default' => 0
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