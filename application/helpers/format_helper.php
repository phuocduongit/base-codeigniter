<?php


/**
 * Convert sang VNĐ
 */
if (!function_exists('toVND')) {
    function toVND($number = 0)
    {
        return number_format($number) . ' VNÐ';
    }
}

if (!function_exists('toASII')) {
    /**
     * Hàm này dùng để chuyển Tiếng việt có dấu thành không dấu
     * ví dụ : Khách sạn Serene Đà Nẵng = > khach-san-serene-da-nang
     * @param mixed $str Là chuổi cần chuyển đổi
     * @return mixed
     */
    function toASII($str = '')
    {
        // In thường
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        // In đậm
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);

        $str = preg_replace("/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|”|“|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/", "-", $str);
        $str = preg_replace("/-+-/", "-", $str);
        $str = preg_replace("/^\-+|\-+$/", "", $str);

        return  strtolower($str); // Trả về chuỗi đã chuyển
    }
}


function pre($list, $exit = true)
{
    echo "<pre>";
    print_r($list);
    if ($exit) {
        die();
    }
}


function custom_echo($x, $length = 10)
{
    if (strlen($x) <= $length) {
        echo $x;
    } else {
        $y = mb_substr($x, 0, $length) . '...';
        echo $y;
    }
}

function time_elapsed_string($datetime, $full = false)
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    // if ($diff->days > 6) return $datetime;

    $string = array(
        'y' => 'năm',
        'm' => 'tháng',
        'w' => 'tuần',
        'd' => 'ngày',
        'h' => 'giờ',
        'i' => 'phút',
        's' => 'giây',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? ' ' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' trước' : 'vừa đăng';
}

function _substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
        break;
        }
    }
    return $sub . (($len < strlen($str)) ? '...' : '');
}

function getdayandtime($time){
    $time = round($time);
    $time = preg_replace('/[.,]/', '', $time);
    $timeday=array();
    $days=$hours=$minutes=$seconds='';
    if(!empty($time)):
        $days = floor($time / (60 * 60 * 24));
        $time -= $days * (60 * 60 * 24);
        $hours = floor($time / (60 * 60));
        $time -= $hours * (60 * 60);
        $minutes = floor($time / 60);
        $time -= $minutes * 60;
        $seconds = floor($time);
        $time -= $seconds;
    endif;
    $timeday['day']=$days;
    $timeday['hours']=$hours;
    $timeday['minutes']=$minutes;
    $timeday['seconds']=$seconds;
    return $timeday;
}


function format_phone($phone)
{
    // $phone = preg_replace("/^\d/", "", $phone);

    if (strlen($phone) == 7)
        return preg_replace("/(\d{3})(\d{4})/", "$1-$2", $phone);
    elseif (strlen($phone) == 10)
        return preg_replace("/(\d{3})(\d{3})(\d{4})/", "($1) $2-$3", $phone);
    else
        return $phone;
}

function float_rand($Min, $Max, $round = 0)
{

    if ($Min > $Max) {
        $min = $Max;
        $max = $Min;
    } else {
        $min = $Min;
        $max = $Max;
    }
    $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
    if ($round > 0)
        $randomfloat = round($randomfloat, $round);

    return $randomfloat;
}


?>