<?php

require_once '../include/conexao.php';
require_once '../include/comum.php';
$equipamento = isset($_GET["equipamentos"]) ? $_GET["equipamentos"] : "";
if (!isAdminLevel($NIVEL_OS_EDIT)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    $c = connect();
    $id = addslashes(htmlspecialchars(filter_input(INPUT_POST, "idOrdemServico")));
    $titulo = addslashes(htmlspecialchars(filter_input(INPUT_POST, "titulo")));
    $descricao = addslashes(htmlspecialchars(filter_input(INPUT_POST, "descricao")));
    $prioridade = addslashes(htmlspecialchars(filter_input(INPUT_POST, "prioridade")));
    $status = addslashes(htmlspecialchars(filter_input(INPUT_POST, "status")));
    $secao = addslashes(htmlspecialchars(filter_input(INPUT_POST, "secao")));
    $secao = (empty($secao) || is_null($secao)) ? "NULL" : $secao;
    $responsavel = addslashes(htmlspecialchars(filter_input(INPUT_POST, "responsavel")));
    $idsInventarios = $_POST["inventario"];
    $usuario = is_numeric(addslashes(htmlspecialchars(filter_input(INPUT_POST, "usuario")))) ? addslashes(htmlspecialchars(filter_input(INPUT_POST, "usuario"))) : "NULL";
    $usuario = addslashes(htmlspecialchars(filter_var($usuario, FILTER_VALIDATE_INT))) ? $usuario : "NULL";
    $ordem = is_numeric(addslashes(htmlspecialchars(filter_input(INPUT_POST, "ordem")))) ? addslashes(htmlspecialchars(filter_input(INPUT_POST, "ordem"))) : 0;
    $comeback = addslashes(htmlspecialchars(filter_input(INPUT_GET, "comeback")));

    $sql = "UPDATE OrdemServico "
            . "SET titulo = '$titulo', descricao = '$descricao', Prioridade_idPrioridade = $prioridade, "
            . "Status_idStatus = $status, responsavel = '$responsavel', Usuario_idUsuario = $usuario, ordem = $ordem, "
            . "Secao_idSecao = $secao "
            . " WHERE idOrdemServico = $id";
    $stmt = $c->prepare($sql);
    $stmt->execute();

    for ($i = 0; $i < count($idsInventarios); $i++) {
        $idInventario = filter_var($idsInventarios[$i]);
        $stmt = $c->prepare("INSERT INTO "
                . "OrdemServico_has_Inventario (OrdemServico_idOrdemServico, Inventario_idInventario)"
                . " VALUES (?, ?)");
        $stmt->bind_param("ii", $id, $idInventario);
        $stmt->execute();
    }

    $erro = mysqli_errno($c);
    $c->close();

    if ($comeback == 1) {
        getResult($erro, "view_ordemServico_edit.php?id=$id", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
    } else {
        getResult($erro, "view_ordemServico.php?" . ($equipamento == 1 ? "equipamentos=$equipamento" : "todas"), "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
    }
}