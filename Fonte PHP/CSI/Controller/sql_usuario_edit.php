<?php

require_once '../include/conexao.php';
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_USUARIO_EDIT)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    $c = connect();
    $id = addslashes(htmlspecialchars(filter_input(INPUT_POST, "idUsuario")));
    $login = addslashes(htmlspecialchars(filter_input(INPUT_POST, "login")));
    $senha = addslashes(htmlspecialchars(filter_input(INPUT_POST, "senha")));
    $nivel = addslashes(htmlspecialchars(filter_input(INPUT_POST, "nivel")));
    $nome = addslashes(htmlspecialchars(filter_input(INPUT_POST, "nome")));

    $sql = "UPDATE Usuario SET login = '$login', ";
    
    if (!empty($senha)) {
        $sql .= "senha = '" . md5($senha) . "', ";
    }

    $sql .= "nivel = $nivel, nome = '$nome' WHERE idUsuario = $id";

    $stmt = $c->prepare($sql);        
    $stmt->execute();    
    $erro = mysqli_errno($c);
    $c->close();    
    getResult($erro, "view_usuario.php?admin", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
}
?>