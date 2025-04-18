<?php
require 'auth.php';
require 'config.php';

$stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
