<?php
require_once "functions/importModules.php";

$output = file_get_contents("../html/login.html");

if(isset($_SESSION['username'])){
      $output = importModules::importEverythingOnline($output);
}
else{
      $output = importModules::importEverythingOffline($output);
}

echo($output);
?>