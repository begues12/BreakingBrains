<?php

#Mostrar Errores

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class) {
  $class = str_replace('\\', '/', $class);
  $path = $_SERVER['DOCUMENT_ROOT'] . explode('?', $_SERVER['REQUEST_URI'], 2)[0];
  if (!file_exists("/".$class . '.php')) {
    require_once $path . '/' . $class . '.php';
  }else{
    echo "<b>Error:</b> Class not found: {$class}.php";
  }

});

function pre_array($array)
{
  echo "<pre>";
  print_r($array);
  echo "</pre>";
}

$ImportMVC = new Engine\Core\ImportMVC();
$ImportMVC->execute();

?>
