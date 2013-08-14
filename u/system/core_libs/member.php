<?php
class Member{
	private $member_id;
	private $username;
	private $email;
	private $from_weibo;
	private $from_qq;
	private $from_taobao;
	private $firstname;
	private $lastname;
	private $login_from_id;
	private $login_from_app_id;
	private $login_ip;
	private $token;
	
	private $tokenTool;
	
	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
		$this->tokenTool = $registry->get('tokenTool');
		
		//unset($this->session->data['token']);
		if (isset($this->session->data['token'])) {
			$member_query = $this->db->query("SELECT a.*,b.`member_id`,b.`login_ip`, b.`login_from_id`,b.`login_from_app_id` FROM `" . DB_PREFIX . "members` as a,`" . DB_PREFIX . "token` as b WHERE b.`member_id` = a.`member_id` AND b.`token` = '" . $this->session->data['token'] . "'");
			if ($member_query->num_rows) {
				$this->member_id = $member_query->row['member_id'];
				$this->username = $member_query->row['username'];
				$this->email = $member_query->row['email'];
				$this->from_weibo = $member_query->row['from_weibo'];
				$this->from_qq = $member_query->row['from_qq'];
				$this->from_taobao = $member_query->row['from_taobao'];
				$this->firstname = $member_query->row['firstname'];
				$this->lastname = $member_query->row['lastname'];
				$this->login_from_id = $member_query->row['login_from_id'];
				$this->login_from_app_id = $member_query->row['login_from_app_id'];
				$this->login_ip = $member_query->row['login_ip'];
				$this->token = $this->session->data['token'];
			}else{
				$this->logout();
			}
		}
	}
	
	/**
	 * 登录处理
	 * @param int $from_id 登录来源(用户系统里Froms ID)
	 * @param int $app_id 登录来源(用户系统里apps ID)
	 * @param array $params 补充参数(淘宝登录有淘宝的补充参数，微博有微博的补充参数)
	 * @param string $login_id 登录账号(账号需要看登录类型：username/email/qq/weibo/taobao)
	 * @param string $password 登录密码
	 * @return bool/String 返回是否登录成功,成功返回token，不成功返回false
	 */
	public function login($from_id = 1, $app_id = 1, $params =array(), $login_id, $password=''){
		switch($from_id){
			case 1://username
				$member_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "members WHERE LOWER(username) = '" . $this->db->escape(strtolower($login_id)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");
				break;
			case 2://email
				$member_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "members WHERE LOWER(email) = '" . $this->db->escape(strtolower($login_id)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");
				break;
			case 4://weibo
				break;
			case 6://qq
				break;
			case 5://weixin
				break;
			case 3://taobao
				if(count($params)){
					//判断淘宝账号是否存在，不存在就添加新用户
					$query = $this->db->query('SELECT * FROM `'. DB_PREFIX .'members` WHERE `from_taobao` = "'.$params['taobao_id'].'"');
					if(!count($query->row)){
						$sql = "INSERT INTO `" . DB_PREFIX . "members` SET from_taobao = '" . $this->db->escape($params['taobao_id']) . "', reg_from_id = " . (int)$from_id . ", reg_from_app_id = ".(int)$app_id.",reg_ip = '" . $_SERVER["REMOTE_ADDR"] ."', date_added = unix_timestamp(now())";
						$this->db->query($sql);
					}					
				}
				$member_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "members WHERE LOWER(from_taobao) = '" . $this->db->escape(strtolower($login_id)) . "' AND status = '1'");
				break;
		}
		if ($member_query->num_rows) {
			$this->token = $this->tokenTool->genToken();//生成token
			$this->session->data['token'] = $this->token;//session token值
			//插入登录信息
			switch($from_id){
				case 1://username
					$insert_token = $this->db->query('INSERT INTO '.DB_PREFIX.'token SET member_id = '.$member_query->row['member_id'].',token="'.$this->token.'",login_from_id='.$from_id.',login_from_app_id = '.$app_id.',login_date=unix_timestamp(now()),login_ip="'.$_SERVER["REMOTE_ADDR"].'"');
					break;
				case 2://email
					$insert_token = $this->db->query('INSERT INTO '.DB_PREFIX.'token SET member_id = '.$member_query->row['member_id'].',token="'.$this->token.'",login_from_app_id='.$app_id.',login_from_id='.$from_id.',login_date=unix_timestamp(now()),login_ip="'.$_SERVER["REMOTE_ADDR"].'"');
					break;
				case 4://from_weibo
					break;
				case 6://from_qq
					break;
				case 3://from_taobao
					if(count($params)){
						//插入token信息
						$insert_token = $this->db->query('INSERT INTO '.DB_PREFIX.'token SET member_id = '.$member_query->row['member_id'].',token="'.$this->token.'",login_from_app_id='.$app_id.',login_from_id='.$from_id.',taobao_token="'.$params['taobao_token'].'",taobao_refresh_token="'.$params['taobao_refresh_token'].'",login_date=unix_timestamp(now()),login_ip="'.$_SERVER["REMOTE_ADDR"].'"');
					}
					break;
			}
			$this->member_id = $member_query->row['member_id'];
			$this->username = $member_query->row['username'];
			$this->email = $member_query->row['email'];
			$this->from_weibo = $member_query->row['from_weibo'];
			$this->from_qq = $member_query->row['from_qq'];
			$this->from_taobao = $member_query->row['from_taobao'];
			$this->firstname = $member_query->row['firstname'];
			$this->lastname = $member_query->row['lastname'];
			
			$this->login_from_id = $from_id;
			$this->login_from_app_id = $app_id;
			$this->login_ip = $_SERVER["REMOTE_ADDR"];
			
			return $this->token;
		}
		else{
			return false;
		}
	}
	
	public function logout(){
		unset($this->session->data['token']);
		
		$this->member_id = '';
		$this->username = '';
		$this->email = '';
		$this->from_weibo = '';
		$this->from_qq = '';
		$this->from_taobao = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->login_from_id = '';
		$this->login_from_app_id = '';
		$this->login_ip = '';
		$this->token = '';
	}
	
	public function isLogged() {
		if(isset($this->session->data['token'])){
			return $this->session->data['token'];
		}
		else{
			$this->token = '';
			return false;
		}
		
	}
	
	public function getMemberId(){
		return $this->member_id;
	}
	public function getUserName(){
		return $this->username;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getFromWeibo(){
		return $this->from_weibo;
	}
	public function getFromQQ(){
		return $this->from_qq;
	}
	public function getFromTaobao(){
		return $this->from_taobao;
	}
	public function getLastName(){
		return $this->lastname;
	}
	public function getFirstName(){
		return $this->firstname;
	}
	public function getLoginFromId(){
		return $this->login_from_id;
	}
	public function getLoginFromAppId(){
		return $this->login_from_app_id;
	}
	public function getLoginIP(){
		return $this->login_ip;
	}
	public function getToken(){
		return $this->token;
	}
}
?>