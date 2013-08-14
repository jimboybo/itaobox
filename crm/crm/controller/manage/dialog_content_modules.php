<?php
class ControllerManageDialogContentModules extends Controller {
	public function index() {
		
	}
	
	public function add_new_customer(){
		$this->document->addScript('crm/view/jquery/validform/jqBootstrapValidation.js');
		$this->document->addScript('crm/view/jquery/jquery.form.js');
		
		$this->load->model('tag/tag_member_config');
		
		//客户等级
		$grade = $this->model_tag_tag_member_config->getMemberConfig($this->session->data['u_member_id'],2);
		$grade_list = array();
		foreach($grade as $item){
			array_push($grade_list,array('url'=>'javascript:;','value'=>$item['id'],'name'=>$item['tag_name']));
		}
		$this->data['select_customer_grade'] = $this->getChild('component/select/common',
												  array(
														'id'=>'select_customer_grade',
														'title'=>'客户类型',
														'name'=>'grade_tag_id',
														'list'=>$grade_list
														)
												  );
		$this->data['ajax_url'] = $this->config->get('crm_api_base_url');
		
		$this->template = 'manage/dialog_content_add_new_customer.html';
    	$this->render();
	}
	//管理收货地址
	public function manage_address(){
		$this->template = 'manage/dialog_content_manage_address.html';
    	$this->render();
	}
	//显示历史订单日期
	public function show_history_deal_date(){
		$this->template = 'manage/dialog_content_show_history_deal_date.html';
    	$this->render();
	}
	//处理备注信息
	public function do_memo(){
		$this->template = 'manage/dialog_content_do_memo.html';
    	$this->render();
	}
}
?>