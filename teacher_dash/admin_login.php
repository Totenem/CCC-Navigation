<?php
session_start();

// Check if the user is already logged in
if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    // Redirect to homepage
    header("Location: dashboard.php");
    exit;
}

// Check if the login form is submitted
if(isset($_POST['login'])){
    $user_name = $_POST['username'];
    $password = $_POST['password'];
    require_once "dbcon.php"; // Database connection

    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Debugging


        // Verify password
        if($password === $user["password"]){
            // Set session variables including user ID and username
            $_SESSION['admin_id'] = $user['admin_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_logged_in'] = true;
            // Redirect to homepage
            header("Location: dashboard.php");
            exit;
        } else{
            // Incorrect password
            $error = "Wrong Password!";
        }
    } else{
        // Account not found
        $error = "Account not found";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="login.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CCC Navigation</title>
</head>
<body>
    <div class="box">
        <?php
        // Display error message if exists
        if(isset($error)){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>$error</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
        ?>
        <form action="admin_login.php" method="post">
            <div class="pic-logo">
                <img src="img/cnav-logo.png" alt="Logo">
            </div>
            <h1>Log In</h1>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Input your username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Input your password">
                <button name="login" type="submit" class="submit">Log In</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
