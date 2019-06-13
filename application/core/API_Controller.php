<?php if (!defined('BASEPATH')) exit('Bạn không có quyền truy cập vào đây');
// require FCPATH . 'vendor/autoload.php';
use Rakit\Validation\Validator;
/**
 * API Controller.
 * @version 1.1
 * @author REVO
 */
class API_Controller extends CI_Controller
{
    public $data = array();
    function __construct()
    {
        parent::__construct();
        if (isset($_SERVER["CONTENT_TYPE"])  && $_SERVER["CONTENT_TYPE"] == "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $_POST = array_merge($decoded, $_POST);
        }
    }

    protected function api_res($data = [], $message = "", $status = true, $code = 200)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("X-Robots-Tag: noindex, nofollow", true);
        switch ($code) {
            case 404:
                header("HTTP/1.1 404 NOT FOUND");
                break;
            case 400:
                header('HTTP/1.1 400 BAD REQUEST');
                break;
            case 401:
                header("HTTP/1.1 401 UNAUTHORIZED");
                break;
            default:
                header("HTTP/1.1 200 OK");
                break;
        }

        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_HEX_QUOT | JSON_HEX_TAG);
        die();
    }

    protected function validate($method,$rules,$messages=[])
    {
        $validator = new Validator;
        $validator->setMessages([
            'required' => ':attribute là bắt buộc',
            'email' => ':email không đúng định dạng',
            // etc
        ]);
        $validation = $validator->validate($method, $rules,$messages);
       
        if ($validation->fails()) {
            // handling errors
            $errors = $validation->errors();
            $messages = $errors->firstOfAll();
            $message = reset($messages);
            return $this->api_res([], $message, false, 400);
        }
    }
}