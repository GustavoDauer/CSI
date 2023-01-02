<?php

$erroVezes = isset($_COOKIE["erroVezes"]) ? $_COOKIE["erroVezes"] + 1 : 1;

if ($erroVezes > 25) {
    echo "Login bloqueado<br>Ofensa registrada: " . $_SERVER["HTTP_USER_AGENT"] . " " . $_SERVER["REMOTE_ADDR"] . " " . $_SERVER["REMOTE_HOST"] . " " . $_SERVER["REMOTE_USER"] . $_SERVER["PHP_AUTH_USER"] . " " . $_SERVER["HTTP_REFERER"] . "<br>";
    exit;
}

require_once '../include/comum.php';
require_once '../include/conexao.php';

$login = addslashes(htmlspecialchars(filter_input(INPUT_POST, "login")));
$senha = addslashes(htmlspecialchars(md5(filter_input(INPUT_POST, "senha"))));
$c = connect();
$sql = "SELECT idUsuario,login,senha,nivel FROM Usuario WHERE login='$login' AND senha='$senha';";
$result = $c->query($sql);

while ($row = $result->fetch_assoc()) {
    $_SESSION["idUsuario"] = $row["idUsuario"];
    $_SESSION["login"] = $row["login"];
    $_SESSION["nivel"] = $row["nivel"];
    $c->close();
    setcookie("idUsuario", $_SESSION["idUsuario"], time() + (86400 * 1), "/");
    if (strpos($_SERVER["HTTP_REFERER"], 'CSI') !== false) {
        getResult(false, "view_admin.php?estatisticas", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }    
    exit;
}

$c->close();
setcookie("erroVezes", $erroVezes, time() + (86400 * 1), "/");
if (isset($_SESSION["login"]))
    session_destroy();

if (strpos($_SERVER["HTTP_REFERER"], 'CSI') !== false) {
    getResult(true, "view_login.php?erro=$erroVezes", "Aguarde...", "Sucesso!", "Erro!", "Login ou senha não conferem!", 0);
} else {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
?>