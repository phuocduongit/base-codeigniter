<?php defined('BASEPATH') OR exit('No direct script access allowed');

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

    function runConfigDb(){
        $this->validate($_POST,[
            'hostname'=>'required',
            'username'=>'required',
            'database'=>'required',
        ]);
        try {
            $db = [
                'db_debug' => FALSE,
                'hostname' => $this->input->post('hostname'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'database' => $this->input->post('database'),
                'dbdriver' => 'mysqli',
                'port' => '3306',
                'dbprefix'=>'ci'
            ];
            error_reporting(0);
            $db_obj = $this->load->database($db,TRUE);
            $connected = $db_obj->initialize();
            if($connected)
            {
                $dbExamplePath = APPPATH.'config/database.example.php';
                $dbExampleFile = file_get_contents($dbExamplePath);
                $data = array(
                    '_HOSTNAME_' => $this->input->post('hostname'),
                    '_USERNAME_' => $this->input->post('username'),
                    '_PASSWORD_' =>$this->input->post('password'),
                    '_DATABASE_' =>$this->input->post('database'),
                    '_DBPREFIX_' =>'ci',
                );
                $dbFile = template_parser($dbExampleFile,$data);
        
                $dbPath = APPPATH.'config/database.php';
                    
                $handle = fopen($dbPath, 'w') or die('Cannot open file:  '.$dbPath);
                fwrite($handle, $dbFile);
                fclose($handle);
                $this->api_res([],'Connect database succcess',true);
            }else{
                $this->api_res([],'can not connect database',false);
            }
        } catch (\Throwable $th) {
            $this->api_res($th,'can not connect database',false);
        }
    }
}

