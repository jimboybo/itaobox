<?php
/**
 * 系统级别的tag
 * 涉及表：tag_sys
 * version:1.0.0
 * 2013-07-17
 * spark zhou
 */
class ModelTagTagSys extends Model {
    
	/*************************************************************************************
	 * 客户类型
	 *************************************************************************************/
	
	/**
	 * 获取系统[客户类型]
	 * 
	 * @param $is_enable 是否可用：0不可用，1可用，-1全部
	 * @param $is_delete 是否删除：0删除，1未删除，-1全部
	 * 
	 */
	public function getSysCustomerType($is_enable = 1, $is_delete = 1){
		$sql_tag = 'SELECT * FROM `'.DB_PREFIX.'tag_sys` WHERE `tag_type_no` = 1 AND `tag_type_name` = "customer_type" '.
					($is_enable >= 0 ? ' AND `is_enable` = '.$is_enable:'').
					($is_delete >= 0 ? ' AND `is_delete` = '.$is_delete:'');
		
		$tag = $this->db->query($sql_tag);
        return $tag->rows;
	}
	
	/*************************************************************************************
	 * 客户级别
	 *************************************************************************************/
	
	/**
	 * 获取系统预设[客户级别]
	 * 
	 * @param $is_enable 是否可用：0不可用，1可用，-1全部
	 * @param $is_delete 是否删除：0删除，1未删除，-1全部
	 */
	public function getSysCustomerGrade($is_enable = 1, $is_delete = 1){
		$sql_tag = 'SELECT * FROM `'.DB_PREFIX.'tag_sys` WHERE `tag_type_no` = 2 AND `tag_type_name` = "grade"'.
					($is_enable >= 0 ? ' AND `is_enable` = '.$is_enable:'').
					($is_delete >= 0 ? ' AND `is_delete` = '.$is_delete:'');
		
		$tag = $this->db->query($sql_tag);
        return $tag->rows;
	}
	
	
}
?>