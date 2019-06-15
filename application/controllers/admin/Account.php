<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends TK_Controller {
	function __construct(){
		parent::__construct();

		$this->layout('admin');
    }


    public function login()
	{
        $this->layout('blank');
            $this->page('site/account/login');
            $this->render();
	}

	public function index()
	{
		// $this->page('site/home');
		$this->content_view(base_url());
		$this->render();

	}


}
