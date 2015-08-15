<?php

class Repository {
  private $conn;
  private $class;

  function __construct($conn, $class) {
    $this->conn = $conn;
    $this->class = $class;
  }

  public function query() {
    return new SelectQuery($this->conn, $this->class);
  }
}
