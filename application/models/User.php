<?php
class User extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
    
    function show(){
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->selectCollection("users");
        $result = $tableUsers->find();
        $result = iterator_to_array($result);
    }

    function insert($params)
    {
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->selectCollection("users");
        $tableUsers->insert($params);
    }

    function update($params)
    {
        $m = new MongoClient();
        $db = $m->selectDB("database");
        $tableUsers = $db->selectCollection("users");
        $tableUsers->update($params);
    }
    
    function delete($params){
        
    }

}