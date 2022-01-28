<?php
namespace DB;
require_once "functions/importModules.php";
require_once "model/casa.php";
require_once "functions/lib_sessioni.php";
require_once "functions/lib_validazione_input.php";

$import = new \importModules();

$output = file_get_contents("../html/catalogo.html");
$caseperpagine = 10;

if(is_logged()){
      $output = $import->importEverythingOnline($output);
}
else{
      $output = $import->importEverythingOffline($output);
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
      $output_validazione_input = true;

      if(isset($_GET['tipologia'])){
            $tipologia=$_GET['tipologia'];           
            $controlli=array();
            $verifica=array();
            $campo='tipologia';
            array_push($controlli, 'LUNGHEZZA_MIN_MAX');
            array_push($controlli, 'NO_NUMERI');
            array_push($controlli, 'SQL_INJECTION');
            $controlli['param']['LUNGHEZZA_MIN']=0;
            $controlli['param']['LUNGHEZZA_MAX']=21;
            $verifica=str_replace('#PARAM', $campo, validazione_input($tipologia, $controlli));
            if($verifica[0] != "OK")
                  $output_validazione_input = false;

            unset($controlli);
            unset($verifica);
            unset($campo);
      }

      if(isset($_GET['regione'])){
            $regione=$_GET['regione'];
            $controlli=array();
            $verifica=array();
            $campo='regione';
            array_push($controlli, 'LUNGHEZZA_MIN_MAX');
            array_push($controlli, 'NO_NUMERI');
            array_push($controlli, 'SQL_INJECTION');
            $controlli['param']['LUNGHEZZA_MIN']=0;
            $controlli['param']['LUNGHEZZA_MAX']=20;
            $verifica=str_replace('#PARAM', $campo, validazione_input($regione, $controlli));
            if($verifica[0] != "OK")
                  $output_validazione_input = false;
            
            unset($controlli);
            unset($verifica);
            unset($campo);
      }
      if($output_validazione_input){            
            $catalogo = $connect->db_getArray(getCasaByMoreField($filterField, $filterValue)); 
      }
      else{
            header('Location: errore.php?errore=Valore+non+valido');     
      }
            
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
      $previous = '<a class="buttonSearch" href=catalogo.php?'. http_build_query(array_merge($_GET, array('page' => ($_GET["page"]-1)))) .'>Precedente</a> ';
}
$next = '<a class="buttonSearch" href=catalogo.php?'. http_build_query(array_merge($_GET, array('page' => ($_GET["page"]+1)))) .'>Successiva</a>';

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
            $temp = str_replace('<a href="" class="link_img">', '<a href="dettagli.php?id_casa='.$casa["id_casa"].'" class="link_img">',$temp);
            $temp = str_replace('<a href="" class="contentLinkButton">', '<a href="dettagli.php?id_casa='.$casa["id_casa"].'" class="contentLinkButton">',$temp);
            $temp = str_replace('<img src="" class="img_casa">', '<img src="../media/immaginiCase/'.$casa["id_casa"].'/'.$casa["id_casa"].'a.jpeg" class="img_casa">',$temp);
      }
}
if(isset($previous))
      $temp .= $previous;

if($row - ($caseperpagine * $_GET["page"]) > 0)
      $temp .= $next;

$output = str_replace('<div class="casa"></div>',$temp,$output);

echo($output);
?>