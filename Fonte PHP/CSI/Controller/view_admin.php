<?php
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_ESTATISTICAS)) {
    echo $_SESSION["nivel"];
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/conexao.php'; ?>
    <?php require_once '../include/header.php'; ?>       
    <!------------------------------------------------>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    <style type="text/css">
        .graphList {
            width: 185px;
            border: 1px;
            border-style: dashed;
            border-color: lightblue;
            font-size: 10px;
        }
    </style>
    <?php
    echo "<h2 style='margin: 14px; font-size: 20px; color: darkblue'>Estatísticas ";
    echo "</h2>";
    echo '';
    $c = connect();
    echo "<hr>";
    $sql = "SELECT COUNT(*) as totalOS FROM OrdemServico;";
    $result = $c->query($sql);
    $totalOS = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $totalOS = $row["totalOS"];
        }
    }
    $sql = "SELECT COUNT(*) as totalVoips FROM Host WHERE tipo = 'telefone';";
    $result = $c->query($sql);
    $totalVoips = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $totalVoips = $row["totalVoips"];
        }
    }
    $sql = "SELECT COUNT(*) as totalNanostations FROM Host WHERE tipo = 'nanostation';";
    $result = $c->query($sql);
    $totalNanostations = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $totalNanostations = $row["totalNanostations"];
        }
    }
    $sql = "SELECT COUNT(*) as totalSwitchs FROM Host WHERE tipo = 'roteador';";
    $result = $c->query($sql);
    $totalSwitchs = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $totalSwitchs = $row["totalSwitchs"];
        }
    }
    $sql = "SELECT COUNT(*) as totalLinux FROM Host WHERE sistemaOperacional LIKE '%linux%';";
    $result = $c->query($sql);
    $totalLinux = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $totalLinux = $row["totalLinux"];
        }
    }
    $sql = "SELECT COUNT(*) as totalWindows FROM Host WHERE sistemaOperacional LIKE '%windows%';";
    $result = $c->query($sql);
    $totalWindows = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $totalWindows = $row["totalWindows"];
        }
    }
    $sql = "SELECT COUNT(*) as totalComputador FROM Host WHERE tipo = 'computador';";
    $result = $c->query($sql);
    $totalComputador = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $totalComputador = $row["totalComputador"];
        }
    }
    $sql = "SELECT COUNT(*) as totalNotebook FROM Host WHERE tipo = 'notebook';";
    $result = $c->query($sql);
    $totalNotebook = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $totalNotebook = $row["totalNotebook"];
        }
    }
    $sql = "SELECT COUNT(*) as totalServidor FROM Host WHERE tipo = 'servidor';";
    $result = $c->query($sql);
    $totalServidor = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $totalServidor = $row["totalServidor"];
        }
    }
    $sql = "SELECT COUNT(*) as totalImpressora FROM Host WHERE tipo = 'impressora';";
    $result = $c->query($sql);
    $totalImpressora = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $totalImpressora = $row["totalImpressora"];
        }
    }
    $sql = "SELECT COUNT(*) as DDR FROM Host WHERE memoriaTipo = 'DDR';";
    $result = $c->query($sql);
    $ddr = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $ddr = $row["DDR"];
        }
    }
    $sql = "SELECT COUNT(*) as DDR2 FROM Host WHERE memoriaTipo = 'DDR2';";
    $result = $c->query($sql);
    $ddr2 = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $ddr2 = $row["DDR2"];
        }
    }
    $sql = "SELECT COUNT(*) as DDR3 FROM Host WHERE memoriaTipo = 'DDR3';";
    $result = $c->query($sql);
    $ddr3 = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $ddr3 = $row["DDR3"];
        }
    }
    $sql = "SELECT COUNT(*) as DDR4 FROM Host WHERE memoriaTipo = 'DDR4';";
    $result = $c->query($sql);
    $ddr4 = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $ddr4 = $row["DDR4"];
        }
    }
    $sql = "SELECT COUNT(*) as HD_IDE FROM Host WHERE discoRigido = 'HD IDE';";
    $result = $c->query($sql);
    $ide = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $ide = $row["HD_IDE"];
        }
    }
    $sql = "SELECT COUNT(*) as HD_SATA FROM Host WHERE discoRigido = 'HD SATA';";
    $result = $c->query($sql);
    $sata = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $sata = $row["HD_SATA"];
        }
    }
    $sql = "SELECT COUNT(*) as SSD FROM Host WHERE discoRigido = 'SSD';";
    $result = $c->query($sql);
    $ssd = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $ssd = $row["SSD"];
        }
    }
    $sql = "SELECT COUNT(*) as 1GB FROM Host WHERE memoria = '1GB';";
    $result = $c->query($sql);
    $gb1 = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $gb1 = $row["1GB"];
        }
    }
    $sql = "SELECT COUNT(*) as 2GB FROM Host WHERE memoria = '2GB';";
    $result = $c->query($sql);
    $gb2 = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $gb2 = $row["2GB"];
        }
    }
    $sql = "SELECT COUNT(*) as 4GB FROM Host WHERE memoria = '4GB';";
    $result = $c->query($sql);
    $gb4 = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $gb4 = $row["4GB"];
        }
    }
    $sql = "SELECT COUNT(*) as 8GB FROM Host WHERE memoria = '8GB';";
    $result = $c->query($sql);
    $gb8 = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $gb8 = $row["8GB"];
        }
    }
    $sql = "SELECT COUNT(*) as 12GB FROM Host WHERE memoria = '12GB';";
    $result = $c->query($sql);
    $gb12 = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $gb12 = $row["12GB"];
        }
    }
    $sql = "SELECT COUNT(*) as 16GB FROM Host WHERE memoria = '16GB';";
    $result = $c->query($sql);
    $gb16 = 0;
    if ($result && mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $gb16 = $row["16GB"];
        }
    }

    $ano = date('Y');
    $anoInicio = 2020;
    ?>
    <table cellpadding='7' cellspacing='0'>
        <tr>
            <td>
                <table cellpadding='7' cellspacing='0' border='1'>
                    <tr><td>Servidores: </td><td><b><?= $totalServidor ?></b></td><td rowspan='3'><b><?= ($totalServidor + $totalComputador + $totalNotebook) ?></b></td></tr>
                    <tr><td>Computadores: </td><td><b><?= $totalComputador ?></b></td></tr>
                    <tr><td>Notebooks: </td><td><b><?= $totalNotebook ?></b></td></tr>
                    <tr><td>Telefones VoIPs</td><td><b><?= $totalVoips ?></b></td></tr>
                    <tr><td>Impressoras de rede: </td><td><b><?= $totalImpressora ?></b></td></tr>
                    <tr><td>Nanostations: </td><td><b><?= $totalNanostations ?></b></td></tr>
                    <tr><td>Roteadores/Switchs: </td><td><b><?= $totalSwitchs ?></b></td></tr>
                </table>
            </td><td>
                <table cellpadding='7' cellspacing='0' border='1'>
                    <tr><td>1GB: </td><td><b><?= $gb1 ?></b></td></tr>
                    <tr><td>2GB: </td><td><b><?= $gb2 ?></b></td></tr>
                    <tr><td>4GB: </td><td><b><?= $gb4 ?></b></td></tr>
                    <tr><td>8GB: </td><td><b><?= $gb8 ?></b></td></tr>
                    <tr><td>12GB: </td><td><b><?= $gb12 ?></b></td></tr>
                    <tr><td>16GB: </td><td><b><?= $gb16 ?></b></td></tr>
                </table>
            </td><td>
                <table cellpadding='7' cellspacing='0' border='1'>
                    <tr><td>DDR: </td><td><b><?= $ddr ?></b></td></tr>
                    <tr><td>DDR2: </td><td><b><?= $ddr2 ?></b></td></tr>
                    <tr><td>DDR3: </td><td><b><?= $ddr3 ?></b></td></tr>
                    <tr><td>DDR4: </td><td><b><?= $ddr4 ?></b></td></tr>
                </table>
            </td><td>
                <table cellpadding='7' cellspacing='0' border='1'>
                    <tr><td>HD IDE: </td><td><b><?= $ide ?></b></td></tr>
                    <tr><td>HD SATA: </td><td><b><?= $sata ?></b></td></tr>
                    <tr><td>SSD: </td><td><b><?= $ssd ?></b></td></tr>
                </table>
            </td><td>
                <table cellpadding='7' cellspacing='0' border='1'>
                    <?= $total = $totalServidor + $totalComputador + $totalNotebook; ?>
                    <tr><td>Linux: </td><td><b><?= $totalLinux ?></b></td><td><?= ($total > 0 ? round((($totalLinux / $total) * 100), 2) : 0) ?>%</td></tr>
                    <tr><td>Windows: </td><td><b><?= $totalWindows ?></b></td><td><?= ($total > 0 ? round((($totalWindows / $total) * 100), 2) : 0) ?>%</td></tr>
                </table>
            </td>
            <td>
                <table cellpadding='7' cellspacing='0' border='1'>
                    <tr><td>Total de Ordens de Serviço: </td><td><b><?= $totalOS ?></b></td></tr>
                    <tr><td>Média diária: </td><td><b><?= round($totalOS / (($ano - $anoInicio) * 250), 2) ?></b></td></tr> <!-- 500 dias úteis -->
                    <tr><td>Média mensal: </td><td><b><?= round($totalOS / (($ano - $anoInicio) * 12), 2) ?></b></td></tr>
                </table>
            </td>
        </tr>
    </table>
    <hr>
    <?php
    $sql = "SELECT COUNT(*) as ids FROM OrdemServico;";
    $resultTotal = $c->query($sql);

    $sql = "SELECT COUNT(*) as ids FROM OrdemServico WHERE "
            . "titulo LIKE '%Rede%' OR "
            . "titulo LIKE '%Internet%' OR "
            . "titulo LIKE '%Intranet%' OR "
            . "titulo LIKE '%EBNET%' OR "
            . "titulo LIKE '%IP%' OR "
            . "titulo LIKE '%Servidor%';";
    $resultRede = $c->query($sql);

    $sql = "SELECT COUNT(*) as ids FROM OrdemServico WHERE "
            . "titulo LIKE '%Computador%' OR "
            . "titulo LIKE '%PC%' OR "
            . "titulo LIKE '%Formata%' OR "
            . "titulo LIKE '%quina%';";
    $resultPC = $c->query($sql);

    $sql = "SELECT COUNT(*) as ids FROM OrdemServico WHERE "
            . "titulo LIKE '%Impressora%' OR "
            . "titulo LIKE '%Imprim%'";
    $resultImpressora = $c->query($sql);

    $sql = "SELECT COUNT(*) as ids FROM OrdemServico WHERE "
            . "titulo LIKE '%SisBol%' OR "
            . "titulo LIKE '%SISCOFIS%' OR "
            . "titulo LIKE '%SIMATEX%' OR "
            . "titulo LIKE '%Programa%' OR "
            . "titulo LIKE '%Sped%'";
    $resultSped = $c->query($sql);

    $sql = "SELECT COUNT(*) as ids FROM OrdemServico WHERE "
            . "titulo LIKE '%VoIP%' OR "
            . "titulo LIKE '%Telefone%'";
    $resultVoIP = $c->query($sql);

    echo "<table cellpadding='0' cellspacing='0'>";
    ?>
    <?php
    if ($resultTotal && mysqli_num_rows($resultTotal)) {
        while ($row = $resultTotal->fetch_assoc()) {
            $numTotal = $row["ids"];
        }
    }

    if ($resultRede && mysqli_num_rows($resultRede)) {
        while ($row = $resultRede->fetch_assoc()) {
            $numRede = $row["ids"];
        }
    }

    if ($resultPC && mysqli_num_rows($resultPC)) {
        while ($row = $resultPC->fetch_assoc()) {
            $numPC = $row["ids"];
        }
    }

    if ($resultImpressora && mysqli_num_rows($resultImpressora)) {
        while ($row = $resultImpressora->fetch_assoc()) {
            $numImpressora = $row["ids"];
        }
    }

    if ($resultSped && mysqli_num_rows($resultSped)) {
        while ($row = $resultSped->fetch_assoc()) {
            $numSped = $row["ids"];
        }
    }

    if ($resultVoIP && mysqli_num_rows($resultVoIP)) {
        while ($row = $resultVoIP->fetch_assoc()) {
            $numVoIP = $row["ids"];
        }
    }

    echo "<tbody>";
    $rowClass = "table-light";
    echo "<tr class='$rowClass'>";
    echo "<td><div id='piechart'></div></td>";
    echo "<td valign='middle'><table class='graphList' cellspacing='0' cellpadding='0'>";
    echo "<tr><td>Rede/Internet: </td><td><b>$numRede</b></td></tr>";
    echo "<tr><td>Computador: </td><td><b>$numPC</b></td></tr>";
    echo "<tr><td>Impressora: </td><td><b>$numImpressora</b></td></tr>";
    echo "<tr><td>Sped/SisBol/SISCOFIS e outros: </td><td><b>$numSped</b></td></tr>";
    echo "<tr><td>Telefone VoIP: </td><td><b>$numVoIP</b></td></tr>";
    echo "<tr><td>Total: </td><td><b>$numTotal</b></td></tr>";
    echo "</table></td>";
    ?>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['2BECmb', ''],
                ['Rede/Internet', <?= $numRede ?>],
                ['Computador', <?= $numPC ?>],
                ['Impressora', <?= $numImpressora ?>],
                ['Sped/SisBol/SISCOFIS e outros', <?= $numSped ?>],
                ['VoIP', <?= $numVoIP ?>]
            ]);

            // Optional; add a title and set the width and height of the chart
            var options = {'title': 'Gráfico de Solicitações da SecInfo', 'width': 400, 'height': 300};

            // Display the chart inside the <div> element with id="piechart"
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
    <?php
