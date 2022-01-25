<?php
require_once "functions/casa.php";
require_once "functions/db.php";

session_start();
$connect = new DBAccess();
$connect->openDBConnection();

if($_SESSION['isAdmin']){
      $query = $connect->db_insert(deleteCasaByField('id_casa', $_GET['id_casa']));
      header('Location: home.php');
}
else{
      header('Location: errore.php?errore=404+Page+Not+Found');
}

$connect->closeConnection();
?>