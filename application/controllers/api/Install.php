
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends API_Controller {
	function __construct(){
		parent::__construct();
    }

    function run_install_vendor(){
        try {
            exec('composer install');
            $this->api_res([],'',true);
        } catch (\Throwable $th) {
            $this->api_res($th,'error install composer',false);
        }
    }
}

