<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends API_Controller {
	function __construct(){
		parent::__construct();
    }

    function run_install_vendor(){
        try {
            // exec('cd ./ && composer install');
            echo exec('composer --v');
            $this->api_res([],'ok',true);
        } catch (\Throwable $th) {
            $this->api_res($th,'error install composer',false);
        }
    }

    function run_config_db(){
        try {
            $dbExamplePath = APPPATH.'config/database.example.php';
            $dbExampleFile = file_get_contents($dbExamplePath);
            $data = array(
                '_HOSTNAME_' =>$this->input->post('hostname'),
                '_USERNAME_' =>$this->input->post('username'),
                '_PASSWORD_' =>$this->input->post('password'),
                '_DATABASE_' =>$this->input->post('database'),
                '_DBPREFIX_' =>$this->input->post('dbprefix'),
            );
            $dbFile = template_parser($dbExampleFile,$data);
    
            $dbPath = APPPATH.'config/database.php';
            
            file_put_contents($dbPath, $dbFile);
            $db_obj = $this->database->load('default',TRUE);
            $connected = $db_obj->initialize();
            if (!$connected) {
                unlink($dbPath);
                $this->api_res([],'connect DB error',true);
            }else{
                $this->api_res([],'connect DB Success',true);
            }

        } catch (\Throwable $th) {
            $this->api_res($th,'error config DB',false);
        }
    }
}

