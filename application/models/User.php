<?php
class User extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
    
    function show($params){
        
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->selectCollection("users");
        $result = $tableUsers->findOne($params);
        
        return $result;
    }

    function insert($params)
    {
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->selectCollection("users");
        
        $orC = "function() {
            return this.nmUser == '".$params['nmUser']."' || this.nmEmail == '".$params['nmEmail']."';
        }";
        $val = $tableUsers->findOne(array('$where' => $orC));
        if(empty($val)){
            $tableUsers->insert($params);
            $result = true;
        }
        else
        {
            $result = false;
        }
        
        return $result;
    }

    function update($params)
    {
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $email = $params['nmEmail'];
        unset($params['nmEmail']);
        $tableUsers = $db->selectCollection("users");
        
        $tableUsers->update(array("nmEmail" => $email), $params);
    }
    
    function delete($params){
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->users;
        $tableUsers->remove(array('nmEmail' => $params['nmEmail']));
    }
    
    function recoverPass($params){
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->selectCollection("users");
        $result = $tableUsers->findOne($params);
        
        
        return $result;
    }

}