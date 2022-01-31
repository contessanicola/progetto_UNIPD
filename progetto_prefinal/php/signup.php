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
$output = str_replace('href="signup.php"','', $output);
if(isset($_GET['errore']))
      $output = str_replace('<div id="errore"></div>','<div id="errore">'.$_GET['errore'].'</div>', $output);
echo($output);
?>