(() => {
  'use strict';
  const grid = document.querySelector('[data-product-grid]');
  const buttons = document.querySelectorAll('[data-filter]');
  if (!grid || !buttons.length) return;
  buttons.forEach(button => button.addEventListener('click', () => {
    const value = button.dataset.filter;
    grid.querySelectorAll('[data-category]').forEach(card => { card.hidden = value !== 'all' && card.dataset.category !== value; });
    buttons.forEach(b => b.setAttribute('aria-pressed', String(b === button)));
  }));
})();
