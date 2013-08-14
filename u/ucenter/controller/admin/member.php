<?php  
class ControllerAdminMember extends Controller {
	public function index() {
		$this->document->setTitle('用户管理');
		
		$this->children = array(
			'admin/footer',
			'admin/header'
		);
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		}
		else{
			$page = 1;
		}
		$this->data['member_list'] = $this->getChild('admin/member_list',array('page'=>$page-1,'limit'=>5));
		$this->data['banner'] = $this->getChild('component/banner',array());
		$this->data['tabs'] = $this->getChild(
			'component/tabs',
			array('len'=>2,
					'titles'=>array('搜索用户','添加用户'),
					'contents'=>array($this->getChild('admin/member_search',array()),$this->getChild('admin/member_add',array()))
				)
		);
		
		$this->data['breadcrumbs'] = $this->getChild('component/breadcrumbs',array('data'=>array('首页','管理','用户管理')));
		$this->template = 'admin/member.html';
		
		$this->response->setOutput($this->render());
	}
	
}
?>