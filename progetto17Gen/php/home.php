<?php
require_once "functions/importModules.php";

$output = file_get_contents("../html/home.html");
echo str_replace('<header></header>',importModules::header(),
      str_replace('<aside id="sidebar"></aside>',importModules::sidebar(),
      str_replace('<footer></footer>',importModules::footer(),$output)));
?>