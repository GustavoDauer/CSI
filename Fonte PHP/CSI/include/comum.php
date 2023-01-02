<?php
header('Content-Type: text/html; charset=utf-8');

$SOFTWARE = "CSI";
$VERSAO = 99.29;

$NIVEL_USUARIO_LIST = 10;
$NIVEL_USUARIO_ADD = 10;
$NIVEL_USUARIO_EDIT = 10;
$NIVEL_USUARIO_REMOVE = 10;

$NIVEL_OS_LIST = 1;
$NIVEL_OS_ADD = 1;
$NIVEL_OS_EDIT = 7;
$NIVEL_OS_INVENTARIO_EDIT = 8;
$NIVEL_SOLICITACAOEQUIPAMENTO_LIST = 1;

$NIVEL_INVENTARIO_LIST = 1;
$NIVEL_INVENTARIO_ADD = 7;
$NIVEL_INVENTARIO_EDIT = 8;

$NIVEL_HOST_LIST = 1;
$NIVEL_HOST_DHCP_LIST = 7;
$NIVEL_HOST_EDIT = 1;

$NIVEL_EQUIPAMENTO_LIST = 1;
$NIVEL_EQUIPAMENTO_ADD = 1;
$NIVEL_EQUIPAMENTO_EDIT = 1;
$NIVEL_EQUIPAMENTO_REMOVE = 10;

$NIVEL_INTERNET_LIST = 1;

$NIVEL_ESTATISTICAS = 1;

if (!(session_id())) {
    session_start();
}

if (isset($_SESSION["login"])) {
    $cookieLogin = $_SESSION["login"];
}

function isLoggedIn() {
    if (isset($_SESSION["login"])) {
        $login = $_SESSION["login"];

        if (!empty($login)) {
            return true;
        }
    }

    return false;
}

function isAdminLevel($NIVEL_ADMIN) {
    if (isset($_SESSION["nivel"])) {
        return $_SESSION["nivel"] >= $NIVEL_ADMIN;
    }
    return false;
}

function getResult($erro, $url, $aguarde, $sucesso, $problema, $mensagemErro, $tempo) {
    if ($erro == false) {
        ?>
        <h2 style="font-size: 25px; font-family: sans-serif; color: orange; margin: 7px; text-align: center;" id="sucesso"><?= $aguarde ?></h2>
        <h2 style="font-size: 20px; font-family: sans-serif; color: blue; margin: 7px; text-align: center; visibility: hidden;" id="redirecionamento">Redirecionando em <span id="segundos"></span>...</h2>      
        <script type="text/javascript">
            function sucesso() {
                document.getElementById("sucesso").innerHTML = "<?= $sucesso ?>";
                document.getElementById("sucesso").style.color = "darkgreen";
                document.getElementById("redirecionamento").style.visibility = "visible";
            }

            setInterval(sucesso, 250);
        </script>
        <?php
    } else {
        ?>
        <h2 style="font-size: 25px; font-family: sans-serif; color: red; margin: 7px; text-align: center;"><?= $problema ?></h2>
        <p style="font-size: 16px; font-family: sans-serif; color: red; margin: 7px; text-align: center;"><?= $mensagemErro ?></p>
        <h2 style="font-size: 20px; font-family: sans-serif; color: blue; margin: 7px; text-align: center;">Redirecionando em <span id="segundos"></span>...</h2>                
        <?php
    }
    ?>
    <script type="text/javascript">
        i = <?= $tempo ?>;

        function contagem() {
            if (i == 0) {
                document.location = "<?= $url ?>";
            }

            document.getElementById("segundos").innerHTML = i;
            i--;
        }

        contagem();
        setInterval(contagem, 1000);
    </script>
    <?php
}
?>
