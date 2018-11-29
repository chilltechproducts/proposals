<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposals extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
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
	
          if(empty($this->session->userdata['user_id'])){
                  redirect('/main/login');
                exit;
          }
          $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
     
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
          $states = $this->user_model->states();
          
	    $this->load->view('header');
		$this->load->view('proposal_system', array('data' => $data, 'me' => $me, 'user_levels' => $user_levels, 'states' => $states_out));
	}
	public function submit_new_part(){
	   $alt = $this->uri->segment(5);
	   
	   $proposal_id = $this->uri->segment(3);
	   $this->db->query("delete from part_data where model_number='" . $this->input->post('model_number[' . $alt . ']') . "' and proposal_id=" . $this->uri->segment(3));
	   
	   $i =1;
	   $client = $this->db->query("select proposals.*, u.user_id, u.first_name, u.last_name, u.company_name, u.street_address from proposals left join users u on u.user_id=proposals.customer_id")->result_array();
	   $part_id = $this->input->post('part_id[' . $alt . ']');
	   $model_number = $this->input->post('model_number[' . $alt . ']');
	   $dealer_id = $this->session->userdata['user_id'];
	   $part_name = $this->input->post('part_name[' . $alt . ']');
	   
	  
	   
	   $warranty = $this->db->query("select part_warranty_id from part_warranty where part_id=" . $part_id)->result_array();
	   $manufacturer = $this->db->query("select manufacturer_id from parts where id=" . $part_id)->result_array();
	   $part_warranty_id = $warrant[0]['part_warranty_id'];
	   $manufacturer_id =$manufacturer[0]['manufacturer_id'];
	   $location_name = $part_name . ' for ' . $client['first_name'] . ' ' . $client['last_name'] . ' at ' . $client['street_address'];
	   $customer_id = $client[0]['user_id'];
	   
	   $qty = $this->input->post('quantity[' . $alt . ']');
	   
	   for($i=1;$i<=$qty;$i++){
	     
	     $location_name .= ' - ' . $i;
	   
	     $sql = "insert into part_data (location_id, location_name, part_id, model_number, manufacturer_id, dealer_id, part_warranty_id, proposal_id, customer_id, part_name) values(null, '$location_name', '$part_id', '$model_number', '$manufacturer_id', '$dealer_id', '$part_warranty_id', '$proposal_id', '$customer_id', '$part_name')";
	    
	     $this->db->query($sql);
	   }
	}
	public function submit_new_labor(){
	   $alt = $this->uri->segment(4);
	  
	   $proposal_id = $this->uri->segment(3);
	   $this->db->query("delete from service_data where service_id='" . $this->input->post('service_id[' . $alt . ']') . "' and proposal_id=" . $this->uri->segment(3));
	   
	   $i =1;
	   $client = $this->db->query("select proposals.*, u.user_id, u.first_name, u.last_name, u.company_name, u.street_address from proposals left join users u on u.user_id=proposals.customer_id")->result_array();
	   $service_id = $this->input->post('service_id[' . $alt . ']');
	   
	   
	   $service_name = $this->input->post('service_name[' . $alt . ']');
	   $rate = $this->input->post('service_rate[' . $alt . ']');
	   $value = $this->input->post('value[' . $alt . ']');
	   $dealer_id = $this->session->userdata['user_id'];
	   
	   if(empty($service_id)){
	   
                $sql = $this->db->insert_string('services', array('id' => 'null', 'service_name' => $service_name, 'status' => 0, 'user_id' => $dealer_id, 'service_rate' => $rate));
                $this->db->query($sql);
                $service_id = $this->db->insert_id();
               
            
	   }
	   
	   
	   
	   
	  
	   
	   $manufacturer_id =$manufacturer[0]['manufacturer_id'];
	
	   $customer_id = $client[0]['user_id'];
	   
	   
	   
	     $sql = "insert into service_data (id, service_id, service_name, proposal_id, value, rate) values(null, '$service_id', '$service_name', '$proposal_id', '$value', '$rate')";
	    
	     $this->db->query($sql);
	   if($this->db->query("select * from services where service_name='$service_name'")->num_rows()==0){
	     $sql = $this->db->insert_string('services', array('id' => 'null', 'service_name' => $service_name, 'status' => 0, 'user_id' => $dealer_id, 'service_rate' => $rate));
	     $this->db->query($sql);
	   }
	}
    public function add_part_to_proposal(){
        if(empty($this->session->userdata['user_id'])){
                //    $this->load->view('header');
                    $this->load->view('login');
                //    $this->load->view('footer');
                exit;
          }
       $this->load->model('ProposalsModel');
          if($this->uri->segment(5)=='view'){
                if($this->uri->segment(4) == 'parts'){
                    return $this->ProposalsModel->ViewParts($this->uri->segment(3));
                }else{
                   return $this->ProposalsModel->ViewLabor($this->uri->segment(3));
                }
            
          }
          if($this->uri->segment(4) == 'parts'){
            return $this->ProposalsModel->AddParts($this->uri->segment(3));
          }else{
            return $this->ProposalsModel->AddLabor($this->uri->segment(3));
          }
        
        }
	
}
