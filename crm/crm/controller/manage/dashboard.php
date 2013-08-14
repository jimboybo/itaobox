<?php
class ControllerManageDashboard extends Controller {
	public function index() {
		//print_r($this->session->data);
		//unset($this->session->data['token']);
		//unset($this->session->data['u_member_id']);
		//$this->member->logout();
		
		$this->document->setTitle('管理首页 - 爱淘客户管理');
		
		if (!$this->member->isLogged()) {
      		$this->session->data['redirect'] = $this->url->link('manage/dashboard', '', 'SSL');
			$this->redirect($this->url->link('account/sign/in', '', 'SSL'));
    	}
		
		$this->document->addLink('crm/view/bootstrap/css/base_admin.css','stylesheet');
		$this->document->addLink('crm/view/css/dashboard.css','stylesheet');
		$this->document->addScript('crm/view/highcharts/highcharts.js');
		$this->document->addScript('crm/view/highcharts/modules/exporting.js');
		$this->document->addScript('crm/view/js/dashboard.js');
		$this->children = array(
			'footer',
			'header'
		);
		$this->data['subnav1'] = $this->getChild('control/menu/subnav1',array('active'=>'dashboard'));
		
		$this->template = 'manage/dashboard.html';
		$this->response->setOutput($this->render());
	}
}
?>