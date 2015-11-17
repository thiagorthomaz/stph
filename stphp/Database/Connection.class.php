<?php

namespace stphp\Database;

/**
 *
 * @author thiago
 */
abstract class Connection {
  
  private $host = "localhost";
  private $port = "27017";
  private $database = null;
  /**
   *
   * @var \MongoDB 
   */
  protected $connection = null;
  
  
  
  protected function connect(){
    $mongodb = new \MongoClient( "mongodb://" . $this->host . ":" . $this->port );
    $this->connection = $mongodb->selectDB($this->database);

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
