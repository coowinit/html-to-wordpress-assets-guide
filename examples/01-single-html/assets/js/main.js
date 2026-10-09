/* Safe on pages that do not contain a mobile menu. */
(() => {
  'use strict';
  function initMobileMenu() {
    const button = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.site-nav');
    if (!button || !nav || button.dataset.initialized === 'true') return;
    button.dataset.initialized = 'true';
    button.addEventListener('click', () => {
      const open = button.getAttribute('aria-expanded') === 'true';
      button.setAttribute('aria-expanded', String(!open));
      nav.classList.toggle('is-open', !open);
    });
  }
  initMobileMenu(); // Loaded by defer: DOM is parsed.
})();

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
