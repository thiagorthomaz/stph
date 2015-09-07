<?php

namespace app\model;

/**
 * Description of User
 *
 * @author thiago
 */
class Usuario extends \stphp\Database\Document {
  
  private $id_perfil;
  private $id_tipo;
  private $login;
  private $senha;

  function getId() {
    return $this->id;
  }

  function getId_perfil() {
    return $this->id_perfil;
  }

  function getId_tipo() {
    return $this->id_tipo;
  }

  function getLogin() {
    return $this->login;
  }

  function getSenha() {
    return $this->senha;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setId_perfil($id_perfil) {
    $this->id_perfil = $id_perfil;
  }

  function setId_tipo($id_tipo) {
    $this->id_tipo = $id_tipo;
  }

  function setLogin($login) {
    $this->login = $login;
  }

  function setSenha($senha) {
    $this->senha = $senha;
  }

}
