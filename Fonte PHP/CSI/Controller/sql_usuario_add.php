<?php

require_once '../include/conexao.php';
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_USUARIO_ADD)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    $c = connect();
    $stmt = $c->prepare("INSERT INTO "
            . "Usuario (login, senha, nivel, nome)"
            . " VALUES (?, ?, ?, ?)");
    $login = addslashes(htmlspecialchars(filter_input(INPUT_POST, "login")));
    $senha = addslashes(htmlspecialchars(filter_input(INPUT_POST, "senha")));
    $nivel = addslashes(htmlspecialchars(filter_input(INPUT_POST, "nivel")));
    $nome = addslashes(htmlspecialchars(filter_input(INPUT_POST, "nome")));
    $stmt->bind_param("ssis", $login, md5($senha), $nivel, $nome);
    $stmt->execute();
    $erro = mysqli_errno($c);
    $c->close();    
    getResult($erro, "view_usuario.php?admin", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
}
?>