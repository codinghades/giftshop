<?php
    require_once 'connection.php';
    session_start();

    $isLoggedIn = isset($_SESSION['user_id']) ? 'true' : 'false';

    $user_id = $_SESSION['user_id'];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
    <link rel="stylesheet" href="styles/cart.css">
    <style>
        .product-quantity{
            margin: 0;
        }
    </style>
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<body>
    <div class="cart-page">
        <div class="heading">
            <h1>My Cart:</h1>
            <h1>Checkout</h1>
        </div>
        <hr>
        <div class="cart-main">
            <div class="cart-main-left">
                <?php
                    $select_product = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('Query failed');
                    $grand_total = 0;
                    if(mysqli_num_rows($select_product) > 0){
                       while($fetch_product = mysqli_fetch_assoc($select_product)){
                ?>
                
                <div class="cart-product">
                    <div class="left">
                        <img src="<?php echo $fetch_product['image']; ?>" alt="">
                    </div>

                    <div class="right">
                        <p class="title"><?php echo $fetch_product['name']; ?></p><br>
                        <p class="descp"><?php echo $fetch_product['product_description']; ?></p>
                        <div class="right-down">
                        <p class="product-price" id="price-<?php echo $fetch_product['id']; ?>" data-unitprice="<?php echo $fetch_product['price']; ?>">₱ <?php echo number_format($sub_total = $fetch_product['quantity'] * $fetch_product['price'], 2); ?></p><br>
                            <form action="" method="post">
                                <p class="qty"> 
                                        Quantity: <span class="product-quantity" id="quantity-<?php echo $fetch_product['id']; ?>"><?php echo $fetch_product['quantity']; ?></span>
                                        <button class="qtyBtn" type="submit" data-id="<?php echo $fetch_product['id']; ?>" data-action="minus">-</button>
                                        <button class="qtyBtn" type="submit" data-id="<?php echo $fetch_product['id']; ?>" data-action="add">+</button>
                                </p>
                            </form>
                            
                            <form method="post" action="">
                                <input type="hidden" name="id" value="<?php echo $fetch_product['id']; ?>">
                                <input type="hidden" name="image" value="<?php echo $fetch_product['image']; ?>">
                                <input type="hidden" name="name" value="<?php echo $fetch_product['name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $fetch_product['price']; ?>">
                                <input type="hidden" name="image" value="<?php echo $fetch_product['image']; ?>">
                                <input class="removeBtn" type="submit" name="remove" value="Remove">
                            </form>
                        </div>
                        
                    </div>
                </div>
                <?php
                $grand_total += $sub_total;
                       };
                    }else{
                        echo '<div class="cart-main-left">No Item Added.</div>';
                     }

                ?>
            </div>

            <div class="cart-main-right">
                <div class="flex">
                    <form action="">
                        <div class="inputBox">
                            <div class="inputs">
                                <label>Your Name</label><br>
                                <input type="text" name="name" required>
                            </div>

                            <div class="inputs">
                            <label>Your Email</label><br>
                            <input type="email" name="email" required>
                            </div>
                        </div>

                        <div class="inputBox">
                            <div class="inputs">
                                <label>Address</label><br>
                                <input type="text" name="address" required>
                            </div>

                            <div class="inputs">
                            <label>Country</label><br>
                            <input type="text" name="city" required>
                            </div>
                        </div>

                        <div class="inputBox">
                            <div class="inputs">
                                <label>City</label><br>
                                <input type="text" name="name" required>
                            </div>

                            <div class="inputs">
                            <label>Postal Code</label><br>
                            <input type="email" name="email" required>
                            </div>
                        </div>

                        <div class="inputBox">
                            <div class="inputs">
                                <label>Phone Number</label><br>
                                <input type="text" name="name" required>
                            </div>

                            <div class="inputs">
                            <label>Select Payment Method</label><br>
                            <select name="method">
                                <option value="Cash On Delivery" selected>Cash On Delivery</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                            </div>
                        </div>

                        <h2>Total:&nbsp;₱<?php echo $grand_total?></h2>
                        <input type="submit" value="Place Order" name="order_btn" class="btn">
                    </form>
                </div>
                
                

            </div>

        </div>
        
    </div>

    <script>
        $(document).ready(function() {
            $(".qtyBtn").on("click", function(e) {
                e.preventDefault();

                var productId = $(this).data("id");
                var action = $(this).data("action"); // 'add' or 'minus'
                var currentQuantity = parseInt($("#quantity-" + productId).text());
                var unitPrice = parseFloat($("#price-" + productId).data("unitprice")); // Assuming the price is set as a data attribute

                var data = {
                    product_id: productId,
                    action: action
                };

                $.ajax({
                    url: "update_cart.php",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            if (action === "add") {
                                currentQuantity += 1;
                            } else if (action === "minus" && currentQuantity > 1) {
                                currentQuantity -= 1;
                            }

                            $("#quantity-" + productId).text(currentQuantity);

                            var updatedPrice = (unitPrice * currentQuantity).toFixed(2);
                            $("#price-" + productId).text('$' + updatedPrice);
                        } else {
                            alert("Failed to update the cart: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + status + " " + error);
                    }
                });
            });
        });
    </script>
</body>
</html>