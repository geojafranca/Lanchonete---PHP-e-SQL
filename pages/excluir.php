<?php
include 'conexao.php'; // Inclui a conexão com o banco de dados

// Verifica se o formulário foi enviado e se o código foi fornecido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod'])) {
    $cod = trim($_POST['cod']);

    // Prepara a consulta SQL para excluir o produto pelo código
    $sql = "DELETE FROM produtos WHERE cod = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cod);
    
    if ($stmt->execute()) {
        $mensagem = "Produto com código " . htmlspecialchars($cod) . " foi excluído com sucesso!";
    } else {
        $mensagem = "Erro ao excluir o produto com código " . htmlspecialchars($cod) . ".";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesGlobal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Excluir Produto</title>
</head>
<body>

    <nav> 
        <div class="navbar">
            <p class="logo">FranBeBeu</p>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="preço.php">Preço</a></li>
                <li><a href="estoque.php">Estoque</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
                <li><a href="#">Excluir</a></li>
                <li><a href="atualizar.php">Atualizar</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <section class="main-container">
            <h1>Excluir Produto</h1>
            <div class="produtos-cadastrados">
                <div class="fabri">
                   <form action="" method="POST">
                      <label for="cod">Código do produto:</label>
                      <input type="text" name="cod" required>
    
                      <button type="submit">Excluir</button>
                   </form>

                   <div class="mensagem">
                       <?php
                       if (isset($mensagem)) {
                           echo "<p>" . $mensagem . "</p>";
                       }
                       ?>
                   </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>Contato: (xx) 9999-9999 | Endereço: Rua dos trabalhos de programação, 123 - Arraial do Cabo, RJ</p>
        </div>
    </footer>
</body>
</html>
