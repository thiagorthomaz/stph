<?php

namespace app\model;

/**
 * Description of DAO
 *
 * @author thiago
 */
class DAO extends \stphp\Database\MongoDB{

  public function __construct() {
    
    $host = "";
    $port = "";
    $this->setDatabase("tcc");
    $this->connect();
    
    parent::__construct();
  }
  
}
