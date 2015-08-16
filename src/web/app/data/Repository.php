<?php

class Repository {
  private $conn;
  private $clazz;
  private $hasTransaction;

  function __construct($conn, $clazz) {
    $this->conn = $conn;
    $this->clazz = $clazz;
  }

  public function query() {
    return new Query($this->conn, $this->clazz);
  }

  public function transacted($actions) {
    if ($this->hasTransaction) {
      $actions();
    } else {
      try {
        $this->conn->beginTransaction();
        $this->hasTransaction = true;
        $actions();
        $this->conn->commit();
      } catch (Exception $e) {
        $this->conn->rollBack();
        throw $e;
      } finally {
        $this->hasTransaction = false;
      }
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
    $sql = 'INSERT INTO ' . $table . ' (' . join(',', $fields) .
           ') VALUES (' . join(',', $values) . ')';

    $stmt = $this->conn->prepare($sql);
    $id_field = $metadata->getIdProperty($this->clazz)->name;

    $this->transacted(function () use ($stmt, $params, $id_field, $model) {
      $stmt->execute($params);
      $model->$id_field = $this->conn->lastInsertId();
    });
  }

  // TODO: Optimistic concurrency control
  public function update($model) {
    $metadata = ModelMetadata::get($this->clazz);
    $table = Conventions::toTableName($this->clazz);
    $sql = "UPDATE $table SET ";
    $where = NULL;
    $params = [];

    $first = true;

    foreach ($metadata->getProperties() as $prop) {
      $prop_name = $prop->name;
      if (Conventions::isIdentityField($prop_name)) {
        $where = " where $prop_name = :$prop_name";
      } else {
        if (!$first) {
          $sql .= ', ';
        }
        $sql .= "$prop_name = :$prop_name";
        $first = false;
      }

      $prop_value = $model->$prop_name;

      if ($prop_name === 'updated') {
        $prop_value = time();
      }

      $params[$prop_name] = $prop_value;
    }

    $stmt = $this->conn->prepare($sql .= $where);
    $stmt->execute($params);
  }

  public function delete($id) {
    $table = Conventions::toTableName($this->clazz);
    $id_filed = ModelMetadata.get($this->clazz)->getIdProperty();
    $sql = "DELETE FROM $table WHERE {$id_field}= :{$id_field}";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      $id_field => $id
    ]);
  }
}
