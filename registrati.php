<html>
<head>
	<title>Registrati</title>
	<link rel="icon" type="image/x-icon" href="img/logo1.png">
	 <link rel="stylesheet" href="style_login.css">
	 <link rel="stylesheet" type="text/css" href="default.css">
	 
</head>
<body>
	<?php  require "header.php"; ?>
<?php
	if(isset($_POST['nome']))
		$nome = $_POST['nome'];
	else
		$nome = "";
	if(isset($_POST['cognome']))
		$cognome = $_POST['cognome'];
	else
		$cognome = "";

	if(isset($_POST['telefono']))
		$telefono = $_POST['telefono'];
	else
		$telefono = "";

	if(isset($_POST['data']))
		$data = $_POST['data'];
	else
		$data = "";

	if(isset($_POST['username']))
		$user = $_POST['username'];
	else
		$user = "";
	if(isset($_POST['password']))
		$pass = $_POST['password'];
	else
		$pass = "";
	if(isset($_POST['repassword']))
		$repassword = $_POST['repassword'];
	else
		$repassword = "";

	//CHECK PASSWORD
	$successo = null;
	$errori['user']=null;
		if (!empty($pass) && !empty($user) && !empty($nome) && !empty($telefono) && !empty($data) && !empty($cognome)){
			if(username_exist($user)){
				$errori['user'] ="Email $user già esistente. Riprova</p>";
			}
			else{
				//ORA posso inserire il nuovo utente nel db
				if(insert_utente($nome,$cognome,$telefono,$data, $user, $pass)){
					$successo ="  Utente registrato con successo. Effettua il <a href=\"login.php\">login</a>";
				}
				else{
					echo "<p> Errore durante la registrazione. Riprova</p>";
				}
			}
		
	}
	

?>


	<form method="post" id="reg-form" action="registrati.php">
		<p>
			<h3>Registrati</h3>
		</p>
		<div id="inputbox">
		<label for="nome">Nome
			<input type="text" name="nome" id="nome" value="<?php echo $nome?>"/>
		</label>
		</div>
		<div id="inputbox">
		<label for="cognome">Cognome
			<input type="text" name="cognome" id="cognome" value="<?php echo $cognome?>"/>
		</label>
		</div>
		<div id="inputbox">
		<label for="telefono">Telefono
			<input type="text" name="telefono" id="telefono" value="<?php echo $telefono?>"/>
		</label>
		</div>
		<div id="inputbox">
		<label for="data">Data di Nascita
			<input type="text" name="data" id="data" placeholder="GG/MM/AAAA"value="<?php echo $data?>"/>
		</label>
		</div>
		<div id="inputbox">
		<label for="username">Email
			<input type="text" name="username" id="username" value="<?php echo $user?>"/>
			
		</label>
		</div>
		<div >
		<label for="password">Password
			<input type="password" name="password" id="password" value="<?php echo $pass?>"/>
		</label>
		</div>
		<div id="inputbox">
		<label for="repassword">Ripeti la password
		<input type="password" name="repassword" id="repassword" value="<?php echo $repassword?>"/>
		</label>
		</div>
		<div id="registrazione">
		 <button type="button" onclick="controllo()">Registrati</button>
		 <span id="error-message" class="error-message"><?php echo $errori['user']; ?></span>
		</div>
		<div id="login-link"> Hai gia un account? <a href="login.php">Accedi!</a></div>
		<div class="successo"><?php echo $successo; ?></div>
	</form>
	      <script src="checkreg.js"></script>
</body>
</html>

<?php
function username_exist($user){
	require "db.php";
	//CONNESSIONE AL DB
	$db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
		//echo "Connessione al database riuscita<br/>"; 
	$sql = "SELECT email FROM proprietario WHERE email=$1";
	$prep = pg_prepare($db, "sqlUsername", $sql); 
	$ret = pg_execute($db, "sqlUsername", array($user));
	if(!$ret) {
		echo "ERRORE QUERY: " . pg_last_error($db);
		return false; 
	}
	else{
		if ($row = pg_fetch_assoc($ret)){ 
			return true;
		}
		else{
			return false;
		}
	}
	pg_close($db);
}

function insert_utente($nome,$cognome,$telefono,$data, $user, $pass){
	require "db.php";
	//CONNESSIONE AL DB
	$db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
		//echo "Connessione al database riuscita<br/>"; 
	$hash = password_hash($pass, PASSWORD_DEFAULT);
	$sql = "INSERT INTO proprietario(nome,cognome,num_tel,data_nascita, email, password) VALUES($1, $2, $3,$4,$5,$6)";
	$prep = pg_prepare($db, "insertUser", $sql); 
	$ret = pg_execute($db, "insertUser", array($nome,$cognome,$telefono,$data, $user, $hash));
	if(!$ret) {
		echo "$hash ERRORE QUERY: " . pg_last_error($db);
		return false; 
	}
	else{
		return true;
	}
	pg_close($db);
}
?>