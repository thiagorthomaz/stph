<?php

namespace app\controller;

/**
 * Description of User
 *
 * @author thiago
 */
class Usuario extends \app\controller\Controller{

  public function delete($parameters) {
    
  }

  public function get($parameters) {
    $model = new \app\model\UsuarioDAO();
    
    $doc = new \app\model\Usuario();
    
    
    $view = new \app\view\View();
    $view->setData($doc->toJson());
    return $view;
  }

  public function save($parameters) {
    $view = new \app\view\View();
    
    $usuario = new \app\model\Usuario();
    $usuario_dao = new \app\model\UsuarioDAO();
    
    $usuario->setId_perfil(1);
    $usuario->setId_tipo(1);
    $usuario->setLogin("thiago");
    $usuario->setSenha("12345");
    
    $usuario_dao->insert($usuario);
    $view->setData($usuario->toJson());
    return $view;
    
  }

  public function update($parameters) {
    
  }

}
