<?php

namespace stphp\Database;

/**
 * Description of MongoConnection
 *
 * @author thiago
 */
abstract class MongoDB extends \stphp\Database\Connection implements \stphp\Database\iDAO {

  /**
   *
   * @var \MongoCollection
   */
  protected $collection = null;

  /**
   *
   * @var \stphp\Database\Document
   * 
   */
  protected $document = null;

  /**
   *
   * @var String
   */
  protected $document_name = null;

  public function __construct() {
    $this->collection = $this->connection->selectCollection($this->getDocumentName());
  }
  
  protected function connect(){
    $mongodb = new \MongoClient( "mongodb://" . $this->host . ":" . $this->port );
    $this->connection = $mongodb->selectDB($this->database);
  }
  
  /**
   * 
   * @return \MongoDB
   */
  public function getConnection() {
    return $this->connection;
  }
  
  abstract protected function getDocumentName();
  abstract protected function getDocument();

  public function delete($criteria) {
    $this->collection->remove($criteria);
  }

  /**
   * 
   * @param \stphp\Database\iDataModel $data_model
   * @return \stphp\Database\iDataModel
   * @throws \stphp\Exception\MongoDBException
   */
  public function insert(\stphp\Database\iDataModel &$data_model) {

    if (!empty($data_model->get_Id())){
      $id = new \MongoId($data_model->get_Id());
    } else {
      $id = new \MongoId();
    }
    $data_model->set_Id($id);
    
    $document = $data_model->toDocument();
    
    $rs = $this->collection->insert($document);

    if ($rs['ok'] == 1 && is_null($rs['err'])){
      return true;
    } else {
      throw new \stphp\Exception\MongoDBException("Insert Failed");
    }

  }

  public function select(\stphp\Database\iDataModel &$data_model) {
    $rs = $this->collection->findOne(array("_id" => new \MongoId($data_model->get_Id())));
    $this->toObject($rs, $data_model);
    return $data_model;
  }

  public function selectAll() {

    $rs = array();
    $cursor = $this->collection->find();
    
    foreach ($cursor as $id => $document) {
      $data_model = $this->getDocument();
      $this->toObject($document, $data_model);
      $rs[] = $data_model;
    }

    return $rs;
  }

  public function update($criteria, \stphp\Database\iDataModel &$data_model, $options = array("upsert"=>false,"multiple"=>false)) {
    $newdata = $data_model->toDocument();
    if ($options["upsert"] === false && $options["multiple"] === false){
      //Not implemented yet.
    }
    
    $rs = $this->collection->update($criteria, $newdata, $options);
    
    if ( ($rs['ok'] == 1) && is_null($rs['err'])) {
      return TRUE;
    }else {
      throw new \stphp\Exception\MongoDBException("Falha: " . $rs['err']);
    }
    
    
  }
  
  private function array_to_obj($array, \stphp\Database\iDataModel &$obj) {
    
     if (is_array($array)) {
       
       $attributes = array_keys($array);
       
       foreach ($attributes as $attr) {

        if (array_key_exists($attr, $array)) {
          
          $array_value = $array[$attr];

          $description = $obj->getDescription($attr);
          
          if ($description) {
            
            $namespace = $description->getNamespace();
            $type = $description->getType();
            $object_name = $namespace . $type; 
            $new_object = new $object_name();

            if ($description->getRelationship() === \stphp\FieldsDescriptor::oneToOne) {
              
              if ($array_value instanceof \MongoId){
                $new_object->set_id($array_value);
                call_user_func(array($obj, "set" . $attr), $new_object);
              } else {
                $this->array_to_obj($array_value, $new_object);
                call_user_func(array($obj, "set" . $attr), $new_object);
              }

            }

            if ($description->getRelationship() === \stphp\FieldsDescriptor::oneToMany) {
              
              if (!is_null($array_value)) {
                foreach ($array_value as $array_value_child){
                  $clone = clone $new_object;
                  if ($array_value_child instanceof \MongoId){
                    $clone->set_id($array_value_child);
                  }else {
                    $this->array_to_obj($array_value_child, $clone);
                  }
                  call_user_func(array($obj, "set" . $attr), $clone);
                }  
              }

            }

          } else {
            
            if (!is_array($array_value)){
              call_user_func(array($obj, "set" . $attr), $array_value);
            }

          }

        }

       }

      }

    return $obj;

  }

  public function toObject($array_mongo, \stphp\Database\iDataModel &$data_model) {
    return $this->array_to_obj($array_mongo, $data_model);
  }
  
  public function count($query = array(), $options = array()){
    return $this->collection->count($query);
  }

}
