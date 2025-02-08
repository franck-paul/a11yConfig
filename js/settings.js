/*global dotclear */
'use strict';

dotclear.ready(() => {
  const required_control = document.getElementById('a11yc_active');
  const required_fields = document.querySelectorAll('#a11yc_label');

  const applyState = () => {
    for (const field of required_fields) field.required = required_control.checked;
  };

  applyState();
  required_control.addEventListener('click', () => {
    applyState();
  });
});
