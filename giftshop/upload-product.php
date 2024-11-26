<?php
// Reference:
// https://github.com/ProgrammingInsider/Building-eCommerce-website-upload-Images-to-database-display-from-database-and-add-products-to-cart/blob/main/product%20table%20sql%20code.sql

    require_once 'connection.php';

    if (isset($_POST["submit"])) {
        // Escape all input to prevent SQL errors and injection
        $productname = mysqli_real_escape_string($conn, $_POST["productname"]);
        $productdescription = mysqli_real_escape_string($conn, $_POST["productdescription"]);
        $price = floatval($_POST["price"]); 
        $discount = floatval($_POST["discount"]); 
        $quantity = intval($_POST["quantity"]); 
        $category = mysqli_real_escape_string($conn, $_POST["category"]);
    
        // File upload settings
        $upload_dir = "shopProducts/";
        $product_image = $upload_dir . basename($_FILES["imageUpload"]["name"]);
        $upload_file = $upload_dir . basename($_FILES["imageUpload"]["name"]);
        $imageType = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
        $check = $_FILES["imageUpload"]["size"];
        $upload_ok = 1;
    
        // File validation
        if (file_exists($upload_file)) {
            echo "<script>alert('The file already exists.')</script>";
            $upload_ok = 0;
        } else {
            if ($check !== false) {
                if (in_array($imageType, ['jpg', 'png', 'jpeg', 'gif'])) {
                    $upload_ok = 1;
                } else {
                    echo '<script>alert("Invalid image format. Use JPG, PNG, JPEG, or GIF.")</script>';
                    $upload_ok = 0;
                }
            } else {
                echo '<script>alert("Invalid photo size. Please upload a valid photo.")</script>';
                $upload_ok = 0;
            }
        }
    
        // If file passes validation
        if ($upload_ok == 1) {
            if ($productname != "" && $price != "") {
                if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $upload_file)) {
                    $sql = "INSERT INTO shop (product_name, product_description, price, discount, quantity, category, product_image) 
                            VALUES ('$productname', '$productdescription', $price, $discount, $quantity, '$category', '$product_image')";
    
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Product uploaded successfully.')</script>";
                    } else {
                        echo "<script>alert('Error: " . $conn->error . "')</script>";
                    }
                } else {
                    echo '<script>alert("Failed to move uploaded file.")</script>';
                }
            } else {
                echo '<script>alert("Product name and price are required.")</script>';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Products</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        #uploadContainer{
            margin: 10% auto;
            width: 50%;
        }

        #uploadContainer form{
            display: flex;
            flex-direction: column;
        }

        #uploadContainer form input{
            padding: .7rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border: 1px solid black;
        }

        #uploadContainer form .inputImage{
            padding: .7rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border: 1px solid black;
            background-color: black;
            color: white;
            cursor: pointer;
        }

        #uploadContainer form .inputSubmit{
            cursor: pointer;
        }
    </style>
</head>
<body>
    <section id="uploadContainer">
        <form method="post" action="upload-product.php" enctype="multipart/form-data">
            <input class="cssInput" type="text" name="productname" id="productname" placeholder="Product Name" required>
            <input class="cssInput" type="text" name="productdescription" id="productdescription" placeholder="Product Description" required>
            <input class="cssInput" type="text" name="price" id="price" placeholder="Product Price" required>
            <input class="cssInput" type="text" name="discount" id="discount" placeholder="Product Discount">
            <input class="cssInput" type="text" name="quantity" id="quantity" placeholder="Quantity">
            <input class="cssInput" type="text" name="category" id="category" placeholder="Category">
            <input class="inputFile" type="file" name="imageUpload" id="imageUpload" required hidden>
            <button class="inputImage" id="choose" onclick="upload()">Choose Image</button>
            <input class="inputSubmit" type="submit" value="Upload" name="submit">
        </form>
    </section>

    <script>
        var productname = document.getElementById('productname');
        var productdescription = document.getElementById('productdescription');
        var price = document.getElementById('price');
        var discount = document.getElementById('discount');
        var quantity = document.getElementById('quantity');
        var category = document.getElementById('category');
        var imageUpload = document.getElementById('imageUpload');
        var choose = document.getElementById('choose');

        function upload(){
            imageUpload.click();
        }

        imageUpload.addEventListener("change", function(){
            var file = this.files[0];
            if(productname.value == ""){
                productname.value = file.name;
            }

            choose.innerHTML = "You can change("+file.name+") picture";
        });
    </script>
</body>
</html>