<?php 
namespace DB;
require_once "model/db.php";
require_once "model/casa.php";
require_once "model/login.php";
require_once "functions/lib_sessioni.php";
require_once "functions/lib_validazione_input.php";
check_session();
//controllo se la sessione è attiva
//$is_logged è true se è utente già loggato, altrimenti è false
$is_logged=is_logged();
$is_admin=is_admin();
$output_validazione_input=array();
$campo='';

//se utente è loggato, può procedere, altrimenti deve fare il login
if($is_logged==true && $is_admin==true)
{
	//utente loggato: verifico form
	//$paginaHTML = file_get_contents("#DA_INSERIRE_FORM_LOGIN.html");
echo '<br>utente loggato e di tipo admin';
	if(isset($_POST['submit']) || isset($_GET['submit']))
	{
echo '<br>utente ha fatto submit';
		//$azione contiene il tipo di azione da fare: insert, modify, delete
		//l'utente ha premuto almeno 1 volta il pulsante submit
		//ricevo dati in input

		//controllo azione
		if(isset($_GET['submit'])){
			$azione=$_GET['azione'];
			if($azione!='delete')
				array_push($output_validazione_input, 'Errore: operazione non valida');

			$id_casa=$_GET['id_casa'];
			$fare_verifica_db = true;
		}
		else{
			$azione=$_POST['azione'];
			if($azione!='insert' && $azione!='delete' && $azione!='modify')
				array_push($output_validazione_input, 'Errore: operazione non valida');
		
			$id_casa=$_POST['id_casa'];
			$regione=$_POST['regione'];
			$provincia=$_POST['provincia'];
			$citta=$_POST['citta'];
			$via=$_POST['via'];
			$civico=$_POST['civico'];
			$tipologia=$_POST['tipologia'];
			$superficie=$_POST['superficie'];
			$camere=$_POST['camere'];
			$bagni=$_POST['bagni'];
			$parcheggio=$_POST['parcheggio'];
			$giardino=$_POST['giardino'];

			if(isset($_POST['piscina']))
				$piscina=$_POST['piscina'];
			else
				$piscina=0;

			if(isset($_POST['patio']))
				$patio=$_POST['patio'];
			else
				$patio=0;	

			if(isset($_POST['barbecue']))
				$barbecue=$_POST['barbecue'];
			else
				$barbecue=0;	

			if(isset($_POST['angolo_bar']))
				$angolo_bar=$_POST['angolo_bar'];
			else
				$angolo_bar=0;	

			if(isset($_POST['idromassaggio']))
				$idromassaggio=$_POST['idromassaggio'];
			else
				$idromassaggio=0;	

			if(isset($_POST['terrazzo']))
				$terrazzo=$_POST['terrazzo'];
			else
				$terrazzo=0;	

			if(isset($_POST['arredato']))
				$arredato=$_POST['arredato'];
			else
				$arredato=0;	

			$prezzo=$_POST['prezzo'];
			$descrizione=$_POST['descrizione'];
			$username=$_SESSION['user'];
		
		$controlli=array();
		$output=array();
		$alert='';
		$fare_verifica_db=true;
		$casa_gia_presente=true;
		
		//controllo id_casa
		$campo='ID casa';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		array_push($controlli, 'NUMERO_INTERO');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=10;
		$output=str_replace('#PARAM', $campo, validazione_input($id_casa, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
				unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo se casa è presente in db, nel caso di modifica o cancellazione
		if($azione=='delete' || $azione=='modify')
		{
			$connessione=new DBAccess();
			$connessioneON=$connessione->openDBConnection();
			if($connessioneON==true)
			{
				$risultatoQuery=$connessione->db_getArray(getCasaBy1Field('id_casa', $id_casa));
				$connessione->closeConnection();
				if(!$risultatoQuery)
				{
					$casa_gia_presente=false;
					//casa non trovata in db
					//se azione richiesta è modifica o cancellazione, e la casa non è presente in db: errore
					array_push($output_validazione_input, 'Casa non trovata');
					header('Location: errore.php?errore="Casa+non+trovata"');		
				}
			}
		}
			
		//controllo regione
		$controlli=array();
		$output=array();
		$campo='Regione';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=20;
		$output=str_replace('#PARAM', $campo, validazione_input($regione, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo provincia
		$controlli=array();
		$output=array();
		$campo='Provincia';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=30;
		$output=str_replace('#PARAM', $campo, validazione_input($provincia, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo citta
		$controlli=array();
		$output=array();
		$campo='Citta';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=30;
		$output=str_replace('#PARAM', $campo, validazione_input($citta, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo via
		$controlli=array();
		$output=array();
		$campo='Via';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=50;
		$output=str_replace('#PARAM', $campo, validazione_input($via, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo civico
		$controlli=array();
		$output=array();
		$campo='Civico';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		array_push($controlli, 'NUMERO_INTERO');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=5;
		$output=str_replace('#PARAM', $campo, validazione_input($civico, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo tipologia
		$controlli=array();
		$output=array();
		$campo='Tipologia';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=30;
		$output=str_replace('#PARAM', $campo, validazione_input($tipologia, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo superficie
		$controlli=array();
		$output=array();
		$campo='Superficie';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		array_push($controlli, 'NUMERO_INTERO');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=10;
		$output=str_replace('#PARAM', $campo, validazione_input($superficie, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo camere
		$controlli=array();
		$output=array();
		$campo='Camere';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		array_push($controlli, 'NUMERO_INTERO');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=10;
		$output=str_replace('#PARAM', $campo, validazione_input($camere, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo bagni
		$controlli=array();
		$output=array();
		$campo='Bagni';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		array_push($controlli, 'NUMERO_INTERO');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=10;
		$output=str_replace('#PARAM', $campo, validazione_input($bagni, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo parcheggio
		$controlli=array();
		$output=array();
		$campo='Parcheggio';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=0;
		$controlli['param']['LUNGHEZZA_MAX']=30;
		$output=str_replace('#PARAM', $campo, validazione_input($parcheggio, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo giardino
		$controlli=array();
		$output=array();
		$campo='Giardino';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=3;
		$controlli['param']['LUNGHEZZA_MAX']=20;
		$output=str_replace('#PARAM', $campo, validazione_input($giardino, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo piscina
		$controlli=array();
		$output=array();
		$campo='Piscina';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=1;
		$output=str_replace('#PARAM', $campo, validazione_input($piscina, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		if($piscina!='0' && $piscina!='1')
			array_push($output_validazione_input, $campo.' non valido');
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo patio
		$controlli=array();
		$output=array();
		$campo='Patio';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=1;
		$output=str_replace('#PARAM', $campo, validazione_input($patio, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		if($patio!='0' && $patio!='1')
			array_push($output_validazione_input, $campo.' non valido');
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo barbecue
		$controlli=array();
		$output=array();
		$campo='Barbecue';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=1;
		$output=str_replace('#PARAM', $campo, validazione_input($barbecue, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		if($barbecue!='0' && $barbecue!='1')
			array_push($output_validazione_input, $campo.' non valido');
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo angolo_bar
		$controlli=array();
		$output=array();
		$campo='Angolo bar';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=1;
		$output=str_replace('#PARAM', $campo, validazione_input($angolo_bar, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		if($angolo_bar!='0' && $angolo_bar!='1')
			array_push($output_validazione_input, $campo.' non valido');
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo idromassaggio
		$controlli=array();
		$output=array();
		$campo='Idromassaggio';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=1;
		$output=str_replace('#PARAM', $campo, validazione_input($idromassaggio, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		if($idromassaggio!='0' && $idromassaggio!='1')
			array_push($output_validazione_input, $campo.' non valido');
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo terrazzo
		$controlli=array();
		$output=array();
		$campo='Terrazzo';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=1;
		$output=str_replace('#PARAM', $campo, validazione_input($terrazzo, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		if($terrazzo!='0' && $terrazzo!='1')
			array_push($output_validazione_input, $campo.' non valido');
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo arredato
		$controlli=array();
		$output=array();
		$campo='Arredato';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=1;
		$output=str_replace('#PARAM', $campo, validazione_input($arredato, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		if($arredato!='0' && $arredato!='1')
			array_push($output_validazione_input, $campo.' non valido');
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo prezzo
		$controlli=array();
		$output=array();
		$campo='Prezzo';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		array_push($controlli, 'NUMERO_INTERO');
		$controlli['param']['LUNGHEZZA_MIN']=1;
		$controlli['param']['LUNGHEZZA_MAX']=10;
		$output=str_replace('#PARAM', $campo, validazione_input($prezzo, $controlli));
echo '<br>';var_dump($output);
		foreach($output as $out)
			array_push($output_validazione_input, $out);
		unset($controlli);
		unset($output);
		unset($campo);
		
		//controllo descrizione
		$controlli=array();
		$output=array();
		$campo='Descrizione';
		array_push($controlli, 'LUNGHEZZA_MIN_MAX');
		array_push($controlli, 'SQL_INJECTION');
		$controlli['param']['LUNGHEZZA_MIN']=10;
		$controlli['param']['LUNGHEZZA_MAX']=500;
		$output=str_replace('#PARAM', $campo, validazione_input($descrizione, $controlli));
echo '<br>';var_dump($output);
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
echo '<br>alert: '.$alert;
}
		
		//se tutti i campi hanno avuto validazione "OK" (cioé $fare_verifica_db=true), posso continuare

		if($fare_verifica_db)
		{
			//se gli input sono ammissibili, verifico con il database
echo '<br>controllo input superato: controllo in db';
			$connessione=new DBAccess();
			switch($azione)
			{
				case 'insert':
						//inserire la casa
						$connessioneON=$connessione->openDBConnection();
						if($connessioneON==true)
						{		
							$values['regione']=addslashes($regione);
							$values['provincia']=addslashes($provincia);
							$values['citta']=addslashes($citta);
							$values['via']=addslashes($via);
							$values['civico']=addslashes($civico);
							$values['tipologia']=addslashes($tipologia);
							$values['superficie']=addslashes($superficie);
							$values['camere']=addslashes($camere);
							$values['bagni']=addslashes($bagni);
							$values['parcheggio']=addslashes($parcheggio);
							$values['giardino']=addslashes($giardino);
							$values['piscina']=addslashes($piscina);
							$values['patio']=addslashes($patio);
							$values['barbecue']=addslashes($barbecue);
							$values['angolo_bar']=addslashes($angolo_bar);
							$values['idromassaggio']=addslashes($idromassaggio);
							$values['terrazzo']=addslashes($terrazzo);
							$values['arredato']=addslashes($arredato);
							$values['prezzo']=addslashes($prezzo);
							$values['descrizione']=addslashes($descrizione);
							
							$risultatoQuery=$connessione->db_getBool(insertCasa($values));
							$connessione->closeConnection();
							if($risultatoQuery)
							{
									//#DA_INSERIRE: inserimento eseguito con successo
									if (isset($_FILES['immagini'])) {
										$uploaddirroot = '../media/immaginiCase/';
										$id_casa = $_POST['id_casa'].'/';
										mkdir($uploaddirroot.$id_casa);
									
										$arr = array();
									
										$index_letter = 'a';
										foreach($_FILES['immagini']["tmp_name"] as $immagine){
											$uploadfile = $uploaddirroot.$id_casa . basename($_POST['id_casa'].$index_letter.'.jpeg');
											if (move_uploaded_file($immagine, $uploadfile)) {
												echo ("DONE IMAGE<br>");
												$arr[] = array("nome" => $_POST['id_casa'].$index_letter.'.jpeg',"alt" => "");
											}	
											else{
												echo ("NOT DONE IMAGE<br>");
											}
											$index_letter++;
										}
									
										echo json_encode($arr);
										$fp = fopen($uploaddirroot.$id_casa .'alt.json', 'w');
										fwrite($fp, json_encode($arr));
										fclose($fp);
									}
									echo '<br>Inserimento avvenuto con successo';
									header('Location: dettagli.php?id_casa='.$_POST['id_casa']);	
							}
							else
							{
									//#DA_INSERIRE: inserimento non eseguito 
									echo '<br>Errore: Inserimento non avvenuto';
									header('Location: aggiungi_casa.php?errore="Inserimento+non+Avvenuto"');	
							}
							unset($values);
						}
						else
						{
							//#DA_INSERIRE: cosa fare? errore connessione db
							echo '<br>Errore connesisone DB, riprovare più tardi';
							header('Location: aggiungi_casa.php?errore="Errore+connessione+database+riprova+più+tardi"');	
						}
						unset($connessioneON);
						break;
				
				case 'modify':
						//la casa è presente (già verificato con $casa_gia_presente). Devo modificarla
						$connessioneON=$connessione->openDBConnection();
						if($connessioneON==true)
						{
							$newField=array();
							array_push($newField, 'regione');
							array_push($newField, 'provincia');
							array_push($newField, 'citta');
							array_push($newField, 'via');
							array_push($newField, 'civico');
							array_push($newField, 'tipologia');
							array_push($newField, 'superficie');
							array_push($newField, 'camere');
							array_push($newField, 'bagni');
							array_push($newField, 'parcheggio');
							array_push($newField, 'giardino');
							array_push($newField, 'piscina');
							array_push($newField, 'patio');
							array_push($newField, 'barbecue');
							array_push($newField, 'angolo_bar');
							array_push($newField, 'idromassaggio');
							array_push($newField, 'terrazzo');
							array_push($newField, 'arredato');
							array_push($newField, 'prezzo');
							array_push($newField, 'descrizione');
							
							$newValue=array();
							array_push($newValue, addslashes($regione));
							array_push($newValue, addslashes($provincia));
							array_push($newValue, addslashes($citta));
							array_push($newValue, addslashes($via));
							array_push($newValue, addslashes($civico));
							array_push($newValue, addslashes($tipologia));
							array_push($newValue, addslashes($superficie));
							array_push($newValue, addslashes($camere));
							array_push($newValue, addslashes($bagni));
							array_push($newValue, addslashes($parcheggio));
							array_push($newValue, addslashes($giardino));
							array_push($newValue, addslashes($piscina));
							array_push($newValue, addslashes($patio));
							array_push($newValue, addslashes($barbecue));
							array_push($newValue, addslashes($angolo_bar));
							array_push($newValue, addslashes($idromassaggio));
							array_push($newValue, addslashes($terrazzo));
							array_push($newValue, addslashes($arredato));
							array_push($newValue, addslashes($prezzo));
							array_push($newValue, addslashes($descrizione));
							$risultatoQuery=$connessione->db_getBool(updateCasaByMoreField('id_casa', addslashes($id_casa), $newField, $newValue));
							
							$connessione->closeConnection();
							if($risultatoQuery)
							{
									//#DA_INSERIRE: modifica eseguito con successo
									echo '<br>UPDATE avvenuto con successo';
									header('Location: dettagli.php?id_casa='.$_POST['id_casa']);
							}
							else
								{
									//#DA_INSERIRE: modifica non eseguito 
									echo '<br>Errore: UPDATE non avvenuto';
									header('Location: modifica_casa.php?errore="Update+non+avvenuto"');
							}
							unset($newField);
							unset($newValue);
						}
						else
						{
							//#DA_INSERIRE: cosa fare? errore connessione db
							echo '<br>Errore connesisone DB, riprovare più tardi';
							header('Location: modifica_casa.php?errore="Errore+connessione+database+riprova+più+tardi"');	
						}
						unset($connessioneON);
						break;
				
				case 'delete':
						//la casa è presente (già verificato con $casa_gia_presente). Devo cancellarla
						$connessioneON=$connessione->openDBConnection();
						if($connessioneON==true)
						{
							$risultatoQuery=$connessione->db_getBool(deleteCasaByField('id_casa', addslashes($id_casa)));
							$connessione->closeConnection();
							if($risultatoQuery)
							{
									//#DA_INSERIRE: delete eseguito con successo
									echo '<br>DELETE avvenuto con successo';
									$dir = '../media/immaginiCase/'.$id_casa;
									$files = array_diff(scandir($dir), array('.','..'));
									foreach ($files as $file) {
										(is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
									}
									rmdir($dir);

									header('Location: catalogo.php');	
							}
							else
								{
									//#DA_INSERIRE: delete non eseguito 
									echo '<br>Errore: DELETE non avvenuto';
									header('Location: errore.php?errore="Detele+non+avvenuto"');	
							}
						}
						else
						{
								//#DA_INSERIRE: cosa fare? errore connessione db
								echo '<br>Errore connesisone DB, riprovare più tardi';
								header('Location: errore.php?errore="Errore+connessione+database+riprova+più+tardi"');	
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
			header('Location: errore.php?errore="Input+non+validi"');	
		}
		unset($azione);
		unset($id_casa);
		unset($regione);
		unset($provincia);
		unset($citta);
		unset($via);
		unset($civico);
		unset($tipologia);
		unset($superficie);
		unset($camere);
		unset($bagni);
		unset($parcheggio);
		unset($giardino);
		unset($piscina);
		unset($patio);
		unset($barbecue);
		unset($angolo_bar);
		unset($idromassaggio);
		unset($terrazzo);
		unset($arredato);
		unset($prezzo);
		unset($descrizione);
		unset($username);
		unset($alert);
		unset($fare_verifica_db);
		unset($casa_gia_presente);
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
	//utente non loggato, oppure loggato con utente non amministratore: redirect
	//#DA_INSERIRE cosa fare?
	echo '<br>utente non loggato: fare login';
	unset($output_validazione_input);
	unset($is_logged);
	header('Location: home.php');
	die();
}


?>