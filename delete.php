<?php
require 'auth.php';
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->execute([$data['id']]);

echo json_encode(["status" => "ok"]);
