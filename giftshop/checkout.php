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
    if (mysqli_num_rows($select_product) > 0) {
        while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            $product_name[] = $fetch_product['name'] . ' (' . $fetch_product['quantity'] . ') ';
            $product_price = floatval($fetch_product['price']) * intval($fetch_product['quantity']);
            $price_total += $product_price;
        };
    };

    $total_product = implode(',', $product_name);
    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, country, city, postal_code, phone_number, grand_total, pmode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssds", $name, $email, $address, $country, $city, $postal, $phone, $price_total, $method);
    if ($stmt->execute()) {
        // Delete cart items for the user after successful order
        $delete_cart = mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'") or die('Query failed');
        $order_success = true;
    } else {
        $order_success = false;
    }
}

// Cart
$cart_items = 0;

    if ($user_id) {
        
        $result = mysqli_query($conn, "SELECT COUNT(*) as item_count FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
        $data = mysqli_fetch_assoc($result);

        
        $cart_items = $data['item_count'] ?? 0;
    }

    $cart_item_style = $cart_items > 0 ? '' : 'style="display: none;"';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles/checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&display=swap" rel="stylesheet">
</head>
<body>
        <div id="heretop" class="header-one">
            <div class="left">
                <i class="fa-solid fa-truck"></i>
                <div class="text">
                    <h5>Fast shipping on all orders</h5>
                    <p>Exclusive offer</p>
                </div>
            </div>
            
            <span style="background-image:linear-gradient(rgba(255,255,255,0),#FFFFFF,#FFFFFF,rgba(255,255,255,0))"></span>

            <div class="center">
                <i class="fa-solid fa-boxes-packing"></i>
                <div class="text">
                    <h5>Free returns</h5>
                    <p>Up to 30 days *</p>
                </div>
            </div>

            <span style="background-image:linear-gradient(rgba(255,255,255,0),#FFFFFF,#FFFFFF,rgba(255,255,255,0))"></span>

            <div class="right">
                <i class="fa-solid fa-mobile-screen"></i>
                <div class="text">
                    <h5>Get the Anime Haven App</h5>
                </div>
            </div>
        </div>

        <div class="home-section">
            <div class="nav-section">
                <div class="left">
                    <div class="nav-logo">
                        <img src="images/animehaven_logo.png" alt="Anime Haven">
                    </div>
        
                    <div class="nav-links">
                        <a href="homepage.php" class="css-links" >Home</a>
                        <a href="shop.php" class="css-links" >Shop</a>
                        <a href="#" class="css-links" >Limited-Time-Sales</a>
                        <a href="#" class="css-links" >New Arrivals</a>
                        <a href="#" class="css-links" >Anime</a>
                    </div>
                </div>

                <div class="right">
                    <!-- Search Bar here -->
                    <form action="">
                        <div class="search-bar">
                            <input placeholder="Jujutsu Kaisen🔥" id="search" class="search" type="text" name="search-products">
                            <input class="search-btn" type="submit" value="">
                        </div>
                    </form>
                    <div class="cart">
                        <a href="#" id="view-cart"><i class="fa-solid fa-cart-shopping"></i><p class="cartItem" <?php echo $cart_item_style; ?> id="cart-item"><?php echo $cart_items; ?></p></a>
                    </div>
                    
                    <div class="nav-users">
                        <?php
                            if (isset($user_id)) {
                                $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
                                if (mysqli_num_rows($select_user) > 0) {
                                    $fetch_user = mysqli_fetch_assoc($select_user);
                                }
                            }

                            if (isset($_SESSION["user"])):
                        ?>
                            <p class="username">Hello, <?php echo $fetch_user['username']; ?></p>
                            <a class="btn-login" href="logout.php">Logout</a>
                        <?php
                        else:
                        ?>
                            <a class="btn-login" href="login.php">Login</a>
                            <a class="btn-signup" href="registration.php">Signup</a>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
        </div>
        
    <div id="loginMessage">You must be logged in to view your cart.</div>

    <div class="checkout-section">
        <?php if (isset($order_success) && $order_success): ?>
            <div class="order-success">
                <h1>Order placed successfully!</h1>
                <p>Your cart has been cleared, and your order is on its way!</p>
            </div>
        <?php elseif (isset($order_success)): ?>
            <div class="order-failure">
                <h1>Failed to place the order.</h1>
                <p>Please try again later.</p>
            </div>
        <?php endif; ?>
    </div>

 <!--Scroll&autoplay placeholder-->
 <script>
        const placeholderTexts = [
            "Attack on Titan",
            "Demon Slayer",
            "Bleach",
            "One Piece"
        ];

        const searchInput = document.getElementById('search');

        let currentPlaceholderIndex = 0;
        
        setInterval(() => {
            searchInput.placeholder = placeholderTexts[currentPlaceholderIndex];
            currentPlaceholderIndex = (currentPlaceholderIndex + 1) % placeholderTexts.length;
        }, 3000);
    </script>
</body>
</html>
