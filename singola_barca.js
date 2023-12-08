function check(){
	var email = document.getElementById("nome").value;
	var descrizione = document.getElementById("recensione").value;

	var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  	var isValidEmail = emailRegex.test(email);
  	if (!isValidEmail){
    	alert("L'email non è corretta");
    	return false;
  	}
  	if(email.length > 50){
   	 	alert("L'email non deve superare i 50 caratteri");
    	return false;
  	}

  	if(descrizione.length > 1000){
  		alert("La descrizione non deve superare i 1000 caratteri");
    	return false;
  	}
  	return true;
}