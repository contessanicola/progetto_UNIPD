<?php
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

	unset($PreferitiFieldIsString);
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
	unset($PreferitiFieldIsString);
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
	
	unset($PreferitiFieldIsString);
	return $queryString;
}

//INSERISCE I RECORD CON I VALORI in $values
function insertPreferito($values){
	$queryString="INSERT INTO preferiti (id_casa, username) VALUES( ";
	$queryString.=$values['id_casa'].", ";
	$queryString.="\"".$values['username']."\") ";
	
	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO I CAMPI newField[i] A newValue[i]
//$filterField e $filterValue sono string o int
//$newField e $newValue sono array
function updatePreferitiByMoreField($filterField, $filterValue, $newField, $newValue){
	if (!empty($newField) && !empty($newValue))
	{
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
		unset($PreferitiFieldIsString);
		return $queryString;
	}
	return '';
}

//RESTITUISCE I RECORD CON I CAMPI filterField[i] SETTATI A filterValue[i]
//$filterField e $filterValue sono string o int
function getPreferitiByMoreField($filterField, $filterValue){
	if (!empty($filterField) && !empty($filterValue))
	{
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
		unset($PreferitiFieldIsString);
		return $queryString;
	}
	return '';
}

//RESTITUISCE I RECORD CON I CAMPI filterField[i] $filterLogic[i] filterValue[i], ordinati per $orderField[j] $orderDirection[j]
//i parametri in entrata sono tutti array
//$filterField e $filterValue sono string o int
//$filterLogic contiene operatore logico, ad esempio '<','>', '='
//$orderField contiene elenco dei campi per cui ordinare
//$orderDirection contiene direzione di ordinamento 'ASC' o 'DESC', per ciascun campo in $orderField
function getPreferitiByMoreRangeFieldOrder($filterField, $filterValue, $filterLogic, $orderField, $orderDirection){
	$queryString="SELECT * FROM preferiti ";
	if (!empty($filterField) && !empty($filterValue) && !empty($filterLogic))
	{
		global $CasaFieldIsString;
		$queryString.=" WHERE ";
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($CasaFieldIsString[$filterField[$i]])
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
	unset($PreferitiFieldIsString);
	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField[i] SETTATO A filterValue[i], SETTANDO I CAMPI newField[i] A newValue[i]
//$filterField e $filterValue sono array
//$newField e $newValue sono array
function updatePreferitiByMoreFilter($filterField, $filterValue, $newField, $newValue){
	if (!empty($newField) && !empty($newValue) && !empty($filterField) && !empty($filterValue))
	{
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
		$queryString.="WHERE ";
		
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($PreferitiFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\" )";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i] )";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($PreferitiFieldIsString);
		return $queryString;
	}
	return '';
}

//CANCELLA I RECORD CON $filterField[$i]=$filterValue[$i]
//$filterField[$i] e $filterValue[$i] sono array
function deletePreferitiByMoreFilter($filterField, $filterValue){
	if (!empty($filterField) && !empty($filterValue))
	{
		global $PreferitiFieldIsString;
		$queryString="DELETE FROM preferiti WHERE ";
		
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($PreferitiFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\" )";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i] )";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($PreferitiFieldIsString);
		return $queryString;
	}
	return '';
}

