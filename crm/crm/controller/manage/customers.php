<?php
class ControllerManageCustomers extends Controller {
	public function index() {
		if (!$this->member->isLogged()) {
      		$this->session->data['redirect'] = $this->url->link('manage/customers', '', 'SSL');
			$this->redirect($this->url->link('account/sign/in', '', 'SSL'));
    	}
		
		$this->document->setTitle('所有客户 - 客户管理');
		$this->document->addScript('crm/view/js/customer.js');
		
		$this->children = array(
			'footer',
			'header'
		);
		
		//page
		if(isset($this->request->get['page'])){
			$page = $this->request->get['page']<=0?1:$this->request->get['page'];
		}
		else{
			$page = 1;
		}
		//c_type
		if(isset($this->request->get['c_type'])){
			$c_type = $this->request->get['c_type']<=0?-1:$this->request->get['c_type'];
		}else{
			$c_type = -1;
		}
		
		//系统客户等级
		$this->load->model('tag/tag_member_config');
		$grade = $this->model_tag_tag_member_config->getMemberConfig($this->session->data['u_member_id'],2);
		$grade_list = array();
		foreach($grade as $item){
			array_push($grade_list,
					   array('url'=>'javascript:;',
							 'value'=>$item['id'],
							'name'=>$item['tag_name'])
					   );
		}
		//所有客户list
		$this->load->model('customer/customer');
		$size = 3;
		$customers_list = $this->model_customer_customer->getCustomersByMemberId(array(
																					   'u_member_id'=>$this->session->data['u_member_id'],
																					   'is_delete'=>1,
																					   'page'=>$page,
																					   'size'=>$size,
																					   'customer_type_id'=>$c_type
																					   )
																				 );
		$customers_list_len = count($customers_list);
		for($i=0;$i<$customers_list_len;$i++){
			$customers_list[$i]['dropdown'] =  $this->getChild('component/dropdown/common',
												  array(
														'p_component'=>'dropdown_customer_grade',
														'v'=>$customers_list[$i]['grade_tag_id'],
														'title'=>$customers_list[$i]['grade_tag_name'],
														'list'=>$grade_list
														)
												  );
		}
		//表格
		$this->data['table'] = $this->getChild('component/table/common',
											   array(
													'id'=>'table_customer_list',
													'header'=>$this->getChild('manage/customers_table_header',array('customer_grade_list'=>$grade_list)),
													'content'=>$this->getChild('manage/customers_table_content',array('customers_list'=>$customers_list))
													)
											   );
		//分页
		$this->data['paging'] = $this->getChild('component/paging/common',array(
																				'count'=>$this->model_customer_customer->getTotalCustomersByMemberId(
																							array(
																									'u_member_id'=>$this->session->data['u_member_id'],
																									'customer_type_id'=>$c_type,
																									'is_delete'=>1
																								)),
																				'size'=>$size,
																				'curr_page'=>$page
																			)
												);
		//添加客户对话框
		$this->data['dialog_addNewCustomer'] = $this->getChild('component/dialog/common',
															   array(
																	'id'=>'dialog_add_new_customer',
																	'header'=>'添加客户',
																    'content' => $this->getChild('manage/dialog_content_modules/add_new_customer'),
																	'is_footer' => false,
																	'js_files' => array('crm/view/theme/manage/dialog_content_add_new_customer.js'),
																));
		$this->data['dialog_manage_address'] = $this->getChild('component/dialog/common',
															   array(
																	'id'=>'dialog_manage_address',
																	'header'=>'管理地址',
																    'content' => $this->getChild('manage/dialog_content_modules/manage_address'),
																	'is_footer' => false,
																	'js_files' => array('crm/view/theme/manage/dialog_content_manage_address.js'),
																	'css_files' => array('crm/view/css/dialog.css')
																));
		$this->data['dialog_show_history_deal_date'] = $this->getChild('component/dialog/common',
															   array(
																	'id'=>'dialog_show_history_deal_date',
																	'header'=>'历史购买列表',
																    'content' => $this->getChild('manage/dialog_content_modules/show_history_deal_date'),
																	'is_footer' => true
																));
		$this->data['dialog_do_memo'] = $this->getChild('component/dialog/common',
															   array(
																	'id'=>'dialog_do_memo',
																	'header'=>'添加/编辑备注',
																    'content' => $this->getChild('manage/dialog_content_modules/do_memo'),
																	'js_files' => array('crm/view/theme/manage/dialog_content_do_memo.js'),
																	'is_footer' => false
																));
		
		$this->data['subnav1'] = $this->getChild('control/menu/subnav1',array('active'=>'customers'));
		
		$this->template = 'manage/customers.html';
		$this->response->setOutput($this->render());
	}
	
	public function sales(){
		if (!$this->member->isLogged()) {
      		$this->session->data['redirect'] = $this->url->link('manage/customers/sales', '', 'SSL');
			$this->redirect($this->url->link('account/sign/in', '', 'SSL'));
    	}
		
		$this->children = array(
			'footer',
			'header'
		);
		$this->data['subnav1'] = $this->getChild('component/menus/subnav1',array('active'=>'customers'));
			
		$this->template = 'manage/dashboard.html';
		$this->response->setOutput($this->render());
	}
}
?>