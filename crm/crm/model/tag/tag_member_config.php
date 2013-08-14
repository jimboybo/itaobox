<?php
/**
 * 网站用户tag配置
 * 涉及表：tag_member_config
 * version:1.0.0
 * 2013-07-17
 * spark zhou
 */
class ModelTagTagMemberConfig extends Model {
	/**
	 * 初始化[系统预设客户Tag]到[网站用户的配置表]里
	 * @param integer $u_member_id 网站用户ID
	 * @param array $data 需要添加的数据
	 */
	public function addSysTagToMemberConfig($u_member_id,$data){
		$sql = 'INSERT INTO `'.DB_PREFIX.'tag_member_config` (`u_member_id`,`tag_name`,`tag_type_no`,`tag_type_name`,`tag_desc`,`is_enable`,`is_delete`,`is_sys`) VALUES';
		$len = count($data);
		if($len<=0) return;
		for($i=0;$i<$len;$i++){
			$sql .= '('.$u_member_id.',"'.$data[$i]['tag_name'].'",'.$data[$i]['tag_type_no'].',"'.$data[$i]['tag_type_name'].'","'.$data[$i]['tag_desc'].'",1,1,'.(isset($data[$i]['is_sys'])?$data[$i]['is_sys']:0).'),';
		}
		
		$sql = substr($sql,0,-1);
		
		$result = $this->db->query($sql);
		return $result;
	}
	
	/**
	 * 获取网站用户配置的tag信息
	 * @param integer $u_member_id 网站用户ID
	 */
	public function getMemberConfig($u_member_id, $tag_type_no, $is_enable = 1, $is_delete = 1){
		$sql = 'SELECT * FROM `'.DB_PREFIX.'tag_member_config` WHERE u_member_id='.$u_member_id.
					($tag_type_no >= 0 ? ' AND `tag_type_no` = '.$tag_type_no:'').
					($is_enable >= 0 ? ' AND `is_enable` = '.$is_enable:'').
					($is_delete >= 0 ? ' AND `is_delete` = '.$is_delete:'');
		
		$tag = $this->db->query($sql);
        return $tag->rows;;
	}
	
}
?>