<?php
session_start();

// Verifica se o valor foi passado
if (!isset($_GET['valor'])) {
    echo "Valor não especificado.";
    exit;
}

$valor = $_GET['valor'];

// Aqui você pode gerar um link de pagamento.
// Este é um exemplo fictício. Substitua pela URL da sua plataforma de pagamento.
$valorFormatado = number_format($valor, 2, '.', ''); // Formato para a plataforma de pagamento
$linkPagamento = "https://www.plataformadepagamento.com/pagar?valor={$valorFormatado}"; // Exemplo de link de pagamento

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Pagamento</h2>
        <p>Para finalizar sua compra, clique no link abaixo:</p>
        <a href="<?php echo $linkPagamento; ?>" class="btn btn-primary" target="_blank">Pagar R$ <?php echo $valorFormatado; ?></a>
        <p>Após o pagamento, você será redirecionado para a página de confirmação.</p>
    </div>
    
    <!-- Bootstrap JS (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
