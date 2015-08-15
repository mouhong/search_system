<?php

class Database {
  public static function getConnection() {
    $pdo = new PDO(
      $GLOBALS['DB_DSN'],
      $GLOBALS['DB_USER_NAME'],
      $GLOBALS['DB_PWD']);

    return $pdo;
  }

  public static function repository($class) {
    return new Repository(Database::getConnection(), $class);
  }
}