/////////////////////// TOTAL ///////////////////////////////////
    $sql = "SELECT SUM(quantidade) as ids FROM Inventario;";
    $resultTotal = $c->query($sql);

    if ($resultTotal && mysqli_num_rows($resultTotal)) {
        while ($row = $resultTotal->fetch_assoc()) {
            $numTotal = $row["ids"];
        }
    }

/////////////////////// PLACA-MÃE ///////////////////////////////////
    $possiveis = "equipamento LIKE '%Motherboard%' OR "
            . "equipamento LIKE '%Placa mae%' OR "
            . "equipamento LIKE '%Placa-mae%' OR "
            . "equipamento LIKE '%Placa mãe%' OR "
            . "equipamento LIKE '%Placa-mãe%';";

    $sql = "SELECT SUM(quantidade) as ids FROM Inventario WHERE " . $possiveis;
    $resultPlacaMae = $c->query($sql);

    $sql = "SELECT COUNT(*) as ids "
            . "FROM OrdemServico "
            . "INNER JOIN OrdemServico_has_Inventario ON OrdemServico_idOrdemServico = idOrdemServico "
            . "INNER JOIN Inventario ON idInventario = Inventario_idInventario "
            . "WHERE " . $possiveis;
    $resultUsosPlacaMae = $c->query($sql);

    if ($resultPlacaMae && mysqli_num_rows($resultPlacaMae)) {
        while ($row = $resultPlacaMae->fetch_assoc()) {
            $numPlacaMae = $row["ids"];
        }
    }

    if ($resultUsosPlacaMae && mysqli_num_rows($resultUsosPlacaMae)) {
        while ($row = $resultUsosPlacaMae->fetch_assoc()) {
            $numUsosPlacaMae = $row["ids"];
        }
    }

