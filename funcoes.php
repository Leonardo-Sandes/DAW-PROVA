<?php
$caminho_txt = 'perguntas.txt';

function listarPerguntas() {
    global $caminho_txt;
    if (!file_exists($caminho_txt)) return [];
    return file($caminho_txt, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function cadastrarPergunta($tipo, $pergunta, $opcoes, $gabarito) {
    global $caminho_txt;
    $id = time(); 
    
    $pergunta = str_replace("|", "-", $pergunta); 
    $gabarito = str_replace("|", "-", $gabarito);

    
    $linha = "$id | $tipo | $pergunta | $opcoes | $gabarito" . PHP_EOL;
    
    return file_put_contents($caminho_txt, $linha, FILE_APPEND);
}

function excluirPergunta($id_excluir) {
    global $caminho_txt;
    $linhas = listarPerguntas();
    $novas_linhas = "";
    foreach ($linhas as $linha) {
        $dados = explode(" | ", $linha);
        if ($dados[0] != $id_excluir) {
            $novas_linhas .= $linha . PHP_EOL;
        }
    }
    file_put_contents($caminho_txt, $novas_linhas);
}


$arquivo_usuarios = 'usuarios.txt';

function cadastrarUsuario($nome, $login, $senha) {
    global $arquivo_usuarios;
    $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);
    $linha = "$nome | $login | $senha_cripto" . PHP_EOL;
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