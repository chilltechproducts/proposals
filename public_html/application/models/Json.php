<?php
class Json extends CI_Model {
       public function Users($owner, $level){
       
         if(!empty($this->input->post('dealer_id')) & $owner['level_id'] == 1){
                $qry = "select  email, first_name, last_name, s.status, user_id, business_phone, company_name, city, state, postal_code, street_address, street_address2 from users left join user_status s on s.id=users.status where dealer_id=" . $this->input->post('dealer_id') . " and level_id like '%$level%' order by email asc";
         
         }else
         
         if($owner['level_id'] == 1){
                $qry = "select email, first_name, last_name, s.status, user_id, business_phone, company_name, city, state, postal_code, street_address, street_address2 from users left join user_status s on s.id=users.status where level_id like '%$level%' order by email asc";
         }else
         if($owner['level_id'] == 2){
            $qry = "select  email, first_name, last_name, s.status, user_id, business_phone, company_name, city, state, postal_code, street_address, street_address2 from users left join user_status s on s.id=users.status where dealer_id=" . $owner['user_id'] . " and level_id like '%$level%' order by email asc";
          }else if($owner['level_id'] > 2){
            $qry = "select  email, first_name, last_name, s.status, user_id, business_phone, company_name, city, state, postal_code, street_address, street_address2 from users left join user_status s on s.id=users.status where dealer_id=" . $owner['dealer_id'] . " and level_id like '%$level%' order by email asc";
          }
            $data = $this->db->query($qry)->result_object();
           return $data;
       }
}        
