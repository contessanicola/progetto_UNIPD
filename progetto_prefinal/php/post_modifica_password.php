<?php 
namespace DB;
require_once "model/db.php";
require_once "model/login.php";
require_once "functions/lib_sessioni.php";
require_once "functions/lib_validazione_input.php";

//DA CANCELLARE-------------------
//session_start();
//$_SESSION['logged']=1;
//-------------------
check_session();
//controllo se la sessione è attiva
//$is_logged è true se è utente già loggato, altrimenti è false
$is_logged=is_logged();
$output_validazione_input=array();
$campo='';

//se utente è loggato, può procedere, altrimenti deve fare il login
if($is_logged==true)
{
	//utente loggato: verifico form
	//$paginaHTML = file_get_contents("#DA_INSERIRE_FORM_LOGIN.html");
echo '<br>utente loggato';
	if(isset($_POST['submit']))
	{
echo '<br>utente ha fatto submit';
		//l'utente ha premuto almeno 1 volta il pulsante submit
		//ricevo dati in input
		$password_vecchia=$_POST['vecchia_password'];
		$password_nuova_1=$_POST['password'];
		$password_nuova_2=$_POST['rpassword'];
		$username=$_SESSION['user'];

		
		$controlli=array();
		$output=array();
		$alert='';
		$fare_verifica_db=true;
		
		//controllo password_vecchia
		$controlli=array();
		$campo='Password precedente';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=255;
		$output=str_replace('#PARAM', $campo, validazione_input($password_vecchia, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo password nuova 1
		$controlli=array();
		$campo='Password nuova';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=255;
		$output=str_replace('#PARAM', $campo, validazione_input($password_nuova_1, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo password nuova 2
		$controlli=array();
		$campo='Password nuova';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=255;
		$output=str_replace('#PARAM', $campo, validazione_input($password_nuova_2, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo che le due password siano uguali
		if($password_nuova_1!=$password_nuova_2)
			array_push($output_validazione_input, 'Password non corrispondenti');
		
		
		//controllo se la password vecchia è corretta in db
		$connessione=new DBAccess();
		$filterField=array('username', 'password');
		$filterValue=array($username, md5($password_vecchia));
		$connessioneON=$connessione->openDBConnection();
		if($connessioneON==true)
		{
			$risultatoQuery=$connessione->db_getArray(getLoginByMoreField($filterField, $filterValue));
			$connessione->closeConnection();
			if(!$risultatoQuery)
			{
				//casa non trovata in db
				array_push($output_validazione_input, 'Password vecchia non corretta');
			}
		}
		unset($filterField);
		unset($filterValue);
		unset($connessione);
		unset($connessioneON);
		unset($risultatoQuery);
		
		//controllo se tutti i campi hanno avuto validazione "OK", verifico la presenza nel database
		for ($i=0; $i<count($output_validazione_input); $i++)
		{
			if($output_validazione_input[$i]!=='OK')
			{
				$fare_verifica_db=false;
				$alert.='<li>'.$output_validazione_input[$i].'</li>';
			}
		}
echo '<br>alert: '.$alert;
		
		//se tutti i campi hanno avuto validazione "OK" (cioé $fare_verifica_db=true), posso continuare

		if($fare_verifica_db)
		{
			//se gli input sono ammissibili, verifico con il database
echo '<br>controllo input superato: controllo in db';
			$connessione=new DBAccess();
			
			//verifico se il preferito è già presente
			$filterField=array('username', 'password');
			$filterValue=array($username, md5($password_vecchia));
		
			$connessioneON=$connessione->openDBConnection();
			if($connessioneON==true)
			{
				$newField=array('password');
				$newValue=array(addslashes(md5($password_nuova_1)));
				$risultatoQuery=$connessione->db_getBool(updateLoginByMoreFilter($filterField, $filterValue, $newField, $newValue));
									
				$connessione->closeConnection();
				if($risultatoQuery)
				{
					//#DA_INSERIRE: inserimento eseguito con successo
					echo '<br>UPDATE avvenuto con successo';
					header('Location: area_riservata.php');
				}
				else
				{
					//#DA_INSERIRE: inserimento non eseguito 
					echo '<br>Errore: UPDATE non avvenuto';
					header('Location: errore.php?errore="Update+non+avvenuto"');	
				}
				unset($newField);
				unset($newValue);
				unset($risultatoQuery);
			}
			else
			{
				//#DA_INSERIRE: cosa fare? errore connessione db
				echo '<br>Errore connesisone DB, riprovare più tardi';
				header('Location: errore.php?errore="Errore+connessione+database+riprova+più+tardi"');	
			}
		unset($filterField);
		unset($filterValue);
		unset($connessioneON);
		unset($connessione);
		}
		else
		{
			//gli input non erano ammissibili: alert ad utente
			//#DA_INSERIRE cosa fare?
			echo '<br>controllo input non superato: modificare input';	
			header('Location: errore.php?errore="Input+non+validi"');			
		}
		
		unset($username);
		unset($password_nuova_2);
		unset($password_nuova_1);
		unset($password_vecchia);
		unset($alert);
		unset($fare_verifica_db);
		unset($output_validazione_input);
		unset($is_logged);
	}
	else
	{
		//esecuzione senza post: non eseguire
		//#DA_INSERIRE cosa fare?
echo '<br>nessun submit';
		header('Location: home.php');
		die();
	}
}
else
{
	//utente non loggato, redirect
	//#DA_INSERIRE cosa fare?
echo '<br>utente non loggato: fare login';
	unset($output_validazione_input);
	unset($is_logged);
	header('Location: login.php');
	die();
}
