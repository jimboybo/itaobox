<?php
class ControllerApiToken extends Controller {
    public function index() {
        $this->api->status(49);
    }
    public function get(){
		$this->load->model('member');
		if(isset($this->request->get['token'])){
			$token = $this->request->get['token'];
		}
		else{
			$this->api->status(48,'$token');
			return;
		}
        
        if(isset($this->request->get['login_from_id'])){
            $login_from_id = $this->request->get['login_from_id'];
        }
        else{
            $this->api->status(48,'$login_from_id');
			return;
        }
		echo $this->api->result('api_token_get',$this->model_member->getMemberByToken(array('token'=>$token,'login_from_id'=>$login_from_id)));
    }
}
?>