<?php   
class ControllerComponentDropdown extends Controller {
	protected function index() {
		$this->template = 'header.html';
    	$this->render();
	}
	
	public function common($option){
		$this->data['count'] = isset($option['count'])?$option['count']:0;
		
		$this->data['id'] = isset($option['id'])?$option['id']:'undefined_dropdown_id_'.time();
		$this->data['p_component'] = isset($option['p_component'])?$option['p_component']:'undefined_dropdown_p_component'.time();//p属性，帅选器
		$this->data['js_files'] = isset($option['js_files'])?$option['js_files']:array();
		$this->data['css_files'] = isset($option['css_files'])?$option['css_files']:array();
		$this->data['title'] = isset($option['title'])?$option['title']:'未定义';
		$this->data['list'] = isset($option['list'])?$option['list']:array();
		$this->data['v'] = isset($option['v'])?$option['v']:'';//值
		
		$this->template = 'component/dropdown/common.html';
    	$this->render();
	}
}
?>