/////////////////////// PROCESSADOR ///////////////////////////////////
    $possiveis = "equipamento LIKE '%CPU%' OR "
            . "equipamento LIKE '%Processador%';";
    $sql = "SELECT SUM(quantidade) as ids FROM Inventario WHERE " . $possiveis;
    $resultProcessador = $c->query($sql);

    $sql = "SELECT COUNT(*) as ids "
            . "FROM OrdemServico "
            . "INNER JOIN OrdemServico_has_Inventario ON OrdemServico_idOrdemServico = idOrdemServico "
            . "INNER JOIN Inventario ON idInventario = Inventario_idInventario "
            . "WHERE " . $possiveis;
    $resultUsosProcessador = $c->query($sql);

    if ($resultProcessador && mysqli_num_rows($resultProcessador)) {
        while ($row = $resultProcessador->fetch_assoc()) {
            $numProcessador = $row["ids"];
        }
    }

    if ($resultUsosProcessador && mysqli_num_rows($resultUsosProcessador)) {
        while ($row = $resultUsosProcessador->fetch_assoc()) {
            $numUsosProcessador = $row["ids"];
        }
    }

/////////////////////// MEMÓRIA RAM ///////////////////////////////////
    $possiveis = "equipamento LIKE '%Memoria%' OR "
            . "equipamento LIKE '%Memória%';";
    $sql = "SELECT SUM(quantidade) as ids FROM Inventario WHERE " . $possiveis;
    $resultMemoria = $c->query($sql);

    $sql = "SELECT COUNT(*) as ids "
            . "FROM OrdemServico "
            . "INNER JOIN OrdemServico_has_Inventario ON OrdemServico_idOrdemServico = idOrdemServico "
            . "INNER JOIN Inventario ON idInventario = Inventario_idInventario "
            . "WHERE " . $possiveis;
    $resultUsosMemoria = $c->query($sql);

    if ($resultMemoria && mysqli_num_rows($resultMemoria)) {
        while ($row = $resultMemoria->fetch_assoc()) {
            $numMemoria = $row["ids"];
        }
    }

    if ($resultUsosMemoria && mysqli_num_rows($resultUsosMemoria)) {
        while ($row = $resultUsosMemoria->fetch_assoc()) {
            $numUsosMemoria = $row["ids"];
        }
    }

