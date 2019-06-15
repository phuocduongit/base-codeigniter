<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
*   @date       :   25 April, 2019
*   @author     :   WIN10
*   @description:   required => [id, date_create, date_update, date_delete]
*/
class Token_model extends TK_model{
    var $table = "token";
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
				),'token' => array(
					'type' => 'VARCHAR',
					'constraint' => '150',
                    'null'=>true,
				),'date_exprire' => array(
					'type' => 'DATETIME',
                    'null'=>true,
				),'user_id' => array(
					'type' => 'INT',
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

	public function createToken($user_id,$token,$date_exprire = "7"){
    	$date_exprire = date('Y-m-d H:i:sP', strtotime(" +$date_exprire day"));
		return $this->create([
			"token"=>$token,
			"date_exprire"=>$date_exprire,
			"user_id"=>$user_id,
		]);
    }

    public function verifyToken($token_key){
       $token = $this->get_info_rule(["token"=>$token_key]);
       if($token)
       {
            if(time() - strtotime($token->date_exprire) <= 0)
            {
                return $token->user_id;
            }
       }
       return false;
    }

    public function verifyUserId($token)
    {
        $sql = "SELECT * FROM `tb_token` WHERE token = '$token' ";
        $query_ = $this->Token_model->query("$sql");
        if($query_){
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $now = new DateTime();
                $ago = new DateTime($query_[0]->date_update);
                $diff = $now->diff($ago);
                $diff->w = floor($diff->d / 7);
                $diff->d -= $diff->w * 7;
                if ($diff->days > 7) {
                    sendMes("Mã xác thực của bạn đã hết hạn! Chọn gửi lại mã xác nhận để nhận mã xác thực.",0,'NOTIFICAION');
                    redirect('/login');
                }else{
                    $update_active = $this->User_model->update($query_[0]->user_id,['status'=>'ACTIVE']);
                    if($update_active){
                        sendMes("Tài khoản bạn đã được kích hoạt!",1,'NOTIFICAION');
                        redirect('/login');
                    }else{
                        sendMes("Không thể kích được kích hoạt tài khoản này!",-1,'NOTIFICAION');
                        redirect('/login');
                    }
                }
        }else{
            sendMes("Không tồn tại mã xác thực này!",-1,'NOTIFICAION');
            redirect('/login');
        }
    }

}

/* End of file Token_model.php */
/* Location: ./application/models/Token_model.php */