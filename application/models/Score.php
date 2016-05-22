<?php
class Score extends CI_Model {

    
    function __construct()
    {
        parent::__construct();
    }
    
    function getGeneralRecord($params){
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->selectCollection("users");
        $tableScores = $db->selectCollection("scores");
        $result = array();
        
        
        $colUser = $tableUsers->find();
        foreach ($colUser as $user){
            $pts = 0;
            $resultScore = $tableScores->find(array('idUser' => $user['_id']));
            foreach ($resultScore as $score){
                $pts += $score['vlScore'];
            }
            $result[] = array(
                'nmUser' => $user['nmUser'],
                'pts' => $pts
            );
        }
        
        return $result;
    }
    
    function getPersonalRecord($params){
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->selectCollection("users");
        $tableScores = $db->selectCollection("scores");
        $result = array();
        
        $resultUser = $tableUsers->findOne($params);
        if(!empty($resultUser)){
            $resultScore = $tableScores->find(array('idUser' => $resultUser['_id']));
            
            $resultScore->sort(array('dtScore' => -1));
            foreach($resultScore as $score){
                $result[] = array(
                    'dtScore' => $score['dtScore'],
                    'vlScore' => $score['vlScore']
                );
            }
        }
        
        return $result;
    }
    
    function insert($params)
    {
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->selectCollection("users");
        $tableScores = $db->selectCollection("scores");
        
        $resultUser = $tableUsers->findOne(array('nmToken' => $params['nmToken']));
        if(!empty($resultUser)){
            $data = array(
                'idUser' => $resultUser['_id'],
                'vlScore' => $params['vlScore'],
                'dtScore' => date('Y-m-d H:i:s')
            );
            $tableScores->insert($data);
            
            $result = true;
        }
        else
        {
            $result = false;
        }
        
        return $result;
    }

}