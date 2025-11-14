<!-- landing.php -->
<?php
include 'header1.php';
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Krishna Car Parts | Premium Auto Spares</title>
  <link rel="icon" href="../assets/images/kcp.png" type="image/png" />

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Swiper (product carousel) -->
  <link href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" rel="stylesheet" />

  <!-- AOS (scroll animations) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />

  <style>
    :root {
      --kk-black: #0b0d10;
      --kk-dark: #111317;
      --kk-mid: #1b1f27;
      --kk-accent: #ff3b2f;
      /* neon red */
      --kk-accent-2: #00ffe5;
      /* neon aqua */
      --kk-white: #f6f7fb;
      --glass: rgba(255, 255, 255, 0.08);
    }

    html,
    body {
      background: var(--kk-black);
      color: var(--kk-white);
      scroll-behavior: smooth;
    }

    a {
      text-decoration: none;
    }

    .container-xl {
      max-width: 1200px;
    }

    /* ======= HERO ======= */
    .hero {
      position: relative;
      min-height: 100vh;
      display: flex;
      align-items: center;
      overflow: hidden;
      background: #0a0c10;
    }

    .hero video {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(.5) contrast(1.05);
    }

    .hero::after {
      content: "";
      position: absolute;
      inset: 0;
      background:
        radial-gradient(75rem 50rem at 15% 20%, rgba(255, 59, 47, .25), transparent 60%),
        linear-gradient(90deg, rgba(10, 12, 16, .8) 0%, rgba(10, 12, 16, .35) 45%, rgba(10, 12, 16, .75) 100%);
      pointer-events: none;
    }

    .hero-content {
      position: relative;
      z-index: 3;
      width: 100%;
    }

    .badge-chip {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      padding: .4rem .8rem;
      border-radius: 30px;
      background: rgba(0, 0, 0, .45);
      border: 1px solid rgba(255, 255, 255, .06);
      backdrop-filter: blur(8px);
      font-weight: 600;
      letter-spacing: .4px;
    }

    .hero-title {
      font-size: clamp(2.4rem, 4.8vw, 4.2rem);
      line-height: 1.05;
      font-weight: 800;
      letter-spacing: .6px;
      text-shadow: 0 10px 50px rgba(0, 0, 0, .45);
    }

    .hero-title .accent {
      background: linear-gradient(90deg, var(--kk-accent), #ff7b36);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .hero-sub {
      max-width: 620px;
      color: #d7d9e0;
      opacity: .9
    }

    .cta-wrap {
      display: flex;
      flex-wrap: wrap;
      gap: 14px;
      margin-top: 1rem;
    }

    .btn-neon {
      position: relative;
      overflow: hidden;
      background: linear-gradient(90deg, var(--kk-accent), #ff7b36);
      border: none;
      color: #0b0d10;
      font-weight: 800;
      letter-spacing: .4px;
      padding: .9rem 1.4rem;
      border-radius: 14px;
      box-shadow: 0 10px 30px rgba(255, 59, 47, .35);
      transform: translateZ(0);
    }

    .btn-neon:hover {
      filter: brightness(1.1);
    }

    .btn-glass {
      background: rgba(255, 255, 255, .08);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, .1);
      color: #fff;
      font-weight: 700;
      padding: .9rem 1.2rem;
      border-radius: 14px;
    }

    .info-card {
      position: absolute;
      right: 5vw;
      bottom: 7vh;
      z-index: 3;
      background: rgba(17, 19, 23, .6);
      border: 1px solid rgba(255, 255, 255, .08);
      backdrop-filter: blur(14px);
      border-radius: 16px;
      padding: 1rem 1.2rem;
      width: min(90vw, 360px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, .35);
    }

    .info-row {
      display: flex;
      align-items: center;
      gap: .8rem;
      padding: .5rem 0;
    }

    .info-icon {
      width: 36px;
      height: 36px;
      display: grid;
      place-items: center;
      border-radius: 10px;
      background: rgba(255, 255, 255, .06);
      border: 1px solid rgba(255, 255, 255, .1);
    }

    /* ======= FEATURE CARDS ======= */
    .section {
      padding: 90px 0;
      position: relative;
    }

    .section-title {
      font-size: clamp(1.6rem, 2.5vw, 2.1rem);
      font-weight: 800;
      margin-bottom: 10px;
    }

    .subtitle {
      color: #b7bcc7;
      max-width: 720px
    }

    .feature-card {
      border-radius: 18px;
      background: linear-gradient(180deg, #12151b, #0e1015);
      border: 1px solid rgba(255, 255, 255, .06);
      padding: 26px;
      height: 100%;
      transition: transform .35s ease, box-shadow .35s ease, border-color .35s;
    }

    .feature-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, .35);
      border-color: rgba(255, 255, 255, .12);
    }

    .feature-icon {
      width: 56px;
      height: 56px;
      border-radius: 14px;
      display: grid;
      place-items: center;
      background: linear-gradient(135deg, rgba(0, 255, 229, .18), rgba(0, 255, 229, .04));
      border: 1px solid rgba(0, 255, 229, .25);
      margin-bottom: 14px;
      font-size: 22px;
      color: var(--kk-accent-2);
    }

    /* ======= PRODUCT CAROUSEL ======= */
    .product-card {
      background: #11161c;
      border: 1px solid rgba(255, 255, 255, .06);
      border-radius: 18px;
      overflow: hidden;
      transition: transform .35s ease, box-shadow .35s;
    }

    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 14px 30px rgba(0, 0, 0, .35);
    }

    .product-img {
      height: 210px;
      object-fit: cover;
      width: 100%;
    }

    .tag {
      position: absolute;
      top: 12px;
      left: 12px;
      font-size: .75rem;
      font-weight: 700;
      background: rgba(255, 255, 255, .12);
      border: 1px solid rgba(255, 255, 255, .16);
      padding: .25rem .55rem;
      border-radius: 10px;
    }

    /* ======= TIMELINE ======= */
    .timeline {
      position: relative;
      margin: 40px 0 10px;
    }

    .timeline::before {
      content: "";
      position: absolute;
      left: 50%;
      top: 0;
      bottom: 0;
      width: 4px;
      background: linear-gradient(180deg, rgba(0, 255, 229, .0), rgba(0, 255, 229, .8), rgba(0, 255, 229, .0));
      transform: translateX(-50%);
    }

    .tl-item {
      position: relative;
      width: 50%;
      padding: 0 26px 36px;
    }

    .tl-item:nth-child(odd) {
      left: 0;
      text-align: right;
    }

    .tl-item:nth-child(even) {
      left: 50%;
    }

    .tl-card {
      display: inline-block;
      max-width: 460px;
      background: #10141a;
      border: 1px solid rgba(255, 255, 255, .08);
      padding: 18px 20px;
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, .35);
    }

    .tl-dot {
      position: absolute;
      top: 10px;
      left: calc(50% - 10px);
      width: 20px;
      height: 20px;
      background: var(--kk-accent-2);
      border-radius: 50%;
      box-shadow: 0 0 20px rgba(0, 255, 229, .8), 0 0 40px rgba(0, 255, 229, .35);
      border: 4px solid #0b0d10;
    }

    @media (max-width: 992px) {

      .tl-item,
      .tl-item:nth-child(even),
      .tl-item:nth-child(odd) {
        left: 0;
        width: 100%;
        text-align: left;
      }

      .tl-card {
        max-width: 100%;
      }

      .timeline::before {
        left: 10px;
      }

      .tl-dot {
        left: 0;
        transform: translateX(-50%);
      }
    }

    /* ======= TESTIMONIALS ======= */
    .glass {
      background: rgba(255, 255, 255, .06);
      border: 1px solid rgba(255, 255, 255, .1);
      backdrop-filter: blur(12px);
      border-radius: 16px;
    }

    /* ======= CTA ======= */
    .cta {
      position: relative;
      overflow: hidden;
      border-radius: 24px;
      background: radial-gradient(60rem 40rem at 80% -20%, rgba(255, 59, 47, .35), transparent 60%),
        linear-gradient(135deg, #0f1218, #151a22 60%);
      border: 1px solid rgba(255, 255, 255, .1);
    }

    .cta .btn-neon {
      box-shadow: 0 10px 30px rgba(255, 59, 47, .45);
    }

    /* Simple tire-track accent bottom-left */
    .tire-accent {
      position: absolute;
      left: -120px;
      bottom: -120px;
      width: 360px;
      height: 360px;
      opacity: .14;
      background: conic-gradient(from 140deg at 50% 50%, transparent 0 25%, #fff 25% 30%, transparent 30% 55%, #fff 55% 60%, transparent 60% 85%, #fff 85% 90%, transparent 90% 100%);
      transform: rotate(-18deg);
      filter: blur(1px);
    }
  </style>
</head>

<body>

  <!-- ======= HERO ======= -->
  <header class="hero">
    <!-- Replace with your own MP4 for better brand fit -->
    <video src="./assets/carvid.mp4"
      autoplay muted loop playsinline poster="assets/images/hero-fallback.jpg"></video>

    <div class="container-xl hero-content">
      <div class="row">
        <div class="col-lg-7" data-aos="fade-right" data-aos-duration="900">
          <span class="badge-chip"><i class="fa-solid fa-screwdriver-wrench"></i> Since 2025 • Genuine Auto Spares</span>
          <h1 class="hero-title mt-3">
            Driving <span class="accent">Performance</span>.<br /> Powering <span class="accent">Trust</span>.
          </h1>
          <p class="hero-sub mt-3">
            At <strong>Krishna Car Parts</strong>, we stock premium OEM & high-grade aftermarket parts,
            backed by expert support and fast delivery. If it goes in a car, we can source it.
          </p>
          <div class="cta-wrap">
            <a href="shop.php" class="btn btn-neon"><i class="fa-solid fa-cart-shopping me-2"></i>Explore Products</a>
            <a href="contact.php" class="btn btn-glass"><i class="fa-regular fa-paper-plane me-2"></i>Request a Quote</a>
          </div>
        </div>
      </div>
    </div>

    <div class="info-card" data-aos="zoom-in" data-aos-delay="250">
      <div class="info-row">
        <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
        <div>
          <small class="text-uppercase text-secondary">Call Us 24/7</small>
          <div class="fw-bold">+91 98765 43210</div>
        </div>
      </div>
      <div class="info-row">
        <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
        <div>
          <small class="text-uppercase text-secondary">We are here</small>
          <div class="fw-bold">Pal, Surat, Gujarat</div>
        </div>
      </div>
    </div>
  </header>

  <!-- ======= WHY CHOOSE US ======= -->
  <section id="why-kcp" class="section">
    <div class="container-xl">
      <div class="row align-items-end mb-4">
        <div class="col-lg-8">
          <h2 class="section-title">Why Krishna Car Parts?</h2>
          <p class="subtitle">Premium inventory, transparent pricing and a service-first culture. We don't just sell parts—we keep your car confident on the road.</p>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-md-6 col-lg-3" data-aos="fade-up">
          <div class="feature-card h-100">
            <div class="feature-icon"><i class="fa-solid fa-medal"></i></div>
            <h5 class="fw-bold">Genuine & OEM</h5>
            <p class="mb-0 text-secondary">Authentic components with warranty & certification.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-card h-100">
            <div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div>
            <h5 class="fw-bold">Fast Fulfillment</h5>
            <p class="mb-0 text-secondary">Same-day dispatch for in-stock parts across Gujarat.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-card h-100">
            <div class="feature-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
            <h5 class="fw-bold">Expert Guidance</h5>
            <p class="mb-0 text-secondary">Right part, right fit—our team helps you avoid guesswork.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
          <div class="feature-card h-100">
            <div class="feature-icon"><i class="fa-regular fa-face-smile-beam"></i></div>
            <h5 class="fw-bold">Happy Customers</h5>
            <p class="mb-0 text-secondary">1000+ satisfied car owners, garages & dealers.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= PRODUCT HIGHLIGHTS (Swiper) ======= -->
  <!-- <section class="section pt-0">
  <div class="container-xl">
    <div class="d-flex justify-content-between align-items-end mb-3">
      <h2 class="section-title m-0">Hot Picks</h2>
      <div class="d-none d-md-flex gap-2">
        <button class="btn btn-glass px-3" id="prevBtn"><i class="fa-solid fa-arrow-left"></i></button>
        <button class="btn btn-glass px-3" id="nextBtn"><i class="fa-solid fa-arrow-right"></i></button>
      </div>
    </div>

    <di v class="swiper mySwiper" data-aos="fade-up">
      <div class="swiper-wrapper">

         Card 1 
        <div class="swiper-slide">
          <div class="product-card position-relative">
            <span class="tag">New</span>
            <img class="product-img" src="assets/images/parts/brake.jpg" alt="Brake Pads">
            <div class="p-3">
              <h6 class="mb-1">Ceramic Brake Pads</h6>
              <small class="text-secondary">Longer life • Low dust</small>
            </div>
          </div>
        </div>

        Card 2 
        <div class="swiper-slide">
          <div class="product-card position-relative">
            <span class="tag">Best Seller</span>
            <img class="product-img" src="assets/images/parts/filter.jpg" alt="Air Filter">
            <div class="p-3">
              <h6 class="mb-1">High-Flow Air Filter</h6>
              <small class="text-secondary">Improved intake efficiency</small>
            </div>
          </div>
        </div>

        Card 3 
        <div class="swiper-slide">
          <div class="product-card position-relative">
            <img class="product-img" src="assets/images/parts/suspension.jpg" alt="Suspension Kit">
            <div class="p-3">
              <h6 class="mb-1">Suspension Kit</h6>
              <small class="text-secondary">Ride comfort & control</small>
            </div>
          </div>
        </div>

         Card 4 
        <div class="swiper-slide">
          <div class="product-card position-relative">
            <span class="tag">OEM</span>
            <img class="product-img" src="assets/images/parts/battery.jpg" alt="Car Battery">
            <div class="p-3">
              <h6 class="mb-1">Maintenance-Free Battery</h6>
              <small class="text-secondary">Reliable cold starts</small>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="text-center mt-4 d-md-none">
      <button class="btn btn-glass me-2" id="prevBtnM"><i class="fa-solid fa-arrow-left"></i></button>
      <button class="btn btn-glass" id="nextBtnM"><i class="fa-solid fa-arrow-right"></i></button>
    </div>
  </div>
</section> -->

  <!-- ======= TIMELINE ======= -->
  <section class="section">
    <div class="container-xl position-relative">
      <h2 class="section-title mb-1" data-aos="fade-up">Our Journey</h2>
      <p class="subtitle" data-aos="fade-up" data-aos-delay="80">From a bold idea to a fast-growing auto-spares brand.</p>

      <div class="timeline">
        <!-- 2025 -->
        <span class="tl-dot"></span>
        <div class="tl-item" data-aos="fade-right">
          <div class="tl-card">
            <h5 class="mb-1">2025 — Establishment</h5>
            <p class="text-secondary mb-0">Krishna Car Parts is founded in Surat with a mission to bring genuine, quality spares to every car owner.</p>
          </div>
        </div>
        <!-- 2026 -->
        <div class="tl-item" data-aos="fade-left">
          <div class="tl-card">
            <h5 class="mb-1">2026 — Inventory Expansion</h5>
            <p class="text-secondary mb-0">Scaled to 500+ parts across major brands. Built relationships with authorized distributors.</p>
          </div>
        </div>
        <!-- 2027 -->
        <div class="tl-item" data-aos="fade-right">
          <div class="tl-card">
            <h5 class="mb-1">2027 — 1000+ Customers</h5>
            <p class="text-secondary mb-0">Trusted by garages & enthusiasts. Introduced express delivery inside Gujarat.</p>
          </div>
        </div>
        <!-- 2028 -->
        <div class="tl-item" data-aos="fade-left">
          <div class="tl-card">
            <h5 class="mb-1">2028 — The Road Ahead</h5>
            <p class="text-secondary mb-0">AI-guided part suggestions, VIN-based matching, and a wider nationwide network.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= TESTIMONIALS / TRUST ======= -->
  <section class="section pt-0">
    <div class="container-xl">
      <div class="row g-4">
        <div class="col-lg-4" data-aos="fade-up">
          <div class="glass p-4 h-100">
            <div class="d-flex align-items-center mb-3">
              <img src="assets/images/avatar-4.png" width="52" class="rounded-circle me-3" alt="Customer">
              <div>
                <strong>Harshil M.</strong><br><small class="text-secondary">Garage Owner</small>
              </div>
            </div>
            <p class="mb-2">“They know their parts. Quick sourcing and perfect fit—saves my team hours.”</p>
            <span class="text-warning"><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star-half-stroke"></i></span>
          </div>
        </div>

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
          <div class="glass p-4 h-100">
            <div class="d-flex align-items-center mb-3">
              <img src="assets/images/avatar-4.png" width="52" class="rounded-circle me-3" alt="Customer">
              <div>
                <strong>Prathna S.</strong><br><small class="text-secondary">Car Enthusiast</small>
              </div>
            </div>
            <p class="mb-2">“Loved the genuine parts and speed. My daily driver feels brand new.”</p>
            <span class="text-warning"><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-regular fa-star"></i></span>
          </div>
        </div>

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
          <div class="glass p-4 h-100">
            <div class="d-flex align-items-center mb-3">
              <img src="assets/images/avatar-4.png" width="52" class="rounded-circle me-3" alt="Customer">
              <div>
                <strong>Arpit K.</strong><br><small class="text-secondary">Fleet Manager</small>
              </div>
            </div>
            <p class="mb-2">“Bulk orders and transparent pricing—exactly what our fleet operations needed.”</p>
            <span class="text-warning"><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= CTA ======= -->
  <section class="section">
    <div class="container-xl">
      <div class="cta p-5 position-relative">
        <div class="tire-accent"></div>
        <div class="row align-items-center">
          <div class="col-lg-8">
            <h2 class="mb-2">Your Car Deserves the Best.</h2>
            <p class="mb-0 text-secondary">Get genuine parts, friendly advice, and fast delivery—every single time.</p>
          </div>
          <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <a href="contact.php" class="btn btn-neon"><i class="fa-regular fa-paper-plane me-2"></i>Talk to Us</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Optional: if you use a global footer, include it here -->
  <?php include 'footer.php'; ?>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    // AOS init
    AOS.init({
      once: true,
      duration: 700,
      easing: 'ease-out-quart'
    });

    // Swiper init
    const swiper = new Swiper('.mySwiper', {
      slidesPerView: 1.1,
      spaceBetween: 16,
      breakpoints: {
        576: {
          slidesPerView: 2,
          spaceBetween: 18
        },
        992: {
          slidesPerView: 3,
          spaceBetween: 20
        },
        1200: {
          slidesPerView: 4,
          spaceBetween: 22
        }
      }
    });

    // Carousel controls
    document.getElementById('prevBtn')?.addEventListener('click', () => swiper.slidePrev());
    document.getElementById('nextBtn')?.addEventListener('click', () => swiper.slideNext());
    document.getElementById('prevBtnM')?.addEventListener('click', () => swiper.slidePrev());
    document.getElementById('nextBtnM')?.addEventListener('click', () => swiper.slideNext());
  </script>
</body>

</html>