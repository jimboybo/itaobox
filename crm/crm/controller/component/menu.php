<?php   
class ControllerComponentMenu extends Controller {
	protected function index() {
		$this->template = 'header.html';
		
    	$this->render();
	}
	
	public function main($option){
		$this->template = 'component/menu/main.html';
    	$this->render();
	}
	public function subnav1($option){
		$this->data['id'] = isset($option['id'])?$option['id']:'undefined_menu_id_'.time();
		$this->data['active'] = isset($option['active'])?$option['active']:'';
		
		$this->data['data'] = isset($option['data'])?$option['data']:'';//只支持两层结构
		$this->data['active'] = isset($option['active'])?$option['active']:'';//激活项

		$this->template = 'component/menu/subnav1.html';
    	$this->render();
	}
	
	
}
?>