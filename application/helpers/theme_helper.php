<?php
$scripts = [];
$styles = [];
$contexts = [];


if (!function_exists('load_script'))
{
    function add_script($src = "",$key=""){
        $GLOBALS['scripts'][$key] = $src;
    }

    function load_script(){
        if(isset($GLOBALS['scripts'])){
            foreach ($GLOBALS['scripts'] as $script) {
                echo '<script src="'.$script.'" type="text/javascript"></script>';
            }
        }
    }
}

if (!function_exists('load_style'))
{
    function add_style($src = "",$key=""){
        $GLOBALS['styles'][$key] = $src;
    }

    function load_style(){
        if(isset($GLOBALS['styles'])){
            foreach ($GLOBALS['styles'] as $style) {
                echo '<link href="'.$style.'" rel="stylesheet" type="text/css" />';
            }
        }
    }
}

if (!function_exists('push')){
    function push(){
        ob_start();
    }

    function endpush($key='context'){
        $content = ob_get_clean();
        $GLOBALS['contexts'][$key][] = $content;
    }

    function stack($key=''){
        if(isset($GLOBALS['contexts'][$key])){
            foreach ($GLOBALS['contexts'][$key] as $context) {
                echo $context;
            }
        }
    }
}



if (!function_exists('assets_url')) {
    /**
     * Lấy đường dẫn thư mục assets
     */
    function assets_url($url = '')
    {
        return base_url('assets/' . $url);
    }
}

if (!function_exists('plugin_url')) {
    /**
     * Lấy đường dẫn thư mục assets
     */
    function plugin_url($url = '')
    {
        return base_url('plugins/' . $url);
    }
}

if (!function_exists('assets_url_page')) {
    /**
     * Lấy đường dẫn thư mục assets
     */
    function assets_url_page($page = '')
    {
        return base_url('assets/dist/page/' . $page);
    }
}

if (!function_exists('assets_url_vue')) {
    /**
     * Lấy đường dẫn thư mục assets
     */
    function assets_url_vue($page = '')
    {
        return base_url('assets/dist/vue/' . $page);
    }
}