<?php
// Register models
spl_autoload_register(function ($name) {
  $folders = ['models', 'data'];

  foreach ($folders as $folder) {
    $path = $GLOBALS['DIR_APP'] . '/' . $folder . '/' . $name . '.php';
    if (file_exists($path)) {
      require_once $path;
      break;
    }
  }
});
