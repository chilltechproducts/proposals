<?php
class Parts extends CI_Model {
       public function Users($owner, $level){
       
         if(!empty($this->input->post('dealer_id')) & $owner['level_id'] == 1){
                $qry = "select " . $owner['level_info']['selectable_columns'] . " from users left join user_status s on s.id=users.status where dealer_id=" . $this->input->post('dealer_id') . " and level_id like '%$level%' order by email asc";
         
         }else
         
         if($owner['level_id'] == 1){
                $qry = "select " . $owner['level_info']['selectable_columns'] . " from users left join user_status s on s.id=users.status where level_id like '%$level%' order by email asc";
         }else
         if($owner['level_id'] == 2){
            $qry = "select " . $owner['level_info']['selectable_columns'] . " from users left join user_status s on s.id=users.status where dealer_id=" . $owner['user_id'] . " and level_id like '%$level%' order by email asc";
          }else if($owner['level_id'] > 2){
            $qry = "select " . $owner['level_info']['selectable_columns'] . " from users left join user_status s on s.id=users.status where dealer_id=" . $owner['dealer_id'] . " and level_id like '%$level%' order by email asc";
          }
            $data = $this->db->query($qry)->result_object();
           return $data;
       }
        public function getPart($part_id){
         return $this->db->query("select part_data.*, 
                                        (select company_name from users where user_id=part_data.dealer_id order by user_id desc limit 1) as dealer_name,
                                        (select concat(first_name, ' ', last_name) from users where user_id=part_data.salesman_id order by user_id desc limit 1) as salesman_name,
                                        (select concat(first_name, ' ', last_name) from users where user_id=part_data.customer_id order by user_id desc limit 1) as customer_name,
                                        (select concat(first_name, ' ', last_name) from users where user_id=part_data.installer_id order by user_id desc limit 1) as installer_name,
                                        (select manufacturer_name from manufacturers where manufacturer_id=part_data.manufacturer_id order by part_data.manufacturer_id desc limit 1) as manufacturer_name
                                        
                                        from part_data where location_id=" . $part_id)->result_array()[0];
       }
}        
