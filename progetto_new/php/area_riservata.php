<?php
require_once "functions/importModules.php";
require_once "functions/db.php";
require_once "functions/preferiti.php";
require_once "functions/login.php";

session_start();

$output = file_get_contents("../html/area_riservata.html");

if(isset($_SESSION['username'])){
      $output = importModules::importEverythingOnline($output);
      //<a href="dettagli.php?id_casa="     "><img src="../media/immaginiCase/1/temp.jpeg" class="preview_casa"></a>

      $connect = new DBAccess();
      $connect->openDBConnection();
      $informazioni = $connect->db_getArray(getLoginByField("username", $_SESSION['username']));
      $preferiti = $connect->db_getArray(getPreferitiByField("username",$_SESSION['username']));
      
      
      $temp = "";

      if(isset($preferiti)){
            foreach($preferiti as $casa){
                  $temp .= '<a href="dettagli.php?id_casa='.$casa["id_casa"].'" class="link">'.'<img src="../media/immaginiCase/'.$casa["id_casa"].'/'.$casa["id_casa"].'a.jpeg" class="preview_casa"></a>';
            }      
            $output = str_replace('<div id="lista_preferiti"></div>', '<div id="lista_preferiti">'.$temp.'</div>', $output);   
      }  
      
      $output = str_replace('<span id="info_username"></span>', '<span id="info_username">' .$informazioni[0]["username"]. '</span>',$output);
      $output = str_replace('<span id="info_nome"></span>', '<span id="info_nome">' .$informazioni[0]["nome"]. '</span>',$output);
      $output = str_replace('<span id="info_cognome"></span>', '<span id="info_cognome">' .$informazioni[0]["cognome"]. '</span>',$output);
      $output = str_replace('<span id="info_email"></span>', '<span id="info_email">' .$informazioni[0]["mail"]. '</span>',$output);
      $output = str_replace('<span id="info_telefono"></span>', '<span id="info_telefono">' .$informazioni[0]["numero_telefono"]. '</span>',$output);

      if(isset($_SESSION["isAdmin"])){
            $richieste = $connect->db_getArray('SELECT * FROM richieste');
      }   
      else{
            $richieste = $connect->db_getArray('SELECT * FROM richieste WHERE username LIKE "'.$_SESSION['username'].'"');
      }
      

      if(isset($richieste)){
            if(isset($_SESSION["isAdmin"])){                  
                  $table_richieste = "<table>
                  <tr>
                  <th>Id_casa</th>
                  <th>Username</th>
                  <th>E-Mail</th>
                  <th>Richiesta</th>
                  <th>Orario</th>
                  <th>Rimuovi</th>
                  </tr>";
                  foreach($richieste as $richiesta){
                        $informazioni_utente = $connect->db_getArray(getLoginByField("username", $richiesta["username"]));
                        $table_richieste .= "<tr><th>". $richiesta["id_casa"] ."</th>";
                        $table_richieste .= "<th>". $richiesta["username"] ."</th>";
                        $table_richieste .= "<th>". $informazioni_utente[0]["mail"] ."</th>";
                        $table_richieste .= "<th>". $richiesta["richiesta"] ."</th>";
                        $table_richieste .= "<th>". $richiesta["orario"] ."</th>";
                        $table_richieste .= '<th><a href="rimuovi_richiesta.php?id_casa='.$richiesta["id_casa"].'&username='. $richiesta["username"] .'">Rimuovi</a></th></tr>';
                  }
                  $table_richieste .= "</table>";
            }
            else{
                  $table_richieste = "<table>
                  <tr>
                  <th>Richiesta</th>
                  <th>Orario</th>
                  <th>Rimuovi</th>
                  </tr>";
                  foreach($richieste as $richiesta){
                        $table_richieste .= "<th>". $richiesta["richiesta"] ."</th>";
                        $table_richieste .= "<th>". $richiesta["orario"] ."</th>";
                        $table_richieste .= '<th><a href="rimuovi_richiesta.php?id_casa='.$richiesta["id_casa"].'&username='. $richiesta["username"] .'">Rimuovi</a></th></tr>';
                  }
                  $table_richieste .= "</table>";
            }

            $output = str_replace('<div id="lista_richieste"></div>', $table_richieste, $output );
      }
    
}
else{
    header("location: home.php");
}

echo($output);

$connect->closeConnection();
?>