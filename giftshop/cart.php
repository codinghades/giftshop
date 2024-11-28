<?php
    session_start();
    include 'connection.php';
    
    $isLoggedIn = isset($_SESSION['user_id']) ? 'true' : 'false';
    if (!$isLoggedIn) {
        // Redirect or display an error message if not logged in
        echo "You must be logged in to checkout.";
        exit;  // Stop further script execution
    }
    
    $user_id = $_SESSION['user_id'];

    if(isset($_GET["paymethod"])) {
        $_SESSION["paymethod"] = $_GET["paymethod"];
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
    <link rel="stylesheet" href="styles/cart.css">
</head>
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
                                <input type="hidden" name="name" value="<?php echo $fetch_product['name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $fetch_product['price']; ?>">
                                <input type="hidden" name="quantity" value="<?php echo $fetch_product['quantity']; ?>">
                                <input type="hidden" name="productdescription" value="<?php echo $fetch_product['product_description']; ?>">
                                <input type="hidden" name="image" value="<?php echo $fetch_product['image']; ?>">
                                <input type="hidden" name="total_amount" value="<?php echo $grand_total; ?>">
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
                    <form method="post" action="checkout.php" id="orderForm">
                        <div class="inputBox">
                            <div class="inputs">
                                <label for="inputname">Your Name</label><br>
                                <input id="inputname" type="text" name="inputname" required>
                            </div>

                            <div class="inputs">
                            <label for="inputemail">Your Email</label><br>
                            <input id="inputemail" type="email" name="inputemail" required>
                            </div>
                        </div>

                        <div class="inputBox">
                            <div class="inputs">
                                <label for="inputaddress">Address</label><br>
                                <input id="inputaddress" type="text" name="inputaddress" required>
                            </div>

                            <div class="inputs">
                            <label for="inputcountry">Country</label><br>
                            <input id="inputcountry" type="text" name="inputcountry" required>
                            </div>
                        </div>

                        <div class="inputBox">
                            <div class="inputs">
                                <label for="inputcity">City</label><br>
                                <input id="inputcity" type="text" name="inputcity" required>
                            </div>

                            <div class="inputs">
                            <label for="inputpostal">Postal Code</label><br>
                            <input id="inputpostal" type="text" name="inputpostal" required>
                            </div>
                        </div>

                        <div class="inputBox">
                            <div class="inputs">
                                <label for="inputphone">Phone Number</label><br>
                                <input id="inputphone" type="text" name="inputphone" required>
                            </div>

                            <div class="inputs">
                            <form method="get" action="cart.php" id="paymethod">
                            <label for="method">Select Payment Method</label><br>
                            <select id="method" name="method" onchange="document.getElementById('paymethod').submit();">
                                <option value="COD" selected>Cash On Delivery</option>
                                <option value="CreditCard">Credit Card</option>
                            </select>
                            </div>
                        </div>
                        
                        <h2>Total:&nbsp;<p id="grandTotal">₱<?php echo number_format($grand_total, 2); ?></p></h2>
                        <input type="hidden" name="total_amount" value="<?php echo $grand_total; ?>">
                        <input id="order" type="submit" value="Place Order" name="order_btn" class="btn">
                    </form>
                </div>
            </div>
            
            <div id="orderDetailsModal" class="modal">
                <div class="modal-content">
                    <h3>Order Confirmation</h3>
                <div id="orderDetails"></div> <!-- Order details will be inserted here -->
                <button onclick="closeModal()">Close</button>
                </div>
            </div>
        </div>
        
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
                    $("#price-" + productId).text('₱' + updatedPrice);

                    // Update the total
                    updateTotal();
                } else {
                    alert("Failed to update the cart: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + " " + error);
            }
        });
    });

    function updateTotal() {
        var total = 0;

        $(".product-price").each(function() {
            var priceText = $(this).text().replace('₱', '').trim();
            total += parseFloat(priceText);
        });

        $("#grandTotal").text('₱' + total.toFixed(2));
    }
});
    </script>
</body>
</html>