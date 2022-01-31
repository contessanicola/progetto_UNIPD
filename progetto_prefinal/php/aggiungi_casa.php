<?php
namespace DB;
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";
require_once "functions/importModules.php";
require_once "model/casa.php";
$output = file_get_contents("../html/aggiungi_casa.html");

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

      /*$casa = $connect->db_getArray(getCasaBy1Field("id_casa", $_GET["id_casa"]));
      if(empty($casa)){
            header('Location: 404.php');
      }*/
            
      $result = $connect->db_getResult("SHOW TABLE STATUS LIKE 'casa'");
      $data = mysqli_fetch_assoc($result);

      $next_increment = $data['Auto_increment'];

      $casa = $next_increment;
      $output = str_replace('placeholder="id_casa', 'placeholder="' . $next_increment, $output); 
      $output = str_replace('name="id_casa" value="', 'name="id_casa" value="' . $next_increment, $output);      
}
else{
      header("location: errore.php?errore=Permessi+Non+Sufficienti");
}


   


echo($output);
?>