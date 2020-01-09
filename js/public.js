'use strict';

window.addEventListener('load', () => {
  const images = document.getElementsByTagName('img');
  for (let i = 0; i < images.length; i++) {
    if (images[i].alt !== '') {
      images[i].classList.add('a42-ac-replace-img');
    }
  }
});
