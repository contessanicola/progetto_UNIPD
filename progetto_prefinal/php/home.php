<?php
namespace DB;
require_once "functions/importModules.php";
require_once "model/preferiti.php";
require_once "functions/lib_sessioni.php";

$output = file_get_contents("../html/home.html");

$import = new \importModules();

if(is_logged()){
      $output = $import->importEverythingOnline($output);
      //<a href="dettagli.php?id_casa="     "><img src="../media/immaginiCase/1/temp.jpeg" class="preview_casa"></a>

      $connect = new DBAccess();
      $connect->openDBConnection();
      $preferiti = $connect->db_getArray(getPreferitiByField("username",$_SESSION['user']));
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
      $output = $import->importEverythingOffline($output);
}

echo($output);

?>