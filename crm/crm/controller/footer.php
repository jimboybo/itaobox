<?php  
class ControllerFooter extends Controller {
	protected function index() {
		
		$this->data['scripts'] = $this->document->getScripts();
		
		$this->template = 'footer.html';
		$this->render();
	}
}
?>