<?php

require_once '../include/conexao.php';
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_OS_ADD)) {       
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    $c = connect();    
    $titulo = addslashes(htmlspecialchars(filter_input(INPUT_POST, "titulo")));
    $descricao = addslashes(htmlspecialchars(filter_input(INPUT_POST, "descricao")));    
    $prioridade = addslashes(htmlspecialchars(filter_input(INPUT_POST, "prioridade")));
    $status = addslashes(htmlspecialchars(filter_input(INPUT_POST, "status")));
    $secao = addslashes(htmlspecialchars(filter_input(INPUT_POST, "secao")));
    $secao = (empty($secao) || is_null($secao)) ? "NULL" : $secao;
    $responsavel = addslashes(htmlspecialchars(filter_input(INPUT_POST, "responsavel")));
    $ordem = addslashes(htmlspecialchars(filter_input(INPUT_POST, "ordem")));
    $ordem = is_numeric($ordem) ? $ordem : 0;
    $sql = "INSERT INTO "
            . "OrdemServico (titulo, descricao, Prioridade_idPrioridade, Status_idStatus, responsavel, ordem, data, Secao_idSecao)"
            . " VALUES ('$titulo', '$descricao', $prioridade, $status, '$responsavel', $ordem, CURRENT_DATE, $secao)";
    $stmt = $c->prepare($sql);    
    $stmt->execute();
    $erro = mysqli_errno($c);    
    $c->close();       
    getResult($erro, "view_ordemServico.php?todas", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
}
?>