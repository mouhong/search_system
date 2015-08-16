<?php

class UserDeleted {
  public $userId;

  function __construct($userId) {
    $this->userId = $userId;
  }
}
