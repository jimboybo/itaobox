<?php  
class ControllerComponentPager extends Controller {
	protected function index($setting) {
		$this->data['base_url'] = $setting['base_url'];
		$this->data['pre'] = $setting['pre'];
		$this->data['next'] = $setting['next'];
		$this->template = 'component/pager.html';
		$this->render();
	}
}
?>