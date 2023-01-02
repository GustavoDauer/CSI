<?php
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_INVENTARIO_LIST)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/conexao.php'; ?>
    <?php require_once '../include/header.php'; ?>
    
    <!------------------------------------------------>
    <?php
    $c = connect();
    $sql = "SELECT idInventario,equipamento,especificacao,quantidade,date_format(data,'%d/%m/%y') as data, COUNT(Inventario_idInventario) as usos "
            . "FROM Inventario "
            . "LEFT JOIN OrdemServico_has_Inventario ON Inventario_idInventario = idInventario "
            . "GROUP BY idInventario "
            . "HAVING usos != quantidade "
            . "ORDER BY data DESC;";
    $result = $c->query($sql);
    $add = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'view_inventario_add.php'" . '"' . ">Adicionar</button>";
    $edit = "";
    $delete = "";

    if (isLoggedIn()) {
        echo "<div style='padding-top: 7px; text-align: right'>$add</div>";
    }

    if ($result->num_rows > 0) {
        echo "<hr>";
        echo "<h2 style='font-size: 20px; color: darkblue'>Inventário disponível</h2>";
        echo "<table class = 'table table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Data</th>";
        echo "<th>Equipamento</th>";
        echo "<th>Especificação</th>";
        echo "<th>Usos/Quantidade</th>";
        echo "<th>&nbsp;</th>";
        echo "<th>&nbsp;</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $rowClass = "table-primary";

        while ($row = $result->fetch_assoc()) {
            $id = $row["idInventario"];
            $usos = $row["usos"];
            $quantidade = $row["quantidade"];
            $total = $quantidade - $usos;

            if ($usos >= floor($quantidade * 0.8)) {
                $rowClass = "table-warning";
                $aviso = "(superou 80% do total)";
            } else if ($total <= 0) {
                $rowClass = "table-danger";
                $aviso = "";
            } else {
                $aviso = "";
            }

            echo "<tr class='$rowClass'>";
            echo "<td>" . $row["data"] . "</td>";
            echo "<td>" . $row["equipamento"] . "</td>";
            echo "<td>" . $row["especificacao"] . "</td>";
            echo "<td>" . $usos . " / " . $row["quantidade"] . " $aviso</td>";

            if (isLoggedIn()) {
                $aplicacoes = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'view_inventario_aplicacoes.php?id=$id'" . '">Aplicações</button>';
                $edit = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'view_inventario_edit.php?id=$id'" . '">Editar</button>';
                //$delete = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'sql_remove_inventario.php?id=$id'" . '">Remover</button>';            
            }

            echo "<td>" . $edit . "</td>";
            echo "<td>" . $aplicacoes . "</td>";
            //echo "<td>" . $delete . "</td>";
            echo "</tr>";

            $rowClass = $rowClass == "table-primary" ? "table-secondary" : "table-primary";
        }
    }

    echo "</tbody>";
    echo "</table>";

    $sql = "SELECT idInventario,equipamento,especificacao,quantidade,date_format(data,'%d/%m/%y') as data, COUNT(Inventario_idInventario) as usos "
            . "FROM Inventario "
            . "LEFT JOIN OrdemServico_has_Inventario ON Inventario_idInventario = idInventario "
            . "GROUP BY idInventario "
            . "HAVING usos = quantidade "
            . "ORDER BY data DESC;";
    $result = $c->query($sql);

    if ($result->num_rows > 0) {
        echo "<hr>";
        echo "<h2 style='font-size: 20px; color: darkblue'>Inventário encerrado</h2>";
        echo "<table class = 'table table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Data</th>";
        echo "<th>Equipamento</th>";
        echo "<th>Especificação</th>";
        echo "<th>Usos/Quantidade</th>";
        echo "<th>&nbsp;</th>";
        echo "<th>&nbsp;</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $rowClass = "table-primary";

        while ($row = $result->fetch_assoc()) {
            $id = $row["idInventario"];
            $usos = $row["usos"];
            $quantidade = $row["quantidade"];
            $total = $quantidade - $usos;
            $rowClass = "table-danger";
            echo "<tr class='$rowClass'>";
            echo "<td>" . $row["data"] . "</td>";
            echo "<td>" . $row["equipamento"] . "</td>";
            echo "<td>" . $row["especificacao"] . "</td>";
            echo "<td>" . $usos . " / " . $row["quantidade"] . "</td>";

            if (isLoggedIn()) {
                $aplicacoes = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'view_inventario_aplicacoes.php?id=$id'" . '">Aplicações</button>';
                $edit = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'view_inventario_edit.php?id=$id'" . '">Editar</button>';
                //$delete = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'sql_remove_inventario.php?id=$id'" . '">Remover</button>';            
            }

            echo "<td>" . $edit . "</td>";
            echo "<td>" . $aplicacoes . "</td>";
            echo "</tr>";

            $rowClass = $rowClass == "table-primary" ? "table-secondary" : "table-primary";
        }
    }

    echo "</tbody>";
    echo "</table>";

    $c->close();
    ?>
    </div>
    <!------------------------------------------------>
<?php } ?>
<?php require_once '../include/footer.php'; ?>