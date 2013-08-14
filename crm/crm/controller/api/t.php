<?php  
class ControllerApiT extends Controller {
	public function index() {
		$this->api->status(49);
	}
	
	public function t(){
		$this->load->model('tag/tag_sys');
		$data = $this->model_tag_tag_sys->getSysCustomerGrade(1,1);
		//print_r($data);
		
		$this->load->model('tag/tag_member_config');
		
		//print_r($this->model_tag_tag_member_config->addSysTagToMemberConfig(12,$data));
		$data = array(array(
			'tag_name'=>'测试tag',
			'tag_type_no'=>'0',
			'tag_type_name'=>'test',
			'tag_desc'=>'测试tag描述'
		));
		
		//$this->model_tag_tag_member_config->addSysTagToMemberConfig(12,$data);
		echo json_encode($this->model_tag_tag_member_config->getMemberConfig(12,-1));
		
	}
	
	
	
	
}
?>