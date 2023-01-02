<?php require_once '../include/comum.php'; ?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "utf-8">        
        <title>SecInfo - 2º BECmb</title>
        <link rel = "stylesheet" href = "../css/bootstrap.min.css">
        <script src = "../js/bootstrap.min.js"></script>
        <style type="text/css">
            .container {
                margin: 0px;                                    
            }            
        </style>      
    </head>
    <body style="margin: 0px; padding: 0px; background: white; background-image: url('../imagens/fundo4.png'); background-repeat: no-repeat; background-size: 100% 100%;">  
        <div align="center">
            <div align="center" style="margin-top: 25px; padding-top: 70px; width: 800px; height: 500px; background-image: url('../imagens/fundo3.png'); background-size: 100% 100%; border: 2px black solid;">        
                <h1 style="font-family: serif; letter-spacing: 2px; font-weight: bold; font-size: 70px; color: #34b2ee;">   
                    <?= $SOFTWARE ?>
                    <span style="font-size: 14px;">Versão <?= $VERSAO ?></span>
                </h1>  
                <form action="../Controller/EquipamentoController.php?action=search" method="GET" style="padding: 25px 70px 25px 70px;">
                    <input type="hidden" name="action" value="search">
                    <div class="form-group">                        
                        <input type="text" placeholder="BUSCAR ORDEM DE SERVIÇO" name="id" class="form-control" style="text-align: center;" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 44;" maxlength="11">
                    </div>
                    <div class="form-group">                        
                        <input type="submit" value="BUSCAR" class="btn btn-danger" onrelease="this.disabled = true;">
                    </div>
                </form>                
                <?php
                if ($object != null) {
                    ?>
                    <div class="alert alert-success" style="margin: 0px 25px 0px 25px;">
                        <a href="../Controller/EquipamentoController.php?action=visualize&id=<?= $object->getId() ?>" target="_blank"><?= $object->getTipo() ?> - <?= $object->getResponsavel() ?></a>
                    </div>
                    <?php
                } else {
                    if (!empty($_REQUEST["id"])) {
                        ?>
                        <div class="alert alert-danger">
                            Nenhuma Ordem de Serviço encontrada!
                        </div>
                        <?php
                    }
                }
                ?>                            
            </div>                        
        </div>
        <hr>
        <div style="font-size: 8px; font-family: sans-serif; text-align: center;">
            <?php if (isLoggedIn()) { ?>
                Usuário: <?= $_SESSION["login"] ?> (<?= $_SESSION["nivel"] ?>) | <a href="./sql_logout.php">Logout</a> | <a href="./view_admin.php">Administração</a>
            <?php } else { ?>
                <a href="../Controller/view_login.php">Login</a>
            <?php } ?>
        </div>
        <hr>
        <div style="font-size: 8px; font-family: sans-serif; text-align: center; color:white;">
            <br><br><img src="../imagens/logo_2becmb.png"><br><br>
            Desenvolvido por 2º Ten Dauer - SecInfo - 2º BECmb - Versão <?= $VERSAO ?>
        </div>
        <br><br>
    </body>
</html>