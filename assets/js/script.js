/* ============================================================
   NVC NETWORK — Main Script
   ============================================================ */

// ===== DARK / LIGHT MODE =====
const body      = document.body;
const savedTheme = localStorage.getItem('nvc-theme') || 'dark';

// Terapkan tema tersimpan SEBELUM render (cegah flicker)
if (savedTheme === 'light') body.classList.add('light-mode');

// Inject tombol toggle ke navbar secara otomatis
document.addEventListener('DOMContentLoaded', () => {
  const navbar = document.querySelector('.navbar');
  if (navbar) {
    const btn = document.createElement('button');
    btn.id = 'themeToggle';
    btn.className = 'theme-toggle';
    btn.setAttribute('aria-label', 'Ganti tema');
    btn.setAttribute('title', 'Dark / Light Mode');
    btn.innerHTML = `
      <span class="toggle-icon" id="iconDark"><i class="fa-solid fa-moon"></i></span>
      <span class="toggle-icon" id="iconLight"><i class="fa-solid fa-sun"></i></span>
    `;

    // Sisipkan sebelum hamburger (atau di akhir navbar)
    const hamburger = navbar.querySelector('#hamburger');
    if (hamburger) navbar.insertBefore(btn, hamburger);
    else navbar.appendChild(btn);

    updateToggleUI();

    btn.addEventListener('click', () => {
      body.classList.toggle('light-mode');
      const theme = body.classList.contains('light-mode') ? 'light' : 'dark';
      localStorage.setItem('nvc-theme', theme);
      updateToggleUI();
    });
  }
});

function updateToggleUI() {
  const isLight   = body.classList.contains('light-mode');
  const iconDark  = document.getElementById('iconDark');
  const iconLight = document.getElementById('iconLight');
  if (!iconDark || !iconLight) return;
  if (isLight) {
    iconDark.classList.remove('active');
    iconLight.classList.add('active');
  } else {
    iconDark.classList.add('active');
    iconLight.classList.remove('active');
  }
}

// ===== NAVBAR TOGGLE (mobile) =====
document.addEventListener('DOMContentLoaded', () => {
  const navnav = document.querySelector('.navigasi');
  const menu   = document.querySelector('#hamburger');
  if (!navnav || !menu) return;

  menu.addEventListener('click', (e) => {
    e.preventDefault();
    navnav.classList.toggle('active');
  });

  document.querySelectorAll('.navigasi a').forEach(link => {
    link.addEventListener('click', () => navnav.classList.remove('active'));
  });

  document.addEventListener('click', (e) => {
    if (!menu.contains(e.target) && !navnav.contains(e.target)) {
      navnav.classList.remove('active');
    }
  });
});

// ===== SMOOTH SCROLL =====
function scrolotomatis(id) {
  const target = document.getElementById(id);
  if (!target) return;
  const yOffset = -80;
  const y = target.getBoundingClientRect().top + window.scrollY + yOffset;
  window.scrollTo({ top: y, behavior: 'smooth' });
}

// ===== INTERSECTION OBSERVER (animasi fade-in) =====
document.addEventListener('DOMContentLoaded', () => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      entry.target.classList.toggle('show', entry.isIntersecting);
    });
  }, { threshold: 0.15 });
  document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));
});

// ===== FOTO SLIDER =====
document.addEventListener('DOMContentLoaded', () => {
  const slider   = document.querySelector('.slider');
  const slides   = document.querySelectorAll('.slide');
  const prevBtn  = document.querySelector('.prev');
  const nextBtn  = document.querySelector('.next');
  if (!slider || slides.length === 0) return;

  let index    = 0;
  let interval = setInterval(autoSlide, 3500);

  function showSlide(i) {
    if (i < 0) index = slides.length - 1;
    else if (i >= slides.length) index = 0;
    else index = i;
    slider.style.transform = `translateX(${-index * 100}%)`;
  }

  function autoSlide() { showSlide(index + 1); }

  function resetInterval() {
    clearInterval(interval);
    interval = setInterval(autoSlide, 3500);
  }

  if (nextBtn) nextBtn.addEventListener('click', () => { showSlide(index + 1); resetInterval(); });
  if (prevBtn) prevBtn.addEventListener('click', () => { showSlide(index - 1); resetInterval(); });

  // Touch / swipe support
  let touchStartX = 0;
  slider.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].clientX;
  }, { passive: true });
  slider.addEventListener('touchend', (e) => {
    const diff = touchStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 40) {
      diff > 0 ? showSlide(index + 1) : showSlide(index - 1);
      resetInterval();
    }
  }, { passive: true });
});