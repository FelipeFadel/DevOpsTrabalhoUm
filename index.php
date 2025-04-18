<?php
session_start();
require_once "config.php";

// Redireciona para o login se não estiver autenticado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: login.php");
    exit;
}

// Consulta produtos
$sql = "SELECT * FROM produtos";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Hadio FX - Catálogo</title>
  <link rel="stylesheet" href="style.css" />
  <script src="script.js" defer></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet" />
</head>
<body>
  <nav class="navbar">
    <div class="nav-left">
      <a href="#inicio" class="nav-link">Inicio</a>
      <a href="#produtos" class="nav-link">Produtos</a>
      <a href="#contato" class="nav-link">Contato</a>
    </div>
    <div class="nav-right">
      <a href="logout.php" class="nav-link">Sair</a>
      <a href="#" class="nav-link" onclick="abrirModal('modalAdicionarProduto')">Adicionar Produtos</a>
    </div>
  </nav>

  <header id="inicio">
    <div class="contCenter">
      <div class="logo">
        <img src="rsc/images/HadioWhite.png" alt="Hadio FX logo" />
      </div>
      <h1>BEM-VINDO À HADIO FX</h1>
      <p>Explore os melhores efeitos e pedais para sua guitarra.</p>
    </div>
  </header>

  <section id="produtos">
    <h2>PRODUTOS</h2>
    <p>Aqui você encontrará nossos pedais, acessórios e novidades da nossa linha.</p>

    <div class="produtos-container">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="produto-card">
          <img src="<?= htmlspecialchars($row['imagem']) ?>" alt="<?= htmlspecialchars($row['nome']) ?>" />
          <h3><?= htmlspecialchars($row['nome']) ?></h3>
          <p class="preco">R$ <?= number_format($row['preco'], 2, ',', '.') ?></p>
          <p class="quantidade">Qtd: <?= $row['quantidade'] ?></p>
          <form action="delete.php" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este produto?');">
            <input type="hidden" name="id" value="<?= $row['id'] ?>" />
            <button type="submit">Remover</button>
          </form>
          <button onclick='editarProdutoBackend(<?= json_encode($row) ?>)'>Editar</button>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <section id="contato">
    <h2>Contato</h2>
    <p>Entre em contato conosco para pedidos especiais ou dúvidas técnicas.</p>
    <form action="contato.php" method="POST">
      <label for="nome">Nome:</label><br />
      <input type="text" id="nome" name="nome" required /><br /><br />
      <label for="email">Email:</label><br />
      <input type="email" id="email" name="email" required /><br /><br />
      <label for="mensagem">Mensagem:</label><br />
      <textarea id="mensagem" name="mensagem" rows="5" required></textarea><br /><br />
      <button type="submit">Enviar</button>
    </form>
    <img src="rsc/images/HadioWhite.png" alt="Hadio FX logo" />
  </section>

  <div id="modalAdicionarProduto" class="modal">
    <div class="modal-content">
      <span class="close" onclick="fecharModal('modalAdicionarProduto')">&times;</span>
      <h2 id="tituloModal">Adicionar Novo Produto</h2>
      <form id="formAdicionarProduto" action="create.php" method="POST">
        <input type="hidden" id="produtoId" name="id" />
        <label for="imagemUrl">URL da Imagem:</label><br />
        <input type="text" id="imagemUrl" name="imagem" required /><br /><br />

        <label for="nomeProduto">Nome do Produto:</label><br />
        <input type="text" id="nomeProduto" name="nome" required /><br /><br />

        <label for="precoProduto">Preço (R$):</label><br />
        <input type="number" id="precoProduto" name="preco" step="0.01" required /><br /><br />

        <label for="quantidadeProduto">Quantidade:</label><br />
        <input type="number" id="quantidadeProduto" name="quantidade" required /><br /><br />

        <button type="submit" id="btnSalvar">Adicionar ao Catálogo</button>
      </form>
    </div>
  </div>

  <script>
    function editarProdutoBackend(produto) {
      abrirModal('modalAdicionarProduto');
      document.getElementById("produtoId").value = produto.id;
      document.getElementById("imagemUrl").value = produto.imagem;
      document.getElementById("nomeProduto").value = produto.nome;
      document.getElementById("precoProduto").value = produto.preco;
      document.getElementById("quantidadeProduto").value = produto.quantidade;
      document.getElementById("tituloModal").textContent = "Editar Produto";
      document.getElementById("formAdicionarProduto").action = "update.php";
      document.getElementById("btnSalvar").textContent = "Salvar Alterações";
    }
  </script>
</body>
</html>
