(() => {
  'use strict';
  const form = document.querySelector('[data-contact-form]');
  const status = document.querySelector('[data-form-status]');
  if (!form || !status) return;
  form.addEventListener('submit', event => {
    event.preventDefault();
    status.textContent = '演示表单验证通过（不会发送或保存信息）。';
  });
})();
