<?php

require_once '../include/conexao.php';
require_once '../include/comum.php';
$equipamento = isset($_GET["equipamentos"]) ? $_GET["equipamentos"] : "";
if (!isAdminLevel($NIVEL_OS_EDIT)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    $c = connect();
    $id = addslashes(htmlspecialchars(filter_input(INPUT_GET, "id")));
    $ordem = addslashes(htmlspecialchars(filter_input(INPUT_GET, "ordem")));
    $ordem = is_numeric($ordem) ? $ordem : 0;
    $comeback = addslashes(htmlspecialchars(filter_input(INPUT_GET, "comeback")));

    $sql = "UPDATE OrdemServico "
            . "SET ordem = $ordem "
            . " WHERE idOrdemServico = $id";
    $stmt = $c->prepare($sql);
    $stmt->execute();

    $erro = mysqli_errno($c);
    $c->close();       
    getResult($erro, "view_ordemServico.php?" . ($equipamento == 1 ? "equipamentos=$equipamento" : "todas") . "#$id", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
}
?>