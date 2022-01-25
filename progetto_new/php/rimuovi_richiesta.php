<?php
require_once "functions/richieste.php";
require_once "functions/db.php";

session_start();
$connect = new DBAccess();
$connect->openDBConnection();

if(isset($_SESSION["isAdmin"]) || $_SESSION["username"] == $_GET["username"]){
      $query = $connect->db_insert(deleteRichiesteByMoreField(array("id_casa","username"), array($_GET['id_casa'],$_GET['username'])));
      header("location: area_riservata.php?");
}
else{
      header('Location: errore.php?errore=404+Page+Not+Found');
}

$connect->closeConnection();
?>