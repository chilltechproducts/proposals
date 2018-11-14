<?php
class Emailer extends CI_Model {
       public function send($from, $to, $subect, $message, $format = 'html', $cc = null, $bcc = null, $name = 'ChillTechProducts'){
                    $this->load->library('email');

                    $this->email->from($from, $name);
                   
                    $this->email->to($me['email']);
                   

                    $this->email->subject($subject);
                    $this->email->message($message);
                    $this->email->set_mailtype($format);
                    
                    $this->email->send(); 
        }
}        
