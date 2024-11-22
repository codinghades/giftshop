<?php
    require_once 'connection.php';

    $sql = "SELECT * FROM product";
    $all_product = $conn->query($sql);
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
        <div class="nav-section">
            <div class="left">
                <div class="nav-logo">
                    <img src="images/animehaven_logo.png" alt="Anime Haven">
                </div>
    
                <div class="nav-links">
                    <a class="css-links" href="#">Home</a>
                    <a class="css-links" href="#">Shop</a>
                    <a class="css-links" href="#">New Arrivals</a>
                    <a class="css-links" href="#">Best Sellers</a>
                    <a class="css-links" href="#">Anime</a>
                </div>
            </div>

            <div class="right">
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

            <div class="right">
                <input class="search" type="text">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>

        <!--Banner Slider-->
        <div class="banner-slider">
            <div class="slider">
                <div class="list">
                    <div class="item">
                        <img src="images/banner1.jpg" alt="">
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
                    while($row = mysqli_fetch_assoc($all_product)){
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
        
        <div class="new-arrivals">
            <h1>New Arrivals</h1>
        </div>
    </div>

    <script>
        let scroll = document.querySelector('.limited-product-container');
        
        scroll.addEventListener("wheel", (evt) =>{
            evt.preventDefault();
            scroll.scrollLeft += evt.deltaY;
        })

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