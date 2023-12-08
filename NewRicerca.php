<!DOCTYPE html>

<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="still.css">
    <title>Ricerca barche</title>
    <link rel="icon" type="image/x-icon" href="img/logo1.png">
    <script type="text/javascript" src="effetto_header.js"></script>
    <script type="text/javascript" src="ricerca.js"></script>

  <?php function make_checkboxes ($nameArray, $query, $arrayOptions) {
    foreach ($arrayOptions as $value => $label) {
      printf('<input class="check" type="checkbox" name="%s[]" value="%s" ', $nameArray, $value); /*Funzione per sticky checkbox*/
      if (in_array($value, $query)) { echo "checked "; } //casella spuntata
      echo "> $label <br>\n"; // chiusura tag e LABEL
    }
  } ?>

  <?php function make_radio ($nameArray, $query, $arrayOptions) {
    foreach ($arrayOptions as $value => $label) {
      printf('<input class="check" type="radio" name="%s" value="%s" ', $nameArray, $value);  /*Funzione modificata per i radio,tolgo array*/
      if (($value == $query)) { echo "checked "; } //casella spuntata
      echo "> $label <br>\n"; // chiusura tag e LABEL
    }
  } 
  ?>


  </head>
  <body>

  <?php require "header.php"; ?>

    <?php
    if(!empty($_GET['Tipologia'])){
      $Tipologia = $_GET['Tipologia'];
    }
    /* se e' la prima volta si crea l'array $tipologia  */
    else{
     $Tipologia = array();
    }

    if(!empty($_GET['Valutazione'])){
      $Valutazione = $_GET['Valutazione'];
    }
    /* se e' la prima volta si crea $Valutazione */
    else{
     $Valutazione = 0;
    }
     ?>

    <?php
    $tipi = array(       /* Possibili opzioni per la tipologia*/
      'Motore'    => 'Motore',
      'Catamarano' => 'Catamarano',
      'Yacht'      => 'Yacht',
      'Vela'  => 'Vela'
    );

    $valutazioni = array( /*Possibili valutazioni*/
      '1'  => '1',
      '2'  => '2',
      '3'  => '3',
      '4'  => '4',
      '5'  => '5'
    );

    ?>


    <?php
    //CONNESSIONE
    require "db.php";
    $conn=pg_connect($connection_string) or die('Impossibile connetersi al database: ' .
    pg_last_error());
     ?>
     <div class="MegaContainer">
       <div class="Scelte">
    <form id="parametri" class="Ricerca" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" onsubmit="return controlloValore()">
        <div class="Menu">
          Cerca la barca
        </div>
        <span class="tip">Tipologia</span>
        <span class="checkbox"><?php make_checkboxes('Tipologia', $Tipologia, $tipi); ?></span>
        <hr class="separatore">
        <input id="testo" type="text" class="testo" name="costo" value="<?php if(isset($_GET['costo']) and !empty($_GET['costo']))
         echo $_GET['costo'] ?>" placeholder="Specifica un costo">
         <hr class="separatore">
        <span class="tip">Valutazione</span>
      <div class="Valut">
        <?php make_radio('Valutazione', $Valutazione, $valutazioni); ?>
      </div>
      <hr class="separatore">
        <input class="Cerca" type="submit" name="Cerca" value="Cerca la tua barca">
        <input class="Cerca" type="button" name="Cerca" value="Cancella tutto" onclick="resettaForm(this)">

    </form>
    </div>

    <?php

    if(isset($_GET['last_id']) and !empty($_GET['last_id'])){ //Mi serve per navigare tra le pagine.
     $last_id = $_GET['last_id'];
  }else{
    $last_id=-1;
  }
    //RICERCA IN BASE AI PARAMETRI DEL FORM (PREZZO)
    if(isset($_GET['costo']) and !empty($_GET['costo'])){
     $prezzo = $_GET['costo'];
     $prezzo = intval($prezzo);
     $sql = "SELECT codice,valutazione,costo,tipologia,immagine,immagine2,immagine3,nome FROM barca WHERE costo <= $1 AND codice >= $2";
  }
    else{
    $prezzo = 0;
    $sql = "SELECT codice,valutazione,costo,tipologia,immagine,immagine2,immagine3,nome from barca where costo > $1 AND codice >= $2"; //QUERY CHE FA ALL'INZIO, TI FA VEDERE TUTTE LE BARCHE
  }

    if(isset($_GET['Tipologia']) and !empty($_GET['Tipologia'])){
    $tipologie = $_GET['Tipologia'];
    $condizioni = array(); // Inizializza un array per memorizzare le condizioni
    foreach ($tipologie as $valore) {
     $condizioni[] = "tipologia = '$valore'"; // Aggiungi ogni condizione all'array
}

  $sql2 = implode(' OR ', $condizioni);
  $sql = $sql . " AND " . $sql2 ;
}
if(isset($_GET['Valutazione']) and !empty($_GET['Valutazione'])){
  $val = $_GET['Valutazione'];
  $valutazione = intval($val);
  $sql3 = "valutazione >= $valutazione and valutazione < $valutazione + 1";
  $sql = $sql . " AND " . $sql3;
}

