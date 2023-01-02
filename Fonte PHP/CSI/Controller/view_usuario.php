<?php
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_USUARIO_LIST)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/conexao.php'; ?>
    <?php require_once '../include/header.php'; ?>        
    <!------------------------------------------------>
    <?php
    $c = connect();
    $sql = "SELECT idUsuario,login,nivel "
            . "FROM Usuario ORDER BY nivel DESC;";
    $result = $c->query($sql);
    $add = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'view_usuario_add.php'" . '"' . ">Adicionar</button>";
    $edit = "";
    $delete = "";

    if (isLoggedIn()) {
        echo "<div style='padding-top: 7px; text-align: right'>$add</div>";
    }

    if ($result->num_rows > 0) {
        echo "<hr>";
        echo "<h2 style='font-size: 20px; color: darkblue'>Usuário</h2>";
        echo "<table class = 'table table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Login</th>";
        echo "<th>Nível</th>";
        echo "<th>&nbsp;</th>";
        echo "<th>&nbsp;</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $rowClass = "table-primary";

        while ($row = $result->fetch_assoc()) {
            $id = $row["idUsuario"];
            $login = $row["login"];
            $nivel = $row["nivel"] == 0 ? $row["nivel"] . " (Desabilitado)" : $row["nivel"];

            echo "<tr class='$rowClass'>";
            echo "<td>$login</td>";
            echo "<td>$nivel</td>";

            if (isLoggedIn()) {
                $edit = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'view_usuario_edit.php?id=$id'" . '">Editar</button>';
                $delete = "<button type='submit' class='btn btn-primary' onclick=" . '"document.location=' . "'sql_usuario_remove.php?id=$id'" . '">Remover</button>';
            }

            echo "<td>" . $edit . "</td>";
            echo "<td>" . $delete . "</td>";
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