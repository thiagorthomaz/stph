<?php

namespace app\controller;

/**
 * Description of User
 *
 * @author thiago
 */
class User extends \app\controller\Controller{
  
  private $format = "application/json";
  

  public function delete($parameters) {
    
  }

  public function get($parameters) {
    
    $view = new \app\view\View();
    $view->setData(array("msg" => "Sucess"));
    return $view;
  }

  public function save($parameters) {
    
  }

  public function update($parameters) {
    
  }

}
