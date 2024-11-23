<?php
    require_once 'connection.php';

    $sqlLimited = "SELECT * FROM product";
    $limited_product = $conn->query($sqlLimited);

    $sqlArrival = "SELECT * FROM arrival";
    $arrival_product = $conn->query($sqlArrival);
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
                        <a class="css-links" href="#">Home</a>
                        <a class="css-links" href="#">Shop</a>
                        <a class="css-links" href="#">Limited-Time-Sales</a>
                        <a class="css-links" href="#">New Arrivals</a>
                        <a class="css-links" href="#">Anime</a>
                    </div>
                </div>

                <div class="right">
                    <form action="">
                        <div class="search-bar">
                            <input placeholder="Jujutsu Kaisen🔥" id="search" class="search" type="text" name="search-products">
                            <input class="search-btn" type="submit" value="">
                        </div>
                    </form>
                    <div class="cart">
                        <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                    </div>
                    
                    <div class="nav-users">
                        <a class="btn-login" href="#">Login</a>
                        <a class="btn-signup" href="#">Signup</a>
                    </div>
                </div>
            </div>


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
                        while($row = mysqli_fetch_assoc($limited_product)){
                ?>
                <div class="card">
                    <div class="image">
                        <img src="<?php echo $row["product_image"];?>" alt="image">
                        <button class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to cart</button>
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
                    }
                ?>
            </div>
        </div>
        
        <div class="arrivalSection">
            <div class="new-arrivals">
                <b class="hu__hu__">Best for Gifting! <i class="fa-solid fa-gift"></i></b><h1>New Arrivals! One Piece Banners </h1>
            </div>
            <hr>
            <!--Limited Products-->

            <div class="arrival-product-container">
                <?php
                        while($row = mysqli_fetch_assoc($arrival_product)){
                ?>
                <div class="card">
                    <div class="image">
                        <img src="<?php echo $row["arrival_image"];?>" alt="image">
                        <button class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to cart</button>
                    </div>
                        
                    <div class="details">
                        <h3 class="product-name"><?php echo $row["arrival_name"];?></h3>
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
                <a href="">Cart</a><br><br>
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
    </div>

    <script>

    </script>

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
        let slider = document.querySelector('.slider .list');
        let items = document.querySelectorAll('.slider .list .item');
        let next = document.getElementById('next');
        let prev = document.getElementById('prev');
        let dots = document.querySelectorAll('.slider .dots li');

        let lengthItems = items.length - 1;
        let active = 0;
        next.onclick = function(){
            active = active + 1 <= lengthItems ? active + 1 : 0;
            reloadSlider();
        }
        prev.onclick = function(){
            active = active - 1 >= 0 ? active - 1 : lengthItems;
            reloadSlider();
        }

        let refreshInterval = setInterval(()=> {next.click()}, 3000);

        function reloadSlider(){
            slider.style.left = -items[active].offsetLeft + 'px';
            // 
            let last_active_dot = document.querySelector('.slider .dots li.active');
            last_active_dot.classList.remove('active');
            dots[active].classList.add('active');

            clearInterval(refreshInterval);
            refreshInterval = setInterval(()=> {next.click()}, 3000);

            
        }

        dots.forEach((li, key) => {
            li.addEventListener('click', ()=>{
                active = key;
                reloadSlider();
            })
        });

        window.onresize = function(event) {
            reloadSlider();
        };
    </script>
</body>
</html>