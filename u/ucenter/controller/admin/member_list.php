<?php  
class ControllerAdminMemberList extends Controller {
	public function index($option) {
		
		$this->document->addStyle('ucenter/view/jquery/themes/base/jquery.ui.all.css');
		$this->document->addScript('ucenter/view/jquery/jquery-ui.min.js');
		
		$this->data['pager'] = $this->getChild('component/pager',array('base_url'=>current_base_url().'?route=admin/member&page=','pre'=>$option['page']<=0?1:$option['page'],'next'=>$option['page']+2));
		$this->load->model('member');
		$this->data['members_list'] = $this->model_member->getMembers(array('start'=>$option['page']*$option['limit'],'limit'=>$option['limit']));
		
		$this->template = 'admin/member_list.html';
		$this->render();
	}
	
	
}
?>