<?php

require_once '../include/conexao.php';
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_INVENTARIO_ADD)) {    
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    $c = connect();
    $equipamento = addslashes(htmlspecialchars(filter_input(INPUT_POST, "equipamento")));
    $especificacao = addslashes(htmlspecialchars(filter_input(INPUT_POST, "especificacao")));
    $quantidade = addslashes(htmlspecialchars(filter_input(INPUT_POST, "quantidade")));
    $sql = "INSERT INTO "
            . "Inventario (equipamento, especificacao, quantidade, data)"
            . " VALUES ('$equipamento','$especificacao',$quantidade, CURRENT_DATE)";
    $stmt = $c->prepare($sql);        
    $stmt->execute();
    $erro = mysqli_errno($c);
    $c->close();    
    getResult($erro, "view_inventario.php", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
}
?>