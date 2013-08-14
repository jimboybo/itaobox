<?php  
class ControllerAdminMemberSearch extends Controller {
	public function index() {
		
		$this->template = 'admin/member_search.html';
		
		$this->render();
	}
	
}
?>