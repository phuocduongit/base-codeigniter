<?php
/**
 * Chuyển hướng trang bằng javascript
 */
if (!function_exists('toLink')) {
    function toLink($string)
    {
        echo "
                <script>
                      window.history.pushState('string', '', '" . base_url() . "$string');
                </script>
              ";
    }
}

/**
 * Lấy current Page URL
 */
if (!function_exists('curPageURL')) {
    function curPageURL()
    {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] . '';
        }
        return $pageURL;
    }
}


if (!function_exists('config_phan_trang')) {
    /**
     * Hàm này dùng để cấu hình phân trang
     * Kiểu dữ liệu trả về là một array config => dùng biến $config để hứng lại
     * @param mixed $per_page Số item tối đa trên một trang
     * @param mixed $base_url đường dẫn khi tạo link phân trang
     * vd :base_url().'admin/hotel'
     * =>localhost/admin/hotel?page=1
     * @return array
     */
    function config_phan_trang($per_page = 0, $base_url = '')
    {
        $config['per_page'] = "$per_page";
        $config['first_tag_open'] = '<li class="page-item-2">';
        $config['first_link'] = 'Đầu Trang';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li class="page-item-2">';
        $config['last_link'] = 'Cuối Trang';
        $config['last_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li class="page-item-2 first-dev"';
        $config['prev_link']        =     '&laquo;';
        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li class="page-item-2">';
        $config['next_link']        =     '»';
        $config['next_tag_close'] = '</li>';

        $config['num_tag_open']        =     '<li class="page-item-2">';
        $config['num_tag_close']    =     '</li>';

        $config['cur_tag_open']        =     '<li class="page-item-2 active"><a class="page-link">';
        $config['cur_tag_close']    =     '<span class="sr-only">(current)</span></a></li>';
        $config['query_string_segment'] = 'page';
        $config['base_url'] = $base_url;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;


        return $config;
    }
}


function geo_location($ip = "")
{
    //$ip="171.233.227.173";
    //http://freegeoip.net/json/27.74.72.23
    //http://www.geoplugin.net/json.gp?ip=27.74.72.23
    $d = curlGet("http://www.geoplugin.net/json.gp?ip=$ip");

    if ($d) {
        $a = json_decode($d);
        if ((isset($a->geoplugin_status)) && $a->geoplugin_status == 200) {
            $rs = array(
                "city" => $a->geoplugin_city,
                "country_name" => $a->geoplugin_countryName,
                "country_code" => $a->geoplugin_countryCode,
                "region_code" => $a->geoplugin_regionCode,
            );
            return (object)$rs;
        }
    }
    return false;
}


/**
 * GET CURL
 */
function curlGet($url)
{
    // Khởi tạo CURL
    $ch = curl_init($url);

    // Thiết lập có return
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
}

/* backup the db OR just a table */
function backup_tables($host, $user, $pass, $name, $tables = '*')
{

    $link = mysql_connect($host, $user, $pass);
    mysql_select_db($name, $link);

    //get all of the tables
    if ($tables == '*') {
        $tables = array();
        $result = mysql_query('SHOW TABLES');
        while ($row = mysql_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    //cycle through
    foreach ($tables as $table) {
        $result = mysql_query('SELECT * FROM ' . $table);
        $num_fields = mysql_num_fields($result);

        $return .= 'DROP TABLE ' . $table . ';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));
        $return .= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysql_fetch_row($result)) {
                $return .= 'INSERT INTO ' . $table . ' VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = ereg_replace("\n", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                $return .= ");\n";
            }
        }
        $return .= "\n\n\n";
    }

    //save file
    $handle = fopen('db-backup-' . time() . '-' . (md5(implode(',', $tables))) . '.sql', 'w+');
    fwrite($handle, $return);
    fclose($handle);
}

function set_cookie($data = array())
{
    $name = "";
    if (isset($data['name'])) {
        $name   = $data["name"];
    }
    $value = "";
    if (isset($data['value'])) {
        $value   = $data["value"];
    }
    $expire = 0;
    if (isset($data['expire'])) {
        $expire   = $data["expire"];
    }
    return  setcookie($name, $value, $expire);
}

function remove_cookie($cookie_name = '')
{
    if (isset($_COOKIE[$cookie_name])) {
        unset($_COOKIE[$cookie_name]);
        // setcookie($cookie_name, null, -1, '/');
        setcookie("$cookie_name", "", time() - 3600);
        return true;
    } else
        return false;
}
/**
 * Gửi thông điệp đi giữa các view , có 3 loại
 * type = 1 : Thành công
 * type = 2 : cảnh báo
 * type = -1 : lỗi
 *
 * @param $mode : NOTIFICAION or ALERT
 */
function sendMes($content = "", $type = 1, $mode = "NOTIFICAION")
{
    $CI = &get_instance();
   $arrNotiMessage =  $CI->session->flashdata('messages_noti');
    if(!$arrNotiMessage )
    {
        $arrNotiMessage  = [];
    }
    $messages_noti = (object) [
        "message" => $content,
        "type" => $type,
        "mode" =>$mode,
    ];
    array_push($arrNotiMessage,$messages_noti);

    $CI->session->set_flashdata('messages_noti', $arrNotiMessage);
}

function getMes()
{
    $CI = &get_instance();
    $arrNotiMessage =  $CI->session->flashdata('messages_noti');
    if($arrNotiMessage)
        return $arrNotiMessage;
    return FALSE;
}

function showMesAlert()
{
    $arrNotiMessage = getMes();
    if($arrNotiMessage && count($arrNotiMessage) > 0){
       // echo '<div class="kt-portlet"><div class="kt-portlet__body">';
        foreach($arrNotiMessage as $mes)
        {
            if($mes->mode == "ALERT")
            {
                    if ($mes->type == -1) {
                        echo render_html_alert('danger', $mes->message, 'flaticon-danger');
                    } else if ($mes->type == 2) {
                        echo render_html_alert('warning', $mes->message, 'flaticon-exclamation-square');
                    } else {
                        echo render_html_alert('success', $mes->message, 'flaticon2-checkmark');
                    }
            }
        }
      //  echo '</div></div>';
        // $CI = &get_instance();
        // $CI->session->set_flashdata('messages_noti', $arrTmp);
        return true;
    }
    return false;
}

function render_html_alert($style, $mesage, $icon)
{
    return '
    <div class="alert alert-' . $style . ' fade show" role="alert">
        <div class="alert-icon"><i class="' . $icon . '"></i></div>
        <div class="alert-text">' . $mesage . '</div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="la la-close"></i></span>
            </button>
        </div>
    </div>
    ';
}

/**
 * Show Thông báo cho người dùng mỗi noti gồm {item:"",content:""}
 */
function showNotification($arr_Notification = array())
{
    $notification = "";
    foreach ($arr_Notification as $item) {
        $mes = "";
        if ($item->type == -1) {
            $mes =  "<div class='alert alert-danger alert-dismissable'  style='margin-bottom: 5px;'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>$item->content</div>";
        } else if ($item->type == 2) {
            $mes = "<div class='alert alert-warning alert-dismissable'  style='margin-bottom: 5px;'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>$item->content</div>";
        } else {
            $mes = "<div class='alert alert-success alert-dismissable' style='margin-bottom: 5px;'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>$item->content</div>";
        }
        $notification = $notification . $mes;
    }
    return $notification;
}

function bend($contex)
{
    $contex->output->enable_profiler(TRUE);
}

function bend_mark($contex, $mark)
{
    $contex->benchmark->mark($mark);
}

function show_bend_mark($context, $mark1, $mark2)
{
    return $context->benchmark->elapsed_time($mark1, $mark2);
}

function check_mobie()
{
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)))
        return true;
    return false;
}

