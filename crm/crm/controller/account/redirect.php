<?php
class ControllerAccountRedirect extends Controller {
	public function index(){
		if(isset($this->request->get['token']) && isset($this->request->get['login_from_id'])){//成功获取token
			$this->load->model('account/member');
			//获取登录用户相关信息
			$u_info = json_decode($this->api->execute($this->config->get('ucenter_base_url').'?route=api/token/get&token='.$this->request->get['token'].'&login_from_id='.$this->request->get['login_from_id']));
			if(isset($u_info->error_response)){//出现错误
				$this->redirect('?route=account/sign/in');
			}else{//登录正确
				if(isset($u_info->api_token_get) && isset($u_info->api_token_get->member_id)){
					//登录
					if($this->member->login($u_info->api_token_get->member_id,$this->request->get['token'])){
						$redirect = '?route=home';
						if(isset($this->session->data['redirect'])){
							$redirect = $this->session->data['redirect'];//获取跳转url
							unset($this->session->data['redirect']);
						}
						$this->redirect($redirect);
					}
					else{
						$this->redirect('?route=account/sign/in');
					}
				}else{
					$this->redirect('?route=account/sign/in');
				}
			}
		}
		else{
			//获取失败，就跳转到登录页面重新登录
			$this->redirect('?route=account/sign/in');
		}
	}
}
?>