<?php  
class ControllerHome extends Controller {
	public function index() {
		$this->document->setTitle('首页');
		$this->children = array(
			'footer',
			'header'
		);
		
		$this->data['slideview'] = $this->getChild('component/slideview/style1',array());
		
		$this->template = 'home.html';
		$this->response->setOutput($this->render());
	}
}
?>