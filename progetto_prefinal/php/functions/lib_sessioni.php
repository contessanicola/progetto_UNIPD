<?php
namespace DB;
require_once "model/db.php";
require_once "model/sessioni.php";
require_once "model/login.php";

//secondi massimi in cui la sessione con login è attiva (valore in secondi)
$sectimemax=3600;
$session_id='';

//attiva la sessione + aggiorna ultima attivita + logout forzato per inattivita
function check_session(){
	global $sectimemax;
	global $session_id;
	$risultatoQuery=null;
	$esito_controllo=null;
	$stQuery='';
	
	if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE)
	{
    	session_start();
		$session_id=session_id();
	}
	//controllo il login da sessione
	if(isset($_SESSION['ultima_attivita']) && !empty($_SESSION['ultima_attivita']))
	{
		//SESSIONE PRESENTE
		//controllo il login
		if($_SESSION['logged']=='1')
		{
			//SESSIONE CON LOGIN AUTENTICATO
			//controllo ultima attivita': se ultima attività è entro $sectimemax secondi, aggiorno ultima attività; altrimenti, logout ed aggiorno ultima attività			
			$now = new \DateTime('now');
			$ultima_attivita = new \DateTime($_SESSION['ultima_attivita']);
			$diffInSeconds = $now->getTimestamp() - $ultima_attivita->getTimestamp();

			if($diffInSeconds<$sectimemax)
			{
				//ULTIMA ATTIVITA ENTRO $sectimemax: aggiorno ultima attività 
				$esito_controllo='SESSIONE-SI#AUTENTICATO-SI#ULTIMA_ATTIVITA-ENTRO_TIMEMAX';				
				unset($now);
				unset($ultima_attivita);
				unset($diffInSeconds);
			}
			else
			{
				//ULTIMA ATTIVITA OLTRE $sectimemax: logout ed aggiorno ultima attività
				$esito_controllo='SESSIONE-SI#AUTENTICATO-SI#ULTIMA_ATTIVITA-OLTRE_TIMEMAX';
			}
		}
		else
		{
			//SESSIONE SENZA LOGIN AUTENTICATO: aggiorno ultima attività
			$esito_controllo='SESSIONE-SI#AUTENTICATO-NO';
		}
	}
	else
	{
		//SESSIONE NON PRESENTE: insert in db
		
		$esito_controllo='SESSIONE-NO';
	}

	$connessionecheckID=new DBAccess();
	$connessioneONcheckID=$connessionecheckID->openDBConnection();
	if($connessioneONcheckID==true)
	{
		$risultatoQueryCheckID=$connessionecheckID->db_getBool(getSessioniByField('id_sessione', $session_id));
		$connessionecheckID->closeConnection();
		if(empty($risultatoQueryCheckID))
			$return=$esito_controllo='SESSIONE-NO';
	}
	
	//PREPARO STRINGA QUERY
	switch ($esito_controllo) {
		case 'SESSIONE-SI#AUTENTICATO-NO':
				//SESSIONE SENZA LOGIN AUTENTICATO: aggiorno ultima attività
		case 'SESSIONE-SI#AUTENTICATO-SI#ULTIMA_ATTIVITA-ENTRO_TIMEMAX':
				//ULTIMA ATTIVITA ENTRO $sectimemax: aggiorno ultima attività 
				$_SESSION['ultima_attivita']=date("Y-m-d H:i:s");
				$stQuery=updateSessioniByField('id_sessione', $session_id, 'ultima_attivita', date("Y-m-d H:i:s"));
				break;
		case 'SESSIONE-SI#AUTENTICATO-SI#ULTIMA_ATTIVITA-OLTRE_TIMEMAX':
				//ULTIMA ATTIVITA OLTRE $sectimemax: logout ed aggiorno ultima attività
				$_SESSION['ultima_attivita']=date("Y-m-d H:i:s");
				$_SESSION['logged']=0;
				$_SESSION['user']='';
				$_SESSION['cognome']='';
				$_SESSION['nome']='';
				$newField=array();
				$newField[0]='ultima_attivita';
				$newField[1]='logged';		
				$newField[2]='cognome';
				$newField[3]='nome';
				$newField[4]='user';
				$newValue=array();
				$newValue[0]=date("Y-m-d H:i:s");
				$newValue[1]=0;
				$newValue[2]='';
				$newValue[3]='';
				$newValue[4]='';
				$stQuery=updateSessioniByMoreField('id_sessione', $session_id, $newField, $newValue);
				unset($newField);
				unset($newValue);
				break;
		case 'SESSIONE-NO':
				//SESSIONE NON PRESENTE: insert in db
				$session_id=session_id();
				$_SESSION['user']='';
				$_SESSION['nome']='';
				$_SESSION['cognome']='';
				$_SESSION['ultima_attivita']=date("Y-m-d H:i:s");
				$_SESSION['logged']=0;
				$values=array();
				$values['id_sessione']=$session_id;
				$values['user']='';
				$values['nome']='';
				$values['cognome']='';
				$values['ultima_attivita']=date("Y-m-d H:i:s");
				$values['logged']=0;
				$stQuery=insertSessioni($values);
				unset($values);
				break;
		default:
			return 'ERRORE_SWITCH';
	}
	
	//ESEGUO QUERY
	$connessione=new DBAccess();
	$connessioneON=$connessione->openDBConnection();
	if($connessioneON==true)
	{
		$risultatoQuery=$connessione->db_getBool($stQuery);
		$connessione->closeConnection();
		if($risultatoQuery)
			$return='SESSIONE_AGGIORNATA#'.$esito_controllo;
		else
			$return='ERRORE_DB';
	}
	
	unset($risultatoQuery);
	unset($connessione);
	unset($connessioneON);
	return $return;
}

