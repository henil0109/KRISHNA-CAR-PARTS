<?php
include '../Admin/connection.php';
include 'header1.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Browse Products | Krishna Car Parts</title>
  <link rel="icon" href="../assets/images/kcp.png" type="image/png" />
  
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- Select2 for searchable dropdowns -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
  <!-- Custom CSS -->
  <link href="browse-style.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>

<body>
  <div class="browse-container">
    <div class="container-fluid px-4">
      <div class="row g-4">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 col-md-4">
          <div class="filter-panel">
            <div class="filter-header">
              <h5><i class="fas fa-filter me-2"></i>Filters</h5>
            </div>
            
            <!-- Price Range Filter -->
            <div class="filter-section">
              <h6>Price Range</h6>
              <div class="price-inputs">
                <input type="number" id="minPrice" placeholder="Min" class="form-control">
                <span>to</span>
                <input type="number" id="maxPrice" placeholder="Max" class="form-control">
              </div>
              <div class="price-slider">
                <input type="range" id="priceRange" min="0" max="50000" value="50000" class="form-range">
                <div class="price-display">₹0 - ₹<span id="priceValue">50000</span></div>
              </div>
            </div>

            <!-- Category Filter -->
            <div class="filter-section">
              <h6>Category</h6>
              <select id="categoryFilter" class="form-select filter-dropdown">
                <option value="">All Categories</option>
                <?php
                $categories = mysqli_query($conn, "SELECT * FROM categories_tbl ORDER BY category_name");
                while($cat = mysqli_fetch_assoc($categories)) {
                ?>
                <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['category_name']; ?></option>
                <?php } ?>
              </select>
            </div>

            <!-- Model Filter -->
            <div class="filter-section">
              <h6>Car Model</h6>
              <select id="modelFilter" class="form-select filter-dropdown">
                <option value="">All Models</option>
                <?php
                $models = mysqli_query($conn, "SELECT DISTINCT model_name, model_id FROM models_tbl ORDER BY model_name");
                while($model = mysqli_fetch_assoc($models)) {
                ?>
                <option value="<?php echo $model['model_id']; ?>"><?php echo $model['model_name']; ?></option>
                <?php } ?>
              </select>
            </div>

            <!-- Stock Status -->
            <div class="filter-section">
              <h6>Availability</h6>
              <select id="stockFilter" class="form-select filter-dropdown">
                <option value="">All Stock</option>
                <option value="in_stock">In Stock</option>
                <option value="low_stock">Low Stock</option>
              </select>
            </div>
            
            <!-- Filter Actions -->
            <div class="filter-actions">
              <button class="btn-apply" onclick="filterProducts()">Apply Filters</button>
              <button class="btn-clear" onclick="clearFilters()">Clear All</button>
            </div>
          </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9 col-md-8">
          <div class="products-header">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div>
                <h4>Browse Products</h4>
                <p class="text-muted">Find the perfect parts for your vehicle</p>
              </div>
              <div class="sort-controls">
                <select id="sortBy" class="form-select">
                  <option value="name_asc">Name A-Z</option>
                  <option value="name_desc">Name Z-A</option>
                  <option value="price_asc">Price Low to High</option>
                  <option value="price_desc">Price High to Low</option>
                  <option value="newest">Newest First</option>
                </select>
              </div>
            </div>
          </div>

          <div id="productsContainer">
            <?php
            // Load products directly
            $sql = "SELECT p.*, c.category_name, m.model_name FROM products_tbl p LEFT JOIN categories_tbl c ON p.category_id = c.category_id LEFT JOIN models_tbl m ON p.model_id = m.model_id ORDER BY c.category_name, p.part_name";
            $result = mysqli_query($conn, $sql);
            
            $currentCategory = '';
            $products = [];
            
            // Group products by category
            while($product = mysqli_fetch_assoc($result)) {
                $products[$product['category_name']][] = $product;
            }
            
            // Display products by category
            foreach($products as $categoryName => $categoryProducts) {
            ?>
            <div class="category-section">
                <div class="category-header">
                    <h4><?php echo $categoryName; ?></h4>
                    <span class="category-count"><?php echo count($categoryProducts); ?> items</span>
                </div>
                <div class="products-grid">
                    <?php foreach($categoryProducts as $product) { 
                        // Generate placeholder image data URL
                        $placeholderSvg = 'data:image/svg+xml;base64,' . base64_encode('<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="300" fill="#2c3e50"/><rect x="10" y="10" width="380" height="280" fill="none" stroke="#34495e" stroke-width="2"/><text x="200" y="140" font-family="Arial" font-size="18" fill="#ecf0f1" text-anchor="middle">' . htmlspecialchars($product['part_name']) . '</text><text x="200" y="170" font-family="Arial" font-size="14" fill="#bdc3c7" text-anchor="middle">Krishna Car Parts</text></svg>');
                        
                        $stockStatus = '';
                        $stockClass = '';
                        if ($product['stock'] > $product['reorder_level']) {
                            $stockStatus = 'In Stock';
                            $stockClass = 'in-stock';
                        } elseif ($product['stock'] > 0) {
                            $stockStatus = 'Low Stock';
                            $stockClass = 'low-stock';
                        } else {
                            $stockStatus = 'Out of Stock';
                            $stockClass = 'out-of-stock';
                        }
                    ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="../assets/images/<?php echo $product['part_image']; ?>" alt="<?php echo htmlspecialchars($product['part_name']); ?>" onerror="this.src='<?php echo $placeholderSvg; ?>'">
                            <div class="stock-badge <?php echo $stockClass; ?>"><?php echo $stockStatus; ?></div>
                        </div>
                        <div class="product-info">
                            <h6 class="product-title"><?php echo htmlspecialchars($product['part_name']); ?></h6>
                            <div class="product-meta">
                                <span><?php echo htmlspecialchars($product['category_name']); ?></span>
                                <span><?php echo htmlspecialchars($product['model_name']); ?></span>
                            </div>
                            <div class="product-price">₹<?php echo number_format($product['price']); ?></div>
                            <div class="product-actions">
                                <button class="btn-action btn-primary-action" onclick="console.log('Button clicked:', <?php echo $product['product_id']; ?>); addToCart(<?php echo $product['product_id']; ?>);" data-product-id="<?php echo $product['product_id']; ?>">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                                <button class="btn-action btn-icon-only" onclick="addToWishlist(<?php echo $product['product_id']; ?>)" title="Add to Wishlist">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="btn-action btn-icon-only" onclick="inquireProduct(<?php echo $product['product_id']; ?>)" title="Inquire">
                                    <i class="fas fa-question-circle"></i>
                                </button>
                            </div>
                            <button class="btn-action btn-secondary-action mt-2" onclick="window.location.href='product-detail-page.php?id=<?php echo $product['product_id']; ?>'">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
          </div>


        </div>
      </div>
    </div>
  </div>

  <!-- Product Modal -->
  <div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Product Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="modalBody">
          <!-- Product details will be loaded here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notifications -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="actionToast" class="toast" role="alert">
      <div class="toast-header">
        <i class="fas fa-check-circle text-success me-2"></i>
        <strong class="me-auto">Success</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body" id="toastMessage">
        Action completed successfully!
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="browse-script.js?v=<?php echo time(); ?>"></script>
  <script>
    // Test if addToCart function is available
    console.log('addToCart function available:', typeof addToCart);
    
    // Alternative add to cart function if main one fails
    function testAddToCart(productId) {
        console.log('testAddToCart called with:', productId);
        addToCart(productId);
    }
  </script>
</body>
</html>