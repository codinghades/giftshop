<?php
// Start the session and include connection
session_start();
include 'connection.php';

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
        // Order Details
    } else {
        
    }
    exit;
}
?>



