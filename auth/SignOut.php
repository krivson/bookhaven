<?php
session_start();

if (isset($_SESSION["name"])) {
    session_unset(); // Hapus semua data sesi
    session_destroy(); // Hancurkan sesi
    header("Location: SignIn.php");
    exit();
} else {
    header("Location: SignIn.php");
    exit();
}
