<?php

class Repository {
  private $conn;
  private $clazz;

  function __construct($conn, $clazz) {
    $this->conn = $conn;
    $this->clazz = $clazz;
  }

  public function query() {
    return new Query($this->conn, $this->clazz);
  }

  public function transacted($actions) {
    try {
      $this->conn->beginTransaction();
      $actions();
      $this->conn->commit();
    } catch (Exception $e) {
      $this->conn->rollBack();
      throw $e;
    }
  }

  public function create($model) {
    $metadata = ModelMetadata::get($this->clazz);

    $fields = [];
    $values = [];
    $params = [];

    foreach ($metadata->getProperties() as $prop) {
      $prop_name = $prop->name;

      if (Conventions::isIdentityField($prop_name)) {
        continue;
      }

      $fields[] = $prop_name;
      $values[] = ":$prop_name";
      $params[$prop_name] = $model->$prop_name;
    }

    $table = Conventions::toTableName($this->clazz);
    // TODO: Select model id because we don't generate id in app layer
    $sql = 'insert into ' . $table . ' (' . join(',', $fields) .
           ') values (' . join(',', $values) . ')';

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
  }

  public function update($model) {
    // TODO: Not implemented
  }

  public function delete($predicate, $params) {
    // TODO: Not implemented
  }
}
