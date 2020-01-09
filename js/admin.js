/*global getData */
'use strict';

function a11yconfig_option() {
  let data = getData('a11yc');
  let elt = document.createElement(data.element);
  elt.setAttribute('id', 'accessconfig');
  elt.setAttribute('data-accessconfig-buttonname', data.label);
  elt.setAttribute('data-accessconfig-params', JSON.stringify(data.options));
  if (data.class !== '') {
    elt.setAttribute('class', data.class);
  }
  let container = document.querySelector(data.position === 0 ? 'ul#top-info-user' : 'footer');
  container.insertBefore(elt, container.firstChild);
}

document.addEventListener("DOMContentLoaded", function() {
  a11yconfig_option();
});

function a11yconfig_load() {
  const images = document.getElementsByTagName('img');
  for (let i = 0; i < images.length; i++) {
    if (images[i].alt !== '') {
      images[i].classList.add('a42-ac-replace-img');
    }
  }
}

window.addEventListener('load', a11yconfig_load);
