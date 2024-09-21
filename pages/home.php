<?php

include 'conexao.php';


$sql = "SELECT * FROM produtos";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
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
                <li><a href="#">Home</a></li>
                <li><a href="preço.php">Preço</a></li>
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
            <h1>Produtos cadastrados</h1>
            <div class="produtos-cadastrados">
                <?php
               
                if ($resultado->num_rows > 0) {
                  
                    while ($row = $resultado->fetch_assoc()) {
                        echo "<div class='produtos'>";
                        echo "<h2>" . htmlspecialchars($row['nome']) . "</h2>";
                        echo "<p><strong>Código:</strong> " . htmlspecialchars($row['cod']) . "</p>";
                        echo "<p><strong>Fabricante:</strong> " . htmlspecialchars($row['fabricante']) . "</p>";
                        echo "<p><strong>Descrição:</strong> " . htmlspecialchars($row['descricao']) . "</p>";
                        echo "<p><strong>Preço de Custo:</strong> R$ " . number_format($row['preco_custo'], 2, ',', '.') . "</p>";
                        echo "<p><strong>Preço de Venda:</strong> R$ " . number_format($row['preco_venda'], 2, ',', '.') . "</p>";
                        echo "<p><strong>Quantidade:</strong> " . $row['qtd'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    
                    echo "<h2> Nenhum produto cadastrado.</h2>";
                }
                ?>
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

<?php

$conn->close();
?>
