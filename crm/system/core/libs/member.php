<?php
class Member{
	private $u_member_id;
	private $token;
	
	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		//unset($this->session->data['token']);
		//unset($this->session->data['u_member_id']);
		if (isset($this->session->data['u_member_id'])) {
			$member_query = $this->db->query('SELECT * FROM '.DB_PREFIX.'members WHERE u_member_id = '.$this->session->data['u_member_id']);
			if ($member_query->num_rows) {
				$this->u_member_id = $member_query->row['u_member_id'];
				$this->token = $this->session->data['token'];
			}else{
				$this->logout();
			}
		}
	}
	public function login($u_member_id,$token){
		$result = false;
		$member_query = $this->db->query('SELECT * FROM '.DB_PREFIX.'members WHERE u_member_id = '.$u_member_id);
		if(count($member_query->rows)){
			$result = true;
		}
		else{
			if($this->db->query('Insert into '.DB_PREFIX.'members set u_member_id = '.$u_member_id.', add_date = unix_timestamp(NOW())')){
				$result = true;
			}
			else{
				$result = false;
			}
		}
		if($result){
			$this->session->data['token'] = $token;
			$this->session->data['u_member_id'] = $u_member_id;
			$this->token = $token;
			$this->u_member_id = $u_member_id;	
		}
		return $result;
	}
	public function logout(){
		unset($this->session->data['token']);
		unset($this->session->data['u_member_id']);
		
		$this->u_member_id = '';
		$this->token = '';
	}
	public function isLogged() {
		return $this->token;
	}
	public function getUMemberId(){
		return $this->u_member_id;
	}
	public function getToken(){
		return $this->token;
	}
}
?>