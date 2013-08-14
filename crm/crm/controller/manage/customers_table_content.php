<?php
class ControllerManageCustomersTableContent extends Controller {
	public function index($option) {
		$this->data['customers_list'] = $option['customers_list'];
		
		$this->template = 'manage/customers_table_content.html';
    	$this->render();
	}
}
?>