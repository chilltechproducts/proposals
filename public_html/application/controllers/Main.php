<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
        
        public $status; 
        public $roles;
    
        function __construct(){
            parent::__construct();
            $this->load->model('User_model', 'user_model', TRUE);
            $this->load->library('form_validation');    
            $this->load->library('session');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->status = $this->config->item('status'); 
            $this->roles = $this->config->item('roles');
        }      
    
	public function index()
	{   
	
            if(empty($this->session->userdata['email'])){
             //  redirect(site_url().'/main/login');
            }            
            /*front page*/
            
            
              $data = array();
            if(!empty($this->session->userdata['user_id'])){
                $data['user'] = $this->user_model->getUserInfo($this->session->userdata['user_id']);
            }
	    
            $this->load->view('welcome_header');            
            $this->load->view('index', array('data' => $data));
            $this->load->view('footer');
	}
	public function presentation(){
        if(empty($this->input->get('ajax_set'))){
            $this->load->view('header');
        }
        
        $data = array();
        $me = $this->db->query("select users.*, (select distinct zipcodes.state as state from zipcodes where zipcodes.zipcode=users.postal_code order by id desc limit 1) as state from users where user_id=" . $this->session->userdata['user_id'])->result_array();
        
        
        
        $data[1]['text'] = '<div id="dealer_info"><div>' . $me[0]['company_name'] . '<br />' ;
        $data[1]['text'] .= '' . $me[0]['street_address'] . $me[0]['street_address2'] . '<br />' ;
        $data[1]['text'] .= '' . $me[0]['city'] . ', '. $me[0]['state'] . ' ' . $me[0]['postal_code'] . '<br />' ;
        $data[1]['text'] .= '' . $me[0]['business_phone'] . '<br />' ;
        if(!empty($me[0]['user_website'] )){
            $data[1]['text'] .= '' . $me[0]['user_website'] . '<br />' ;
        }
        if(!empty($me[0]['user_facebook'] )){
            $data[1]['text'] .= ' ' . $me[0]['user_facebook'] . '<br />' ;
        }
        if(!empty($me[0]['email'] )){
            $data[1]['text'] .= '' . $me[0]['email'] . '<br />' ;
        }
        $data[1]['text'] .= '</div>';
        if(!empty($me[0]['logo'])){
          $data[1]['text'] .= '<img src="' . $me[0]['logo'] . '" class="logo" />';
        }
        if(!empty($me[0]['avatar'])){
          $data[1]['text'] .= '<img class="avatar" src="' . $me[0]['avatar'] . '" />';
        }
        $data[1]['text'] .= '</div>';
        
        $this->load->view('presentation', array('data' => $data, 'me' => $me[0]));
	}
    public function schedule()
	{
	    $this->load->view('welcome_header');
		$this->load->view('schedule');
	}
        
    public function register()
        {
             
            $this->form_validation->set_rules('firstname', 'First Name', 'required');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required');    
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');    
                       
            if ($this->form_validation->run() == FALSE) {   
               
                $this->load->view('register');
              
            }else{                
                if($this->user_model->isDuplicate($this->input->post('email'))){
                    $this->session->set_flashdata('flash_message', 'User email already exists');
                    redirect(site_url().'main/login?ajax_set=' . $_REQUEST['ajax_set']);
                }else{
                    
                    $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
                    $id = $this->user_model->insertUser($clean); 
                    $token = $this->user_model->insertToken($id);                                        
                    
                    $qstring = $this->base64url_encode($token);                    
                    $url = site_url() . 'main/complete/token/' . $qstring;
                    $link = '<a href="' . $url . '">' . $url . '</a>'; 
                               
                    $message = '';                     
                    $message .= '<strong>You have signed up with our website</strong><br>';
                    $message .= '<strong>Please click:</strong> ' . $link;                          

                    echo $message; //send this in email
                    exit;
                     
                    
                };              
            }
        }
        
        
        protected function _islocal(){
            return strpos($_SERVER['HTTP_HOST'], 'local');
        }
        
        public function complete()
        {                                   
            $token = base64_decode($this->uri->segment(3));       
            $cleanToken = $this->security->xss_clean($token);
         
            $user_info = $this->user_model->isTokenValid($cleanToken); //either false or array();           
          
            if(!$user_info){
                $this->session->set_flashdata('flash_message', 'Token is invalid or expired');
                redirect(site_url().'main/login?ajax_set=' . $_REQUEST['ajax_set']);
            }            
            $data = array(
                'firstName'=> $user_info['first_name'], 
                'email'=>$user_info['email'], 
                'user_id'=>$user_info['user_id'], 
                'token'=>$this->base64url_encode($token)
            );
        
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');              
            
            if ($this->form_validation->run() == FALSE) {   
             
                $this->load->view('complete', $data);
                
            }else{
                
                $this->load->library('password');                 
                $post = $this->input->post(NULL, TRUE);
                
                $cleanPost = $this->security->xss_clean($post);
                
                $hashed = $this->password->create_hash($cleanPost['password']);    
                $cleanPost['password'] = $hashed;
                unset($cleanPost['passconf']);
                $userInfo = $this->user_model->updateUserInfo($cleanPost);
                
                if(!$userInfo){
                    $this->session->set_flashdata('flash_message', 'There was a problem updating your record');
                    redirect(site_url().'main/login?ajax_set=' . $_REQUEST['ajax_set']);
                }
                
                unset($userInfo->password);
                $this->session->set_userdata('email', $userInfo['email']);
                $this->session->set_userdata('user_id', $userInfo['user_id']);
                $this->session->set_userdata('first_name', $userInfo['first_name']);
                $this->session->set_userdata('last_name', $userInfo['last_name']);
                
                redirect(site_url().'/proposals');
                
            }
        }
        
     public function login()
        {
        $this->load->library('recaptcha');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');    
            $this->form_validation->set_rules('password', 'Password', 'required'); 
      
            if($this->form_validation->run() == FALSE | empty($this->input->post())) {
            
               if(empty($_REQUEST['ajax_set'])){
                    $this->load->view('header');
               }
               return $this->load->view('login');
                
              
            }else{
              
            
                $post = $this->input->post();  
         
                $clean = $this->security->xss_clean($post);
        
                
                
                     $recaptcha = $this->input->post('g-recaptcha-response');
                    $response = $this->recaptcha->verifyResponse($recaptcha);

                    if (!isset($response['success']) | $response['success'] != true){
                   
                            $this->session->set_flashdata('flash_message', 'The login was unsucessful ' . $response['error-codes'][0] . ' Captcha Code');
             
                        if(empty($_REQUEST['ajax_set'])){
                            $this->load->view('header');
                            }
                          return  $this->load->view('login');
                          
                    }
                   
                $userInfo = $this->user_model->checkLogin($clean);
                        print_r($userInfo);
               
                if(!$userInfo){
           
                    $this->session->set_flashdata('flash_message', 'The login was unsucessful');
                     if(empty($_REQUEST['ajax_set'])){
                            $this->load->view('header');
                    }
                    return $this->load->view('login');
                    exit;
                }     
        
                $data = array(
                            'user_id'  => $userInfo->user_id,
                            'email'     => $userInfo->email,
                            'first_name' => $userInfo->first_name,
                            'last_name' => $userInfo->last_name,
                            'dealer_id' => $userInfo->dealer_id,
                            'avatar' => $userInfo->avatar,
                            'logged_in' => TRUE
                    );
                    
                $this->session->set_userdata($data);
                
                redirect(site_url() . '/proposals');
            }
            
        }
        
        public function logout()
        {
            $this->session->sess_destroy();
            redirect(site_url());
        }
        
        public function forgot()
        {
         
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
         
            if($this->form_validation->run() === FALSE | empty($this->input->post())) {
            
               if(empty($_REQUEST['ajax_set'])){
                  $this->load->view('header');
                  }
                $this->load->view('forgot');
               
            }else{
                $email = $this->input->post('email');  
                $clean = $this->security->xss_clean($email);
                $userInfo = $this->user_model->getUserInfoByEmail($clean);
               
                if(!$userInfo){
                    $this->session->set_flashdata('flash_message', 'We cant find your email address');
                    redirect(site_url().'main/login/?ajax_set=' . $_REQUEST['ajax_set']);
                }   
                
                if($userInfo->status < 1){ //if status is not approved
                    $this->session->set_flashdata('flash_message', 'Your account is not in approved status');
                    redirect(site_url().'main/login/?ajax_set=' . $_REQUEST['ajax_set']);
                }
                
                //build token 
				
                $token = $this->user_model->insertToken($userInfo->user_id);                        
                $qstring = $this->base64url_encode($token);                  
                $url = site_url() . 'main/reset_password/'  . $qstring .  '/?redirect=' . base64_encode('/main/reset_password/token/' . $qstring . '?ajax_set=' . $_REQUEST['ajax_set']);
                $link = '<a href="' . $url . '">' . $url . '</a>'; 
                
                $message = '';                     
                $message .= '<strong>A password reset has been requested for this email account</strong><br>';
                $link = '<strong>Please click:</strong> ' . $link;             
                $this->load->model('Emailer');
                
                $this->Emailer->send('jon@' . $_SERVER['SERVER_NAME'], $email, 'Recover Password', $message . $link);
                echo $message; //send this through mail
                exit;
                
            }
            
        }
        public function client_listings(){
           $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
           
         //  echo "select email, first_name, last_name, business_phone, company_name, street_address, street_address2, city, state, postal_code, user_id from users where level_id=5 and dealer_id=" . $me['dealer_id'] . " and (company_name like '" . $this->input->post('company_name') . "%' or concat(first_name, ' ', last_name) like '" . $this->input->post('company_name') . "%' or email like '" . $this->input->post('company_name') . "%')";
           $data = $this->db->query("select email, first_name, last_name, business_phone, company_name, street_address, street_address2, city, state, postal_code, user_id from users where level_id=5 and dealer_id=" . $me['dealer_id'] . " and (company_name like '" . $this->input->post('company_name') . "%' or concat(first_name, ' ', last_name) like '" . $this->input->post('company_name') . "%' or email like '" . $this->input->post('company_name') . "%')")->result_array();
           
           foreach($data as $c => $client){
             $data[$c]['proposals'] = $this->db->query("select * from proposals where dealer_id=" . $this->session->userdata['user_id'] . " and customer_id=" . $client['user_id'])->result_array();
           
           }
         
           $this->load->view('build_proposal/search_clients');
           $this->load->view('user_list', array('data' => $data));
        }
        public function create_proposal(){
          $this->load->model('ProposalsModel');
            if(empty($this->uri->segment(3))){
                $step = 1;
             }else{
                $step = $this->uri->segment(3);
            }    
           $states = $this->user_model->states();
           $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
               if($step == 3){
                          $clean = $this->input->post(NULL, TRUE);
                        
                          if(!empty($clean['warranty'])){
                                                $data = array(
                                                    
                                                    'warranty' => addslashes($clean['warranty'])
                                                 );  
                                               
                                                 $this->db->query("update proposals set warranty='" . $data['warranty'] . "' where proposal_id=" . $this->uri->segment(5) . " and dealer_id=" .  $this->session->userdata['user_id']); 
                                                 if($this->db->query("select * from labor_warranty where dealer_id=" . $this->session->userdata['user_id'])->num_rows()==0){
                                                     $data['dealer_id'] = $this->session->userdata['user_id'];
                                                     
                                                     
                                                        $this->db->query("insert into labor_warranty values(null, " . $this->session->userdata['user_id'] . ", '" . $data['warranty'] . "', NOW(), NOW(), 1);");
                                                 }
                          }                       
                  return $this->ProposalsModel->AddPartsAndServices($this->uri->segment(5));
               }
               if($step ==2){
               
               $proposal = array();
               $proposal[0] = array();
              if(!empty($this->uri->segment(5))){
                 $proposal = $this->db->query("select * from proposals where proposal_id=" . $this->uri->segment(5))->result_array();
                 }else{
                 $proposal[0]['client_id'] = $this->uri->segment(4);
                 }
               
              
              
                if(count($this->input->post())>0 & isset($_POST['proposal_name'])){
                     $this->form_validation->set_rules('street_address', 'Street Address', 'required');
                     $this->form_validation->set_rules('proposal_name', 'Proposal Name', 'required');
                        $this->form_validation->set_rules('city', 'City', 'required');    
                        $this->form_validation->set_rules('state', 'State', 'required');    
                        $this->form_validation->set_rules('postal_code', 'Zip Code', 'required');
                        $this->form_validation->set_rules('utility_company', 'Utility Company', 'required');
                        $this->form_validation->set_rules('utility_kwH_rate', 'Existing kwH', 'required');
                        
                        if ($this->form_validation->run() == FALSE) {  
                            
                            if(is_numeric($this->uri->segment(4))){ 
                                    $client = $this->user_model->getUserInfo($this->uri->segment(4));
                            }else{
                                    $clent = array();
                            }
                          // $this->load->view('header');
                           $proposals = array();
                            if(!empty($this->uri->segment(5))){
                            //    $proposal = $this->db->query("select * from proposals where proposal_id=" . $this->uri->segment(5))->result_array();
                            }
                                $this->load->view('build_proposal/step' . $step, array('client' => $client, 'proposal' => $proposal[0], 'msg' => 'Error creating Proposal please check your inputs'));
                                return;
                        }else{ 
                            $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
                           
                            if(empty($clean['proposal_id'])){
                                    $data = array(
                                                    'proposal_id' => null,
                                                    'customer_id' => $clean['client_id'],
                                                    'dealer_id' => $clean['client_id'],
                                                    'street_address' => $clean['street_address'],
                                                    'street_address2' => $clean['street_address2'],
                                                    'salesman_id' => $this->session->userdata['user_id'],
                                                    'city' => $clean['city'],
                                                    'state' => $clean['state'],
                                                    'postal_code' => $clean['postal_code'],
                                                    'utility_company' => $clean['utility_company'],
                                                    'utility_kwH_rate' => $clean['utility_kwH_rate'],
                                                    'proposal_name' => $clean['proposal_name'],
                                                    'proposal_date' => date('Y-m-d H:i:s', time()),
                                                    'client_id' => $clean['client_id']
                                                 );   
                                    $this->db->query($this->db->insert_string('proposals', $data));
                                    $id = $this->db->insert_id();
                            }else{
                               $id = $clean['proposal_id'];
                                   $data = array(
                                                    
                                                    'client_id' => $clean['client_id'],
                                                    'customer_id' =>$clean['client_id'],
                                                    'street_address' => $clean['street_address'],
                                                    'street_address2' => $clean['street_address2'],
                                                    'city' => $clean['city'],
                                                    'state' => $clean['state'],
                                                    'postal_code' => $clean['postal_code'],
                                                    'utility_company' => $clean['utility_company'],
                                                    'utility_kwH_rate' => $clean['utility_kwH_rate'],
                                                    'proposal_name' => $clean['proposal_name'],
                                                    'proposal_date' => date('Y-m-d H:i:s', time()),
                                                    'salesman_id' => $this->session->userdata['user_id'],
                                                    'client_id' => $clean['client_id']
                                                 );  
                                                 $this->db->where(array('proposal_id' => $id) );
                                                 $this->db->update('proposals', $data); 
                            } 
                            redirect('/main/create_proposal/3/'  . $clean['client_id'] . '/' . $id);
                            return;
                        }
               
                 }else{
                         $client = $this->user_model->getUserInfo($this->uri->segment(4));
                         
                         
                            $this->load->view('build_proposal/step' . $step, array('client' => $client, 'states' => $states, 'proposal' => $proposal[0]));
                       
                 }
                 return;
               }else
            
                if(count($this->input->post())>1 & $step ==1){
               
                        $this->form_validation->set_rules('first_name', 'First Name', 'required');
                        $this->form_validation->set_rules('last_name', 'Last Name', 'required');    
                        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');    
                        if($me['level_id'] <= 2){
                            /* 'sales_tax' => $post['sales_tax'],
                                'labor_rate' => $post['labor_rate'],
                                'travel_distance' => $post['travel_distance'],
                                'travel_cost' => $post['travel_cost'],
                                'vehicle_charge' => $post['vehicle_charge'] */
                         
                            //$this->form_validation->set_rules('last_name', 'Last Name', 'required'); 
                            //$this->form_validation->set_rules('last_name', 'Last Name', 'required'); 
                            
                        }
                        if ($this->form_validation->run() == FALSE) {  
                       
                        if(is_numeric($this->uri->segment(4))){ 
                                    $client = $this->user_model->getUserInfo($this->uri->segment(4));
                            }else{
                                    $clent = array();
                            }
                          //  $this->load->view('header');
                            $this->load->view('build_proposal/step' . $step, array('client' => $client, 'msg' => 'Error creating Client please check your inputs', 'states' => $states));
                            return;
                        }else{                
                            
                                
                                $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
                               
                                $id = $this->user_model->insertUser($clean); 
                                $post['user_id'] = $id;
                                $this->user_model->updateUserInfo($clean);
                                
                                $this->db->query("update users set company_name='" . addslashes($clean['company_name']) . "', salesman_id=" . $this->session->userdata['user_id'] . ", dealer_id=" . $me['dealer_id'] . " where user_id=" . $id);
                                
                                $token = $this->user_model->insertToken($id);                                        
                                
                                $qstring = $this->base64url_encode($token);                    
                                $url = site_url() . 'main/complete/' . $qstring;
                                $link = '<a href="' . $url . '">' . $url . '</a>'; 
                                        
                                $message = '';                     
                                $message .= '<strong>You have been signed up with our website</strong><br>';
                                $message .= '<strong>Please click:</strong> ' . $link;                          

                                echo $message; //send this in email
                                redirect('/main/create_proposal/2/' . $id);
                                exit;
                                
                                
                                        
                        }
                
                }
           
           if(is_numeric($this->uri->segment(4))){ 
                $client = $this->user_model->getUserInfo($this->uri->segment(4));
           }else{
                $client = array();
           }

            
                $this->load->view('build_proposal/step' . $step, array('client' => $client, 'states' => $states, 'proposal' => $proposal));
            
            return;
        }
        public function reset_password()
        {
   
            $token = $this->base64url_decode($this->uri->segment(4));                  
            $cleanToken = $this->security->xss_clean($token);
            
            $user_info = $this->user_model->isTokenValid($cleanToken); //either false or array();               
           
            if(!$user_info){
                $this->session->set_flashdata('flash_message', 'Token is invalid or expired');
                redirect(site_url().'main/login');
            }            
            $data = array(
                'firstName'=> $user_info['first_name'], 
                'email'=>$user_info['email'], 
                'user_id'=>$user_info['user_id'], 
                'token'=>$this->base64url_encode($token)
            );
           
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');              
            
            if ($this->form_validation->run() === FALSE | empty($this->input->post())) {   
                if(empty($_REQUEST['ajax_set'])){
                  $this->load->view('header');
                  }
                $this->load->view('reset_password', $data);
           
            }else{
                                
                $this->load->library('password');                 
                $post = $this->input->post(NULL, TRUE);                
                $cleanPost = $this->security->xss_clean($post);                
                $hashed = $this->password->create_hash($cleanPost['password']);                
                $cleanPost['password'] = $hashed;
                $cleanPost['user_id'] = $user_info['user_id'];
                unset($cleanPost['passconf']);                
                if(!$this->user_model->updatePassword($cleanPost)){
                    $this->session->set_flashdata('flash_message', 'There was a problem updating your password');
                }else{
                    $this->session->set_flashdata('flash_message', 'Your password has been updated. You may now login');
                }
                redirect(site_url().'/proposals/?ajax_set=' . $_REQUEST['ajax_set']);                
            }
        }
        
    public function base64url_encode($data) { 
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    } 

    public function base64url_decode($data) { 
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
    }       
}
