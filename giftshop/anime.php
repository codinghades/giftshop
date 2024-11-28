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
        if (!isset($_POST["sort-name"])) {
            $sortOrder = "";
        }
        else{
            $sortOrder = $_POST["sort-name"];
        }
        usort($products, function($a, $b) use ($sortOrder) { 
            if ($sortOrder == 'descend') { 
                return strcmp($b['product_name'], $a['product_name']); 
            } 
            elseif ($sortOrder == 'newest') {
                return strcmp($b['product_id'], $a['product_id']);
            }
            elseif ($sortOrder == 'ascend') {
                return strcmp($a['product_name'], $b['product_name']);
            }
            elseif ($sortOrder == 'cheap') {
                return ($a['price'] <=> $b['price']);
            }
            elseif ($sortOrder == 'expensive') {
                return ($b['price'] <=> $a['price']);
            }
            else { 
                return strcmp($a['product_id'], $b['product_id']); 
            } 
        });
    } 
    else {
        $message = "No products found :(";
    }


    $animes = [];

    $sql = "SELECT * FROM anime"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) 
        $animes[] = $row;
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
    <link rel="stylesheet" href="styles/anime.css">
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
                        <a href="homepage.php#limitedSection" class="css-links" >Limited-Time-Sales</a>
                        <a href="homepage.php#arrivalSection" class="css-links" >New Arrivals</a>
                        <a class="css-links" href="anime.php">Anime</a>
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
                            <input placeholder="Jujutsu Kaisen🔥" id="search" class="search" type="text" name="search-product" value="">
                            <input class="search-btn" type="submit" name="submit" value="">
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

    <div class="anime-container">
        <?php
            if (!empty($animes)):
        ?>
            <?php
                foreach ($animes as $anime):
            ?>
        <div class="anime-group">
            <div class="image-section">
                <img class="image-section" src="<?php echo htmlspecialchars($anime['anime_image']); ?>" alt="<?php echo htmlspecialchars($anime['anime_title']); ?>">
            </div> 
            <div class="text-section"> 
                <h1><?php echo htmlspecialchars($anime['anime_title']); ?></h1> 
                <p><?php echo htmlspecialchars($anime['anime_description']); ?></p> 
                <div class="button-container"> 
                    <a href="<?php echo htmlspecialchars($anime['anime_link']); ?>" class="button">START WATCHING</a>
                </div>
            </div> 
        </div>
            <?php
                endforeach;
            ?>
        <?php
            endif;
        ?>
    </div>

    <div class="footer">
        <div class="footer-box">
            <h3><b>Anime Haven</b></h3>
            <p><b>Subscribe</b></p>
            <p>Get 10% off your first order</p>
            <input class="subscribe" placeholder="Enter your email" type="text">
        </div>
        <div class="footer-box">
            <h4>Support</h4>
            <a href="">123 San Juan St. Morong, Rizal</a><br><br>
            <a href="">animehaven@gmail.com</a><br><br>
            <a href="">+09937479921</a>
        </div>
        <div class="footer-box">
            <h4>Account</h4>
            <a href="" id="view-cart">Cart</a><br><br>
            <a href="shop.php">Shop</a><br><br>
            <a href="homepage.php#arrivalSection">New Arrivals</a><br><br>
            <a href="homepage.php#limitedSection">Limited-Time-Sales</a>
            </div>
        <div class="footer-box">
            <h4>Quick Link</h4>
            <a href="">Privacy Policy</a><br><br>
            <a href="">Terms of Use</a><br><br>
            <a href="">FAQ</a>
            <a href="">Contact</a>
        </div>
        <div class="footer-box">
            <h4>Download App</h4>
            <p>Save $3 with App Now User Only</p>
            <img src="images/getapp.PNG" alt="">
            <div class="icons">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-x-twitter"></i></a>
                <a href=""><i class="fa-brands fa-square-instagram"></i></a>
                <a href=""><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>

        <div class="copyright">
            <p>©Copyright Anthony & Arwin 2024. All rights reserved.</p>
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
                    $('.anime-container').fadeOut(200, function() {
                        $.ajax({
                            url: 'cart.php',  
                            method: 'GET',
                            success: function(response) {
                                $('.anime-container').html(response);
                                $('.anime-container').fadeIn(200);
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