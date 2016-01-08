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
  public function update($criteria, \stphp\Database\iDataModel &$data_model);
  
  /**
   * 
   * @param array $criteria
   */
  public function delete(\stphp\Database\iDataModel &$data_model);
  public function select(\stphp\Database\iDataModel &$data_model);
  public function selectAll();
  
  
}
