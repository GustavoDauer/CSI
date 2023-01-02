<?php
require_once '../include/comum.php';
require_once '../include/conexao.php';
?>    
<!------------------------------------------------>
<link rel = "stylesheet" href = "../css/bootstrap.min.css">  
<table cellpadding="0" cellspacing="0" border="0" style="margin: 7px; font-size: 11px; font-family: sans-serif;">
    <tr>
        <td valign="top">
            <span id="timing"></span><br>
        </td>        
    </tr>
    <tr>
        <td valign="top">
            <span style="color: red;"> OBS: Atualização automática através dos arquivos de log do proxy</span>
        </td>              
    </tr>
</table>   
<?php
$rowClass = "";

function formataTamanho($tamanho) {
    $tamanho = $tamanho >= 1024 ? $tamanho / 1024 : $tamanho;
    $tamanho = $tamanho >= 1024 ? number_format($tamanho / 1024, 2, '.', '') . " MB" : number_format($tamanho, 2, '.', '') . " KB";
    return $tamanho;
}

function readAccessLog($fileName) {
    $c = connect();
    $sql = "DELETE FROM Internet ";
    $stmt = $c->prepare($sql);
    $stmt->execute();
    $file = file($fileName);
    $ignoradas = 0;

    for ($i = 1;
            $i < count($file);
            $i++) {
        $insert = true;
        $line = $file[count($file) - $i];
        $partes = explode(" ", $line);
        $dataHora = null;
        $ip = null;
        $tamanho = null;
        $url = null;
        $login = null;

//echo sizeof($partes) . "<br>" . var_dump($partes) . "<br>";

        switch (sizeof($partes)) {
            case 10:
                $ip = $partes[2];
                $tamanho = $partes[1];
                $url = $partes[6];
                $login = $partes[7];
                break;
            case 11:
                $ip = $partes[3];
                $tamanho = $partes[2];
                $url = $partes[7];
                $login = $partes[8];
                break;
            case 12:
                $ip = $partes[4];
                $tamanho = $partes[6];
                $url = $partes[8];
                $login = $partes[9];
                break;
            case 13:
                $ip = $partes[5];
                $tamanho = $partes[7];
                $url = $partes[9];
                $login = $partes[10];
                break;
            case 14:
                $ip = $partes[6];
                $tamanho = $partes[8];
                $url = $partes[10];
                $login = $partes[11];
                break;
            case 15:
                $ip = $partes[7];
                $tamanho = $partes[9];
                $url = $partes[11];
                $login = $partes[12];
                break;
            case 16:
                $ip = $partes[8];
                $tamanho = $partes[10];
                $url = $partes[12];
                $login = $partes[13];
                break;
            case 17:
                $ip = $partes[9];
                $tamanho = $partes[11];
                $url = $partes[13];
                $login = $partes[14];
                break;
            case 18:
                $ip = $partes[10];
                $tamanho = $partes[12];
                $url = $partes[14];
                $login = $partes[15];
                break;
            case 19:
                $ip = $partes[11];
                $tamanho = $partes[13];
                $url = $partes[15];
                $login = $partes[16];
                break;
            default:
//echo var_dump($partes) . "<br>";
                $insert = false;
                $ignoradas++;
                break;
        }

        if ($insert == true) {
            $sql = "INSERT INTO Internet(login, consumo, url, ip) VALUES('$login',  $tamanho, '$url', '$ip')";
            $stmt = $c->prepare($sql);
            $stmt->execute();
        }
    }

    echo $ignoradas . " linhas ignoradas / " . count($file) . " totais<br>";
}

readAccessLog("../access.log");
?>
<span id="holder" style="visibility: hidden;"></span>
<script type="text/javascript">
    document.getElementById("holder").innerHTML = document.getElementById("rightContent").innerHTML;
    document.getElementById("rightContent").innerHTML = document.getElementById("leftContent").innerHTML;
    document.getElementById("leftContent").innerHTML = document.getElementById("holder").innerHTML;
    document.getElementById("holder").innerHTML = "";

    var seconds = 70;
    var secondsForTiming = seconds;

    function timing() {
        secondsForTiming -= 1;
        document.getElementById("timing").innerHTML = secondsForTiming + " segundos para atualização automática";
        setTimeout("timing()", 1000);
    }

    window.onload = function () {
        setTimeout("location.replace('view_internet_iframe.php');", seconds * 1000);
        timing();
    }
