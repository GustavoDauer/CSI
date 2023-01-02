<?php require_once '../include/comum.php'; ?>
<?php require_once '../include/conexao.php'; ?>
<?php require_once '../include/header.php'; ?>

<!------------------------------------------------>
<style type="text/css">
    .updownbutton {
        width: 20px;
        height: 20px;
        font-size: 10px;
        padding: 0px;
        margin: 0px;
    }
</style>
<?php
$concluido = isset($_GET["concluidas"]) ? $_GET["concluidas"] : "";
$c = connect();

if ($concluido != "1") {
    $sqlStatus = "SELECT status FROM Status WHERE status != 'Concluido' ORDER BY ordem";
} else {
    $sqlStatus = "SELECT status FROM Status WHERE status = 'Concluido' ORDER BY ordem";
}

$resultStatus = $c->query($sqlStatus);
$usuario = filter_input(INPUT_GET, "idUsuario");
$add = "<button type='submit' class='btn btn-primary' style='margin-top: 7px;' onclick=" . '"document.location=' . "'view_ordemServico_add.php'" . '"' . ">Adicionar Ordem de Serviço</button>";

if (isLoggedIn()) {
    ?>    
    <table style='margin-top: 7px;' width='100%'>
        <tr>          
            <td valign='top' style="text-align: right;">
                <ul class="nav nav-tabs" style="margin-top: 7px;">
                    <li class="nav-item">
                        <a class="nav-link <?= substr_count($address, "todas") > 0 ? "active" : ""; ?>" href="view_ordemServico.php?todas">Todas</a>
                    </li>
                    <?php
                    if (isAdminLevel($NIVEL_OS_LIST)) {
                        $sql = "SELECT idUsuario,login,nivel FROM Usuario WHERE nivel <= " . $_SESSION["nivel"] . " AND nivel > 0 ORDER BY nivel";
                        $result = $c->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $usuarioId = $row["idUsuario"];

                                if ($_SESSION["nivel"] >= $row["nivel"]) {
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= substr_count($address, $row["login"]) > 0 ? "active" : ""; ?>" href="view_ordemServico.php?idUsuario=<?= $usuarioId ?>&<?= $row["login"] ?>"><?= $row["login"] ?></a>
                                    </li>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?= substr_count($address, "Null") > 0 ? "active" : ""; ?>" href="view_ordemServico.php?idUsuario=Null">Não atribuídas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= substr_count($address, "concluidas") > 0 ? "active" : ""; ?>" href="view_ordemServico.php?concluidas=1">Concluídas</a>
                        </li>
                        <?php
                    }

                    if ($usuario != "Null") {
                        $filtraUsuario = empty($usuario) ? "" : " AND Usuario_idUsuario = $usuario ";
                    } else {
                        $filtraUsuario = empty($usuario) ? "" : " AND Usuario_idUsuario is Null ";
                    }
                    ?>                    
                </ul>
                <?= $add ?> 
                <button type='submit' class='btn btn-primary' style='margin-top: 7px;' onclick="document.location = 'EquipamentoController.php?action=insert';">Adicionar Equipamento</button>
            </td>
        </tr> 
    </table>
    <?php
}

if ($resultStatus->num_rows > 0) {
    $equipamento = isset($_GET["equipamentos"]) ? $_GET["equipamentos"] : null;
    $filtraEquipamento = $equipamento == 1 ? " AND titulo LIKE '%Fornecimento de%' " : " AND titulo NOT LIKE '%Fornecimento de%' ";
    while ($rowStatus = $resultStatus->fetch_assoc()) {
        $status = $rowStatus["status"];
        $filtraUsuario = isset($filtraUsuario) ? $filtraUsuario : "";
        $filtraEquipamento = isset($filtraEquipamento) ? $filtraEquipamento : "";
        $sql = "SELECT *, OrdemServico.responsavel as responsavel, date_format(data,'%d/%m/%y') as data,OrdemServico.ordem "
                . "FROM OrdemServico "
                . "INNER JOIN Status on Status_idStatus = idStatus "
                . "INNER JOIN Prioridade on Prioridade_idPrioridade = idPrioridade "
                . "LEFT JOIN Equipamento ON Equipamento_idEquipamento = idEquipamento "
                . "LEFT JOIN Secao ON Secao_idSecao = idSecao "
                . "WHERE status = '$status' $filtraUsuario $filtraEquipamento"
                . "ORDER BY prioridade DESC, OrdemServico.ordem;";
        $result = $c->query($sql);
        $edit = "";
        $delete = "";

        if (isset($result->num_rows) && $result->num_rows > 0) {
            echo "<hr>";
            echo "<h2 style='font-size: 20px; color: darkblue'>$status</h2>";
            echo "<table class = 'table table-hover' border='1'>";
            echo "<thead>";
            echo "<tr>";
            if (isLoggedIn()) {
                echo "<th>ID</th>";
                echo "<th>Data</th>";
            }
            echo "<th>Ordem</th>";
            echo "<th>Seção/Usuário</th>";
            echo "<th>Solicitação</th>";
            echo "<th>Prioridade</th>";
            echo "<th>&nbsp;</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $rowClass = "table-primary";

            while ($row = $result->fetch_assoc()) {
                $idPrioridade = $row["Prioridade_idPrioridade"];
                switch ($idPrioridade) {
                    case 1: $rowClass = "table-success";
                        break;
                    case 2: $rowClass = "table-info";
                        break;
                    case 3: $rowClass = "table-warning";
                        break;
                    case 4: $rowClass = "table-danger";
                        break;
                }

                $idStatus = $row["Status_idStatus"];

                switch ($idStatus) {
                    case 1: break;
                    case 2: break; //$rowClass = "table-warning";
                        break;
                    case 3: $rowClass = "table-secondary";
                        break;
                    case 4: $rowClass = "table-dark";
                        break;
                }

                echo "<tr class='$rowClass'>";
                if (isLoggedIn()) {
                    echo "<td>#" . $row["idOrdemServico"] . "</td>";
                    echo "<td>" . $row["data"] . "</td>";
                }
                echo "<td><a name='" . $row["idOrdemServico"] . "'></a>";
                if (isLoggedIn()) {
                    echo "<a href='sql_ordemServico_ordem_edit.php?id=" . $row["idOrdemServico"] . "&ordem=" . ($row["ordem"] - 1) . "&equipamentos=$equipamento'> - </a>";
                }
                echo $row["ordem"];
                if (isLoggedIn()) {
                    echo "<a href='sql_ordemServico_ordem_edit.php?id=" . $row["idOrdemServico"] . "&ordem=" . ($row["ordem"] + 1) . "&equipamentos=$equipamento'> + </a>";
                }
                echo "</td>";
                echo "<td>" . $row["secao"] . " / " . $row["responsavel"] . "</td>";
                echo "<td>";
                echo!empty($row["idEquipamento"]) ? "<a href='EquipamentoController.php?action=visualize&id=" . $row["idEquipamento"] . "'  target='_blank'>" : "";
                echo $row["titulo"];
                echo!empty($row["idEquipamento"]) ? "</a></td>" : "";
                echo "<td>" . $row["prioridade"] . "</td>";
                $id = $row["idOrdemServico"];
                if (isLoggedIn()) {
                    $edit = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'view_ordemServico_edit.php?id=$id&equipamentos=$equipamento'" . '">Editar</button>';
//$delete = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'sql_remove_ordemServico.php?id=$id'" . '">Remover</button>';
                }
                echo "<td>" . $edit . "</td>";
//echo "<td>" . $delete . "</td>";
                echo "</tr>";

                $rowClass = $rowClass == "table-primary" ? "table-secondary" : "table-primary";
            }

            echo "</tbody>";
            echo "</table>";
        }
    }
}

$c->close();
?>
</div>
<!------------------------------------------------>
<?php require_once '../include/footer.php'; ?>