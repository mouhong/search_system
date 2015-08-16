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

  // TODO: Optimistic concurrency control
  public function update($model) {
    $metadata = ModelMetadata::get($this->clazz);
    $table = Conventions::toTableName($this->clazz);
    $sql = "update $table set ";
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

    return $sql .= $where;

    $stmt = $this->conn->prepare($sql .= $where);
    $stmt->execute($params);
  }

  public function delete($id) {
    $table = Conventions::toTableName($this->clazz);
    $id_filed = ModelMetadata.get($this->clazz)->getIdProperty();
    $sql = "delete from $table where {$id_field}= :{$id_field}";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      $id_field => $id
    ]);
  }
}
