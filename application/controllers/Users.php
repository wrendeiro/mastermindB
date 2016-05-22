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
                "nmToken" => $generatedToken
            );
            
            
            $this->user->insert($data);
            
            $this->set_response($data);
            
        }
        
        public function index_get(){
            $this->load->model('user');
            $this->user->show();
        }
        
        public function index_put(){
            
        }
        
        public function index_delete($key = NULL, $xss_clean = NULL){
            
        }
}