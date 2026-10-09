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
