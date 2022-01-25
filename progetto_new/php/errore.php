<?php
require_once "functions/importModules.php";
require_once "functions/db.php";
require_once "functions/preferiti.php";

session_start();

$output = file_get_contents("../html/errore.html");

if(isset($_SESSION['username'])){
      $output = importModules::importEverythingOnline($output);
}
else{
      $output = importModules::importEverythingOffline($output);
}

if(isset($_GET["errore"]))
$output = str_replace('<section id="errore"></section>', '<section id="errore">'.$_GET["errore"].'</section>', $output);  

echo($output);

?>