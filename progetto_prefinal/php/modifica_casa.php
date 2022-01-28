<?php
namespace DB;
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";
require_once "functions/importModules.php";
require_once "model/casa.php";

$output = file_get_contents("../html/modifica_casa.html");

$import = new \importModules();

if(is_logged()){
      $output = $import->importEverythingOnline($output);
}
else{
      $output = $import->importEverythingOffline($output);
}

$connect = new DBAccess();
$connect->openDBConnection();


if(is_admin()){
      $casa = $connect->db_getArray(getCasaBy1Field("id_casa", $_GET["id_casa"]));
      if(empty($casa)){
            header('Location: 404.php');
      }
            


      $casa = $casa[0];
      $output = str_replace('placeholder="id_casa', 'placeholder="' . $casa["id_casa"], $output); 
      $output = str_replace('name="id_casa" value="', 'name="id_casa" value="' . $casa["id_casa"], $output);

      $output = str_replace('placeholder="regione', 'placeholder="' . $casa["regione"], $output);
      $output = str_replace('name="regione" value="', 'name="regione" value="' . $casa["regione"], $output);

      $output = str_replace('placeholder="provincia', 'placeholder="' . $casa["provincia"], $output);
      $output = str_replace('name="provincia" value="', 'name="provincia" value="' . $casa["provincia"], $output);

      $output = str_replace('placeholder="citta', 'placeholder="' . $casa["citta"], $output);
      $output = str_replace('name="citta" value="', 'name="citta" value="' . $casa["citta"], $output);
      
      $output = str_replace('placeholder="via', 'placeholder="' . $casa["via"], $output);
      $output = str_replace('name="via" value="', 'name="via" value="' . $casa["via"], $output);

      $output = str_replace('placeholder="civico', 'placeholder="' . $casa["civico"], $output);
      $output = str_replace('name="civico" value="', 'name="civico" value="' . $casa["civico"], $output);

      $output = str_replace('placeholder="tipologia', 'placeholder="' . $casa["tipologia"], $output);
      $output = str_replace('name="tipologia" value="', 'name="tipologia" value="' . $casa["tipologia"], $output);

      $output = str_replace('placeholder="superficie', 'placeholder="' . $casa["superficie"], $output);
      $output = str_replace('name="superficie" value="', 'name="superficie" value="' . $casa["superficie"], $output);

      $output = str_replace('placeholder="camere', 'placeholder="' . $casa["camere"], $output);
      $output = str_replace('name="camere" value="', 'name="camere" value="' . $casa["camere"], $output);

      $output = str_replace('placeholder="bagni', 'placeholder="' . $casa["bagni"], $output);
      $output = str_replace('name="bagni" value="', 'name="bagni" value="' . $casa["bagni"], $output);

      $output = str_replace('placeholder="parcheggio', 'placeholder="' . $casa["parcheggio"], $output);
      $output = str_replace('name="parcheggio" value="', 'name="parcheggio" value="' . $casa["parcheggio"], $output);

      $output = str_replace('placeholder="giardino', 'placeholder="' . $casa["giardino"], $output);
      $output = str_replace('name="giardino" value="', 'name="giardino" value="' . $casa["giardino"], $output);

      if($casa["piscina"])
            $output = str_replace('name="piscina"', 'name="piscina" checked', $output);

      if($casa["barbecue"])
            $output = str_replace('name="barbecue"', 'name="barbecue" checked', $output);

      if($casa["patio"])
            $output = str_replace('name="patio"', 'name="patio" checked', $output);

      if($casa["angolo_bar"])
            $output = str_replace('name="angolo_bar"', 'name="angolo_bar" checked', $output);

      if($casa["idromassaggio"])
            $output = str_replace('name="idromassaggio"', 'name="idromassaggio" checked', $output);

      if($casa["terrazzo"])
            $output = str_replace('name="terrazzo"', 'name="terrazzo" checked', $output);

      if($casa["arredato"])
            $output = str_replace('name="arredato"', 'name="arredato" checked', $output);

      $output = str_replace('placeholder="prezzo', 'placeholder="' . $casa["prezzo"], $output);
      $output = str_replace('name="prezzo" value="', 'name="prezzo" value="' . $casa["prezzo"], $output);

      $output = str_replace('placeholder="descrizione', 'placeholder="' . $casa["descrizione"], $output);
      $output = str_replace('name="descrizione" >', 'name="descrizione" >' . $casa["descrizione"], $output);
}
else{
      header("location: errore.php?errore=Permessi+Non+Sufficienti");
}


   


echo($output);
?>