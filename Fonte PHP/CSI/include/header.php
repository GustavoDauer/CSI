<?php $address = $_SERVER['REQUEST_URI']; ?>
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
    <body> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td valign="bottom" style="text-align: center;">
                                <h1 style="margin: 0; font-family: serif; letter-spacing: 1px; font-weight: bold; font-size: 35px; color: #34b2ee;">   
                                    <?= $SOFTWARE ?>
                                    <span style="font-size: 10px;color: red;">SISTEMA EM REFATORAÇÃO!</span>
                                </h1>
                            </td>
                        </tr>
                    </table>                                                   
                </div>        
                <div class="col-md-6" style="text-align: right; padding-top: 7px;">
                    <span style="font-size: 10px; font-family: sans-serif;">                            
                        <?php if (isAdminLevel($NIVEL_USUARIO_LIST)) { ?>  
                            <a href="./view_usuario.php">
                                <img src="../imagens/gerenciar_usuarios.png" width="25" height="25" hspace="2" vspace="2"> Usuários
                            </a> |
                        <?php } ?>
                        CSI V. <?= $VERSAO ?>
                    </span>
                    <hr style="margin: 0px;">
                    <?php if (!isLoggedIn()) { ?>
                        <span style="font-size: 14px; color: red">Não há nenhum usuário logado!</span>
                    <?php } else { ?>
                        <span style="font-size: 14px; color: green">
                            Usuário: <?= $_SESSION["login"] . " | Nível: " . $_SESSION["nivel"] . "" ?>
                        </span>
                        <br>
                        <span style="font-size: 14px;">
                            <a href="#" onclick="alert('Função ainda não implementada!')">
                                Alterar senha
                            </a> 
                            | 
                            <a href="./sql_logout.php">
                                <img src="../imagens/sair.png" width="20" height="20"> Sair                                
                            </a> 
                        </span>
                    <?php } ?>
                </div>


                <ul class="nav nav-tabs">
                    <?php if (isAdminLevel($NIVEL_ESTATISTICAS)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= substr_count($address, "admin") > 0 ? "active" : ""; ?>" href="./view_admin.php?estatisticas">Administração</a>
                        </li>    
                    <?php } ?>      
                    <?php if (isAdminLevel($NIVEL_EQUIPAMENTO_LIST)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= substr_count($address, "EquipamentoController") > 0 ? "active" : ""; ?>" href="./EquipamentoController.php?action=getAllList">Equipamentos</a>
                        </li>  
                    <?php } ?>  
                    <?php if (isAdminLevel($NIVEL_OS_LIST)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= substr_count($address, "todas") > 0 ? "active" : ""; ?>" href="./view_ordemServico.php?todas">Ordens de serviço</a>
                        </li>
                    <?php } ?>  
                    <?php if (isAdminLevel($NIVEL_SOLICITACAOEQUIPAMENTO_LIST)) { ?>
                        <!--                        <li class="nav-item">
                                                        <a class="nav-link <?= substr_count($address, "equipamentos=1") > 0 ? "active" : ""; ?>" href="./view_ordemServico.php?equipamentos=1">Solicitações de equipamentos</a>
                                                    </li>-->
                    <?php } ?>  
                    <?php if (isAdminLevel($NIVEL_INVENTARIO_LIST)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= substr_count($address, "inventario") > 0 ? "active" : ""; ?>" href="./view_inventario.php">Inventário</a>
                        </li>
                    <?php } ?>
                    <?php if (isAdminLevel($NIVEL_HOST_LIST)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= substr_count($address, "host") > 0 ? "active" : ""; ?>" href="./view_host.php">Rede</a>
                        </li>
                    <?php } ?>
                        <?php if (isAdminLevel($NIVEL_INTERNET_LIST)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= substr_count($address, "internet") > 0 ? "active" : ""; ?>" href="./view_internet.php">Internet</a>
                        </li>
                    <?php } ?>  
                </ul>                                 
            </div>
        </div>
        <div class='container'>