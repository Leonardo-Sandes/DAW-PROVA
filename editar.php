<?php 
session_start();
if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo_usuario'] != 'admin') {
    header("Location: login.php");
    exit;
}
require_once 'funcoes.php'; 

$id = $_GET['id'];
$pergunta_data = buscarPergunta($id);

if (!$pergunta_data) {
    echo "Pergunta não encontrada! <a href='index.php'>Voltar</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    alterarPergunta($id, $_POST['tipo'], $_POST['pergunta'], $_POST['opcoes'], $_POST['gabarito']);
    header("Location: index.php");
    exit;
}

$tipo_atual = $pergunta_data[1];
$texto_pergunta = $pergunta_data[2];
$opcoes = trim($pergunta_data[3]);
$gabarito = trim($pergunta_data[4]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Pergunta</title>
</head>
<body style="text-align: center; font-family: sans-serif; max-width: 600px; margin: 40px auto;">
    <h2>Editar Pergunta (ID: <?php echo $id; ?>)</h2>
    
    <form method="POST">
        <label>Pergunta:</label><br>
        <input type="text" name="pergunta" value="<?php echo $texto_pergunta; ?>" required><br><br>

        <label>Tipo:</label><br>
        <select name="tipo">
            <option value="Texto" <?php if($tipo_atual == 'Texto') echo 'selected'; ?>>Resposta de Texto</option>
            <option value="Multipla" <?php if($tipo_atual == 'Multipla') echo 'selected'; ?>>Múltipla Escolha</option>
        </select><br><br>

        <label>Opções (separadas por ; ):</label><br>
        <input type="text" name="opcoes" value="<?php echo $opcoes; ?>"><br><br>

        <label>Gabarito:</label><br>
        <input type="text" name="gabarito" value="<?php echo $gabarito; ?>" required><br><br>

        <button type="submit">Salvar Alterações</button>
        <a href="index.php">Cancelar</a>
    </form>

</body>
</html>