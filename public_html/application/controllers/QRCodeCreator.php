<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QRCodeCreator extends CI_Controller {

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
            $this->load->database();
        }      
    
	public function create()
	{
	  $this->load->library('ciqrcode');
	  $columns = array('location_name', 'concat(latitude, ',', longitude)');
	  
	  $sql = "select part_data.*, u.dealer_id, u.company_name from part_data left join service_dates sd on sd.location_id=part_data.location_id left join users u on u.dealer_id=sd.tech_id left join part_warranty pw on pw.serial_number=part_data.serial_number";
      if(is_numeric($this->uri->segment(3))){
         $sql .= " where part_data.location_id=" . $this->uri->segment(3); 
      }  else {
         if(in_array($this->uri->segment(3), $columns)){
           $sql .= " where " . $this->uri->segment(3) . "=" . $this->uri->segment(4);
         }else{
          // exit;
         }  
      
      }
    //  echo $sql;
      $datain = $this->db->query($sql . " order by part_data.serial_number desc limit 1")->result_array();
      if(count($datain)==0){
        echo 'part not found';
        exit;
      }
      $data = '';
      foreach($datain[0] as $k => $r){
        if(!empty($r)){
         $data .= "<b>" . ucwords(str_replace("_", " ", $k)) . ":</b> " . $r . "<br />";
           switch($k){
             case('customer_id'):
             
             break;
             case('dealer_id'):
             
             break;
             case('salesman_id'):
             
             break;
             case('part_warranty_id'):
             
             break;
             case('manufacturer_id'):
             
             break;
             case('labor_waaranty_id'):
             
             break;
             case('last_service_date'):
             
             break;
           }  
        } 
      }
      //echo $data;
        $params['data'] = $data;
        $params['level'] = 'H';
        $params['size'] = 10;
        header("content-type: image/png");
       // $params['savename'] = '/home/chilltech/public_html/public/qr_codes/tes.png';
        $this->ciqrcode->generate($params);

        
		
	}
}
