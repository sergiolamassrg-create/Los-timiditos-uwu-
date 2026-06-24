const revealItems = document.querySelectorAll('.reveal');
const nav = document.getElementById('site-nav');
const toggle = document.querySelector('.menu-toggle');
const yearNode = document.getElementById('year');
const yearMobileNode = document.getElementById('year-mobile');
const scrollTopButton = document.querySelector('.scroll-top-btn');
const header = document.querySelector('.site-header');
const navLinks = nav ? [...nav.querySelectorAll('a[href^="#"]')] : [];
const pageLinks = nav ? [...nav.querySelectorAll('a:not([href^="#"])')] : [];
const heroBg = document.querySelector('.hero-bg');

if (yearNode) yearNode.textContent = new Date().getFullYear();
if (yearMobileNode) yearMobileNode.textContent = new Date().getFullYear();

if (toggle && nav) {
  toggle.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    toggle.setAttribute('aria-expanded', String(open));
  });

  nav.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      nav.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
    });
  });

  document.addEventListener('click', (event) => {
    if (!nav.classList.contains('open')) return;
    if (nav.contains(event.target) || toggle.contains(event.target)) return;
    nav.classList.remove('open');
    toggle.setAttribute('aria-expanded', 'false');
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    nav.classList.remove('open');
    toggle.setAttribute('aria-expanded', 'false');
  });
}


if (scrollTopButton) {
  const footerNode = document.querySelector('.footer-mobile-minimal') || document.querySelector('.site-footer');

  const syncScrollTopButton = () => {
    const nearFooter = footerNode
      ? footerNode.getBoundingClientRect().top < window.innerHeight * 1.25
      : false;
    const shouldShow = window.scrollY > 600 || nearFooter;
    scrollTopButton.classList.toggle('is-visible', shouldShow);
  };

  scrollTopButton.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  syncScrollTopButton();
  window.addEventListener('scroll', syncScrollTopButton, { passive: true });
  window.addEventListener('resize', syncScrollTopButton);
}
if (header) {
  const syncHeaderState = () => {
    header.classList.toggle('scrolled', window.scrollY > 12);
  };

  syncHeaderState();
  window.addEventListener('scroll', syncHeaderState, { passive: true });
}

if (navLinks.length) {
  const sections = navLinks
    .map((link) => document.querySelector(link.getAttribute('href')))
    .filter(Boolean);

  if (sections.length) {
    const activateCurrent = () => {
      const offset = window.scrollY + 130;
      let currentId = sections[0].id;

      sections.forEach((section) => {
        if (section.offsetTop <= offset) currentId = section.id;
      });

      navLinks.forEach((link) => {
        const isActive = link.getAttribute('href') === `#${currentId}`;
        link.classList.toggle('active', isActive);
      });
    };

    activateCurrent();
    window.addEventListener('scroll', activateCurrent, { passive: true });
  }
}

if (pageLinks.length) {
  const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
  pageLinks.forEach((link) => {
    const href = link.getAttribute('href');
    if (!href || href.startsWith('http')) return;
    const linkPath = href.split('#')[0].replace(/\/+$/, '') || '/';
    link.classList.toggle('active', linkPath === currentPath);
  });
}

if (heroBg) {
  const syncHeroMotion = () => {
    const offset = Math.min(window.scrollY * 0.08, 22);
    heroBg.style.transform = `scale(1.04) translateY(${offset}px)`;
  };

  syncHeroMotion();
  window.addEventListener('scroll', syncHeroMotion, { passive: true });
}

if ('IntersectionObserver' in window) {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.18 }
  );

  revealItems.forEach((item) => observer.observe(item));
} else {
  revealItems.forEach((item) => item.classList.add('visible'));
}

