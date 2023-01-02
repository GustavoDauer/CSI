<?php $server = $_SERVER['SERVER_NAME']; ?>
<?php $address = $_SERVER['REQUEST_URI']; ?>
<?php require_once "../include/comum.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta http-equiv = "refresh" content = "250">
        <title>SecInfo - 2º BECmb</title>
        <link rel = "stylesheet" href = "../css/bootstrap.min.css">
        <script src = "../js/bootstrap.min.js"></script>
        <link rel = "stylesheet" href = "http://<?= $server ?>/CSI/css/bootstrap.min.css">
        <script src = "http://<?= $server ?>/CSI/js/bootstrap.min.js"></script>
        <style type="text/css">
            .container {
                margin: 0px;                                    
            }            
        </style>      
    </head>
    <body>
        <?php require_once '../include/conexao.php'; ?>
        <!------------------------------------------------>
        <div style="margin: 0px;">    
            <?php
            $levantamento = filter_input(INPUT_GET, "gathering");

            if ($levantamento == 1 || !isset($_COOKIE["ultimaAtualizacaoNmap"])) {
                setHostsByFile();
            }

            function setId($secao) {
                echo "id='$secao'";
            }

            function printHost($ip, $tipo, $estado, $sistemaOperacional, $lacre, $dataOnline, $processador, $memoria, $memoriaTipo, $discoRigido) {
                $checkUsb = getHostsUsb($ip);
                $neverOnline = "";
                $dataLimite = strtotime('today');
                $dataOnlineCalc = strtotime($dataOnline);
                $dateDiff = abs((int) (($dataOnlineCalc - $dataLimite) / 86400));
                if ($estado == "offline" && (empty($dataOnline) || $dataOnline == "NULL" || $dateDiff > 34)) {
                    $neverOnline = "-semrede";
                } else if ($estado == "offline" && $dateDiff < 34) {
                    $neverOnline = "";
                }
                if (!empty($dataOnline)) {
                    $dataOnlineFormatada = new DateTime($dataOnline);
                    $dataOnlineFormatada = $dataOnlineFormatada->format('d/m/Y H:i');
                } else {
                    $dataOnlineFormatada = "Nunca foi visto online";
                }
                //echo "<a name='$ip'></a><a href='view_host_edit.php?id=$ip' target='_parent'><span style='font-size: 10px; font-family: sans-serif;'><img src='../imagens/$tipo-$estado" . $neverOnline . ".png' title='Última vez online em: $dataOnlineFormatada'>";
                echo "<a name='$ip'></a><a href='HostController.php?action=update&id=$ip' target='_parent'><span style='font-size: 10px; font-family: sans-serif;'><img src='../imagens/$tipo-$estado" . $neverOnline . ".png' title='Última vez online em: $dataOnlineFormatada'>";
                if ($sistemaOperacional != "" && $sistemaOperacional != " ") {
                    echo " <img src='../imagens/$sistemaOperacional.png' title='$processador\n$memoria $memoriaTipo\n $discoRigido'>";
                }
                if ($checkUsb) {
                    echo " <img src='../imagens/usb.png'>";
                }
                if ($lacre != "") {
                    echo "<br><b>#$lacre</b> ";
                }
                echo "<br>$ip</span></a><br>";
            }

            function printSessionStatus($online, $secao) {
                if (!$online) {
                    echo "<script type='text/javascript'>document.getElementById('$secao').className = 'offline';</script>";
                } else {
                    echo "<script type='text/javascript'>document.getElementById('$secao').className = 'online';</script>";
                }
            }

            function checkIpOnFile($ip, $fileName) {
                $file = file($fileName);

                foreach ($file as $line) {
                    $line = trim($line);

                    if ($line == $ip) {
                        return true;
                    }
                }

                return false;
            }

            // Pega hosts por seção (Hosts por seção cadastrada)
            function getHosts($secao) {
                $c = connect();
                $sql = "SELECT * FROM Host "
                        . " INNER JOIN Secao ON idSecao = Secao_idSecao "
                        . " WHERE secao='$secao' AND tipo != 'camera' AND tipo != 'nanostation' AND tipo != 'vm' AND tipo != 'servidor' AND tipo != 'roteador' "
                        . " ORDER BY ordem;";

                $resultHost = $c->query($sql);
                echo "<span class='secao'>$secao</span>" . "<br>";
                $online = 0; // Diz se uma sessão está online ou offline (basta uma máquina estar online para sessão estar online)

                if ($resultHost->num_rows > 0) {
                    while ($row = $resultHost->fetch_assoc()) {
                        $ip = $row["ip"];
                        $tipo = $row["tipo"];
                        $mac = $row["mac"];
                        $isOnline = ($row["estado"] == 1 || checkIpOnFile($ip, "./online.txt"));
                        $estado = $isOnline ? "online" : "offline";
                        $sistemaOperacional = $row["sistemaOperacional"];
                        $lacre = $row["lacre"];
                        $dataOnline = $row["dataOnline"];
                        $processador = $row["processador"];
                        $memoria = $row["memoria"];
                        $memoriaTipo = $row["memoriaTipo"];
                        $discoRigido = $row["discoRigido"];

                        if ($tipo == "" || $tipo == null) {
                            $tipo = "pc";
                        }

                        if (($mac == "" || $mac == null) && $row["ipHost"] != 1) {
                            $tipo = "pc";
                        }

                        printHost($ip, $tipo, $estado, $sistemaOperacional, $lacre, $dataOnline, $processador, $memoria, $memoriaTipo, $discoRigido);

                        if ($online == 0) {
                            if ($estado == "online") {
                                $online = 1;
                            }
                        }
                    }

                    printSessionStatus($online, $secao);
                }

                $c->close();
            }

            // Pega hosts sem seção (Hosts sem seção cadastrada)
            function getHostsNull() {
                $secao = "";
                $c = connect();
                $sql = "SELECT *, CAST(REPLACE(ip,'.','') AS SIGNED) as ipnum FROM Host "
                        . " WHERE Secao_idSecao is NULL "
                        . " ORDER BY ipnum;";
                $resultHost = $c->query($sql);
                $online = 0;
                $hostsInCol = 14;
                $colNum = 12;
                $iHostsInCol = 0;
                $iColNum = 0;
                $novaLinha = true;
                $novaColuna = true;

                if ($resultHost->num_rows > 0) {
                    while ($row = $resultHost->fetch_assoc()) {
                        $ip = $row["ip"];
                        $tipo = $row["tipo"];
                        $estado = $row["estado"] == 1 ? "online" : "offline";
                        $sistemaOperacional = $row["sistemaOperacional"];
                        $lacre = $row["lacre"];
                        $dataOnline = $row["dataOnline"];
                        $processador = $row["processador"];
                        $memoria = $row["memoria"];
                        $memoriaTipo = $row["memoriaTipo"];
                        $discoRigido = $row["discoRigido"];

                        if ($tipo == "" || $tipo == null) {
                            $tipo = "pc";
                        }

                        if ($novaLinha) {
                            echo "<tr>";
                            $novaLinha = false;
                        }

                        if ($novaColuna) {
                            echo "<td>";
                            $novaColuna = false;
                        }

                        printHost($ip, $tipo, $estado, $sistemaOperacional, $lacre, $dataOnline, $processador, $memoria, $memoriaTipo, $discoRigido);
                        $iHostsInCol++;

                        if ($iHostsInCol == $hostsInCol) {
                            echo "</td>";
                            $novaColuna = true;
                            $iHostsInCol = 0;
                            $iColNum++;
                        }

                        if ($iColNum == $colNum) {
                            echo "</tr>";
                            $novaLinha = true;
                            $iColNum = 0;
                        }

                        if ($online == 0) {
                            $online = $row["estado"] == 1 ? 1 : 0;
                        }
                    }

                    printSessionStatus($online, $secao);
                }

                $c->close();
            }

            // Pega hosts por tipo (Hosts separados por tipo (Ex: Cameras, Roteadores e Nanostations)
            function getHostsByTipo($tipoHost) {
                $c = connect();
                $sql = "SELECT * FROM Host "
                        . " WHERE tipo = '$tipoHost' "
                        . " ORDER BY ordem;";

                $resultHost = $c->query($sql);
                $online = 0;
                $hostsInCol = 5;
                $colNum = 12;
                $iHostsInCol = 0;
                $iColNum = 0;
                $novaLinha = true;
                $novaColuna = true;

                if ($resultHost->num_rows > 0) {
                    while ($row = $resultHost->fetch_assoc()) {
                        $ip = $row["ip"];
                        $tipo = $row["tipo"];
                        $estado = $row["estado"] == 1 ? "online" : "offline";
                        $sistemaOperacional = $row["sistemaOperacional"];
                        $lacre = $row["lacre"];
                        $dataOnline = $row["dataOnline"];
                        $processador = $row["processador"];
                        $memoria = $row["memoria"];
                        $memoriaTipo = $row["memoriaTipo"];
                        $discoRigido = $row["discoRigido"];

                        if ($tipo == "" || $tipo == null) {
                            $tipo = "pc";
                        }

                        if ($novaLinha) {
                            echo "<tr>";
                            $novaLinha = false;
                        }

                        if ($novaColuna) {
                            echo "<td>";
                            $novaColuna = false;
                        }

                        printHost($ip, $tipo, $estado, $sistemaOperacional, $lacre, $dataOnline, $processador, $memoria, $memoriaTipo, $discoRigido);
                        $iHostsInCol++;

                        if ($iHostsInCol == $hostsInCol) {
                            echo "</td>";
                            $novaColuna = true;
                            $iHostsInCol = 0;
                            $iColNum++;
                        }

                        if ($iColNum == $colNum) {
                            echo "</tr>";
                            $novaLinha = true;
                            $iColNum = 0;
                        }

                        if ($online == 0) {
                            $online = $row["estado"] == 1 ? 1 : 0;
                        }
                    }

                    printSessionStatus($online, $secao);
                }

                $c->close();
            }

            // Pega hosts com MACs duplicados
            function getHostsMacDup() {
                $c = connect();
                $sql = "SELECT ip,secao,tipo,estado,mac,sistemaOperacional,lacre,COUNT(*) c,dataOnline FROM Host "
                        . " INNER JOIN Secao on idSecao = Secao_idSecao "
                        . " GROUP BY mac HAVING c > 1;";

                $resultHost = $c->query($sql);

                if ($resultHost->num_rows > 0) {
                    while ($row = $resultHost->fetch_assoc()) {
                        $ip = $row["ip"];
                        $mac = $row["mac"];
                        $tipo = $row["tipo"];
                        $estado = $row["estado"] == 1 ? "online" : "offline";
                        $sistemaOperacional = $row["sistemaOperacional"];
                        $lacre = $row["lacre"];
                        $dataOnline = $row["dataOnline"];
                        $processador = $row["processador"];
                        $memoria = $row["memoria"];
                        $memoriaTipo = $row["memoriaTipo"];
                        $discoRigido = $row["discoRigido"];

                        if ($tipo == "" || $tipo == null) {
                            $tipo = "pc";
                        }

                        printHost($ip, $tipo, $estado, $sistemaOperacional, $lacre, $dataOnline, $processador, $memoria, $memoriaTipo, $discoRigido);
                    }
                }

                $c->close();
            }

            // Verifica a USB de um host
            function getHostsUsb($ip) {
                $file = file("./HostLiberados");

                foreach ($file as $line) {
                    $line = trim($line);

                    if ($line == $ip) {
                        return true;
                    }
                }

                return false;
            }

            // Atualiza o BD pelo arquivo do Nmap
            function setHostsByFile() {
                $hostsUp = fopen("../online.txt", "r") or die("Erro ao abrir arquivo!");
                $c = connect();
                $stmt = $c->prepare("UPDATE Host SET estado=0 WHERE Secao_idSecao NOT IN ( SELECT idSecao FROM Secao WHERE secao='OUTROS' OR secao='OM EXTERNA' );");
                $stmt->execute();

                while (!feof($hostsUp)) {
                    $ip = fgets($hostsUp);
                    $ip = str_replace("\n", "", $ip);

                    if ($ip != "") {
                        $stmt = $c->prepare("UPDATE Host SET estado=1, dataOnline=CURRENT_DATE WHERE ip='$ip'");
                        $stmt->execute();
                    }
                }

                $c->close();
                fclose($hostsUp);
                setcookie("ultimaAtualizacaoNmap", time() + 125);
            }
            ?>
            <style type="text/css">
                td {
                    vertical-align: top;                          
                }

                td .secao {
                    margin: 2px;
                    font-size: 10px;
                    letter-spacing: 2px;
                    font-weight: bold;
                }

                .offline {
                    background: #ffefef;
                }

                .online {
                    background: #effff3;
                }

                table {

                }
            </style>   
            <?php // if (isAdmin()) {  ?>
            <table cellpadding="0" cellspacing="0" border="0" style="margin: 7px; font-size: 11px; font-family: sans-serif;">
                <tr>
                    <td valign="top">
                        <span id="timing"></span> | <a href="view_host_iframe.php?gathering=1" target="hostGathering">Atualizar com dados Nmap</a> | <?php if (isAdminLevel($NIVEL_HOST_DHCP_LIST)) { ?><a href="view_host_dhcp.php" target="_top">Gerar DHCP</a><?php } ?> | <a href="https://docs.google.com/spreadsheets/d/1sd_crpfQjl08e319J9GuuoLgmTlN2hDn_O2lJhLC6dQ/edit?usp=sharing" target="_blank">Planilha de controle de IPs</a><br>
                        <span style="color: red;"> OBS: Atualização automática através do monitoramento contínuo de todos IPs da rede </span>
                    </td>
                    <td rowspan="2">&nbsp;</td>
                    <td rowspan="2">  
                        <?php getHosts("OM EXTERNA"); ?>
                        <!--<button type='submit' class='btn btn-primary' onclick="document.location = 'view_host_add.php'">Adicionar</button>-->
                    </td>
                    <td rowspan="2">&nbsp;</td>
                    <td rowspan="2">  
                        <?php getHosts("MI"); ?>                
                    </td>
                    <td rowspan="2">&nbsp;</td>
                    <td rowspan="2">  
                        <?php getHosts("OUTROS"); ?>
                        <!--<button type='submit' class='btn btn-primary' onclick="document.location = 'view_host_add.php'">Adicionar</button>-->
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <!--<span style="color: red;"> OBS: Atualização automática através do monitoramento contínuo de todos IPs da rede </span>-->
                    </td>              
                </tr>
            </table>                                         
            <?php // }  ?>  
            <table cellpadding="0" cellspacing="0" width="1024" border="0" id="main">
                <script type="text/javascript">
                    var tableWidth = screen.width - 70; // Margem para ambientes gráficos com menus laterais
                    document.getElementById("main").width = tableWidth < 1024 ? 1024 : tableWidth;
                </script>
                <tr>
                    <td colspan="3" height="" >
                        <table border="0" cellpadding="7" cellspacing="7">
                            <tr>
                                <td>
                                    <!------------ SERVIDORES ---------------->
                                    <h2 style='font-size: 20px; color: darkblue'>Servidores</h2>
                                    <table cellspacing="7" cellpadding="7" border="1">
                                        <?php
                                        getHostsByTipo("servidor");
                                        ?>            
                                    </table>  
                                </td>
                                <td>
                                    <!------------ NANOSTATIONS ---------------->
                                    <h2 style='font-size: 20px; color: darkblue'>Nanostations</h2>
                                    <table cellspacing="7" cellpadding="7" border="1">
                                        <?php
                                        getHostsByTipo("nanostation");
                                        ?>            
                                    </table>  
                                </td>
                                <td>
                                    <!------------ ROTEADORES ---------------->
                                    <h2 style='font-size: 20px; color: darkblue'>Roteadores / Switchs</h2>
                                    <table cellspacing="7" cellpadding="7" border="1">
                                        <?php
                                        getHostsByTipo("roteador");
                                        ?>            
                                    </table>
                                </td>
                                <td>
                                    <!------------ VoIPs ---------------->
                                    <h2 style='font-size: 20px; color: darkblue'>VoIPs</h2>
                                    <table cellspacing="7" cellpadding="7" border="1">
                                        <?php
                                        getHostsByTipo("telefone");
                                        ?>            
                                    </table>
                                </td>
                                <td>
                                    <!------------ VMs ---------------->
                                    <h2 style='font-size: 20px; color: darkblue'>VMs clientes</h2>
                                    <table cellspacing="7" cellpadding="7" border="1">
                                        <?php
                                        getHostsByTipo("vm");
                                        ?>            
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <hr>

                        <!------------ PAVILHAO COMANDO 2º ANDAR ---------------->
                        <table cellpadding="0" cellspacing="0"  border="1" width="100%">
                            <tr>
                                <td width="10%" height="" <?php setId("S3"); ?>>
                                    <?php getHosts("S3"); ?>
                                </td>
                                <td  width="10%" <?php setId("SECINFO"); ?>>
                                    <?php getHosts("SECINFO"); ?>
                                </td>
