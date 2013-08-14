<?php  
class ControllerComponentBanner extends Controller {
	protected function index($setting) {
		$this->template = 'component/banner.html';
		
		$this->render();
	}
}
?>