<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends TK_Controller {
	function __construct(){
		parent::__construct();

		$this->layout('admin');
	}
	
	public function index()
	{
		// $this->page('site/home');
		$this->content_view(base_url());
		$this->render();
		
	}

	
}


