<?php

namespace stphp\Database;

/**
 * Description of MySQL
 *
 * @author thiago
 */
class MySQL extends \stphp\Database\Connection implements \stphp\Database\iDAO {
  
  
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
  
  /**
   * 
   * @return \PDO
   */
  public function getConnection() {
    return $this->connection;
  }

  public function delete($criteria) {
    

  }

  public function insert(iDataModel &$data_model) {
    
  }

  public function select(iDataModel &$data_model) {
    
    
  }

  public function selectAll() {
    

  }

  public function update($criteria, iDataModel &$data_model) {


  }


}
