<html>
<head>
	<title>Pagina riservata</title>
</head>
<body>
<?php
	session_start();
	//Se la variabile username è vuota, l'utente non ha effettuato l'accesso
	if(empty($_SESSION["username"])){
		echo "<p>Pagina riservata agli utenti registrati. <br/> Effettua il <a href=\"login.html\">Login</a> oppure <a href=\"registrati.php\">Registrati</a> per continuare</p>";
	}
	else{
		$user = $_SESSION["username"];
		echo "<p> Benvenuto $user!</p>";
	?>
		<p>Questa immagine è visibile solo agli utenti loggati.</p>
		<img src="html.jpg"/>
		<p>
			<a href="logout.php">Logout</a>
		</p>
	<?php
	}
	?>

	
</body>
</html>