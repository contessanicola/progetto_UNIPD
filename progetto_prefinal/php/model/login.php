<?php
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
	unset($LoginFieldIsString);
	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO IL CAMPO newField A newValue
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
	unset($LoginFieldIsString);
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
	unset($LoginFieldIsString);
	return $queryString;
}

//INSERISCE I RECORD CON I VALORI in $values
function insertLogin($values){
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
	if (!empty($newField) && !empty($newValue))
	{
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
		
		unset($LoginFieldIsString);
		return $queryString;
	}
	return '';
}

//RESTITUISCE I RECORD CON I CAMPI filterField[i] SETTATI A filterValue[i]
//$filterField e $filterValue sono string o int
function getLoginByMoreField($filterField, $filterValue){
	if (!empty($filterField) && !empty($filterValue))
	{
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
		unset($LoginFieldIsString);
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
function getLoginByMoreRangeFieldOrder($filterField, $filterValue, $filterLogic, $orderField, $orderDirection){
	$queryString="SELECT * FROM login";
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
	unset($LoginFieldIsString);
	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField[i] SETTATO A filterValue[i], SETTANDO I CAMPI newField[i] A newValue[i]
//$filterField e $filterValue sono array
//$newField e $newValue sono array
function updateLoginByMoreFilter($filterField, $filterValue, $newField, $newValue){
	if (!empty($newField) && !empty($newValue) && !empty($filterField) && !empty($filterValue))
	{
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
		$queryString.="WHERE ";
		
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($LoginFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\" )";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i] )";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($LoginFieldIsString);
		return $queryString;
	}
	return '';
}

//CANCELLA I RECORD CON $filterField[$i]=$filterValue[$i]
//$filterField[$i] e $filterValue[$i] sono array
function deleteLoginByMoreFilter($filterField, $filterValue){
	if (!empty($filterField) && !empty($filterValue))
	{
		global $LoginFieldIsString;
		$queryString="DELETE FROM login WHERE ";
		
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($LoginFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\" )";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i] )";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($LoginFieldIsString);
		return $queryString;
	}
	return '';
}

