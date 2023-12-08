
  function checkName(obj){
    if(obj.value.length > 50){
      alert("Il nome della barca deve essere minore di 50 caratteri");
      obj.value='';
      obj.focus();
    }
  }

  function checkNumbers(obj){
    if(isNaN(obj.value)){
      alert("Il campo "+obj.name+" deve essere un numero");
      obj.value='';
      obj.focus();
    }
  }

  function checkDesc(obj){
    if(obj.value.length > 300){
      alert("La descrizione deve essere < 300 caratteri");
      obj.value='';
      obj.focus();
  }
}
  function removeBoat(removeBoat){
    if(confirm("Sei sicuro di voler cancellare la barca?")){

    var hiddenForm = document.getElementById('dispo');
    document.getElementById('hiddenCode').value  = removeBoat.id 
    document.getElementById("hiddenValue").value = 1;
    hiddenForm.submit();
  }
  }

  function reset(){
      document.getElementById('nomeBarca').reset();

    }

    // Attendere il caricamento completo della pagina
    document.addEventListener('DOMContentLoaded', function() {
      // Ottenere il riferimento al pulsante "Aggiungi barca"
      var addBoatButton = document.getElementById('addBoatButton');
      // Ottenere il riferimento al div
      
      var newBoatForm = document.querySelector('.new-boat-form');
      // Nascondere il div "Nuova barca" all'inizio

      // Aggiungere un listener per il clic sul pulsante "Aggiungi barca"
      addBoatButton.addEventListener('click', function() {
        // Nascondere il pulsante "Aggiungi barca"
        addBoatButton.style.display = 'none';
        // Mostrare il modulo "Nuova barca"
        newBoatForm.style.display = 'block';

        // Creare un pulsante "Indietro"
        var backButton = document.createElement('button');
        // Impostare il testo del pulsante "Indietro"
        backButton.textContent = 'Indietro';

        // Aggiungere un listener per il clic sul pulsante "Indietro"
        backButton.addEventListener('click', function() {
          // Nascondere il pulsante "Indietro"
          backButton.style.display = 'none';
          // Nascondere il modulo "Nuova barca"
          newBoatForm.style.display = 'none';
          // Mostrare nuovamente il pulsante "Aggiungi barca"
          addBoatButton.style.display = 'block';
        });

        // Aggiungere il pulsante "Indietro" al modulo "Nuova barca"
        newBoatForm.appendChild(backButton);
      });

      // Ottenere il riferimento al modulo di invio del modulo "Nuova barca"
      var newBoatFormSubmit = document.getElementById('newBoatForm');

      // Aggiungere un listener per l'invio del modulo "Nuova barca"
      newBoatFormSubmit.addEventListener('submit', function() {

        // Nascondere il modulo "Nuova barca"
        newBoatForm.style.display = 'none';
        
        // Mostrare nuovamente il pulsante "Aggiungi barca"
        addBoatButton.style.display = 'block';
      });
    });