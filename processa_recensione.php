<?php

 
  // Ottenere i dati inviati dal form
  $nome = $_POST['nome'];
  $codiceBarca = $_POST['codiceBarca'];
  $recensione = $_POST['recensione'];
  $valutazione = $_POST['valutazione'];

  // compilo la query da inoltrare
      require "db.php";
      $db = pg_connect($connection_string)or die('Impossibile connetersi al database:'.pg_last_error());

       $sql = "select MAX(codice) from recensione";

      $ret = pg_query($db, $sql); //leggo qual'è l'ultimo codice inserito;
      if(!$ret){
        echo "errore nella query <br>".pg_last_error($db);
      }
    $row = pg_fetch_array($ret);
    $cod = $row[0];
    $cod++;
    $sql = "INSERT INTO recensione(codice, descrizione, num_stelle, barca, utente) VALUES ($1,$2,$3,$4,$5)";
     $prep = pg_prepare($db, "postgres", $sql);
      $ret = pg_execute($db, "postgres", array($cod, $recensione, $valutazione, $codiceBarca,$nome));
      if(!$ret){
        echo "errore nella query <br>".pg_last_error($db);
      } else echo "tutto bene recensione arrivata!" ; 

      pg_close($db);



      // Ti rimando sulla pagina che stavi
      header("Refresh: 3; url=page_1.php");
      echo "<br>Reindirizzamento in corso...";
      exit;
?>

