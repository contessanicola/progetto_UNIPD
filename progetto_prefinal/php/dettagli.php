<?php
namespace DB;
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";
require_once "model/casa.php";
require_once "model/preferiti.php";

$import = new \importModules();

$output = file_get_contents("../html/dettagli.html");


if(is_logged()){
      $output = $import->importEverythingOnline($output);
}
else{
      $output = $import->importEverythingOffline($output);
}

$connect = new DBAccess();

$connect->openDBConnection();

if(isset($_GET["id_casa"])){
      $casa = $connect->db_getArray(getCasaBy1Field("id_casa", $_GET["id_casa"]));

      if(!empty($casa)){
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

            if(isset($casa["parcheggio"])){
                  if($casa["parcheggio"] == "posto_auto")
                        $output = str_replace('<span class="parcheggio">', '<span class="parcheggio">Posto auto',$output);
                  else if($casa["parcheggio"] == "entrambi")
                        $output = str_replace('<span class="parcheggio">', '<span class="parcheggio">Posto auto e parcheggio',$output);
                  else if($casa["parcheggio"] == "garage")
                        $output = str_replace('<span class="parcheggio">', '<span class="parcheggio">Garage',$output);                  
            }
            else
                  $output = str_replace('<span class="parcheggio">', '<span class="parcheggio"> No',$output);

            if(isset($casa["giardino"])){
                  if($casa["giardino"] == "privato")
                        $output = str_replace('<span class="giardino">', '<span class="giardino">Giardino Privato',$output);
                  else if($casa["giardino"] == "comune")
                        $output = str_replace('<span class="giardino">', '<span class="giardino">Giardino Comune',$output);
            }

            if($casa["piscina"]){
                  $output = str_replace('<span class="piscina">', '<span class="giardino">Piscina',$output);
            }

            if($casa["patio"]){
                  $output = str_replace('<span class="patio">', '<span class="patio">Patio',$output);
            }

            if($casa["barbecue"]){
                  $output = str_replace('<span class="barbecue">', '<span class="barbecue">Barbecue',$output);
            }

            if($casa["angolo_bar"]){
                  $output = str_replace('<span class="angolo_bar">', '<span class="angolo_bar">Angolo Bar',$output);
            }

            if($casa["idromassaggio"]){
                  $output = str_replace('<span class="idromassaggio">', '<span class="idromassaggio">Idromassaggio',$output);
            }

            if($casa["terrazzo"]){
                  $output = str_replace('<span class="terrazzo">', '<span class="terrazzo">Terrazzo',$output);
            }

            if($casa["arredato"]){
                  $output = str_replace('<span class="arredato">', '<span class="arredato">Arredato',$output);
            }
            

            //INSERISCE ID CASA NEL FORM PER MANDARE UNA RICHIESTA
            $output = str_replace('<input type="hidden" value="" name="id_casa" />', '<input type="hidden" value="'.$casa["id_casa"].'" name="id_casa" />',$output);
            

            $json = file_get_contents('../media/immaginiCase/'.$casa["id_casa"].'/alt.json');
            $json_decoded = json_decode($json,true);

            $imgTemplate = '';
            $imgThumbTemplate = '';
            $index = 1;
            foreach($json_decoded as $file){
                  $imgTemplate .= '<img loading=lazy class="imgCasa" alt="" src="../media/immaginiCase/'.$casa["id_casa"].'/'.$file["nome"].'">';
                  $imgThumbTemplate .= '<div class="column"><img loading=lazy class="thumb cursor" src="../media/immaginiCase/'.$casa["id_casa"].'/'.$file["nome"].'" onclick="currentSlide('.$index.')" alt=""></div>';
                  $index = $index+1;
            }
            $output = str_replace('<img class="imgCasa" alt="" src="">', $imgTemplate ,$output);
            $output = str_replace('<div class="column"><img class="thumb cursor" src="" onclick="" alt=""></div>', $imgThumbTemplate ,$output);
            if(is_logged()){
                  $preferito = $connect->db_getArray(getPreferitiByMoreField(array("id_casa","username"), array($_GET["id_casa"],$_SESSION['user'])));
                  $richieste = $connect->db_getArray('SELECT * FROM richieste WHERE username LIKE "'.$_SESSION['user'].'" AND id_casa LIKE "'.$_GET["id_casa"].'"');
            
                  if(isset($richieste)){
                        $output = str_replace('<form id="contactForm" action="post_richiesta.php" method="post">','Richiesta in fase di elaborazione <a class="buttonSearch" href="area_riservata.php">Vai alla tua Area Privata</a> <form id="contactForm" action="aggiungi_richiesta.php" method="get" hidden>',$output);
                  }
                  if(isset($preferito)){
                        $rimuovi_preferito = file_get_contents("../html/modules/rimuovi_preferito.html");
                        $rimuovi_preferito = str_replace('value=""', 'value="'.$_GET["id_casa"].'"', $rimuovi_preferito);                        
                        $output = str_replace('<form action="post_preferito.php"></form>', $rimuovi_preferito, $output);
                  }
                  else{
                        $aggiungi_preferito = file_get_contents("../html/modules/aggiungi_preferito.html");
                        $aggiungi_preferito = str_replace('value=""', 'value="'.$_GET["id_casa"].'"', $aggiungi_preferito); 
                        $output = str_replace('<form action="post_preferito.php"></form>', $aggiungi_preferito, $output);
                  }

                  if(is_admin()){
                        
                        $opzioni = '<div id="optionsAnnounce" class="containerSpecsFull">';
                        $opzioni .= '<hr><h2>Opzioni Admin</h2><div id="opzioni_admin">';
                        $opzioni .= '<a class="buttonSearch" href="post_casa.php?submit=submit&azione=delete&id_casa='. $_GET["id_casa"].'">Rimuovi</a> ';
                        $opzioni .= '<a class="buttonSearch" href="modifica_casa.php?id_casa='. $_GET["id_casa"].'">Modifica</a>';
                        $opzioni .= '</div></div>';

                        $output = str_replace('<div id="optionsAnnounce" class="containerSpecsFull"></div>',$opzioni,$output);
                  }
                  else{
                        $output = str_replace('<div id="optionsAnnounce" class="containerSpecsFull"></div>',"",$output);
                  }
            }
      }
      else{
            header('Location: 404.php');
      }
}
else{
      header('Location: 404.php');
}


echo($output);
$connect->closeConnection()
?>