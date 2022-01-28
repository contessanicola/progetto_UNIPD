<?php 
namespace DB;
require_once "model/db.php";
require_once "model/casa.php";
require_once "model/login.php";
require_once "model/richieste.php";
require_once "functions/lib_sessioni.php";
require_once "functions/lib_validazione_input.php";

//DA CANCELLARE-------------------
//session_start();
//$_SESSION['logged']=1;
//-------------------

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
	if(isset($_POST['submit']) || isset($_GET))
	{
echo '<br>utente ha fatto submit';
		//$azione contiene il tipo di azione da fare: insert, modify, delete
		//l'utente ha premuto almeno 1 volta il pulsante submit
		//ricevo dati in input

		if(!empty($_POST)){
			$id_casa=$_POST['id_casa'];
			$richiesta=$_POST['richiesta'];
			$azione=$_POST['azione'];
			$username=$_SESSION['user'];
			$orario=$_POST['orario'];				
		}
		else{
			$id_casa=$_GET['id_casa'];
			if(isset($_GET['richiesta']))
				$richiesta=$_GET['richiesta'];
			$azione=$_GET['azione'];
			$username=$_SESSION['user'];
			if(isset($_GET['orario']))
				$orario=$_GET['orario'];
		}
		
		
		/*$azione='insert';
		$id_casa=1;
		$richiesta='wow casa';
		$username='user';
		$orario='2022-02-01 12:00:00';
		*/
		$controlli=array();
		$output=array();
		$alert='';
		$fare_verifica_db=true;
		
		//controllo azione
		if($azione!='insert' && $azione!='delete' && $azione!='modify')
			array_push($output_validazione_input, 'Errore: operazione non valida');
		
		//controllo id_casa
		$campo='ID casa';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		array_push($controlli, 'NUMERO_INTERO');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=50;
		$output=str_replace('#PARAM', $campo, validazione_input($id_casa, $controlli));
		echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
				unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo se casa è presente in db
		$connessione=new DBAccess();
		$connessioneON=$connessione->openDBConnection();
		if($connessioneON==true)
		{
			$risultatoQuery=$connessione->db_getArray(getCasaBy1Field('id_casa', $id_casa));
			$connessione->closeConnection();
			if(!$risultatoQuery)
			{
				//casa non trovata in db
				array_push($output_validazione_input, 'Casa non trovata');
			}
		}
		unset($connessione);
		unset($connessioneON);
		unset($risultatoQuery);
		
		//controllo richiesta
		if(!empty($richiesta)){
			$controlli=array();
			$output=array();
			$campo='Richiesta';
			array_push($controlli, 'LUNGHEZZA_MIN_MAX');
			array_push($controlli, 'SQL_INJECTION');
			$controlli['param']['LUNGHEZZA_MIN']=3;
			$controlli['param']['LUNGHEZZA_MAX']=255;
			$output=str_replace('#PARAM', $campo, validazione_input($richiesta, $controlli));
			echo '<br>';var_dump($output);
			foreach($output as $out)
				array_push($output_validazione_input, $out);
			unset($controlli);
			unset($output);
			unset($campo);
		}
		
		//controllo orario
		if(!empty($orario)){
			$controlli=array();
			$output=array();
			$campo='Orario';
			array_push($controlli, 'LUNGHEZZA_MIN_MAX');
			array_push($controlli, 'DATETIME');
			array_push($controlli, 'SQL_INJECTION');
			$controlli['param']['LUNGHEZZA_MIN']=0;
			$controlli['param']['LUNGHEZZA_MAX']=19;
			$output=str_replace('#PARAM', $campo, validazione_input(date('Y-m-d H:i:s', strtotime($orario)), $controlli));
			echo '<br>';var_dump($output);
			foreach($output as $out)
				array_push($output_validazione_input, $out);
			unset($controlli);
			unset($output);
			unset($campo);
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
echo '<br>alert: '.$alert;
		
		//se tutti i campi hanno avuto validazione "OK" (cioé $fare_verifica_db=true), posso continuare

		if($fare_verifica_db)
		{
			//se gli input sono ammissibili, verifico con il database
         echo '<br>controllo input superato: controllo in db';
			$connessione=new DBAccess();
			switch($azione)
			{
				case 'insert':
						//verifico se la richiesta è già presente
						$filterField=array('id_casa', 'username');
						$filterValue=array(addslashes($id_casa), addslashes($username));
						$connessioneON=$connessione->openDBConnection();
						if($connessioneON==true)
						{
							$risultatoQuery=$connessione->db_getArray(getRichiesteByMoreField($filterField, $filterValue));
							$connessione->closeConnection();
							unset($filterField);
							unset($filterValue);
							if($risultatoQuery)
							{
								//#DA_INSERIRE: cosa fare? si vuole inserire qualcosa che c'è già
								echo '<br>Errore: richiesta già presente';
								header('Location: errore.php?errore="Richiesta+Già+Inserita"');
								die();
							}
							else
							{
								//richiesta non presente, devo inserirla
								$connessioneON=$connessione->openDBConnection();
								if($connessioneON==true)
								{
									$values['id_casa']=addslashes($id_casa);
									$values['username']=addslashes($username);
									$values['richiesta']=addslashes($richiesta);
									$values['orario']=addslashes($orario);
									$risultatoQuery=$connessione->db_getBool(insertRichiesta($values));
									$connessione->closeConnection();
									if($risultatoQuery)
									{
											echo '<br>Inserimento avvenuto con successo';											
											header('Location: dettagli.php?id_casa='.$id_casa);
											die();
									}
									else
										{
											echo '<br>Errore: Inserimento non avvenuto';
											header('Location: errore.php?errore="Errore+Inserimento+Richiesta"');
									}
									unset($values);
								}
								else
								{
									echo '<br>Errore connesisone DB, riprovare più tardi';
									header('Location: errore.php?errore="Errore+Connesssione+Database"');
								}
							}
						}
						else
						{
							echo '<br>Errore connesisone DB, riprovare più tardi';
							header('Location: errore.php?errore="Errore+Connesssione+Database"');
						}
						unset($connessioneON);
						break;
				
				
				case 'modify':
						//verifico se la richiesta è già presente
						$filterField=array('id_casa', 'username');
						$filterValue=array(addslashes($id_casa), addslashes($username));
						$connessioneON=$connessione->openDBConnection();
						if($connessioneON==true)
						{
							$risultatoQuery=$connessione->db_getArray(getRichiesteByMoreField($filterField, $filterValue));
							$connessione->closeConnection();
							if($risultatoQuery)
							{
								//richiesta presente, devo aggiornarlo
								$connessioneON=$connessione->openDBConnection();
								if($connessioneON==true)
								{
									$newField=array('richiesta');
									$newField=array('orario');
									$newValue=array(addslashes($richiesta));
									$newValue=array(addslashes($orario));
									$risultatoQuery=$connessione->db_getBool(updateRichiesteByMoreFilter($filterField, $filterValue, $newField, $newValue));
									
									$connessione->closeConnection();
									if($risultatoQuery)
									{
											//#DA_INSERIRE: modifica eseguito con successo
											echo '<br>UPDATE avvenuto con successo';
									}
									else
										{
											//#DA_INSERIRE: modifica non eseguito 
											echo '<br>Errore: UPDATE non avvenuto';
									}
									unset($newField);
									unset($newValue);
								}
								else
								{
									//#DA_INSERIRE: cosa fare? errore connessione db
									echo '<br>Errore connesisone DB, riprovare più tardi';
								}
							}
							else
							{
								//#DA_INSERIRE: cosa fare? si vuole inserire qualcosa che c'è già
								echo '<br>Errore: richiesta già presente';
							}
							unset($filterField);
							unset($filterValue);
						}
						else
						{
							//#DA_INSERIRE: cosa fare? errore connessione db
							echo '<br>Errore connesisone DB, riprovare più tardi';
						}
						unset($connessioneON);
						break;
				
				
				case 'delete':
						//verifico se la richiesta è già presente
						$filterField=array('id_casa', 'username');
						$filterValue=array(addslashes($id_casa), addslashes($username));
						$connessioneON=$connessione->openDBConnection();
						if($connessioneON==true)
						{
							$risultatoQuery=$connessione->db_getArray(getRichiesteByMoreField($filterField, $filterValue));
							$connessione->closeConnection();
							if($risultatoQuery)
							{
								//richiesta presente, devo cancellarla
								$connessioneON=$connessione->openDBConnection();
								if($connessioneON==true)
								{
									$risultatoQuery=$connessione->db_getBool(deleteRichiesteByMoreFilter($filterField, $filterValue));
									$connessione->closeConnection();
									if($risultatoQuery)
									{
											//#DA_INSERIRE: delete eseguito con successo
											echo '<br>DELETE avvenuto con successo';
											header('Location: area_riservata.php');
											die();
									}
									else
										{
											//#DA_INSERIRE: delete non eseguito 
											echo '<br>Errore: DELETE non avvenuto';
											header('Location: errore.php?errore="Errore+Cancellazione+Richiesta"');

									}
								}
								else
								{
									//#DA_INSERIRE: cosa fare? errore connessione db
									echo '<br>Errore connesisone DB, riprovare più tardi';
									header('Location: errore.php?errore="Errore+Connesssione+Database"');
								}
							}
							else
							{
								//#DA_INSERIRE: cosa fare? si vuole DELETARE qualcosa che non c'è
								echo '<br>Errore: richiesta non presente';
									header('Location: errore.php?errore="Richiesta+Non+Presente"');
							}
							unset($filterField);
							unset($filterValue);
						}
						else
						{
							//#DA_INSERIRE: cosa fare? errore connessione db
							echo '<br>Errore connesisone DB, riprovare più tardi';
							header('Location: errore.php?errore="Errore+Connesssione+Database"');
						}
						unset($connessioneON);
						break;
				
				default:
						//#DA_INSERIRE cosa fare? azione non prevista: errore
						echo '<br>azione non prevista';
						header('Location: home.php');
						die();
			}
			unset($connessione);
		}
		else
		{
			//gli input non erano ammissibili: alert ad utente
			//#DA_INSERIRE cosa fare?
echo '<br>controllo input non superato: modificare input';	
header('Location: errore.php?errore="Input+Non+Validi"');		
		}
		unset($azione);
		unset($id_casa);
		unset($richiesta);
		unset($orario);
		unset($username);
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
	//header('Location: home.php');
	die();
}
