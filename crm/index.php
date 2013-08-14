<?php
// Version
define('VERSION', '1.5.4');

// Configuration
require_once('config.php');
   
// Install 
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);
$config->load('system_config');//加载系统层级配置文件
$config->load('app_config');//加载应用层级配置文件

// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Url
$url = new Url($config->get('config_url'), $config->get('config_use_ssl') ? $config->get('config_ssl') : $config->get('config_url'));	
$registry->set('url', $url);


// iLogs
$ilog = new iLog(DIR_LOGS.$config->get('config_log_info_filename')); 
$registry->set('ilog', $ilog);

// Log 
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);

function error_handler($errno, $errstr, $errfile, $errline) {
	global $log, $config;
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	}
		
	if ($config->get('config_error_display')) {
		echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return true;
}
	
// Error Handler
set_error_handler('error_handler');

// Request
$request = new Request();
$registry->set('request', $request);
 
// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$response->setCompression($config->get('config_compression'));
$registry->set('response', $response); 
		
// Cache
$cache = new Cache();
$registry->set('cache', $cache); 

// Session
$session = new Session();
$registry->set('session', $session);

// Document
$registry->set('document', new Document());

// api
$api = new Api();
$registry->set('api', $api);

// utils
$utils = new Utils();
$registry->set('utils', $utils);

//Member
$registry->set('member', new Member($registry));

// TaoBao
$topClient = new TopClient;
$topClient->appkey = $config->get('taobao_app_key_1');
$topClient->secretKey = $config->get('taobao_app_secret_1');
$topClient->format = "json";
$registry->set('topClient', $topClient);

if (isset($request->get['tracking']) && !isset($request->cookie['tracking'])) {
	setcookie('tracking', $request->get['tracking'], time() + 3600 * 24 * 1000, '/');
}

//  Encryption
$registry->set('encryption', new Encryption($config->get('config_encryption')));
		
// Front Controller 
$controller = new Front($registry);	
	
// Router
if (isset($request->get['route'])) {
	$action = new Action($request->get['route']);
} else { 
	$action = new Action('home');
}

// Dispatch
$controller->dispatch($action, new Action('error/not_found'));

// Output
$response->output();
?>