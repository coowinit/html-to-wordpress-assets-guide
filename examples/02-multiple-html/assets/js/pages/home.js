(() => {
  'use strict';
  const button = document.querySelector('[data-demo-action]');
  const output = document.querySelector('[data-demo-status]');
  if (!button || !output || button.dataset.initialized === 'true') return;
  button.dataset.initialized = 'true';
  button.addEventListener('click', () => {
    output.textContent = '页面专属 JavaScript 已正常运行。';
  });
})();
