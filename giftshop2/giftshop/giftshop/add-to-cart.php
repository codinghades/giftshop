<!-- <?php
session_start();
header('Content-Type: application/json');

// Check if product ID is set
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Initialize cart in session if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to cart
    $_SESSION['cart'][] = [
        'product_id' => $product_id,
        'product_image' => $_POST['product_image'],
        'product_name' => $_POST['product_name'],
        'price' => $_POST['price'],
        'discount' => $_POST['discount'],
    ];

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?> -->