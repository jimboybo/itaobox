<?php  
class ControllerApiCustomer extends Controller {
	public function index() {
		$this->api->status(49);
	}
	
	public function get(){
		$this->cache->set('api_customer_get','sssssss');
	}
	//添加客户
	public function add(){
		if (!$this->member->isLogged()) {
      		$this->api->status(26);
			return;
    	}
		
		$this->load->model('customer/customer');
		
		if(isset($this->request->get['c_tag_id'])){
			$c_tag_id = $this->request->get['c_tag_id'];
		}else{
			$this->api->status(48,'c_tag_id');
			return;
		}
		if(isset($this->request->get['grade_tag_id'])){
			$grade_tag_id = $this->request->get['grade_tag_id'];
		}else{
			$this->api->status(48,'grade_tag_id');
			return;
		}
		
		//地区国家
		if(isset($this->request->get['area_country_id'])){
			$area_country_id = $this->request->get['area_country_id'];
		}else{
			$this->api->status(48,'area_country_id');
			return;
		}
		//地区地区省
		if(isset($this->request->get['area_state_id'])){
			$area_state_id = $this->request->get['area_state_id'];
		}else{
			$this->api->status(48,'area_state_id');
			return;
		}
		//地区城市
		if(isset($this->request->get['area_city_id'])){
			$area_city_id = $this->request->get['area_city_id'];
		}else{
			$this->api->status(48,'area_city_id');
			return;
		}
		
		if(isset($this->request->get['customer_name'])){
			$customer_name = $this->request->get['customer_name'];
		}else{
			$this->api->status(48,'customer_name');
			return;
		}
		if(isset($this->request->get['customer_mobile'])){
			$customer_mobile = $this->request->get['customer_mobile'];
		}else{
			$this->api->status(48,'customer_mobile');
			return;
		}
		if(isset($this->request->get['customer_email'])){
			$customer_email = $this->request->get['customer_email'];
		}else{
			$this->api->status(48,'customer_email');
			return;
		}
		if(isset($this->request->get['customer_phone'])){
			$customer_phone = $this->request->get['customer_phone'];
		}else{
			$this->api->status(48,'customer_phone');
			return;
		}
		
		//联系人
		if(isset($this->request->get['contact_name'])){
			$contact_name = $this->request->get['contact_name'];
		}else{
			$this->api->status(48,'contact_name');
			return;
		}
		if(isset($this->request->get['contact_phone'])){
			$contact_phone = $this->request->get['contact_phone'];
		}else{
			$this->api->status(48,'contact_phone');
			return;
		}
		$customer_id = $this->model_customer_customer->addCustomer(array(
																		 'u_member_id'=>$this->session->data['u_member_id'],
																		 'c_tag_id'=>$c_tag_id,
																		 'grade_tag_id'=>$grade_tag_id,
																		 
																		 'area_country_id'=>$area_country_id,
																		 'area_state_id'=>$area_state_id,
																		 'area_city_id'=>$area_city_id,
																		 
																		 'customer_name'=>$customer_name,
																		 'customer_mobile'=>$customer_mobile,
																		 'customer_email'=>$customer_email,
																		 'customer_phone'=>$customer_phone,
																		 'contact_name'=>$contact_name,
																		 'contact_phone'=>$contact_phone
																	));
		echo $this->api->result('api_customer_add',$customer_id);
	}
	
	//删除客户
	public function del(){
		if (!$this->member->isLogged()) {
      		$this->api->status(26);
			return;
    	}
		if(isset($this->request->get['data'])){
			$del_list = $this->request->get['data'];
		}else{
			$this->api->status(48,'data');
			return;
		}
		$del_list = explode(',',$del_list);
		$this->load->model('customer/customer');
		echo $this->api->result('api_customer_del',$this->model_customer_customer->deleteCustomers($del_list));
	}
	
	public function update_grade(){
		if (!$this->member->isLogged()) {
      		$this->api->status(26);
			return;
    	}
		if(isset($this->request->get['data'])){
			$del_list = $this->request->get['data'];
		}else{
			$this->api->status(48,'data');
			return;
		}
		$this->load->model('customer/customer');
	}
}
?>