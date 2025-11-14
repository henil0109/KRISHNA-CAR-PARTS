<!-- header1.php -->
<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  $currentPage = basename($_SERVER['PHP_SELF']);
  $isLoggedIn = isset($_SESSION['user_id']);
  $userName = $isLoggedIn ? $_SESSION['user_name'] : '';
?>

<header class="kk-header py-2">
  <div class="container-xl d-flex align-items-center justify-content-between">

    <!-- Logo -->
    <a href="index.php" class="kk-logo d-flex align-items-center">
      <img src="../assets/images/kcp.png" alt="Krishna Car Parts" height="48" class="me-2">
      <span class="fw-bold text-white d-none d-sm-inline">Krishna Car Parts</span>
    </a>

    <!-- Navigation + Login (desktop) -->
    <div class="d-none d-md-flex align-items-center gap-4">
      <nav class="d-flex gap-4">
        <a href="index.php"
           class="kk-nav-link <?= ($currentPage == 'index.php') ? 'active' : '' ?>">
           Home
        </a>
        <a href="browse.php"
           class="kk-nav-link <?= ($currentPage == 'browse.php') ? 'active' : '' ?>">
           Browse Parts
        </a>
        <a href="index.php#why-kcp"
           class="kk-nav-link about-link">
           About
        </a>
        <a href="contact.php"
           class="kk-nav-link <?= ($currentPage == 'contact.php') ? 'active' : '' ?>">
           Contact
        </a>
      </nav>

      <!-- User Authentication -->
      <?php if ($isLoggedIn): ?>
        <div class="d-flex align-items-center gap-3">
          <!-- Cart Icon -->
          <div class="position-relative">
            <a href="cart.php" class="cart-icon">
              <i class="fas fa-shopping-cart"></i>
              <span class="cart-badge" id="cartCount">0</span>
            </a>
          </div>
          
          <!-- Wishlist Icon -->
          <div class="position-relative">
            <a href="wishlist.php" class="wishlist-icon">
              <i class="fas fa-heart"></i>
              <span class="wishlist-badge" id="wishlistCount">0</span>
            </a>
          </div>
          
          <!-- Profile Button -->
          <a href="user-dashboard.php" class="btn-profile">
            <i class="fas fa-user-circle me-2"></i><?php echo htmlspecialchars($userName); ?>
          </a>
        </div>
      <?php else: ?>
        <a href="login.php" class="btn-login <?= ($currentPage == 'login.php') ? 'active' : '' ?>">
          Login
        </a>
      <?php endif; ?>
    </div>

    <!-- Mobile Menu Toggle -->
    <button class="btn btn-glass d-md-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
      <i class="fa-solid fa-bars"></i>
    </button>
  </div>
</header>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-end bg-dark text-white" id="mobileMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column gap-3">
    <a href="index.php"
       class="kk-nav-link <?= ($currentPage == 'index.php') ? 'active' : '' ?>">
       Home
    </a>
    <a href="browse.php"
       class="kk-nav-link <?= ($currentPage == 'browse.php') ? 'active' : '' ?>">
       Browse Parts
    </a>
    <a href="index.php#why-kcp"
       class="kk-nav-link about-link">
       About
    </a>
    <a href="contact.php"
       class="kk-nav-link <?= ($currentPage == 'contact.php') ? 'active' : '' ?>">
       Contact
    </a>

    <!-- Mobile User Authentication -->
    <?php if ($isLoggedIn): ?>
      <div class="border-top pt-3 mt-3">
        <div class="d-flex align-items-center mb-3">
          <i class="fas fa-user-circle me-2 text-info"></i>
          <span><?php echo htmlspecialchars($userName); ?></span>
        </div>
        <a href="profile.php" class="kk-nav-link"><i class="fas fa-user me-2"></i>Profile</a>
        <a href="change-password.php" class="kk-nav-link"><i class="fas fa-key me-2"></i>Change Password</a>
        <a href="logout.php" class="btn-login mt-2"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
      </div>
    <?php else: ?>
      <a href="login.php" class="btn-login <?= ($currentPage == 'login.php') ? 'active' : '' ?>">
        Login
      </a>
    <?php endif; ?>
  </div>
</div>

