<?php
include 'conexao.php'; // Inclui a conexão com o banco de dados

$msg = ""; // Mensagem inicial vazia

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod = $_POST['cod'];
    $descricao = $_POST['descricao'];
    $fabricante = $_POST['fabricante'];
    $qtd = $_POST['qtd'];
    $preco_custo = $_POST['preco_custo'];
    $preco_venda = $_POST['preco_venda'];
    $nome = $_POST['nome']; // Campo para nome

    // Verifica se o código do produto está vazio
    if (empty($cod)) {
        $msg = "Código do produto não pode ser vazio.";
    } else {
        $sql = "UPDATE produtos SET descricao = ?, fabricante = ?, qtd = ?, preco_custo = ?, preco_venda = ?, nome = ? WHERE cod = ?"; // Inclui o campo nome
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiddsi", $descricao, $fabricante, $qtd, $preco_custo, $preco_venda, $nome, $cod); // Adiciona o parâmetro do nome

        if ($stmt->execute()) {
            $msg = "Produto atualizado com sucesso!";
        } else {
            $msg = "Erro ao atualizar o produto. Código: " . htmlspecialchars($cod);
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesCadProduto.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Atualizar Produto</title>
</head>
<body>
    <div class="main-cad">
        <div class="left-cad">
            <h1>FranBeBeu Produtos</h1>
            <img src="../assets/product-quality-animate2.svg" alt="Imagem Cadastro">
        </div>

        <div class="right-cad">
            <div class="card-cad">
                <h1><?php echo htmlspecialchars($msg); ?></h1> <!-- Mensagem de confirmação -->
                <form action="atualizar.php" method="POST">
                     <label for="cod">Código do Produto:</label>
                     <input type="number" name="cod" required>

                     <label for="nome">Nome do Produto</label> <!-- Novo campo para nome -->
                     <input type="text" name="nome" required>

                     <label for="descricao">Nova Descrição</label>
                     <input type="text" name="descricao" required>

                     <label for="fabricante">Novo Fabricante</label>
                     <input type="text" name="fabricante" required>

                     <label for="qtd">Nova Quantidade</label>
                     <input type="number" name="qtd" required>

                     <label for="preco_custo">Novo Preço de Custo</label>
                     <input type="number" name="preco_custo" step="0.01" required>

                     <label for="preco_venda">Novo Preço de Venda</label>
                     <input type="number" name="preco_venda" step="0.01" required>

                     <button type="submit" class="btn-cad">Atualizar</button>
                </form>
                <br>
                <span><a href="home.php">Voltar</a></span>
            </div>
        </div>
    </div>
</body>
</html>
