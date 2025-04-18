<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $senha = hash('sha256', $_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ?");
    $stmt->execute([$username, $senha]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['usuario'] = $user['username'];
        header("Location: index.php");
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>

<form method="POST">
    <h2>Login</h2>
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
    <input type="text" name="username" placeholder="Usuário" required><br>
    <input type="password" name="password" placeholder="Senha" required><br>
    <button type="submit">Entrar</button>
</form>
