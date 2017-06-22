<?php

namespace stphp\Database;

/**
 *
 * @URL http://php.net/manual/en/mongo.sqltomongo.php
 * @author thiago
 */
interface iDAO {
  
  public function insert(\stphp\Database\iDataModel &$data_model);
  /**
   * 
   * @param array $criteria
   */
  public function update(\stphp\Database\iDataModel &$data_model, $criteria = null);
  
  /**
   * 
   * @param array $criteria
   */
  public function delete(\stphp\Database\iDataModel &$data_model);
  public function select(\stphp\Database\iDataModel &$data_model);
  public function selectAll();
  public function sendQuery($query, $params);
  
  
}
