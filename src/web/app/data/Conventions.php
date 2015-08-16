<?php

class Conventions {
  public static function toTableName($clazz) {
    return strtolower($clazz) . 's';
  }

  public static function isIdentityField($name) {
    return $name === 'id';
  }
}
