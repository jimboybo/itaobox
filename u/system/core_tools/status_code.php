<?php
/**
 * api 状态码
 */
class StatusCode{
    private $codes;
    public function __construct(){
	$this->codes = parse_ini_file('status_codes/status_codes.ini');
    }
    
    public function getStatus($code, $message = null, $sub_code=null, $sub_msg=null){
		if(empty($message)) {
				if(array_key_exists($code, $this->codes)) {
					$message = $this->codes[$code];
				} else {
					$message = 'Unknow error.';
				}
			}
		$sub_code = empty($sub_code) ? $code : $sub_code;
			$sub_msg = empty($sub_msg) ? $message : $sub_msg;
			
		$error_response = array(
			'error_response' => array(
			'code' => $code, 
			'msg' => $message, 
			'sub_code' => $sub_code,
			'sub_msg' => $sub_msg
			)
		);
		echo json_encode($error_response);
    }
}
?>