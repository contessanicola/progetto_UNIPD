<?php
$RichiesteFieldIsString=array();
$RichiesteFieldIsString['id_casa']=0;
$RichiesteFieldIsString['username']=1;
$RichiesteFieldIsString['richiesta']=1;
$RichiesteFieldIsString['orario']=1;


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

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO IL CAMPO newField A newValue
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
	$queryString="INSERT INTO richieste (id_casa, username, richiesta, orario) VALUES( ";
	$queryString.=$values['id_casa'].", ";
	$queryString.="\"".$values['username']."\", ";
	$queryString.="\"".$values['richiesta']."\", ";
	$queryString.="\"".$values['orario']."\")";

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO I CAMPI newFiled[i] A newValue[i]
//$filterField e $filterValue sono string o int
//$newField e $newValue sono array
function updateRichiesteByMoreField($filterField, $filterValue, $newField, $newValue){
	if (!empty($newField) && !empty($newValue))
	{
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
	return '';
}


//RESTITUISCE I RECORD CON I CAMPI filterField[i] SETTATI A filterValue[i]
//$filterField e $filterValue sono string o int
function getRichiesteByMoreField($filterField, $filterValue){
	if (!empty($filterField) && !empty($filterValue))
	{
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
	return '';
}


//RESTITUISCE I RECORD CON I CAMPI filterField[i] $filterLogic[i] filterValue[i], ordinati per $orderField[j] $orderDirection[j]
//i parametri in entrata sono tutti array
//$filterField e $filterValue sono string o int
//$filterLogic contiene operatore logico, ad esempio '<','>', '='
//$orderField contiene elenco dei campi per cui ordinare
//$orderDirection contiene direzione di ordinamento 'ASC' o 'DESC', per ciascun campo in $orderField
function getRichiesteByMoreRangeFieldOrder($filterField, $filterValue, $filterLogic, $orderField, $orderDirection){
	$queryString="SELECT * FROM richieste ";
	if (!empty($filterField) && !empty($filterValue) && !empty($filterLogic))
	{
		global $RichiesteFieldIsString;
		$queryString.=" WHERE ";
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($RichiesteFieldIsString[$filterField[$i]])
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
	unset($RichiesteFieldIsString);
	return $queryString;
}



//MODIFICA I RECORD CON CAMPO filterField[i] SETTATO A filterValue[i], SETTANDO I CAMPI newField[i] A newValue[i]
//$filterField e $filterValue sono array
//$newField e $newValue sono array
function updateRichiesteByMoreFilter($filterField, $filterValue, $newField, $newValue){
	if (!empty($newField) && !empty($newValue) && !empty($filterField) && !empty($filterValue))
	{
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
		$queryString.="WHERE ";
		
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($RichiesteFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\" )";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i] )";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($RichiesteFieldIsString);
		return $queryString;
	}
	return '';
}

//CANCELLA I RECORD CON $filterField[$i]=$filterValue[$i]
//$filterField[$i] e $filterValue[$i] sono array
function deleteRichiesteByMoreFilter($filterField, $filterValue){
	if (!empty($filterField) && !empty($filterValue))
	{
		global $RichiesteFieldIsString;
		$queryString="DELETE FROM richieste WHERE ";
		
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($RichiesteFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\" )";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i] )";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($RichiesteFieldIsString);
		return $queryString;
	}
	return '';
}

