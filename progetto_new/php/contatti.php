<?php
require_once "functions/importModules.php";

session_start();

$output = file_get_contents("../html/contatti.html");

$output = str_replace('<header></header>',importModules::header(),$output);
$output = str_replace('<nav id="sidebar"></nav>',importModules::sidebar(),$output);
$output = str_replace('<footer></footer>',importModules::footer(),$output);

if(isset($_SESSION['username'])){
      $output = str_replace('<div id="nav_area_riservata"></div>',importModules::nav_online(), $output);
}
else{
      $output = str_replace('<div id="nav_area_riservata"></div>',importModules::nav_offline(), $output);
}

echo($output);
?>