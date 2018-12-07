<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GraphsModel extends CI_Model {
        
        public $status; 
        public $roles;
    
        function __construct(){
            parent::__construct();
            $this->load->model('User_model', 'user_model', TRUE);
            $this->load->library('form_validation');    
            $this->load->library('session');
            $this->load->model('Proposalsmodel');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->status = $this->config->item('status'); 
            $this->roles = $this->config->item('roles');
        }     
        
        function Graph($parts, $idx){
        
        
        
        
        
        }

        
}
