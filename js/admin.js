/*global getData */
'use strict';

document.addEventListener("DOMContentLoaded", () => {
  let data = getData('a11yc');
  let container = document.querySelector(data.parent);
  if (!container) {
    if (!(container = document.querySelector('body.popup'))) {
      return;
    }
  }
  let elt = document.createElement(data.element);
  elt.setAttribute('id', 'accessconfig');
  elt.setAttribute('data-accessconfig-buttonname', data.label);
  elt.setAttribute('data-accessconfig-params', JSON.stringify(data.options));
  if (data.class !== '') {
    elt.setAttribute('class', data.class);
  }
  container.insertBefore(elt, container.firstChild);
});

window.addEventListener('load', () => {
  document.querySelectorAll('img:not([alt=""])').forEach((image) => image.classList.add('a42-ac-replace-img'));
});
