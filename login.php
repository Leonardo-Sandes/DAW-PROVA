<?php 
session_start();
require_once 'funcoes.php'; 

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btn_cadastrar'])) {
        cadastrarUsuario($_POST['nome'], $_POST['login'], $_POST['senha']);
        $mensagem = "Usuário cadastrado com sucesso! Faça o login.";
    }
    
    if (isset($_POST['btn_login'])) {
        if (realizarLogin($_POST['login'], $_POST['senha'])) {
            header("Location: index.php"); 
            exit;
        } else {
            $mensagem = "Login ou senha incorretos!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistema de Perguntas</title>
    <style>
        .container { display: flex; gap: 50px; justify-content: center; margin-top: 50px; }
        .caixa { border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 300px; }
        .erro { color: red; text-align: center; }
    </style>
</head>
<body>

    <h2 style="text-align:center;">Acesso ao Sistema</h2>
    <?php if($mensagem) echo "<p class='erro'>$mensagem</p>"; ?>

    <div class="container">
        <div class="caixa">
            <h3>Login</h3>
            <form method="POST">
                <input type="text" name="login" placeholder="Login" required><br><br>
                <input type="password" name="senha" placeholder="Senha" required><br><br>
                <button type="submit" name="btn_login">Entrar</button>
            </form>
        </div>

        <div class="caixa">
            <h3>Novo Usuário</h3>
            <form method="POST">
                <input type="text" name="nome" placeholder="Seu Nome" required><br><br>
                <input type="text" name="login" placeholder="Crie um Login" required><br><br>
                <input type="password" name="senha" placeholder="Crie uma Senha" required><br><br>
                <button type="submit" name="btn_cadastrar">Cadastrar</button>
            </form>
        </div>
    </div>

</body>
</html>