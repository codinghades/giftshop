<?php
    require_once 'connection.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = null;
    }
    
    if (!isset($_SESSION["user"])){
        $_SESSION["email"] = "";
    }

    // $sqlAllProduct = "SELECT * FROM shop";
    // $all_product = $conn->query($sqlAllProduct);

    $sqlLimitedProduct = "SELECT * FROM shop WHERE category = 'limited'";
    $sqlArrivalProduct = "SELECT * FROM shop WHERE category = 'arrival'";
    $limited_product = $conn->query($sqlLimitedProduct);
    $arrival_product = $conn->query($sqlArrivalProduct);

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
                $_SESSION['cart_message'] = htmlentities('<i class="fa-solid fa-circle-exclamation"></i> Item is already in the cart!');
            } else {
                mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, product_type, product_description) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_type', '$product_description')") or die('query failed');
                $_SESSION['cart_message'] = htmlentities('<i class="fa-solid fa-check"></i> Added to Cart');
            }
        }
    }

    if (isset($_POST['qtyAdd'])) {
        $product_id = $_POST['qtyAdd'];
        $update_quantity = mysqli_query($conn, "UPDATE `cart` SET quantity = quantity + 1 WHERE id = '$product_id' AND user_id = '$user_id'") or die('Query failed');
    }

    if (isset($_POST['qtyMinus'])) {
        $product_id = $_POST['qtyMinus'];  
        
        $update_quantity = mysqli_query($conn, "UPDATE `cart` SET quantity = GREATEST(quantity - 1, 1) WHERE id = '$product_id' AND user_id = '$user_id'") or die('Query failed');
    }

    if (isset($_POST['remove'])) {
        $remove_id = $_POST['id'];
        mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('Query failed');
        header('Location: homepage.php');
    }

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
    <title>Anime Haven</title>
    <link rel="stylesheet" href="styles/general.css">
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
    <div class="main">
            <!--header 2-->
            <div class="header2">
                <div class="left">
                    <h1>BEST GIFT IDEAS</h1>
                </div>
            </div>

            <!--Banner Slider-->
            <div class="banner-slider">
                <div class="slider">
                    <div class="list">
                        <div class="item">
                            <img src="images/banner6.jpg" alt="">
                        </div>
                        <div class="item">
                            <img src="images/banner2.jpg" alt="">
                        </div>
                        <div class="item">
                            <img src="images/banner3.jpg" alt="">
                        </div>
                        <div class="item">
                            <img src="images/banner4.jpg" alt="">
                        </div>
                        <div class="item">
                            <img src="images/banner5.jpg" alt="">
                        </div>
                    </div>
                    <div class="buttons">
                        <button id="prev"><</button>
                        <button id="next">></button>
                    </div>
                    <ul class="dots">
                        <li class="active"></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                
                <div class="download">
                    <img src="images/download.png" alt="">
                </div>
            </div>

            <!--Black Friday-->
            <div class="black-friday">
                <h1 class="one">BLACK FRIDAY</h1>
                <h1 class="two">EXPLORE YOUR INTERESTS</h1>
            </div>
        

        <div class="limited-section">
            <!--Limited Time Sales-->
            <div class="limited">
                <h1>Limited-Time-Sales</h1>
                
                <div class="countdown-container">
                    <div class="cd-elem days-c">
                        <p class="big-text" id="days">0</p>
                    </div>
                    <div class="cd-elem hours-c">
                        <p class="cd-elem big-text" id="hours">0</p>
                    </div>
                    <div class="cd-elem mins-c">
                        <p class="big-text" id="mins">0</p>
                    </div>
                    <div class="cd-elem seconds-c">
                        <p class="big-text" id="seconds">0</p>
                    </div>
                </div>
            </div>
            <hr>

            <!--Limited Products-->
            <div class="limited-product-container">
                <?php
                    if ($limited_product && $limited_product->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($limited_product)) {
                ?>
                <div class="card">
                    <div class="image">
                        <img src="<?php echo $row["product_image"];?>" alt="image">
                        <!--Add to cart form-->
                    <form method="post" class="add-to-cart-form">
                            <input type="hidden" name="product_type" value="limited">
                            <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                            <input type="hidden" name="product_description" value="<?php echo $row['product_description']; ?>">
                            <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                            <input type="hidden" name="discount" value="<?php echo $row['discount']; ?>">
                            <input class="btn-cart" type="submit" name="add-to-cart" value="Add to cart">
                    </form>
                    </div>
                    
                    <div class="details">
                        <h3 class="product-name"><?php echo $row["product_name"];?></h3>
                        <div class="price-rating">
                            <div class="prices">
                                <p class="price">₱<?php echo number_format($row["price"], 2);?></p>
                                <p class="discount-price">₱<?php echo $row["discount"];?></p>
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
                <?php
                        };
                    }else{
                        echo "<p>No Limited products available.</p>";
                    }
                ?>
            </div>
        </div>
        <div id="cartModal" class="modal">
            <div class="modal-content">
                <p id="modalMessage"></p>
            </div>
        </div>

        <div class="arrivalSection">
            <div class="new-arrivals">
                <b class="hu__hu__">Best for Gifting! <i class="fa-solid fa-gift"></i></b><h1>New Arrivals! One Piece Banners </h1>
            </div>
            <hr>

            <div class="arrival-product-container">
                <?php
                    if ($arrival_product && $arrival_product->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($arrival_product)) {
                ?>
                <div class="card">
                    <div class="image">
                        <img src="<?php echo $row["product_image"];?>" alt="image">
                        <form method="post" class="add-to-cart-form">
                            <input type="hidden" name="product_type" value="arrival">
                            <input type="hidden" name="arrival_image" value="<?php echo $row['product_image']; ?>">
                            <input type="hidden" name="arrival_id" value="<?php echo $row['product_id']; ?>">
                            <input type="hidden" name="arrival_name" value="<?php echo $row['product_name']; ?>">
                            <input type="hidden" name="product_description" value="<?php echo $row['product_description']; ?>">
                            <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                            <input type="hidden" name="discount" value="<?php echo $row['discount']; ?>">
                            <input class="btn-cart" type="submit" name="add-to-cart" value="Add to cart">
                    </form>
                    </div>
                        
                    <div class="details">
                        <h3 class="product-name"><?php echo $row["product_name"];?></h3>
                        <div class="price-rating">
                            <div class="prices">
                                <p class="price">₱<?php echo $row["price"];?></p>
                                <p class="discount-price">₱<?php echo $row["discount"];?></p>
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
                <?php
                        };
                    }else{
                        echo "<p>No Arrival products available.</p>";
                    }
                ?>
            </div>
        </div>

        <div class="category-section">
            <div class="category-left">
                <img src="images/limited/mha.jpg" alt="">
                <div class="descp">
                    <h3>Anime Figures</h3>
                    <p>Character figurines and collectibles from your favorite animes, mangas, and video games are transformed and brought to life as three-dimensional anime statues.<br> They are perferct for gifting who loves anime.</p><br>
                    <a a href="#">Shop now</a>
                </div>
            </div>
            
            <div class="category-right">
                <div class="category-right-up">
                    <img src="images/banner6.jpg" alt="">
                    <div class="descp">
                        <h3>Anime Printed Shirts/Hoodie</h3>
                        <p>High quality products.</p><br>
                        <a href="#">Shop Now</a>
                    </div>
                    
                </div>
                <div class="category-down">
                    <div class="down-left">
                        <img src="images/anime accessories.jpg" alt="">
                        <div class="descp">
                            <h3>Anime Accessories</h3>
                            <p>Keychains, pins, showcase, and etc..</p><br>
                            <a href="#">Shop Now</a>
                        </div>
                        
                    </div>
                    <div class="down-right">
                        <img src="images/plushtoy.avif" alt="">
                        <div class="descp">
                            <h3>Anime Plush Toys</h3>
                            <p>Soft, cuddly figures of beloved anime characters.</p><br>
                            <a href="#">Shop Now</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="about-section">
            <div class="box">
                <div class="image">
                    <img src="images/truck.PNG" alt="">
                </div>
                <p><b>FREE AND FAST DELIVERY</b></p>
                <p>Free Delivery on all orders $140</p>
            </div>

            <div class="box">
                <div class="image">
                    <img src="images/customer.PNG" alt="">
                </div>
                <p><b>24/7 CUSTOMER SERVICE</b></p>
                <p>Friendly 24/7 customer support</p>
            </div>
            
            <div class="box">
                <div class="image">
                    <img src="images/money.PNG" alt="">
                </div>
                <p><b>MONEY BACK GUARANTEE</b></p>
                <p>We return money within 30days</p>
            </div>
        </div>

        <div class="gotop">
            <a href="#heretop"><i class="fa-solid fa-arrow-up"></i></a>
        </div>
        <br>
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
            <a href="#" id="view-cart">Cart</a><br><br>
            <a href="">Shop</a><br><br>
            <a href="">New Arrivals</a><br><br>
            <a href="">Limited-Time-Sales</a>
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
                    $('.main').fadeOut(200, function() {
                        $.ajax({
                            url: 'cart.php',  
                            method: 'GET',
                            success: function(response) {
                                $('.main').html(response);
                                $('.main').fadeIn(200);
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

    <!-- Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const message = '<?php echo isset($_SESSION['cart_message']) ? htmlspecialchars_decode($_SESSION['cart_message'], ENT_QUOTES) : ''; ?>';
            if (message) {
                showModal(message);

                <?php unset($_SESSION['cart_message']); ?>
            }
        });

        function showModal(message) {
            const modal = document.getElementById('cartModal');
            const modalMessage = document.getElementById('modalMessage');
            modalMessage.innerHTML = message;
            setTimeout(() => {
                modal.classList.add('show');  
            }, 10);  
            modal.style.display = 'flex';

            setTimeout(() => {
                modal.classList.remove('show'); 
                setTimeout(() => {
                    modal.style.display = 'none'; 
                }, 500); 
            }, 3000); 
        }
    </script>

    <!--Scroll&autoplay placeholder-->
    <script>
        let scroll = document.querySelector('.limited-product-container');
        
        scroll.addEventListener("wheel", (evt) =>{
            evt.preventDefault();
            scroll.scrollLeft += evt.deltaY;
        })

        let arrivalscroll = document.querySelector('.arrival-product-container');
        
        arrivalscroll.addEventListener("wheel", (evt) =>{
            evt.preventDefault();
            arrivalscroll.scrollLeft += evt.deltaY;
        })

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

    <!--Limited time countdown-->
    <script>
        // Step 4
        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('mins');
        const secondsEl = document.getElementById('seconds');

        // Step 1
        const newYears = "3 Dec 2024"; // Target Time

        const countDown = () => {
            // Step 3
            const newYearsDate = new Date(newYears);
            const currentDate = new Date();

            const Totalseconds = (newYearsDate - currentDate) / 1000;

            const days = Math.floor(Totalseconds / 3600 / 24);
            const hours = Math.floor(Totalseconds / 3600) % 24;
            const minutes = (Math.floor(Totalseconds / 60) % 60);
            const seconds = Math.floor(Totalseconds) % 60;

            // Step 6
            daysEl.innerHTML = days;
            hoursEl.innerHTML = formatTime(hours);
            minutesEl.innerHTML = formatTime(minutes);
            secondsEl.innerHTML = formatTime(seconds);
        }
            // Step 5
            const formatTime = (time) => {
                return time < 10 ? (`0${time}`) : time;
            } 

            // Step 2
            // initial call
            countDown();

            setInterval(countDown, 1000);
    </script>

    <!--Banner Slider-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    let slider = document.querySelector('.slider .list');
    let items = document.querySelectorAll('.slider .list .item');
    let next = document.getElementById('next');
    let prev = document.getElementById('prev');
    let dots = document.querySelectorAll('.slider .dots li');

    if (!slider || !next || !prev || !dots.length) {
        console.warn("Slider elements not found, skipping slider initialization.");
        return;
    }

    let lengthItems = items.length - 1;
    let active = 0;

    next.onclick = function() {
        active = active + 1 <= lengthItems ? active + 1 : 0;
        reloadSlider();
    };

    prev.onclick = function() {
        active = active - 1 >= 0 ? active - 1 : lengthItems;
        reloadSlider();
    };

    let refreshInterval = setInterval(() => { next.click() }, 3000);

    function reloadSlider() {
        slider.style.left = -items[active].offsetLeft + 'px';
        
        let last_active_dot = document.querySelector('.slider .dots li.active');
        if (last_active_dot) last_active_dot.classList.remove('active');
        dots[active].classList.add('active');

        clearInterval(refreshInterval);
        refreshInterval = setInterval(() => { next.click() }, 3000);
    }

    dots.forEach((li, key) => {
        li.addEventListener('click', () => {
            active = key;
            reloadSlider();
        });
    });

    window.onresize = function(event) {
        reloadSlider();
    };

    if (window.location.pathname === '/giftshop2/giftshop/giftshop/homepage.php') {
        reloadSlider();
    }
});

    </script>
</body>
</html>