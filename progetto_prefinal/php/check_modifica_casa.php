<?php
require_once "functions/casa.php";
require_once "functions/db.php";

session_start();
$connect = new DBAccess();
$connect->openDBConnection();

if(isset($_SESSION["isAdmin"])){
      echo(var_dump($_GET));

      $filterField = [];
      $filterValue = [];
      foreach($_GET as $key => $value){
            if(($key == "id_casa" || $key == "regione" || $key == "provincia" || $key == "citta" || $key == "via" || $key == "civico" || $key == "tipologia" || $key == "citta" 
                  || $key == "superficie" || $key == "camere" || $key == "bagni" || $key == "parcheggio" || $key == "giardino" || $key == "piscina" || $key == "patio"
                  || $key == "barbecue" || $key == "angolo_bar" || $key == "idromassaggio" || $key == "terrazzo" || $key == "arredato" || $key == "prezzo" || $key == "descrizione")
                  && $value != ""){
                  $filterField[] = $key;
                  $filterValue[] = $value;
            }
      }
      echo(updateCasaByMoreField("id_casa",$_GET["id_casa"],$filterField, $filterValue));
      $catalogo = $connect->db_getArray(); 
}
else{
      echo($_SESSION["isAdmin"]);
}

$connect->closeConnection();
?>