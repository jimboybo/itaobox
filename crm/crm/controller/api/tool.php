<?php  
class ControllerApiTool extends Controller {
	public function index() {
		$this->api->status(49);
	}
	
	//日志
	public function ilog(){
		if($this->request->get){
			if(isset($this->request->get['msg'])){
				$msg = $this->request->get['msg'];
			}else{
				$this->api->status(48,'msg');
				return;
			}
		}
		if($this->request->post){
			if(isset($this->request->post['msg'])){
				$msg = $this->request->post['msg'];
			}else{
				$this->api->status(48,'msg');
				return;
			}
		}
		$this->ilog->info('['.$this->utils->getip().'] - '.$msg);
		
		echo $this->api->result('api_tool_ilog',true);
	}
	
}
?>