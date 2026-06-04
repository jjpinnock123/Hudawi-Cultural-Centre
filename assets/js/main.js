document.addEventListener('DOMContentLoaded', () => {
  // Mobile navigation toggle
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');

  const closeMobileMenu = () => {
    if (mobileMenu) {
      mobileMenu.classList.remove('open');
    }
    if (menuToggle) {
      menuToggle.setAttribute('aria-expanded', 'false');
    }
  };

  if (menuToggle && mobileMenu) {
    menuToggle.setAttribute('aria-expanded', 'false');

    menuToggle.addEventListener('click', () => {
      const isOpen = mobileMenu.classList.toggle('open');
      menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    // Close the mobile menu as soon as a menu link is selected.
    // This stops the menu staying open over the Booking page on phones.
    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', closeMobileMenu);
    });

    // Close the menu if the visitor taps outside the navigation area.
    document.addEventListener('click', event => {
      const clickedInsideMenu = mobileMenu.contains(event.target);
      const clickedToggle = menuToggle.contains(event.target);
      if (!clickedInsideMenu && !clickedToggle) {
        closeMobileMenu();
      }
    });

    // Close the menu when Escape is pressed.
    document.addEventListener('keydown', event => {
      if (event.key === 'Escape') {
        closeMobileMenu();
      }
    });
  }

  // Feather icons
  if (window.feather) {
    window.feather.replace();
  }

  // Update footer year
  const yearSpan = document.getElementById('year');
  if (yearSpan) {
    yearSpan.textContent = new Date().getFullYear();
  }

  // Scroll fade-in animations
  const scrollElements = document.querySelectorAll('.scroll-fade');

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('show');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.2 }
    );

    scrollElements.forEach(el => observer.observe(el));
  } else {
    scrollElements.forEach(el => el.classList.add('show'));
  }
});
