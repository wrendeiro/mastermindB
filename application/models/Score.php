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
        
        $resultUser = $tableUsers->findOne($params);
        if(!empty($resultUser)){
            //$resultScore = $tableScores->find(array('idUser' => $resultUser['_id']));
            $resultScore = $tableScores->aggregate(
                    array('$group' => array('idUser' => $resultUser['_id'], 'pts' => array('$sum' => '$vlScore')))
            );
            $result = $resultScore;
        }
        else
        {
            $result = array();
        }
        
        return $result;
    }
    
    function getPersonalRecord($params){
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->selectCollection("users");
        $tableScores = $db->selectCollection("scores");
        
        $resultUser = $tableUsers->findOne($params);
        if(!empty($resultUser)){
            $resultScore = $tableScores->find(array('idUser' => $resultUser['_id']));
            $result = $resultScore;
        }
        else
        {
            $result = array();
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
                'dtScore' => date()
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