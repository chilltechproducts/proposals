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
        public function find_part(){
           $data = $this->db->query("select * from parts where part_name like '%" . $this->input->get('term') . "%' or model_number like '%" . $this->input->get('term') . "%' order by part_name asc limit 10")->result_array(); 
          echo json_encode($data);
        }
        public function find_service(){
           $data = $this->db->query("select * from services where service_name like '%" . $this->input->get('term') . "%' and (status=1 or user_id=" . $this->session->userdata['user_id'] . ")order by service_name asc limit 10")->result_array(); 
          echo json_encode($data);
        }
        public function user_lookup(){
                $data = $this->db->query("select user_id, concat(first_name, ' ', last_name) as user_name, company_name, avatar, logo from users where company_name  like '" . $this->input->get('term') . "%' or  concat(first_name, ' ', last_name) like '" . $this->input->get('term') . "%'")->result_array();
                header('content-type: application/json');
                echo json_encode($data);
        
        }
         public function service_entry_date(){
          
               
                if(empty($this->session->userdata['user_id'])){
                    return;
                }
               
                if(!empty($this->input->post('service_date'))){
              
                        $service_date = $this->input->post('service_date') . ':00';
                        

                            
                        if(is_numeric($this->uri->segment(4))){
                            $data = array('tech_id' => $this->input->post('technician_id'), 'service_date' => $service_date, 'service_performed' => $this->input->post('service_performed'), 'location_id' => $this->uri->segment(3));
                            
                            $where = "location_id = " . $this->uri->segment(3) . " AND id = " . $this->uri->segment(4); 
                            $sql = $this->db->update_string("service_dates", $data, $where);
                        }else{
                            $data = array('tech_id' => $this->input->post('technician_id'), 'service_date' => $service_date, 'service_performed' => $this->input->post('service_performed'), 'location_id' => $this->uri->segment(3));
                            $sql = $this->db->insert_string('service_dates', $data);
                        
                        }
                        
                        header('content-type: application/json');
                        $this->db->query($sql);
                        echo json_encode(array('success' => 1, 'sid' => $this->db->insert_id()));
                        exit;
                }
                return;
        }   
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
           redirect('/main/login?ajax_set=1');
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
                    redirect('/main/login?ajax_set=1');
                    return;
                }
                ;
                if(!empty($this->input->post('service_date'))){
              
                        $service_date = $this->input->post('service_date') . ':00';
                        

                            
                        if(is_numeric($this->uri->segment(4))){
                            $data = array('tech_id' => $this->input->post('tech_id'), 'service_date' => $service_date, 'service_performed' => $this->input->post('service_performed'), 'location_id' => $this->uri->segment(3));
                            
                            $where = "location_id = " . $this->uri->segment(3) . " AND id = " . $this->uri->segment(4); 
                            $sql = $this->db->update_string("service_dates", $data, $where);
                        }else{
                            $data = array('tech_id' => $this->input->post('tech_id'), 'service_date' => $service_date, 'service_performed' => $this->input->post('service_performed'), 'location_id' => $this->uri->segment(3));
                            $sql = $this->db->insert_string('service_dates', $data);
                        
                        }
                        header('content-type: application/json');
                        $this->db->query($sql);
                        echo json_encode(array('success' => 1));
                        exit;
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
           redirect('/main/login?ajax_set=1');
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
           redirect('/main/login?ajax_set=1');
           return;
          }
          $uid = $this->input->get('uid')?$this->input->get('uid'):$this->session->userdata['user_id'] ;
          $this->load->view('parts/search_parts');
          $this->load->view('parts/parts_list', array('uid' => $uid));
        }  
        public function diag_json(){
        
           $data = array();
           
           
             $jsons = $this->db->query("select service_date, json from service_dates where location_id=" . $this->uri->segment(3) . " and json is not null")->result_array();
           
           $data['dates'] = array();
           $data['services'] = array();
           foreach($jsons as $j => $json){
           
              $arr = json_decode($json['json'], true);
              
              
              $key = $json['service_date'];
              $data['dates'][] = $key;
              
              $data[$key] = array();
              
              foreach($arr as $a => $v){
               if(!array_key_exists($a, $data[$key])){
                  $data[$key][$a] =$v;
                  $data['services'][$a][] = array($key => $v);
               }
              
              }
           
           }
           header("content-type: application/json");
           echo json_encode($data);
        }
        public function getkwH(){
        ob_start();
            $handle = curl_init();

            curl_setopt($handle, CURLOPT_URL, $this->input->post('url'));

            $data = curl_exec($handle);
            
          
            ob_end_clean();
            echo $data;
            exit;
            $doc = new DOMDocument();
                $doc->loadHTML($data);

                $xpath = new DOMXpath($doc);
                
                $elements = $xpath->query("/html/body/div[@id='urdbUtilityInfo']");
                
                print_r($elements);

            curl_close($handle);
        
        }
        public function find_parts_json(){
        $this->load->model('Parts');
          if(empty($this->session->userdata['user_id'])){
           redirect('/main/login?ajax_set=1');
           return;
          }
          
          $s=$this->input->get('s')?$this->input->get('s'):0;
          $l = 25;
          $o = 'install_date';
          
          
          $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
          $filter = '';
          if(count($this->input->post())>0){
            
            $o = 0;
            foreach($this->input->post() as $k => $v){
              $o++;
               if(!empty($v)){
                 if ($o == 1){
                     $filter .= ' where ';
                    $filter .= $v . ' like \'' . $v . '%\'';
               }else{
                    $filter .= ' and ' . $v . ' like \'' . $v . '%\'';
               }
            }
          
          }
          }
          $sql = "select distinct model_number, part_data.* from part_data $filter order by part_name asc limit 0, 50";
          parse_str($this->input->post('search_data'), $arr);
        
          
          $filters = $this->Parts->SearchFilters($arr);
          
          
          $replaces = array($arr['customer_id']?$arr['customer_id']:'' => 'customer_id', $uid => 'dealer_id', $this->input->post('sid') => 'salesman_id', $this->input->post('technician_id') => 'technician_id', $this->input->post('maintenence_id') => 'maintanence_id', $this->session->userdata['user_id'] => 'uid');
          foreach($replaces as $r => $replace){
            $sql = str_replace("[[" . $replace . "]]", $r, $sql);
            
          }
          $sql = str_replace("[[start]]", $s, $sql);
          $sql = str_replace("[[limit]]", $l, $sql);
          $sql = str_replace("[[filter]]", $filters, $sql);
        
          $sql = str_replace("[[order_by]]", $o, $sql);
          //echo $sql;
          //return;
         // header("content-type: application/json");
           $data = array();
           $data['part_data'] = $this->db->query($sql)->result_array();
           $data['filters'] = $filters;
           //$data['part_data'][$k]['json']
           //exit;
           echo json_encode($data);
        }
        public function get_parts(){
        $this->load->model('Parts');
          if(empty($this->session->userdata['user_id'])){
           redirect('/main/login?ajax_set=1');
           return;
          }
          
          $s=$this->input->get('s')?$this->input->get('s'):0;
          $l = 25;
          $o = 'install_date';
          
          
          $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
          
          $sql = $me['level_info']['part_sql'];
          parse_str($this->input->post('search_data'), $arr);
        
          
          $filters = $this->Parts->SearchFilters($arr);
          
          
          $replaces = array($arr['customer_id']?$arr['customer_id']:'' => 'customer_id', $uid => 'dealer_id', $this->input->post('sid') => 'salesman_id', $this->input->post('technician_id') => 'technician_id', $this->input->post('maintenence_id') => 'maintanence_id', $this->session->userdata['user_id'] => 'uid');
          foreach($replaces as $r => $replace){
            $sql = str_replace("[[" . $replace . "]]", $r, $sql);
            
          }
          $sql = str_replace("[[start]]", $s, $sql);
          $sql = str_replace("[[limit]]", $l, $sql);
          $sql = str_replace("[[filter]]", $filters, $sql);
        
          $sql = str_replace("[[order_by]]", $o, $sql);
          //echo $sql;
          //return;
         // header("content-type: application/json");
           $data = array();
           $data['part_data'] = $this->db->query($sql)->result_array();
           $data['filters'] = $filters;
           //$data['part_data'][$k]['json']
           //exit;
           echo json_encode($data);
        }
        public function find_parts(){
        
          $this->load->view('parts/search_all_parts', array('data' => $data));
          $this->load->view('parts/all_parts', array('data' => $data));
        }
        public function delete_image(){
           if(empty($this->uri->segment(4))){
             echo "Please Confirm you want to delete this Photo!<br /><a href=\"javascript:;\" onclick=\"$('#modalContainer').remove();\">Cancel</a>";
           }else{
           
             $this->db->query("delete from part_photos where id=" . $this->uri->segment(3));
             
           }
        
        }
        public function product_photos(){
          $this->load->model('Parts');
                $data['part_data'] = $this->Parts->getPart($this->uri->segment(3));
               
                $data['photos'] = $this->db->query("select * from part_photos where model_number='" . $data['part_data']['model_number'] . "'")->result_array();
          $this->load->view('parts/photos', array('me' => $me, 'data' => $data));
        }
        public function add_part(){
        if(empty($this->session->userdata['user_id'])){
           redirect('/main/login?ajax_set=1');
           return;
          }
           $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
           $data = array('part_data' => array(), 'warranty_data' => array(), 'photos' => array());
           
           if(!empty($this->uri->segment(3))){
                $this->load->model('Parts');
                $data['part_data'] = $this->Parts->getPart($this->uri->segment(3));
               
                $data['photos'] = $this->db->query("select * from part_photos where model_number='" . $data['part_data']['model_number'] . "'")->result_array();
             // print_r($data['part_data']);
                $this->load->model('Part_Warranty'); 
                if(!empty($this->Part_Warranty->getByModel($data['part_data']['model_number'], $this->uri->segment(3)))){
                    $data['warranty_data'] = $this->Part_Warranty->getByModel($data['part_data']['model_number'], $this->uri->segment(3));
                }
                
           }
          
           
           if(empty($this->input->post('json'))){
                 $this->load->view('parts/photos', array('me' => $me, 'data' => $data));
                $this->load->view('parts/add_part', array('me' => $me, 'data' => $data));
                $this->load->view('parts/part_warranty', array('me' => $me, 'data' => $data));
               
           }else{
              header("content-type: application/json");
              echo json_encode(array('data' => $data));
           
           }
        }
        public function product_lookup(){
          $this->load->model('Parts');
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
       
     
          if(in_array($column, $columns)){
        //  echo "select * from column_to_table_reference where reference_column='" .  $column . "' order by id desc limit 1";
            $meta = $this->db->query("select * from column_to_table_reference where reference_column='" .  $column . "' order by id desc limit 1")->result_object();
            
           
            if(count($meta)==0){
              return;
            }
          // echo "select " . $meta[0]->column_name . " from " . $meta[0]->table_name . " " . $meta[0]->joins . " where " . $meta[0]->where_name . " like '" . $this->input->get('term') . "%' order by " . $meta[0]->order_by_name . " asc limit 10";
           // exit;
           $filters = $this->Parts->SearchFilters($this->input->get('search_data'));
           
            $data = $this->db->query("select distinct " . $meta[0]->column_name . " from " . $meta[0]->table_name  . " " . $meta[0]->joins . " where " . $meta[0]->where_name .  " like '" . $this->input->get('term') . "%' " . $filters . " order by " . $meta[0]->order_by_name . " asc limit 10")->result_array();
          
          }else{
            return;
          }
          header("content-type: application/json");
          echo json_encode($data);
          return;
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
                    redirect(site_url().'main/login?ajax_set=1');
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
     if($this->input->post('user_id') == 0 & $me['level_id'] <= 2 & count($this->input->post())>0){
              $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
             
              $this->load->library('Password');
                               
                                $id = $this->user_model->insertUser($clean); 
                                $clean['user_id'] = $id;
                                $this->user_model->updateUserInfo($clean);
                                
                                $this->db->query("update users set company_name='" . addslashes($clean['company_name']) . "', salesman_id=" . $this->session->userdata['user_id'] . ", dealer_id=" . $me['dealer_id'] . " where user_id=" . $id);
                                
                               
                                
                                $auto_password= time() . rand(1000, 9999); 
                               
                                $hashed['password'] = $this->password->create_hash($auto_password);     
                                $hashed['user_id'] = $clean['user_id'];
                                $this->user_model->updatePassword($hashed);
                                 $token = $this->user_model->insertToken($clean['user_id']);                                        
                                
                                $qstring = $this->base64url_encode($token);     
                                
                                
                                $url = site_url() . 'main/reset_password/token/' . $qstring;
                                $link = '<a href="' . $url . '">' . $url . '</a>'; 
                                        
                                $message = '';                     
                                $message .= '<strong>You have been signed up with our website</strong><br>';
                                $message .= '<strong>Please click:</strong> ' . $link . ' To change your password. Your current password is ' . $auto_password;                          

                               
                                
                                $this->load->model('Emailer');
                                echo $clean['email'];
                                $this->Emailer->send('suppport@chilltechproducts.com', $clean['email'], 'You have been registered on ChillTech Products', $message, 'html', 'edward.goodnow@gmail.com');
                                
                                
                                redirect('/ajax/myprofile/' . $id . '/?alert=1');
                                exit;
     
     
     }
          if(empty($me['user_id'])){
                //    $this->load->view('header');
                    $this->load->view('login');
                //    $this->load->view('footer');
                exit;
          }
          if(!empty($this->input->post('user_id'))){
             $post = $this->security->xss_clean($this->input->post(NULL, TRUE));
            $this->user_model->updateUserInfo($post);
          
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
