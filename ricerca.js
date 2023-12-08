function sfoglia(div){

        var primoFiglio = div.parentNode.childNodes[0];
        var secondoFiglio = div.parentNode.childNodes[1];
        var terzoFiglio = div.parentNode.childNodes[2];
        if (primoFiglio.style.display != "none") {
        primoFiglio.style.display = "none";
        secondoFiglio.style.display = "inline-block";
      } else if (secondoFiglio.style.display != "none") {
        secondoFiglio.style.display = "none";
        terzoFiglio.style.display = "inline-block";
      } else if (terzoFiglio.style.display != "none") {
        terzoFiglio.style.display = "none";
        primoFiglio.style.display = "inline-block";
      }
    }


    function resettaForm(button) {
    var form=document.getElementById('parametri');
    var i = 0;
    var text = document.getElementById('testo')
    text.value='';
    for(i=0;i<document.getElementsByClassName('check').length;i++){
      document.getElementsByClassName('check')[i].checked=false;
    }
  }


  function scorri(div){
    var skip = div.children[3];
    skip.style.display = "inline-block";
  }

  function hide(div){
    var skip = div.children[3];
    skip.style.display = "none";
  }

  function controlloValore(){
    var textValue=document.getElementById('testo').value;
    var a;
    if(isNaN(textValue)){
      alert("Devi inserire un numero nel campo prezzo!");
      document.getElementById('testo').focus();
      return false;
    }else{
      return true;
    }
  }
