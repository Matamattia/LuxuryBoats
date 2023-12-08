<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dettagli barca</title>
  <link rel="icon" type="image/x-icon" href="img/logo1.png">
  <link rel="stylesheet" href="style1.css">
  <link rel="stylesheet" type="text/css" href="default.css">
  <script type="text/javascript" src="singola_barca.js"></script>
  <script type="text/javascript" src="effetto_header.js"></script>
</head>


<body>
  <!-- Header del sito -->
  <?php require "header.php"; ?>


    <!-- Mi collego al DB --> 

  <?php
  if(isset($_GET['cod']) and !empty($_GET['cod'])){
    $codice = $_GET['cod'];
   }else{
    $codice = 1;//nel caso si cerca di accedere trmite un link
   }
      require "db.php";
      $db = pg_connect($connection_string)or die('Impossibile connetersi al database:'.pg_last_error());
      $sql = "SELECT descrizione, tipologia, costo, disponibilita,nome,immagine,immagine2,immagine3,lunghezza,posti FROM barca where codice = $codice";
      $ret = pg_query($db, $sql);
        if(!$ret) echo "Qualcosa è andato storto!";


  $row = pg_fetch_array($ret);
  $nome_barca = $row['nome'];
  $descrizione_barca = $row['descrizione'];
  $tipologia_barca = $row['tipologia'];
  $costo_giornaliero = $row['costo'];
  $disponibilita_barca = $row['disponibilita'];
   // PRENDO IMMAGINE DA DB
  $immagine_barca_1 = $row['immagine'];
  $immagine_barca_2 = $row['immagine2'];
  $immagine_barca_3 = $row['immagine3'];
  $lunghezza = $row['lunghezza'];
  $posti = $row['posti'];
  $sql1 = "SELECT num_tel from proprietario inner join possiede on(proprietario.email = possiede.proprietario) where possiede.barca = $codice";
  $ret1 = pg_query($db,$sql1);
  $row1 = pg_fetch_array($ret1);
  $num_telefono = $row1[0];
    ?>
  <!-- Contenuto principale --> 

  <!-- griglia immagini --> 

<div class="container-img">
  <div class="box">
   <?php echo "<img src=\"img/$immagine_barca_1\" alt='Sample photo'>"; ?>
 </div><div class="box">
    <?php echo "<img src=\"img/$immagine_barca_2\" alt='Sample photo'>"; ?>
  </div> <div class="box">
   <?php echo "<img src=\"img/$immagine_barca_3\" alt='Sample photo'>"; ?>
 </div>

</div>
<!-- fine immagini -->

<div class="container-body">

    <h2> Descrizione</h2>
    <?php
    echo "<p> $descrizione_barca </p> "; 
    ?>
  <hr>
    <h2> Informazioni: </h2>
    <ul>
  <li>Tipologia di barca: <?php echo $tipologia_barca; ?></li>
  <li>Lunghezza: <?php echo $lunghezza?>m </li>
  <li> Posti letto: <?php echo $posti;?> </li>


  <li> Disponibilità Barca : <?php 
  if($disponibilita_barca === 't')
  echo '<h5 style=" display:inline;color: #00FF00;"> Imbarcazione disponibile </h5> ' ;
  else echo '<h5 style="display:inline;color: #ff0000;"> Imbarcazione non disponibile </h5>';
    ?> 

 </li>
</ul>
<hr>
    <h2> Prezzo </h2>
    <?php echo "Questa Barca ha un costo € $costo_giornaliero  al giorno ";
    echo "<br>"; 
            $pippo = " <button onclick=\"chiamaProprietario()\" class=\"prenota-bottone\">Chiama il proprietario! </button>
        <script type=\"text/javascript\">
          function chiamaProprietario(){
            window.location.href =\"tel:$num_telefono\" ; 
          }
        </script>" ;
        echo $pippo ; 
      ?>



<br>
<hr>
</div>

<h2> Dicci cosa ne pensi di questa barca! </h2>

  <form action="processa_recensione.php" method="POST" onsubmit="return check()">
    <label>Email:</label>
    <input type="email" id="nome" name="nome" required><br><br>
    <input type="hidden"  id="codiceBarca" name="codiceBarca" value= <?php echo $codice; ?> >

    <label>Recensione:</label><br>
    <textarea id="recensione" name="recensione" rows="4" cols="50"  required></textarea><br><br><!-- maxlength="300" può essere utilizzato nel tag textarea per la dim max(ora però usiamo js)-->
    <label for="valutazione">Valutazione:</label>
    <select id="valutazione" name="valutazione" required>
      <option value="">Seleziona una valutazione</option>
      <option value="1">1 stella</option>
      <option value="2">2 stelle</option>
      <option value="3">3 stelle</option>
      <option value="4">4 stelle</option>
      <option value="5">5 stelle</option>
    </select><br><br>

    <input class="prenota-bottone" type="submit" value="Invia Recensione"  required>
  </form>

  

  <?php require "footer.php"; ?>
  <!-- Footer del sito -->
<?php ?>
</body>
</html>