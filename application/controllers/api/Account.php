<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends API_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('User_model');
    }


    public function login() {
		if (isset($_POST)) {

			$this->validate($_POST,[
				'username'=>'required',
				'password'=>""
			],[
				'username:required' => 'Tên đăng nhập không được để trống',
				'password:required' => 'Mật khẩu không được để trống',
			]);
			$mess=$this->User_model->login($this->input->post('username'),$this->input->post("password"));
			if ($mess) {
				$this->session->user_login = clone $mess;
				if($mess->role_id)
				{
					$mess->redirect = "/";
				}
				unset($mess->role_id);
				sendMes("Đăng nhập thành công",1,"NOTIFICAION");
				$this->api_res($mess,'Đăng nhập thành công',true);
			}
			else {
				$this->api_res([],'Sai tên đăng nhập hoặc mật khẩu!',false);
			}
		}
	}

	public function forgot() {
		$this->validate($_POST,[
			'email'=>'required',
		],[
			'email:required' => 'Email không được để trống',
		]);

		$email=$this->input->post('email');
		if ($email) {
			$user = $this->User_model->get_info_rule(["email"=>$email]);
			if($user){
				$token = get_secrect_rand();
				$this->load->model('Token_model');
				$this->Token_model->createToken($user->id,$token,7);
				$subject = 'ERP OTO || KHÔI PHỤC MẬT KHẨU';
				$message = "Link xác nhận: ".base_url()."auth/forgot-verify?token=$token";
				$sendMail = sendMail([$email], $subject,array(
					"title"=>"Khôi phục mật khẩu",
					"content"=>$message
				));
				if($sendMail)
				{
					$this->api_res([],'Link khôi phục mật khẩu đã được gửi về email của  bạn',true);
				}else{
					$this->api_res([],"Chúng tôi không thể gửi Mã cho địa chỉ : <strong>$email</strong>",false);
				}
			}else{
				$this->api_res([],"Email <strong>$email</strong> không tồn tại trong hệ thống",false);
			}
		}
	}

	public function newpassword() {
		$this->validate($_POST,[
			'password'=>'required',
			'rpassword'=>'required',
			'token'=>'required',
		],[
			'password:required' => 'Bạn chưa nhập mật khẩu',
			'rpassword:required' => 'Bạn chưa nhập lại mật khẩu',
			'token:required' => 'Token của bạn không hợp lệ',
		]);

		$password=$this->input->post('password');
		$rpassword=$this->input->post('rpassword');
		if($password != $rpassword)
		{
			$this->api_res([],'Nhập lại mật khẩu không chính xát',false);
		}

		$this->load->model('Token_model');
		$user_id = $this->Token_model->verifyToken($this->input->post('token'));
		if ($user_id) {
			$user = $this->User_model->findById($user_id);
			if($user){
				if($this->User_model->update_password($user_id,$password)){

					$this->Token_model->remove_rule(["token"=>$this->input->post('token')]);
					sendMes("Đổi mật khẩu thành công",1,"NOTIFICAION");
					$subject = 'ERP OTO || KHÔI PHỤC MẬT KHẨU';
					$message = "Bạn đã đổi mật khẩu thành công";
					$sendMail = sendMail([$user->email], $subject,array(
						"title"=>"Xát nhận đổi mật khẩu",
						"content"=>$message
					));
					if($sendMail)
					{
						$this->api_res([
							"redirect"=>"/login"
						],$message,true);
					}else{
						$this->api_res([
							"redirect"=>"/login"
						],"Chúng tôi không thể gửi Mã cho địa chỉ : <strong>$user->email</strong>",true);
					}
				}else{
					$this->api_res([],"Ôi có lỗi gì rồi",false);
				}

			}else{
				$this->api_res([],"<strong>Tài khoản</strong> đã bị xoá hoặc không tồn tại trong hệ thống",false);
			}
		}else{
			$this->api_res([],"<strong>Tài khoản</strong> đã bị xoá hoặc không tồn tại trong hệ thống",false);
		}
	}



	public function index()
	{
		// $this->page('site/home');
		$this->content_view(base_url());
		$this->render();

	}


}

