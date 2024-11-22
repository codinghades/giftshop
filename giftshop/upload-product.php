<?php
// Reference:
// https://github.com/ProgrammingInsider/Building-eCommerce-website-upload-Images-to-database-display-from-database-and-add-products-to-cart/blob/main/product%20table%20sql%20code.sql

    require_once 'connection.php';

    if(isset($_POST["submit"])){
        $productname = $_POST["productname"];
        $price = $_POST["price"];
        $discount = $_POST["discount"];


        // For Upload Photos
        $upload_dir = "limitedProduct/"; // this is where the uploaded photo stored
        $product_image = $upload_dir.$_FILES["imageUpload"]["name"];
        $upload_dir.$_FILES["imageUpload"]["name"];
        $upload_file = $upload_dir.basename($_FILES["imageUpload"]["name"]);
        $imageType = strtolower(pathinfo($upload_file,PATHINFO_EXTENSION)); //used to detected the image format
        $check = $_FILES["imageUpload"]["size"]; // to detect the size of the image
        $upload_ok = 0;

        if(file_exists($upload_file)){
            echo "<script>alert('The file is already exist')</script>";
            $upload_ok = 0;
        }else{
            $upload_ok = 1;
            if($check !== false){
                $upload_ok = 1;
                if($imageType == 'jpg' || $imageType == 'png' || $imageType == 'jpeg' || $imageType == 'gif'){
                    $upload_ok = 1;
                }else{
                    echo '<script>alert("Please change the image format")</script>';
                }
            }else{
                echo '<script>alert("The photo size is 0 please change the photo")</script>';
                $upload_ok = 0;
            }
        }

        if($upload_ok == 0){
            echo '<script>alert("sorry your file doesn\'t uploaded. Please try again.")</script>';
        }else{
            if($productname != "" && $price !=""){
                move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $upload_file);

                $sql = "INSERT INTO product(product_name,price,discount,product_image)
                VALUES('$productname',$price,$discount,'$product_image')";

                if($conn->query($sql) === TRUE){
                    echo "<script>alert('your product uploaded successfully')</script>";
                }
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
            <input class="cssInput" type="text" name="price" id="price" placeholder="Product Price" required>
            <input class="cssInput" type="text" name="discount" id="discount" placeholder="Product Discount">
            <input class="inputFile" type="file" name="imageUpload" id="imageUpload" required hidden>
            <button class="inputImage" id="choose" onclick="upload()">Choose Image</button>
            <input class="inputSubmit" type="submit" value="Upload" name="submit">
        </form>
    </section>

    <script>
        var productname = document.getElementById('productname');
        var price = document.getElementById('price');
        var discount = document.getElementById('discount');
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