<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
*   @date       :   30 May, 2019
*   @author     :   WIN10
*   @description:   required => [id, date_create, date_update, date_delete]
*/
class User_model extends TK_model
{
    var $table = "user";
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
				),'username' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
                    'null'=>false,
				),'password' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
					'null'=>false
				),'name' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
					'null'=>true
				),'address' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
					'null'=>true
				),'phone' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
					'null'=>true
				),'fax' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
					'null'=>true
				),'cmnd' => array(
					'type' => 'VARCHAR',
					'constraint' => '50',
					'null'=>true
				),'city' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
					'null'=>true
				),'type' => array(
					'type' => 'VARCHAR',
					'constraint' => '50',
					'null'=>true
				),'note' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
					'null'=>true
				),'email' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
					'null'=>true
				),'website' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
					'null'=>true
				),'avatar_url' => array(
					'type' => 'VARCHAR',
					'constraint' => '250',
					'null'=>true
				),'taxcode' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
					'null'=>true
				),'role_id' => array(
                    'type' => 'int',
                    "default"=>2,
                    'comment'=>'1: super_admin || 2: admin || 3:user | ..',
				),'discount' => array(
					'type' => 'double',
					'default' => '0',
					'comment'=>'chiết khấu (%)',
				),'status' => array(
					'type' => 'varchar',
					'constraint' => '50',
                    "default"=>"ACTIVE",
					'comment'=>'ACTIVE,DISABLE'
				),'active' => array(
                    'type' => 'tinyint',
                    "default"=>"1",
                    'comment'=>'1:active, 0:xóa',
					'null'=>true,
				)
			));
			$this->dbforge->add_field('date_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
   			$this->dbforge->add_field('date_update DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
   			$this->dbforge->add_field('date_delete DATETIME NULL');
			#endregion
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table($this->table);
			$data = array(
				"username"=>"super_admin",
				"name"=>"Supper Admin",
				"address"=>"",
				"phone"=>"",
				"fax"=>"",
				"cmnd"=>"",
				"email"=>'super.admin@gmail.com',
                "website"=>'devteam.mobi',
                "role_id"=>ROLE_SUPER_ADMIN,
				"password"=>password_hash("123456",PASSWORD_BCRYPT)
			);
			$this->create($data);
			$this->create([
				"username"=>"admin",
				"name"=>"Admin",
				"address"=>"",
				"phone"=>"",
				"fax"=>"",
				"cmnd"=>"",
				"email"=>'admin@gmail.com',
                "website"=>'devteam.mobi',
                "role_id"=>ROLE_ADMIN,
				"password"=>password_hash("123456",PASSWORD_BCRYPT)
			]);
			$this->create([
				"username"=>"user",
				"name"=>"User",
				"address"=>"",
				"phone"=>"",
				"fax"=>"",
				"cmnd"=>"",
				"email"=>'user@gmail.com',
                "website"=>'devteam.mobi',
                "role_id"=>ROLE_USER,
				"password"=>password_hash("123456",PASSWORD_BCRYPT)
			]);
		}
	}

	public function update_password($id, $password)
	{
		return $this->update($id,[
			"password"=>password_hash($password,PASSWORD_BCRYPT)
		]);
	}

	public function login($email="",$pass="")
	{
		$this->db->select("email,name,username,role_id,password,date_created,date_update,note");
		$this->db->where("email", "$email")->or_where("username",$email);
		$this->db->where("active", 1);
		$this->db->where("status", 'ACTIVE');
		$query=$this->db->get("$this->table");
		$result = $query->row_object();
		if($result == null)
			return null;
		if(password_verify($pass,$result->password)){
			unset($result->password);
			return $result;
		}else{
			return null;
		}
    }

	public function findByToken($token = ""){
		$this->db->select("*");
        $this->db->where("token", "$token");
        $query=$this->db->get("$this->table");
        return $query->row_object();
	}

	public function findById($id = ""){
		$this->db->select("*");
        $this->db->where("id", "$id");
        $query=$this->db->get("$this->table");
        return $query->row_object();
	}

	public function findByEmail($email=""){
		$this->db->select("*");
        $this->db->where("email", "$email");
        $query=$this->db->get("$this->table");
        return $query->row_object();
	}

	public function findByCodeRef($ref=""){
		$this->db->select("*");
        $this->db->where("ref", "$ref");
        $query=$this->db->get("$this->table");
        return $query->row_object();
	}


}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */