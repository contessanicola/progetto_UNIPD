<?php
require_once "functions/richieste.php";
require_once "functions/db.php";


session_start();
$connect = new DBAccess();

$connect->openDBConnection();

echo($_SESSION["username"]);
if(isset($_SESSION["username"])){
      $query = $connect->db_insert(insertRichiesta(array('id_casa' => $_GET["id_casa"], 'username' => $_SESSION["username"], 'richiesta' => $_GET['text'], 'orario' => $_GET['orario'])));
      header("location: dettagli.php?id_casa=".$_GET['id_casa']);
}

else
      header("location: errore.php?errore=Devi+aver+fatto+accesso+per+utilizzare+questa+funzionalità ");
/*if(($_GET['username'] == $_SESSION['username'] || isset($_SESSION["isAdmin"]))){
      $query = $connect->db_insert(deletePreferitiByMoreField(array("id_casa","username"), array($_GET['id_casa'],$_GET['username'])));
}
else{
      $query = $connect->db_insert(insertPreferito(array("id_casa" => $_GET['id_casa'] ,"username" => $_GET['username'] ))); 
}*/

//

$connect->closeConnection();
?>