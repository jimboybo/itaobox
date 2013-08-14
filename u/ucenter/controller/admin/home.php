<?php  
class ControllerAdminHome extends Controller {
	public function index() {
		
		$this->data['banner'] = $this->getChild('component/banner',array());
		$this->data['tabs'] = $this->getChild('component/tabs',array());
		$this->data['breadcrumbs'] = $this->getChild('component/breadcrumbs',array());
		
		$this->children = array(
			'admin/footer',
			'admin/header'
		);
		$this->template = 'admin/home.html';
		$this->response->setOutput($this->render());
	}
}
?>