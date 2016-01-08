<?php

namespace stphp\Database;

/**
 *
 * @author thiago
 */
interface iConnectionDB {
  
  public function getHost();
  public function getPort();
  public function getDatabase();
  public function getDriver();
  public function getUser();
  public function getpassword();
  public function setUser($username);
  public function setpassword($pass);
  
}
