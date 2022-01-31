<?php
namespace DB;
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";

do_Logout();


ob_start();
header('Location: home.php');
ob_end_flush();
die();

?>