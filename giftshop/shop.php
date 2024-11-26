<?php
    session_start();
    include 'connection.php';
    if (!isset($_SESSION["user"])){
        $_SESSION["email"] = "";
    }
    $searchbar = "";

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = null;
    }
    
    //search bar code
    if(isset($_GET["search-product"])) {
        $search = $_GET["search-product"];
        $sql = "SELECT * FROM shop WHERE product_name LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $search . "%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $searchbar = isset($_GET['search-product']) ? $_GET['search-product'] : '';
        $_SESSION["searchbar"] = $searchbar;
    }
    else{
        if(isset($_GET["search-btn"]) && isset($_GET["search-products"])) {
            $search = $_GET["search-products"];
            $sql = "SELECT * FROM shop WHERE product_name LIKE ?";
            $stmt = $conn->prepare($sql);
            $searchTerm = "%" . $search . "%";
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            $searchbar = isset($_GET['search-products']) ? $_GET['search-products'] : '';
            $_SESSION["searchbar"] = $searchbar;
        }
        else{
            $sql = "SELECT * FROM shop";
            $result = $conn->query($sql);
        }
    }
    

    $products = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $sql = "SELECT * FROM arrival";
        $result = $conn->query($sql);
    } 
    else {
        $message = "No products found :(";
    }

    $cart_items = 0;

    if ($user_id) {
        
        $result = mysqli_query($conn, "SELECT COUNT(*) as item_count FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
        $data = mysqli_fetch_assoc($result);

        
        $cart_items = $data['item_count'] ?? 0;
    }

    $cart_item_style = $cart_items > 0 ? '' : 'style="display: none;"';

    if (isset($_POST['add-to-cart'])) {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>
                    alert('You must be logged in to add items to the cart!');
                    window.location.href = 'login.php';
                  </script>";
        } else {
            $user_id = $_SESSION['user_id'];
            $product_type = $_POST['product_type'];
            $product_name = $product_type == 'limited' ? $_POST['product_name'] : $_POST['arrival_name'];
            $product_price = $_POST['price'];
            $product_description = $_POST['product_description'];
            $product_image = $product_type == 'limited' ? $_POST['product_image'] : $_POST['arrival_image'];
    
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE (name = '$product_name' AND user_id = '$user_id')") or die('query failed');
            
            if (mysqli_num_rows($select_cart) > 0) {
                echo "<script>
                    alert('Item is already in the cart');
                    </script>";
            } else {

                mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, product_type, product_description) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_type', '$product_description')") or die('query failed');
                echo "<script>
                    alert('Added to cart!');
                    </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Haven Shop</title>
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&display=swap" rel="stylesheet">
</head>
<body>
<div class="main">
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
                        <a class="css-links" href="homepage.php">Home</a>
                        <a class="css-links" href="shop.php">Shop</a>
                        <a class="css-links" href="#">Limited-Time-Sales</a>
                        <a class="css-links" href="#">New Arrivals</a>
                        <a class="css-links" href="#">Anime</a>
                        <!--For Admin-->
                        <?php
                        if($_SESSION["email"] == "admin@gmail.com"):
                        ?>
                        <a href="admin.php" class="css-links">Admin</a>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>

                <div class="right">
                    <form action="shop.php" method="get">
                        <div class="search-bar">
                            <input placeholder="Jujutsu Kaisen🔥" id="search" class="search" type="text" name="search-products" value="<?php echo $searchbar?>">
                            <input class="search-btn" type="submit" value="" name="search-btn">
                            <?php
                                if(isset($_GET["search-btn"])) {
                                    $_SESSION["searchbar"] = $_GET["search-products"];
                                }
                            ?>
                        </div>
                    </form>
                    <div class="cart">
                        <a href="#" id="view-cart"><i class="fa-solid fa-cart-shopping"></i><p class="cartItem" <?php echo $cart_item_style; ?> id="cart-item"><?php echo $cart_items; ?></p></a>
                    </div>
                    
                    <div class="nav-users">
                        <?php
                        if (isset($_SESSION["user"])):
                        ?>
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
        </div>

    <?php if (isset($message)): ?>
        <div class="shop-nonfound">
            <p><?php echo $message; ?></p>
        </div>
    <?php endif; ?>
    <div class="shop-container">
        <div class="category">
            <h2>Category</h2>
        </div>
        <?php if (!empty($products)): ?>
            <div class="shop-product-container">
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <div class="image">
                        <img src="<?php echo $product["product_image"];?>" alt="image">
                        <!--Add to cart form-->
                    <form method="post" class="add-to-cart-form">
                            <input type="hidden" name="product_type" value="limited">
                            <input type="hidden" name="product_image" value="<?php echo $product['product_image']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                            <input type="hidden" name="product_description" value="<?php echo $product['product_description']; ?>">
                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                            <input type="hidden" name="discount" value="<?php echo $product['discount']; ?>">
                            <input class="btn-cart" type="submit" name="add-to-cart" value="Add to cart">
                    </form>
                    </div>
                    
                    <div class="details">
                        <h3 class="product-name"><?php echo $product["product_name"];?></h3>
                        <div class="price-rating">
                            <div class="prices">
                                <p class="price">₱<?php echo number_format($product["price"], 2);?></p>
                                <p class="discount-price">₱<?php echo $product["discount"];?></p>
                            </div>
                            <div class="ratings">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#view-cart').click(function(e) {
                e.preventDefault();
                var isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

                if (!isLoggedIn) {
                    $('#loginMessage').fadeIn();
                    // alert('You must be logged in to view your cart!');
                    setTimeout(function() {
                        $('#loginMessage').fadeOut();
                    }, 2000);  
                } else {
                    $('.shop-container').fadeOut(200, function() {
                        $.ajax({
                            url: 'cart.php',  
                            method: 'GET',
                            success: function(response) {
                                $('.shop-container').html(response);
                                $('.shop-container').fadeIn(200);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error loading cart page: ", status, error);
                            }
                        });
                    });
                }
            });
        });
    </script>
</body>
</html>