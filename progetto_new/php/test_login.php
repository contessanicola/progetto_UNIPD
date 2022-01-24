<?php
require_once("functions/db.php");

$testObject = new DBAccess();
session_start();
$_SESSION['username'] = "Nicola";
echo($_SESSION['id']);

$testObject->closeConnection();
?>