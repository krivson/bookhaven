<?php
include("../includes/config.php");
session_start();

if (isset($_SESSION["name"])) {
    header("Location: ../Index.php");
    exit();
} else {
    if (isset($_POST["sign_in"])) {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        if (mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);
            if (password_verify($password, $user["password"])) {
                if ($user["type"] === "admin") {
                    $_SESSION["id"] = $user['user_id'];
                    $_SESSION["name"] = $user['name'];
                    $_SESSION["type"] = $user["type"];
                    header("Location: ../admin/Dashboard.php");
                    exit();
                } else if ($user["type"] === "user") {
                    $_SESSION["id"] = $user['user_id'];
                    $_SESSION["name"] = $user['name'];
                    $_SESSION["type"] = $user["type"];
                    header("Location: ../Index.php");
                    exit();
                }
            } else {
                echo
                "
                <script>
                    alert('Wrong password! Try again.');
                </script>
                ";
                header("Refresh: 0");
                exit();
            }
        } else {
            echo
            "
            <script>
                alert('Email not found!');
            </script>
            ";
            header("Refresh: 0");
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
    <title>Sign In | Bookhaven</title>
    <link rel="stylesheet" href="../assets/css/SignIn.css">

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
            <h1>Sign In</h1>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class="fa-solid fa-at"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="fa-solid fa-lock"></i>
            </div>

            <button type="submit" name="sign_in">Sign In</button>

            <div class="register-link">
                <p>Don't have account? <a href="./SignUp.php">Sign Up</a></p>
            </div>
        </form>
    </div>

    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

    </script>
</body>

</html>