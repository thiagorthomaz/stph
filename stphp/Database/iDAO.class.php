<?php

namespace stphp\Database;

/**
 *
 * @author thiago
 */
interface iDAO {
  
  public function insert();
  public function update();
  public function delete();
  public function select();
  
  
}
