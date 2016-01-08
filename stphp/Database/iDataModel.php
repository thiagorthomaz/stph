<?php

namespace stphp\Database;

/**
 *
 * @author thiago
 */
interface iDataModel {
  public function setId($id);
  public function getId();
  public function getFieldsDescriptor();
  public function getDescription($field);
}
