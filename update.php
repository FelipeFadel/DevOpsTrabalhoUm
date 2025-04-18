<?php
require 'auth.php';
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("UPDATE produtos SET nome = ?, preco = ?, imagem = ?, quantidade = ? WHERE id = ?");
$stmt->execute([$data['nome'], $data['preco'], $data['imagem'], $data['quantidade'], $data['id']]);

echo json_encode(["status" => "ok"]);
