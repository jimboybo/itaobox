<?php
class ModelMember extends Model {
	public function addMember($data) {
		$sql = "INSERT INTO `" . DB_PREFIX . "members` SET username = '" . $this->db->escape($data['username']) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', reg_from_id = " . (int)$data['reg_from_id'] . ", reg_from_app_id= ".(int)$data['reg_from_app_id'].",reg_ip = '" . $this->db->escape($data['ip']) ."', status = '" . (int)$data['status'] . "', date_added = unix_timestamp(now())";
		echo $sql;
		$this->db->query($sql);
	}
	public function addMemberByTaobaoId($data){
		$sql = "INSERT INTO `" . DB_PREFIX . "members` SET from_taobao = '" . $this->db->escape($data['taobao_id']) . "', reg_from_id = " . (int)$data['reg_from_id'] . ", reg_from_app_id = ".(int)$data['reg_from_app_id'].",reg_ip = '" . $this->db->escape($data['ip']) ."', status = '" . (int)$data['status'] . "', date_added = unix_timestamp(now())";
		echo $sql;
		$this->db->query($sql);
	}
	public function getMembers($data){
		$sql = "SELECT * FROM `" . DB_PREFIX . "members` as a, `".DB_PREFIX."apps` as b, `".DB_PREFIX."froms` as c where b.`app_id` = a.`reg_from_app_id` AND c.`from_id`=a.`reg_from_id`";
		$sort_data = array(
			'username',
			'status',
			'date_added',
			'member_id'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY a.member_id";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			
			
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		echo $sql;
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	/**
	 * 根据淘宝id获取用户
	 **/
	public function getMemberByTaobaoId($taobao_id){
		$query = $this->db->query('SELECT * FROM `'. DB_PREFIX .'members` WHERE `from_taobao` = "'.$taobao_id.'"');
		return $query->row;
	}
	/**
	 * 根据登录token和登录类型获取用户信息
	 */
	public function getMemberByToken($data){
		$query = $this->db->query('SELECT 
									a.member_id,a.username,a.email,a.from_weibo,a.from_qq,a.from_taobao,
									b.`login_from_id`,b.token,b.taobao_token,b.taobao_refresh_token
									FROM `'.DB_PREFIX.'members` as a, `'.DB_PREFIX.'token` as b
									where a.member_id = b.member_id
									and a.status = 1
									and b.login_from_id = '.$data['login_from_id'].'
									and b.token = "'.$data['token'].'"');
		return $query->row;
	}
	/**
	 * 根据用户ID，获取用户信息
	 */
	public function getMemberById($member_id){
		
	}
	
	
}
?>