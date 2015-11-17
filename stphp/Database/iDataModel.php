<?php

namespace stphp\Database;

/**
 *
 * @author thiago
 */
interface iDataModel {
  public function set_Id($id);
  public function get_Id();
  public function getFieldsDescriptor();
  public function getDescription($field);
}
