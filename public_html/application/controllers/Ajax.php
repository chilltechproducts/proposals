<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
        
        public $status; 
        public $roles;
    
        function __construct(){
            parent::__construct();
            $this->load->model('User_model', 'user_model', TRUE);
            $this->load->library('form_validation');    
            $this->load->library('session');
            $this->load->helper('url');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->status = $this->config->item('status'); 
            $this->roles = $this->config->item('roles');
        }      
    
	
        
        protected function _islocal(){
            return strpos($_SERVER['HTTP_HOST'], 'local');
        }
       /* public function createUnits(){
        
          $units = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT']  . '/public/units-of-measure_json.json'), TRUE);
          foreach($units as $array){
          echo "insert into units values(null, '" . $array['CommonCode'] . "', '" . $array['Description'] . "',  '" . $array['LevelAndCategory'] . "', '" . $array['Name'] . "', '" . $array['Quantity'] . "', '" . $array['Sector'] . "'";
            $this->db->query("insert into units values(null, '" . $array['CommonCode'] . "', '" . $array['Description'] . "',  '" . $array['LevelAndCategory'] . "', '" . $array['Name'] . "', '" . $array['Quantity'] . "', '" . $array['Sector'] . "')");
          }
        
        }*/
        public function save_diagnotics(){
          $data=array();
           foreach($this->input->post('key') as $k => $value){
             if(!empty($value) & !empty($this->input->post('value[' . $k . ']')) & !empty($this->input->post('unit[' . $k . ']'))){
               $data[$value] = $this->input->post('value[' . $k . ']') . $this->input->post('unit[' . $k . ']');
             
             }
           
           }
           $json = json_encode($data);
         
           $this->db->query("update service_dates set json='" . $json . "' where id=" . $this->uri->segment(4) . " and location_id=" . $this->uri->segment(3));
           redirect('/ajax/show_diagnostic_data/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
        }
        public function add_record(){
          $units = $this->db->query("select * from units order by Name asc")->result_array();
          $this->load->view('parts/add_record', array('units' => $units));
        }
         public function show_diagnostic_data(){
         if(empty($this->session->userdata['user_id'])){
           redirect('/main/login?ajax=1');
           return;
          }
          $filter = '';
          if(!empty($this->uri->segment(4))){
            $filter = " and id=" . $this->uri->segment(4);
          }
          $data = $this->db->query("select json from service_dates where location_id=" . $this->uri->segment(3) . $filter)->result_object();
          
       
          $units = $this->db->query("select * from units order by Name asc")->result_array();
          
        
          $this->load->view('parts/diagnostics_form_values', array('data' => $data, 'units' => $units));
        }
        public function add_service_entry(){
         if(empty($this->session->userdata['user_id'])){
           redirect('/main/login?ajax=1');
           return;
          }
          $filter = '';
          if(!empty($this->uri->segment(4))){
            $filter = " and id=" . $this->uri->segment(4);
          }
          $data = $this->db->query("select * from service_dates where location_id=" . $this->uri->segment(3))->result_object();
          $this->load->view('parts/diagnostics_form', array('data' => $data));
        }
        public function service_history(){
        if(empty($this->session->userdata['user_id'])){
           redirect('/main/login?ajax=1');
           return;
          }
          
          $data = $this->db->query("select *, (select user_id from users where dealer_id=service_dates.tech_id or pd.service_tech_id=service_dates.tech_id or dealer_id=pd.dealer_id or user_id=pd.service_tech_id or pd.maintanence_id=user_id or pd.customer_id=user_id order by level_id asc limit 1) as uid from service_dates left join part_data pd on pd.location_id=service_dates.location_id where service_dates.location_id=" . $this->input->get('lid'))->result_array();
        
          header('content-type: application/json');
           // if(empty($data[0]['user_id'])){
            
            //echo json_encode(array('error' => 'You don\'t have permission to view this part.'));
            
           // }else{
            echo json_encode(array('data' => $data));
           
          //  }
        }
        public function my_parts(){
          if(empty($this->session->userdata['user_id'])){
           redirect('/main/login?ajax=1');
           return;
          }
          $uid = $this->input->get('uid')?$this->input->get('uid'):$this->session->userdata['user_id'] ;
          $this->load->view('parts/search_parts');
          $this->load->view('parts/parts_list', array('uid' => $uid));
        }  
        public function get_parts(){
          if(empty($this->session->userdata['user_id'])){
           redirect('/main/login?ajax=1');
           return;
          }
          
          $s=$this->input->get('s')?$this->input->get('s'):0;
          $l = 25;
          $o = $this->input->get('o')?$this->input->get('o'):'install_date';
          
          
          $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
          
          $sql = $me['level_info']['part_sql'];
      
          
          $replaces = array('customer_id', 'dealer_id', 'salesman_id', 'technician_id', 'maintanence_id', 'uid');
          foreach($replaces as $replace){
            $sql = str_replace("[[" . $replace . "]]", $this->session->userdata['user_id'], $sql);
            
          }
          $sql = str_replace("[[start]]", $s, $sql);
          $sql = str_replace("[[limit]]", $l, $sql);
          $sql = str_replace("[[order_by]]", $o, $sql);
          
          header("content-type: application/json");
           $data = array();
           $data['part_data'] = $this->db->query($sql)->result_array();
           echo json_encode($data);
        }
        public function add_part(){
        if(empty($this->session->userdata['user_id'])){
           redirect('/main/login?ajax=1');
           return;
          }
           $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
           $data = array('part_data' => array(), 'warranty_data' => array(), 'photos' => array());
           
           if(!empty($this->uri->segment(3))){
             $this->load->model('Parts');
              $data['part_data'] = $this->Parts->getPart($this->uri->segment(3));
             // print_r($data['part_data']);
              $this->load->model('Part_Warranty'); 
                if(!empty($this->Part_Warranty->getByModel($data['part_data']['model_number'], $this->uri->segment(3)))){
                    $data['warranty_data'] = $this->Part_Warranty->getByModel($data['part_data']['model_number'], $this->uri->segment(3));
                }
           }
          
           
           if(empty($this->input->post('json'))){
           
                $this->load->view('parts/add_part', array('me' => $me, 'data' => $data));
                $this->load->view('parts/part_warranty', array('me' => $me, 'data' => $data));
           
           }else{
              header("content-type: application/json");
              echo json_encode(array('data' => $data));
           
           }
        }
        public function product_lookup(){
          if(empty($this->uri->segment(2))){
            return;
          }
          $columns_data = $this->db->query("show columns from part_data")->result_array();
          
          $columns = array();
          foreach($columns_data as $col){
            $columns[] = $col['Field'];
          }
       //   print_r($columns);
            $column = str_replace('_name', '_id', $this->uri->segment(3));
       //echo $column;
        
          if(in_array($column, $columns)){
      //    echo "select * from column_to_table_reference where reference_column='" .  $column . "' order by id desc limit 1";
            $meta = $this->db->query("select * from column_to_table_reference where reference_column='" .  $column . "' order by id desc limit 1")->result_object();
            
         //  print_r($meta);
            if(count($meta)==0){
              return;
            }
         //  echo "select " . $meta[0]->column_name . " from " . $meta[0]->table_name . " where " . $meta[0]->where_name . " like '" . $this->input->get('term') . "%' order by " . $meta[0]->order_by_name . " asc limit 10";
           // exit;
            $data = $this->db->query("select distinct " . $meta[0]->column_name . " from " . $meta[0]->table_name . " where " . $meta[0]->where_name . " like '" . $this->input->get('term') . "%' order by " . $meta[0]->order_by_name . " asc limit 10")->result_array();
          
          }else{
            return;
          }
          header("content-type: applcation/json");
          echo json_encode($data);
        } 
        public function register()
        {
             
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');    
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');    
                       
            if ($this->form_validation->run() == FALSE) {   
               $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
       
          if(empty($me['user_id'])){
                   // $this->load->view('header');
                    $this->load->view('login');
                    //$this->load->view('footer');
                exit;
          }
          if($me['level_id'] <=2 & $this->input->get('user_id') >0){ //edit existing user as admin or dealer
            $data = $this->user_model->getUserInfo($this->input->get('user_id'));
          
          }else if($me['level_id'] <=2 & $this->input->get('user_id') == 0){ // create new user profile
                $data = array('user_id' => 0); //no user data needed / empty form
               
          
          }else if($me['level_id'] <=2 & $this->input->get('user_id') == $this->session->userdata['user_id']){//admin or dealer editing their own profile
            $data = $this->user_model->getUserInfo($this->session->userdata['user_id']);
          
          }else if($me['level_id'] > 2){
        
            $data = $me;
          }
          
          $user_levels = $this->user_model->user_levels($me['level_id']);
         // $this->load->view('header');
          $this->load->view('profile/edit/form', array('data' => $data, 'me' => $me, 'user_levels' => $user_levels));
            }else{                
                if($this->user_model->isDuplicate($this->input->post('email'))){
                    $this->session->set_flashdata('flash_message', 'User email already exists');
                    redirect(site_url().'main/login');
                }else{
                   // echo $this->user_model->user_level(        $this->input->post('level_id')        );
                   // exit;
                    $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
                    $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
                    $id = $this->user_model->insertUser($clean); 
                    $token = $this->user_model->insertToken($id);                                        
                    
                    $qstring = $this->base64url_encode($token);                    
                    $url = site_url() . 'main/complete/token/' . $qstring;
                    $link = '<a href="' . $url . '">' . $url . '</a>'; 
                
                    $message = '';                     
                    $message .= '<strong>You have added a(n) ' . $this->user_model->user_level(        $this->input->post('level_id')        ) . ' to your account</strong><br>';
                    $subect = 'New ' . $this->user_model->user_level(        $this->input->post('level_id')        ) . ' on Your  ChillTechProducts Account';
                    $this->load->model('Emailer');
                    $this->Emailer->send('jon@chilltechproducts.com', $me['email'], $subject, $message);

                    
                    
                    
                    $message = '';                     
                    $message .= '<strong>You have been added as a(n) ' . $this->user_model->user_level(        $this->input->post('level_id')        ) . ' on ' . $me['first_name'] . ' ' . $me['last_name'] . '\'s ChillTechProducts account</strong><br>';
                    $message .= $link;
                    $subect = 'You have been added as a(n) ' . $this->user_model->user_level(        $this->input->post('level_id')        ) . ' on a  ChillTechProducts Account';
                    
                    

                    $this->Emailer->send('jon@chilltechproducts.com', $this->input->post('email'), $subject, $message);
                    
                    
                    header('content-type: application/json');
                    echo json_encode(array('success' => $message));
                    
                    exit;
                     
                    
                };              
            }
        }
     public function sales_staff(){
       $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
        header("content-type: application/json");
        
        $this->load->model('Json');
        $users = $this->Json->Users( $me, ''); //use like here for the level_id...so it can match all users when necessary
        echo json_encode(array('data' => $users));
     
     }
     public function cities(){
        $data = $this->db->query("select distinct( concat(city, ', ', state, ' ', country, ' ', zipcode) )as description, city, state, zipcode, country from zipcodes where concat (city, ', ', state) like '" . $this->input->get('term') . "%' and concat(city, ', ', state, ' ', country, ' ', zipcode) != 'null' and concat(city, ', ', state, ' ', country, ' ', zipcode) != '' order by city asc limit 10")->result_array();
        header("content-type: application/json");
        echo json_encode($data);
     }
     public function zipcodes(){
        $data = $this->db->query("select distinct( concat(city, ', ', state, ' ', country, ' ', zipcode) )as description, city, state, zipcode, country from zipcodes where zipcode like '" . $this->input->get('term') . "%' and concat(city, ', ', state, ' ', country, ' ', zipcode) != 'null' and concat(city, ', ', state, ' ', country, ' ', zipcode) != ''  order by zipcode asc limit 10")->result_array();
        header("content-type: application/json");
        echo json_encode($data);
     }
     public function myprofile()
        {
          $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
       
          if(empty($me['user_id'])){
                //    $this->load->view('header');
                    $this->load->view('login');
                //    $this->load->view('footer');
                exit;
          }
          if($me['level_id'] <=2 & $this->input->get('user_id') >0){ //edit existing user as admin or dealer
            $data = $this->user_model->getUserInfo($this->input->get('user_id'));
          
          }else if($me['level_id'] <=2 & $this->input->get('user_id') == 0){ // create new user profile
                $data = array('user_id' => 0); //no user data needed / empty form
               
          
          }else if($me['level_id'] <=2 & $this->input->get('user_id') == $this->session->userdata['user_id']){//admin or dealer editing their own profile
            $data = $this->user_model->getUserInfo($this->session->userdata['user_id']);
          
          }else if($me['level_id'] > 2){
        
            $data = $me;
          }
          
          $user_levels = $this->user_model->user_levels($me['level_id']);
          $states = $this->db->query("select distinct(state), id from zipcodes where country='United States' order by state asc")->result_array();
          $states_out = array();
          foreach($states as $k => $arr){
            if(!in_array($arr['state'], $states_out)){
              $states_out[$arr['state']] = $arr['state'];
            }
          }
         // $this->load->view('header');
          $this->load->view('profile/edit/form', array('data' => $data, 'me' => $me, 'user_levels' => $user_levels, 'states' => $states_out));
          //$this->load->view('footer');
            
        }
     
        
    public function base64url_encode($data) { 
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    } 

    public function base64url_decode($data) { 
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
    }       
}
