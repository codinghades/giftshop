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
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update the quantity.']);
    }
?>