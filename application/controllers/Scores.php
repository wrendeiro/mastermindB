<?php
require APPPATH . '/libraries/REST_Controller.php';

class Scores extends REST_Controller {
    
        public function __construct($config = 'rest') {
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Access-Control-Allow-Origin");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
            parent::__construct($config);
        }
        
        public function index_options(){
            
        }

        public function index_post(){
            $this->load->model('score');
            $nmToken = $this->post('nmToken');
            $vlScore = $this->post('vlScore');
            $validate = true;
            $error_msg = "Encountered errors during requisition:\n";
            
            if(empty($nmToken))
            {
                $validate = false;
                $error_msg .= "  - Token has bot been informed.\n";
            }
            
            if(empty($vlScore))
            {
                $validate = false;
                $error_msg .= "  - Score has not been informed.";
            }
            
            if($validate){
                $data = array(
                    "vlScore" => $vlScore,
                    "nmToken" => $nmToken
                );

                $status = $this->score->insert($data);
                if($status){
                    $data['success'] = true;
                }
                else
                {
                    $data = array(
                        'success' => false,
                        'message' => 'An error occurred while processing your request'
                    );
                }
            }
            else
            {
                $data = array(
                    'success' => false,
                    'message' => $error_msg
                );
            }
            
            echo json_encode($data);
            
        }
        
        public function index_get(){
            $this->load->model('score');
            $nmToken = $this->get('nmToken');
            $action = $this->get('action');
            $validate = true;
            $error_msg = "Encountered errors during requisition:\n";
            
            if(empty($action))
            {
                $validate = false;
                $error_msg .= "  - Specify action.\n";
            }
            
//            if(empty($nmUser))
//            {
//                $validate = false;
//                $error_msg .= "  - Token has not been informed.";
//            }
            
            if($validate){
                $data = array(
                    'nmToken'     => $nmToken
                );
                
                switch ($action){
                    case "general":
                        $data = $this->score->getGeneralRecord($data);
                        break;
                    case "personal":
                        $data = $this->score->getPersonalRecord($data);
                        break;
                }
                
                if(!empty($data)){
                    $responseData = array(
                        'success' => true,
                        'data' => $data
                    );
                }
                else
                {
                    $responseData = array(
                        'success' => true,
                        'data' => array()
                    );
                }
            }
            else
            {
                $responseData = array(
                    'success' => false,
                    'message' => $error_msg
                );
            }
            
            
            
            echo json_encode($responseData);
        }
}