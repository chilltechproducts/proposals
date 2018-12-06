<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProposalsModel extends CI_Model {
        function __construct(){
            parent::__construct();
            $this->load->model('User_model', 'user_model', TRUE);
            $this->load->database();
            $this->load->library('form_validation');    
            $this->load->library('session');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
    }
   function locate($location){
        $apiKey= "AIzaSyA28-MbyYgkZK-Z3ELvbaw8N8lAHgwVLIE"; 
        $address = urlencode(@$location['street_address'] . ' ' . @$location['city'] . ', ' . @$location['state'] . ' ' . @$location['postal_code'] );
 
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=true&key=$apiKey";
    
        $data = @file_get_contents($url);
		
		          $jsondata = json_decode($data,true);
                        if(!is_array($jsondata) | $jsondata['status'] != "OK")
		         {
		           $address = urlencode(@$location['city'] . ', ' . @$location['state'] . ' ' . @$location['postcode'] );
 
                            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=true&key=$apiKey";
     
                            $data = @file_get_contents($url);
		         
		         }
		         if(is_array($jsondata) && $jsondata['status'] == "OK")
		         {
                                $lat = number_format($jsondata['results'][0]['geometry']['location']['lat'], 3);
                                $lng = number_format($jsondata['results'][0]['geometry']['location']['lng'], 3);
                                
                                if($this->db->query("select * from zipcodes where latitude like '$lat%' and longitude like '$lng%'")->num_rows()==0){
                                
                                  $location2 = $this->db->query("select * from zipcodes where city='$location[city]' and state='$location[state]' order by id desc limit 1")->result_array();
                                  
                                  $this->db->insert_string('zipcodes', array('city' => $location['city'], 'state_province_name' => $location2[0]['state_province_name'], 'state' => $location['state'], 'zipcode' => $location['postcode']));
                                
                                }
                                
                                return $jsondata['results'][0]['geometry']['location'];
		         }
		      
    }
    public function JobDetails($pid){
       $data = $this->db->query("select * from proposals where proposal_id=" . $pid)->result_array();
       return $data;
    
    }
	public function CalculateMiles($client, $dealer, $proposal){
           $proposal = $proposal[0];
            $from =  $dealer['street_address'] . ' ' . $dealer['city'] . ', ' . $dealer['state'];
            $to = $proposal['street_address'] . ' ' . $proposal['city'] . ', ' . $proposal['state'];
            
            if(empty($dealer['lat']) | empty($dealer['lng'])){
              //geocode dealer
                $loc = $this->locate($dealer);
                if(count($loc)>0){
                    $this->db->query("update users set lat='" . $loc['lat'] . "', lng='" . $loc['lng'] . "' where user_id=" . $dealer['user_id']);
                    
                }
            }
             if(empty($client['lat']) | empty($client['lng'])){
              //geocode dealer
                $loc = $this->locate($client);
                if(count($loc)>0){
                    $this->db->query("update users set lat='" . $loc['lat'] . "', lng='" . $loc['lng'] . "' where user_id=" . $client['user_id']);
                    
                }
            }
           
            if(empty($proposal['lat']) | empty($proposal['lng'])){
              //geocode dealer
           
                    $loc = $this->locate($proposal);
                    if(count($loc)>0){
                        $this->db->query("update proposals set lat='" . $loc['lat'] . "', lng='" . $loc['lng'] . "' where proposal_id=" . $proposal['proposal_id']);
                    
                    }
            }
            $miles = 20;
        if(empty($proposal['distance']) | empty($proposal['travel_time']) & !empty($to) & !empty($from)){
            $from = urlencode($from);
            $to = urlencode($to);
          
            $apiKey= "AIzaSyDb61TGMg2rxGzypjkMRKWFn5qye_Vbkt4";  
      
            $data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&key=$apiKey&language=en-EN&sensor=false");
            $data = json_decode($data, true);
           if(!empty($data['rows'][0]['elements'][0]['distance']['text'])){
            $km = str_replace(" km", "", $data['rows'][0]['elements'][0]['distance']['text']);
            $miles = $km * 0.62137119;
            
            $duration = $data['rows'][0]['elements'][0]['distance']['value'] * 2;
            $this->db->query("update proposals set distance='" . $miles . "', travel_time='$duration' where proposal_id=" . $proposal['proposal_id']);
            }
          }  
            return $miles;
	}
	public function AddLabor($proposal_id){
	
	    
        $parts = $this->db->query("select distinct(service_data.service_id), service_data.service_name, service_data.rate, service_data.value from service_data where proposal_id=" . $proposal_id)->result_array();
        
       
        $dealer = $this->db->query("select * from users where user_id=" . $this->session->userdata['user_id'])->result_array();
        $proposal = $this->db->query("select * from proposals where proposal_id=" . $proposal_id)->result_array();
        
	  $this->load->view('parts/labor_for_proposal', array('parts' => $parts, 'dealer' => $dealer[0], 'proposal' => $proposal[0]));
	}	
	public function AddParts($proposal_id){
	
	    
        $parts = $this->db->query("select distinct(part_data.model_number), count(part_data.location_id) as count, part_data.part_id, p.wholesale, part_data.part_name, part_data.manufacturer_id, m.manufacturer_name, r.rebate_amount, r.limit_amount_per_customer from part_data left join rebates r on r.model_number=part_data.model_number left join manufacturers m on m.manufacturer_id=part_data.manufacturer_id left join parts p on p.id=part_data.part_id where proposal_id=" . $proposal_id)->result_array();
        
       $dealer = $this->db->query("select * from users where user_id=" . $this->session->userdata['user_id'])->result_array();
        $proposal = $this->db->query("select * from proposals where proposal_id=" . $proposal_id)->result_array();
        
	  $this->load->view('parts/parts_for_proposal', array('parts' => $parts, 'dealer' => $dealer[0], 'proposal' => $proposal[0]));
	}
	public function AddPartsAndServices($proposal_id){
	//echo $proposal_id; exit;
            $proposal = $this->JobDetails($proposal_id);
        
            $client = $this->user_model->getUserInfo($proposal[0]['client_id']);
           // print_r($client);
            $job = $this->JobDetails($proposal_id);
            $me = $this->user_model->getUserInfo($this->session->userdata['user_id']);
            
            $dealer = $this->user_model->getUserInfo($proposal[0]['dealer_id']);
            
            
            $motors = $this->db->query("select * from parts where series = 'A' or series='IP'")->result_array();
            $blades = $this->db->query("select * from parts where series = 'BLADE'")->result_array();
            
            $distance = $this->CalculateMiles($client, $me, $proposal);
            
            
            $this->load->view('build_proposal/step3', array('client' => $client, 'states' => $states, 'job' => $job, 'distance' => $distance, 'me' => $me, 'proposal' => $proposal, 'dealer' => $dealer, 'blades' => $blades, 'motors' => $motors));
	
	}
}
