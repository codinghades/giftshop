<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    Tanggalin mo nalang yung bootstrap kung di kailangan-->
    <link rel="stylesheet" href="styles/general.css">
</head>
<body class="log-bg log-body">
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
            <h1>Login</h1>
            <?php
// Start the session at the top of the page
session_start();

if(isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Include your database connection
    require_once "connection.php";
    
    // Prepare SQL to select user based on email
    $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);  // bind the email parameter to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the user data
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    if ($user) {
        // If the user exists, verify the password
        if (password_verify($password, $user["password"])) {
            // Set session variables on successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION["user"] = "yes";  // Add a flag to indicate the user is logged in
            
            // Redirect to homepage after successful login
            header("Location: homepage.php");
            exit();  // Make sure the script ends here after redirection
        } else {
            // Error message for incorrect password
            echo "<div class='log-alert log-alert-danger'>Password does not match</div>";
        }
    } else {
        // Error message if email doesn't exist
        echo "<div class='log-alert log-alert-danger'>Email does not match</div>";
    }
}
?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter Email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Enter Password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" name="login" value="Login" class="log-btn">
            </div>
            <div class="reg">
                <p>Not registered yet?&nbsp;&nbsp;&nbsp; <a class="register" href="registration.php">Register here</a></p>
            </div>
        </form>
    </div>
</body>
</html>