document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    const navContainer = document.querySelector('.nav-container');
    const searchContainer = document.querySelector('.search-container');
    
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', function() {
            document.body.classList.toggle('mobile-menu-active');
            this.textContent = document.body.classList.contains('mobile-menu-active') ? '✕' : '☰';
            
            // Create mobile search if it doesn't exist
            if (document.body.classList.contains('mobile-menu-active') && searchContainer) {
                if (!document.querySelector('.search-container.mobile-visible')) {
                    const mobileSearchContainer = searchContainer.cloneNode(true);
                    mobileSearchContainer.classList.add('mobile-visible');
                    const mobileSearchInput = mobileSearchContainer.querySelector('.search-input');
                    if (mobileSearchInput) {
                        mobileSearchInput.classList.add('mobile-visible');
                    }
                    navLinks.appendChild(mobileSearchContainer);
                    
                    // Add event listener to the cloned search button
                    const mobileSearchBtn = mobileSearchContainer.querySelector('.search-btn');
                    
                    if (mobileSearchBtn && mobileSearchInput) {
                        mobileSearchBtn.addEventListener('click', function() {
                            const searchTerm = mobileSearchInput.value.trim();
                            if (searchTerm) {
                                alert(`Mencari: "${searchTerm}"\nFitur pencarian akan segera tersedia.`);
                            }
                        });
                    }
                }
            } else {
                // Remove mobile search when menu is closed
                const mobileSearch = document.querySelector('.search-container.mobile-visible');
                if (mobileSearch) {
                    mobileSearch.remove();
                }
            }
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (document.body.classList.contains('mobile-menu-active') && 
            !navLinks.contains(event.target) && 
            !hamburger.contains(event.target)) {
            document.body.classList.remove('mobile-menu-active');
            hamburger.textContent = '☰';
            
            // Remove mobile search when menu is closed
            const mobileSearch = document.querySelector('.search-container.mobile-visible');
            if (mobileSearch) {
                mobileSearch.remove();
            }
        }
    });

    // Handle dropdown in mobile view
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth <= 992) {
                e.preventDefault();
                const parentDropdown = this.closest('.nav-dropdown');
                
                // Close all other dropdowns
                document.querySelectorAll('.nav-dropdown').forEach(dropdown => {
                    if (dropdown !== parentDropdown) {
                        dropdown.classList.remove('open');
                    }
                });
                
                // Toggle current dropdown
                parentDropdown.classList.toggle('open');
            }
        });
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('.nav-links a:not(.dropdown-toggle):not(.dropdown-item)').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            // Skip for non-hash links (like login/register)
            if (!targetId.startsWith('#')) return;
            
            e.preventDefault();
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                // Calculate header height dynamically
                const headerHeight = document.querySelector('.header').offsetHeight;
                
                window.scrollTo({
                    top: targetElement.offsetTop - headerHeight,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                if (document.body.classList.contains('mobile-menu-active')) {
                    document.body.classList.remove('mobile-menu-active');
                    hamburger.textContent = '☰';
                    
                    // Remove mobile search when menu is closed
                    const mobileSearch = document.querySelector('.search-container.mobile-visible');
                    if (mobileSearch) {
                        mobileSearch.remove();
                    }
                }
            }
        });
    });

    // CTA Button click handler
    const ctaButton = document.querySelector('.cta-button');
    if (ctaButton && ctaButton.getAttribute('href') === '#') {
        ctaButton.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Terima kasih atas minat Anda! Silakan hubungi sekolah untuk informasi pendaftaran lebih lanjut.');
        });
    }

    // Search functionality
    const searchBtn = document.querySelector('.search-btn');
    const searchInput = document.querySelector('.search-input');
    
    if (searchBtn && searchInput) {
        searchBtn.addEventListener('click', function() {
            const searchTerm = searchInput.value.trim();
            if (searchTerm) {
                alert(`Mencari: "${searchTerm}"\nFitur pencarian akan segera tersedia.`);
            }
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchBtn.click();
            }
        });
    }

    // Animated counter for statistics
    function animateCounters() {
        const statNumbers = document.querySelectorAll('.stat-number');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const finalNumber = parseInt(target.textContent) || 0;
                    
                    animateNumber(target, finalNumber);
                    observer.unobserve(target);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(stat => {
            observer.observe(stat);
        });
    }

    function animateNumber(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toString();
        }, 30);
    }

    // Initialize counter animation
    animateCounters();

    // Scroll-triggered animations for cards
    function addScrollAnimations() {
        const cards = document.querySelectorAll('.staff-card, .vm-card, .facility-card, .activity-card, .stat-item, .gallery-item');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    }

    // Initialize scroll animations
    addScrollAnimations();

    // Navbar background change on scroll
    const header = document.querySelector('.header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
            header.style.backdropFilter = 'blur(10px)';
            header.style.boxShadow = '0 2px 12px rgba(0,0,0,0.1)';
        } else {
            header.style.backgroundColor = '#ffffff';
            header.style.backdropFilter = 'none';
            header.style.boxShadow = '0 2px 8px rgba(34,197,94,0.08)';
        }
    });

    // Scroll spy for navigation
    function updateActiveNav() {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-links a:not(.dropdown-toggle):not(.dropdown-item)');
        
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (window.pageYOffset >= (sectionTop - 150)) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    }

    // Call updateActiveNav on scroll
    window.addEventListener('scroll', updateActiveNav);
    
    // Scroll to top button
    function createScrollToTop() {
        const scrollBtn = document.createElement('button');
        scrollBtn.classList.add('scroll-to-top');
        scrollBtn.innerHTML = '↑';
        document.body.appendChild(scrollBtn);
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 500) {
                scrollBtn.classList.add('visible');
            } else {
                scrollBtn.classList.remove('visible');
            }
        });
        
        scrollBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Initialize scroll to top button
    createScrollToTop();
    
    // Add hover effects to buttons
    function addButtonEffects() {
        const buttons = document.querySelectorAll('.cta-button, .search-btn, button');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    }
    
    // Initialize button effects
    addButtonEffects();
    
    // Fix for mobile viewport height issues
    function fixMobileViewportHeight() {
        const setVH = () => {
            let vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        };
        
        setVH();
        window.addEventListener('resize', setVH);
    }
    
    // Initialize viewport height fix
    fixMobileViewportHeight();
    
    // Handle orientation change for better mobile experience
    window.addEventListener('orientationchange', function() {
        // Small timeout to ensure the browser has completed the orientation change
        setTimeout(function() {
            fixMobileViewportHeight();
            
            // Force redraw of elements that might be affected
            const sections = document.querySelectorAll('section');
            sections.forEach(section => {
                section.style.display = 'none';
                section.offsetHeight; // Force redraw
                section.style.display = '';
            });
        }, 200);
    });
    
    // Improve touch interactions for mobile
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
        
        // Make dropdowns work better on touch devices
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('touchstart', function(e) {
                if (window.innerWidth > 992) {
                    e.preventDefault();
                    const parentDropdown = this.closest('.nav-dropdown');
                    
                    // Close all other dropdowns
                    document.querySelectorAll('.nav-dropdown').forEach(dropdown => {
                        if (dropdown !== parentDropdown) {
                            dropdown.classList.remove('open');
                        }
                    });
                    
                    // Toggle current dropdown
                    parentDropdown.classList.toggle('open');
                }
            });
        });
    }

    // Console welcome message
    console.log('%c🎓 Selamat datang di SD Normal Islam 2 Samarinda! 🎓', 'color: #22c55e; font-size: 16px; font-weight: bold;');
    console.log('%cWebsite ini dibuat dengan ❤️ untuk pendidikan yang berkualitas', 'color: #666; font-size: 12px;');
});