<?php   
class ControllerComponentSlideview extends Controller {
	protected function index() {
		
		$this->template = 'header.html';
		
    	$this->render();
	}
	
	public function style1($option){
		$this->template = 'component/slideview/style1.html';
		
    	$this->render();
	}
}
?>