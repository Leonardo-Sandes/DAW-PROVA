<?php
session_start();
$arquivo_usuarios = 'usuarios.txt';

function cadastrarUsuario($nome, $login, $senha) {
    global $arquivo_usuarios;
   
    $linha = "$nome | $login | $senha" . PHP_EOL;
    file_put_contents($arquivo_usuarios, $linha, FILE_APPEND);
}

function realizarLogin($login, $senha) {
    global $arquivo_usuarios;
    if (!file_exists($arquivo_usuarios)) return false;

    $usuarios = file($arquivo_usuarios, FILE_IGNORE_NEW_LINES);
    foreach ($usuarios as $linha) {
        $dados = explode(" | ", $linha);
        if ($dados[1] == $login && password_verify($senha, $dados[2])) {
            $_SESSION['usuario_logado'] = $dados[0]; 
            return true;
        }
    }
    return false;
}
?>