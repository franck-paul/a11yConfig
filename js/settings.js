/*global dotclear */
'use strict';

window.addEventListener('load', () => {
  const required_control = document.getElementById('a11yc_active');
  const required_fields = document.querySelectorAll('#a11yc_label');

  const applyState = () => {
    required_fields.forEach((field) => (field.required = required_control.checked));
  };

  applyState();
  required_control.addEventListener('click', () => {
    applyState();
  });
});
