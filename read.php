<?php
// Verifica se o parâmetro id existe
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Inclui o arquivo de configuração
    require_once "config.php";
    
    // Prepara a query
    $sql = "SELECT * FROM produtos WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Liga os parâmetros
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Define o valor
        $param_id = trim($_GET["id"]);
        
        // Executa
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Recupera os dados
                $nome = $row["nome"];
                $preco = $row["preco"];
                $imagem = $row["imagem"];
                $quantidade = $row["quantidade"];
            } else{
                // Redireciona em caso de erro
                header("location: error.php");
                exit();
            }
        } else{
            echo "Ops! Algo deu errado. Tente novamente mais tarde.";
        }
    }
     
    // Fecha a consulta
    mysqli_stmt_close($stmt);
    
    // Fecha a conexão
    mysqli_close($link);
} else{
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Produto - Hadio FX</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: 'Oswald', sans-serif;
            margin: 0;
            padding: 0;
        }

        .view-container {
            background-color: #1e1e1e;
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 255, 134, 0.3);
        }

        h1 {
            text-align: center;
            color: #00e676;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            color: #ccc;
            margin-bottom: 5px;
        }

        p {
            font-size: 1.1em;
            color: #fff;
            margin: 0;
        }

        img {
            max-width: 100%;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn-voltar {
            display: inline-block;
            background-color: #00e676;
            color: #111;
            text-decoration: none;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .btn-voltar:hover {
            background-color: #00c853;
        }

        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="view-container">
        <h1>Detalhes do Produto</h1>
        <div class="form-group">
            <label>Nome</label>
            <p><b><?php echo htmlspecialchars($nome); ?></b></p>
        </div>
        <div class="form-group">
            <label>Preço</label>
            <p><b>R$ <?php echo number_format($preco, 2, ',', '.'); ?></b></p>
        </div>
        <div class="form-group">
            <label>Imagem</label>
            <p><img src="<?php echo htmlspecialchars($imagem); ?>" alt="Imagem do Produto"></p>
        </div>
        <div class="form-group">
            <label>Quantidade</label>
            <p><b><?php echo (int)$quantidade; ?></b></p>
        </div>
        <div class="center">
            <a href="index.php" class="btn-voltar">Voltar</a>
        </div>
    </div>
</body>
</html>


