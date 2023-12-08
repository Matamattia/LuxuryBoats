<!DOCTYPE html>
<html>
<head>
  <title>Le mie barche</title>
  <link rel="stylesheet" href="stylebarche1.css">
  <link rel="icon" type="image/x-icon" href="img/logo1.png">
  <script type="text/javascript" src="effetto_header.js"></script>
  <script type="text/javascript" src="barche.js"></script>
</head>
<body onload="reset()">
  <?php
    session_start();

    if(empty($_SESSION["username"])){
      echo "<p>Devi essere loggato per vedere questa sezione!</p>";
      echo "<p><a href=\"login.php\">Torna al login</a></p>";
      exit;
  }
  $user = $_SESSION["username"];
  require "db.php";
  $db = pg_connect($connection_string) or die('Impossibile connettersi al database: ' . pg_last_error());
  

        if (isset($_POST['disponibile'])){
          $disp = $_POST['disponibile'];
          $nasc = $_POST['codice'];
            if($disp==1){
              $sql6="UPDATE barca set disponibilita=true where codice=$nasc";
              $ret6=pg_query($db,$sql6);
              $cod = pg_fetch_assoc($ret6);
            }else {
              $sql6="UPDATE barca set disponibilita=false where codice=$nasc";
              $ret6=pg_query($db,$sql6);
              $cod = pg_fetch_assoc($ret6);
            }
        }
        
        if (isset($_POST['hiddenValue'])){
          $hiddenValue = $_POST['hiddenValue'];
          $hiddenCode = $_POST['hiddenCode'];

        if($hiddenValue==1){
          $sql6="DELETE FROM barca WHERE codice = $hiddenCode;";
          $ret6=pg_query($db,$sql6);
              
          }
        }

      $sql3="SELECT codice from barca order by codice desc limit 1";
      $ret3=pg_query($db,$sql3);
      $cod = pg_fetch_assoc($ret3);
      $codice = $cod['codice']+1; //Abbiamo gestito l'insrimento automatico del codice per semplicità dall'applicazione,avremmo potuto fare una vista nel database.

      if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['nomeBarca'])){
          $nome = $_POST['nomeBarca'];


      $sql = "INSERT INTO barca (nome, tipologia, descrizione, costo, disponibilita, codice, immagine, immagine2, immagine3, valutazione,lunghezza,posti)
        VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10,$11,$12)";
      $prep = pg_prepare($db, "insertBoat", $sql);
      $ret = pg_execute($db, "insertBoat", array($_POST['nomeBarca'], $_POST['tipologiaBarca'], $_POST['descrizioneBarca'], $_POST['costoBarca'], true, $codice, $_POST['imm1'], $_POST['imm2'], $_POST['imm3'], null,$_POST['lunghezzaBarca'],$_POST['postiLetto']));
      if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
      } else {
        $sql2 = "INSERT INTO possiede (barca,proprietario)
         VALUES ($1, $2)";
         $prep2 = pg_prepare($db, "Boat", $sql2);
         $ret2 = pg_execute($db, "Boat", array($codice, $user));
         if (!$ret2) {
           echo "ERRORE QUERY: " . pg_last_error($db);
         } else {
           echo "Barca registrata con successo!";
         }

      }
    }

    }
    
$sql4="SELECT count(*) from possiede where proprietario='$user' ";
  $ret4=pg_query($db,$sql4);
  $co = pg_fetch_row($ret4);
  $count = $co[0];
    ?>

    <header id="main-header">
    
      <img class="logo" src="img/logo.png" alt="logo...">

    
    <nav>
      <ul class="content">
        <li ><a href="home.php">home</a></li>
        <li ><a href="NewRicerca.php">ricerca</a></li>

        <?php 
          if( !strpos($_SERVER['PHP_SELF'],'login.php') and  !strpos($_SERVER['PHP_SELF'],'registrati.php')){
            echo "<li ><a href=\"#section1\">contatti</a></li>";
          }
        ?>
        
        <?php
          
            echo "<li ><a href='lemiebarche.php'>le mie barche</a></li>";
            echo "<li ><a href=\"logout-2.php\">logout</a></li>";
            $user1 = explode('@',$_SESSION["username"] );
            echo "<li class='usern' >$user1[0]</li>";
        ?>
        
      </ul>
    </nav>
  </header>

<h1 >Le mie barche</h1>
<?php echo "<p>Ciao $user, hai $count barche registrate.</p>"; ?>
<h2>Elenco delle barche registrate: </h2>

