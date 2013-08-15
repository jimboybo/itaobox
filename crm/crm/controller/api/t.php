<?php  
class ControllerApiT extends Controller {
	public function index() {
		$this->api->status(49);
	}
	
	public function t(){
		$this->cache->set('api_customer_get','sssssss');
		echo $this->cache->get('api_customer_get1');
	}
	
	
	
	
}
?>