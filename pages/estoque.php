<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
include 'conexao.php';

// Consulta para obter os produtos com estoque zerado
$sql = "SELECT * FROM produtos WHERE qtd = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesGlobal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Estoque</title>
</head>
<body>

    <nav> 
        <div class="navbar">
            <p class="logo">FranBeBeu</p>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="preço.php">Preço</a></li>
                <li><a href="#">Estoque</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
                <li><a href="excluir.php">Excluir</a></li>
                <li><a href="atualizar.php">Atualizar</a></li>
                <li><a href="fabricante.php">Fabricante</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <section class="main-container">
            <h1>Consultar Estoque</h1>
            <div class="produtos-cadastrados">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="produtos">
                                <h2><?php echo htmlspecialchars($row['nome']); ?></h2>
                                <p><strong>Fabricante:</strong> <?php echo htmlspecialchars($row['fabricante']); ?></p>
                                <p><strong>Descrição:</strong> <?php echo htmlspecialchars($row['descricao']); ?></p>
                                <p><strong>Código:</strong> <?php echo htmlspecialchars($row['cod']); ?></p>
                                <p><strong>Preço de Custo:</strong> R$ <?php echo number_format($row['preco_custo'], 2, ',', '.'); ?></p>
                                <p><strong>Preço de Venda:</strong> R$ <?php echo number_format($row['preco_venda'], 2, ',', '.'); ?></p>
                                <p><strong>Quantidade em Estoque:</strong> <?php echo htmlspecialchars($row['qtd']); ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Nenhum produto com estoque zerado encontrado.</p>
                    <?php endif; ?>
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

<?php
// Fecha a conexão
$conn->close();
?>
