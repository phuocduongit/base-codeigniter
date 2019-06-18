<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends TK_Controller {
	function __construct(){
        parent::__construct();
        $this->layout('install');
        if(!file_exists(FCPATH.'assets/dist'))
        {
           try {
                exec('cd ./assets && yarn && yarn run build');
           } catch (\Throwable $th) {
            $this->load->view('install/error',
                ['heading'=>"Cannot install assets",
                    'message'=>"
                    <div style='padding:20px;'>
                        We cannot call exec 'yarn' ! <br>
                        You can install it manually in the following way: <br>
                        B1 : cd assets <br>
                        B2 : npm install <br>
                        B3 : npm run build <br>
                    </div>
                    <hr>
                    <div style='padding:20px'>
                    ".pre($th,false)."
                    </div>
                "]);
           }
        }
    }

    function index(){
        if(!file_exists(FCPATH.'assets/dist'))
        {
            $this->load->view('install/error',
            ['heading'=>"Cannot install assets",
                'message'=>"
                <div style='padding:20px;'>
                    We cannot call exec 'yarn' ! <br>
                    You can install it manually in the following way: <br>
                    B1 : cd assets <br>
                    B2 : npm install <br>
                    B3 : npm run build <br>
                </div>
            "]);
        }

        $this->run_config_db();
        $this->page('/install/index');
        $this->render();
    }

    function run_config_db(){
        try {
            $dbExamplePath = APPPATH.'config/database.example.php';
            $dbExampleFile = file_get_contents($dbExamplePath);
            $data = array(
                '_HOSTNAME_' =>'localhost',
                '_USERNAME_' =>'develop',
                '_PASSWORD_' =>'develop',
                '_DATABASE_' =>'erp-oto',
                '_DBPREFIX_' =>'erp',
            );
            $dbFile = template_parser($dbExampleFile,$data);
    
            $dbPath = APPPATH.'config/database.php';
            
            $db_obj = $this->load->database('',TRUE);
            $connected = $db_obj->initialize();
            if (!$connected) {
                unlink($dbPath);
                return FALSE;
            }else{
                return true;
            }

        } catch (\Throwable $th) {
            return false;
        }
    }
}

