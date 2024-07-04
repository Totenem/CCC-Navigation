<!DOCTYPE html>
<html lang="en">

<head>
    <link href="signup.css" rel="stylesheet" type="text/CSS">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_POST['signup'])) {
        $user_name = $_POST['username'];
        $pass = $_POST['password'];
        $email = $_POST['email'];

        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
        $errors = array();

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $user_name)) {
            array_push($errors, "Username should only contain letters, numbers, and underscores");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is Not Valid");
        }

        if (strlen($pass) < 8) {
            array_push($errors, "Passowrd is Not Valid");
        }

        require_once "dbcon.php"; //Data base connection
        $sql = "SELECT *  FROM users WHERE email = '$email'"; //Checking if email already exist
        $result = mysqli_query($conn, $sql);
        $count_rows = mysqli_num_rows($result);

        if ($count_rows > 0) {
            array_push($errors, "Email already exist");
        }

        if (count($errors) > 0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>$error</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
            }
        } else {
            $sql = "INSERT INTO users(username, email, password) VALUES (?, ?, ?)"; //Inserting dATA
            $stmt = mysqli_stmt_init($conn);
            $preparestmt = mysqli_stmt_prepare($stmt, $sql);

            if ($preparestmt) {
                mysqli_stmt_bind_param($stmt, "sss", $user_name, $email, $pass_hash,); //INSERTING DATA P2
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>Sucessfuly Registered! </div>";
                header("Location: login.php");
            } else {
                die("Something went wrong");
            }
        }
    }


    ?>
    <div class="box">
        <form action="signup.php" method="post"><!--For the back end to work need ng form tag-->
            <img src="img/cnav-logo.png" alt="Logo">
            <h1>Sign Up</h1>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" alt="text" placeholder="Input your username" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" alt="password" required placeholder="Input your password">
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="username" name="email" alt="text" placeholder="Input your email" required>
            </div>
            <button type="submit" name="signup" class="submit">Sign up</button>
            <div class="Register">
                <p>Already have an account? <a href="login.php" style="color:black; text-decoration:none">Log in here</a></p>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>