//dopo aver controllato lo stato della sessione, ritorna true se è sessione loggata, altrimenti ritorna false
function is_logged()
{
	global $session_id;
	$return=false;
	if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE)
	{
		session_start();
		$session_id=session_id();	
	}	
	$esito_check_session=check_session();
	//controllo se $esito_check_session contiene un errore
	if(strpos($esito_check_session, 'ERRORE')==false)
	{
		//stringa 'ERRORE' non trovata: check_session è andata a buon fine
		//controllo se utente è loggato
		if($_SESSION['logged']=='1')
			$return=true;
	}
	unset($session_id);
	unset($esito_check_session);
	return $return;
}


//set parametri di login in sessione, in var $param (array con indici: nome, cognome, utente, logged)
function do_Login($param)
{
	global $session_id;
	$return=false;
	if (!empty($param))
	{
		
		if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE)
		{
			session_start();
			$session_id=session_id();
		}
		$esito_check_session=check_session();
		//controllo se $esito_check_session contiene un errore
		if(strpos($esito_check_session, 'ERRORE')==false)
		{
			//stringa 'ERRORE' non trovata: check_session è andata a buon fine
			//setto utente loggato
			
			$_SESSION['nome']=$param['nome'];
			$_SESSION['cognome']=$param['cognome'];
			$_SESSION['user']=$param['user'];
			$_SESSION['logged']='1';
			$risultatoQuery=null;
			$session_id=session_id();
			$esito_check_session=check_session();
			//ESEGUO QUERY
			$connessione=new DBAccess();
			$connessioneON=$connessione->openDBConnection();
			if($connessioneON==true)
			{
				$newField=array();
				$newField[0]='nome';
				$newField[1]='cognome';
				$newField[2]='user';
				$newField[3]='logged';

				$newValue=array();
				$newValue[0]=$param['nome'];
				$newValue[1]=$param['cognome'];
				$newValue[2]=$param['user'];
				$newValue[3]='1';

				
				$risultatoQuery=$connessione->db_getBool(updateSessioniByMoreField('id_sessione', $session_id, $newField, $newValue));
				$connessione->closeConnection();
				unset($connessione);
				unset($newField);
				unset($newValue);
				if($risultatoQuery==true){
					$return=true;	
				}
					
			}
		}
		//stringa 'ERRORE' trovata: check_session ha fallito
		//oppure $connessioneON==false
		unset($connessioneON);
		unset($esito_check_session);
		unset($risultatoQuery);
	}
	unset($session_id);
	return $return;
}



//set parametri di login in sessione non autenticata, con valori vuoti per i campi: nome, cognome, utente, logged
function do_Logout()
{
	global $session_id;

	$return=false;
	if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE)
	{
    	session_start();
		$session_id = session_id();
	}
	$esito_check_session=check_session();
	//controllo se $esito_check_session contiene un errore
	if(strpos($esito_check_session, 'ERRORE')==false)
	{
		//stringa 'ERRORE' non trovata: check_session è andata a buon fine
		//setto utente loggato
		$_SESSION['nome']='';
		$_SESSION['cognome']='';
		$_SESSION['user']='';
		$_SESSION['logged']='0';
		$risultatoQuery=null;
		$session_id=session_id();
		//ESEGUO QUERY
		$connessione=new DBAccess();
		$connessioneON=$connessione->openDBConnection();
		if($connessioneON==true)
		{
			$newField=array();
			$newField[0]='nome';
			$newField[1]='cognome';
			$newField[2]='user';
			$newField[3]='logged';
			$newValue=array();
			$newValue[0]='';
			$newValue[1]='';
			$newValue[2]='';
			$newValue[3]='0';
			$risultatoQuery=$connessione->db_getBool(updateSessioniByMoreField('id_sessione', $session_id, $newField, $newValue));
			$connessione->closeConnection();
			
			unset($connessione);
			unset($newField);
			unset($newValue);
			if($risultatoQuery==true){
				$return=true;	
			}
		}
	}
	//stringa 'ERRORE' trovata: check_session ha fallito
	//oppure $connessioneON==false
	unset($connessioneON);
	unset($esito_check_session);
	unset($risultatoQuery);
	unset($session_id);
	return $return;
}

//return true se la sessione autenticata è da parte di utente amministratore, altrimenti false
function is_admin()
{
	global $session_id;
	$return=false;
	if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE)
	{
    	session_start();
		$session_id=session_id();
	}
	$esito_check_session=check_session();
	//controllo se $esito_check_session contiene un errore
	if(strpos($esito_check_session, 'ERRORE')==false)
	{
		//stringa 'ERRORE' non trovata: check_session è andata a buon fine
		$risultatoQuery=null;
		$session_id=session_id();
		//ESEGUO QUERY
		$connessione=new DBAccess();
		$connessioneON=$connessione->openDBConnection();
		if($connessioneON==true)
		{
			$risultatoQuery=$connessione->db_getArray(getLoginByField('username', $_SESSION['user']));
			$connessione->closeConnection();
			foreach($risultatoQuery as $row)
			{
				if($row['isAdmin']==1)
					$return=true;
			}
			unset($connessione);
			unset($newField);
			unset($newValue);
		}
	}
	//stringa 'ERRORE' trovata: check_session ha fallito
	//oppure $connessioneON==false
	unset($connessioneON);
	unset($esito_check_session);
	unset($risultatoQuery);
	unset($session_id);
	return $return;
}
