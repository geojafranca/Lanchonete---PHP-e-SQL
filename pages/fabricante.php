<?php
include 'conexao.php'; 

$produtos = []; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fabricante'])) {
    $fabricante = trim($_POST['fabricante']);

    
    $sql = "SELECT * FROM produtos WHERE fabricante = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $fabricante);
    $stmt->execute();
    $resultado = $stmt->get_result();

    
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $produtos[] = $row;
        }
    } else {
        $produtos = []; 
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
    <title>Home</title>
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
                <li><a href="excluir.php">Excluir</a></li>
                <li><a href="atualizar.php">Atualizar</a></li>
                <li><a href="#">Fabricante</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <section class="main-container">
            <h1>Buscar produtos por fabricante</h1>
            <div class="produtos-cadastrados">
                <div class="fabri">
                   <form action="fabricante.php" method="POST">
                      <label for="fabricante">Nome do fabricante:</label>
                      <input type="text" name="fabricante" required>
    
                      <button type="submit">Buscar</button>
                   </form>

                       <?php
                       if (!empty($produtos)) {
                           foreach ($produtos as $produto) {
                               echo "<div class='prod-fabri '>";
                               echo "<h2>" . htmlspecialchars($produto['nome']) . "</h2>";
                               echo "<p><strong>Código:</strong> " . htmlspecialchars($produto['cod']) . "</p>";
                               echo "<p><strong>Descrição:</strong> " . htmlspecialchars($produto['descricao']) . "</p>";
                               echo "<p><strong>Preço de Custo:</strong> R$ " . number_format($produto['preco_custo'], 2, ',', '.') . "</p>";
                               echo "<p><strong>Preço de Venda:</strong> R$ " . number_format($produto['preco_venda'], 2, ',', '.') . "</p>";
                               echo "<p><strong>Quantidade:</strong> " . $produto['qtd'] . "</p>";
                               echo "</div>";
                           }
                       } else {
                           echo "<p class='lastp'>Nenhum produto encontrado para o fabricante: </p>";
                       }
                       ?>
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
