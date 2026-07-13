/**
 * Online Auto Mechanic Finder - Global JS (2026 Modern Enhancements)
 */

document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize Dark/Light Mode Theme
    initTheme();

    // 2. Inject Page Loader Overlay (if not already present)
    injectLoader();

    // 3. Inject Scroll Progress Bar
    injectScrollProgress();

    // 4. Inject Back-to-Top Button
    injectBackToTop();

    // 5. Password Visibility Toggles
    setupPasswordToggles();

    // 6. Interactive Button Ripples
    setupButtonRipples();
});

// Theme Management
function initTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    document.body.setAttribute('data-theme', savedTheme);

    // Sync switch state if it exists on page
    const themeToggles = document.querySelectorAll('.theme-toggle-btn');
    themeToggles.forEach(toggle => {
        if (savedTheme === 'dark') {
            toggle.classList.add('active');
            toggle.innerHTML = '<i class="fas fa-sun"></i>';
        } else {
            toggle.classList.remove('active');
            toggle.innerHTML = '<i class="fas fa-moon"></i>';
        }

        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const currentTheme = document.documentElement.getAttribute('data-theme');
            let newTheme = 'light';
            if (currentTheme === 'light') {
                newTheme = 'dark';
                toggle.innerHTML = '<i class="fas fa-sun"></i>';
                toggle.classList.add('active');
            } else {
                toggle.innerHTML = '<i class="fas fa-moon"></i>';
                toggle.classList.remove('active');
            }
            
            document.documentElement.setAttribute('data-theme', newTheme);
            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    });
}

// Inject Scroll Progress Bar
function injectScrollProgress() {
    const progressContainer = document.createElement('div');
    progressContainer.className = 'scroll-progress-container';
    
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress-bar';
    progressBar.id = 'scrollProgress';
    
    progressContainer.appendChild(progressBar);
    document.body.appendChild(progressContainer);

    window.addEventListener('scroll', function() {
        const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        document.getElementById('scrollProgress').style.width = scrolled + "%";
    });
}

// Inject Back to Top Button
function injectBackToTop() {
    const btn = document.createElement('button');
    btn.className = 'back-to-top';
    btn.id = 'backToTop';
    btn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    document.body.appendChild(btn);

    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            btn.classList.add('show');
        } else {
            btn.classList.remove('show');
        }
    });

    btn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Inject Page Loader Overlay
function injectLoader() {
    const loader = document.createElement('div');
    loader.className = 'page-loader';
    loader.innerHTML = `
        <div class="loader-spinner"></div>
        <div class="loader-logo">GoMechanic</div>
    `;
    document.body.appendChild(loader);

    window.addEventListener('load', function() {
        setTimeout(() => {
            loader.classList.add('fade-out');
            setTimeout(() => {
                loader.remove();
            }, 600);
        }, 300);
    });

    // Backup if onload doesn't trigger or is delayed
    setTimeout(() => {
        if (document.body.contains(loader)) {
            loader.classList.add('fade-out');
            setTimeout(() => {
                loader.remove();
            }, 600);
        }
    }, 2000);
}

// Password Visibility Toggles
function setupPasswordToggles() {
    const pwdInputs = document.querySelectorAll('input[type="password"]');
    pwdInputs.forEach(input => {
        const wrapper = document.createElement('div');
        wrapper.className = 'password-wrapper';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        const toggleBtn = document.createElement('span');
        toggleBtn.className = 'password-toggle';
        toggleBtn.innerHTML = '<i class="far fa-eye"></i>';
        wrapper.appendChild(toggleBtn);

        toggleBtn.addEventListener('click', function() {
            if (input.type === 'password') {
                input.type = 'text';
                toggleBtn.innerHTML = '<i class="far fa-eye-slash"></i>';
            } else {
                input.type = 'password';
                toggleBtn.innerHTML = '<i class="far fa-eye"></i>';
            }
        });
    });
}

// Ripple Click Effect on buttons
function setupButtonRipples() {
    const buttons = document.querySelectorAll('.btn-ripple, .btn-custom, input[type="submit"], button');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Avoid issues with quick multiple clicks
            const existingRipple = this.querySelector('.ripple');
            if (existingRipple) {
                existingRipple.remove();
            }

            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
}
