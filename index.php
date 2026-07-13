<?php include('navbar.php'); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mt-lg-0" data-aos="fade-right">
                <h1 class="hero-title">Professional Care for Your Vehicle</h1>
                <p class="hero-desc">Connect with certified, top-rated local mechanics in seconds. Fast, reliable, and transparent auto repairs at your convenience.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="findmacanic.php" class="btn-ripple btn-custom px-4 py-3">
                        <i class="fas fa-search me-2"></i> Book a Mechanic
                    </a>
                    <a href="about.php" class="btn btn-outline-secondary px-4 py-3 border-2 font-weight-bold" style="border-radius:10px;">
                        Learn More
                    </a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="illustration-container">
                    <img src="images/banner3.png" alt="Mechanic Services" class="illustration-img">
                    <div class="floating-badge floating-badge-1">
                        <div class="metric-icon" style="width: 40px; height: 40px; font-size:16px;">
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">4.9 Star Rating</h6>
                            <small class="text-muted">From 2k+ reviews</small>
                        </div>
                    </div>
                    <div class="floating-badge floating-badge-2">
                        <div class="metric-icon" style="width: 40px; height: 40px; font-size:16px; background: rgba(16, 185, 129, 0.08); color: var(--success);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Verified Pros</h6>
                            <small class="text-muted">100% certified</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Section -->
<div class="container my-5">
    <div class="card card-glass text-center p-4" data-aos="fade-up">
        <h3 class="mb-4">How It Works</h3>
        <img src="images/t1.png" alt="Timeline" class="img-fluid rounded-3" style="max-height: 250px; object-fit: contain;">
    </div>
</div>

<!-- Benefits Section -->
<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
            <div class="card p-4">
                <h3 class="mb-3">Why Choose GoMechanic?</h3>
                <p class="text-secondary">We offer a transparent experience, connecting you directly with qualified local professionals. Save time, skip the queue, and enjoy premium assistance when you need it most.</p>
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="metric-icon me-3" style="width: 40px; height: 40px; font-size:16px;">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Comprehensive Inspections</h6>
                            <p class="text-muted small mb-0">Complete vehicle diagnosis & repair solutions.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="metric-icon me-3" style="width: 40px; height: 40px; font-size:16px;">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Secure Transactions</h6>
                            <p class="text-muted small mb-0">Traceable payments and secure digital invoice histories.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <img src="images/benefits.png" alt="Benefits" class="img-fluid rounded-4 shadow-lg w-100">
        </div>
    </div>
</div>

<!-- Call-to-Action Section -->
<div class="my-5 py-5 text-center bg-light-subtle border-top border-bottom" style="background: rgba(37, 99, 235, 0.03);">
    <div class="container" data-aos="zoom-in">
        <h2 class="fw-bold mb-2">Service Due? Car Trouble?</h2>
        <p class="text-secondary mb-4">Wait no more, get started with GoMechanic today!</p>
        <a href="userregistration.php" class="btn btn-custom px-5 py-3 font-weight-bold">Get Started Now</a>
    </div>
</div>

<!-- Reach Section -->
<div class="container my-5" data-aos="fade-up">
    <div class="card p-4 text-center">
        <h3 class="mb-4">Our Growing Network</h3>
        <img src="images/reach.png" alt="Reach" class="img-fluid rounded-3" style="max-height: 280px; object-fit: contain;">
    </div>
</div>

<!-- Customer Reviews Section -->
<div class="container my-5 mb-5 pb-5">
    <h2 class="text-center mb-4 font-weight-bold">What Our Customers Say</h2>
    <div id="reviewCarousel" class="carousel slide mt-3 card p-2" data-bs-ride="carousel" data-aos="fade-up">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#reviewCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#reviewCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/rev1.png" class="d-block w-100 rounded-3" alt="First Review">
            </div>
            <div class="carousel-item">
                <img src="images/rev2.png" class="d-block w-100 rounded-3" alt="Second Review">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(1);"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(1);"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<?php include('footer.php'); ?>

