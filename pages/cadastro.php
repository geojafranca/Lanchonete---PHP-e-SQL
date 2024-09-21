<?php
session_start(); // Inicia a sessão

// Inclui o arquivo de conexão com o banco de dados
include 'conexao.php';

// Variável para armazenar a mensagem de confirmação
$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta os dados do formulário
    $cod = $_POST['cod'];
    $fabricante = $_POST['fabricante'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco_custo = $_POST['preco_custo'];
    $preco_venda = $_POST['preco_venda'];
    $qtd = $_POST['qtd'];

    // Verifica se o código do produto já existe
    $verifica_sql = "SELECT * FROM produtos WHERE cod = '$cod'";
    $result = $conn->query($verifica_sql);

    if ($result->num_rows > 0) {
        $mensagem = "Erro: O código do produto já existe.";
    } else {
        // Cria a query de inserção
        $sql = "INSERT INTO produtos (cod, fabricante, nome, descricao, preco_custo, preco_venda, qtd) 
                VALUES ('$cod', '$fabricante', '$nome', '$descricao', $preco_custo, $preco_venda, $qtd)";

        // Executa a query e verifica o resultado
        if ($conn->query($sql) === TRUE) {
            $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
            header("Location: cadastro.php"); // Redireciona para a mesma página
            exit();
        } else {
            $mensagem = "Erro ao cadastrar produto: " . $conn->error;
        }
    }

    // Fecha a conexão
    $conn->close();
}

// Se houver uma mensagem de sucesso armazenada na sessão, exiba-a
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Remove a mensagem após exibi-la
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesCadProduto.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Cadastro</title>
</head>
<body>
    <div class="main-cad">
        <div class="left-cad">
            <h1>
                FranBeBeu Produtos 
                <?php if (!empty($mensagem)): ?>
                    <br><span style='color: green;'><?php echo htmlspecialchars($mensagem); ?></span>
                <?php endif; ?>
            </h1>
            <img src="../assets/product-quality-animate.svg" alt="Imagem Cadastro">
        </div>

        <div class="right-cad">
            <div class="card-cad">
                <h1>Cadastre seu produto</h1>
                <form action="cadastro.php" method="POST">

                    <label for="cod">Código do Produto:</label>
                    <input type="number" name="cod" required>

                    <label for="fabricante">Fabricante</label>
                    <input type="text" name="fabricante" placeholder="Nome do fabricante | EX.: Carlos Augusto" required>

                    <label for="nome">Nome</label>
                    <input type="text" name="nome" placeholder="Nome do seu produto | EX.: Bicicleta" required>    
    
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" placeholder="Descrição do seu produto | EX.: Cor vermelha, rodas grandes, etc." required>

                    <label for="preco_custo">Preço de Custo</label>
                    <input type="number" name="preco_custo" step="0.01" placeholder="Preço de Custo | EX.: 300R$" required>

                    <label for="preco_venda">Preço de Venda</label>
                    <input type="number" name="preco_venda" step="0.01" placeholder="Preço de Venda | EX.: 600R$" required>

                    <label for="qtd">Quantidade</label>
                    <input type="number" name="qtd" placeholder="Quantidade | EX.: 10" required>

                    <button type="submit" class="btn-cad">Cadastrar</button>
                </form>
                <br>
                <span><a href="home.php">Voltar</a></span>
            </div>
        </div>
    </div>
</body>
</html>
