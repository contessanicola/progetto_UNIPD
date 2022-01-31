<?php
namespace DB;
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";
require_once "functions/importModules.php";
require_once "model/casa.php";
check_session();
$output = file_get_contents("../html/modifica_password.html");

$import = new \importModules();

if(is_logged()){
      $output = $import->importEverythingOnline($output);
}
else{
      $output = $import->importEverythingOffline($output);
}

$connect = new DBAccess();
$connect->openDBConnection();


if(is_admin()){
      
}
else{
      
}





echo($output);
?>