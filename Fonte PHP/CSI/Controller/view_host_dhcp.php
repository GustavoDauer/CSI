<?php
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_HOST_DHCP_LIST)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/conexao.php'; ?>
    <?php require_once '../include/header.php'; ?>  
    <!------------------------------------------------>
    <div style="margin: 7px;">    
        <input type="button" value="Voltar" onclick="document.location = 'view_host.php';"><br><br>
        <?php
        $c = connect();
        $sql = "SELECT REPLACE(ip,'.','') as ipnum, ip,tipo,mac,secao,observacao,gateway FROM Host "
                . "INNER JOIN Secao ON idSecao = Secao_idSecao "
                . "WHERE secao != 'OM EXTERNA' AND secao != 'OUTROS' "
                . "ORDER BY Secao_idSecao, LEFT(ipnum, 6), LENGTH(ipnum);";

        $resultHost = $c->query($sql);
        echo "<textarea cols='125' rows='25'>";
        echo "ddns-update-style none;\n";
        echo "default-lease-time 600;\n";
        echo "max-lease-time 7200;\n";
        echo "authoritative;\n";
        //echo "#option wpad-url code 252=text;\n";
        //echo "#option wpad-url " . '"' . "http://10.12.80.5/wpad.dat\\n" . '";' . "\n";
        echo "option domain-name " . '"' . "2becmb.eb.mil.br" . '"' . ";\n";
        echo "deny unknown-clients;\n\n";
        echo "subnet 10.12.80.0 netmask 255.255.252.0 {\n"
        //. "\trange 10.12.80.1 10.12.80.2;\n"
        . "\toption routers 10.12.80.3;\n"
        . "\toption domain-name-servers 10.13.128.15, 10.13.128.20;\n" //, 10.12.80.5
        . "\toption broadcast-address 10.12.83.255;\n"
        . "\toption ntp-servers 10.13.128.31;\n\n\n";

        if ($resultHost->num_rows > 0) {
            $secaoAux = "";            

            while ($row = $resultHost->fetch_assoc()) {
                $secao = $row["secao"];
                $ip = $row["ip"];
                $tipo = $row["tipo"];
                $mac = $row["mac"];
                $ordem = $row["ordem"];
                $observacao = $row["observacao"];
                $gateway = $row["gateway"];
                $ipOctets = explode(".", $ip);
                $hostNameEnd = $ipOctets[2] . "." . $ipOctets[3];                

                $secao = str_replace(" ", "_", $secao);
                $secao = str_replace("/", "-", $secao);

                if ($mac == "") {
                    echo "#";
                }

                echo "\thost $secao.$hostNameEnd {";
                echo "  hardware ethernet $mac;";
                echo "  fixed-address $ip; ";

                if ($gateway != "") {
                    echo "  option routers $gateway; option domain-name-servers 10.12.80.5, 8.8.8.8, 8.8.4.4; ";
                }

                echo "} # $observacao | $tipo\n";
            }
        }

        echo "}";
        echo "</textarea>";
        $c->close();
        ?>        
    </div>
    <!------------------------------------------------>
<?php } ?>
<?php require_once '../include/footer.php'; ?>
