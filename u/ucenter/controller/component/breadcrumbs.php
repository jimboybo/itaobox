<?php  
class ControllerComponentBreadcrumbs extends Controller {
	protected function index($setting) {
		$this->template = 'component/breadcrumbs.html';
		$this->data['breadcrumbs'] = $setting['data'];
		$this->data['len'] = count($setting['data']);
		$this->render();
	}
}
?>