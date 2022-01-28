<?php

//data la variabile in $input, vengono effettuai i controlli inseriti in $controlli
//se tutti i controlli sono superati, si restituisce la stringa "OK"
//per ogni controllo non superato, si restituisce un array di stringhe: ogni elemento dell'array contiene l'errore riguardante il controllo non superato
//#PARAM serve per indicare il nome del parametro
//di seguito sono riportate le combinazioni dei controlli
//array $controlli['param'] contiene un array di informazioni aggiuntive, necessarie per il controllo
//$controlli[$i]='LUNGHEZZA_MIN'
//$controlli['param']['LUNGHEZZA_MIN']=int, lunghezza minima

//$controlli[$i]='LUNGHEZZA_MAX'
//$controlli['param']['LUNGHEZZA_MAX']=int, lunghezza massima

//$controlli[$i]='LUNGHEZZA_MIN_MAX'
//$controlli['param']['LUNGHEZZA_MIN']=int, lunghezza minima
//$controlli['param']['LUNGHEZZA_MAX']=int, lunghezza massima

//$controlli[$i]='NO_NUMERI'
//NO $controlli['param'] richiesti

//$controlli[$i]='NUMERO_INTERO'
//NO $controlli['param'] richiesti

//$controlli[$i]='NUMERO_DECIMALE'
//NO $controlli['param'] richiesti

//$controlli[$i]='EMAIL'
//NO $controlli['param'] richiesti

//$controlli[$i]='SQL_INJECTION'
//NO $controlli['param'] richiesti

function validazione_input($input, $controlli)
{
	$return=array();
	$param=array();
	
	if(array_key_exists('param', $controlli))
	{
		$param=$controlli['param'];
		unset($controlli['param']);
	}
	
	//controllo array dei controlli da eseguire
	if(empty($controlli)==false)
	{
		//array dei controlli non � vuoto, procedo con i controlli
		foreach ($controlli as $controllo)
		{
			switch($controllo)
			{
				case 'LUNGHEZZA_MIN':
						if(empty($param['LUNGHEZZA_MIN'])==false)
						{
							if(strlen($input)<$param['LUNGHEZZA_MIN'])
								array_push($return,'#PARAM deve avere lunghezza minima di '.$param['LUNGHEZZA_MIN'].' caratteri');
						}
						else
						{
							array_push($return,'LUNGHEZZA_MIN: richiesti $param[LUNGHEZZA_MIN]');
						}
						break;
						
				case 'LUNGHEZZA_MAX':
						if(empty($param['LUNGHEZZA_MAX'])==false)
						{
							if(strlen($input)>$param['LUNGHEZZA_MAX'])
								array_push($return,'#PARAM deve avere lunghezza massima di '.$param['LUNGHEZZA_MAX'].' caratteri');
						}
						else
						{
							array_push($return,'LUNGHEZZA_MAX: richiesti $param[LUNGHEZZA_MAX]');
						}
						break;
				
				case 'LUNGHEZZA_MIN_MAX':
						if(empty($param['LUNGHEZZA_MIN'])==false || empty($param['LUNGHEZZA_MAX'])==false)
						{
							if(strlen($input)>$param['LUNGHEZZA_MAX'] || strlen($input)<$param['LUNGHEZZA_MIN'])
								array_push($return,'#PARAM deve avere lunghezza compresa tra '.$param['LUNGHEZZA_MIN'].' e '.$param['LUNGHEZZA_MAX'].' caratteri');
						}
						else
						{
							array_push($return,'LUNGHEZZA_MIN_MAX: richiesti $param[LUNGHEZZA_MIN], $param[LUNGHEZZA_MAX]');
						}
						break;
				
				case 'NO_NUMERI':
						///\d/ cerca i numeri
						if(preg_match('/\d/', $input))
							array_push($return,'#PARAM non pu� contenere numeri');
						
						break;
						
				case 'NUMERO_INTERO':
							if(!filter_var($input, FILTER_VALIDATE_INT))
							array_push($return,'#PARAM deve essere un numero intero');
						break;
				
				case 'NUMERO_DECIMALE':
							if(!filter_var($input, FILTER_VALIDATE_FLOAT))
							array_push($return,'#PARAM deve essere un numero decimale');
						break;
						
				case 'EMAIL':
							if(!filter_var($input, FILTER_VALIDATE_EMAIL))
							array_push($return,'#PARAM deve essere un indirizzo email');
						break;
						
				case 'DATETIME':
						if (date('Y-m-d H:i:s', strtotime($input))== false)
						{	
							array_push($return,'#PARAM deve essere di tipo data-ora');
						}
						break;
				
				case 'SQL_INJECTION':
							$st_non_permesse=array();
							array_push($st_non_permesse,'XOR');
							array_push($st_non_permesse,'SELECT');
							array_push($st_non_permesse,'UPDATE');
							array_push($st_non_permesse,'DELETE');
							array_push($st_non_permesse,'INSERT');
							array_push($st_non_permesse,'DROP');
							array_push($st_non_permesse,'TABLE');
							array_push($st_non_permesse,'VALUES');
							array_push($st_non_permesse,'FROM');
							array_push($st_non_permesse,'" OR ""="');
							array_push($st_non_permesse,'OR 1=1');
							array_push($st_non_permesse,'1=1');
							array_push($st_non_permesse,'/*');
							array_push($st_non_permesse,'/');
							array_push($st_non_permesse,'<!�');
							array_push($st_non_permesse,'�>');
							array_push($st_non_permesse,'*');
							array_push($st_non_permesse,'<');
							array_push($st_non_permesse,'>');
							array_push($st_non_permesse,'--');
							array_push($st_non_permesse,';');
							
							$pos=-1;
							foreach($st_non_permesse as $non_permesse)
							{
								/*
								//cerco $non_permesse in $input originale
								$pos= $pos+strpos($input, $non_permesse);
								//cerco $non_permesse in $input originale togliendo gli spazi in entrambi
								$pos= $pos+strpos(preg_replace('/\s+/', '', $input), preg_replace('/\s+/', '', $non_permesse));
								//cerco $non_permesse in $input originale ponendo in minuscolo entrambi
								$pos= $pos+strpos(strtolower($input), strtolower($non_permesse));
								*/
								$input_confronto=preg_replace('/\s+/', '', strtolower($input));
								$non_permesse_confronto=preg_replace('/\s+/', '', strtolower($non_permesse));
								$pos= $pos+strpos(strtolower($input_confronto), strtolower($non_permesse_confronto));
							}
							if($pos>=0)
								array_push($return,'#PARAM contiene caratteri non consentiti');
							unset($st_non_permesse);
							unset($non_permesse_confronto);
							unset($input_confronto);
							unset($pos);
						break;
			}
		}
	}
	else
	{
		//array dei controlli vuoto: segnalo errore
		array_push($return,'NO_DATA');
	}
	
	//se $return � vuota, significa che tutti i controlli eseguiti sono stati passati positivamente. Ritorno "OK"
	if(empty($return)==true)
		array_push($return,'OK');
	
	unset($input);
	unset($controlli);
	unset($param);
	return $return;
}