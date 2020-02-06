'use strict';

window.addEventListener('load', () => {
  const images = document.querySelectorAll('img:not([alt=""])');
  images.forEach(function(image) {
    image.classList.add('a42-ac-replace-img');
  });
});
