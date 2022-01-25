<?php
/*STRUTTURA TABELLA
CREATE TABLE `sopralluoghi` (
  `id_casa` int(50) NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orario` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


*/

$SopralluoghiFieldIsString=array();
$SopralluoghiFieldIsString['id_casa']=0;
$SopralluoghiFieldIsString['username']=1;
$SopralluoghiFieldIsString['orario']=1;


//RESTITUISCE LA QUERY PER L'LELENCO DI TUTTE LE RICHIESTE
function getAllSopralluoghi(){
	return "SELECT * FROM sopralluoghi";
}

//RESTITUISCE QUERY PER ELENCO DEI SOPRALLUOGHI CHE SODDISFANO IL FILTRO ($field e $value sono variabili string)
function getSopralluoghiByField($field, $value){
	global $SopralluoghiFieldIsString;
	$queryString="SELECT * FROM sopralluoghi WHERE ";
	if($SopralluoghiFieldIsString[$field])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="$field LIKE \"$value\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="$field LIKE $value";

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO IL CAMPO newFiled A newValue
function updateSopralluoghiByField($filterField, $filterValue, $newField, $newValue){
	global $SopralluoghiFieldIsString;
	$queryString="UPDATE sopralluoghi ";
	if($SopralluoghiFieldIsString[$newField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="SET $newField = \"$newValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="SET $newField = $newValue";
	
	if($SopralluoghiFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	return $queryString;
}

//ELIMINA I RECORD CON CAMPO filterField SETTATO A filterValue
function deleteSopralluoghiByField($filterField, $filterValue){
	global $SopralluoghiFieldIsString;
	$queryString="DELETE FROM sopralluoghi ";
	
	if($SopralluoghiFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	return $queryString;
}

//INSERISCE I RECORD CON I VALORI in $values
function insertSopralluoghi($values){
	global $SopralluoghiFieldIsString;
	$queryString="INSERT INTO sopralluoghi (id_casa, username, orario) VALUES( ";
	$queryString.=$values['id_casa'].", ";
	$queryString.="\"".$values['username']."\", ";
	$queryString.="\"".$values['orario']."\")";

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO I CAMPI newFiled[i] A newValue[i]
//$filterField e $filterValue sono string o int
//$newField e $newValue sono array
function updateSopralluoghiByMoreField($filterField, $filterValue, $newField, $newValue){
	global $SopralluoghiFieldIsString;
	$queryString="UPDATE sopralluoghi SET ";
	$count=count($newField);
	for($i=0; $i<$count;$i++)
	{
		if($SopralluoghiFieldIsString[$newField[$i]])
			//il campo è stringa, quindi devo aggiungere gli apici
			$queryString.="$newField[$i] = \"$newValue[$i]\" ";
		else
			//il campo è non stringa, quindi non devo aggiungere gli apici
			$queryString.="$newField[$i] = $newValue[$i] ";
		
		if($i!=$count-1)
				$queryString.=", ";
	}
	if($SopralluoghiFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	
	return $queryString;
}


//RESTITUISCE I RECORD CON I CAMPI filterField[i] SETTATI A filterValue[i]
//$filterField e $filterValue sono string o int
function getSopralluoghiByMoreField($filterField, $filterValue){
	global $SopralluoghiFieldIsString;
	$queryString="SELECT * FROM sopralluoghi WHERE ";
	$count=count($filterField);
	for($i=0; $i<$count;$i++)
	{
		if($SopralluoghiFieldIsString[$filterField[$i]])
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
