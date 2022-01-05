<?php
/*STRUTTURA TABELLA
CREATE TABLE `casa` (
  `id_casa` int(10) NOT NULL,
  `provincia` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `citta` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `via` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civico` int(5) NOT NULL,
  `tipologia` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `superficie` int(10) UNSIGNED NOT NULL,
  `camere` int(10) UNSIGNED NOT NULL,
  `bagni` int(10) UNSIGNED NOT NULL,
  `parcheggio` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `giardino` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `piscina` tinyint(1) NOT NULL,
  `patio` tinyint(1) NOT NULL,
  `barbecue` tinyint(1) NOT NULL,
  `angolo_bar` tinyint(1) NOT NULL,
  `idromassaggio` tinyint(1) NOT NULL,
  `terrazzo` tinyint(1) NOT NULL,
  `arredato` tinyint(1) NOT NULL,
  `prezzo` int(10) UNSIGNED NOT NULL,
  `descrizione` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

*/

$CasaFieldIsString=array();
$CasaFieldIsString['id_casa']=0;
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

	return $queryString;
}

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO IL CAMPO newFiled A newValue
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
	return $queryString;
}

//INSERISCE I RECORD CON I VALORI in $values
function insertCasa($values){
	global $CasaFieldIsString;
	$queryString="INSERT INTO casa (id_casa, provincia, citta, via, civico, tipologia, superficie, camere, bagni, parcheggio, giardino, piscina, patio, barbecue, angolo_bar, idromassaggio, terrazzo, arredato, prezzo, descrizione) VALUES( ";
	$queryString.=$values['id_casa'].", ";
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

//MODIFICA I RECORD CON CAMPO filterField SETTATO A filterValue, SETTANDO I CAMPI newFiled[i] A newValue[i]
//$filterField e $filterValue sono string o int
//$newField e $newValue sono array
function updateCasaByMoreField($filterField, $filterValue, $newField, $newValue){
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
	
	return $queryString;
}

//RESTITUISCE I RECORD CON I CAMPI filterField[i] SETTATI A filterValue[i]
//$filterField e $filterValue sono string o int
function getCasaByMoreField($filterField, $filterValue){
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
	return $queryString;
}
