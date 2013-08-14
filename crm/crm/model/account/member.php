<?php
class ModelAccountMember extends Model {
    public function addMember($data){
        $this->db->query('Insert into '.DB_PREFIX.'members set u_member_id = '.$data['id'].', add_date = unix_timestamp(NOW())');
      	
		$customer_id = $this->db->getLastId();
        
        return $customer_id;
    }
    
    public function getMemberById($member_id){
        $member_query = $this->db->query('SELECT * FROM '.DB_PREFIX.'members WHERE member_id = '.$member_id);
        return $member_query->row;
    }
}
?>