<?php
require_once "functions/importModules.php";
require_once "functions/db.php";
require_once "functions/casa.php";

session_start();

$output = file_get_contents("../html/catalogo.html");
$caseperpagine = 10;

if(isset($_SESSION['username'])){
      $output = importModules::importEverythingOnline($output);
}
else{
      $output = importModules::importEverythingOffline($output);
}

$connect = new DBAccess();

$connect->openDBConnection();
if(!isset($_GET["submit"])){ 
      $catalogo = $connect->db_getArray(getAllCasa());
}
else{
      $filterField = [];
      $filterValue = [];
      foreach($_GET as $key => $value){
            if($key == "id_casa" || $key == "regione" || $key == "provincia" || $key == "citta" || $key == "tipologia" || $key == "camere" 
                  || $key == "bagni" || $key == "parcheggio" || $key == "giardino"){
                  $filterField[] = $key;
                  $filterValue[] = $value;
            }
      }
      $catalogo = $connect->db_getArray(getCasaByMoreField($filterField, $filterValue)); 
}

$template_casa = file_get_contents("../html/modules/casa.html");
$temp = "";



if(!isset($_GET["page"])){
      $_GET["page"] = 1;  
}
$row = 0;
if(!empty($catalogo)){
      $row = count($catalogo);
      $catalogo = array_slice($catalogo, 0 + ($_GET["page"] - 1) * $caseperpagine, $caseperpagine + ($_GET["page"] - 1) * $caseperpagine);
}
if($_GET["page"]>1){
      $previous = '<a href=catalogo.php?'. http_build_query(array_merge($_GET, array('page' => ($_GET["page"]-1)))) .'>Previous</a> ';
}
$next = '<a href=catalogo.php?'. http_build_query(array_merge($_GET, array('page' => ($_GET["page"]+1)))) .'>Next</a>';

if(!empty($catalogo)){
      foreach($catalogo as $casa){
            $temp .= $template_casa;
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
            $temp = str_replace('<img src="../media/immaginiCase/1/1a.jpeg" class="img_casa">', '<img src="../media/immaginiCase/'.$casa["id_casa"].'/'.$casa["id_casa"].'a.jpeg" class="img_casa">',$temp);
      }
}
if(isset($previous))
      $temp .= $previous;

if($row - ($caseperpagine * $_GET["page"]) > 0)
      $temp .= $next;

$output = str_replace('<div class="casa"></div>',$temp,$output);

echo($output);
?>