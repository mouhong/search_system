<?php

class Elastic {
  public static function search($type) {
    $host = $GLOBALS['ELASTIC_HOST'];
    $port = $GLOBALS['ELASTIC_PORT'];

    $url = "http://$host:$port/search_system/$type/_search";
    $json = file_get_contents($url);

    return json_decode($json)->hits;
  }
}
