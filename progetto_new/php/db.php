<?php
namespace DB;

class DBAccess{
	private const HOST_DB = "127.0.0.1";
	private const DATABASE_NAME = "nalberti";
	private const USERNAME = "nalberti";
	private const PASSWORD = "eX2iu4ooThae0oz1";

	private $connection;
	
	//APRE CONNESSIONE CON DB
	public function openDBConnection(){
		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
	
		if(mysqli_connect_errno($this->connection))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	//CHIUDE CONNESSIONE CON DB
	public function closeConnection(){
		mysqli_close($this->connection);
	}
	
	//RESTITUISCE ARRAY RISULTATO DELLA QUERY IN $stringaQuery
	public function db_getArray($stringaQuery){
		$queryResult=mysqli_query($this->connection, $stringaQuery) or die ('Errore in db_getArray: '.mysqli_error($this->connection));
		
		if(mysqli_num_rows($queryResult) == 0)
		{
			return null;
		}
		else
		{
			$result = array();
			while($row=mysqli_fetch_assoc($queryResult))
			{
				array_push($result, $row);
			}
		$queryResult->free();
		return $result;
		}
	}
	
	//RESTITUISCE ARRAY RISULTATO DELLA QUERY IN $stringaQuery
	public function db_getBool($stringaQuery){
		$queryResult=mysqli_query($this->connection, $stringaQuery) or die ('Errore in db_getArray: '.mysqli_error($this->connection));
		
		if(mysqli_affected_rows($this->connection)>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}

?>