<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KCP Database Setup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0b0d10; color: #f6f7fb; }
        .setup-container { padding: 3rem 0; }
        .setup-card { background: linear-gradient(180deg, #111317, #1b1f27); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 2rem; }
        .btn-primary { background: linear-gradient(135deg, #ff3b2f, #ff7b36); border: none; }
        .alert-success { background: rgba(0, 255, 0, 0.1); border: 1px solid rgba(0, 255, 0, 0.3); color: #00ff00; }
        .alert-info { background: rgba(0, 255, 229, 0.1); border: 1px solid rgba(0, 255, 229, 0.3); color: #00ffe5; }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="setup-card">
                        <h2 class="text-center mb-4">KCP Database Setup</h2>
                        <p class="text-center text-muted mb-4">This will set up your database with sample data and images</p>
                        
                        <?php
                        if (isset($_POST['setup'])) {
                            echo '<div class="alert alert-info">Starting setup process...</div>';
                            
                            // Create uploads directory
                            $uploadDir = 'uploads/parts/';
                            if (!file_exists($uploadDir)) {
                                mkdir($uploadDir, 0777, true);
                                echo '<div class="alert alert-success">✓ Created uploads directory</div>';
                            }
                            
                            // Create high-quality product images
                            echo '<h5>Creating high-quality product images...</h5>';
                            include 'download-real-images.php';
                            echo '<div class="alert alert-success">✓ High-quality product images created</div>';
                            
                            // Add sample data
                            echo '<h5>Adding sample data to database...</h5>';
                            include 'add-sample-data.php';
                            echo '<div class="alert alert-success">✓ Sample data added to database</div>';
                            
                            echo '<div class="alert alert-success mt-4">';
                            echo '<h5>Setup Complete!</h5>';
                            echo '<p>Your database has been set up with:</p>';
                            echo '<ul>';
                            echo '<li>10 Categories</li>';
                            echo '<li>10 Car brands</li>';
                            echo '<li>25 Car models</li>';
                            echo '<li>50 Products with images</li>';
                            echo '</ul>';
                            echo '<div class="mt-3">';
                            echo '<a href="products_view.php" class="btn btn-primary me-2">View Products (Admin)</a>';
                            echo '<a href="../User/browse.php" class="btn btn-outline-light">Browse Products (User)</a>';
                            echo '</div>';
                            echo '</div>';
                        } else {
                        ?>
                        
                        <div class="text-center">
                            <div class="alert alert-info">
                                <h5>What will this setup do?</h5>
                                <ul class="text-start">
                                    <li>Add 10 product categories</li>
                                    <li>Add 10 car brands and 25 models</li>
                                    <li>Add 50 sample products to your database</li>
                                    <li>Create uploads directory</li>
                                </ul>
                            </div>
                            
                            <form method="POST">
                                <button type="submit" name="setup" class="btn btn-primary btn-lg">
                                    <i class="fas fa-database me-2"></i>Setup Database
                                </button>
                            </form>
                        </div>
                        
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>