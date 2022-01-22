<?php
require_once "functions/login.php";
require_once "functions/db.php";
session_start();
$connect = new DBAccess();
$connect->openDBConnection();

$array = array('username' => $_POST['username'],
                'password' => $_POST['password'],
                'nome' => $_POST['nome'],
                'cognome' => $_POST['cognome'],
                'mail' => $_POST['email'],
                'numero_telefono' => $_POST['numero_telefono'],
                'isAdmin' => 0);


$checkUsername = $connect->db_getBool(getLoginByField("username",$_POST['username']));   

if($checkUsername){
    echo("duplicato");
}
else{
    $signUpQuery = $connect->db_insert(insertLogin($array));
    $_SESSION['username'] = $_POST['username'];
}


$connect->closeConnection();
/*
if($_POST['password'] == $loginQuery[0]["password"]){
    $_SESSION['username'] = $_POST['username'];
    echo("LOGIN");
}
else{
    echo("NO LOGIN");
}*/

?>