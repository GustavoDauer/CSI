<?php require_once 'comum.php'; ?>
</div>
<hr>
<div style="font-size: 8px; font-family: sans-serif; text-align: center;">
    <?php if (isLoggedIn()) { ?>
        Usuário: <?= $_SESSION["login"] ?> (<?= $_SESSION["nivel"] ?>) | <a href="sql_logout.php">Logout</a> 
    <?php } else { ?>
        <a href="view_login.php">Login</a>
    <?php } ?>
</div>
<hr>
<div style="font-size: 8px; font-family: sans-serif; text-align: center;">
    <br><br><img src="../imagens/logo_2becmb.png"><br><br>
    Desenvolvido por 1º Ten Dauer - SecInfo - 2º BECmb - Versão <?= $VERSAO ?>
</div>
<br><br>
</body>
</html>