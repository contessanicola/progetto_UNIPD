<?php
$CasaFieldIsString=array();
$CasaFieldIsString['id_casa']=0;
$CasaFieldIsString['regione']=1;
$CasaFieldIsString['provincia']=1;
$CasaFieldIsString['citta']=1;
$CasaFieldIsString['via']=1;
$CasaFieldIsString['civico']=0;
$CasaFieldIsString['tipologia']=1;
$CasaFieldIsString['superficie']=0;
$CasaFieldIsString['camere']=0;
$CasaFieldIsString['bagni']=0;
$CasaFieldIsString['parcheggio']=1;
$CasaFieldIsString['giardino']=1;
$CasaFieldIsString['piscina']=0;
$CasaFieldIsString['patio']=0;
$CasaFieldIsString['barbecue']=0;
$CasaFieldIsString['angolo_bar']=0;
$CasaFieldIsString['idromassaggio']=0;
$CasaFieldIsString['terrazzo']=0;
$CasaFieldIsString['arredato']=0;
$CasaFieldIsString['prezzo']=0;
$CasaFieldIsString['descrizione']=1;


//RESTITUISCE LA QUERY PER L'LELENCO DI TUTTE LE CASE
function getAllCasa(){
	return "SELECT * FROM casa";
}


//RESTITUISCE QUERY PER ELENCO DELLE CASE CHE SODDISFANO IL FILTRO ($field e $value sono variabili string)
function getCasaBy1Field($field, $value){
	global $CasaFieldIsString;
	$queryString="SELECT * FROM casa WHERE ";
	if($CasaFieldIsString[$field])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="$field LIKE \"$value\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="$field LIKE $value";
	unset($CasaFieldIsString);
	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO IL CAMPO newField A newValue
function updateCasaByField($filterField, $filterValue, $newField, $newValue){
	global $CasaFieldIsString;
	$queryString="UPDATE casa ";
	if($CasaFieldIsString[$newField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="SET $newField = \"$newValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="SET $newField = $newValue";
	
	if($CasaFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	unset($CasaFieldIsString);
	return $queryString;
}

//ELIMINA I RECORD CON CAMPO filterField SETTATO A filterValue
function deleteCasaByField($filterField, $filterValue){
	global $CasaFieldIsString;
	$queryString="DELETE FROM casa ";
	
	if($CasaFieldIsString[$filterField])
		//il campo è stringa, quindi devo aggiungere gli apici
		$queryString.="WHERE $filterField = \"$filterValue\"";
	else
		//il campo è non stringa, quindi non devo aggiungere gli apici
		$queryString.="WHERE $filterField = $filterValue";
	unset($CasaFieldIsString);
	return $queryString;
}

//INSERISCE I RECORD CON I VALORI in $values
function insertCasa($values){
	if (!empty($values))
	{
		$queryString="INSERT INTO casa (regione, provincia, citta, via, civico, tipologia, superficie, camere, bagni, parcheggio, giardino, piscina, patio, barbecue, angolo_bar, idromassaggio, terrazzo, arredato, prezzo, descrizione) VALUES( ";
		$queryString.="\"".$values['regione']."\", ";
		$queryString.="\"".$values['provincia']."\", ";
		$queryString.="\"".$values['citta']."\", ";
		$queryString.="\"".$values['via']."\", ";
		$queryString.=$values['civico'].", ";
		$queryString.="\"".$values['tipologia']."\", ";
		$queryString.=$values['superficie'].", ";
		$queryString.=$values['camere'].", ";
		$queryString.=$values['bagni'].", ";
		$queryString.="\"".$values['parcheggio']."\", ";
		$queryString.="\"".$values['giardino']."\", ";
		$queryString.=$values['piscina'].", ";
		$queryString.=$values['patio'].", ";
		$queryString.=$values['barbecue'].", ";
		$queryString.=$values['angolo_bar'].", ";
		$queryString.=$values['idromassaggio'].", ";
		$queryString.=$values['terrazzo'].", ";
		$queryString.=$values['arredato'].", ";
		$queryString.=$values['prezzo'].", ";
		$queryString.="\"".$values['descrizione']."\")";

		return $queryString;
	}
	return '';
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO I CAMPI newFiled[i] A newValue[i]
//$filterField e $filterValue sono string o int
//$newField e $newValue sono array
function updateCasaByMoreField($filterField, $filterValue, $newField, $newValue){
	if (!empty($newField) && !empty($newValue))
	{
		global $CasaFieldIsString;
		$queryString="UPDATE casa SET ";
		$count=count($newField);
		for($i=0; $i<$count;$i++)
		{
			if($CasaFieldIsString[$newField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="$newField[$i] = \"$newValue[$i]\" ";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="$newField[$i] = $newValue[$i] ";
			
			if($i!=$count-1)
					$queryString.=", ";
		}
		if($CasaFieldIsString[$filterField])
			//il campo è stringa, quindi devo aggiungere gli apici
			$queryString.="WHERE $filterField = \"$filterValue\"";
		else
			//il campo è non stringa, quindi non devo aggiungere gli apici
			$queryString.="WHERE $filterField = $filterValue";
		unset($CasaFieldIsString);
		return $queryString;
	}
	return '';
}

//RESTITUISCE I RECORD CON I CAMPI filterField[i] SETTATI A filterValue[i]
//$filterField e $filterValue sono string o int
function getCasaByMoreField($filterField, $filterValue){
	if (!empty($filterField) && !empty($filterValue))
	{
		global $CasaFieldIsString;
		$queryString="SELECT * FROM casa WHERE ";
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($CasaFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\") ";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i]) ";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($CasaFieldIsString);
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
function getCasaByMoreRangeFieldOrder($filterField, $filterValue, $filterLogic, $orderField, $orderDirection){
	$queryString="SELECT * FROM casa";
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
	unset($CasaFieldIsString);
	return $queryString;
}



//MODIFICA I RECORD CON CAMPO filterField[i] SETTATO A filterValue[i], SETTANDO I CAMPI newField[i] A newValue[i]
//$filterField e $filterValue sono array
//$newField e $newValue sono array
function updateCasaByMoreFilter($filterField, $filterValue, $newField, $newValue){
	if (!empty($newField) && !empty($newValue) && !empty($filterField) && !empty($filterValue))
	{
		global $CasaFieldIsString;
		$queryString="UPDATE casa SET ";
		$count=count($newField);
		for($i=0; $i<$count;$i++)
		{
			if($CasaFieldIsString[$newField[$i]])
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
			if($CasaFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\" )";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i] )";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($CasaFieldIsString);
		return $queryString;
	}
	return '';
}

//CANCELLA I RECORD CON $filterField[$i]=$filterValue[$i]
//$filterField[$i] e $filterValue[$i] sono array
function deleteCasaByMoreFilter($filterField, $filterValue){
	if (!empty($filterField) && !empty($filterValue))
	{
		global $CasaFieldIsString;
		$queryString="DELETE FROM casa WHERE ";
		
		$count=count($filterField);
		for($i=0; $i<$count;$i++)
		{
			if($CasaFieldIsString[$filterField[$i]])
				//il campo è stringa, quindi devo aggiungere gli apici
				$queryString.="($filterField[$i] = \"$filterValue[$i]\" )";
			else
				//il campo è non stringa, quindi non devo aggiungere gli apici
				$queryString.="($filterField[$i] = $filterValue[$i] )";
			
			if($i!=$count-1)
					$queryString.=" AND ";
		}
		unset($CasaFieldIsString);
		return $queryString;
	}
	return '';
}

