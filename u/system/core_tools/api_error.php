<?php
class ApiError{
    
    public function __construct(){
        
    }
    public function execute($err_code){
        switch ($err_code){
            case 27:
                $this->_session();
                break;  
            case value:
                break;
            default:
                break;
        }
    }
    public function _session(){
        redirect('?route=manage/user/login');
    }
}
?>