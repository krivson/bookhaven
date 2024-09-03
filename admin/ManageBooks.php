<?php
include("../includes/config.php");
session_start();

if ($_SESSION['type'] == 'user') {
    header("Location: ../Index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books | Admin</title>
    <link rel="stylesheet" href="../assets/css/ManageBooks.css">

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
            <h2>☰ Manage Books</h2>

            <ul>
                <li><a href=""><?= $_SESSION['name'] ?></a></li>
                <li><a href="../auth/SignOut.php">Sign Out</a></li>
            </ul>
        </header>

        <section>
            <div class="container-table">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($conn, "SELECT * FROM books");
                        while ($book = mysqli_fetch_array($query)) :
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><img src="../uploads/<?= $book['image'] ?>" alt=""></td>
                                <td><?= $book['title'] ?></td>
                                <td><?= $book['author'] ?></td>
                                <td><?= "Rp" . number_format($book['price'], 0, ',', '.'); ?></td>
                                <td><?= $book['stock'] ?></td>
                                <td>
                                    <div class="button">
                                        <a href="./EditBook.php?book_id=<?= $book['book_id'] ?>">Edit</a>
                                        <a href="">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        endwhile; ?>
                    </tbody>
                </table>
                <a href="./AddBook.php">Add Book</a>
            </div>
        </section>
    </main>
</body>

</html>