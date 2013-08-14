<?php   
class ControllerComponentBreadcrumb extends Controller {
	protected function index() {
		$this->template = 'header.html';
    	$this->render();
	}
	
	public function common($option){
		$this->data['count'] = $option['count'];
		$this->data['content'] = $option['content'];
		$this->template = 'component/breadcrumb/common.html';
    	$this->render();
	}
}
?>