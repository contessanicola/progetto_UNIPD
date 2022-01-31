<?php 
namespace DB;
require_once "model/db.php";
require_once "model/login.php";
require_once "functions/lib_sessioni.php";
require_once "functions/lib_validazione_input.php";

//controllo se la sessione è attiva
//$is_logged è true se è utente già loggato, altrimenti è false
$is_logged=is_logged();
$output_validazione_input=array();
$campo='';

//se utente è già loggato, non deve fare nuovamente il login
if($is_logged==false)
{
	//utente non loggato: verifico form
	//$paginaHTML = file_get_contents("#DA_INSERIRE_FORM_LOGIN.html");
echo '<br>utente non loggato';
	if(isset($_POST['submit']))
	{
echo '<br>utente ha fatto submit';
		//l'utente ha premuto almeno 1 volta il pulsante submit
		//ricevo dati in input
		$username=$_POST['username'];
		$password=$_POST['password'];
		
		//controllo username
		$controlli=array();
		$output=array();
		$alert='';
		$fare_verifica_db=true;
		$campo='Username';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=30;
		$output=str_replace('#PARAM', $campo, validazione_input($username, $controlli));
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo password
		$controlli=array();
		$campo='Password';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=255;
		$output=str_replace('#PARAM', $campo, validazione_input($password, $controlli));
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);

		//controllo se tutti i campi hanno avuto validazione "OK", verifico la presenza nel database
		for ($i=0; $i<count($output_validazione_input); $i++)
		{
			if($output_validazione_input[$i]!=='OK')
			{
				$fare_verifica_db=false;
				$alert.='<li>'.$output_validazione_input[$i].'</li>';
			}
		}
		
		//se tutti i campi hanno avuto validazione "OK" (cioé $fare_verifica_db=true), posso verificare la presenza nel database

		if($fare_verifica_db)
		{
			//se gli input sono ammissibili, verifico con il database
			echo '<br>controllo input superato: controllo in db';
			$filterField=array('username', 'password');
			$filterValue=array(addslashes($username), addslashes(md5($password)));
			$connessione=new DBAccess();
			$connessioneON=$connessione->openDBConnection();
			if($connessioneON==true)
			{
				$risultatoQuery=$connessione->db_getArray(getLoginByMoreField($filterField, $filterValue));
				
				$connessione->closeConnection();
				if($risultatoQuery)
				{
					//utente trovato in db
					//attivo sessione
					echo '<br>corrispondenza nome utente e pwd in db';
					$param=array();
					$param['nome']=$risultatoQuery[0]['nome'];
					$param['cognome']=$risultatoQuery[0]['cognome'];
					$param['user']=$risultatoQuery[0]['username'];
					$param['isAdmin']=$risultatoQuery[0]['isAdmin'];
					if(do_Login($param))
					{
						//#DA_INSERIRE tutto ok, redirect ad home??
						echo '<br>sessione attivata: registrato login';						
						echo '<br/><br/>#DA_INSERIRE : LOGIN FATTO, TUTTO OK<br/>';
						header('Location: home.php');
						die();
					}
					else
					{
						//#DA_INSERIRE no login cosa fare??
						echo '<br>sessione attivata: registrato login';
						echo 'errore';
						header('Location: home.php');
						die();
					}
				}
				else
				{
					//utente non trovato in db
					//#DA_INSERIRE cosa fare?
					echo '<br>nome utente e pwd non corrispondono: modificare input';
					$alert.='<li>Nome utente o password errati</li>';
					header('Location: login.php?errore=Nome+utente+o+password+errati');
					die();
				}
			}
		unset($filterField);
		unset($filterValue);
		}
		else
		{
			//gli input non erano ammissibili: alert ad utente
			//#DA_INSERIRE cosa fare?
			echo '<br>controllo input non superato: modificare input';	
			header('Location: login.php?errore=Input+non+validi');		
		}
		unset($username);
		unset($password);
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
	//utente già loggato, redirect
	//#DA_INSERIRE cosa fare?
	echo '<br>utente già loggato';
	unset($output_validazione_input);
	unset($is_logged);
	header('Location: home.php');
	die();
}
