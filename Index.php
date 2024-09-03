<?php
include("./includes/config.php");
session_start();

if (!isset($_SESSION["name"])) {
    header("Location: ./auth/SignIn.php");
    exit();
} else {
    $user_id = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookhaven</title>
    <link rel="stylesheet" href="./assets/css/Style.css">

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
                <a href="./Index.php">Bookhaven</a>
            </div>
            <div class="center">
                <form action="" method="post"><button type="submit" name="search_book"><i class="fa-solid fa-magnifying-glass"></i></button><input type="text" name="search" placeholder="Search Books"></form>
            </div>
            <div class="right">
                <div class="group">
                    <a href="./pages/Cart.php" class="shopping-cart">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM carts WHERE user_id = '$user_id'");

                        if (mysqli_num_rows($query) > 0) { ?>
                            <span><?= mysqli_num_rows($query) ?></span>
                        <?php } ?>
                    </a>
                    <a href="./pages/Orders.php" class="orders">
                        <i class="fa-solid fa-box"></i>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id'");

                        if (mysqli_num_rows($query) > 0) { ?>
                            <span><?= mysqli_num_rows($query) ?></span>
                        <?php } ?>
                    </a>
                </div>
                <div class="vertical-line"></div>
                <div class="button"><a href="./auth/SignOut.php">Sign Out</a></div>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main>
        <!-- Category Section -->
        <section class="categorys">
            <ul>
                <li><a href="./Index.php" class="active" >For You</a></li>
                <li><a href="./Index.php?genre=Fiction">Fiction</a></li>
                <li><a href="./Index.php?genre=Non-Fiction">Non-Fiction</a></li>
            </ul>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Ambil semua elemen <a> di dalam <li>
                var li = document.querySelectorAll('.categorys li');
                var links = document.querySelectorAll('.categorys li a');

                // Tambahkan event listener untuk setiap elemen <a>
                li.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        // Hentikan perilaku default dari tautan
                        event.preventDefault();

                        // Simpan href ke localStorage
                        localStorage.setItem('activeLink', link.querySelector('a').getAttribute('href'));

                        // Hapus kelas 'active' dari semua elemen <a>
                        li.forEach(function(otherLink) {
                            otherLink.classList.remove('active');
                        });

                        // Tambahkan kelas 'active' ke elemen <a> yang ditekan
                        link.classList.add('active');

                        // Arahkan ke link a yang sesuai
                        window.location.href = localStorage.getItem('activeLink');
                    });
                });

                // Memeriksa apakah ada href yang disimpan di localStorage
                var activeHref = localStorage.getItem('activeLink');
                if (activeHref) {
                    // Menambahkan kelas 'active' ke elemen yang sesuai
                    var activeElement = document.querySelector('.categorys li a[href="' + activeHref + '"]');
                    if (activeElement) {
                        activeElement.closest('li').classList.add('active');
                    }
                }
            });
        </script>

        <!-- Products Section -->
        <section class="products">
            <div class="row">
                <?php
                if (isset($_GET["genre"])) {
                    $genre = $_GET["genre"];
                    $book_query = mysqli_query($conn, "SELECT * FROM books WHERE genre = '$genre'");
                } else if (isset($_POST["search_book"])) {
                    $search = $_POST["search"];
                    $book_query = mysqli_query($conn, "SELECT * FROM books WHERE title LIKE '%$search%'");
                } else {
                    $book_query = mysqli_query($conn, "SELECT * FROM books");
                }

                // echo $book_query;
                while ($book = mysqli_fetch_assoc($book_query)) { ?>
                    <div class="card">
                        <a href="./pages/ProductDetails.php?book_id=<?= $book['book_id'] ?>">
                            <div class="card-image">
                                <img src="./uploads/<?= $book['image'] ?>" alt="">
                            </div>
                            <div class="card-content">
                                <span class="author"><?= $book['author'] ?></span>
                                <h3 class="title"><?= $book['title'] ?></h3>
                                <?php if ($book['stock'] < 1) { ?>
                                    <a class="price">Sold Out!</a>
                                <?php } else { ?>
                                    <a href="./pages/ProcessAddToCart.php?book_id=<?= $book['book_id'] ?>" class="price"><i class="fa-solid fa-cart-plus"></i><?= "Rp" . number_format($book['price'], 0, ',', '.'); ?></a>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>Copyright © 2023 Bookhaven. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>