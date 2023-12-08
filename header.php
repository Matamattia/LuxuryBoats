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
					session_start();
					//si apre la sessione
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