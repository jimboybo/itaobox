<?php  
class ControllerComponentTabs extends Controller {
	protected function index($setting) {
		$this->template = 'component/tabs.html';
		$this->data['len'] = $setting['len'];
		$this->data['titles'] = $setting['titles'];
		$this->data['contents'] = $setting['contents'];
		$this->render();
	}
}
?>