<?php require_once '../include/comum.php'; ?>
<?php require_once '../include/conexao.php'; ?>
<?php

session_destroy();
getResult(false, "view_login.php", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
?>