<?php
namespace DB;
require_once "functions/importModules.php";
require_once "functions/lib_sessioni.php";
require_once "model/preferiti.php";
require_once "model/login.php";
$import = new \importModules();

$output = file_get_contents("../html/area_riservata.html");

if(is_logged()){
      $output = $import->importEverythingOnline($output);
      //<a href="dettagli.php?id_casa="     "><img src="../media/immaginiCase/1/temp.jpeg" class="preview_casa"></a>

      $connect = new DBAccess();
      $connect->openDBConnection();
      $informazioni = $connect->db_getArray(getLoginByField("username", $_SESSION['user']));
      $preferiti = $connect->db_getArray(getPreferitiByField("username",$_SESSION['user']));
      
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

      if(is_admin()){
            $richieste = $connect->db_getArray('SELECT * FROM richieste');
      }   
      else{
            $richieste = $connect->db_getArray('SELECT * FROM richieste WHERE username LIKE "'.$_SESSION['user'].'"');
      }
      
      if(isset($richieste)){
            if(is_admin()){                  
                  $table_richieste = '<table><thead>
                  <tr>
                        <th scope="col">Id casa</th>
                        <th scope="col">Username</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Richiesta</th>
                        <th scope="col">Orario</th>
                        <th scope="col">Rimuovi</th>
                  </tr></thead>';
                  foreach($richieste as $richiesta){
                        $informazioni_utente = $connect->db_getArray(getLoginByField("username", $richiesta["username"]));
                        $table_richieste .= "<tbody><tr><td>". $richiesta["id_casa"] ."</td>";
                        $table_richieste .= "<td>". $richiesta["username"] ."</td>";
                        $table_richieste .= "<td>". $informazioni_utente[0]["mail"] ."</td>";
                        $table_richieste .= "<td>". $richiesta["richiesta"] ."</td>";
                        $table_richieste .= "<td><time>". $richiesta["orario"] ."</time></td>";
                        $table_richieste .= '<td><a href="post_richiesta.php?azione=delete&id_casa='.$richiesta["id_casa"].'&username='. $richiesta["username"] .'">Rimuovi</a></td></tr></tbody>';
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
                        $table_richieste .= '<th><a href="post_richiesta.php?azione=delete&id_casa='.$richiesta["id_casa"].'&username='. $richiesta["username"] .'">Rimuovi</a></th></tr>';
                  }
                  $table_richieste .= "</table>";

                  
            }
            $output = str_replace('<div id="lista_richieste"></div>', $table_richieste, $output );
           
      }    

      if(is_admin()){
            
            $opzioni_admin = file_get_contents("../html/modules/opzioni_admin.html");
      }
      else{
            $opzioni_admin = "";
      }
      $output = str_replace('<section id="opzioni_admin"></section>',$opzioni_admin,$output);
}
else{
    header("location: home.php");
}
$output = str_replace('href="area_riservata.php"','', $output);
echo($output);

$connect->closeConnection();
?>