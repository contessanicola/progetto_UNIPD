<?php
require_once "functions/importModules.php";
require_once "functions/db.php";
require_once "functions/preferiti.php";

session_start();

$output = file_get_contents("../html/home.html");



if(isset($_SESSION['username'])){
      $output = importModules::importEverythingOnline($output);
      //<a href="dettagli.php?id_casa="     "><img src="../media/immaginiCase/1/temp.jpeg" class="preview_casa"></a>

      $connect = new DBAccess();
      $connect->openDBConnection();
      $preferiti = $connect->db_getArray(getPreferitiByField("username",$_SESSION['username']));
      $temp = "";
      if(isset($preferiti)){
            foreach($preferiti as $casa){
                  $temp .= '<a href="dettagli.php?id_casa='.$casa["id_casa"].'" class="link">'.'<img src="../media/immaginiCase/'.$casa["id_casa"].'/'.$casa["id_casa"].'a.jpeg" class="preview_casa"></a>';
            }      
            $output = str_replace('<section id="preferiti"></section>', '<section id="preferiti">'.$temp.'</section>', $output);   
      }      
      
      $connect->closeConnection(); 
}
else{
      $output = importModules::importEverythingOffline($output);
}

echo($output);

?>