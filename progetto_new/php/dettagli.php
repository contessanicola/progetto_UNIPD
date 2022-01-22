<?php
require_once "functions/importModules.php";
require_once "functions/db.php";
require_once "functions/casa.php";
require_once "functions/preferiti.php";

session_start();

$output = file_get_contents("../html/dettagli.html");

$output = str_replace('<header></header>',importModules::header(),$output);
$output = str_replace('<nav id="sidebar"></nav>',importModules::sidebar(),$output);
$output = str_replace('<footer></footer>',importModules::footer(),$output);

if(isset($_SESSION['username'])){
      $output = str_replace('<div id="nav_area_riservata"></div>',importModules::nav_online(), $output);
}
else{
      $output = str_replace('<div id="nav_area_riservata"></div>',importModules::nav_offline(), $output);
}

$connect = new DBAccess();

$connect->openDBConnection();
$casa = $connect->db_getArray(getCasaBy1Field("id_casa", $_GET["id_casa"]));

$casa = $casa[0];

$template_casa = file_get_contents("../html/modules/dettagli.html");
$temp = $template_casa;

$temp = str_replace('<div class="tipologia"></div>', '<div class="tipologia">' . $casa["tipologia"] . '</div>' , $temp);
$temp = str_replace('<div class="via"></div>', '<div class="via">'.$casa["via"].'</div>',$temp);
$temp = str_replace('<div class="civico"></div>', '<div class="civico">'.$casa["civico"].'</div>',$temp);
$temp = str_replace('<div class="citta"></div>', '<div class="citta">'.$casa["citta"].'</div>',$temp);
$temp = str_replace('<div class="provincia"></div>', '<div class="provincia">'.$casa["provincia"].'</div>',$temp);
$temp = str_replace('<div class="prezzo"></div>', '<div class="prezzo">'.$casa["prezzo"].'</div>',$temp);
$temp = str_replace('<div class="camere"></div>', '<div class="camere">'.$casa["camere"].'</div>',$temp);
$temp = str_replace('<div class="superficie"></div>', '<div class="superficie">'. $casa["superficie"] . '</div>',$temp);
$temp = str_replace('<div class="bagni"></div>', '<div class="bagni">'.$casa["bagni"].'</div>',$temp);
$temp = str_replace('<div class="descrizione"></div>', '<div class="descrizione">'.$casa["descrizione"].'</div>',$temp);
$temp = str_replace('<a href="" class="link">', '<a href="dettagli.php?id_casa='.$casa["id_casa"].'" class="link">',$temp);

if(isset($_SESSION['username'])){
      $preferito = $connect->db_getArray(getPreferitiByMoreField(array("id_casa","username"), array($_GET["id_casa"],$_SESSION['username'])));

      if(isset($preferito)){
            $temp = str_replace('<a class="preferito"></a>', '<a class="preferito true" href="toggle_preferito.php?id_casa='.$_GET["id_casa"].'&username='.$_SESSION['username'].'&preferito=rimuovi">Rimuovi Preferito</a>',$temp);
      }
      else{
            $temp = str_replace('<a class="preferito"></a>', '<a class="preferito true" href="toggle_preferito.php?id_casa='.$_GET["id_casa"].'&username='.$_SESSION['username'].'&preferito=aggiungi">Aggiungi Preferito</a>',$temp);
      }

      if($_SESSION['isAdmin'] == 1){
            $temp .= '<a href="rimuovi_casa.php?id_casa='. $_GET["id_casa"].'">Rimuovi</a> ';
            $temp .= '<a href="modifica_casa.php?id_casa='. $_GET["id_casa"].'">Modifica</a>';
      }
}
$output = str_replace('<div class="casa"></div>',$temp,$output);

echo($output);
$connect->closeConnection()
?>