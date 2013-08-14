<?php
class ControllerManageCustomersTableHeader extends Controller {
	public function index($option) {
		$this->data['customer_grade_list'] = $option['customer_grade_list'];
		$this->load->model('tag/tag_sys');
		//客户类型
		$member_c_type = $this->model_tag_tag_sys->getSysCustomerType(1,1);
		$member_c_sort_list = array();
		foreach($member_c_type as $item){
			array_push($member_c_sort_list,array('url'=>union_url(current_base_url(),$this->request->get,array('c_type'=>$item['id'],'page'=>1)),
												 'value'=>$item['id'],
												 'name'=>$item['tag_name']
												)
					   );
		}
		
		$this->data['dropdown_customer_sort'] = $this->getChild('component/dropdown/common',
																	array('id' => 'dropdown_customer_sort',
																		  'title'=>'客户类型',
																		  'list'=>$member_c_sort_list
																		)
																);
		
		//客户等级
		$this->data['dropdown_customer_grade'] = $this->getChild('component/dropdown/common',
												  array(
														'title'=>'客户等级',
														'list'=>$this->data['customer_grade_list']
														)
												  );
		$this->template = 'manage/customers_table_header.html';
    	$this->render();
	}
}
?>