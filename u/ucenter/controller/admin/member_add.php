<?php  
class ControllerAdminMemberAdd extends Controller {
	public function index() {
		
		$this->load->model('member');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_member->addMember($this->request->post);
		}
		$this->data['action'] = $this->url->link('admin/member', '', 'SSL');
		
		
		$this->template = 'admin/member_add.html';
		$this->render();
	}
	private function validate() {
		
	}
	
}
?>