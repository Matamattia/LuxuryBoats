
function handlerClickMore(element){
		
	var id = element.id;
	var meno_id = null;
	var desc_id = null;

	if(id == 'praiano'){
		meno_id = 2;
		desc_id = "descrizione2";
	}else if(id == 'marini'){
		meno_id = 1;
		desc_id = "descrizione1";
	}else{
		meno_id = 3;
		desc_id = "descrizione3";
	}
	
	
	element.style.display = "none";//nascondo view more

	var meno = document.getElementById(meno_id);
	var desc = document.getElementById(desc_id);
	meno.style.display = "inline-block";
	desc.style.display = "inline-block";


}
function handlerClickMeno(element){
	element.style.display = "none";//nascondo il vedi meno
	var id = element.id;
	var more_id = null;
	var desc_id = null;
	if(id == 1){
		more_id = "marini";
		desc_id = "descrizione1";
	}else if(id == 2){
		more_id = "praiano";
		desc_id = "descrizione2";
	}else{
		more_id = "amalfi";
		desc_id = "descrizione3";
	}
	var more = document.getElementById(more_id);//ottengo l' id di vedi più
	var desc = document.getElementById(desc_id);
	more.style.display = "inline-block";
	desc.style.display = "none";
}