<!--                                <td width="8%" <?php setId("SERVIDOR"); ?>>
                                <?php getHosts("SERVIDOR"); ?>
                                </td>-->
                                <td width="10%" <?php setId("S2"); ?>>
                                    <?php getHosts("S2"); ?>
                                </td>
                                <td width="10%" <?php setId("S1"); ?>>
                                    <?php getHosts("S1"); ?>
                                </td>
                                <td width="10%" <?php setId("SPP"); ?>>
                                    <?php getHosts("SPP"); ?>
                                </td>
                                <td width="10%" <?php setId("S4"); ?>>
                                    <?php getHosts("S4"); ?>
                                </td>
                                <td>&nbsp;</td>
                                <td width="10%" <?php setId("COMANDO"); ?>>
                                    <?php getHosts("COMANDO"); ?>
                                </td>
                                <td width="10%" <?php setId("PROTOCOLO"); ?>>
                                    <?php getHosts("PROTOCOLO"); ?>
                                </td>
                                <td width="10%" <?php setId("JURIDICO"); ?>>
                                    <?php getHosts("JURIDICO"); ?>
                                </td>
                                <td width="10%" <?php setId("ARQUIVOS GERAIS"); ?>>
                                    <?php getHosts("ARQUIVOS GERAIS"); ?>
                                </td>                               
                        </table>
                        <table cellpadding="0" cellspacing="0" border="1" width="100%">
                            <tr>
                                <td width="8%" height="" <?php setId("SIP"); ?>>
                                    <?php getHosts("SIP"); ?>
                                </td>
                                <td width="4%">&nbsp;</td>
                                <td width="12%" <?php setId("FUSEX"); ?>>
                                    <?php getHosts("FUSEX"); ?>
                                </td>
                                <td width="8%"></td>                                    
                                <td width="8%" <?php setId("IDENTIDADE"); ?>>
                                    <?php getHosts("IDENTIDADE"); ?>
                                </td>
                                <td width="8%" <?php setId("DENTISTA"); ?>>
                                    <?php getHosts("DENTISTA"); ?>
                                </td>
                                <td width="8%" <?php setId("RP"); ?>>
                                    <?php getHosts("RP"); ?>
                                </td>
                                <td width="10%">&nbsp;</td>
                                <td width="18%">&nbsp;</td>
                                <td width="8%" <?php setId("CMDT CEC"); ?>>
                                    <?php getHosts("CMDT CEC"); ?>
                                </td>
                                <td width="8%" <?php setId("ST CEC"); ?>>
                                    <?php getHosts("ST CEC"); ?>
                                </td>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td height="70"></td>
                    <td>&nbsp;</td>
                    <td  align="right">
                        <table cellpadding="0" cellspacing="0" border="1" width="50%">
                            <tr>
                                <td <?php setId("CMDT PEL CEC"); ?>>
                                    <?php getHosts("CMDT PEL CEC"); ?>
                                </td>                        
                            </tr>
                            <tr>
                                <td <?php setId("SGTE CEC"); ?>>
                                    <?php getHosts("SGTE CEC"); ?>
                                </td>                        
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="25%" height="">
                        <!------------CCAP / SGTE CCAP / ST CCAP / FS ---------------->

                        <table cellpadding="0" cellspacing="0" border="1" width="50%" height="100%">
                            <tr>
                                <td <?php setId("COM"); ?>>
                                    <?php getHosts("COM"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td <?php setId("SGTE CCAP"); ?>>
                                    <?php getHosts("SGTE CCAP"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td <?php setId("ST CCAP"); ?>>
                                    <?php getHosts("ST CCAP"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td <?php setId("FS"); ?>>
                                    <?php getHosts("FS"); ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td width="50%">
                        <!------------ALMOX / RESERVA / DAE / GUARDA---------------->

                        <table cellpadding="0" cellspacing="0" border="1" width="100%" height="100%">
                            <tr>
                                <td width="34%">&nbsp;</td>
                                <td width="22%" align="center">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr>
                                            <td <?php setId("CMDT CCAP"); ?>>
                                                <?php getHosts("CMDT CCAP"); ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="34%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td <?php setId("ALMOX"); ?>>
                                    <?php getHosts("ALMOX"); ?>
                                </td>
                                <td rowspan="5">&nbsp;</td>
                                <td <?php setId("RESERVA"); ?>>                                                        
                                    <?php getHosts("RESERVA"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;
                                </td>                        
                                <td <?php setId("DAE"); ?>>
                                    <?php getHosts("DAE"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td <?php setId("ST CEP"); ?>>
                                    <?php getHosts("ST CEP"); ?>
                                </td>                        
                                <td rowspan="3" <?php setId("GUARDA"); ?>>                            
                                    <?php getHosts("GUARDA"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td <?php setId("CMDT PEL CEP"); ?>>
                                    <?php getHosts("CMDT PEL CEP"); ?>
                                </td>                                      
                            </tr>
                            <tr>
                                <td <?php setId("ADJUNTO/OF DIA"); ?>>
                                    <?php getHosts("ADJUNTO/OF DIA"); ?>
                                </td>                            
                            </tr>
                        </table>

                    </td>
                    <td width="25%" align="right">
                        <!------------CEC / FISCAL / RANCHO ---------------->                

                        <table cellpadding="0" cellspacing="0" border="1" width="50%" height="100%">                                        
                            <tr>
                                <td <?php setId("SISCOFIS"); ?>>
                                    <?php getHosts("SISCOFIS"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td <?php setId("CONFORMIDADE"); ?>>
                                    <?php getHosts("CONFORMIDADE"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td <?php setId("TESOURARIA"); ?>>
                                    <?php getHosts("TESOURARIA"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td <?php setId("SEC TEC"); ?>>
                                    <?php getHosts("SEC TEC"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td <?php setId("AQUISICOES"); ?>>
                                    <?php getHosts("AQUISICOES"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td <?php setId("FISCAL"); ?>>
                                    <?php getHosts("FISCAL"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td <?php setId("RANCHO"); ?>>
                                    <?php getHosts("RANCHO"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td height="70">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan = "3">
                        <!------------CEP ---------------->                

                        <table cellpadding="0" cellspacing="0" border="1" width="100%">
                            <tr>
                                <td width="10%" <?php setId("VISITANTES"); ?>>
                                    <?php getHosts("VISITANTES"); ?>
                                </td>
                                <td width="40%" height="">&nbsp;</td>
                                <td width="25%" <?php setId("SGTE CEP"); ?>>
                                    <?php getHosts("SGTE CEP"); ?>
                                </td>
                                <td width="15%" <?php setId("CMDT CEP"); ?>>
                                    <?php getHosts("CMDT CEP"); ?>
                                </td>
                                <td width="10%">&nbsp;</td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>    
            <hr>
            <h2 style='font-size: 20px; color: darkblue'>SALC</h2>
            <table cellpadding="0" cellspacing="0" border="1" width="100%">
                <tr>
                    <td <?php setId("SALC"); ?>>
                        <?php getHosts("SALC"); ?>
                    </td>
                </tr>
            </table>
            <h2 style='font-size: 20px; color: darkblue'>Escalão</h2>
            <table cellpadding="0" cellspacing="0" border="1" width="100%">
                <tr>
                    <td <?php setId("ESCALAO"); ?>>
                        <?php getHosts("ESCALAO"); ?>
                    </td>
                </tr>
            </table>
            <hr><h2 style='font-size: 20px; color: darkblue'>Estação Rádio</h2>
            <table cellpadding="0" cellspacing="0" border="1" width="100%">
                <tr>
                    <td <?php setId("ESTACAO RADIO"); ?>>
                        <?php getHosts("ESTACAO RADIO"); ?>
                    </td>
                </tr>
            </table>
            <hr><h2 style='font-size: 20px; color: darkblue'>Pelotão de Obras</h2>
            <table cellpadding="0" cellspacing="0" border="1" width="100%">
                <tr>
                    <td <?php setId("PO"); ?>>
                        <?php getHosts("PO"); ?>
                    </td>
                </tr>
            </table>
            <hr><h2 style='font-size: 20px; color: darkblue'>Depósito de Pontes</h2>
            <table cellpadding="0" cellspacing="0" border="1" width="100%">
                <tr>
                    <td <?php setId("DEP PONTES"); ?>>
                        <?php getHosts("DEP PONTES"); ?>
                    </td>
                </tr>
            </table>
            <hr><h2 style='font-size: 20px; color: darkblue'>Pel Eq</h2>
            <table cellpadding="0" cellspacing="0" border="1" width="100%">
                <tr>
                    <td <?php setId("PEL EQ"); ?>>
                        <?php getHosts("PEL EQ"); ?>
                    </td>
                </tr>
            </table>
            <hr><h2 style='font-size: 20px; color: darkblue'>HT</h2>
            <table cellpadding="0" cellspacing="0" border="1" width="100%">
                <tr>
                    <td <?php setId("HT"); ?>>
                        <?php getHosts("HT"); ?>
                    </td>
                </tr>
            </table>
            <hr><h2 style='font-size: 20px; color: darkblue'>SEC MOB</h2>
            <table cellpadding="0" cellspacing="0" border="1" width="100%">
                <tr>
                    <td <?php setId("SECMOB"); ?>>
                        <?php getHosts("SECMOB"); ?>
                    </td>
                </tr>
            </table>
            <hr><h2 style='font-size: 20px; color: darkblue'>SFPC</h2>
            <table cellpadding="0" cellspacing="0" border="1" width="100%">
                <tr>
                    <td <?php setId("SFPC"); ?>>
                        <?php getHosts("SFPC"); ?>
                    </td>
                </tr>
            </table>
            <hr><h2 style='font-size: 20px; color: darkblue'>Hosts sem seção cadastrada</h2>
            <table cellspacing="7" cellpadding="7" border="1">
                <?php
                getHostsNull("");
                ?>            
            </table>
            <hr><h2 style='font-size: 20px; color: darkblue'>Hosts com MACs duplicados</h2>
            <table cellspacing="7" cellpadding="7" border="1">
                <tr>
                    <td>
                        <?php
                        getHostsMacDup();
                        ?>  
                    </td>
                </tr>                  
            </table>    
            <script type="text/javascript">
                var seconds = 70;
                var secondsForTiming = seconds;

                function timing() {
                    secondsForTiming -= 1;
                    document.getElementById("timing").innerHTML = secondsForTiming + " segundos para atualização automática";
                    setTimeout("timing()", 1000);
                }

                window.onload = function () {
                    setTimeout("location.replace('view_host_iframe.php');", seconds * 1000);
                    timing();
                }
            </script>
        </div>
    </body>
</html>