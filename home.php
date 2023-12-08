<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<link rel="icon" type="image/x-icon" href="img/logo1.png">
	<link rel="stylesheet" href="style_home.css">
	<link rel="stylesheet" type="text/css" href="default.css">
	<script type="text/javascript" src="stars.js"></script>
	<script type="text/javascript" src="effetto_header.js"></script>
	<script type="text/javascript" src="more.js"></script>
</head>
<body onload="numStars();">
	
		<?php 
			require "db.php";
			$db = pg_connect($connection_string)or die('Impossibile connetersi al database:'.pg_last_error());
		?>
	<?php require "header.php"; ?>
	<main>
			<div class="copertina">

			<?php 
			if(!empty($_SESSION["username"])){
			 echo "<div class=\"dati\" style=\"font-weight:bold;font-size:30px;\">";
				$email = $_SESSION['username'];
				$sql1 = "SELECT nome,cognome FROM proprietario where email = '$email'";
				$ret1 = pg_query($db,$sql1);
				$row1 = pg_fetch_row($ret1);
				echo "ciao <span style=\"color:#483D8B;\">$row1[0] $row1[1]</span>";
				echo "</div>";
			}
			 ?>	
			<div class="immagini">
				<div class="titolo_immagini"><h1><span style="color:#483D8B;">Barca</span> più votata</h1></div>
				
			<?php
				
			$sql = "SELECT immagine,codice FROM barca WHERE valutazione = (SELECT MAX(valutazione) FROM barca)";
			$ret = pg_query($db,$sql);
			while($row = pg_fetch_row($ret)){
				echo "<a href=\"page_1.php?cod=$row[1]\"><img  src='img/$row[0]' alt='foto barche'></a>";
			}
			?>
			
			</div>
			 
			 	
			 
			</div>
		
		<div class="titolo">
			<h2><span style="color:#483D8B;">Tipologia</span> di barche</h2>
		</div>
		
		<div class="tipologia">
			
			<?php
			$sql = $sql = "SELECT distinct tipologia FROM barca";
			$ret = pg_query($db,$sql);
			while ($row = pg_fetch_row($ret)){
				if($row[0] == 'Motore'){
					echo "<a href='NewRicerca.php?Tipologia%5B%5D=Motore'><img src='img/barca_a_motore.png' class='tipologia_1'></a>";
				}elseif($row[0] == 'Catamarano'){
					echo "<a href='NewRicerca.php?Tipologia%5B%5D=Catamarano'><img src='img/catamarano.png' alt='immagine non disponibile' class='tipologia_2'></a>";
				}elseif($row[0] == 'Vela'){
					echo "<a href='NewRicerca.php?Tipologia%5B%5D=Vela'><img src='img/vela.png' class='tipologia_3'></a>";
				}else{
					echo "<a href='NewRicerca.php?Tipologia%5B%5D=Yacht'><img src='img/yacht.png' class='tipologia_3'></a>";
				}
			}
			?>
		</div>

		<div class="titolo"><h2>Le nostre <span style="color:#483D8B;">destinazioni</span> preferite</h2></div>
		<div class="destinazione">
			<div class="destcol" >
			<!--	<div style="position: relative;">
    <img src="fiordo.png" alt="errore" style="width: 450px; height: 350px;">
    <div style="position: absolute; top: 70%; left: 30%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: white; padding: 10px;">
      Testo sovrapposto sull'immagine
    </div>
  </div>-->
  			<img src="img/fiordo.png" alt="errore" style="width: 450px; height: 350px;">
				<div class="more" id="marini" onclick="handlerClickMore(this)">Vedi più</div>
				<div id="descrizione1" style="display: none;">Il Fiordo di Furore è un canyon marino profondo e stretto che si apre tra due imponenti pareti di roccia. L'ambiente circostante è caratterizzato da scogliere a strapiombo, ricoperte di vegetazione lussureggiante, che si ergono maestose sopra il mare turchese. Questo scenario crea un contrasto spettacolare tra le pareti verticali di pietra e le acque cristalline sottostanti.</div>

				<div class="meno" id="1" onclick="handlerClickMeno(this)" style="display: none;">Vedi meno</div>
			</div>
			<div class="destcol" >
				<img src="img/positano.png" alt="errore">
				<div class="more" id="praiano" onclick="handlerClickMore(this)">Vedi più</div>
				<div id="descrizione2" style="display: none;">Positano è caratterizzata da una posizione unica e suggestiva, con le sue case colorate che si arrampicano sulle ripide colline che si affacciano sul Mar Tirreno. L'architettura tradizionale è dominata dalle casette color pastello, dalle cupole di tegole rosse delle chiese e dalle scalinate in pietra che si intrecciano tra le viuzze strette. Questa combinazione crea un'atmosfera romantica e suggestiva.</div>
				<div class="meno" id="2" onclick="handlerClickMeno(this)" style="display: none;">Vedi meno</div>
			</div>
			<div class="destcol" >
				<img src="img/amalfi.png" alt="errore">
				<div class="more" id="amalfi" onclick="handlerClickMore(this)">Vedi più</div>
				<div id="descrizione3" style="display: none;">Amalfi è una pittoresca città situata sulla costa sud-occidentale dell'Italia, nella regione della Campania. È una delle località più famose e affascinanti della Costiera Amalfitana, riconosciuta come Patrimonio dell'Umanità dell'UNESCO.Amalfi è rinomata per la sua bellezza naturale, le sue acque cristalline e i suoi paesaggi mozzafiato. La città è incastonata tra ripide scogliere e colline lussureggianti, offrendo viste panoramiche incredibili sull'azzurro Mar Tirreno.</div>
				<div class="meno" id="3" onclick="handlerClickMeno(this)" style="display: none;">Vedi meno</div>
			</div>
		</div>
		<hr/>
		<div class="titolo"><h2 >Cosa <span style="color:#483D8B;">dicono</span> di noi</h2></div>
		
		<div class="recensione">
			<?php
			$sql = "SELECT * FROM recensione order by codice desc limit 5";/*in modo tale che escono le recensioni più recenti*/
			$ret = pg_query($db,$sql);
			$i=1;
			while($row = pg_fetch_row($ret)){
				echo "<div class ='$i'>";
				echo "<p class = 'stars' >$row[2]</p>";
				$array = explode('@', $row[4]);//così prendo il nome
				echo "<p class='name'>$array[0]</p>";
				echo "<p class='text'>$row[1]<br><a href=\"page_1.php?cod=$row[3]\">clicca qui</a></p>";
				echo "</div>";
				$i = $i+1;

			}
			pg_close($db);
		?>

		</div>

	</main>

	<?php require "footer.php"; ?>
</body>
</html>