/////////////////////// DISCO RÍGIDO ///////////////////////////////////
    $possiveis = "equipamento LIKE '%Disco Rigido%' OR "
            . "equipamento LIKE '%Disco-Rigido%' OR "
            . "equipamento LIKE '%Disco Rígido%' OR "
            . "equipamento LIKE '%Disco-Rígido%' OR "
            . "equipamento LIKE '%Hard Disk%' OR "
            . "equipamento LIKE '%Hard-Disk%' OR "
            . "equipamento LIKE '%SSD%' OR "
            . "equipamento LIKE '%HD%';";
    $sql = "SELECT SUM(quantidade) as ids FROM Inventario WHERE " . $possiveis;
    $resultHD = $c->query($sql);

    $sql = "SELECT COUNT(*) as ids "
            . "FROM OrdemServico "
            . "INNER JOIN OrdemServico_has_Inventario ON OrdemServico_idOrdemServico = idOrdemServico "
            . "INNER JOIN Inventario ON idInventario = Inventario_idInventario "
            . "WHERE " . $possiveis;
    $resultUsosHD = $c->query($sql);

    if ($resultHD && mysqli_num_rows($resultHD)) {
        while ($row = $resultHD->fetch_assoc()) {
            $numHD = $row["ids"];
        }
    }

    if ($resultUsosHD && mysqli_num_rows($resultUsosHD)) {
        while ($row = $resultUsosHD->fetch_assoc()) {
            $numUsosHD = $row["ids"];
        }
    }

