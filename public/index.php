<?php
session_start();

// JSON dos produtos (em PHP)
$produtosJson = '[
    {
        "id": 1,
        "nome": "Curso PC/Desktop",
        "preco": 59.99,
        "imagem": ""
    },
    {
        "id": 2,
        "nome": "Curso de PHP",
        "preco": 70.00,
        "imagem": ""
    },
    {
        "id": 3,
        "nome": "Curso de Blender",
        "preco": 45.00,
        "imagem": ""
    }
]';

// Decodifica o JSON em um array associativo
$produtos = json_decode($produtosJson, true);

// Inicializa o carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adiciona um produto ao carrinho
if (isset($_POST['comprar'])) {
    $id = $_POST['comprar'];
    $produto = array_filter($produtos, fn($p) => $p['id'] == $id);
    if ($produto) {
        $_SESSION['carrinho'][] = reset($produto);
    }
}

// Remove um produto do carrinho
if (isset($_POST['remover'])) {
    $id = $_POST['remover'];
    $_SESSION['carrinho'] = array_filter($_SESSION['carrinho'], fn($item) => $item['id'] != $id);
}

// Finaliza a compra
if (isset($_POST['finalizar_compra'])) {
    // Aqui você pode adicionar a lógica para processar a compra
    // Por exemplo, limpar o carrinho após a compra
    $_SESSION['carrinho'] = [];
    echo "<p class='alert alert-success'>Compra finalizada com sucesso!</p>";
}

// Exibe o carrinho
function exibirCarrinho() {
    if (empty($_SESSION['carrinho'])) {
        echo "<p>O carrinho está vazio.</p>";
        return;
    }

    echo "<h2>Carrinho de Compras</h2>";
    foreach ($_SESSION['carrinho'] as $item) {
        echo "<div class='mb-3'>
                <h5>{$item['nome']}</h5>
                <p>Preço: R$ " . number_format($item['preco'], 2, ',', '.') . "</p>
                <form action='' method='POST'>
                    <button class='btn btn-danger' name='remover' value='{$item['id']}'>Remover</button>
                </form>
              </div>";
    }
    echo "<p>Total: R$ " . number_format(array_sum(array_column($_SESSION['carrinho'], 'preco')), 2, ',', '.') . "</p>";
    
    // Mostrar botão de compra apenas se houver produtos no carrinho
    echo "<form action='gerar_pix.php' method='GET'>
        <input type='hidden' name='valor' value='" . number_format(array_sum(array_column($_SESSION['carrinho'], 'preco')), 2, '.', '') . "'>
        <button class='btn btn-comprar'>Comprar</button>
      </form>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Loja</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-comprar {
            padding: 15px 120px;
            border: none;
            border-radius: 10px;
            background-color: black;
            color: white;
            transition: 0.5s;
        }
        .btn-comprar:hover {
            transition: 0.5s;
            background-color: darkblue;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <header class="bg-dark text-white p-4">
    <div class="container">
        <h1 class="text-center">Mini Loja</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                        <a class="nav-link" href="#">home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contato</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8">
                <h2>Bem-vindo à Mini Loja</h2>
                <div class="row">
                    <?php foreach ($produtos as $produto): ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img src="<?php echo $produto['imagem']; ?>" class="card-img-top" alt="<?php echo $produto['nome']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                                    <p class="card-text">Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                                    <form action="" method="POST">
                                        <button class="btn btn-success" name="comprar" value="<?php echo $produto['id']; ?>">Comprar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <?php exibirCarrinho(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-dark text-white text-center p-4 mt-5">
        <div class="container">
            <p>Contato: email@example.com | Telefone: (11) 1234-5678</p>
            <p>Redes Sociais: 
                <a href="#" class="text-white">Facebook</a> | 
                <a href="#" class="text-white">Instagram</a>
            </p>
            <p>&copy; 2024 Mini Loja. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
