<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProposalsModel extends CI_Model {
        function __construct(){
            parent::__construct();
            $this->load->model('User_model', 'user_model', TRUE);
            $this->load->database();
            $this->load->library('form_validation');    
            $this->load->library('session');
            $this->load->model('GraphsModel');
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
	public function ComboPrices($motor, $dealer){
	ini_set('precision', 15);
	   $prices = array();
	   $prices['B2'] = $dealer['labor_rate']?$dealer['labor_rate']:40;
	   $prices['B3'] = $dealer['billable_efficiency']?$dealer['billable_efficiency']/100:.60;
	   $prices['B4'] = $dealer['sales_tax']?$dealer['sales_tax']/100:0;
	   $prices['B5'] = $dealer['travel_distance']?$dealer['travel_distance']:20;
	   $prices['B6'] = $dealer['travel_cost']?$dealer['travel_cost']:.65;
	   $prices['B7'] = $dealer['vehicle_charge']?$dealer['vehicle_charge']:5.60;
	   $prices['B8'] = $dealer['risk']?$dealer['risk']/100:.04;
	   $prices['B9'] = $dealer['service_dept_overhead']?$dealer['service_dept_overhead']/100:.25;
	   $prices['B10'] = $dealer['sales_commiss']?$prices['sales_commiss']/100:.10;
	   $prices['B11'] = $dealer['target_net']?$dealer['target_net']/100:.15;
	   $prices['B12'] = $dealer['target_gross']?$dealer['target_gross']/100:.50;
	   $prices['B16'] = $motor['wholesale'];
	   
	  // print_r($prices);
	   $prices['E2'] =(($prices['B2'] / $prices['B3']) / $prices['B9']);   //=SUM((B2/B3)/B9)  266.6666666667 
	   
	   
	   $prices['C16'] = (($prices['B16']*$prices['B12'])*($prices['B8']+$prices['B4'])+($prices['E2'] *0.35)) + $prices['B16'] + $prices['B16'];
	   
	   
	  // $prices['E3'] = ($prices['B16']*(1-$prices['B12']))*($prices['B8']+$prices['B4']) + $prices['B16'];//=SUM(B16/(1-B12))*(1+B8+B4) 393.12
	  
        $blade = $this->db->query("select * from parts where id=" . $motor['blade_id'])->result_array();
        
        if(count($blade)>0){
          $prices['B20'] = $blade[0]['wholesale'];
          $prices['C20'] =  $blade[0]['wholesale'] + $blade[0]['wholesale'] + (($prices['B20']*($prices['B12'])))*($prices['B8']+$prices['B4']) ;//=SUM(((B20/(1-B12))*(1+B8+B4))) 135.20
          
        }else{
          $prices['B20'] = 0;
          $prices['C20'] = 0;
        }
        
        $prices['B24'] = $prices['C20'] + $prices['C16'];
        
        $prices['E4'] = ($prices['B5'] * $prices['B6']) + ($prices['B7']*.75) + ($prices['E2'] * .75); //=SUM(B5*B6,(B7*0.75),(E2*0.75))
	 
	   $prices['installed']=$prices['B24'];
	   $prices['retail'] = $prices['C16'];
	   $prices['total_hourly'] = $prices['E2'];
	   $prices['trip_charge'] = $prices['E4'];
	   
	   return $prices;
	}
	public function AddLabor($proposal_id){
	
	    
        $parts = $this->db->query("select distinct(service_data.service_id), service_data.service_name, service_data.rate, service_data.value from service_data where proposal_id=" . $proposal_id)->result_array();
        
       
        $dealer = $this->db->query("select * from users where user_id=" . $this->session->userdata['user_id'])->result_array();
        $proposal = $this->db->query("select * from proposals where proposal_id=" . $proposal_id)->result_array();
        
	  $this->load->view('parts/labor_for_proposal', array('parts' => $parts, 'dealer' => $dealer[0], 'proposal' => $proposal[0]));
	}	
	public function AddParts($proposal_id){
	
	    $dealer = $this->db->query("select * from users where user_id=" . $this->session->userdata['user_id'])->result_array();
       $parts = $this->db->query("select distinct(part_data.unique_val), part_data.model_number, p.kWh_with_blade,  part_data.part_id, p.wholesale, part_data.part_name, part_data.manufacturer_id, m.manufacturer_name, r.rebate_amount, r.limit_amount_per_customer, part_data.blade_id from part_data left join rebates r on r.model_number=part_data.model_number left join manufacturers m on m.manufacturer_id=part_data.manufacturer_id left join parts p on p.id=part_data.part_id where part_data.proposal_id=" . $proposal_id)->result_array();
            
            foreach($parts as $p => $part){
               $parts[$p]['blade'] = $this->db->query("select * from parts where id=" . $part['blade_id'])->result_array()[0];
               $parts[$p]['count'] = $this->db->query("select location_id from part_data where unique_val=" . $part['unique_val'])->num_rows();
               $parts[$p]['prices'] = $this->ComboPrices($part, $dealer);
            }
        
       
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
            
            $parts = $this->db->query("select distinct(part_data.unique_val), part_data.model_number, p.kWh_with_blade,  part_data.part_id, p.wholesale, part_data.part_name, part_data.manufacturer_id, m.manufacturer_name, r.rebate_amount, r.limit_amount_per_customer, part_data.blade_id from part_data left join rebates r on r.model_number=part_data.model_number left join manufacturers m on m.manufacturer_id=part_data.manufacturer_id left join parts p on p.id=part_data.part_id where part_data.proposal_id=" . $proposal_id)->result_array();
            
            foreach($parts as $p => $part){
            
               $parts[$p]['blade'] = $this->db->query("select * from parts where id=" . $part['blade_id'])->result_array()[0];
               $parts[$p]['count'] = $this->db->query("select location_id from part_data where unique_val=" . $part['unique_val'])->num_rows();
              $parts[$p]['prices'] = $this->ComboPrices($part, $dealer);
            
            }
            $motors = $this->db->query("select * from parts where series = 'A' or series='IP'")->result_array();
            $blades = $this->db->query("select * from parts where series = 'BLADE'")->result_array();
            
            $distance = $this->CalculateMiles($client, $me, $proposal);
            $Graphs = array();
            for($i=1;$i<=3;$i++){
              $Graphs[$i] = $this->GraphsModel->Graph($parts, $i);
            
            }
            
            $this->load->view('build_proposal/step3', array('client' => $client, 'states' => $states, 'job' => $job, 'distance' => $distance, 'me' => $me, 'proposal' => $proposal, 'dealer' => $dealer, 'blades' => $blades, 'motors' => $motors, 'parts' => $parts));
	
	}
}