/////////////////////// FONTE ///////////////////////////////////
    $possiveis = "equipamento LIKE '%Fonte%';";
    $sql = "SELECT SUM(quantidade) as ids FROM Inventario WHERE " . $possiveis;
    $resultFonte = $c->query($sql);

    $sql = "SELECT COUNT(*) as ids "
            . "FROM OrdemServico "
            . "INNER JOIN OrdemServico_has_Inventario ON OrdemServico_idOrdemServico = idOrdemServico "
            . "INNER JOIN Inventario ON idInventario = Inventario_idInventario "
            . "WHERE " . $possiveis;
    $resultUsosFonte = $c->query($sql);

    if ($resultFonte && mysqli_num_rows($resultFonte)) {
        while ($row = $resultFonte->fetch_assoc()) {
            $numFonte = $row["ids"];
        }
    }

    if ($resultUsosFonte && mysqli_num_rows($resultUsosFonte)) {
        while ($row = $resultUsosFonte->fetch_assoc()) {
            $numUsosFonte = $row["ids"];
        }
    }

    echo "<td><div id='dual_x_div' style='margin-left: 25px; width: 520px; height: 250px;'></div></td>";
    echo "<td valign='middle'><table class='graphList' cellpadding='7'>";
    echo "<tr><td>Placa-mãe: </td><td><b>$numUsosPlacaMae / $numPlacaMae</b></td></tr>";
    echo "<tr><td>Processador: </td><td><b>$numUsosProcessador / $numProcessador</b></td></tr>";
    echo "<tr><td>Memória RAM: </td><td><b>$numUsosMemoria / $numMemoria</b></td></tr>";
    echo "<tr><td>Disco Rígido: </td><td><b>$numUsosHD / $numHD</b></td></tr>";
    echo "<tr><td>Fonte ATX: </td><td><b>$numUsosFonte / $numFonte</b></td></tr>";
    echo "<tr><td>Total: </td><td><b>$numTotal</b></td></tr>";
    echo "</table></td>";
    echo "</tr>";
    ?>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['bar']});
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Inventário', 'Quantidade', 'Aplicações'],
                ['Placa-mãe', <?= $numPlacaMae ?>, <?= $numUsosPlacaMae ?>],
                ['Processador', <?= $numProcessador ?>, <?= $numUsosProcessador ?>],
                ['Memória RAM', <?= $numMemoria ?>, <?= $numUsosMemoria ?>],
                ['Disco Rígido', <?= $numHD ?>, <?= $numUsosHD ?>],
                ['Fonte', <?= $numFonte ?>, <?= $numUsosFonte ?>]
            ]);

            var options = {
                width: 500,
                chart: {
                    title: 'Inventário',
                    subtitle: 'Quantidade x Aplicações'
                },
                bars: 'horizontal', // Required for Material Bar Charts.                        
            };

            var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
            chart.draw(data, options);
        }
        ;
    </script>
    <?php
    echo "</tbody>";
    echo "</table>";

    $c->close();
}
?>
<!------------------------------------------------>
<?php require_once '../include/footer.php'; ?>