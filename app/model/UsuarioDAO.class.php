<?php

namespace app\model;

/**
 * Description of UserDAO
 *
 * @author thiago
 */
class UsuarioDAO extends \app\model\DAO {
  
  public function __construct() {
    
    $this->document_name = "Usuario";
    $this->document = new \app\model\Usuario();
    
    parent::__construct();
    
  }
  
}
