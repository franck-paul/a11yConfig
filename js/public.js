'use strict';

function a11yconfig_load() {
  const images = document.getElementsByTagName('img');
  for (let i = 0; i < images.length; i++) {
    if (images[i].alt !== '') {
      images[i].className += ' a42-ac-replace-img';
    }
  }
}
window.addEventListener('load', a11yconfig_load);