<style>
  :root {
    --kk-accent: #ff7b36;   /* bright orange */
    --kk-accent-2: #3fa9f5; /* bright blue */
  }

  /* ======= LOGIN BUTTON ======= */
  .btn-login {
    background: linear-gradient(135deg, var(--kk-accent), var(--kk-accent-2));
    border: none;
    padding: .55rem 1.2rem;
    border-radius: 12px;
    font-weight: 600;
    color: #fff !important;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(0,0,0,0.25);
  }
  .btn-login:hover {
    background: linear-gradient(135deg, var(--kk-accent-2), var(--kk-accent));
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.35);
  }

  /* ======= HEADER ======= */
  .kk-header {
    position: sticky;
    top: 0;
    z-index: 1030;
    border-bottom: 1px solid rgba(255, 255, 255, .08);
    backdrop-filter: blur(14px);
    background: rgba(17, 19, 23, 0.55);
    overflow: hidden;
  }

  /* Moving gradient overlay */
  .kk-header::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg,
        var(--kk-accent),
        var(--kk-accent-2),
        #ff7b36,
        var(--kk-accent));
    background-size: 300% 300%;
    animation: gradientMove 8s linear infinite;
    opacity: .18;
    pointer-events: none;
  }
  @keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  /* Remove blue outline from logo */
  .kk-logo {
    text-decoration: none !important;
    outline: none !important;
    color: inherit;
  }
  .kk-logo:focus,
  .kk-logo:active {
    outline: none !important;
    text-decoration: none !important;
  }

  /* Navigation links */
  .kk-nav-link {
    color: #f6f7fb;
    font-weight: 600;
    letter-spacing: .3px;
    position: relative;
    text-decoration: none;
    outline: none;
    transition: color .3s ease;
  }
  .kk-nav-link:hover {
    color: var(--kk-accent-2);
  }
  .kk-nav-link:focus,
  .kk-nav-link:active {
    outline: none;
    box-shadow: none;
    text-decoration: none;
    color: var(--kk-accent-2);
  }

  /* Highlight active page */
  .kk-nav-link.active,
  .kk-nav-link.about-link.active {
    color: var(--kk-accent-2);
    font-weight: 700;
  }
  .kk-nav-link.active::after,
  .kk-nav-link.about-link.active::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: -4px;
    height: 2px;
    background: linear-gradient(90deg, var(--kk-accent), var(--kk-accent-2));
    border-radius: 2px;
  }

  /* Glass button (menu toggle) */
  .btn-glass {
    background: rgba(255, 255, 255, .08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, .1);
    color: #fff;
    font-weight: 700;
    padding: .6rem .9rem;
    border-radius: 12px;
  }
  .btn-glass:hover {
    color: var(--kk-accent-2);
  }
  
  /* Profile Button */
  .btn-profile {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .btn-profile:hover {
    background: rgba(255, 255, 255, 0.15);
    color: var(--kk-accent-2);
  }
  
  .dropdown-menu {
    background: rgba(17, 19, 23, 0.95) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    border-radius: 12px !important;
    backdrop-filter: blur(20px);
    z-index: 99999 !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
    position: absolute !important;
  }
  
  .dropdown {
    z-index: 99999 !important;
    position: relative !important;
  }
  
  .dropdown-item {
    color: #f6f7fb;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
  }
  
  .dropdown-item:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--kk-accent-2);
  }
  
  /* Cart and Wishlist Icons */
  .cart-icon, .wishlist-icon {
    color: #fff;
    font-size: 1.5rem;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
  }
  
  .cart-icon:hover, .wishlist-icon:hover {
    color: var(--kk-accent-2);
    transform: scale(1.1);
  }
  
  .cart-badge, .wishlist-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: var(--kk-accent);
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    min-width: 20px;
  }
  
  .dropdown-toggle::after {
    margin-left: 0.5rem;
  }
  
  .dropdown-menu {
    min-width: 200px;
    margin-top: 0.5rem;
  }
  
  .dropdown-divider {
    border-color: rgba(255, 255, 255, 0.1);
  }
</style>

<script>
  // Highlight "About" only when scrolling inside its section
  document.addEventListener("scroll", () => {
    const section = document.getElementById("why-kcp");
    const aboutLinks = document.querySelectorAll(".about-link");

    if (section) {
      const rect = section.getBoundingClientRect();
      if (rect.top <= 100 && rect.bottom >= 100) {
        aboutLinks.forEach(a => a.classList.add("active"));
      } else {
        aboutLinks.forEach(a => a.classList.remove("active"));
      }
    }
  });
  
  // Update cart and wishlist counts
  function updateHeaderCounts() {
    fetch('get-counts.php')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const cartBadge = document.getElementById('cartCount');
        const wishlistBadge = document.getElementById('wishlistCount');
        
        if (cartBadge) cartBadge.textContent = data.cart_count || 0;
        if (wishlistBadge) wishlistBadge.textContent = data.wishlist_count || 0;
      }
    })
    .catch(error => console.error('Error updating counts:', error));
  }
  
  // Load counts on page load
  document.addEventListener('DOMContentLoaded', function() {
    updateHeaderCounts();
    // Also update immediately with session data
    <?php if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])): ?>
    const cartCount = <?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?>;
    const cartBadge = document.getElementById('cartCount');
    if (cartBadge) cartBadge.textContent = cartCount;
    <?php endif; ?>
  });
  
  // Update counts every 30 seconds
  setInterval(updateHeaderCounts, 30000);
</script>
