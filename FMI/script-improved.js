/**
 * FMI Biblical Studies & Seminary
 * Improved JavaScript - Mobile Menu & Accessibility Features
 * Author: Nuru Amudi
 * Date: May 2026
 */

'use strict';

// ===== DOM ELEMENTS =====
const navLinksElement = document.getElementById('navLinks');
const navToggleButton = document.querySelector('.nav-toggle');
const navCloseButton = document.querySelector('.nav-close');
const navLinks = document.querySelectorAll('.nav-links a');
const yearElement = document.getElementById('year');

// ===== MOBILE MENU FUNCTIONALITY =====

/**
 * Show mobile navigation menu
 * Accessible for users with screen readers
 */
function showMenu() {
    if (navLinksElement) {
        navLinksElement.classList.add('active');
        navToggleButton.setAttribute('aria-expanded', 'true');
        navToggleButton.setAttribute('aria-label', 'Close menu');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }
}

/**
 * Hide mobile navigation menu
 * Accessible for users with screen readers
 */
function hideMenu() {
    if (navLinksElement) {
        navLinksElement.classList.remove('active');
        navToggleButton.setAttribute('aria-expanded', 'false');
        navToggleButton.setAttribute('aria-label', 'Open menu');
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    }
}

/**
 * Toggle mobile menu visibility
 */
function toggleMenu() {
    if (navLinksElement.classList.contains('active')) {
        hideMenu();
    } else {
        showMenu();
    }
}

// ===== EVENT LISTENERS FOR MOBILE MENU =====

// Toggle menu on button click
if (navToggleButton) {
    navToggleButton.addEventListener('click', toggleMenu);
}

// Close menu on close button click
if (navCloseButton) {
    navCloseButton.addEventListener('click', hideMenu);
}

// Close menu when a nav link is clicked
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        hideMenu();
    });
});

// Close menu when clicking outside of it
document.addEventListener('click', (event) => {
    if (navLinksElement && !navLinksElement.contains(event.target) && 
        !navToggleButton.contains(event.target)) {
        if (navLinksElement.classList.contains('active')) {
            hideMenu();
        }
    }
});

// Close menu on Escape key press
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && navLinksElement.classList.contains('active')) {
        hideMenu();
    }
});

// ===== RESPONSIVE MENU: CLOSE ON SCREEN RESIZE =====

/**
 * Close mobile menu when screen is resized to larger breakpoint
 */
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        if (window.innerWidth > 768) {
            hideMenu(); // Close mobile menu on larger screens
        }
    }, 250);
});

// ===== SMOOTH SCROLL =====

/**
 * Smooth scroll navigation links
 * Enhances user experience when clicking internal links
 */
navLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        const href = link.getAttribute('href');
        
        // Only handle internal links (starting with #)
        if (href.startsWith('#')) {
            event.preventDefault();
            const targetElement = document.querySelector(href);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Update URL without page jump
                history.pushState(null, null, href);
            }
        }
    });
});

// ===== SCROLL SPY (ACTIVE NAV LINK) =====

/**
 * Update active nav link based on scroll position
 * Shows which section is currently in view
 */
function updateActiveNavLink() {
    const sections = document.querySelectorAll('section');
    let currentSection = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        if (window.scrollY >= sectionTop - 200 && 
            window.scrollY < sectionTop + sectionHeight) {
            currentSection = section.getAttribute('id');
        }
    });
    
    // Update active state
    navLinks.forEach(link => {
        link.removeAttribute('aria-current');
        if (link.getAttribute('href') === `#${currentSection}`) {
            link.setAttribute('aria-current', 'page');
        }
    });
}

window.addEventListener('scroll', () => {
    updateActiveNavLink();
});

// ===== LAZY LOADING IMAGES =====

/**
 * Lazy load images for better performance
 * Uses Intersection Observer API
 */
function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.src; // Trigger loading
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
}

// ===== COPYRIGHT YEAR AUTO-UPDATE =====

/**
 * Update copyright year automatically
 * Ensures year is always current
 */
function updateCopyrightYear() {
    if (yearElement) {
        const currentYear = new Date().getFullYear();
        yearElement.textContent = currentYear;
    }
}

// ===== ACCESSIBILITY: FOCUS MANAGEMENT =====

/**
 * Improve keyboard navigation
 * Ensure proper focus states for accessibility
 */
document.addEventListener('keydown', (event) => {
    // Tab key for focus management
    if (event.key === 'Tab') {
        document.body.classList.add('keyboard-nav');
    }
});

document.addEventListener('mousedown', () => {
    document.body.classList.remove('keyboard-nav');
});

// ===== PERFORMANCE: DEBOUNCE FUNCTION =====

/**
 * Debounce function for performance optimization
 * Prevents function from being called too frequently
 */
function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}

// ===== INITIALIZATION =====

/**
 * Initialize all features when DOM is ready
 */
function init() {
    updateCopyrightYear();
    initLazyLoading();
    updateActiveNavLink(); // Set initial active state
    
    // Log initialization (optional - remove in production)
    console.log('✓ FMI Website initialized successfully');
}

// Run initialization when DOM is fully loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

// ===== ERROR HANDLING =====

/**
 * Log any JavaScript errors for debugging
 */
window.addEventListener('error', (event) => {
    console.error('JavaScript Error:', event.error);
});

/**
 * Handle unhandled promise rejections
 */
window.addEventListener('unhandledrejection', (event) => {
    console.error('Unhandled Promise Rejection:', event.reason);
});

// ===== EXPORT FOR MODULE USAGE =====
// Uncomment if using as module
// export { showMenu, hideMenu, toggleMenu, updateActiveNavLink };
