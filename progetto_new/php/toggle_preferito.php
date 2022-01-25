<?php
require_once "functions/preferiti.php";
require_once "functions/db.php";


session_start();
$connect = new DBAccess();

$connect->openDBConnection();


if($_GET['preferito'] == "rimuovi" && ($_GET['username'] == $_SESSION['username'] || isset($_SESSION["isAdmin"]))){
      $query = $connect->db_insert(deletePreferitiByMoreField(array("id_casa","username"), array($_GET['id_casa'],$_GET['username'])));
}
else{
      $query = $connect->db_insert(insertPreferito(array("id_casa" => $_GET['id_casa'] ,"username" => $_GET['username'] ))); 
}

header("location: dettagli.php?id_casa=".$_GET['id_casa']);

$connect->closeConnection();
?>