<div class="boat-list">

   <?php
    $db = pg_connect($connection_string) or die('Impossibile connettersi al database: ' . pg_last_error());
      $query = "SELECT nome,disponibilita, tipologia, descrizione, costo, immagine, immagine2, immagine3, codice FROM barca join possiede on codice=barca where proprietario='$user' ";
      $result = pg_query($db, $query);
      if (!$result) {
        echo "Errore nella query: " . pg_last_error($db);
      } else {
        while ($row = pg_fetch_assoc($result)) {
          $disp=$row['disponibilita'];
          $codice = $row['codice'];
          $immagine = $row['immagine'];
          echo "<div class= element>
                  <img src='img/$immagine'>
                  <div class=\"info\">
                  <h3 >".$row['nome']."</h3>
                  <p><strong>Nome barca:</strong> ".$row['nome']."</p>
                  <p><strong>Tipologia:</strong> ".$row['tipologia']."</p>
                  <p><strong>Descrizione:</strong> ".$row['descrizione']."</p>
                  <p><strong>Costo:</strong> ".$row['costo']."€/giorno</p>";
                  echo "<button class='removeBoat' onclick=\"removeBoat(this)\" id='$codice'>Rimuovi barca</button>";
                if($disp=='f'){
                echo "<label for=$codice>non disponibile<input type=\"radio\" id=$codice name=$codice value=0 checked onclick=\"cambia(this)\" ></label> ";
                echo "<label for=$codice>disponibile<input type=\"radio\" id=$codice name=$codice value=1 onclick=\"cambia(this)\" ></label> ";
              }
              else{
                echo "<label for=$codice>non disponibile<input type=\"radio\" id=$codice name=$codice value=0 onclick=\"cambia(this)\" ></label> ";
                echo "<label for=$codice>disponibile<input type=\"radio\" id=$codice name=$codice value=1 checked onclick=\"cambia(this)\"></label> ";
              }
                  echo "</div>";
                echo "</div>";

        }

      }


   ?>

<form id="dispo" class="dispo"  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
  <input id="nascosto" type="hidden" name="disponibile" value="0">
  <input id="nascosto1" type="hidden" name="codice" value="0">
  <input id="hiddenValue" type="hidden" name="hiddenValue" value="0">
  <input id="hiddenCode" type="hidden" name="hiddenCode" value="0">
</form> 

<script type="text/javascript">
  function cambia(check){

    document.getElementById('nascosto1').value = check.id;
    if (check.value == 1){
      document.getElementById('nascosto').value=1;
    }else{
      document.getElementById('nascosto').value=0;
    }
    document.getElementById('dispo').submit();
  }
</script>

</div>

   <button id="addBoatButton">Aggiungi una nuova barca</button>

  <div class="new-boat-form">
    <h2 >Registra una nuova barca:</h2>
    <form id="newBoatForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <div>
        <label for="nomeBarca">Nome barca:</label>
        <input type="text" id="nomeBarca" name="nomeBarca" onchange="checkName(this)" required
        placeholder="Max 50 caratteri">
     </div>
    <div>
      <label for="tipologiaBarca">Tipo barca:</label>
      <select class="tipologiaBarca" name="tipologiaBarca" id="tipologiaBarca" required>
        <option value="Catamarano">Catamarano</option>
        <option value="Motore">Motore</option>
        <option value="Vela">Vela</option>
        <option value="Yacht">Yacht</option>
      </select>
    </div>
    <div>

      <label for="descrizioneBarca">Descrizione barca:</label><br>
    <textarea id="descrizioneBarca" name="descrizioneBarca" rows="4" cols="50" onchange="checkDesc(this)" required></textarea><br><br>
    </div>
    <div>
      <label for="costoBarca">Costo noleggio giornaliero:</label>
      <input type="text" id="costoBarca" name="costoBarca" onchange="checkNumbers(this)" required placeholder="Inserisci il prezzo della barca">
    </div>
    <label for="lunghezzaBarca">Lunghezza barca:</label>
    <input type="text" name="lunghezzaBarca" onchange="checkNumbers(this)" required placeholder="Inserisci un numero che indica la lunghezza">
    <label for="posti">Posti letto:</label>
    <input type="text" name="postiLetto" onchange="checkNumbers(this)" required placeholder="Inserisci il numero di posti letto">
    <div>
      <label for="imm1">Immagine1:</label>
      <input type="file" id="imm1" name="imm1" required>
    </div>
    <div>
      <label for="imm2">Immagine2:</label>
      <input type="file" id="imm2" name="imm2" required>
    </div>
    <div>
      <label for="imm3">Immagine3:</label>
      <input type="file" id="imm3" name="imm3" required>
    </div>
      <div>
        <input type="submit" name="invia" value="Registra"/>
     </div>
      <div id="error-message" class="error-message"> </div>
    </form>

  </div>

  <?php require "footer.php"; ?>
</body>
</html>
