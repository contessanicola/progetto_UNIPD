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
      if(isset($_GET['errore']))
      $output = str_replace('<div id="errore"></div>','<div id="errore">'.$_GET['errore'].'</div>', $output);
}
else{
      header("location: 404.php");
      $output = $import->importEverythingOffline($output);
}

$connect = new DBAccess();
$connect->openDBConnection();

echo($output);
?>