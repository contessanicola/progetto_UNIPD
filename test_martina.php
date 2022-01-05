<?php 
namespace DB;

require_once "db.php";
require_once "login.php";
require_once "preferiti.php";
require_once "casa.php";
require_once "richieste.php";
require_once "sopralluoghi.php";

$connessione=new DBAccess();
$connessioneON=$connessione->openDBConnection();
if($connessioneON==true)
{
	echo '----TEST LOGIN----<br/>';
	
	//TEST LOGIN::getAllLogin
	$risultatoQuery=$connessione->db_getArray(getAllLogin());
	
	if($risultatoQuery)
	{
		echo '<br/><br/>LOGIN::getAllLogin - RISULTATO QUERY<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo 'ERRORE LOGIN::getAllLogin';
	}

	//TEST LOGIN::getLoginByField
	$risultatoQuery=$connessione->db_getArray(getLoginByField('isAdmin', '1'));
	if($risultatoQuery)
	{
		echo '<br/><br/>LOGIN::getLoginByField - RISULTATO QUERY<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo 'ERRORE LOGIN::getLoginByField<br/>';
	}
	
	//TEST LOGIN::updateLoginByField
	$risultatoQuery=$connessione->db_getBool(updateLoginByField('isAdmin', '1', 'nome', 'Martina'));
	if($risultatoQuery)
	{
		echo '<br/><br/>LOGIN::updateLoginByField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>LOGIN::updateLoginByField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST LOGIN::deleteLoginByField
	$risultatoQuery=$connessione->db_getBool(deleteLoginByField('isAdmin', '1'));
	if($risultatoQuery)
	{
		echo '<br/><br/>LOGIN::deleteLoginByField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>LOGIN::deleteLoginByField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
		
	//TEST LOGIN::insertLogin
	$values=array();
	$values['username']='admin';
	$values['password']='admin';
	$values['nome']='Amministratore';
	$values['cognome']='Prova';
	$values['mail']='example2708@gmail.com';
	$values['numero_telefono']=3472637812;
	$values['isAdmin']=1;
	$risultatoQuery=$connessione->db_getBool(insertLogin($values));
	if($risultatoQuery)
	{
		echo '<br/><br/>LOGIN::insertLogin - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>LOGIN::insertLogin - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST LOGIN::updateLoginByMoreField
	$newField=array('nome', 'cognome');
	$newValue=array('pippo', 'pluto');
	
	$risultatoQuery=$connessione->db_getBool(updateLoginByMoreField('username', 'admin', $newField, $newValue));
	if($risultatoQuery)
	{
		echo '<br/><br/>LOGIN::updateLoginByMoreField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>LOGIN::updateLoginByMoreField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST LOGIN::getLoginByMoreField
	$filterField=array('nome', 'cognome');
	$filterValue=array('pippo', 'pluto');
	
	$risultatoQuery=$connessione->db_getArray(getLoginByMoreField($filterField, $filterValue));
	if($risultatoQuery)
	{
		echo '<br/><br/>LOGIN::getCasaByMoreField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>LOGIN::getLoginByMoreField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//---------------------------
	echo '<br/><br/>----TEST PREFERITI----<br/>';
	
	//TEST PREFERITI::getAllPreferiti
	$risultatoQuery=$connessione->db_getArray(getAllPreferiti());
	
	if($risultatoQuery)
	{
		echo '<br/><br/>PREFERITI::getAllPreferiti - RISULTATO QUERY<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo 'ERRORE PREFERITI::getAllPreferiti';
	}
	
	
	//TEST PREFERITI::getPreferitiByField
	$risultatoQuery=$connessione->db_getArray(getPreferitiByField('username', 'admin'));
	if($risultatoQuery)
	{
		echo '<br/><br/>PREFERITI::getPreferitiByField - RISULTATO QUERY<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo 'ERRORE PREFERITI::getPreferitiByField<br/>';
	}
	
	//TEST PREFERITI::updatePreferitiByField
	$risultatoQuery=$connessione->db_getBool(updatePreferitiByField('username', 'admin', 'username', 'user'));
	if($risultatoQuery)
	{
		echo '<br/><br/>PREFERITI::updatePreferitiByField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>PREFERITI::updatePreferitiByField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST PREFERITI::deletePreferitiByField
	$risultatoQuery=$connessione->db_getBool(deletePreferitiByField('username', 'user'));
	if($risultatoQuery)
	{
		echo '<br/><br/>PREFERITI::deletePreferitiByField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>PREFERITI::deletePreferitiByField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
		
	//TEST PREFERITI::insertPreferito
	$values=array();
	$values['id_casa']=1;
	$values['username']='admin';
	$values['preferito']=1;
	
	$risultatoQuery=$connessione->db_getBool(insertPreferito($values));
	if($risultatoQuery)
	{
		echo '<br/><br/>PREFERITI::insertPreferito - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>PREFERITI::insertPreferito - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST PREFERITI::updatePreferitiByMoreField
	$newField=array('username', 'preferito');
	$newValue=array('admin', '2');
	
	$risultatoQuery=$connessione->db_getBool(updatePreferitiByMoreField('id_casa', 1, $newField, $newValue));
	if($risultatoQuery)
	{
		echo '<br/><br/>PREFERITI::updatePreferitiByMoreField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>PREFERITI::updatePreferitiByMoreField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST PREFERITI::getPreferitiByMoreField
	$filterField=array('username', 'preferito');
	$filterValue=array('admin', '2');
	
	$risultatoQuery=$connessione->db_getArray(getPreferitiByMoreField($filterField, $filterValue));
	if($risultatoQuery)
	{
		echo '<br/><br/>PREFERITI::getPreferitiByMoreField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>PREFERITI::getCasaByMoreField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//---------------------------
	echo '<br/><br/>----TEST CASA----<br/>';
	
	//TEST CASA::getAllCasa
	$risultatoQuery=$connessione->db_getArray(getAllCasa());
	
	if($risultatoQuery)
	{
		echo '<br/><br/>CASA::getAllCasa - RISULTATO QUERY<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo 'ERRORE CASA::getAllCasa';
	}
	
	
	//TEST CASA::getCasaBy1Field
	$risultatoQuery=$connessione->db_getArray(getCasaBy1Field('provincia', 'Belluno'));
	if($risultatoQuery)
	{
		echo '<br/><br/>CASA::getCasaBy1Field - RISULTATO QUERY<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo 'ERRORE CASA::getCasaBy1Field<br/>';
	}
	
	//TEST CASA::updateCasaByField
	$risultatoQuery=$connessione->db_getBool(updateCasaByField('id_casa', '1', 'tipologia', 'rurale'));
	if($risultatoQuery)
	{
		echo '<br/><br/>CASA::updateCasaByField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>CASA::updateCasaByField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST CASA::deleteCasaByField
	$risultatoQuery=$connessione->db_getBool(deleteCasaByField('id_casa', '1'));
	if($risultatoQuery)
	{
		echo '<br/><br/>CASA::deleteCasaByField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>CASA::deleteCasaByField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
		
	//TEST CASA::insertCasa
	$values=array();
	$values['id_casa']=1;
	$values['provincia']='Belluno';
	$values['citta']='Falcade';
	$values['via']='T. Vecellio';
	$values['civico']=14;
	$values['tipologia']='villa';
	$values['superficie']=150;
	$values['camere']=2;
	$values['bagni']=1;
	$values['parcheggio']='privato';
	$values['giardino']=0;
	$values['piscina']=0;
	$values['patio']=0;
	$values['barbecue']=0;
	$values['angolo_bar']=1;
	$values['idromassaggio']=0;
	$values['terrazzo']=1;
	$values['arredato']=0;
	$values['prezzo']=390000;
	$values['descrizione']='Splendida villetta di recente costruzione, in stile bungalow con ampie vetrate. L’immobile, con giardino privato, è composto su un unico piano, con ingresso, ampia zona giorno, angolo cottura, camera matrimoniale, cameretta e bagno finestrato con vasca idromassaggio. Infissi in triplo vetro, parquet in tutte le zone della casa. Esternamente l’immobile si presenta in stile moderno, con vialetto di accesso.';
	
	$risultatoQuery=$connessione->db_getBool(insertCasa($values));
	if($risultatoQuery)
	{
		echo '<br/><br/>CASA::insertCasa - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>CASA::insertCasa - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST CASA::updateCasaByMoreField
	$newField=array('provincia', 'via');
	$newValue=array('Roma', 'Corso centrale');
	
	$risultatoQuery=$connessione->db_getBool(updateCasaByMoreField('id_casa', 1, $newField, $newValue));
	if($risultatoQuery)
	{
		echo '<br/><br/>CASA::updateCasaByMoreField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>CASA::updateCasaByMoreField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST CASA::getCasaByMoreField
	$filterField=array('provincia', 'via');
	$filterValue=array('Roma', 'Corso centrale');
	
	$risultatoQuery=$connessione->db_getArray(getCasaByMoreField($filterField, $filterValue));
	if($risultatoQuery)
	{
		echo '<br/><br/>CASA::getCasaByMoreField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>CASA::getCasaByMoreField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	//---------------------------
	echo '<br/><br/>----TEST RICHIESTE----<br/>';
	
	//TEST RICHIESTE::getAllRichieste
	$risultatoQuery=$connessione->db_getArray(getAllRichieste());
	
	if($risultatoQuery)
	{
		echo '<br/><br/>RICHIESTE::getAllRichieste - RISULTATO QUERY<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo 'ERRORE RICHIESTE::getAllRichieste';
	}
	
	
	
	//TEST RICHIESTE::getRichiesteByField
	$risultatoQuery=$connessione->db_getArray(getRichiesteByField('username', 'admin'));
	if($risultatoQuery)
	{
		echo '<br/><br/>RICHIESTE::getRichiesteByField - RISULTATO QUERY<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo 'ERRORE RICHIESTE::getRichiesteByField<br/>';
	}
	
	//TEST RICHIESTE::updateRichiesteByField
	$risultatoQuery=$connessione->db_getBool(updateRichiesteByField('username', 'admin', 'richiesta', 'appuntamento?'));
	if($risultatoQuery)
	{
		echo '<br/><br/>RICHIESTE::updateRichiesteByField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>RICHIESTE::updateRichiesteByField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	//TEST RICHIESTE::deleteRichiesteByField
	$risultatoQuery=$connessione->db_getBool(deleteRichiesteByField('id_casa', '1'));
	if($risultatoQuery)
	{
		echo '<br/><br/>RICHIESTE::deleteRichiesteByField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>RICHIESTE::deleteRichiesteByField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
		
	//TEST RICHIESTE::insertRichiesta
	$values=array();
	$values['id_casa']=1;
	$values['username']='user';
	$values['richiesta']='richiesta';
	
	$risultatoQuery=$connessione->db_getBool(insertRichiesta($values));
	if($risultatoQuery)
	{
		echo '<br/><br/>RICHIESTE::insertRichiesta - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>RICHIESTE::insertRichiesta - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST RICHIESTE::updateRichiesteByMoreField
	$newField=array('username', 'richiesta');
	$newValue=array('user', 'Corso centrale');
	
	$risultatoQuery=$connessione->db_getBool(updateRichiesteByMoreField('id_casa', 1, $newField, $newValue));
	if($risultatoQuery)
	{
		echo '<br/><br/>RICHIESTE::updateRichiesteByMoreField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>RICHIESTE::updateRichiesteByMoreField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST RICHIESTE::getRichiesteByMoreField
	$filterField=array('username', 'id_casa');
	$filterValue=array('user', '10');
	
	$risultatoQuery=$connessione->db_getArray(getRichiesteByMoreField($filterField, $filterValue));
	if($risultatoQuery)
	{
		echo '<br/><br/>RICHIESTE::getRichiesteByMoreField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>RICHIESTE::getRichiesteByMoreField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	
	//---------------------------
	echo '<br/><br/>----TEST SOPRALLUOGHI----<br/>';
	
	//TEST SOPRALLUOGHI::getAllSopralluoghi
	$risultatoQuery=$connessione->db_getArray(getAllSopralluoghi());
	
	if($risultatoQuery)
	{
		echo '<br/><br/>SOPRALLUOGHI::getAllSopralluoghi - RISULTATO QUERY<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo 'ERRORE SOPRALLUOGHI::getAllSopralluoghi';
	}
	

	
	//TEST SOPRALLUOGHI::getSopralluoghiByField
	$risultatoQuery=$connessione->db_getArray(getSopralluoghiByField('username', 'admin'));
	if($risultatoQuery)
	{
		echo '<br/><br/>SOPRALLUOGHI::getSopralluoghiByField - RISULTATO QUERY<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo 'ERRORE SOPRALLUOGHI::getSopralluoghiByField<br/>';
	}
		
	//TEST SOPRALLUOGHI::updateSopralluoghiByField
	$risultatoQuery=$connessione->db_getBool(updateSopralluoghiByField('username', 'admin', 'orario', '2020-02-20'));
	if($risultatoQuery)
	{
		echo '<br/><br/>SOPRALLUOGHI::updateSopralluoghiByField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>SOPRALLUOGHI::updateSopralluoghiByField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	
	//TEST SOPRALLUOGHI::deleteSopralluoghiByField
	$risultatoQuery=$connessione->db_getBool(deleteSopralluoghiByField('id_casa', '1'));
	if($risultatoQuery)
	{
		echo '<br/><br/>SOPRALLUOGHI::deleteSopralluoghiByField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>SOPRALLUOGHI::deleteSopralluoghiByField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
		
	//TEST SOPRALLUOGHI::insertSopralluoghi
	$values=array();
	$values['id_casa']=10;
	$values['username']='user';
	$values['orario']='2021-10-03 17:26:27';
	
	$risultatoQuery=$connessione->db_getBool(insertSopralluoghi($values));
	if($risultatoQuery)
	{
		echo '<br/><br/>SOPRALLUOGHI::insertSopralluoghi - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>SOPRALLUOGHI::insertSopralluoghi - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST SOPRALLUOGHI::updateSopralluoghiByMoreField
	$newField=array('username', 'id_casa');
	$newValue=array('user', '2');
	
	$risultatoQuery=$connessione->db_getBool(updateSopralluoghiByMoreField('id_casa', 1, $newField, $newValue));
	if($risultatoQuery)
	{
		echo '<br/><br/>SOPRALLUOGHI::updateSopralluoghiByMoreField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>SOPRALLUOGHI::updateSopralluoghiByMoreField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}
	
	//TEST SOPRALLUOGHI::getSopralluoghiByMoreField
	$filterField=array('username', 'id_casa');
	$filterValue=array('user', '10');
	
	$risultatoQuery=$connessione->db_getArray(getSopralluoghiByMoreField($filterField, $filterValue));
	if($risultatoQuery)
	{
		echo '<br/><br/>SOPRALLUOGHI::getSopralluoghiByMoreField - RISULTATO TRUE<br/>';
		var_dump($risultatoQuery);
	}
	else
	{
		echo '<br/><br/>SOPRALLUOGHI::getSopralluoghiByMoreField - RISULTATO FALSE<br/>';
		var_dump($risultatoQuery);
	}


}
else
{
	echo 'ERRORE connessione DB';
}

$connessione->closeConnection();


