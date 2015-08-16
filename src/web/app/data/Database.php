<?php

class Database {

  // TODO: Is there built-in connection pooling support?
  public static function getConnection() {
    $pdo = new PDO(
      $GLOBALS['DB_DSN'],
      $GLOBALS['DB_USER_NAME'],
      $GLOBALS['DB_PWD']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
  }

  public static function repository($class) {
    return new Repository(Database::getConnection(), $class);
  }
}
