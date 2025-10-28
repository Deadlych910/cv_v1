document.addEventListener("DOMContentLoaded", function() {
  const bars = document.querySelectorAll('.progress-bar');

  // Animación de las barras al aparecer
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const bar = entry.target;
        const width = bar.getAttribute('data-width');
        bar.style.width = width;
      }
    });
  }, { threshold: 0.4 });

  bars.forEach(bar => {
    bar.style.width = '0';
    observer.observe(bar);
  });

  // Efecto fade-in general para elementos con clase .fade-in (AOS ya hace esto, pero lo mantenemos por si acaso)
  const fadeEls = document.querySelectorAll('.fade-in');
  const fadeObs = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('active');
    });
  }, { threshold: 0.3 });

  fadeEls.forEach(el => fadeObs.observe(el));
  
  // Activar el "spy scroll" de Bootstrap para el menú
  const mainNav = document.querySelector('.navbar');
  if (mainNav) {
    new bootstrap.ScrollSpy(document.body, {
      target: '#navbarNav',
      offset: 70 // Ajusta este valor si es necesario
    });
  }
});