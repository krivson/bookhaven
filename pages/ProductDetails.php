<?php
include("../includes/config.php");
session_start();

if (!$_SESSION["type"] === "user") {
    header("Location: ../Index.php");
    exit();
} else {
    $user_id = $_SESSION['id'];
    $book_id = $_GET['book_id'];
    $query = mysqli_query($conn, "SELECT * FROM books WHERE book_id = '$book_id'");
    $book = mysqli_fetch_assoc($query);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['title'] ?></title>
    <link rel="stylesheet" href="../assets/css/ProductDetails.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <header>
        <div class="top">
            <div class="left">
                <ul>
                    <li><span class="number-phone"><i class="fa-solid fa-phone"></i>0812-3456-7890</span></li>
                    <li>
                        <div class="vertical-line"></div>
                    </li>
                    <li><a href="">About Us</a></li>
                    <li><a href="">FAQS</a></li>
                    <li><a href="">Contacts</a></li>
                </ul>
            </div>
            <div class="right">
                <ul>
                    <li><a href=""><?= $_SESSION['name'] ?></a></li>
                    <li><a href="">Assistance</a></li>
                </ul>
            </div>
        </div>
        <div class="bottom">
            <div class="left">
                <a href="../Index.php">Bookhaven</a>
            </div>
            <div class="center">
                <form action=""><button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button><input type="text" placeholder="Search Books"></form>
            </div>
            <div class="right">
                <div class="group">
                    <a href="./Cart.php" class="shopping-cart">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM carts WHERE user_id = '$user_id'");

                        if (mysqli_num_rows($query) > 0) { ?>
                            <span><?= mysqli_num_rows($query) ?></span>
                        <?php } ?>
                    </a>
                    <a href="./Orders.php" class="orders">
                        <i class="fa-solid fa-box"></i>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id'");

                        if (mysqli_num_rows($query) > 0) { ?>
                            <span><?= mysqli_num_rows($query) ?></span>
                        <?php } ?>
                    </a>
                </div>
                <div class="vertical-line"></div>
                <div class="button"><a href="../auth/SignOut.php">Sign Out</a></div>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM books WHERE book_id = '$book_id'");
        $book = mysqli_fetch_assoc($query);
        ?>
        <div class="container">
            <div class="image-details">
                <img src="../uploads/<?= $book['image'] ?>" alt="">
            </div>
            <div class="content-details">
                <h2 class="title"><?= $book['title'] ?></h2>
                <span class="author"><?= $book['author'] ?></span>
                <h5 class="price"><?= "Rp" . number_format($book['price'], 0, ',', '.'); ?></h5>
                <p>Stock: <?= $book['stock'] ?></p>
                <div class="line-horizontal"></div>
                <p class="description"><?= $book['description'] ?></p>
                <form action="./ProcessAddToCart.php" method="post">
                    <input type="hidden" name="book_id" value="<?= $book_id ?>">
                    <div class="number-input">
                        <a onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</a>
                        <input type="number" name="quantity" id="quantity" min="1" value="1" max="<?= $book['stock'] ?>" required>
                        <a onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</a>
                    </div>
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>Copyright © 2023 Bookhaven. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>