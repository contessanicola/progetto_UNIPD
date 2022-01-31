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
$output = str_replace('href="login.php"','', $output);
if(isset($_GET['errore']))
      $output = str_replace('<div id="errore"></div>','<div id="errore">'.$_GET['errore'].'</div>', $output);

echo($output);
?>