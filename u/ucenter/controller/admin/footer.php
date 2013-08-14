<?php  
class ControllerAdminFooter extends Controller {
	protected function index() {
		
		$this->template = 'admin/footer.html';
		
		$this->render();
	}
}
?>