<?php
class ControllerAccountSign extends Controller {
	public function index() {
		
	}
	public function in(){
		if ($this->member->isLogged()) {
			$this->redirect($this->url->link('account/home', '', 'SSL'));
    	}
		
		$this->document->setTitle('用户登录');
		$this->children = array(
			'footer',
			'header'
		);
		$this->data['login_from_id'] = 3;
		$this->template = 'account/sign_in.html';
		$this->response->setOutput($this->render());
	}
	public function out(){}
	public function up(){}
	public function taobao(){}
	
	public function success(){
		$this->load->model('account/member');
		if(isset($this->session->data['token'])){
			//获取登录用户相关信息
			$taobao_token = json_decode($this->api->execute($this->config->get('ucenter_base_url').'?route=api/token/get&token='.$this->session->data['token'].'&login_from_id=3'));
			//print_r($taobao_token);
			if(isset($taobao_token->error_response)){//出现错误
				$this->redirect('?route=account/sign/in');
				return;
			}else{//登录正确
				if(isset($taobao_token->api_token_get)){
					$login_result = $this->model_account_member->addMember(array('id'=>$taobao_token->api_token_get->member_id));
				}else{
					$this->redirect('?route=account/sign/in');
				}
			}
		}else{
			$this->redirect('?route=account/sign/in');
		}
	}
	
	public function test(){
		print_r($this->session->data);
		echo '<br \><br \>';
		if(isset($this->session->data['token'])){
			$taobao_token = json_decode($this->api->execute($this->config->get('ucenter_base_url').'?route=api/token/get&token='.$this->session->data['token'].'&type=4'));

			if(isset($taobao_token->error_response)){//出现错误
				print_r($taobao_token);
				return;
			}
			echo '<br \><br \>';
			$req = new TradesSoldGetRequest;
			$req->setFields("tid,num,num_iid,status,title,type,price,created,pay_time,modified,end_time,alipay_id,alipay_no,alipay_url,buyer_memo,buyer_flag,seller_memo,seller_flag,buyer_nick,price,buyer_area,buyer_email,has_buyer_message,area_id,trade_from,trade_memo,buyer_rate,trade_source,seller_nick,pic_path,payment,snapshot_url,snapshot,seller_rate,buyer_alipay_no,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_zip,receiver_mobile,receiver_phone,consign_time,seller_alipay_no,seller_mobile,seller_phone,seller_name,seller_email,orders");
			$req->setStartCreated("2012-01-01 00:00:00");
			$req->setEndCreated("2013-03-01 00:00:00");
			
			$resp = $this->topClient->execute($req, $taobao_token->api_taobao_token_get->taobao_token);
			print_r($resp);
		}
		else{
			$this->redirect('?route=account/login');
		}
	}
	
	public function mail(){
		$mail = new Mail();
		//$mail->protocol = 'mail';
		//$mail->parameter = 'spark@shangbox.com';
		$mail->hostname = 'smtp.exmail.qq.com';
		$mail->username = 'spark@shangbox.com';
		$mail->password = 'bo12354';
		$mail->port = '25';
		$mail->timeout = '10';				
		$mail->setTo('spark@pingcoo.com');
		$mail->setFrom('spark@shangbox.com');
		$mail->setSender('周晓波');
		$mail->setSubject('现在很快啦');
		$mail->setText('你好你好你好你好');
		$mail->send();
		
	}
	
}
?>