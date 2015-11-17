<?php

namespace stphp;

/**
 * Description of FieldsDescriptor
 *
 * @author thiago
 */
class FieldsDescriptor {
  
  const oneToMany = 1;
  const oneToOne  = 2;
  const ManyToOne = 3;

  private $namespace = "";
  private $field_name = "";
  private $type = "";
  private $relationship;
  private $onlyKey = false;
  
  function getNamespace() {
    return $this->namespace;
  }

  function getField_name() {
    return $this->field_name;
  }

  function getType() {
    return $this->type;
  }

  function getRelationship() {
    return $this->relationship;
  }
  
  function getOnlyKey() {
    return $this->onlyKey;
  }

  function setOnlyKey($onlyKey) {
    if (!is_bool($onlyKey)){
      throw new Exception\STException("Variable onlyKey must be a boolean.");
    }
    $this->onlyKey = $onlyKey;
  }

  function setRelationship($relationship) {
    
    if ( ($relationship !== self::oneToMany) && ($relationship !== self::oneToOne) && ($relationship !== self::ManyToOne) ) {
      throw new \stphp\Exception\STException("Constant undefined.");
    }

    $this->relationship = $relationship;

  }
  
  function setNamespace($namespace) {
    $this->namespace = $namespace;
  }

  function setField_name($field_name) {
    $this->field_name = $field_name;
  }

  function setType($type) {
    $this->type = $type;
  }

  
}
