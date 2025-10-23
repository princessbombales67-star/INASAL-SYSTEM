<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inasal_system"; // 👉 palitan kung iba DB name mo

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("❌ Database Connection failed: " . mysqli_connect_error());
}
?>
