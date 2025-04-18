<?php
$host = "localhost";
$dbname = "hadiofx";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header("Location: error.php?msg=" . urlencode($e->getMessage()));
    exit();
}
?>