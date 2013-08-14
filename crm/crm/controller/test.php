<?php  
class ControllerTest extends Controller {
	public function index() {
		
		
		$this->template = 'test.html';
		$this->response->setOutput($this->render());
	}
}
?>