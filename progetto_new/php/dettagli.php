<?php
require_once "functions/importModules.php";
require_once "functions/db.php";
require_once "functions/casa.php";
require_once "functions/preferiti.php";

session_start();

$output = file_get_contents("../html/dettagli.html");


if(isset($_SESSION['username'])){
      $output = importModules::importEverythingOnline($output);
}
else{
      $output = importModules::importEverythingOffline($output);
}

$connect = new DBAccess();

$connect->openDBConnection();
$casa = $connect->db_getArray(getCasaBy1Field("id_casa", $_GET["id_casa"]));

$casa = $casa[0];


$output = str_replace('<span class="locali"></span>', '<span class="locali">' . ($casa["camere"] + $casa["bagni"]) . '</span>' , $output);
$output = str_replace('<span class="tipologia"></span>', '<span class="tipologia">' . $casa["tipologia"] . '</span>' , $output);
$output = str_replace('<span class="via"></span>', '<span class="via">'.$casa["via"].'</span>',$output);
$output = str_replace('<span class="civico"></span>', ' <span class="civico">'.$casa["civico"].'</span>',$output);
$output = str_replace('<span class="citta"></span>', ' <span class="citta">'.$casa["citta"].'</span>',$output);
$output = str_replace('<span class="provincia"></span>', ' <span class="provincia">'.$casa["provincia"].'</span>',$output);
$output = str_replace('<span class="prezzo"></span>', '<span class="prezzo">'.$casa["prezzo"].'</span>',$output);
$output = str_replace('<span class="camere"></span>', '<span class="camere">'.$casa["camere"].'</span>',$output);
$output = str_replace('<span class="superficie"></span>', '<span class="superficie">'. $casa["superficie"] . '</span>',$output);
$output = str_replace('<span class="bagni"></span>', '<span class="bagni">'.$casa["bagni"].'</span>',$output);
$output = str_replace('<div class="descrizione"></div>', '<div class="descrizione">'.$casa["descrizione"].'</div>',$output);
$output = str_replace('<a href="" class="link">', '<a href="dettagli.php?id_casa='.$casa["id_casa"].'" class="link">',$output);

if(isset($_SESSION['username'])){
      $preferito = $connect->db_getArray(getPreferitiByMoreField(array("id_casa","username"), array($_GET["id_casa"],$_SESSION['username'])));

      if(isset($preferito)){
            $output = str_replace('<a class="preferito"></a>', '<a class="preferito true" href="toggle_preferito.php?id_casa='.$_GET["id_casa"].'&username='.$_SESSION['username'].'&preferito=rimuovi">Rimuovi Preferito</a>',$output);
      }
      else{
            $output = str_replace('<a class="preferito"></a>', '<a class="preferito true" href="toggle_preferito.php?id_casa='.$_GET["id_casa"].'&username='.$_SESSION['username'].'&preferito=aggiungi">Aggiungi Preferito</a>',$output);
      }

      if($_SESSION['isAdmin'] == 1){
            $output .= '<a href="rimuovi_casa.php?id_casa='. $_GET["id_casa"].'">Rimuovi</a> ';
            $output .= '<a href="modifica_casa.php?id_casa='. $_GET["id_casa"].'">Modifica</a>';
      }
}

echo($output);
$connect->closeConnection()
?>