</script>
<table cellspacing='7' cellpadding='7'>
    <tr><td id='rightContent' valign='top'>
            <table class='table table-hover' style='font-size: 12px; border: 2px solid blue;'>
                <thead>
                    <tr>
                        <th colspan='5'>Monitoramento de acesso à Internet</th>
                    </tr>
                    <tr>                        
                        <th>Login</th>                        
                        <th>Consumo</th>
                        <th>IPs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rowClass = "table-primary";
                    $loginsCompartilhados = null;
                    $c = connect();
                    $sql = "SELECT DISTINCT (login) FROM Internet ";
                    $result = $c->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $login = $row["login"];
                            $sql = "SELECT SUM(consumo) as consumo FROM Internet WHERE login='$login' ";
                            $resultConsumo = $c->query($sql);
                            while ($row = $resultConsumo->fetch_assoc()) {
                                $consumo = $row["consumo"];
                            }
                            ?>                    
                            <tr class='<?= $rowClass ?>'>                                             
                                <td><?= $login ?></td>   
                                <td><?= formataTamanho($consumo) ?></td> 
                                <td>
                                    <?php
                                    $sql = "SELECT DISTINCT(ip) FROM Internet WHERE login='$login' ";
                                    $resultIp = $c->query($sql);
                                    $i = 0;
                                    while ($row = $resultIp->fetch_assoc()) {
                                        $ip = $row["ip"];
                                        echo $ip . "<br>";
                                        $i++;
                                        if ($i > 1) {
                                            $loginsCompartilhados[] = $login;
                                        }
                                    }
                                    ?>  
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </td>
        <td valign="top">
            <table class='table table-hover' style='font-size: 12px; border: 2px solid yellow;'>
                <tr>
                    <th colspan='5'>Logins compartilhados</th>
                </tr>
                <tr>
                    <th>Login</th>                                        
                </tr>                 
                <?php
                $rowClass = "table-warning";
                foreach ($loginsCompartilhados as $login) {
                    ?> 
                    <tr class='<?= $rowClass ?>'>                                             
                        <td><?= $login ?></td>                                                                                               
                    </tr>    
                    <?php
                }
                ?>
            </table>
        </td>
        <td id='leftContent' valign='top'>
            <table class='table table-hover' style='font-size: 12px; border: 2px solid red;'>
                <tr>
                    <th colspan='5'>Top consumos altos de banda de Internet</th>
                </tr>
                <tr>
                    <th>Login</th>
                    <th>Consumo</th>
                    <th>IPs</th>
                </tr>     
                <?php
                $rowClass = "table-danger";
                $sql = "SELECT login, SUM(consumo) as total "
                        . " FROM Internet "
                        . " GROUP BY login "
                        . " ORDER by total DESC "
                        . " LIMIT 10";
                $reslultTop = $c->query($sql);
                while ($row = $reslultTop->fetch_assoc()) {
                    $login = $row["login"];
                    $consumo = $row["total"];
                    ?>
                    <tr class='<?= $rowClass ?>'>
                        <td><?= $login ?></td>
                        <td><?= formataTamanho($consumo) ?></td>  
                        <td>
                            <?php
                            $sql = "SELECT DISTINCT(ip) FROM Internet WHERE login='$login' ";
                            $resultIp = $c->query($sql);
                            while ($row = $resultIp->fetch_assoc()) {
                                $ip = $row["ip"];
                                echo $ip . "<br>";
                            }
                            ?>  
                        </td>
                    </tr>
                    <?php
                }
                $c->close();
                ?>
            </table>
        </td>        
    </tr>
</table>
<!------------------------------------------------>