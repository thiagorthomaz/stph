<?php

namespace stphp\Database;

/**
 * Description of MySQL
 *
 * @author thiago
 */
abstract class MySQL extends \stphp\Database\Connection implements \stphp\Database\iDAO {

  protected function connect(iConnectionDB $config){

    $username = $config->getUser();
    $pass = $config->getpassword();
    
    $driver = $config->getDriver();
    $database = $config->getDatabase();
    $host = $config->getHost();
    
    $dsn = $driver.':dbname='.$database.";host=".$host;
    $pdo = new \PDO($dsn, $username, $pass);
    
    $this->connection = $pdo;

  }
  
  abstract public function getTable();

  /**
   * 
   * @return \PDO
   */
  public function getConnection() {
    return $this->connection;
  }

  public function delete(\stphp\Database\iDataModel &$data_model) {
    $sql = "delete from " . $this->getTable() . " where id = :id" . " LIMIT 1";
    return $this->connection->query($sql, array($data_model->getId()));
  }

  public function insert(iDataModel &$data_model) {
    
  }


  public function select(iDataModel &$data_model, $params = array(), $condition = "AND") {
    
    $sql = "SELECT * from " . $this->getTable();
    $prepared_query = $this->connection->prepare($sql);
    
    $where_params = array();
    
    if (count($params) > 0 ) {

      end($params);
      $last_key = key($params);
      reset($params);
      
      $where = " where ";

      foreach ($params as $key => $value) {
        $where .= $key . " = :" . $key;
        if ($key != $last_key){
          $where .= " " . $condition . " ";
        }
        $where_params[":".$key] = $value;
      }
      
      $sql .= $where;

      $prepared_query = $this->connection->prepare($sql);
      
    }
    
    $prepared_query->setFetchMode(\PDO::FETCH_ASSOC);
    $prepared_query->execute($where_params);

    $result_list = array();
    while($result = $prepared_query->fetch()) {
      $result_list[] = $result;
    }
    return $result_list;

  }

  public function selectAll($limit = 100) {
    $sql = "select * from " . $this->getTable() . " LIMIT " . $limit;
    $STH = $this->connection->query($sql);
    $STH->setFetchMode(\PDO::FETCH_ASSOC);
    
    $result_list = array();
    
    while($result = $STH->fetch()) {
      $result_list[] = $result;
    }
    
    return $result_list;
    
  }

  public function update($criteria, iDataModel &$data_model) {


  }


}
