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
        print_r($result);
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
        $this->mongo_db->update('entries', $this, array('id' => $_POST['id']));
    }
    
    function delete($params){
        
    }

}