<?php
namespace DB;
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";
$output = file_get_contents("../html/errore.html");
$import = new \importModules();
if(is_logged()){
      $output = $import->importEverythingOnline($output);
}
else{
      $output = $import->importEverythingOffline($output);
}

if(isset($_GET["errore"]))
$output = str_replace('<section id="errore"></section>', '<section id="errore">'.$_GET["errore"].'</section>', $output);

echo($output);
?>