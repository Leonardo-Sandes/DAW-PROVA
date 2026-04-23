<?php 
session_start();
require_once 'funcoes.php'; 

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btn_cadastrar'])) {
       
        cadastrarUsuario($_POST['nome'], $_POST['login'], $_POST['senha'], $_POST['tipo']);
        $mensagem = "Usuário cadastrado com sucesso! Faça o login.";
    }
    
    if (isset($_POST['btn_login'])) {
        if (realizarLogin($_POST['login'], $_POST['senha'])) {
            if ($_SESSION['tipo_usuario'] == 'admin') {
                header("Location: index.php"); 
            } else {
                header("Location: painel_usuario.php"); 
            }
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
    <title>Login - Sistema</title>
    <style>
        body { font-family: sans-serif; }
        .container { display: flex; gap: 50px; justify-content: center; margin-top: 50px; }
        .caixa { border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 300px; background: #f9f9f9; }
        .erro { color: red; text-align: center; }
        input, select, button { width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
    </style>
</head>
<body>

    <h2 style="text-align:center;">Acesso ao Sistema</h2>
    <?php if($mensagem) echo "<p class='erro'>$mensagem</p>"; ?>

    <div class="container">
        <div class="caixa">
            <h3>Login</h3>
            <form method="POST">
                <input type="text" name="login" placeholder="Login" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit" name="btn_login">Entrar</button>
            </form>
        </div>

        <div class="caixa">
            <h3>Novo Usuário</h3>
            <form method="POST">
                <input type="text" name="nome" placeholder="Seu Nome" required>
                <input type="text" name="login" placeholder="Crie um Login" required>
                <input type="password" name="senha" placeholder="Crie uma Senha" required>
                
                <label>Tipo de Conta:</label>
                <select name="tipo" required>
                    <option value="comum">Usuário Comum </option>
                    <option value="admin">Administrador</option>
                </select>

                <button type="submit" name="btn_cadastrar">Cadastrar</button>
            </form>
        </div>
    </div>

</body>
</html>
