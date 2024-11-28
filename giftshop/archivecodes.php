<?php
if (isset($_POST['add-to-cart'])) {
    if (!isset($_SESSION['user_id'])) {
        // If the user is not logged in, redirect to login page
        echo "<script>
                alert('You must be logged in to add items to the cart!');
                window.location.href = 'login.php';
              </script>";
    } else {
        // If the user is logged in, proceed with adding to cart
        $product_name = $_POST['product_name'];
        $product_price = $_POST['price'];
        $product_image = $_POST['product_image'];
        $user_id = $_SESSION['user_id'];
        // $arrival_name = $_POST['arrival_name'];
        // $arrival_price = $_POST['price'];
        // $arrival_image = $_POST['arrival_image'];
        
        
        // Check if the product is already in the cart
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        
        if (mysqli_num_rows($select_cart) > 0) {
            echo "<script>
                alert('Item is already in the cart');
                </script>";
        } else {
            mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image) VALUES('$user_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
            echo "<script>
                alert('Added to cart!');
                </script>";
        }
    }
}

// REMOVE ALL FROM THE CART
if (isset($_GET['clear'])) {
    $stmt = $conn->prepare('DELETE FROM cart');
    $stmt->execute();
    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'All Item removed from the cart!';
    header('location:cart.php');
  }

  if (isset($_POST['order_btn'])) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['inputname'];
    $email = $_POST['inputemail'];
    $address = $_POST['inputaddress'];
    $country = $_POST['inputcountry'];
    $city = $_POST['inputcity'];
    $postal = $_POST['inputpostal'];
    $phone = $_POST['inputphone'];
    $method = $_POST['method'];
    $total_amount = $_POST['total_amount'];

    $select_product = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('Query failed');
    $price_total = 0;
    $product_name = [];
    if(mysqli_num_rows($select_product) > 0){
        while($fetch_product = mysqli_fetch_assoc($select_product)){
            $product_name[] = $fetch_product['name'] .' ('. $fetch_product['quantity'] .') ';
            $product_price = floatval($fetch_product['price']) * intval($fetch_product['quantity']);
            $price_total += $product_price;
        };
    };

    $total_product = implode(',',$product_name);
    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, country, city, postal_code, phone_number, grand_total, pmode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssds", $name, $email, $address, $country, $city, $postal, $phone, $price_total, $method);
    if ($stmt->execute()) {
        $modal_html = "
        <div class='order-message-container'>
        <div class='message-container'>
            <h3>Thank you for shopping!</h3>
            <div class='order-detail'>
                <span>" . implode(', ', $product_name) . "</span>
                <span class='total'> Total: $" . number_format($price_total, 2) . "/- </span>
            </div>
            <div class='customer-details'>
                <p>Your name: <span>" . $name . "</span></p>
                <p>Your phone number: <span>" . $phone . "</span></p>
                <p>Your email: <span>" . $email . "</span></p>
                <p>Your address: <span>" . $address . "</span></p>
                <p>Your payment mode: <span>" . $method . "</span></p>
                <p>(*Pay when product arrives*)</p>
            </div>
            <a href='products.php' class='btn'>Continue Shopping</a>
        </div>
        </div>";
        echo json_encode([
            $modal_html
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'There was an issue with the order'
        ]);
    }
    exit;
}
?>