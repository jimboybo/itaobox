<?php   
class ControllerComponentSelect extends Controller {
	protected function index() {
		$this->api->status(49);
	}
	
	public function common($option){
		$this->data['id'] = isset($option['id'])?$option['id']:'undefined_dropdown_id_'.time();
		$this->data['title'] = isset($option['title'])?$option['title']:'未定义';
		$this->data['name'] = isset($option['name'])?$option['name']:'select';
		$this->data['list'] = isset($option['list'])?$option['list']:array();
		$this->data['is_js'] = isset($option['is_js'])?$option['is_js']:false;
		$this->data['js_content'] = isset($option['js_content'])?$option['js_content']:'';
		
		$this->template = 'component/select/common.html';
    	$this->render();
	}
}
?>