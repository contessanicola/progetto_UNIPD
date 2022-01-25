<?php
require_once "functions/login.php";
require_once "functions/db.php";
session_start();
$connect = new DBAccess();

$connect->openDBConnection();

$loginQuery = $connect->db_getArray(getLoginByField("username", $_POST['username']));

if($_POST['password'] == $loginQuery[0]["password"]){
    $_SESSION['username'] = $_POST['username'];
    if($loginQuery[0]["isAdmin"] == 1)
        $_SESSION['isAdmin'] = 1;
    echo("LOGIN");
}
else{
    echo("NO LOGIN");
}
$connect->closeConnection();
?>