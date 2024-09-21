<?php
include 'conexao.php';


$produtos = [];


if (isset($_GET['min-preco']) && isset($_GET['max-preco'])) {
    // Pegando e limpando os valores
    $min_preco = trim($_GET['min-preco']);
    $max_preco = trim($_GET['max-preco']);

    if (is_numeric($min_preco) && is_numeric($max_preco)) {
        $min_preco = (float)$min_preco;
        $max_preco = (float)$max_preco;

        $sql = "SELECT * FROM produtos WHERE preco_venda BETWEEN ? AND ?";
        $stmt = $conn->prepare($sql);

        
        try {
            $stmt->bind_param("dd", $min_preco, $max_preco);
            $stmt->execute();
            $resultado = $stmt->get_result();

            // Verificando se existem produtos
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $produtos[] = $row;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao executar a consulta: " . $e->getMessage();
        }
    } else {
        echo "<h3>Por favor, insira valores numéricos válidos.</h3>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesGlobal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Filtrar por Preço</title>
</head>
<body>

    <nav> 
        <div class="navbar">
            <p class="logo">FranBeBeu</p>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="#">Preço</a></li>
                <li><a href="estoque.php">Estoque</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
                <li><a href="excluir.php">Excluir</a></li>
                <li><a href="atualizar.php">Atualizar</a></li>
                <li><a href="fabricante.php">Fabricante</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <section class="main-container">
            <h1>Filtrar produtos pelo preço</h1>
            <div class="produtos-cadastrados">
                <div class="action">
                    <form action="preço.php" method="GET">
                        <label for="min-preco">Preço Mínimo:</label>
                        <input type="number" name="min-preco" step="0.01" required>
    
                        <label for="max-preco">Preço Máximo:</label>
                        <input type="number" name="max-preco" step="0.01" required>
     
                        <button type="submit">Buscar</button>
                    </form>

                </div>
                <div class="produtos">
                    <?php
                    if (!empty($produtos)) {
                        foreach ($produtos as $produto) {
                            echo "<div class='produto'>"; 
                            echo "<h2>" . htmlspecialchars($produto['nome']) . "</h2>";
                            echo "<p><strong>Código:</strong> " . htmlspecialchars($produto['cod']) . "</p>";
                            echo "<p><strong>Fabricante:</strong> " . htmlspecialchars($produto['fabricante']) . "</p>";
                            echo "<p><strong>Descrição:</strong> " . htmlspecialchars($produto['descricao']) . "</p>";
                            echo "<p><strong>Preço de Custo:</strong> R$ " . number_format($produto['preco_custo'], 2, ',', '.') . "</p>";
                            echo "<p><strong>Preço de Venda:</strong> R$ " . number_format($produto['preco_venda'], 2, ',', '.') . "</p>";
                            echo "<p><strong>Quantidade:</strong> " . $produto['qtd'] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<h3>Nenhum produto encontrado com os preços informados.</h3>";
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

<?php
$conn->close();
?>
</body>
</html>
