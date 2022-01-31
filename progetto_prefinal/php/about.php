<?php
namespace DB;
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";
$output = file_get_contents("../html/about.html");
$import = new \importModules();
if(is_logged()){
      $output = $import->importEverythingOnline($output);
}
else{
      $output = $import->importEverythingOffline($output);
}
$output = str_replace('href="about.php"','', $output);
echo($output);
?>