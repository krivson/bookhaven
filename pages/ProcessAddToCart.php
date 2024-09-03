<?php
include("../includes/config.php");
session_start();

if (isset($_GET["book_id"])) {
    $user_id = $_SESSION["id"];
    $book_id = $_GET['book_id'];

    $query = mysqli_query($conn, "SELECT * FROM books WHERE book_id = '$book_id'");
    $book = mysqli_fetch_assoc($query);

    $price = $book['price'];
    $stock = $book['stock'];

    $query = mysqli_query($conn, "SELECT * FROM carts WHERE user_id = '$user_id' AND book_id = '$book_id'");

    if (mysqli_num_rows($query) >= 1) {
        $fetch_cart = mysqli_fetch_assoc($query);
        $first_quantity = $fetch_cart["quantity"];
        $result = $first_quantity + $quantity;

        if ($stock > $result) {
            mysqli_query($conn, "UPDATE carts SET quantity = '$first_quantity' + 1 WHERE user_id = '$user_id' AND book_id = '$book_id'");
            header("Location: ../Index.php");
            exit();
        } else {
            echo
            "
            <script>    
                alert('The stock is insufficient!');
                window.location.href = '../Index.php';
            </script>
            ";
        }
    } else {
        mysqli_query($conn, "INSERT INTO carts (user_id, book_id, price, quantity) VALUES ('$user_id', '$book_id', '$price', 1)");
        header("Location: ../Index.php");
        exit();
    }
} else if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION["id"];
    $quantity = $_POST['quantity'];
    $book_id = $_POST['book_id'];

    $query = mysqli_query($conn, "SELECT * FROM books WHERE book_id = '$book_id'");
    $book = mysqli_fetch_assoc($query);

    $price = $book['price'];
    $stock = $book['stock'];

    $query = mysqli_query($conn, "SELECT * FROM carts WHERE user_id = '$user_id' AND book_id = '$book_id'");

    if (mysqli_num_rows($query) >= 1) {
        $fetch_cart = mysqli_fetch_assoc($query);
        $first_quantity = $fetch_cart["quantity"];
        $result = $first_quantity + $quantity;

        if ($stock >= $result) {
            mysqli_query($conn, "UPDATE carts SET quantity = '$first_quantity' + '$quantity' WHERE user_id = '$user_id' AND book_id = '$book_id'");
            header("Location: ./Cart.php");
            exit();
        } else {
            echo
            "
            <script>    
                alert('The stock is insufficient!');
                window.location.href = '../Index.php';
            </script>
            ";
        }
    } else {
        mysqli_query($conn, "INSERT INTO carts (user_id, book_id, price, quantity) VALUES ('$user_id', '$book_id', '$price', '$quantity')");
        header("Location: ./Cart.php");
        exit();
    }
}
