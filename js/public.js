'use strict';

window.addEventListener('load', () => {
  const images = document.querySelectorAll('img:not([alt=""])');
  images.forEach((image) => image.classList.add('a42-ac-replace-img'));
});
