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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        body { background: #0b0d10; color: #f6f7fb; }
        .product-card { background: #1b1f27; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem; margin-bottom: 1rem; }
        .product-image { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; }
        .price { color: #ff3b2f; font-weight: bold; font-size: 1.2rem; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Browse Products</h2>
        
        <div class="row">
            <?php
            $sql = "SELECT p.*, c.category_name, m.model_name FROM products_tbl p LEFT JOIN categories_tbl c ON p.category_id = c.category_id LEFT JOIN models_tbl m ON p.model_id = m.model_id";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($product = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-md-4 mb-3">
                <div class="product-card">
                    <img src="../Admin/uploads/parts/<?php echo $product['part_image']; ?>" class="product-image" alt="<?php echo $product['part_name']; ?>" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgZmlsbD0iIzMzMzMzMyIvPjx0ZXh0IHg9IjIwMCIgeT0iMTUwIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTYiIGZpbGw9IndoaXRlIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5ObyBJbWFnZTwvdGV4dD48L3N2Zz4='">
                    <h5 class="mt-2"><?php echo $product['part_name']; ?></h5>
                    <p class="text-muted"><?php echo $product['category_name']; ?> - <?php echo $product['model_name']; ?></p>
                    <div class="price">₹<?php echo number_format($product['price']); ?></div>
                    <div class="mt-2">
                        <button class="btn btn-danger btn-sm">Add to Cart</button>
                        <button class="btn btn-outline-light btn-sm">View Details</button>
                    </div>
                </div>
            </div>
            <?php 
                }
            } else {
                echo "<div class='col-12'><div class='alert alert-warning'>No products found in database.</div></div>";
            }
            ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>