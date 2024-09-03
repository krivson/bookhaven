<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "bookhaven";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Failed to connect MySQL");
}
