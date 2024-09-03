<?php
include("../includes/config.php");
session_start();

if ($_SESSION["type"] === "user") {
    header("Location: ../Index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin</title>
    <link rel="stylesheet" href="../assets/css/Dashboard.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <aside>
        <div class="logo">
            <h1>Bookhaven</h1>
        </div>
        <ul>
            <li><a href="./Dashboard.php"><i class="fa-solid fa-gauge"></i>Dashboard</a></li>
            <li><a href="./ManageBooks.php"><i class="fa-solid fa-book"></i>Manage Books</a></li>
            <li><a href="./ManageOrders.php"><i class="fa-solid fa-boxes"></i>Manage Orders</a></li>
        </ul>
    </aside>

    <!-- Main -->
    <main>
        <!-- Header -->
        <header>
            <h2>☰ Dashboard</h2>

            <ul>
                <li><a href=""><?= $_SESSION["name"] ?></a></li>
                <li><a href="../auth/SignOut.php">Sign Out</a></li>
            </ul>
        </header>

        <section>
            <div class="row">
                <div class="box">
                    <?php
                    $users_query = mysqli_query($conn, "SELECT * FROM users WHERE type = 'user'");
                    $books_query = mysqli_query($conn, "SELECT * FROM books");
                    $orders_query = mysqli_query($conn, "SELECT * FROM orders"); ?>
                    <div>
                        <span><?= mysqli_num_rows($users_query) ?></span>
                        <span>User(s)</span>
                    </div>
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="box">
                    <div>
                        <span><?= mysqli_num_rows($books_query) ?></span>
                        <span>Book(s)</span>
                    </div>
                    <i class="fa-solid fa-book"></i>
                </div>
                <div class="box">
                    <div>
                        <span><?= mysqli_num_rows($orders_query) ?></span>
                        <span>Order(s)</span>
                    </div>
                    <i class="fa-solid fa-boxes"></i>
                </div>
            </div>
        </section>
    </main>
</body>

</html>