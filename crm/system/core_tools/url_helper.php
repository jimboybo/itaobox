<?php

/**
 * 获取当前完整的URL
 */
if ( ! function_exists('current_url')){
	function current_url(){
	    $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
    
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } 
        else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
	}
}

/**
 *获取当前网页?前的链接
 */
if ( ! function_exists('current_base_url'))
{
    function current_base_url() 
    {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") 
        {
            $pageURL .= "s";
        }
        $pageURL .= "://";
    
        if ($_SERVER["SERVER_PORT"] != "80") 
        {
            $pageURL .= $_SERVER["SERVER_NAME"].":" . $_SERVER["SERVER_PORT"] . $_SERVER['PHP_SELF'];
        } 
        else 
        {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER['PHP_SELF'];
        }
        return $pageURL;
    }
}
/**
 * 返回所有页面的URI段
 */
if ( ! function_exists('uri_string')){
    function uri_string(){
        if (isset($_SERVER['REQUEST_URI'])){
            $uri = $_SERVER['REQUEST_URI']; 
        }
        else{
            if (isset($_SERVER['argv'])){
                $uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['argv'][0];
            }
            else{
                $uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['QUERY_STRING'];
            }
        }
        return $uri;
    }
}

/**
 * URL跳转
 */
if(! function_exists('redirect')){
	function redirect($url, $status = 302) {
		header('Status: ' . $status);
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url));
		exit();				
	}
}

/**
 * 组合链接
 */
if(! function_exists('union_url')){
	/**
	 * 组合链接
	 * @param array $segments 当前请求的参数数组
	 * @param array $modify 当前需要变更的参数
	 */
	function union_url($base_url, $segments = array(), $modify = array()) {
		$base_url .= '?';
		foreach($modify as $name => $item){
			$segments[$name] = $item;
		}
		foreach($segments as $name=>$item){
			
			$base_url .= $name.'='.$item.'&';
		}
		return substr($base_url,0,-1);
	}
}
?>
