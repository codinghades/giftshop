<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    Tanggalin mo nalang yung bootstrap kung di kailangan-->
    <link rel="stylesheet" href="styles/general.css">
</head>
<body class="log-bg">
    <br>
    <div class="container">
        <div class="form-group">
            <a class="back" href="homepage.php">Back</a>
        </div>
        <div class="log-nav">
                <div class="log-left">
                    <div class="log-nav-logo">
                        <img src="images/animehaven_logo.png" alt="Anime Haven">
                    </div>
                </div>
            </div>
            <h1>Register</h1>
        <?php
        if (isset($_POST["submit"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordrepeat = $_POST["repeat_password"];
            $errors = array();

            $passwordhash = password_hash($password, PASSWORD_DEFAULT);

            //Input checker
            if(empty($username) || empty($email) || empty($password) || empty($passwordrepeat)) {
                array_push($errors, "All fields are required");
            }
            //Email checker
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            //Password at least 8 long
            if(strlen($password)<8) {
                array_push($errors, "Password must be at least 8 characters long");
            }
            //Password checker
            if($password !== $passwordrepeat) {
                array_push($errors, "Password does not match");
            }
            //Email repeat checker
            require_once "connection.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
                array_push($errors, "Email already exists");
            }
            //Display error messages
            if(count($errors)>0) {
                foreach($errors as $error) {
                    echo "<div class='log-alert log-alert-danger'>$error</div>";
                }
            }
            else{
                //Insert into database
                $sql = "INSERT INTO users (username, email, password) VALUES ( ?, ?, ? )";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordhash);
                    mysqli_stmt_execute($stmt);
                    //echo "<div class='log-alert log-alert-success'>You are registered successfully.</div>";
                    header("Location: login.php");
                }
                else{
                    die("Something went wrong.");
                }
            }

        }
        ?>
        <form action="registration.php" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
        </div>
        <div class="form-group">
            <input type="submit" class="log-btn" name="submit" value="Register">
        </div>
        <div class="reg">
            <p>Already registered?&nbsp;&nbsp;&nbsp; <a class="register" href="login.php">Go to login</a></p>
        </div>
        </form>
    </div>
</body>
</html>