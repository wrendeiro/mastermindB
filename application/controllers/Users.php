<?php
require APPPATH . '/libraries/REST_Controller.php';

//            $this->load->library("JWT");
//            $CONSUMER_KEY = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
//            $CONSUMER_SECRET = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
//            $CONSUMER_TTL = 86400;
//            echo $this->jwt->encode(array(
//              'consumerKey'=>$CONSUMER_KEY,
//              'userId'=>345,
//              'issuedAt'=>date(DATE_ISO8601, strtotime("now")),
//              'ttl'=>$CONSUMER_TTL
//            ), $CONSUMER_SECRET);


class Users extends REST_Controller {
    
        public function __construct($config = 'rest') {
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            parent::__construct($config);
        }

        public function index_post(){
            $this->load->model('user');
            //$params = json_decode();
            
            $nmUser = $this->post('nmUser');
            $nmPass = $this->post('nmPassword');
            $nmEmail= $this->post('nmEmail');
            
            $this->load->library("JWT");
            $CONSUMER_KEY = $nmPass;
            $CONSUMER_SECRET = '034580684';
            $generatedToken = $this->jwt->encode(array(
              'consumerKey'=>$CONSUMER_KEY,
              'userId'=>$nmUser,
              'userEmail' => $nmEmail  
            ), $CONSUMER_SECRET);
            
            
            $data = array(
                "nmUser" => $nmUser,
                "nmPassword" => $nmPass,
                "nmEmail" => $nmEmail,
                "nmToken" => $generatedToken
            );
            
            
            $this->user->insert($data);
            
            $this->set_response($data);
            
        }
        
        public function index_get(){
            $this->load->model('user');
            $data = $this->user->show();
            
            $this->set_response($data);
        }
        
        public function index_put(){
            $this->load->model('user');
            //$params = json_decode();
            
            $nmUser = $this->put('nmUser');
            $nmPass = $this->put('nmPassword');
            $nmEmail= $this->put('nmEmail');
            
            $this->load->library("JWT");
            $CONSUMER_KEY = $nmPass;
            $CONSUMER_SECRET = '034580684';
            $generatedToken = $this->jwt->encode(array(
              'consumerKey'=>$CONSUMER_KEY,
              'userId'=>$nmUser,
              'userEmail' => $nmEmail  
            ), $CONSUMER_SECRET);
            
            
            $data = array(
                "nmUser" => $nmUser,
                "nmPassword" => $nmPass,
                "nmEmail" => $nmEmail,
                "nmToken" => $generatedToken
            );
            
            
            $this->user->update($data);
            
            $this->set_response($data);
        }
        
        public function index_delete(){
            $this->load->model('user');
            $nmEmail= $this->delete('nmEmail');
            
            $data = array(
                "nmEmail" => $nmEmail
            );
            
             $this->user->delete($data);
        }
}