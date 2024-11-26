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

?>