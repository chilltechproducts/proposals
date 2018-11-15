<?php
class User_model extends CI_Model {
    public $status; 
    public $roles;
    
    function __construct(){
        // Call the Model constructor
        parent::__construct();        
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }    
    
    public function insertUser($d)
    {  
            $string = array(
                'first_name'=>$d['first_name'],
                'last_name'=>$d['last_name'],
                'email'=>$d['email'],
                'role'=>$this->roles[0], 
                'status'=>3, 
                'password'=> '', 
                'last_login'=> '',
                'level_id' => $d['level_id']
            );
            $q = $this->db->insert_string('users',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    }
    public function user_level($id){
      
      return $this->db->query("select level_name from user_levels where level_id=" . $id)->row()->level_name;
    }
    
    public function isDuplicate($email)
    {     
        $this->db->get_where('users', array('email' => $email), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }
    
    public function insertToken($user_id)
    {   
        $token = substr(sha1(rand()), 0, 30); 
        $date = date('Y-m-d');
        
        $string = array(
                'token'=> $token,
                'user_id'=>$user_id,
                'created'=>$date
            );
        $query = $this->db->insert_string('tokens',$string);
        $this->db->query($query);
        return $token . $user_id;
        
    }
    
    public function isTokenValid($token)
    {
       $tkn = substr($token,0,30);
       $uid = substr($token,30);      
       
        $q = $this->db->get_where('tokens', array(
            'tokens.token' => $tkn, 
            'tokens.user_id' => $uid), 1);                         
               
        if($this->db->affected_rows() > 0){
            $row = $q->row();             
            
            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d'); 
            $todayTS = strtotime($today);
            
            if($createdTS != $todayTS){
                return false;
            }
            
            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
            
        }else{
            return false;
        }
        
    }    
    public function user_levels($level_id = null){
      $qry = "select level_id, level_name from user_levels";
      
      if($level_id == 2){
        $qry .= " where level_id > " . $level_id . " order by level_id asc";
        $data = $this->db->query($qry)->result_object();
      }
      if($level_id == 1){
        $qry .= " where level_id >= " . $level_id . " order by level_id asc";
        $data = $this->db->query($qry)->result_object();
      }
      if($level_id == 5){
        $qry .= " where level_id > " . $level_id . " and level_id<9 order by level_id asc";
        $data = $this->db->query($qry)->result_object();
      }
      if($level_id == 8){
        $qry .= " where level_id > 5 and level_id<8 order by level_id asc";
        $data = $this->db->query($qry)->result_object();
      }
      return $data;
    }
    public function getUserInfo($id)
    {
    
        $q = $this->db->query("select * from users where user_id = " . $id)->result_array(); 
    
        if(count($q) > 0){
           if($q[0]['level_id'] <=2){
              $q[0]['dealer_info'] = @$this->db->query("select * from dealers where dealer_id=" . $q[0]['dealer_id'])->result_array()[0];
            }
              $q[0]['level_info'] = $this->db->query("select * from user_levels where level_id=" . $q[0]['level_id'])->result_array()[0];
              
            return $q[0];
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }
    
    public function updateUserInfo($post)
    {
    
        $data = array(
               'password' => $post['password'],
               'last_login' => date('Y-m-d h:i:s A'), 
               'status' => 1
            );
        $this->db->where('user_id', $post['user_id']);
        $this->db->update('users', $data); 
        $success = $this->db->affected_rows(); 
      
        if(!$success){
            error_log('Unable to updateUserInfo('.$post['user_id'].')');
            return false;
        }
        
        $user_info = $this->getUserInfo($post['user_id']); 
        return $user_info; 
    }
    
    public function checkLogin($post)
    {
    
        $this->load->library('password');       
        $this->db->select('*');
        $this->db->where('email', $post['email']);
        $query = $this->db->get('users');
        $userInfo = $query->row();
        
        if(!$this->password->validate_password($post['password'], $userInfo->password)){
            error_log('Unsuccessful login attempt('.$post['email'].')');
            return false; 
        }
        
        $this->updateLoginTime($userInfo->user_id);
        
        unset($userInfo->password);
        return $userInfo; 
    }
    
    public function updateLoginTime($id)
    {
        $this->db->where('user_id', $id);
        $this->db->update('users', array('last_login' => date('Y-m-d h:i:s A')));
        return;
    }
    
    public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('users', array('email' => $email), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$email.')');
            return false;
        }
    }
    
    public function updatePassword($post)
    {   
        $this->db->where('user_id', $post['user_id']);
        $this->db->update('users', array('password' => $post['password'])); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updatePassword('.$post['user_id'].')');
            return false;
        }        
        return true;
    } 
    
}