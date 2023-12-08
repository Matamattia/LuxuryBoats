function numStars(){

	var num = document.getElementsByClassName('stars');
	
	for(let i=0; i<num.length;i++){
		immagine = document.createElement('img')
		if(num[i].textContent == '1'){
			immagine.src = "img/stars1.jpeg";
			immagine.alt = "stars1";
		}else if(num[i].textContent == '2'){
			immagine.src = 'img/stars2.jpeg';
			immagine.alt = "stars2";
		}else if(num[i].textContent == '3'){
			immagine.src = 'img/stars3.jpeg';
			immagine.alt = "stars3";
		}else if(num[i].textContent == '4'){
			immagine.src = 'img/stars4.jpeg';
			immagine.alt = "stars4";
		}else{//quindi uguale a 5, in quanto non si possono mettere 0 stelle nel nostro caso
			
			immagine.src = 'img/stars5.jpeg';
			immagine.alt = "stars5";
		}
		num[i].innerHTML = '';
		num[i].appendChild(immagine);//non devo inserirlo a sua volta perchè sta sempre lì
	}

}


