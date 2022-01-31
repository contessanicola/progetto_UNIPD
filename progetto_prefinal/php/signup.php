<?php
namespace DB;
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";
require_once "functions/importModules.php";
$output = file_get_contents("../html/signup.html");

$import = new \importModules();

if(is_logged()){
      $output = $import->importEverythingOnline($output);
}
else{
      $output = $import->importEverythingOffline($output);
}

echo($output);
?>