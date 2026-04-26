<?php 
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php");
    exit;
}
require_once 'funcoes.php'; 

$id = $_GET['id'] ?? null;
$pergunta = buscarPergunta($id);

if (!$pergunta) {
    echo "Pergunta não encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Pergunta</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 40px auto; }
        .detalhe { border: 2px solid #007BFF; padding: 20px; border-radius: 8px; }
    </style>
</head>
<body>
    <h2>Detalhes da Pergunta</h2>
    <div class="detalhe">
        <p><strong>ID:</strong> <?php echo $pergunta[0]; ?></p>
        <p><strong>Tipo:</strong> <?php echo $pergunta[1]; ?></p>
        <p><strong>Enunciado:</strong> <?php echo $pergunta[2]; ?></p>
        <?php if($pergunta[1] == "Multipla"): ?>
            <p><strong>Opções:</strong> <?php echo $pergunta[3]; ?></p>
        <?php endif; ?>
        <p><strong>Gabarito Oficial:</strong> <?php echo $pergunta[4]; ?></p>
    </div>
    <br>
    <a href="index.php">Voltar para a Lista</a>
</body>
</html>