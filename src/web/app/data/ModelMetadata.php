<?php

class ModelMetadata {
  private $clazz;

  function __construct($clazz) {
    $this->clazz = $clazz;
  }

  public function getProperties() {
    // TODO: I think reflection is slow, we might need to cache the result.
    //       Figure it out later
    $reflector = new ReflectionClass($this->clazz);

    // TODO: Better to filter properties base on annotations.
    //       How does PHP annotations work?
    return $reflector->getProperties(ReflectionProperty::IS_PUBLIC);
  }

  public static function get($clazz) {
    return new ModelMetadata($clazz);
  }
}
