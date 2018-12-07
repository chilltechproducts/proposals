<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Java extends CI_Controller { 

function main(){
header("content-type: application/javascript");
  $this->load->view('JS/main');
  
  }



}
