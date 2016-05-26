<?php

namespace stphp\Database;

/**
 * Description of MySQL
 *
 * @author thiago
 */
abstract class MySQL extends \stphp\Database\Connection implements \stphp\Database\iDAO {
  
  private $resultset;
  
  /**
   * 
   * @return \stphp\Database\ResultSet
   */
  function getResultset() {
    return $this->resultset;
  }
  
  private function setResultset(\stphp\Database\ResultSet $resultset) {
    $this->resultset = $resultset;
  }

  protected function connect(iConnectionDB $config){

    $username = $config->getUser();
    $pass = $config->getpassword();
    
    $this->driver = $config->getDriver();
    $this->database = $config->getDatabase();
    $this->host = $config->getHost();
    
    $dsn = $this->driver.':dbname='.$this->database.";host=".$this->host .";charset=utf8";
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
    $rs = $this->sendQuery($sql, array("id" => $data_model->getId()));
    return $rs->getAffected_rows() > 0;
  }

  public function insert(iDataModel &$data_model) {

    $bindings = $this->modeltoArray($data_model);

    $fields = array_keys($bindings);

    $fields_vals = array(implode("`,`", $fields) . "`", ",:" . implode(",:", $fields));
    $table_name = "`" . $this->database . "`.`" .$this->getTable();
    $sql = str_replace("(,", "(", "INSERT INTO " . $table_name . "` (`" .$fields_vals[0] . ") VALUES (" . $fields_vals[1] . ");");

    $result = $this->sendQuery($sql, $bindings);
    
    if ($result->getAffected_rows() > 0){
      $data_model->setId($result->getLastInsertId());
      return TRUE;
    }
    
    return FALSE;

  }

  public function select(iDataModel &$data_model) {
    
    $table_name = $this->getTable();
    $sql = "select * from " . $table_name . " where id = :id";
    $params = array("id" => $data_model->getId());
    $rs = $this->sendQuery($sql, $params);
    return $rs->getResultSet();

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
    
    $resulset = new \stphp\Database\ResultSet();
    
    try{
      
      $conn = $this->getConnection();
      $prepared = $conn->prepare($query);

      $exec_params = $this->prepareParams($params);

      $prepared->execute($exec_params);

      /**
       * The insert|updade|delete query doesn't return a 'fetchable' value.
       * 
       */
      if (count(explode("select", $query)) > 1) {
        
        $resulset = $this->fetchValues($prepared, $resulset);
        $this->setResultset($resulset);

      } else { //Insert, Update or Delete
        $result_list = $prepared->rowCount();
        $resulset->setAffected_rows($result_list);
        $resulset->setLastInsertId($conn->lastInsertId());
        
      }
      
      return $resulset;
      
    } catch (\PDOException $pdo_exc){
      $resulset->setPdo_exception($pdo_exc);
      $resulset->setError_code($pdo_exc->getCode());
      $resulset->setError_message($pdo_exc->getMessage());
      $resulset->setError_info($pdo_exc->errorInfo);
      return $resulset;
    }

  }
  
  /**
   * 
   * @param array $params
   * @return array
   */
  private function prepareParams($params){
    $exec_params = array();
    foreach ($params as $column => $value){
      $exec_params[":" . $column] = $value;
    }
    return $exec_params;
  }
  /**
   * 
   * @param \PDOStatement $pdo_statement
   * @param \stphp\Database\ResultSet $resultset
   * @return \stphp\Database\ResultSet
   */
  private function fetchValues(\PDOStatement $pdo_statement, \stphp\Database\ResultSet $resultset){
    
    $pdo_statement->setFetchMode(\PDO::FETCH_ASSOC);

    $result_list = array();
    while($result = $pdo_statement->fetchAll()) {
      $result_list[] = $result;
    }

    if (isset($result_list[0])){
      $resultset->setResultSet($result_list[0]);
    }

    return $resultset;
    
  }

}
