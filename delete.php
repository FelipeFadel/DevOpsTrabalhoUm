<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM produtos WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Record deleted successfully. Redirect to index
            header("location: index.php");
            exit();
        } else {
            echo "Algo deu errado. Por favor, tente novamente mais tarde.";
        }
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else {
    // Verifica existência do ID via GET
    if(empty(trim($_GET["id"]))){
        // Sem ID válido, redireciona para erro
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Excluir Produto - Hadio FX</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: 'Oswald', sans-serif;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            background-color: #1e1e1e;
            width: 600px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 64, 64, 0.3);
        }

        h2 {
            text-align: center;
            color: #ff5252;
            margin-bottom: 20px;
        }

        .alert {
            background-color: #2b2b2b;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ff1744;
            text-align: center;
        }

        .alert p {
            color: #ccc;
        }

        .btn {
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }

        .btn-danger {
            background-color: #ff5252;
            color: #111;
        }

        .btn-danger:hover {
            background-color: #ff1744;
        }

        .btn-secondary {
            background-color: #444;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <h2>Excluir Produto</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="alert">
                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                <p>Tem certeza que deseja excluir este produto?</p>
                <p>
                    <input type="submit" value="Sim" class="btn btn-danger">
                    <a href="index.php" class="btn btn-secondary">Não</a>
                </p>
            </div>
        </form>
    </div>
</div>
</body>
</html>


