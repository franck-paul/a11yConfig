/*global getData */
'use strict';

document.addEventListener("DOMContentLoaded", () => {
  let data = getData('a11yc');
  let elt = document.createElement(data.element);
  elt.setAttribute('id', 'accessconfig');
  elt.setAttribute('data-accessconfig-buttonname', data.label);
  elt.setAttribute('data-accessconfig-params', JSON.stringify(data.options));
  if (data.class !== '') {
    elt.setAttribute('class', data.class);
  }
  let container = document.querySelector(data.parent);
  container.insertBefore(elt, container.firstChild);
});

window.addEventListener('load', () => {
  const images = document.getElementsByTagName('img');
  for (let i = 0; i < images.length; i++) {
    if (images[i].alt !== '') {
      images[i].classList.add('a42-ac-replace-img');
    }
  }
});
