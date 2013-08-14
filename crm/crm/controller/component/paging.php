<?php   
class ControllerComponentPaging extends Controller {
	protected function index() {
		$this->template = 'header.html';
    	$this->render();
	}
	
	public function common($option){
		$this->data['id'] = isset($option['id'])?$option['id']:'undefined_paging_id_'.time();
		$this->data['p_component'] = isset($option['p_component'])?$option['p_component']:'undefined_paging_p_component'.time();//p属性，帅选器

		$this->data['count'] = isset($option['count'])?$option['count']:1;
		$size = isset($option['size'])?$option['size']:10;
		$this->data['curr_page'] = isset($option['curr_page'])?$option['curr_page']:1;
		$this->data['prev_page'] = ($this->data['curr_page']-1)<=0?1:$this->data['curr_page']-1;
		$this->data['total_page'] = ceil($this->data['count']/$size);
		$this->data['next_page'] = ($this->data['curr_page']+1)<=$this->data['total_page']?($this->data['curr_page']+1):$this->data['total_page'];
		
		$this->data['url'] = isset($option['url'])?$option['url']:'';
		
		$this->template = 'component/paging/common.html';
    	$this->render();
	}
}
?>