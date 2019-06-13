<?php
$scripts = [];
$styles = [];
$contexts = [];
$actions = [];
$run_actions = '';


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

if (!function_exists('add_action'))
{
    /**
     * Add a new action hook
     *
     * @param mixed $name
     * @param mixed $function
     * @param mixed $priority
     */
    function add_action($name, $function, $priority = 10)
    {
        // If we have already registered this action return true
        if (isset($GLOBALS['actions'][$name][$priority][$function])) {
            return true;
        }

        /**
         * Allows us to iterate through multiple action hooks.
         */
        if (is_array($name)) {
            foreach ($name as $name) {
                // Store the action hook in the $hooks array
                $GLOBALS['actions'][$name][$priority][$function] = array("function" => $function);
            }
        } else {
            // Store the action hook in the $hooks array
            $GLOBALS['actions'][$name][$priority][$function] = array("function" => $function);
        }

        return true;
    }

    /**
     * Run an action
     *
     * @param mixed $name
     * @param mixed $arguments
     * @return mixed
     */
    function do_action($name, $arguments = "")
    {
        // Oh, no you didn't. Are you trying to run an action hook that doesn't exist?
        if (!isset($GLOBALS['actions'][$name])) {
            return $arguments;
        }

        // Set the current running hook to this
        $GLOBALS['current_action'] = $name;

        // Key sort our action hooks
        ksort($GLOBALS['actions'][$name]);

        foreach ($GLOBALS['actions'][$name] as $priority => $names) {
            if (is_array($names)) {
                foreach ($names as $name) {
                    // This line runs our function and stores the result in a variable
                    $returnargs = call_user_func_array($name['function'], array(&$arguments));

                    if ($returnargs) {
                        $arguments = $returnargs;
                    }

                    // Store our run hooks in the hooks history array
                   // $GLOBALS['current_action'][""+$priority] = $name;
                }
            }
        }

        // No hook is running any more
        $GLOBALS['current_action'] = '';

        return $arguments;
    }

    /**
     * Remove an action
     *
     * @param mixed $name
     * @param mixed $function
     * @param mixed $priority
     */
    function remove_action($name, $function, $priority = 10)
    {
        // If the action hook doesn't, just return true
        if (!isset($GLOBALS['actions'][$name][$priority][$function])) {
            return true;
        }

        // Remove the action hook from our hooks array
        unset($GLOBALS['actions'][$name][$priority][$function]);
    }

    function current_action()
    {
        return $GLOBALS['current_action'];
    }

    function has_run($action, $priority = 10)
    {
        if (isset($GLOBALS['actions'][$action][$priority])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if an action actually exists
     *
     * @param mixed $name
     */
    function action_exists($name)
    {
        if (isset($GLOBALS['actions'][$name])) {
            return true;
        } else {
            return false;
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


add_action('header_load','hello_world',10);
function hello_world()
{
    echo "Hello World!";
    echo "<br /><br />";
}