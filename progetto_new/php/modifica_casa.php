<?php
require_once "functions/importModules.php";
require_once "functions/db.php";
require_once "functions/casa.php";

$output = file_get_contents("../HTML/modifica_casa.html");
session_start();
if(isset($_SESSION['username'])){
      $output = importModules::importEverythingOnline($output);
}
else{
      $output = importModules::importEverythingOffline($output);
}

$connect = new DBAccess();
$connect->openDBConnection();


if(isset($_SESSION["isAdmin"])){
      $casa = $connect->db_getArray(getCasaBy1Field("id_casa", $_GET["id_casa"]));

      $casa = $casa[0];
      $output = str_replace('placeholder="id_casa', 'placeholder="' . $casa["id_casa"], $output);
      $output = str_replace('placeholder="regione', 'placeholder="' . $casa["regione"], $output);
      $output = str_replace('placeholder="provincia', 'placeholder="' . $casa["provincia"], $output);
      $output = str_replace('placeholder="citta', 'placeholder="' . $casa["citta"], $output);
      $output = str_replace('placeholder="via', 'placeholder="' . $casa["via"], $output);
      $output = str_replace('placeholder="civico', 'placeholder="' . $casa["civico"], $output);
      $output = str_replace('placeholder="tipologia', 'placeholder="' . $casa["tipologia"], $output);
      $output = str_replace('placeholder="superficie', 'placeholder="' . $casa["superficie"], $output);
      $output = str_replace('placeholder="camere', 'placeholder="' . $casa["camere"], $output);
      $output = str_replace('placeholder="bagni', 'placeholder="' . $casa["bagni"], $output);
      $output = str_replace('placeholder="parcheggio', 'placeholder="' . $casa["parcheggio"], $output);
      $output = str_replace('placeholder="giardino', 'placeholder="' . $casa["giardino"], $output);
      $output = str_replace('placeholder="piscina', 'placeholder="' . $casa["piscina"], $output);
      $output = str_replace('placeholder="patio', 'placeholder="' . $casa["patio"], $output);
      $output = str_replace('placeholder="angolo_bar', 'placeholder="' . $casa["angolo_bar"], $output);
      $output = str_replace('placeholder="idromassaggio', 'placeholder="' . $casa["idromassaggio"], $output);
      $output = str_replace('placeholder="terrazzo', 'placeholder="' . $casa["terrazzo"], $output);
      $output = str_replace('placeholder="arredato', 'placeholder="' . $casa["arredato"], $output);
      $output = str_replace('placeholder="prezzo', 'placeholder="' . $casa["prezzo"], $output);
      $output = str_replace('placeholder="descrizione', 'placeholder="' . $casa["descrizione"], $output);
}
else{
      header("location: errore.php?errore=404+Page+Not+Found");
}





echo($output);
?>