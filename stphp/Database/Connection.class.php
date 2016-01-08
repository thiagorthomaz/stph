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
  private $settings = null;

  protected $connection = null;
  
  abstract protected function connect(iConnectionDB $config);

  protected function disconect(){
    $this->connection = null;
  }

  function getHost() {
    return $this->host;
  }

  function getPort() {
    return $this->port;
  }

  abstract public function getConnection();

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
