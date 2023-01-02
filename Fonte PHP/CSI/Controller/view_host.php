<?php
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_HOST_LIST)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/header.php'; ?>   
    <!------------------------------------------------>
    <iframe src="view_host_iframe.php" width="1024" height="14000" style="border: 0px;" name="hostGathering" id="hostGathering"></iframe>
    <script type="text/javascript">
        var iframeWidth = screen.width - 50; // Margem para ambientes gráficos com menus laterais
        document.getElementById("hostGathering").width = iframeWidth < 1024 ? 1024 : iframeWidth;
    </script>
    <!------------------------------------------------>
<?php } ?>
<?php require_once '../include/footer.php'; ?>