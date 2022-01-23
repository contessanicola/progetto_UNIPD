<?php
require_once "functions/importModules.php";
require_once "functions/db.php";
require_once "functions/preferiti.php";
require_once "functions/login.php";

session_start();

$output = file_get_contents("../html/area_riservata.html");

if(isset($_SESSION['username'])){
      $output = importModules::importEverythingOnline($output);
      //<a href="dettagli.php?id_casa="     "><img src="../media/immaginiCase/1/temp.jpeg" class="preview_casa"></a>

      $connect = new DBAccess();
      $connect->openDBConnection();
      $informazioni = $connect->db_getArray(getLoginByField("username", $_SESSION['username']));
      $preferiti = $connect->db_getArray(getPreferitiByField("username",$_SESSION['username']));
      $temp = "";

      if(isset($preferiti)){
            foreach($preferiti as $casa){
                  $temp .= '<a href="dettagli.php?id_casa='.$casa["id_casa"].'"><img src="../media/immaginiCase/1/temp.jpeg" class="preview_casa"></a>';
            }      
            $output = str_replace('<div id="lista_preferiti"></div>', '<div id="lista_preferiti">'.$temp.'</div>', $output);   
      }  
      
      $output = str_replace('<span id="info_username"></span>', '<span id="info_username">' .$informazioni[0]["username"]. '</span>',$output);
      $output = str_replace('<span id="info_nome"></span>', '<span id="info_nome">' .$informazioni[0]["nome"]. '</span>',$output);
      $output = str_replace('<span id="info_cognome"></span>', '<span id="info_cognome">' .$informazioni[0]["cognome"]. '</span>',$output);
      $output = str_replace('<span id="info_email"></span>', '<span id="info_email">' .$informazioni[0]["mail"]. '</span>',$output);
      $output = str_replace('<span id="info_telefono"></span>', '<span id="info_telefono">' .$informazioni[0]["numero_telefono"]. '</span>',$output);

}
else{
    header("location: home.php");
}

echo($output);

$connect->closeConnection();
?>