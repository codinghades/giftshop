<?php
    session_start();
    include 'connection.php';
    if (!isset($_SESSION["user"])){
        $_SESSION["email"] = "";
    }
    $searchbar = "";
    $select_sort = isset($_POST['sort-name']) ? $_POST['sort-name'] : 'newest';

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = null;
    }

    //search bar code

    $category = isset($_GET['category']) ? $_GET['category'] : 'all';
    
    if(isset($_GET["search-product"])) {
        $search = $_GET["search-product"];
        $sql = "SELECT * FROM shop WHERE product_name LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $search . "%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
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
        }
        else{
            if ($category !== 'all'){
                $sql = "SELECT * FROM shop WHERE category = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $category);
                $stmt->execute();
                $result = $stmt->get_result();
            }
            else {
                $sql = "SELECT * FROM shop";
                $result = $conn->query($sql);
            }
            
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
            elseif ($sortOrder == 'oldest') {
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
            $quantity = $_POST['quantity'];
            $product_description = $_POST['product_description'];
            $product_image = $product_type == 'limited' ? $_POST['product_image'] : $_POST['arrival_image'];
    
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
            $select_cart->bind_param("si", $product_name, $user_id);
            $select_cart->execute();
            $result = $select_cart->get_result();
            
            if ($result->num_rows > 0) {
                $_SESSION['cart_message'] = htmlentities('<i class="fa-solid fa-circle-exclamation"></i> Item is already in the cart!');
            } else {

                $insert_cart = $conn->prepare(
                    "INSERT INTO `cart` (user_id, name, price, image, quantity, product_type, product_description) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)"
                );
                $insert_cart->bind_param(
                    "isdsiss",
                    $user_id,
                    $product_name,
                    $product_price,
                    $product_image,
                    $quantity,
                    $product_type,
                    $product_description
                );
                
                if ($insert_cart->execute()) {
                    $_SESSION['cart_message'] = htmlentities('<i class="fa-solid fa-check"></i> Added to Cart');
                } else {
                    echo "<script>alert('Error adding to cart: " . $insert_cart->error . "');</script>";
                }
            }
        }
    }

    /*
    // Category (1)
    $category = isset($_GET['category']) ? $_GET['category'] : 'all';

    if ($category === 'all') {
        $query = "SELECT * FROM shop";
    } else {
        $query = "SELECT * FROM shop WHERE category = ?";
    }

    $stmt = $conn->prepare($query);

    if ($category !== 'all') {
        $stmt->bind_param("s", $category);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
        */            
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Haven Shop</title>
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/shop.css">
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
                        <a href="anime.php" class="css-links" >Anime</a>
                    </div>
                </div>

                <div class="right">
                    <form action="shop.php" method="get">
                        <div class="search-bar">
                            <input placeholder="Jujutsu Kaisen🔥" id="search" class="search" type="text" name="search-products">
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
    <div class="shop-container">
        <div class="category">
            <h2>Category</h2>
            <div class="categories">
                <a data-category="all" class="active" href="#">All</a>
                <a data-category="figures" href="#">Figures</a>
                <a data-category="accessories" href="#">Accessories</a>
                <a data-category="plush" href="#">Plush Toys</a>
                <a data-category="shirt" href="#">Shirt</a>
                <a data-category="hoodie" href="#">Hoodie</a>
                <a data-category="decor" href="#">Home Decor</a>

            </div>
        </div>
        <form action="" method="post" id="sort-name">
        <div class="shop-filter-container">
            <div class="shop-filter">
                <label for="sort-name">Sort by: </label>
                <select name="sort-name" class="filter-sort" onchange="document.getElementById('sort-name').submit();">
                    <option value="clothes" <?php if ($select_sort == 'clothes') echo 'selected'; ?>>Most Newest</option>
                    <option value="oldest"<?php if ($select_sort == 'oldest') echo 'selected'; ?>>Most Oldest</option>
                    <option value="ascend" <?php if ($select_sort == 'ascend') echo 'selected'; ?>>Ascending</option>
                    <option value="descend"<?php if ($select_sort == 'descend') echo 'selected'; ?>>Descending</option>
                    <option value="cheap" <?php if ($select_sort == 'cheap') echo 'selected'; ?>>Lowest Price</option>
                    <option value="expensive"<?php if ($select_sort == 'expensive') echo 'selected'; ?>>Highest Price</option>
                </select>
            </div>
        </div>
    </form>

        <div id="cartModal" class="categoryModal">
            <div class="modal-content">
                <p id="modalMessage"></p>
            </div>
        </div>

        <?php if (isset($message)): ?>
            <div class="shop-nonfound">
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>
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
                            <input type="hidden" name="quantity" value="<?php echo $product['quantity']; ?>">
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

    <!-- Cart when clicked -->
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

        // Categories links
        const categoryLinks = document.querySelectorAll('.category .categories a');

        categoryLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();

                categoryLinks.forEach(link => link.classList.remove('active'));

                link.classList.add('active');
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
            }, 2000); 
        }
    
        // Categories function
    document.addEventListener('DOMContentLoaded', () => {
    const categoryLinks = document.querySelectorAll('.category .categories a');
    const productContainer = document.querySelector('.shop-product-container');

    categoryLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            categoryLinks.forEach(link => link.classList.remove('active'));
            link.classList.add('active');

            const category = link.getAttribute('data-category');

            // Fetch products using PHP and update the page
            fetch(`shop.php?category=${category}`)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const html = parser.parseFromString(data, 'text/html');
                    const newProducts = html.querySelector('.shop-product-container');

                    if (newProducts) {
                        // Update the product container
                        productContainer.innerHTML = newProducts.innerHTML;
                    } else {
                        console.error('Error: .shop-product-container not found in response.');
                        productContainer.innerHTML = '<p>No products found for this category.</p>';
                    }
                })
                .catch(error => console.error('Error fetching products:', error));
            });
        });
    });
    </script>
</body>
</html>