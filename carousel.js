 carousel() {
   var carousel = document.querySelector('.carousel');
  var carouselItems = document.querySelectorAll('.carousel-item');
  var currentIndex = 0;

  function showSlide(index) {
    carousel.style.transform = 'translateX(-' + (index * 100) + '%)';
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % carouselItems.length;
    showSlide(currentIndex);
  }

  setInterval(nextSlide, 3000); // Cambia slide ogni 3 secondi
  };