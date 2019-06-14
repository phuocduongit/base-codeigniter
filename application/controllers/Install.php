
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->page('/install/index');
        $this->render();
    }
}

