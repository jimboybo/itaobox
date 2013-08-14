<?php   
class ControllerComponentDialog extends Controller {
	protected function index() {
		$this->api->status(49);
	}
	
	public function common($option){
		$this->data['id'] = isset($option['id'])?$option['id']:'undefined_dialog_id_'.time();//dialog dom ID
		$this->data['header'] = isset($option['header'])?$option['header']:'未定义标题';
		$this->data['content'] = isset($option['content'])?$option['content']:'未定义内容';
		$this->data['js_files'] = isset($option['js_files'])?$option['js_files']:array(); 
		$this->data['css_files'] = isset($option['css_files'])?$option['css_files']:array();
		
		//是否显示footer的功能按钮
		$is_footer = isset($option['is_footer'])?$option['is_footer']:true;
		$this->data['is_footer'] = $is_footer?'':'display:none;';
		//footer 按钮
		$this->data['btn_ok'] = isset($option['btn_ok'])?$option['btn_ok']:'OK';
		$this->data['btn_cancel'] = isset($option['btn_cancel'])?$option['btn_cancel']:'Cancel';
		
		$this->template = 'component/dialog/common.html';
		
    	$this->render();
	}
}
?>