<?php
class ModelCustomerCustomer extends Model {
	
	/**
	 * 添加一个客户(Customer)
	 * $data:$c_tag_id,$grade_tag_id,$u_member_id,$customer_name,$customer_mobile,$customer_email,$customer_phone,$customer_contact_name
	 */
    public function addCustomer($data){
		//生成customer数据
        $this->db->query('Insert into '.DB_PREFIX.'customers set u_member_id = '.(int)$data['u_member_id'].',
						 tag_sys_customer_type_id = '.(int)$data['c_tag_id'].',
						 tag_member_config_grade_id = '.(int)$data['grade_tag_id'].',
						 area_country_id='.(int)$data['area_country_id'].',
						 area_state_id='.(int)$data['area_state_id'].',
						 area_city_id='.(int)$data['area_city_id'].',
						 add_date = unix_timestamp(NOW())');
		$customer_id = $this->db->getLastId();
		
		//设置客户信息
		$this->db->query('Insert into '.DB_PREFIX.'common_customer_info set customer_id='.(int)$customer_id.',
						 customer_name="'.$data['customer_name'].'",
						 customer_mobile="'.$data['customer_mobile'].'",
						 customer_email="'.$data['customer_email'].'",
						 customer_phone="'.$data['customer_phone'].'"');
		
		if((int)$data['c_tag_id']==2){
			//设置客户联系人
			$this->db->query('Insert into '.DB_PREFIX.'common_customer_contact_list set customer_id='.(int)$customer_id.',
						 contact_name="'.$data['contact_name'].'",
						 contact_phone="'.$data['contact_phone'].'"');
		}
		
        return $customer_id;
    }
	
	/**
	 * 根据网站用户Id获取所有客户信息
	 * $data:$u_member_id,$page,$size,is_delete,customer_type_id
	 */
	public function getCustomersByMemberId($data){
		$sql = 'SELECT a.`customer_id`,a.`add_date`,a.`u_member_id`,a.`is_taobao_init`,a.`tag_member_config_grade_id` as `grade_tag_id`,
						b.`customer_name`,b.`customer_phone`,b.`customer_mobile`,b.`customer_email`,
						c.`tag_name` as `grade_tag_name`,
						d.`tag_name` as `c_tag_name`,
						country.`country_zh_name`,state.`state_zh_name`,city.`city_zh_name`
				FROM `dg_customers` as a
				LEFT JOIN `dg_common_customer_info` as b	ON a.`customer_id` = b.`customer_id`
				LEFT JOIN `dg_tag_member_config` as c		ON c.`id` = a.`tag_member_config_grade_id`
				LEFT JOIN `dg_tag_sys` as d					ON d.`id` = a.`tag_sys_customer_type_id`
				LEFT JOIN `dg_area_country` as country		ON a.`area_country_id` = country.`id`
				LEFT JOIN `dg_area_state` as state			ON state.`id` = a.`area_state_id`
				LEFT JOIN `dg_area_city` as city			ON city.`id` = a.`area_city_id`
				WHERE a.`u_member_id` = '.(int)$data['u_member_id'].'
						'.(isset($data['is_delete'])?'AND a.`is_delete` = '.$data['is_delete']:'').'
						'.($data['customer_type_id']>0?'AND a.`tag_sys_customer_type_id` = '.$data['customer_type_id']:'').'
				ORDER BY add_date DESC
				LIMIT '.((int)$data['page']-1)*(int)$data['size'].','.(int)$data['size'];
		$customers_query = $this->db->query($sql);
		return $customers_query->rows;
	}
    
	
	/**
	 * 获取所有行数
	 * @param array $data: $u_member_id,$is_delete,$customer_type_id
	 */
	public function getTotalCustomersByMemberId($data){
		$total_query = $this->db->query('SELECT COUNT(*) as total FROM `dg_customers` WHERE `u_member_id` = '.$data['u_member_id'] .'
										'.(isset($data['is_delete'])?'AND `is_delete` = '.$data['is_delete']:'').'
										'.((isset($data['customer_type_id']) && $data['customer_type_id']>0)?'AND `tag_sys_customer_type_id` = '.$data['customer_type_id']:'')
										);
		$total = $total_query->row;
		
		return $total['total'];
	}
	
	/**
	 * 标记删除客户
	 */
	public function deleteCustomers($data){
		$sql = 'UPDATE `dg_customers` set `is_delete` = 0 where `customer_id` in (';
		$len = count($data);
		for($i=0;$i<$len;$i++){
			$sql .= $data[$i].',';
		}
		$sql = substr($sql,0,-1);
		$sql .= ')';
		return $this->db->query($sql);
	}
    
	/**
	 * 更新客户级别
	 * @param array $data:
	 */
	public function updateCustomerGrade($data){
		$sql = 'UPDATE crm.`dg_customers` SET `tag_member_config_grade_id` = '.$data['tag_member_config_grade_id'].' WHERE `customer_id` = '.$data['customer_id'];
		return $this->db->query($sql);
	}
}
?>