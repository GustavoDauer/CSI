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
    $id = filter_input(INPUT_GET, "id");
    $sql = "SELECT idInventario,equipamento,especificacao,quantidade "
            . "FROM Inventario "
            . "WHERE idInventario = $id;";
    $result = $c->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["idInventario"];
            $equipamento = $row["equipamento"];
            $especificacao = $row["especificacao"];
            $quantidade = $row["quantidade"];
        }
    }

    $c->close();
    ?>
    <div style="margin: 25px;">
        <form action="sql_inventario_edit.php" method="POST">
            <input type="hidden" class="form-control" id="idInventario" name="idInventario" value="<?= $id ?>">
            <div class="form-group">
                <label for="equipamento">Equipamento:</label>
                <input type="text" class="form-control" id="equipamento" name="equipamento" value="<?= $equipamento ?>">
            </div>        
            <div class="form-group">
                <label for="especificacao">Especificação:</label>
                <textarea class="form-control" id="especificacao" name="especificacao"><?= $especificacao ?></textarea>
            </div>        
            <div class="form-group">
                <label for="prioridade">Quantidade:</label>
                <select class="form-control" id="prioridade" name="quantidade">
                    <?php
                    for ($i = 0; $i < 100; $i++) {
                        $selected = $quantidade == $i ? " selected" : "";
                        echo "<option value='$i' $selected>" . $i . "</option>";
                    }
                    ?>
                </select>
            </div>                        
            <button type="submit" class="btn btn-primary">Edita</button>
        </form> 
    </div>
    <!------------------------------------------------>
<?php } ?>
<?php require_once '../include/footer.php'; ?>