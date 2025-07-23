"use strict";

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile menu toggle functionality
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const nav = document.querySelector('.nav');
    
    if (mobileMenuToggle && nav) {
        mobileMenuToggle.addEventListener('click', function() {
            try {
                nav.classList.toggle('nav-active');
                mobileMenuToggle.classList.toggle('active');
            } catch (error) {
                console.error('Error toggling mobile menu:', error);
            }
        });
    }
    
    // Smooth scrolling for CTA button
    const ctaButton = document.querySelector('.btn-cta');
    const productsSection = document.querySelector('#products');
    
    if (ctaButton && productsSection) {
        ctaButton.addEventListener('click', function(e) {
            try {
                e.preventDefault();
                productsSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            } catch (error) {
                console.error('Error with smooth scrolling:', error);
                // Fallback to regular scrolling
                window.location.href = '#products';
            }
        });
    }
    
    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('.nav-list a');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            try {
                const href = this.getAttribute('href');
                
                if (href.startsWith('#')) {
                    e.preventDefault();
                    const targetSection = document.querySelector(href);
                    
                    if (targetSection) {
                        targetSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        
                        // Close mobile menu if open
                        if (nav.classList.contains('nav-active')) {
                            nav.classList.remove('nav-active');
                            mobileMenuToggle.classList.remove('active');
                        }
                    }
                }
            } catch (error) {
                console.error('Error with navigation link:', error);
            }
        });
    });
    
    // Image loading error handling
    const images = document.querySelectorAll('img');
    
    images.forEach(img => {
        img.addEventListener('error', function() {
            try {
                this.style.backgroundColor = '#f0f0f0';
                this.style.height = '200px';
                this.style.display = 'flex';
                this.style.alignItems = 'center';
                this.style.justifyContent = 'center';
                this.alt = 'Image not available';
                console.warn('Image failed to load:', this.src);
            } catch (error) {
                console.error('Error handling image load failure:', error);
            }
        });
        
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
    });
    
    // Header scroll effect
    const header = document.querySelector('.header');
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        try {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            lastScrollTop = scrollTop;
        } catch (error) {
            console.error('Error with scroll handler:', error);
        }
    });
    
    // Add animation on scroll for cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            try {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            } catch (error) {
                console.error('Error with intersection observer:', error);
            }
        });
    }, observerOptions);
    
    // Observe cards for animation
    const cards = document.querySelectorAll('.product-card, .finance-card');
    cards.forEach(card => {
        observer.observe(card);
    });
    
    // Button click effects
    const buttons = document.querySelectorAll('button');
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            try {
                this.classList.add('clicked');
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 200);
            } catch (error) {
                console.error('Error with button click effect:', error);
            }
        });
    });
    
    // Console log for successful initialization
    console.log('Hanoi Re website initialized successfully');
});

// Additional CSS for animations (injected via JavaScript)
const additionalStyles = `
    .nav-active {
        display: block !important;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 1rem;
    }
    
    .nav-active .nav-list {
        flex-direction: column;
        gap: 1rem;
    }
    
    .mobile-menu-toggle.active span:nth-child(1) {
        transform: rotate(-45deg) translate(-5px, 6px);
    }
    
    .mobile-menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }
    
    .mobile-menu-toggle.active span:nth-child(3) {
        transform: rotate(45deg) translate(-5px, -6px);
    }
    
    .header.scrolled {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    
    .animate-in {
        animation: slideInUp 0.6s ease-out forwards;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .clicked {
        transform: scale(0.95);
        transition: transform 0.1s ease;
    }
    
    @media (max-width: 768px) {
        .nav {
            display: none;
        }
    }
`;

// Inject additional styles
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);
