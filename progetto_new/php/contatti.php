<?php
require_once "functions/importModules.php";

session_start();

$output = file_get_contents("../html/contatti.html");

if(isset($_SESSION['username'])){
      $output = importModules::importEverythingOnline($output);
}
else{
      $output = importModules::importEverythingOffline($output);
}

echo($output);
?>