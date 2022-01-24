<?php
/*STRUTTURA TABELLA
CREATE TABLE `richieste` (
  `id_casa` int(50) NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `richiesta` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

*/

$RichiesteFieldIsString=array();
$RichiesteFieldIsString['id_casa']=0;
$RichiesteFieldIsString['username']=1;
$RichiesteFieldIsString['richiesta']=1;


//RESTITUISCE LA QUERY PER L'LELENCO DI TUTTE LE RICHIESTE
function getAllRichieste(){
	return "SELECT * FROM richieste";
}

//RESTITUISCE QUERY PER ELENCO DELLE RICHIESTE CHE SODDISFANO IL FILTRO ($field e $value sono variabili string)
function getRichiesteByField($field, $value){
	global $RichiesteFieldIsString;
	$queryString="SELECT * FROM richieste WHERE ";
	if($RichiesteFieldIsString[$field])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="$field LIKE \"$value\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="$field LIKE $value";

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO IL CAMPO newFiled A newValue
function updateRichiesteByField($filterField, $filterValue, $newField, $newValue){
	global $RichiesteFieldIsString;
	$queryString="UPDATE richieste ";
	if($RichiesteFieldIsString[$newField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="SET $newField = \"$newValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="SET $newField = $newValue";
	
	if($RichiesteFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	return $queryString;
}

//ELIMINA I RECORD CON CAMPO filterField SETTATO A filterValue
function deleteRichiesteByField($filterField, $filterValue){
	global $RichiesteFieldIsString;
	$queryString="DELETE FROM richieste ";
	
	if($RichiesteFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	return $queryString;
}

//INSERISCE I RECORD CON I VALORI in $values
function insertRichiesta($values){
	global $RichiesteFieldIsString;
	$queryString="INSERT INTO richieste (id_casa, username, richiesta) VALUES( ";
	$queryString.=$values['id_casa'].", ";
	$queryString.="\"".$values['username']."\", ";
	$queryString.="\"".$values['richiesta']."\")";

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO I CAMPI newFiled[i] A newValue[i]
//$filterField e $filterValue sono string o int
//$newField e $newValue sono array
function updateRichiesteByMoreField($filterField, $filterValue, $newField, $newValue){
	global $RichiesteFieldIsString;
	$queryString="UPDATE richieste SET ";
	$count=count($newField);
	for($i=0; $i<$count;$i++)
	{
		if($RichiesteFieldIsString[$newField[$i]])
			//il campo è stringa, quindi devo aggiungere gli apici
			$queryString.="$newField[$i] = \"$newValue[$i]\" ";
		else
			//il campo è non stringa, quindi non devo aggiungere gli apici
			$queryString.="$newField[$i] = $newValue[$i] ";
		
		if($i!=$count-1)
				$queryString.=", ";
	}
	if($RichiesteFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	
	return $queryString;
}


//RESTITUISCE I RECORD CON I CAMPI filterField[i] SETTATI A filterValue[i]
//$filterField e $filterValue sono string o int
function getRichiesteByMoreField($filterField, $filterValue){
	global $RichiesteFieldIsString;
	$queryString="SELECT * FROM richieste WHERE ";
	$count=count($filterField);
	for($i=0; $i<$count;$i++)
	{
		if($RichiesteFieldIsString[$filterField[$i]])
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
