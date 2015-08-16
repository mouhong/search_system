<?php

class Elastic {
  public static function search($type, $query = null) {
    $host = $GLOBALS['ELASTIC_HOST'];
    $port = $GLOBALS['ELASTIC_PORT'];

    $url = "http://$host:$port/search_system/$type/_search";
    if ($query) {
      $url .= "?q=$query";
    }
    $json = file_get_contents($url);

    return json_decode($json)->hits;
  }
}
