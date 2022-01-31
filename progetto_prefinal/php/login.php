<?php
namespace DB;
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";

$output = file_get_contents("../html/login.html");

$import = new \importModules();

if(is_logged()){
      $output = $import->importEverythingOnline($output);
}
else{
      $output = $import->importEverythingOffline($output);
}

echo($output);
?>