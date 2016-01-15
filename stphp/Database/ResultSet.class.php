<?php

namespace stphp\Database;

/**
 * Description of ResultSet
 *
 * @author thiago
 */
class ResultSet {
  
  private $resultSet = array();
  private $affected_rows = 0;
  private $error_code;
  private $error_message;
  private $error_info;
  
  public function getResultSet() {
    return $this->resultSet;
  }

  public function getAffected_rows() {
    return $this->affected_rows;
  }

  function getError_code() {
    return $this->error_code;
  }

  function getError_info() {
    return $this->error_info;
  }

  function getError_message() {
    return $this->error_message;
  }

  function setError_message($error_message) {
    $this->error_message = $error_message;
  }
  
  function setError_code($error_code) {
    $this->error_code = $error_code;
  }

  function setError_info($error_info) {
    $this->error_info = $error_info;
  }
  
  public function setResultSet($resultSet) {
    $this->resultSet = $resultSet;
  }

  public function setAffected_rows($affected_rows) {
    $this->affected_rows = $affected_rows;
  }

  public function isEmpty(){
    return count($this->getResultSet()) == 0;
  }
  
  public function recordCount(){
    return count($this->getResultSet());
  }

  
}
