<html>
<head>
	<title>Logout</title>
</head>
<body>
	<header id="main-header">
		
			<img class="logo" src="logo.png" alt="logo...">

		
		<nav>
			<ul class="content">
				<li ><a href="home.php">home</a></li>
				<li ><a href="NewRicerca.php">yatch</a></li>
				<li ><a href="foot">contatti</a></li>
				
				<?php
					session_start();
					//
					if(empty($_SESSION["username"])){
						echo "<li ><a href=\"login.php\">login</a></li>";
					}else{
						echo "<li ><a href='lemiebarche.php'>le mie barche</a></li>";
						echo "<li ><a href=\"logout-2.php\">logout</a></li>";
						$user = explode('@',$_SESSION["username"] );
						echo "<li class='usern' >$user[0]</li>";
					}
				?>
				
			</ul>
		</nav>
	</header>
<?php
 	/* attiva la sessione */
	session_start();
	/* sessione attiva, la distrugge */
	$sname=session_name();
	session_destroy();
	/* ed elimina il cookie corrispondente */
	if (isset($_COOKIE[session_name()])) { 
		setcookie($sname,'', time()-3600,'/');
	}
	header("Location: home.php");
?>
</body>
</html>