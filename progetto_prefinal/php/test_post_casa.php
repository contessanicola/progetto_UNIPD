<?php 
namespace DB;
require_once "model/db.php";
require_once "model/casa.php";
require_once "model/login.php";
require_once "functions/lib_sessioni.php";
require_once "functions/lib_validazione_input.php";

if (isset($_FILES['immagini'])) {
	$uploaddirroot = '../media/immaginiCase/';
	$id_casa = $_POST['id_casa'].'/';
	mkdir($uploaddirroot.$id_casa);

	$arr = array();

	$index_letter = 'a';
	foreach($_FILES['immagini']["tmp_name"] as $immagine){
		$uploadfile = $uploaddirroot.$id_casa . basename($_POST['id_casa'].$index_letter.'.jpeg');
		if (move_uploaded_file($immagine, $uploadfile)) {
			echo ("DONE");
			$arr[] = array("nome" => $_POST['id_casa'].$index_letter.'.jpeg',"alt" => "");
		}	
		else{
			echo ("NOT DONE");
		}
		$index_letter++;
	}

	echo json_encode($arr);
	$fp = fopen($uploaddirroot.$id_casa .'alt.json', 'w');
	fwrite($fp, json_encode($arr));
	fclose($fp);
}

?>