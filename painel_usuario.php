<?php 
session_start();

if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo_usuario'] != 'comum') {
    header("Location: login.php");
    exit;
}
require_once 'funcoes.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área de Respostas</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; line-height: 1.6; }
        .bloco { border: 1px solid #ccc; padding: 15px; margin: 10px 0; background: #fff; border-radius: 5px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1); }
        hr { margin: 20px 0; }
        
        summary { 
            cursor: pointer; 
            color: #fff; 
            background: #007BFF; 
            padding: 8px 12px; 
            border-radius: 4px; 
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
            outline: none;
        }
        summary:hover { background: #0056b3; }
        .gabarito-texto { margin-top: 10px; padding: 10px; background: #eef; border-left: 4px solid #007BFF; }
    </style>
</head>
<body style="background-color: #f4f4f9;">

    <h2>Painel do Aluno / Usuário</h2>
    <p>Bem-vindo(a), <strong><?php echo $_SESSION['usuario_logado']; ?></strong> | <a href="saida.php">Sair do sistema</a></p>

    <hr>

    <h3>Perguntas Disponíveis</h3>
    <?php 
    $lista = listarPerguntas();
    if (empty($lista)) {
        echo "<p>Nenhuma pergunta foi disponibilizada pelo administrador ainda.</p>";
    }
    
    foreach ($lista as $item): 
        $col = explode(" | ", $item); 
    ?>
        <div class="bloco">
            <strong><?php echo $col[2]; ?></strong> <br>
            
            <?php if ($col[1] == "Multipla" && !empty($col[3])): ?>
                <ul style="margin-top: 5px;">
                    <?php 
                    $opcoes = explode(";", $col[3]);
                    foreach($opcoes as $opcao) {
                        echo "<li>" . trim($opcao) . "</li>";
                    }
                    ?>
                </ul>
            <?php else: ?>
                <br>
            <?php endif; ?>

            <details>
                <summary>Mostrar Gabarito</summary>
                <div class="gabarito-texto">
                    <strong>Resposta Correta:</strong> <?php echo $col[4]; ?>
                </div>
            </details>
        </div>
    <?php endforeach; ?>

</body>
</html>