<?php
/*STRUTTURA TABELLA
CREATE TABLE `login` (
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cognome` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_telefono` int(10) UNSIGNED DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL
*/

$LoginFieldIsString=array();
$LoginFieldIsString['username']=1;
$LoginFieldIsString['password']=1;
$LoginFieldIsString['nome']=1;
$LoginFieldIsString['cognome']=1;
$LoginFieldIsString['mail']=1;
$LoginFieldIsString['numero_telefono']=0;
$LoginFieldIsString['isAdmin']=0;

//RESTITUISCE LA QUERY PER L'LELENCO DI TUTTI I LOGIN
function getAllLogin(){
	return "SELECT * FROM login";
}

//RESTITUISCE QUERY PER ELENCO DEI LOGIN CHE SODDISFANO IL FILTRO ($field e $value sono variabili string)
function getLoginByField($field, $value){
	global $LoginFieldIsString;
	$queryString="SELECT * FROM login WHERE ";
	if($LoginFieldIsString[$field])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="$field LIKE \"$value\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="$field LIKE $value";

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO IL CAMPO newFiled A newValue
function updateLoginByField($filterField, $filterValue, $newField, $newValue){
	global $LoginFieldIsString;
	$queryString="UPDATE login ";
	if($LoginFieldIsString[$newField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="SET $newField = \"$newValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="SET $newField = $newValue";
	
	if($LoginFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	return $queryString;
}

//ELIMINA I RECORD CON CAMPO filterField SETTATO A filterValue
function deleteLoginByField($filterField, $filterValue){
	global $LoginFieldIsString;
	$queryString="DELETE FROM login ";
	
	if($LoginFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	return $queryString;
}

//INSERISCE I RECORD CON I VALORI in $values
function insertLogin($values){
	global $LoginFieldIsString;
	$queryString="INSERT INTO login (username, password, nome, cognome, mail, numero_telefono, isAdmin) VALUES( ";
	$queryString.="\"".$values['username']."\", ";
	$queryString.="\"".$values['password']."\", ";
	$queryString.="\"".$values['nome']."\", ";
	$queryString.="\"".$values['cognome']."\", ";
	$queryString.="\"".$values['mail']."\", ";
	$queryString.=$values['numero_telefono'].", ";
	$queryString.=$values['isAdmin'].")";
	
	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO I CAMPI newFiled[i] A newValue[i]
//$filterField e $filterValue sono string o int
//$newField e $newValue sono array
function updateLoginByMoreField($filterField, $filterValue, $newField, $newValue){
	global $LoginFieldIsString;
	$queryString="UPDATE login SET ";
	$count=count($newField);
	for($i=0; $i<$count;$i++)
	{
		if($LoginFieldIsString[$newField[$i]])
			//il campo è stringa, quindi devo aggiungere gli apici
			$queryString.="$newField[$i] = \"$newValue[$i]\" ";
		else
			//il campo è non stringa, quindi non devo aggiungere gli apici
			$queryString.="$newField[$i] = $newValue[$i] ";
		
		if($i!=$count-1)
				$queryString.=", ";
	}
	if($LoginFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	
	return $queryString;
}

//RESTITUISCE I RECORD CON I CAMPI filterField[i] SETTATI A filterValue[i]
//$filterField e $filterValue sono string o int
function getLoginByMoreField($filterField, $filterValue){
	global $LoginFieldIsString;
	$queryString="SELECT * FROM login WHERE ";
	$count=count($filterField);
	for($i=0; $i<$count;$i++)
	{
		if($LoginFieldIsString[$filterField[$i]])
			//il campo è stringa, quindi devo aggiungere gli apici
			$queryString.="($filterField[$i] = \"$filterValue[$i]\") ";
		else
			//il campo è non stringa, quindi non devo aggiungere gli apici
			$queryString.="($filterField[$i] = $filterValue[$i]) ";
		
		if($i!=$count-1)
				$queryString.=" AND ";
	}
	return $queryString;
}