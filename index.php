<?php 
session_start();
if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo_usuario'] != 'admin') {
    header("Location: login.php");
    exit;
}
require_once 'funcoes.php'; 


$mensagem_sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btn_salvar'])) {
        $salvou = cadastrarPergunta($_POST['tipo'], $_POST['pergunta'], $_POST['opcoes'], $_POST['gabarito']);
        
        if ($salvou) {
            $mensagem_sucesso = "Sucesso: A pergunta '<strong>" . $_POST['pergunta'] . "</strong>' foi salva!";
        }
    }
    if (isset($_POST['btn_excluir'])) {
        excluirPergunta($_POST['id']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Perguntas</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; line-height: 1.6; }
        .bloco { border: 1px solid #000; padding: 10px; margin: 10px 0; background: #f9f9f9; }
        .alerta { color: green; font-weight: bold; margin-bottom: 15px; }
        hr { margin: 20px 0; }
        label { display: block; margin-top: 10px; }
    </style>
</head>
<body>

    <h2>Sistema de Perguntas e Respostas</h2>
    <p>Usuário logado: <strong><?php echo $_SESSION['usuario_logado']; ?></strong> | <a href="saida.php">sair</a></p>

    <?php if ($mensagem_sucesso): ?>
        <p class="alerta"><?php echo $mensagem_sucesso; ?></p>
    <?php endif; ?>

    <div class="bloco">
        <h3>Cadastrar nova pergunta</h3>
        <form method="POST">
            <label>Pergunta:</label>
            <input type="text" name="pergunta" required style="width: 300px;">

            <label>Tipo:</label>
            <select name="tipo">
                <option value="Texto">Resposta de Texto</option>
                <option value="Multipla">Múltipla Escolha</option>
            </select>

            <label>Opções (se for Múltipla, separe por ; ):</label>
            <input type="text" name="opcoes" placeholder="Ex: Sim;Não;Talvez" style="width: 300px;">

            <label>Gabarito (Resposta Correta):</label>
            <input type="text" name="gabarito" required style="width: 300px;"><br><br>

            <button type="submit" name="btn_salvar">Salvar no txt</button>
        </form>
    </div>

    <hr>

    <h2>Todas as perguntas cadastradas</h2>
    <?php 
    $lista = listarPerguntas();
    if (empty($lista)) echo "<p>Nenhuma pergunta cadastrada.</p>";
    
    foreach ($lista as $item): 
        $col = explode(" | ", $item); 
    ?>
        <div class="bloco">
            <strong>ID:</strong> <?php echo $col[0]; ?> | 
            <strong>Tipo:</strong> <?php echo $col[1]; ?><br>
            <strong>Pergunta:</strong> <?php echo $col[2]; ?><br>
            
            <?php if ($col[1] == "Multipla" && !empty($col[3])): ?>
                <strong>Opções:</strong> <?php echo str_replace(";", " - ", $col[3]); ?><br>
            <?php endif; ?>

            <strong>Gabarito:</strong> <?php echo $col[4]; ?><br>

            <form method="POST" style="margin-top: 10px;">
                <input type="hidden" name="id" value="<?php echo $col[0]; ?>">
                <button type="submit" name="btn_excluir" style="color: red;">Excluir</button>
            </form>
        </div>
    <?php endforeach; ?>

</body>
</html>
