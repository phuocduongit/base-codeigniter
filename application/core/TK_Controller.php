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
        $this->data['description'] = "";
    }

    function ignore_request_auth()
    {
        $controller = strtolower($this->uri->rsegment('1'));
        $action = strtolower($this->uri->rsegment('2'));
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

    protected function render()
    {
        $content_view = "";
        if (file_exists(VIEWPATH."dist/pages/".$this->data['page'].'.php'))
        {
            $content_view = $this->load->view("dist/pages/".$this->data['page'],$this->data,TRUE);
        }
        $this->data['path_layout'] = 'dist/layouts/' . $this->data['layout'].'/';
        $this->data['content_view'] = $content_view;
        $this->data['breadcrumbs'] = $this->breadcrumbs->get();
        $this->load->view('dist/layouts/' . $this->data['layout'].'/layout', $this->data);
    }
}
