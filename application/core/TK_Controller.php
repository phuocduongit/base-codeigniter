<?php if (!defined('BASEPATH')) exit('Bạn không có quyền truy cập vào đây');
require_once(APPPATH . 'core/API_Controller.php');
/**
 * TK_Controller short summary.
 *
 * TK_Controller description.
 *
 * @version 1.1
 * @author REVO
 */
class TK_Controller extends CI_Controller
{
    //bien gui du lieu sang ben view
    public $data = array();

    function __construct()
    {
        parent::__construct();
        $this->load->library('breadcrumbs');
        $this->data['layout'] = "site";
        $this->data['page'] = "index";
        $this->data['title'] = "";
        $this->data['content_view'] = "";
        $this->data['description'] = "";
    }

    function ignore_request_auth()
    {
        $controller = strtolower($this->uri->rsegment('1'));
        $action = strtolower($this->uri->rsegment('2'));
    }

    function setModuleName($module_name = ''){
        $this->module_name = $module_name;
    }

    function setActionName($action_name = ''){
        $this->action_name = $action_name;
    }

    function checkPermission(){
        $isAccess = FALSE;
        if($this->session->user_login)
        {
            $role_id=$this->session->user_login->role_id;
            $this->load->model('Role_permission_model');
            $this->load->model('Permission_model');
            $action = $this->router->method;
            $module = $this->router->class;

            $checkExistPermission = $this->Permission_model->get_info_rule(['module'=> $module,'action'=> $action]);
            if ($checkExistPermission){

                $checkExistRolePermission = $this->Role_permission_model->get_info_rule(['permission_id'=> $checkExistPermission->id,'role_id'=>$role_id]);
                if($checkExistRolePermission)
                {
                    if($checkExistRolePermission->access)
                    {
                        $isAccess = TRUE;
                    }
                }else{
                    if(ROLE_SUPER_ADMIN == $role_id)
                    {
                        $data['access'] = 1;
                        $data['role_id'] = $role_id;
                        $data['permission_id'] = $checkExistPermission->id;
                        $this->Role_permission_model->create($data);
                        $isAccess = TRUE;
                    }
                }
            }else{
                $data['module'] = $module;
                $data['module_name'] = $this->module_name;
                $data['action'] = $action;
                $data['action_name'] = $this->action_name;
                $res_permission = $this->Permission_model->create($data);
                if(ROLE_SUPER_ADMIN == $role_id)
                {
                    $data = [];
                    $data['access'] = 1;
                    $data['role_id'] = $role_id;
                    $data['permission_id'] = $res_permission;
                    $this->Role_permission_model->create($data);
                    $isAccess = TRUE;
                }
            }
        }else{
            redirect('/login');
        }

        if($isAccess)
        {
            return TRUE;
        }else{
            $this->page('errors/permission');
            $this->render();
            return FALSE;
        }
    }


    protected function layout($layout)
    {
        $this->data['layout'] = $layout;
    }

    protected function page($page)
    {
        $this->data['page'] = $page;
    }

    protected function title($title)
    {
        $this->data['title'] = $title;
    }

    protected function description($description)
    {
        $this->data['description'] = $description;
    }

    protected function content_view($content_view)
    {
        $this->data['content_view'] = $content_view;
    }

    protected function render()
    {
        if (file_exists(VIEWPATH."dist/pages/".$this->data['page'].'.php'))
        {
            $content_view = $this->load->view("dist/pages/".$this->data['page'],$this->data,TRUE);
            $this->data['content_view'] = $content_view;
        }
        $this->data['path_layout'] = 'dist/layouts/' . $this->data['layout'].'/';
        $this->data['breadcrumbs'] = $this->breadcrumbs->get();
        $this->load->view('dist/layouts/' . $this->data['layout'].'/layout', $this->data);
    }
}
