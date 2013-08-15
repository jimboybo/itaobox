<?php
/**
 * 版本 2013-3-20
 */
class API{
	private $mResponseName = '';//返回名
    private $mResponseBody;//返回体
    public function __construct(){
		
    }
    /**
     * 获取API
     * @param string $url 
     * @param string $param 参数
     */
    public function execute($url, $postFields=null){
		return $this->curl($url, $postFields);
    }
    
    public function curl($url, $postFields = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//https 请求
		if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}
		
		if (is_array($postFields) && 0 < count($postFields))
		{
			$postBodyString = "";
			$postMultipart = false;
			foreach ($postFields as $k => $v)
			{
				if("@" != substr($v, 0, 1))//判断是不是文件上传
				{
					$postBodyString .= "$k=" . urlencode($v) . "&"; 
				}
				else//文件上传用multipart/form-data，否则用www-form-urlencoded
				{
					$postMultipart = true;
				}
			}
			unset($k, $v);
			curl_setopt($ch, CURLOPT_POST, true);
			if ($postMultipart)
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
			}
			else
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
			}
		}
		$reponse = curl_exec($ch);
		
		if (curl_errno($ch))
		{
			throw new Exception(curl_error($ch),0);
		}
		else
		{
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (200 !== $httpStatusCode)
			{
				throw new Exception($reponse,$httpStatusCode);
			}
		}
		curl_close($ch);
		return $reponse;
    }
	
	/**
	 * API结果
	 * @param string $responseName 返回的名称
	 * @param array $responseBody 返回的数据
	 * @param int $length 数据长度
	 *
	 * @return json 返回json数据
	 */
	public function result($responseName,$responseBody,$length=0){
		if($length == 0){
			return json_encode(array($responseName => $responseBody));
		}else{
			return json_encode(array($responseName => $responseBody,'counts' => $length));
		}
    }
	/**
	 * 显示状态码及信息
	 * @param string $code 状态码(必填)
	 * @param string $message 状态信息(可选)
	 * @param string $sub_code 子状态码(可选)
	 * @param string $sub_msg 子状态信息(可选)
	 *
	 * @return json 返回json格式数据
	 */
	public function status($code, $message = '', $sub_code=null, $sub_msg=''){
		$statusCodes = parse_ini_file('status_codes/status_codes.ini');
		
		if(array_key_exists($code, $statusCodes)) {
			$message = $statusCodes[$code].':'.$message;
		} else {
			$message = 'Unknow error.'.':'.$message;
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