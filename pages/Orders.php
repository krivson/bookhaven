<?php
include("../includes/config.php");
session_start();

if (!$_SESSION["type"] === "user") {
    header("Location: ../Index.php");
    exit();
} else {
    $user_id = $_SESSION['id'];

    if (isset($_GET['order_id'])) {
        mysqli_query($conn, "UPDATE orders SET status = 'Arrived', delivery_date = NOW()");
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
    <title>Orders | Bookhaven</title>
    <link rel="stylesheet" href="../assets/css/Orders.css">

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

        <div class="container-orders">
            <div class="top">
                <h2>List Orders</h2>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_id DESC");
                ?>
                <p>You have <span><?= mysqli_num_rows($query) ?></span> item(s) in your orders</p>
            </div>
            <div class="horizontal-line"></div>
            <div class="bottom">
                <div class="row">
                    <?php
                    $i = 1;
                    while ($order = mysqli_fetch_assoc($query)) { ?>
                        <div class="card">
                            <div class="container-text">
                                <p>Number:</p><span><?= $i ?></span>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="container-text">
                                <p>Receiver Name:</p><span><?= $order['name'] ?></span>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="container-text">
                                <p>Email:</p><span><?= $order['email'] ?></span>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="container-text">
                                <p>Phone:</p><span><?= $order['phone'] ?></span>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="container-text">
                                <p>Order Date:</p><span><?= $order['order_date'] ?></span>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="container-text">
                                <p>Shipping Address:</p><span><?= $order['address'] ?></span>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="container-text">
                                <p>Total Products:</p><span><?= $order['total_products'] ?></span>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="container-text">
                                <p>Total Price:</p><span><?= "Rp" . number_format($order['total_amount'], 0, ',', '.') ?></span>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="container-text">
                                <p>Delivery Status:</p><span><?= $order['status'] ?></span>
                            </div>
                            <div class="horizontal-line"></div>
                            <?php
                            if ($order['status'] === 'Process') { ?>
                                <div class="container-text">
                                    <p>Has the Book Arrived?</p><span><a href="./Orders.php?order_id=<?= $order['order_id'] ?>">Accept</a></span>
                                </div>
                                <div class="horizontal-line"></div>
                                <div class="container-text">
                                    <p>Delivery Date:</p><span>-</span>
                                </div>
                            <?php } else { ?>
                                <div class="container-text">
                                    <p>Has the Book Arrived?</p><span><a>Accept</a></span>
                                </div>
                                <div class="horizontal-line"></div>
                                <div class="container-text">
                                    <p>Delivery Date:</p><span><?= $order['delivery_date'] ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    <?php
                        $i++;
                    } ?>
                </div>
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