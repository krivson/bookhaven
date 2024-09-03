<?php
include("../includes/config.php");
session_start();

if (!$_SESSION["type"] === "user") {
    header("Location: ../Index.php");
    exit();
} else {
    $user_id = $_SESSION['id'];
    if (isset($_GET['cart_id'])) {
        $cart_id = $_GET['cart_id'];
        mysqli_query($conn, "DELETE FROM carts WHERE cart_id = '$cart_id'");
        header("Location: Cart.php");
        exit();
    }

    if (isset($_POST["quantity"])) {
        $quantity = $_POST["quantity"];
        $cart_id = $_POST["cart_id"];

        mysqli_query($conn, "UPDATE carts SET quantity = $quantity WHERE cart_id = '$cart_id'");
        header("Location: ./Cart.php");
        exit();
    }

    if (isset($_POST["checkout"])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $email = $_POST['email'];
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $zip_code = mysqli_real_escape_string($conn, $_POST['zip_code']);
        $name_card = mysqli_real_escape_string($conn, $_POST['name_card']);
        $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
        $exp_month = mysqli_real_escape_string($conn, $_POST['exp_month']);
        $exp_year = mysqli_real_escape_string($conn, $_POST['exp_year']);
        $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
        $subtotal = $_POST['subtotal'];
        $total_products[] = '';
        $cart_products = array();

        $query_cart = mysqli_query($conn, "SELECT * FROM carts WHERE user_id = '$_SESSION[id]'");
        while ($cart = mysqli_fetch_assoc($query_cart)) {
            $query_book = mysqli_query($conn, "SELECT * FROM books WHERE book_id = '$cart[book_id]'");
            while ($book = mysqli_fetch_assoc($query_book)) {
                $cart_products[] = $book["title"] . "($cart[quantity])";
                $first_stock = $book['stock'];
                mysqli_query($conn, "UPDATE books SET stock = '$first_stock' - '$cart[quantity]' WHERE book_id = '$cart[book_id]'");
            }
            mysqli_query($conn, "DELETE FROM carts WHERE user_id = '$user_id'");
        }

        $total_products = implode(', ', $cart_products);
        mysqli_query($conn, "INSERT INTO orders (user_id, name, email, address, phone, city, zip_code, total_products, total_amount) VALUES ('$_SESSION[id]', '$name', '$email', '$address', '$phone', '$city', '$zip_code', '$total_products', '$subtotal')");
        header("Location: Orders.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | Bookhaven</title>
    <link rel="stylesheet" href="../assets/css/Cart.css">

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
        <div class="container-cart">
            <div class="top-cart">
                <h2>Shooping Cart</h2>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM carts WHERE user_id = '$user_id'");
                ?>
                <p>You have <span><?= mysqli_num_rows($query) ?></span> item(s) in your cart</p>
            </div>
            <div class="line-horizontal"></div>
            <div class="content-cart">
                <div class="row">
                    <?php
                    $grand_total = 0;
                    $query = mysqli_query($conn, "SELECT * FROM carts WHERE user_id = '$user_id'");
                    while ($cart = mysqli_fetch_assoc($query)) { ?>
                        <?php
                        $subtotal = $cart["price"] * $cart["quantity"];
                        $grand_total += $subtotal;
                        $book_id = $cart['book_id'];
                        $query_book = mysqli_query($conn, "SELECT * FROM books WHERE book_id = '$book_id'");
                        while ($book = mysqli_fetch_assoc($query_book)) { ?>
                            <div class="card">
                                <div class="card-details">
                                    <div class="card-image">
                                        <img src="../uploads/<?= $book['image'] ?>" alt="">
                                    </div>
                                    <div class="card-content">
                                        <h3 class="title"><?= $book['title'] ?></h3>
                                        <span class="category"><?= $book['genre'] ?></span>
                                        <span class="price"><?= "Rp" . number_format($book['price'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <form action="" method="post">
                                        <input type="hidden" name="cart_id" value="<?= $cart['cart_id'] ?>">
                                        <input type="number" name="quantity" id="quantity" value="<?= $cart['quantity'] ?>" max="<?= $book['stock'] ?>" required>
                                        <script>
                                            function handleEnter(event) {
                                                if (event.keyCode === 13) {
                                                    event.preventDefault();
                                                    submitForm();
                                                }
                                            }

                                            function submitForm() {
                                                var form = document.getElementsByClassName("quantity")
                                                var formData = new FormData(form);
                                                var xhr = new XMLHttpRequest();
                                                xhr.open("POST", form.action, true);
                                                xhr.onload = function() {
                                                    console.log(xhr.responseText);
                                                };
                                                xhr.send(formData);
                                            }
                                        </script>
                                    </form>
                                    <a href="./Cart.php?cart_id=<?= $cart['cart_id'] ?>"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="container-checkout">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$_SESSION[id]'");
            $user = mysqli_fetch_assoc($query);
            ?>
            <form action="./Cart.php" onsubmit="return validateForm()" method="post">
                <div class="wrapper">
                    <h3 class="title">Summary</h3>
                    <input type="hidden" name="email" value="<?= $user['email'] ?>">
                    <input type="text" name="name" id="name" value="<?= $user['name'] ?>" placeholder="Name">
                    <input type="text" name="address" id="address" value="<?= $user['address'] ?>" placeholder="Address">
                    <input type="text" name="phone" id="phone" placeholder="Phone">
                    <div class="group">
                        <input type="text" name="city" id="city" placeholder="City">
                        <input type="number" name="zip_code" id="zip_code" placeholder="Zip Code">
                    </div>
                </div>

                <div class="horizontal-line"></div>

                <div class="wrapper">
                    <h3 class="title">Card Details</h3>
                    <input type="text" name="name_card" id="name_card" placeholder="Name on Card">
                    <input type="number" name="card_number" id="card_number" placeholder="Card Number">
                    <div class="group">
                        <input type="number" min="1" max="12" name="exp_month" id="exp_month" placeholder="Exp Month">
                        <input type="number" min="<?= date("Y") ?>" name="exp_year" id="exp_year" placeholder="Exp Year">
                        <input type="number" name="cvv" id="cvv" placeholder="CVV">
                    </div>
                    <div class="horizontal-line"></div>
                    <div class="container-details">
                        <div class="details">
                            <p>Subtotal:</p><span><?= "Rp" . number_format($grand_total, 0, ',', '.') ?></span>
                            <input type="hidden" name="subtotal" value="<?= $grand_total ?>">
                        </div>
                        <button type="submit" name="checkout">
                            <span>Checkout</span>
                            <span><?= "Rp" . number_format($grand_total, 0, ',', '.') ?></span>
                        </button>

                        <script>
                            function validateForm() {
                                var expMonth = document.getElementById('exp_month').value;
                                var expYear = document.getElementById('exp_year').value;

                                var currentMonth = new Date().getMonth() + 1; // Adding 1 because getMonth() returns zero-based index
                                var currentYear = new Date().getFullYear();

                                if (expYear < currentYear || (expYear == currentYear && expMonth < currentMonth)) {
                                    alert('Invalid expiration date. Please check the expiration month and year.');
                                    return false;
                                }

                                return true;
                            }
                        </script>
                    </div>
                </div>
            </form>
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