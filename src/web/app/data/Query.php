<?php

// TODO: Implement Iterator
class Query {
  private $clazz;
  private $conn;
  private $params;
  private $predicates = [];
  private $orderBys = [];

  function __construct($conn, $clazz) {
    $this->conn = $conn;
    $this->clazz = $clazz;
  }

  public function where($predicate, $params = null) {
    if (!$predicate) {
      throw new Exception('$predicate is required.');
    }

    $this->predicates[] = $predicate;

    if ($params) {
      foreach ($params as $name => $value) {
        $this->params[$name] = $value;
      }
    }

    return $this;
  }

  public function orderBy($expression) {
    if (!$expression) {
      throw new Exception('$expression is required.');
    }

    $this->orderBys[] = $expression;

    return $this;
  }

  public function first() {
    $stmt = $this->execute();
    if ($model = $stmt->fetch()) {
      return $model;
    }
  }

  public function toList() {
    $stmt = $this->execute();
    $result = [];
    while ($model = $stmt->fetch()) {
      $result[] = $model;
    }

    return $result;
  }

  public function getSql() {
    $table = Conventions::toTableName($this->clazz));
    $sql = "select * from {$table}";

    if ($this->predicates) {
      $first = true;
      foreach ($this->predicates as $predicate) {
        if ($first) {
          $sql .= ' where';
        } else {
          $sql .= ' and';
        }

        $sql .= ' ' . $predicate;
      }
    }

    if ($this->orderBys) {
      $sql .= ' ' . join(', ', $this->orderBys);
    }

    return $sql;
  }

  private function execute() {
    $sql = $this->getSql();
    $stmt = $this->conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_CLASS, $this->clazz);
    $stmt->execute($this->params);

    return $stmt;
  }
}
