<?php
$SessioniFieldIsString=array();
$SessioniFieldIsString['id_sessione']=1;
$SessioniFieldIsString['user']=1;
$SessioniFieldIsString['nome']=1;
$SessioniFieldIsString['cognome']=1;
$SessioniFieldIsString['ultima_attivita']=1;
$SessioniFieldIsString['logged']=0;


//RESTITUISCE LA QUERY PER L'LELENCO DI TUTTE LE SESSIONI
function getAllSessioni(){
	return "SELECT * FROM sessioni";
}

//RESTITUISCE QUERY PER ELENCO DEI LOGIN CHE SODDISFANO IL FILTRO ($field e $value sono variabili string)
function getSessioniByField($field, $value){
	global $SessioniFieldIsString;
	$queryString="SELECT * FROM sessioni WHERE ";
	if($SessioniFieldIsString[$field])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="$field LIKE \"$value\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="$field LIKE $value";

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO IL CAMPO newField A newValue
function updateSessioniByField($filterField, $filterValue, $newField, $newValue){
	global $SessioniFieldIsString;
	$queryString="UPDATE sessioni ";
	if($SessioniFieldIsString[$newField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="SET $newField = \"$newValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="SET $newField = $newValue";
	
	if($SessioniFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	return $queryString;
}

//ELIMINA I RECORD CON CAMPO filterField SETTATO A filterValue
function deleteSessioniByField($filterField, $filterValue){
	global $SessioniFieldIsString;
	$queryString="DELETE FROM sessioni ";
	
	if($SessioniFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	return $queryString;
}

//INSERISCE I RECORD CON I VALORI in $values
function insertSessioni($values){
	global $SessioniFieldIsString;
	$queryString="INSERT INTO sessioni (id_sessione, user, nome, cognome, ultima_attivita, logged) VALUES( ";
	$queryString.="\"".$values['id_sessione']."\", ";
	$queryString.="\"".$values['user']."\", ";
	$queryString.="\"".$values['nome']."\", ";
	$queryString.="\"".$values['cognome']."\", ";
	$queryString.="\"".$values['ultima_attivita']."\", ";
	$queryString.=$values['logged'].") ";

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO I CAMPI newFiled[i] A newValue[i]
//$filterField e $filterValue sono string o int
//$newField e $newValue sono array
function updateSessioniByMoreField($filterField, $filterValue, $newField, $newValue){
	if (!empty($newField) && !empty($newValue))
	{
		global $SessioniFieldIsString;
		$queryString="UPDATE sessioni SET ";
		$count=count($newField);
		for($i=0; $i<$count;$i++)
		{
			if($SessioniFieldIsString[$newField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="$newField[$i] = \"$newValue[$i]\" ";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="$newField[$i] = $newValue[$i] ";
			
			if($i!=$count-1)
					$queryString.=", ";
		}
		if($SessioniFieldIsString[$filterField])
			//il campo è stringa, quindi devo aggiungere gli apici
			$queryString.="WHERE $filterField = \"$filterValue\"";
		else
			//il campo è non stringa, quindi non devo aggiungere gli apici
			$queryString.="WHERE $filterField = $filterValue";
		
		return $queryString;
	}
	return '';
}

//RESTITUISCE I RECORD CON I CAMPI filterField[i] SETTATI A filterValue[i]
//$filterField e $filterValue sono string o int
function getSessioniByMoreField($filterField, $filterValue){
	if (!empty($filterField) && !empty($filterValue))
	{
		global $SessioniFieldIsString;
		$queryString="SELECT * FROM sessioni WHERE ";
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($SessioniFieldIsString[$filterField[$i]])
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
}

//RESTITUISCE I RECORD CON I CAMPI filterField[i] $filterLogic[i] filterValue[i], ordinati per $orderField[j] $orderDirection[j]
//i parametri in entrata sono tutti array
//$filterField e $filterValue sono string o int
//$filterLogic contiene operatore logico, ad esempio '<','>', '='
//$orderField contiene elenco dei campi per cui ordinare
//$orderDirection contiene direzione di ordinamento 'ASC' o 'DESC', per ciascun campo in $orderField
function getSessioniByMoreRangeFieldOrder($filterField, $filterValue, $filterLogic, $orderField, $orderDirection){
	$queryString="SELECT * FROM sessioni ";
	if (!empty($filterField) && !empty($filterValue) && !empty($filterLogic))
	{
		global $SessioniFieldIsString;
		$queryString.=" WHERE ";
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($SessioniFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] $filterLogic[$i] \"$filterValue[$i]\") ";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] $filterLogic[$i] $filterValue[$i]) ";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
	}
	if (!empty($orderField) && !empty($orderDirection))
	{
		$count=count($orderField);
		$queryString.=" ORDER BY ";
		for($i=0; $i<$count;$i++)
		{
			$queryString.="$orderField[$i] $orderDirection[$i] ";
			
			if($i!=$count-1)
					$queryString.=" , ";
		}
	}
	unset($count);
	return $queryString;
}



//MODIFICA I RECORD CON CAMPO filterField[i] SETTATO A filterValue[i], SETTANDO I CAMPI newField[i] A newValue[i]
//$filterField e $filterValue sono array
//$newField e $newValue sono array
function updateSessioniByMoreFilter($filterField, $filterValue, $newField, $newValue){
	if (!empty($newField) && !empty($newValue) && !empty($filterField) && !empty($filterValue))
	{
		global $SessioniFieldIsString;
		$queryString="UPDATE sessioni SET ";
		$count=count($newField);
		for($i=0; $i<$count;$i++)
		{
			if($SessioniFieldIsString[$newField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="$newField[$i] = \"$newValue[$i]\" ";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="$newField[$i] = $newValue[$i] ";
			
			if($i!=$count-1)
					$queryString.=", ";
		}
		$queryString.="WHERE ";
		
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($SessioniFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\" )";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i] )";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($SessioniFieldIsString);
		return $queryString;
	}
	return '';
}

//CANCELLA I RECORD CON $filterField[$i]=$filterValue[$i]
//$filterField[$i] e $filterValue[$i] sono array
function deleteSessioniByMoreFilter($filterField, $filterValue){
	if (!empty($filterField) && !empty($filterValue))
	{
		global $SessioniFieldIsString;
		$queryString="DELETE FROM sessioni WHERE ";
		
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($SessioniFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\" )";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i] )";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($SessioniFieldIsString);
		return $queryString;
	}
	return '';
}

