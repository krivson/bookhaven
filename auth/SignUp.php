<?php
include("../includes/config.php");
session_start();

if (isset($_SESSION["name"])) {
    if ($_SESSION["type"] === "admin") {
        header("Location: ../admin/Dashboard.php");
        exit();
    } else if ($_SESSION["type"] === "user") {
        header("Location: ../Index.php");
        exit();
    }
} else {
    if (isset($_POST["sign_up"])) {
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        if (mysqli_num_rows($query) > 0) {
            echo
            "
            <script>
                alert(`You can't use this email!`);
            </script>
            ";
            header("Refresh: 0");
            exit();
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query = mysqli_query($conn, "INSERT INTO users(name, email, password, address, created_date) VALUES('$name', '$email', '$password_hash', '$address', NOW())");
            header("Location: SignIn.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Bookhaven</title>
    <link rel="stylesheet" href="../assets/css/SignUp.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <h1>Sign Up</h1>
            <div class="input-box">
                <input type="name" name="name" placeholder="Name">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="address" name="address" placeholder="Address">
                <i class="fa-solid fa-home"></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email">
                <i class="fa-solid fa-at"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Password">
                <i class="fa-solid fa-lock"></i>
            </div>

            <button type="submit" name="sign_up">Sign Up</button>

            <div class="register-link">
                <p>Have account? <a href="./SignIn.php">Sign In</a></p>
            </div>
        </form>
    </div>
</body>

</html>