<?php

require_once '../include/conexao.php';
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_INVENTARIO_EDIT)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    $c = connect();
    $id = addslashes(htmlspecialchars(filter_input(INPUT_POST, "idInventario")));
    $equipamento = addslashes(htmlspecialchars(filter_input(INPUT_POST, "equipamento")));
    $especificacao = addslashes(htmlspecialchars(filter_input(INPUT_POST, "especificacao")));
    $quantidade = addslashes(htmlspecialchars(filter_input(INPUT_POST, "quantidade")));
    $stmt = $c->prepare("UPDATE Inventario "
            . "SET equipamento = ?, especificacao = ?, quantidade = ?"
            . " WHERE idInventario = $id");
    $stmt->bind_param("ssi", $equipamento, $especificacao, $quantidade);
    $stmt->execute();
    $erro = mysqli_errno($c);
    $c->close();
    getResult($erro, "view_inventario.php", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
}
?>