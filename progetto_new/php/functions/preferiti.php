<?php
/*STRUTTURA TABELLA
CREATE TABLE `preferiti` (
  `id_casa` int(50) NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preferito` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
*/

$PreferitiFieldIsString=array();
$PreferitiFieldIsString['id_casa']=0;
$PreferitiFieldIsString['username']=1;

//RESTITUISCE LA QUERY PER L'LELENCO DI TUTTI I PREFERITI
function getAllPreferiti(){
	return "SELECT * FROM preferiti";
}

//RESTITUISCE QUERY PER ELENCO DEI PREFERITI CHE SODDISFANO IL FILTRO ($field e $value sono variabili string)
function getPreferitiByField($field, $value){
	global $PreferitiFieldIsString;
	$queryString="SELECT * FROM preferiti WHERE ";
	if($PreferitiFieldIsString[$field])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="$field LIKE \"$value\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="$field LIKE $value";

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO IL CAMPO newFiled A newValue
function updatePreferitiByField($filterField, $filterValue, $newField, $newValue){
	global $PreferitiFieldIsString;
	$queryString="UPDATE preferiti ";
	if($PreferitiFieldIsString[$newField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="SET $newField = \"$newValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="SET $newField = $newValue";
	
	if($PreferitiFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	return $queryString;
}

//ELIMINA I RECORD CON CAMPO filterField SETTATO A filterValue
function deletePreferitiByField($filterField, $filterValue){
	global $PreferitiFieldIsString;
	$queryString="DELETE FROM preferiti ";
	
	if($PreferitiFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	
	return $queryString;
}

//INSERISCE I RECORD CON I VALORI in $values
function insertPreferito($values){
	global $LoginFieldIsString;
	$queryString="INSERT INTO preferiti (id_casa, username) VALUES( ";
	$queryString.=$values['id_casa'].", ";
	$queryString.="\"".$values['username'].'")';

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO I CAMPI newFiled[i] A newValue[i]
//$filterField e $filterValue sono string o int
//$newField e $newValue sono array
function updatePreferitiByMoreField($filterField, $filterValue, $newField, $newValue){
	global $PreferitiFieldIsString;
	$queryString="UPDATE preferiti SET ";
	$count=count($newField);
	for($i=0; $i<$count;$i++)
	{
		if($PreferitiFieldIsString[$newField[$i]])
			//il campo è stringa, quindi devo aggiungere gli apici
			$queryString.="$newField[$i] = \"$newValue[$i]\" ";
		else
			//il campo è non stringa, quindi non devo aggiungere gli apici
			$queryString.="$newField[$i] = $newValue[$i] ";
		
		if($i!=$count-1)
				$queryString.=", ";
	}
	if($PreferitiFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	
	return $queryString;
}

//RESTITUISCE I RECORD CON I CAMPI filterField[i] SETTATI A filterValue[i]
//$filterField e $filterValue sono string o int
function getPreferitiByMoreField($filterField, $filterValue){
	global $PreferitiFieldIsString;
	$queryString="SELECT * FROM preferiti WHERE ";
	$count=count($filterField);
	for($i=0; $i<$count;$i++)
	{
		if($PreferitiFieldIsString[$filterField[$i]])
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

function deletePreferitiByMoreField($filterField, $filterValue){
	global $PreferitiFieldIsString;
	$queryString="DELETE FROM preferiti WHERE ";
	$count=count($filterField);
	for($i=0; $i<$count;$i++)
	{
		if($PreferitiFieldIsString[$filterField[$i]])
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
