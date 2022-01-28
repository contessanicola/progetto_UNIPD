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
		$password_2=$_POST['rpassword'];
		$nome=$_POST['nome'];
		$cognome=$_POST['cognome'];
		$mail=$_POST['email'];
		$numero_telefono=$_POST['numero_telefono'];
		
	/*	$username='m_username';
		$password='m_password';
		$password_2='m_password';
		$nome='m_nome';
		$cognome='m_cognome';
		$mail='martina@mail.it';
		$numero_telefono='123456';
		*/
		//controllo che le due password siano uguali
		if($password!=$password_2){
			array_push($output_validazione_input, 'Password non corrispondenti');
			header('Location: errore.php?errore="Passow+Non+Combaciano"');
		}

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
		echo '<br>';var_dump($output);
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
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo nome
		$controlli=array();
		$campo='Nome';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=30;
		$output=str_replace('#PARAM', $campo, validazione_input($nome, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo cognome
		$controlli=array();
		$campo='Cognome';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=30;
		$output=str_replace('#PARAM', $campo, validazione_input($cognome, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo mail
		$controlli=array();
		$campo='Email';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		array_push($controlli, 'EMAIL');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=50;
		$output=str_replace('#PARAM', $campo, validazione_input($mail, $controlli));
		echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo numero_telefono
		$controlli=array();
		$campo='Numero di telefono';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		array_push($controlli, 'NUMERO_INTERO');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=10;
		echo(var_dump($numero_telefono));
		$output=str_replace('#PARAM', $campo, validazione_input($numero_telefono, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo se utente è già presente: se sì, errore
		$connessione=new DBAccess();
		$connessioneON=$connessione->openDBConnection();
		if($connessioneON==true)
		{
			$risultatoQuery=$connessione->db_getArray(getLoginByField('username', addslashes($username)));
				
			$connessione->closeConnection();
			if($risultatoQuery)
			{
				//utente trovato in db
				array_push($output_validazione_input, 'Utente non valido');
			}
		}
		else
		{
			//errore connessione DB
			//#DA_INSERIRE: cosa fare?
			echo '<li>Errore: provare più tardi';
			header('Location: errore.php?errore="Errore+Connessione+Database"');
			die();

		}
		//controllo se tutti i campi hanno avuto validazione "OK", verifico la presenza nel database
		for ($i=0; $i<count($output_validazione_input); $i++)
		{
			if($output_validazione_input[$i]!=='OK')
			{
				$fare_verifica_db=false;
				$alert.='<li>'.$output_validazione_input[$i].'</li>';
			}
		}
echo '<br>'.$alert;
		
		//se tutti i campi hanno avuto validazione "OK" (cioé $fare_verifica_db=true), posso verificare la presenza nel database

		if($fare_verifica_db)
		{
			//se gli input sono ammissibili, verifico con il database
echo '<br>controllo input superato: controllo in db';
			$values['username']=addslashes($username);
			$values['password']=addslashes(md5($password));
			$values['nome']=addslashes($nome);
			$values['cognome']=addslashes($cognome);
			$values['mail']=addslashes($mail);
			$values['numero_telefono']=addslashes($numero_telefono);
			$values['isAdmin']=addslashes(0);

			$connessione=new DBAccess();
			$connessioneON=$connessione->openDBConnection();
			if($connessioneON==true)
			{
				$risultatoQuery=$connessione->db_getBool(insertLogin($values));
				
				$connessione->closeConnection();
				if($risultatoQuery)
				{
					//utente trovato in db
					//attivo sessione
echo '<br>corrispondenza nome utente e pwd in db';
					$param=array();
					$param['nome']=$nome;
					$param['cognome']=$cognome;
					$param['user']=$username;
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
						header('Location: errore.php?errore="Regristrazione+Non+Effettuata"');
						die();
					}
				}
				else
				{
					//utente non trovato in db
					//#DA_INSERIRE cosa fare?
					echo '<br>nome utente e pwd non corrispondono: modificare input';
					$alert.='<li>Nome utente o password errati</li>';	
					header('Location: errore.php?errore="Utente+Già+Esistente"');
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
			header('Location: errore.php?errore="Input+Non+Valido"');
			die();	
		}
		unset($username);
		unset($password);
		unset($password_2);
		unset($nome);
		unset($cognome);
		unset($mail);
		unset($numero_telefono);
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
