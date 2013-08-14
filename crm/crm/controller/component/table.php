<?php   
class ControllerComponentTable extends Controller {
	protected function index() {
		$this->template = 'header.html';
    	$this->render();
	}
	
	public function common($option){
		$this->data['id'] = isset($option['id'])?$option['id']:'undefined_table_id_'.time();//dialog dom ID
		$this->data['header'] = $option['header'];
		$this->data['content'] = $option['content'];
		
		$this->template = 'component/table/common.html';
    	$this->render();
	}
}
?>