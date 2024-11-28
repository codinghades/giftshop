<?php
    require_once 'connection.php';
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'You must be logged in.']);
        exit();
    }

    if (!isset($_POST['product_id']) || !isset($_POST['action'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid parameters.']);
        exit();
    }

    $product_id = $_POST['product_id'];
    $action = $_POST['action'];
    $user_id = $_SESSION['user_id'];

    if ($action === 'add') {
        $query = "UPDATE `cart` SET quantity = quantity + 1 WHERE id = '$product_id' AND user_id = '$user_id'";
    } elseif ($action === 'minus') {
        $query = "UPDATE `cart` SET quantity = GREATEST(quantity - 1, 1) WHERE id = '$product_id' AND user_id = '$user_id'";
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit();
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch updated subtotal for the specific product
        $productQuery = "SELECT quantity, price FROM `cart` WHERE id = '$product_id' AND user_id = '$user_id'";
        $productResult = mysqli_query($conn, $productQuery);
        $productData = mysqli_fetch_assoc($productResult);

        $subtotal = $productData['quantity'] * $productData['price'];

        // Fetch overall total for the cart
        $totalQuery = "SELECT SUM(quantity * price) AS grand_total FROM `cart` WHERE user_id = '$user_id'";
        $totalResult = mysqli_query($conn, $totalQuery);
        $totalData = mysqli_fetch_assoc($totalResult);

        $grand_total = $totalData['grand_total'];

        echo json_encode([
            'success' => true,
            'subtotal' => number_format($subtotal, 2),
            'grand_total' => number_format($grand_total, 2)
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update the quantity.']);
    }
?>
