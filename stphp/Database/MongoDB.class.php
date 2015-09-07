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
    $rs = $this->collection->insert($document);
    
    if (is_null($rs['err']) && $rs['ok'] ){
      $new_id = $document['_id']->{'$id'};
      $data_model->setId($new_id);      
    } else {
      "falha";
    }
    
    return $data_model;
    
  }
  
  public function select() {
    return $this->collection->find();
  }
  
  public function selectAll() {
    return $this->collection->find();
  }

  public function update($criteria, \stphp\Database\iDataModel &$data_model) {
    $this->collection->update($criteria, array("$set" => $this->document->toArray()));
  }

}
