<?php
	$errorMessage = ""; // Variabile per memorizzare i messaggi di errore

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Controllo se il form è stato inviato
		$user = $_POST['username'];
		$pass = $_POST['password'];

		if (empty($user) || empty($pass)) {
			$errorMessage = "ERRORE: Username o password non inseriti.";
		} else {
			// Resto del codice per il controllo dell'utente e la gestione del login

			// Esempio di controllo dell'email
			if (!filter_var($user, FILTER_VALIDATE_EMAIL)) {
				$errorMessage = "ERRORE: Inserisci un indirizzo email valido.";
			} else {
				$hash = get_pwd($user);
				if (!$hash) {
					$errorMessage = "L'utente $user non esiste.";
				} else {
					if (password_verify($pass, $hash)) {
						// Login eseguito con successo
						session_start();
						$_SESSION['username'] = $user;
						header("Location: home.php"); // Reindirizzamento a una pagina successiva al login
						exit();
					} else {
						$errorMessage = "Username o password errati.";
					}
				}
			}
		}
		
	}


	function get_pwd($user) {
		require "db.php";
		//CONNESSIONE AL DB
		$db = pg_connect($connection_string) or die('Impossibile connettersi al database: ' . pg_last_error());

		$sql = "SELECT password FROM proprietario WHERE email=$1;";
		$prep = pg_prepare($db, "sqlPassword", $sql); 
		$ret = pg_execute($db, "sqlPassword", array($user));

		if (!$ret) {
			echo "ERRORE QUERY: " . pg_last_error($db);
			return false; 
		} else {
			if ($row = pg_fetch_assoc($ret)){ 
				$pass = $row['password'];
				return $pass;
			} else {
				return false;
			}
		}

	}

?>


<html>
<head>
	<link rel="stylesheet" href="style_login.css">
	<title>Login</title>
	<link rel="icon" type="image/x-icon" href="img/logo1.png">
	<link rel="stylesheet" type="text/css" href="default.css">
	<script type="text/javascript" src="effetto_header.js"></script>
</head>
<body>	
<?php  require "header.php"; ?>

	<form method="post" id="login-form" action="login.php">
		<p>
			<h3>Effettua il login</h3>
		</p>
		<div id="inputbox">
			<label for="username">Email
				<input type="text" name="username" id="username" required/>
			</label>
		</div>
		<div id="inputbox">
			<label for="password">Password
				<input type="password" name="password" id="password" required/>
			</label>
		</div>
		<div id="submit">
			<input type="submit" name="invia" value="Login"/>
		</div>
		<div id="registrati-link"> Nuovo utente? <a href="registrati.php">Registrati!</a></div>

				<?php if (!empty($errorMessage)): ?>
		<p class="error-message"><?php echo $errorMessage; ?></p>
	<?php endif; ?>
	</form>
</body>
</html>



