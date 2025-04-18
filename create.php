<?php
require 'auth.php';
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, imagem, quantidade) VALUES (?, ?, ?, ?)");
$stmt->execute([$data['nome'], $data['preco'], $data['imagem'], $data['quantidade']]);

echo json_encode(["status" => "ok", "id" => $pdo->lastInsertId()]);
