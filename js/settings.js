/*global dotclear */
'use strict';

window.addEventListener('load', () => {
  const required_control = document.getElementById('a11yc_active');
  const required_childs = document.querySelectorAll('#a11yc_label_label');
  const required_fields = document.querySelectorAll('#a11yc_label');

  const applyState = () => {
    if (required_control.checked) {
      required_childs.forEach((child) => child.classList.add('required'));
      required_fields.forEach((field) => (field.required = true));
    } else {
      required_childs.forEach((child) => child.classList.remove('required'));
      required_fields.forEach((field) => (field.required = false));
    }
  };

  applyState();
  required_control.addEventListener('click', () => {
    applyState();
  });
});
