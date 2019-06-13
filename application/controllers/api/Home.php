<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends API_Controller {
	
	public function index()
	{
		$this->validate($_GET + $_POST,[
			 'name' => 'required'
		],[
            'required' => ':attribute là bắt buộc 2',
        ]);
        $this->api_res([],"");
		//$this->render();
	}
}
