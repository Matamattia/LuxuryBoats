


function controllo() {
  //leggo i valori dei vari input
  var email = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var repassword = document.getElementById("repassword").value;
  var nome = document.getElementById("nome").value;
  var cognome = document.getElementById("cognome").value;
  var telefono = document.getElementById("telefono").value;
  var dataNascita = document.getElementById("data").value;

  // verifico che non ci siano campi vuoti
  if (email === "" || password === "" || nome === "" || cognome === "" || telefono === "" || dataNascita === "" || repassword==="") {
    alert("Si prega di compilare tutti i campi");
    return;
  }
  if(nome.length > 30){
    document.getElementById("error-message").textContent = "Il nome deve contenere meno di 30 caratteri";
    return;
  }
  if(cognome.length > 30){
    document.getElementById("error-message").textContent = "Il cognome deve contenere meno di 30 caratteri";
    return;
  }
  // Verifico che il formato dell'email sia giusto
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  var isValidEmail = emailRegex.test(email);
  if (!isValidEmail){
    document.getElementById("error-message").textContent = "L'email non è corretta";
    return;
  }
  if(email.length > 50){
    document.getElementById("error-message").textContent = "L'email deve contenere massimo 50 caratteri";
    return;
  }

    // Verifico che il formato della data sia giusto
  var dataRegex = /^\d{2}\/\d{2}\/\d{4}$/;
  var isValidData = dataRegex.test(dataNascita);
  if (!isValidData) {
    document.getElementById("error-message").textContent = "La data non è nel formato corretto (gg/mm/aaaa)";
    return;
  }


  // verifico che la password sia inserita correttamente
  var passwordRegex = /^(?=.*\d).{8,}$/;
  var isValidPassword = passwordRegex.test(password);
  if (!isValidPassword) {
    document.getElementById("error-message").textContent = "La password deve contenere almeno 8 caratteri, inclusi almeno un numero";
    return;
  }
  if (password != repassword) {
    document.getElementById("error-message").textContent = "Le password inserite non corrispondono";
    return;
  }
  if(password.length > 255){
    document.getElementById("error-message").textContent = "La password deve essere massimo di 255 caratteri";
    return;
  }
  // Verifica che il numero di telefono sia un numero di telefono mobile valido
  var telefonoRegex = /^(\+?39)?[ -]?3\d{2}[ -]?(\d{6,7})$/;
  var isValidTelefono = telefonoRegex.test(telefono);
  if (!isValidTelefono) {
    document.getElementById("error-message").textContent = "Il numero di telefono non è valido. Assicurati di inserire un numero di telefono mobile italiano.";
    return;
  }

  // Se la validazione è passata, invia il modulo di registrazione
   document.getElementById("reg-form").submit();
}