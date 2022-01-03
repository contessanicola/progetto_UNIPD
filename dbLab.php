<?php

setlocale(LC_TIME, "it_IT");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use mysqli;

class DBAccess
{
    private const HOST_DB = "127.0.0.1"; //Utilizzare sempre il localhost, così è facilmente portabile
    private const DATABASE_NAME = "nalberti";
    private const USERNAME = "nalberti";
    private const PASSWORD = "eX2iu4ooThae0oz1";
    private $connection;

    public function openDBconnection()
    {
        $this->connection = mysqli_connect(static::HOST_DB, static::USERNAME, static::PASSWORD, static::DATABASE_NAME);
        if (!mysqli_connect_errno($this->connection))
            return true;
        else {
            $_SESSION['error'] = "Connection to database failed.";
            return false;
        }
    }
    public function closeConnection()
    {
        mysqli_close($this->connection);
    }
    // Funzione per ritornare la query che verrà inserita come array che utilizza, al posto del numero di indice, il nome dei campi della query
    private function toRetrieve($query)
    {
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Funzione per evitare SQL Injection
    private function escape($string)
    {
        return mysqli_real_escape_string($this->connection, $string);
    }
    // Da usare nel caso di admin diversi da quello preimpostato (admin, admin) 
    // TODO: Inserire funzione di hash durante registrazione
    public function insertAdmin($username, $password, $nome, $cognome, $mail, $telefono)
    {
        $query = 'INSERT INTO login (username, password, nome, cognome, mail, numero_telefono, isAdmin) VALUES ("' .
            $this->escape($username) . '", "' .
            $this->escape(password_hash($password, PASSWORD_DEFAULT)) .
            $this->escape($nome) . '", "' .
            $this->escape($cognome) . '", "' .
            $this->escape($mail) . '", "' .
            $this->escape($telefono) . '", "' .
            "TRUE " . '")';
        return mysqli_query($this->connection, $query);
    }
    // Previsto login sia con username sia con email
    public function adminLogin($username, $email, $password)
    {
        if (($username != NULL && $email == NULL) || ($username == NULL && $email != NULL)) {
            $query = 'SELECT password FROM login WHERE ' . 'username = "' . $this->escape($username) . '"';
            $result = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection)); //Togliere die una volta finito
            $dbRequest = mysqli_fetch_row($result);
            return password_verify($password, $dbRequest[0]);
        }
    }
    public function insertHouse($id, $provincia, $citta, $via, $civico, $tipo, $superficie, $camere, $bagni, $parcheggio, $giardino, $piscina, $patio, $barbecue, $angolo_bar, $idromassaggio, $terrazzo, $arredato, $prezzo, $descrizione)
    {
        $query = 'INSERT INTO lista_case (id_casa, provincia, citta, via, civico, tipo, superficie, camere, bagni, parcheggio, giardino, piscina, patio, barbecue, angolo_bar, idromassaggio, terrazzo, arredato, prezzo, descrizione) VALUES ("' .
            $this->escape($id) . '", "' .
            $this->escape($provincia) . '", "' .
            $this->escape($citta) . '", "' .
            $this->escape($via) . '", "' .
            $this->escape($civico) . '", "' .
            $this->escape($tipo) . '", "' .
            $this->escape($superficie) . '", "' .
            $this->escape($camere) . '", "' .
            $this->escape($bagni) . '", "' .
            $this->escape($parcheggio) . '", "' .
            $this->escape($giardino) . '", "' .
            $this->escape($piscina) . '", "' .
            $this->escape($patio) . '", "' .
            $this->escape($barbecue) . '", "' .
            $this->escape($angolo_bar) . '", "' .
            $this->escape($idromassaggio) . '", "' .
            $this->escape($terrazzo) . '", "' .
            $this->escape($arredato) . '", "' .
            $this->escape($prezzo) . '", "' .
            $this->escape($descrizione) . '")';
        return mysqli_query($this->connection, $query);
    }
    public function getHouseList()
    {
        $this->toRetrieve('SELECT * FROM lista_case');
    }

    public function deleteHouse($id)
    {
        $query = 'DELETE FROM lista_case WHERE id_casa = "' . $this->escape($id) . '"';
        return mysqli_query($this->connection, $query) === true; // Per confermare direttamente, evitando blocco DB.
    }
}
?>
