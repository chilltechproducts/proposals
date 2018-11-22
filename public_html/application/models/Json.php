<?php
class Json extends CI_Model {
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
}        
