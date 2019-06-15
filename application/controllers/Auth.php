<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends TK_Controller {
	function __construct(){
		parent::__construct();
		$this->layout('blank');
    }


    public function login()
	{
        $this->title("Đăng nhập");
        $this->page('site/account/login');
        $this->render();
	}

	public function logout(){
		$this->session->unset_userdata('user_login');
		redirect('/login');
	}


	public function forgotVerify(){
		$this->load->model('Token_model');
		$user_id = $this->Token_model->verifyToken($this->input->get('token'));
		if($user_id){
			$this->page("site/account/forgotpass");
			$this->title("Đổi mật khẩu");
		}else{
			$this->data["title"] = "Xát thực token thất bại";
			$this->data["description"] = "Token này không hợp lệ hoặc đã hết hạn";
			$this->page('errors/error');
		}
		$this->render();
	}

	public function index()
	{
		// $this->page('site/home');
		$this->content_view(base_url());
		$this->render();

	}


}
