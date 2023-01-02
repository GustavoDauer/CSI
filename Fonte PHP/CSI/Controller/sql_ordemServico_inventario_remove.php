<?php

require_once '../include/conexao.php';
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_OS_INVENTARIO_EDIT)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    $c = connect();
    $id = addslashes(htmlspecialchars(filter_input(INPUT_GET, "id")));
    $idOs = addslashes(htmlspecialchars(filter_input(INPUT_GET, "idOs")));
    $stmt = $c->prepare("DELETE FROM OrdemServico_has_Inventario WHERE id = $id");
    $stmt->execute();
    $erro = mysqli_errno($c);
    $c->close();    
    getResult($erro, "view_ordemServico_edit.php?id=$idOs", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
}
?>