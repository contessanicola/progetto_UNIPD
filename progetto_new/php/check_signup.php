<?php
require_once "functions/login.php";
require_once "functions/db.php";
session_start();

$REGEX_USERNAME = "/^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
$REGEX_PASSWORD = "/^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
$REGEX_NOME_COGNOME = "/^[a-zA-Z]{3,30}$/";
$REGEX_EMAIL = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";
$REGEX_TELEFONO = "/^[0-9]{10}$/";

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

if($checkUsername || !preg_match($REGEX_USERNAME,$_POST['username']) || !preg_match($REGEX_PASSWORD,$_POST['password']) || !preg_match($REGEX_NOME_COGNOME,$_POST['nome']) ||
!preg_match($REGEX_NOME_COGNOME,$_POST['cognome']) || !preg_match($REGEX_EMAIL,$_POST['email']) || !preg_match($REGEX_TELEFONO,$_POST['numero_telefono'])){
    echo("ERRORE");
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