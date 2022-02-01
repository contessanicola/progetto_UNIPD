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
$output = str_replace('href="catalogo.php"','', $output);
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
                  || $key == "bagni" || $key == "parcheggio" || $key == "giardino" || $key == "superficie" || $key == "arredato" ||
                  $key == "terrazzo" || $key == "barbecue" || $key == "angolo_bar" || $key == "idromassaggio" || $key == "patio" ){

                  if($value != ""){
                        $filterField[] = $key;
                        $filterValue[] = $value;
            }
            }
      }
      $output_validazione_input = true;
      if(isset($_GET["parcheggio"]))
            $output = str_replace('value="'.$_GET['parcheggio'].'"','value="'.$_GET['parcheggio'].'"  selected', $output);

      if(isset($_GET["giardino"]))
            $output = str_replace('value="'.$_GET['giardino'].'"','value="'.$_GET['giardino'].'"  selected', $output);  
            
      if(isset($_GET["giardino"]))
            $output = str_replace('value="'.$_GET['giardino'].'"','value="'.$_GET['giardino'].'"  selected', $output); 

      if(isset($_GET["piscina"]))
            $output = str_replace('id="piscina"','id="piscina" checked', $output); 
      if(isset($_GET["idromassaggio"]))
            $output = str_replace('id="idromassaggio"','id="idromassaggio" checked', $output); 
      if(isset($_GET["patio"]))
            $output = str_replace('id="patio"','id="patio" checked', $output);  
      if(isset($_GET["barbecue"]))
            $output = str_replace('id="barbecue"','id="barbecue" checked', $output);  
      if(isset($_GET["angolo_bar"]))
            $output = str_replace('id="angolo_bar"','id="angolo_bar" checked', $output); 
      if(isset($_GET["terrazzo"]))
            $output = str_replace('id="terrazzo"','id="terrazzo" checked', $output); 
      if(isset($_GET["arredato"]))
            $output = str_replace('id="arredato"','id="arredato" checked', $output); 

      if(isset($_GET['tipologia'])){

            $output = str_replace('value="'.$_GET['tipologia'].'"','value="'.$_GET['tipologia'].'"  selected', $output);
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

            $output = str_replace('value="'.$_GET['regione'].'"','value="'.$_GET['regione'].'"  selected', $output);
            
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
            
            if(count($filterField)!=0){
                  $aggiunta = "";
                  if(isset($_GET["prezzoDa"]) && isset($_GET["prezzoA"]))
                        $aggiunta = ' AND (prezzo BETWEEN '.$_GET["prezzoDa"].' AND '.$_GET["prezzoA"].')';

                  $catalogo = $connect->db_getArray(getCasaByMoreField($filterField, $filterValue).$aggiunta); 
            }
            else{
                  if(isset($_GET["prezzoDa"]) && isset($_GET["prezzoA"])){
                        $catalogo = $connect->db_getArray('SELECT * FROM casa WHERE (prezzo BETWEEN '.$_GET["prezzoDa"].' AND '.$_GET["prezzoA"].')');
                  }
                  else
                        $catalogo = $connect->db_getArray(getAllCasa());
            }
            
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
      $catalogo = array_slice($catalogo, 0 + ($_GET["page"] - 1) * $caseperpagine, $caseperpagine);
}
if($_GET["page"]>1){
      $previous = '<a class="buttonSearch" href="catalogo.php?'. http_build_query(array_merge($_GET, array('page' => ($_GET["page"]-1)))) .'">Precedente</a> ';
}
$next = '<a class="buttonSearch" href="catalogo.php?'. http_build_query(array_merge($_GET, array('page' => ($_GET["page"]+1)))) .'">Successiva</a>';

if(!empty($catalogo)){
      foreach($catalogo as $casa){
            $temp .= $template_casa;
            if($casa["tipologia"] == "attività_commerciale"){
                  $temp = str_replace('<div class="tipologia"></div>', '<div class="tipologia">Attività Commerciale</div>' , $temp);
            }
            else{
                  $temp = str_replace('<div class="tipologia"></div>', '<div class="tipologia">' . $casa["tipologia"] . '</div>' , $temp);
            }
            
            $temp = str_replace('<div class="via"></div>', '<div class="via">'.$casa["via"].'</div>',$temp);
            $temp = str_replace('<div class="civico"></div>', '<div class="civico">'.$casa["civico"].'</div>',$temp);
            $temp = str_replace('<div class="citta"></div>', '<div class="citta">'.$casa["citta"].'</div>',$temp);
            $temp = str_replace('<div class="provincia"></div>', '<div class="provincia">'.$casa["provincia"].'</div>',$temp);

            if($casa["prezzo"] == 0){
                  $temp = str_replace('<div class="prezzo"></div>', '<div class="prezzo">Trattativa Riservata</div>',$temp);
            }            
            else
                  $temp = str_replace('<div class="prezzo"></div>', '<div class="prezzo">'.$casa["prezzo"].'</div>',$temp);

            $temp = str_replace('<div class="camere"></div>', '<div class="camere">'.$casa["camere"].'</div>',$temp);
            $temp = str_replace('<div class="superficie"></div>', '<div class="superficie">'. $casa["superficie"] . '</div>',$temp);
            $temp = str_replace('<div class="bagni"></div>', '<div class="bagni">'.$casa["bagni"].'</div>',$temp);
            $temp = str_replace('<div class="descrizione_casa"></div>', '<div class="descrizione_casa">'.$casa["descrizione"].'</div>',$temp);
            $temp = str_replace('<a href="" class="link_img">', '<a href="dettagli.php?id_casa='.$casa["id_casa"].'" class="link_img">',$temp);
            $temp = str_replace('<a href="" class="contentLinkButton">', '<a href="dettagli.php?id_casa='.$casa["id_casa"].'" class="contentLinkButton">',$temp);

            $json = file_get_contents('../media/immaginiCase/'.$casa["id_casa"].'/alt.json');
            $json_decoded = json_decode($json,true);
            $temp = str_replace('<img src="" class="img_casa" alt="">', '<img src="../media/immaginiCase/'.$casa["id_casa"].'/'.$casa["id_casa"].'a.jpeg" class="img_casa" alt="'.$json_decoded[0]["alt"].'">',$temp);
      }
}
if(isset($previous))
      $temp .= $previous;

if($row - ($caseperpagine * $_GET["page"]) > 0)
      $temp .= $next;

$output = str_replace('<div class="casa"></div>',$temp,$output);

echo($output);
?>
