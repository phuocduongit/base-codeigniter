<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends TK_Controller {
	function __construct(){
		parent::__construct();
		$this->layout('admin');
		$this->setModuleName("Admin Dashboard");
	}

	public function index()
	{
		$this->setActionName('Xem bảng điều khiển');
		if($this->checkPermission())
		{
			$this->page('site/dashboard');
			$this->content_view(base_url());
			$this->render();
		}
	}
}


