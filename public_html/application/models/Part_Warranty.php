<?php
class Part_Warranty extends CI_Model {
       public function getPart($part_id){
         return $this->db->query("select part_data.*, 
                                        (select company_name from users where user_id=part_data.dealer_id order by user_id desc limit 1) as dealer_name,
                                        (select concat(first_name, ' ', last_name) from users where user_id=part_data.salesman_id order by user_id desc limit 1) as salesman_name,
                                        (select concat(first_name, ' ', last_name) from users where user_id=part_data.salesman_id order by user_id desc limit 1) as salesman_name,
                                        (select concat(first_name, ' ', last_name) from users where user_id=part_data.installer_id order by user_id desc limit 1) as installer_name,
                                        
                                        from part_data where location_id=" . $part_id)->result_array()[0];
       }
       public function getByModel($mid, $pid){
        
        }
}        
