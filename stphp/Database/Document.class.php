<?php

namespace stphp\Database;

/**
 * Description of Collection
 *
 * @author thiago
 */
abstract class Document implements \stphp\Database\iDataModel{
  
  protected $id;
  //protected $aggregated_to = array();
  
  function getId() {
    return $this->id;
  }

  function setId($id) {
    $this->id = $id;
  }
  
  protected function getAttributeList(){
    $rc = new \ReflectionClass(get_class($this));
    $attribute_list = array();

    foreach ($rc->getProperties() as $prop){
      $attribute_list[] = $prop->name;
    }
    
    return $attribute_list;
  }
  
  public function toArray(){

    $attr_list = $this->getAttributeList();
    $value_list = array();
    
    foreach ($attr_list as $att){
      
      $return = call_user_func(array($this, "get" . ucfirst($att)));
      
      if (is_array($return)){
        foreach ($return as $r){
          $value_list[$att][] = $r->toArray();
        }
      } elseif (is_object($return)){
        if ($return instanceof \MongoId){
          $value_list["_id"] = $return;
        } else {
          $value_list[$att] = $return->toArray();
        }
        
      } else {
        $value_list[$att] = $return;
      }
      
    }
    
    return $value_list;
    
  }
  
  public function toJson(){
    return json_encode($this->toArray());
  }
  
}
