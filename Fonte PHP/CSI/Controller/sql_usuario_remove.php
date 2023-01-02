<?php

require_once '../include/conexao.php';
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_USUARIO_REMOVE)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    $c = connect();
    $id = addslashes(htmlspecialchars(filter_input(INPUT_GET, "id")));
    $stmt = $c->prepare("DELETE FROM Usuario WHERE idUsuario = $id");
    $stmt->execute();
    $erro = mysqli_errno($c);
    $c->close();    
    getResult($erro, "view_usuario.php?admin", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
}
?>