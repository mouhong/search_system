<?php
//namespace models;

class User {
  public $id;
  public $email;
  public $first_name;
  public $last_name;
  public $age;
  public $created;
  public $updated;

  function __construct() {
    $this->created = time();
  }
}
