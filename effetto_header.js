window.addEventListener('scroll', function() {
  var header = document.getElementById('main-header');
  var distanceFromTop = window.pageYOffset || document.documentElement.scrollTop;
  var links = document.querySelectorAll('header nav ul li a');

  if (distanceFromTop > 0) {
    header.classList.remove('header-transparent');
    header.classList.add('header-white');
    for (var i = 0; i < links.length; i++) {
      links[i].classList.remove('color-white');
      links[i].classList.add('color-black');

    }
  } else {
    header.classList.remove('header-white');
    header.classList.add('header-transparent');
    for (var i = 0; i < links.length; i++) {
      links[i].classList.remove('color-black');
      links[i].classList.add('color-white');
    }
  }
});
