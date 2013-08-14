<?php
class ControllerAuthLogin extends Controller{
	public function index() {
		$this->api->status(49);
	}
	
	//普通登录
	public function common(){
		$this->member->logout();
		var_dump($this->member->login(1,1,array(),'jimboybo','123'));
		
		$this->template = 'auth/login.html';
		$this->response->setOutput($this->render());
	}
	
	//淘宝登录
	public function taobao(){
		$this->session->data['login_from_id'] = 3;
		if(isset($this->request->get['login_from_id'])){
			$this->session->data['login_from_id'] = $this->request->get['login_from_id'];
		}
		$this->session->data['login_app_id'] = 1;
		if(isset($this->request->get['login_app_id'])){
			$this->session->data['login_app_id'] = $this->request->get['login_app_id'];
		}
		$view = 'web';
		if(isset($this->request->get['view'])){
			$view = $this->request->get['view'];
		}
		$this->session->data['redirect'] = '?route=auth/login/success';
		if(isset($this->request->get['redirect'])){
			$this->session->data['redirect'] = $this->request->get['redirect'];
		}
		$authorize_url = $this->config->get('get_authorize_url');
		$client_id = $this->config->get('taobao_app_key_1');
		$authorize_url .= '?client_id='.$client_id
		.'&response_type=code&view='.$view
		.'&encode=utf-8&redirect_uri=http://u.itaobox.com/?route=auth/login/taobao_success';
		
		$this->redirect($authorize_url);
	}
	public function taobao_success(){
		if(isset($this->request->get['error'])){
			echo '登录错误,请重试！';
			echo '<br \>';
			echo json_encode($this->request->get);
			return;
		}
		$token_url = $this->config->get('get_token_url');
		$client_id = $this->config->get('taobao_app_key_1');
		$client_secret = $this->config->get('taobao_app_secret_1');
		$grant_type = 'authorization_code';
		$code = $this->request->get['code'];
		$redirect_uri = 'http://u.itaobox.com';
		$postfields = array(
			'client_id'=>$client_id,
			'client_secret'=>$client_secret,
			'grant_type'=>$grant_type,
			'code'=>$code,
			'redirect_uri'=>$redirect_uri
		);
		$token_data = json_decode($this->api->curl($token_url,$postfields));
		//处理登录
		if(isset($this->session->data['login_from_id'])){
			$login_result = $this->member->login(3,$this->session->data['login_app_id'],array('taobao_id'=>$token_data->taobao_user_nick,'taobao_token'=>$token_data->access_token,'taobao_refresh_token'=>$token_data->refresh_token),$token_data->taobao_user_nick);
		}
		else{
			$this->redirect('?route=auth/login/taobao');
		}
		//unset($this->session->data['from_id']);
		//unset($this->session->data['redirect']);
		if(!$login_result){//登录失败
			$this->redirect('?route=auth/login/failure');
		}
		else{//登录成功
			$this->redirect($this->session->data['redirect'].'&token='.$login_result.'&login_from_id=3');
		}
	}
	
	public function success(){
		echo '登录成功';
		echo '<br \>';
		echo '---------------------------------------------------------';
		echo '<br \>';
		print_r($this->session);
	}
	
	public function failure(){
		echo '登录失败';
		echo '<br \>';
		echo '---------------------------------------------------------';
		echo '<br \>';
		print_r($this->session);
	}
}
?>