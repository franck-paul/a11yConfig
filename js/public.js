'use strict';

window.addEventListener('load', () => {
  document.querySelectorAll('img:not([alt=""])').forEach((image) => image.classList.add('a42-ac-replace-img'));
});
