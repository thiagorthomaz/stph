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
    
    $this->driver = $config->getDriver();
    $this->database = $config->getDatabase();
    $this->host = $config->getHost();
    
    $dsn = $this->driver.':dbname='.$this->database.";host=".$this->host;
    $pdo = new \PDO($dsn, $username, $pass);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $this->connection = $pdo;

  }
  
  abstract public function getTable();
  abstract public function getModel();
  abstract public function modeltoArray(\stphp\Database\iDataModel $data_model);
  
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

    $bindings = $this->modeltoArray($data_model);

    $fields = array_keys($bindings);

    $fields_vals = array(implode("`,`", $fields) . "`", ",:" . implode(",:", $fields));
    $table_name = "`" . $this->database . "`.`" .$this->getTable();
    $sql = str_replace("(,", "(", "INSERT INTO " . $table_name . "` (`" .$fields_vals[0] . ") VALUES (" . $fields_vals[1] . ");");

    $inserted = $this->sendQuery($sql, $bindings);

    return $inserted;

  }

  protected function getTableNick($table_name){
    return substr(md5($table_name), 0, 6);
  }
  
  
  public function select(iDataModel &$data_model) {
    
    $table_name = $this->getTable();
    $sql = "select * from " . $table_name . " where id = :id";

    $STH = $this->connection->prepare($sql);
    $id = $data_model->getId();
    $STH->bindParam("id", $id);
    $STH->execute();
    
    $STH->setFetchMode(\PDO::FETCH_ASSOC);
    
    $result_list = array();
    
    while($result = $STH->fetch()) {
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

  protected function where($params){
    $sql = "";
    if (count($params) > 0){
      $sql .= "\nwhere ";
      end($params);
      $last_column = key($params);
      reset($params);
      
      foreach ($params as $column => $value) {
        $sql .= $column . " = :" . $column;
        if ($column !== $last_column){
          $sql .= " and ";
        }
      }
    }
    
    return $sql;
    
  }
  
  /**
   * If is a select query, this method will return a fetched result.
   * If is a insert|delete|update query, will return the number of affected rows
   * 
   * @param string $query
   * @param array $params
   * @return mixed
   */
  public function sendQuery($query, $params) {

    $conn = $this->getConnection();
    $prepared = $conn->prepare($query);

    $exec_params = array();
    foreach ($params as $column => $value){
      $exec_params[":" . $column] = $value;
    }
    
    
    $prepared->execute($exec_params);

    $result_list = $prepared->rowCount();
    
    /**
     * The insert|updade|delete query doesn't return a 'fetchable' value.
     * 
     */
    if (count(explode("select", $query)) > 1){
      $prepared->setFetchMode(\PDO::FETCH_ASSOC);

      $result_list = array();
      while($result = $prepared->fetchAll()) {
        $result_list[] = $result;
      }
      
    }

    return $result_list;
  }

}