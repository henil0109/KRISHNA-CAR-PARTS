<?php
include '../Admin/connection.php';

header('Content-Type: application/json');

try {
    // Get filter parameters
    $categories = json_decode($_POST['categories'] ?? '[]', true);
    $models = json_decode($_POST['models'] ?? '[]', true);
    $minPrice = floatval($_POST['minPrice'] ?? 0);
    $maxPrice = floatval($_POST['maxPrice'] ?? 50000);
    $stock = json_decode($_POST['stock'] ?? '[]', true);
    $sortBy = $_POST['sortBy'] ?? 'name_asc';

    // Build the SQL query
    $sql = "SELECT p.*, c.category_name, m.model_name 
            FROM products_tbl p 
            LEFT JOIN categories_tbl c ON p.category_id = c.category_id 
            LEFT JOIN models_tbl m ON p.model_id = m.model_id 
            WHERE p.product_id IS NOT NULL";

    $params = [];
    $types = "";

    // Apply category filter
    if (!empty($categories)) {
        $placeholders = str_repeat('?,', count($categories) - 1) . '?';
        $sql .= " AND p.category_id IN ($placeholders)";
        $params = array_merge($params, $categories);
        $types .= str_repeat('i', count($categories));
    }

    // Apply model filter
    if (!empty($models)) {
        $placeholders = str_repeat('?,', count($models) - 1) . '?';
        $sql .= " AND p.model_id IN ($placeholders)";
        $params = array_merge($params, $models);
        $types .= str_repeat('i', count($models));
    }

    // Apply price filter
    $sql .= " AND p.price BETWEEN ? AND ?";
    $params[] = $minPrice;
    $params[] = $maxPrice;
    $types .= "dd";

    // Apply stock filter
    if (!empty($stock)) {
        $stockConditions = [];
        foreach ($stock as $stockType) {
            if ($stockType === 'in_stock') {
                $stockConditions[] = "p.stock > p.reorder_level";
            } elseif ($stockType === 'low_stock') {
                $stockConditions[] = "(p.stock > 0 AND p.stock <= p.reorder_level)";
            }
        }
        if (!empty($stockConditions)) {
            $sql .= " AND (" . implode(' OR ', $stockConditions) . ")";
        }
    }

    // Apply sorting
    switch ($sortBy) {
        case 'name_asc':
            $sql .= " ORDER BY p.part_name ASC";
            break;
        case 'name_desc':
            $sql .= " ORDER BY p.part_name DESC";
            break;
        case 'price_asc':
            $sql .= " ORDER BY p.price ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY p.price DESC";
            break;
        case 'newest':
            $sql .= " ORDER BY p.product_id DESC";
            break;
        default:
            $sql .= " ORDER BY p.part_name ASC";
    }

    // Prepare and execute the query
    if (!empty($params)) {
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            throw new Exception("Failed to prepare statement: " . mysqli_error($conn));
        }
    } else {
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Query failed: " . mysqli_error($conn));
        }
    }

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = [
            'product_id' => $row['product_id'],
            'part_name' => $row['part_name'],
            'part_description' => $row['part_description'],
            'price' => $row['price'],
            'stock' => $row['stock'],
            'reorder_level' => $row['reorder_level'],
            'part_image' => $row['part_image'],
            'category_name' => $row['category_name'],
            'model_name' => $row['model_name']
        ];
    }

    echo json_encode([
        'success' => true,
        'products' => $products,
        'count' => count($products),
        'debug' => $sql
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

mysqli_close($conn);
?>