// ============================================
// Simplified JavaScript - Escalier Monte au Bois
// ============================================

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const nav = document.getElementById('nav');
    const navLinks = document.querySelectorAll('.nav-link');

    // Toggle menu on hamburger click
    if (hamburger) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            nav.classList.toggle('active');
        });
    }

    // Close menu when a link is clicked
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            nav.classList.remove('active');
        });
    });

    // Set active nav link based on current page
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (href === './' && (currentPage === '' || currentPage === 'index.html'))) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.header-content')) {
            hamburger.classList.remove('active');
            nav.classList.remove('active');
        }
    });
});
