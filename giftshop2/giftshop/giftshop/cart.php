<?php
    require_once 'connection.php';
    session_start();

    
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
        <h1>My Cart:</h1>
        <hr>
        <div class="cart-main">
            <div class="cart-main-left">
                <?php
                    $select_product = mysqli_query($conn, "SELECT * FROM cart") or die('query failed');
                    if(mysqli_num_rows($select_product) > 0){
                       while($fetch_product = mysqli_fetch_assoc($select_product)){
                ?>
                
                <div class="cart-product">
                    <div class="left">
                        <img src="<?php echo $fetch_product['image']; ?>" alt="">
                    </div>

                    <div class="right">
                        <p class="title"><?php echo $fetch_product['name']; ?></p><br>
                        <p class="descp">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam nam laborum unde amet deleniti, vero eum aut tempora eligendi velit, placeat quos est tenetur molestias dolor libero expedita saepe soluta!</p>
                        <div class="right-down">
                            <p class="product-price">$<?php echo number_format($fetch_product['price'], 2); ?></p><br>
                            <form action="" method="post">
                                <p class="qty">Quantity: <?php echo $fetch_product['quantity']; ?> 
                                        <button class="qtyBtn" type="submit" name="qtyMinus">-</button>
                                        <button class="qtyBtn" type="submit" name="qtyAdd">+</button>
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
                       };
                    }else{
                        echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">No item added</td></tr>';
                     }
                ?>
            </div>

            <div class="cart-main-right">
                
            </div>
        </div>
        
    </div>
</body>
</html>