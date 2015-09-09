<?php

namespace stphp\Database;

/**
 * Description of MongoConnection
 *
 * @author thiago
 */
class MongoDB extends \stphp\Database\Connection implements \stphp\Database\iDAO {

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
    $this->collection = $this->connection->selectCollection($this->document_name);
  }

  public function delete($criteria) {
    $this->collection->remove($criteria);
  }

  public function insert(\stphp\Database\iDataModel &$data_model) {
    $document = $data_model->toArray();

    unset($document['id']); //If send this to the insert function, will be created a field "ID" without value

    $rs = $this->collection->insert($document);

    if (is_null($rs['err']) && $rs['ok']) {
      $new_id = $document['_id']->{'$id'};
      $data_model->setId($new_id);
    } else {
      throw new \stphp\Exception\MongoDBException("Erro: " . $rs['err']);
    }

    return $data_model;
  }

  public function select() {
    return $this->collection->find();
  }

  public function selectAll() {

    $rs = array();
    $cursor = $this->collection->find();
    foreach ($cursor as $id => $document) {
      foreach ($document as $field_name => $field_value) {
        $rs[$id][$field_name] = $field_value;
      }
    }

    return $rs;
  }

  public function update($criteria, \stphp\Database\iDataModel &$data_model) {
    $this->collection->update($criteria, array("$set" => $this->document->toArray()));
  }

  private function array_to_obj($array, &$obj) {

    foreach ($array as $key => $value) {
      if (is_array($value)) {    
        $instance = call_user_func(array($obj, "get" . $key));
        $this->array_to_obj($value, $instance);
        
      } else {
        call_user_func(array($obj, "set" . $key), $value);
      }

    }
    
    return $obj;
  }


  public function toObject($array_mongo, \stphp\Database\iDataModel &$data_model) {
    if (isset($array_mongo['_id'])) {
      $array_mongo['id'] = $array_mongo['_id']->{'$id'};
      unset($array_mongo['_id']);
    }
    
    return $this->array_to_obj($array_mongo, $data_model);

  }

}
