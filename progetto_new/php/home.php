<?php
require_once "functions/importModules.php";
require_once "functions/db.php";
require_once "functions/preferiti.php";

session_start();

$output = file_get_contents("../html/home.html");

$output = str_replace('<header></header>',importModules::header(),$output);
$output = str_replace('<nav id="sidebar"></nav>',importModules::sidebar(),$output);
$output = str_replace('<footer></footer>',importModules::footer(),$output);

if(isset($_SESSION['username'])){
      $output = str_replace('<div id="nav_area_riservata"></div>',importModules::nav_online(), $output);
      //<a href="dettagli.php?id_casa="     "><img src="../media/immaginiCase/1/temp.jpeg" class="preview_casa"></a>

      $connect = new DBAccess();
      $connect->openDBConnection();
      $preferiti = $connect->db_getArray(getPreferitiByField("username",$_SESSION['username']));
      $temp = "";
      if(isset($preferiti)){
            foreach($preferiti as $casa){
                  $temp .= '<a href="dettagli.php?id_casa='.$casa["id_casa"].'"><img src="../media/immaginiCase/1/temp.jpeg" class="preview_casa"></a>';
            }      
            $output = str_replace('<section id="preferiti"></section>', '<section id="preferiti">'.$temp.'</section>', $output);   
      }      
      
      $connect->closeConnection(); 
}
else{
      $output = str_replace('<div id="nav_area_riservata"></div>',importModules::nav_offline(), $output);
}

echo($output);

?>