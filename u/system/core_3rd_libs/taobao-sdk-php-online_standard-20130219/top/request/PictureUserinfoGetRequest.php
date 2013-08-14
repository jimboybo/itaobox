<?php
/**
 * TOP API: taobao.picture.userinfo.get request
 * 
 * @author auto create
 * @since 1.0, 2013-02-19 16:42:55
 */
class PictureUserinfoGetRequest
{
	
	private $apiParas = array();
	
	public function getApiMethodName()
	{
		return "taobao.picture.userinfo.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
