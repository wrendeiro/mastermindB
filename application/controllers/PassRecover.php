<?php
require APPPATH . '/libraries/REST_Controller.php';


class PassRecover extends REST_Controller {
    
        public function __construct($config = 'rest') {
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Access-Control-Allow-Origin");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
            parent::__construct($config);
        }

        public function index_options(){
            
        }
        
        public function index_get(){
            $this->load->model('user');
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.live.com';
            $config['smtp_port'] = 587;
            $config['smtp_user'] = "mastermind_project@hotmail.com";
            $config['smtp_pass'] = "MastermindU1";
            $config['wordwrap'] = TRUE;
            $config['smtp_crypto'] = 'TLS';
            $this->load->library('email');
            $this->email->initialize($config);
            
            $nmEmail = $this->get('nmEmail');
            
            if(!empty($nmEmail)){
                $data = array(
                    'nmEmail'     => $nmEmail
                );
                
                $newData = $this->user->recoverPass($data);
                if(!empty($newData)){
                    $this->email->from('mastermind_project@hotmail.com', 'Test');
                    $this->email->to($nmEmail);
                    $this->email->set_newline("\r\n");  
                    $this->email->subject('teste');
                    $this->email->message('teste');

                    $this->email->send();
                    
                    echo $this->email->print_debugger();
//                    $headers = "MIME-Version: 1.0" . "\r\n";
//                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//
//                    // More headers
//                    $headers .= 'From: <webmaster@example.com>' . "\r\n";
//                    mail($nmEmail,"Password Reset",'<div>Hi '.$newData['nmUser'].', this is your password:<br/><br/>'.$newData['nmPassword'].'</div>',$headers);
                    
                    $data = array(
                        'success' => 'true',
                        'message' => 'Email has been sent'
                    );
                    
                }
                else
                {
                    $data = array(
                        'success' => false,
                        'message' => 'Wrong username or password.'
                    );
                }
            }
            else
            {
                $data = array(
                    'success' => false,
                    'message' => 'Email has not been informed.'
                );
            }
            
            
            
            echo json_encode($data);
        }
}