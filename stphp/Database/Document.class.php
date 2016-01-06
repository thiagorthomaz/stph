<?php

namespace stphp\Database;

/**
 * Description of Collection
 *
 * @author thiago
 */
abstract class Document implements \stphp\Database\iDataModel{
  
  protected $_id;
  //protected $aggregated_to = array();
  
  function get_Id() {
    return (string)$this->_id;
  }

  function set_Id($id) {
    if (empty($id)){
      $id = null;
    }
    $this->_id = new \MongoId($id);
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
            if ($r instanceof \stphp\Database\iDataModel){
              $value_list[$att][] = $r->toArray();
            } else {
              $value_list[$att][] = $r;
            }
            
          }
      } elseif (is_object($return)){
        if ($return instanceof \MongoId){
          $value_list[$att] = $return;
        } if ($return instanceof \MongoTimestamp) {
          $value_list[$att] = $return;
        }else {
          $value_list[$att] = $return->toArray();
        }
        
      } else {
        $value_list[$att] = $return;
        if (!is_null($return)){
          
        }
        
      }
      
    }
    
    return $value_list;
    
  }
  
  /**
   * @TODO improve this method and toArray
   * @return array
   */
  public function toDocument() {

    $attr_list = $this->getAttributeList();
    $value_list = array();

    foreach ($attr_list as $att) {
      $descriptor = $this->getDescription($att);
      
      if ($att == "_id"){
        $return = call_user_func(array($this, "get" . ucfirst($att)));
        if (empty($return)){
          $return = null;
        }
        $value_list[$att] = new \MongoId($return);
        
      } else {

        $return = call_user_func(array($this, "get" . ucfirst($att)));
        if ($return instanceof \stphp\Database\Document){
          $value_list[$att] = $return->toDocument();  
        } else if ($descriptor) {
          
          if ($descriptor->getRelationship() == \stphp\FieldsDescriptor::oneToOne){
            if ( $descriptor->getOnlyKey() ){
              $value_list[$att] = new \MongoId($return);
            }
          }
          
          if ($descriptor->getRelationship() == \stphp\FieldsDescriptor::oneToMany){
            if (!is_null($return)){
              foreach ($return as $r) {
                
                if ( $descriptor->getOnlyKey() ){
                  $value_list[$att][] = new \MongoId($r);
                }else {
                  $value_list[$att][] = $r->toDocument();
                }
                
              }  
            }
            

          }

          
        } else {
          $value_list[$att] = $return;
        }
        
      }
    }
    
    return $value_list;
  }

  /**
   * 
   * @param string $field
   * @param \stphp\Database\iDataModel $obj
   * @return FieldsDescriptor
   */
  public function getDescription($field) {
    $fieldsDescriptors = $this->getFieldsDescriptor();
    if (!is_null($fieldsDescriptors)){
      foreach ($fieldsDescriptors as $i => $description){
        if ($description->getField_name() === $field){
          return $description;
        }
      }
    }
    
    
    return false;
  }
  
  public function toJson(){
    return json_encode($this->toArray());
  }
  
}
