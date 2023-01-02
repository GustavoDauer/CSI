<?php
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_INVENTARIO_EDIT)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/conexao.php'; ?>
    <?php require_once '../include/header.php'; ?>
    
    <!------------------------------------------------>
    <?php
    $c = connect();
    $idInventario = filter_input(INPUT_GET, "id");
    $sql = "SELECT idOrdemServico,titulo,date_format(OrdemServico.data,'%d/%m/%y') as data,equipamento,responsavel "
            . "FROM OrdemServico "
            . "INNER JOIN OrdemServico_has_Inventario ON OrdemServico_idOrdemServico = idOrdemServico "
            . "INNER JOIN Inventario ON idInventario = Inventario_idInventario "
            . "WHERE Inventario_idInventario = $idInventario";
    $result = $c->query($sql);

    if ($result->num_rows > 0) {
        echo "<hr>";
        echo "<h2 style='font-size: 20px; color: darkblue'>Aplicações</h2>";
        echo "<table class = 'table table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Data</th>";
        echo "<th>Título</th>";
        echo "<th>Equipamento</th>";
        echo "<th>Responsável</th>";
        echo "<th>&nbsp;</th>";
        echo "<th>&nbsp;</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $rowClass = "table-primary";

        while ($row = $result->fetch_assoc()) {
            $idOs = $row["idOrdemServico"];
            $edit = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'view_ordemServico_edit.php?id=$idOs'" . '">Editar</button>';

            echo "<tr class='$rowClass'>";
            echo "<td>" . $row["data"] . "</td>";
            echo "<td>" . $row["titulo"] . "</td>";
            echo "<td>" . $row["equipamento"] . "</td>";
            echo "<td>" . $row["responsavel"] . "</td>";
            echo "<td>" . $edit . "</td>";
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