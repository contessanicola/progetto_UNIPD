<?php
require_once "functions/casa.php";
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";
require_once "functions/importModules.php";

$output = file_get_contents("../html/login.html");

$import = new \importModules();

if(is_logged()){
      $output = $import->importEverythingOnline($output);
      if($_SESSION['isAdmin']){
            $query = $connect->db_insert(deleteCasaByField('id_casa', $_GET['id_casa']));
            header('Location: home.php');
      }
      else{
            header('Location: errore.php?errore=Non+Hai+Le+Credenziali+Adatte');
      }
}
else{
      $output = $import->importEverythingOffline($output);
}




$connect->closeConnection();
?>