$sql = $sql . " order by codice ";





  $ret = pg_prepare($conn,"Ricerca",$sql);
  if(!$ret) {
    echo pg_last_error($conn);
  }else{
    $res = pg_execute($conn,"Ricerca",array($prezzo,$last_id));
   if(!$res) {
    echo pg_last_error($conn);
  }else{
    $p = pg_prepare($conn,"Pagine",$sql);
    if(!$p){
      echo pg_last_error($conn);
    }else{
      $pag = pg_execute($conn,"Pagine",array($prezzo,-1));
      if(!$pag){
        echo pg_last_error($conn);
      }else{
        $count_pag=pg_num_rows($pag);//CONTA IL NUMERO DI RIGHE RISULTATE DALLA QUERY
        $count=pg_num_rows($res);



    echo "<div class=\"imgs\">";
    if($count == 0){ //SE E' 0 STAMPA UN MESSAGGIO DI ERRORE
      echo "<p class=\"error\">Non ci sono barche che rispettano i parametri</p>";
    }
    else{
      if(!isset($_GET['last_id']) and empty($_GET['last_id'])){ //prima volta che visualizzo
      echo "<p class=\"error\">Barche disponibili : $count</p>";
    }

    if($count < 6){ //VOGLIO MOSTRARE SOLO 6 BARCHE ALLA VOLTA, MA SE COUNT E' MINORE STAMPO SOLO QUELLE
      while($row=pg_fetch_assoc($res)){
        $img1=$row['immagine'];
        $img2=$row['immagine2'];
        $img3=$row['immagine3'];
        $last_id=$row['codice'];
        $prezzo=$row['costo'];
        $tipologia=$row['tipologia'];
        $valutazione=$row['valutazione'];
        $nome = $row['nome'];
        //quando il numero di righe è minore di 6 last_id resta quello di prima quindi anche ricaricando la pagina fa sempre la stessa query.
        echo "<div class=\"single\" onmouseover=scorri(this) onmouseout=hide(this)>";
        echo "<img class=\"img1\" src=img/$img1 alt='immagine non disponibile'>";
        echo "<img class=\"img2\" src=img/$img2 alt='immagine non disponibile'>";
        echo "<img class=\"img3\" src=img/$img3 alt='immagine non disponibile'>";
        echo "<div class=\"skip\" onclick=sfoglia(this)>Next";
        echo "</div>";
        echo "<span class=\"descr\"><a href=\"page_1.php?cod=$last_id\">Vai alla pagina</a><br> Nome:$nome<br> $prezzo.€/giorno.<br> Tipologia: $tipologia <br> Valutazione:$valutazione </span>";
        echo "</div>";
      }
    }else{
      $i=0;
      while($row=pg_fetch_assoc($res) and $i<6){ //ne voglio stampare solo 6 per pagina
        $img1=$row['immagine'];
        $img2=$row['immagine2'];
        $img3=$row['immagine3'];
        $last_id=$row['codice'];
        $prezzo=$row['costo'];
        $tipologia=$row['tipologia'];
        $valutazione=$row['valutazione'];
        $nome = $row['nome'];
        echo "<div class=\"single\" onmouseover=scorri(this) onmouseout=hide(this)>";
        echo "<img class=\"img1\" src=img/$img1 alt='immagine non disponibile'>";
        echo "<img class=\"img2\" src=img/$img2 alt='immagine non disponibile'>";
        echo "<img class=\"img3\" src=img/$img3 alt='immagine non disponibile'>";
        echo "<div class=\"skip\" onclick=sfoglia(this)>Next";
        echo "</div>";
        echo "<span class=\"descr\"><a href=\"page_1.php?cod=$last_id\">Vai alla pagina</a><br> Nome:$nome<br> $prezzo.€/giorno.<br> Tipologia: $tipologia <br> Valutazione:$valutazione </span>";
        echo "</div>";
          $i++;
      }
    }
    echo "</div>";
  }
}
}
}
}

       ?>

  </div>



<?php

//Con la query che ogni volta mi restituisce tutte le righe desiderate creo i numeri per viaggiare tra le Pagine
//sfrutto questi numeri, che stampo ogni 6 immagini, per collegare anche l'id nel link associato in modo
//che sia la pagina successiva che quella precedente abbiano $last_id dell'ultima immagine caricata
//questo funziona in modo fisso in quanto riesegue il calcolo ogni volta sul totale delle righe, cosi' abbiamo link fiss
//che permettono di eseguire la query giusta passando il last_id giusto.
$i=0;
$c=0;
$a=1;
if($count_pag>6){ //STAMPO LA NAVIGAZIONE DELLE PAGINE SOLO SE IL NUMERO DI RISULTATI E' > 6.
  echo "<div class=\"ProssimaPagina\">";
for($i=0;$i<$count_pag;$i++){
  $pagine=pg_fetch_assoc($pag);
  $c++;
  if($c==6 || $i==0){
    if (isset($_SERVER['QUERY_STRING'])) {
        $queryString = $_SERVER['QUERY_STRING'];
        $queryParams = $_GET; // Copia tutti i parametri GET in un array
        unset($queryParams['last_id']); // Rimuovi il campo "last_id" dalla queryString
        $queryString = http_build_query($queryParams);}//costruisco la nuova query string
    $last_id = $pagine['codice'];
  echo '<div class="numbers"><a id="linkz" href="' . $_SERVER['PHP_SELF'] . '?last_id=' . $last_id . '&' . $queryString . '"> ' . $a . ' </a></div>';

  $c=0;
  $a++;
}
}
}

echo "</div>";
pg_close($conn);
?>



<?php require "footer.php"; ?>
  </body>
</html>
