<?php

namespace stphp\Database;

/**
 *
 * @author thiago
 */
abstract class Connection {
  
  private $host = null;
  private $port = null;
  private $connection = null;
  private $database = null;
  
  public function __construct($host = "", $port = "", $database = ""){
    
  }
  
  protected function connect(){
    $mongodb = new MongoClient();
    $this->connection = $mongodb->$this->$database;
  }
  protected function disconect(){
    $this->connection = null;
  }

  function getHost() {
    return $this->host;
  }

  function getPort() {
    return $this->port;
  }

  function getConnection() {
    return $this->connection;
  }

  function getDatabase() {
    return $this->database;
  }

  function setDatabase($database) {
    $this->database = $database;
  }

  function setHost($host) {
    $this->host = $host;
  }

  function setPort($port) {
    $this->port = $port;
  }

  function setConnection($connection) {
    $this->connection = $connection;
  }


  
  
}
