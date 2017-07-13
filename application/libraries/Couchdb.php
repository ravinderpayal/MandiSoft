<?php
$autoloader = join(DIRECTORY_SEPARATOR,[__DIR__,'vendor','autoload.php']);
require $autoloader;

//We import the classes that we need
use PHPOnCouch\CouchClient;
use PHPOnCouch\Exceptions;
class Couchdb{
    //We create a client to access the database
    private $client = null;
   function constructor(){
        $this->client = new CouchClient('http://ravinder:secure_@@localhost:5984','mandisoft_sfc');
   }

   function checkDB(){
    //We create the database if required
    if(!$client->databaseExists()){
        $client->createDatabase();
    }
   }

   function addDocument($doc){
        $doc = new CouchDocument($client);
        $doc->set($doc);
   }

   function dbInfo(){
        return ($client->getDatabaseInfos());
   }

    //Note:  Every request should be inside a try catch since CouchExceptions could be thrown.For example, let's try to get a unexisting document
    function getDocByID($id){
        try{
            $client->getDoc($id);
            echo 'Document found';
        }
        catch(Exceptions\CouchNotFoundException $ex){
            if($ex->getCode() == 404)
                echo 'Document not found';
        }
    }
}