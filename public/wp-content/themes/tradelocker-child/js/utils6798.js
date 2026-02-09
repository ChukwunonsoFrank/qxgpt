function blockMenuLinksOnSmallScreens() {
  const selector = '#menu-primary-menu > li > a';
  const mediaQuery = window.matchMedia('(max-width: 1199px)');

  function preventNav(e) {
    const target = e.currentTarget;
    const isStartTrading = target.getAttribute('data-analytics-label') === 'Start trading';
    
    // Allow navigation only for "Start trading" link
    if (!isStartTrading) {
      e.preventDefault();
    }
  }

  function updateHandlers() {
    document.querySelectorAll(selector).forEach(link => {
      link.removeEventListener('click', preventNav);
      if (mediaQuery.matches) {
        link.addEventListener('click', preventNav);
      }
    });
  }

  mediaQuery.addListener(updateHandlers);
  updateHandlers();
}

document.addEventListener('DOMContentLoaded', blockMenuLinksOnSmallScreens);