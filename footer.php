<footer id="section1">
  		<div class="container">
    	<div class="footer-content">
      	<div class="footer-section">
        <h3>Contatti</h3>
        <p>Indirizzo: Via Example, 123</p>
        <p>Email: info@example.com</p>
        <p>Telefono: 123-456789</p>
      	</div>
      	<div class="footer-section">
        <h3>Link Utili</h3>
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="NewRicerca.php">Barche</a></li>
          <?php
					if(empty($_SESSION["username"])){
						echo "<li><a href=\"registrati.php\">Registrati</a></li>";
					}
				?>
        </ul>
      	</div>
      	<div class="footer-section">
        <h3>Social</h3>
        <ul class="social-icons">
          <li><a href="https://it-it.facebook.com/"><i class="fa fa-facebook"><img src="img/facebook.png"></i></a></li>
          <li><a href="https://twitter.com/"><i class="fa fa-twitter"><img src="img/twitter.png"></i></a></li>
          <li><a href="https://www.instagram.com/"><i class="fa fa-instagram"><img src="img/instagram.png"></i></a></li>
        </ul>
      	</div>
    	</div>
    	<div class="footer-bottom">
      <p>&copy;2023 Luxury Boats. Tutti i diritti riservati.</p>
    	</div>
  	</div>
</footer>