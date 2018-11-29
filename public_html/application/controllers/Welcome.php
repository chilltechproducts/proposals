<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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

	    $this->load->view('welcome_header');
		$this->load->view('index');
	}
	public function contact()
	{
	  $data = array();
	   if(!empty($this->input->post())){
              
                $this->form_validation->set_rules('_u689818486450563240', 'Name', 'required');
                $this->form_validation->set_rules('_u299538569683647988', 'Phone', 'required');
                $this->form_validation->set_rules('_u974858400987469693', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('_u642942518700304519', 'Comment', 'required');
                       
            if ($this->form_validation->run() == FALSE) { 
                $this->load->view('welcome_header');
                $this->load->view('contact');
            }else{
                $this->load->model('Emailer');
                $post = $this->security->xss_clean($this->input->post(NULL, TRUE));
                $this->Emailer->send($post['_u974858400987469693'], 'jon@chilltechproducts.com', 'Contact Form Submission', $post['_u642942518700304519']);
                $data['msg'] = 'Message Sent';
                
             }   
	   }
	    $this->load->view('welcome_header');
		$this->load->view('contact', array('data' => $data));
	}
	public function next()
	{
	    $this->load->view('welcome_header');
		$this->load->view('next');
	}
	public function news()
	{
	    $this->load->view('welcome_header');
		$this->load->view('news');
	}
	public function products()
	{
	    $this->load->view('welcome_header');
		$this->load->view('products');
	}
	public function schedule()
	{
	$data = array();
	   if(!empty($this->input->post())){
              
                $this->form_validation->set_rules('_u853152573264572327', 'Company Name', 'required');
                $this->form_validation->set_rules('_u534123273502973030[line1]', 'Address', 'required');
                $this->form_validation->set_rules('_u534123273502973030[city]', 'City', 'required');
                $this->form_validation->set_rules('_u534123273502973030[state]', 'State', 'required');
                $this->form_validation->set_rules('_u534123273502973030[zip]', 'Zip Code', 'required');
                $this->form_validation->set_rules('_u271229300896372171', 'Annual Revenue', 'required');
                $this->form_validation->set_rules('_u898295096151894438', 'Comment', 'required');
                $this->form_validation->set_rules('_u458618890989731388[first]', 'First Name', 'required');
                $this->form_validation->set_rules('_u458618890989731388[last]', 'Last Name', 'required');
                $this->form_validation->set_rules('_u295912610444034561', 'Phone', 'required');
                
                $this->form_validation->set_rules('_u613312299727719573', 'Email', 'required|valid_email');
                
                
            if ($this->form_validation->run() == FALSE) { 
                $this->load->view('welcome_header');
                $this->load->view('contact');
            }else{
                $this->load->model('Emailer');
                $post = $this->security->xss_clean($this->input->post(NULL, TRUE));
                $this->Emailer->send($post['_u974858400987469693'], 'jon@chilltechproducts.com', 'Schedule Request', $post['_u642942518700304519']);
                $data['msg'] = 'Message Sent';
                
             }   
	   }
	    $this->load->view('welcome_header');
		$this->load->view('schedule', array('data' => $data));
	}
	public function proposal_system()
	{
	 $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
     
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
	    $this->load->view('header');
		$this->load->view('proposal_system', array('data' => $data, 'me' => $me, 'user_levels' => $user_levels, 'states' => $states_out));
	}
}
