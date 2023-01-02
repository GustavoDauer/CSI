<?php
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_USUARIO_EDIT)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/conexao.php'; ?>
    <?php require_once '../include/header.php'; ?>
    <!------------------------------------------------>
    <?php
    $c = connect();
    $id = filter_input(INPUT_GET, "id");
    $sql = "SELECT * "
            . "FROM Usuario "
            . "WHERE idUsuario = $id;";
    $result = $c->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["idUsuario"];
            $login = $row["login"];
            $nivel = $row["nivel"];
            $nome = $row["nome"];
        }
    }

    $c->close();
    ?>
    <div style="margin: 25px;">
        <form action="sql_usuario_edit.php" method="POST">
            <input type="hidden" class="form-control" id="idUsuario" name="idUsuario" value="<?= $id ?>">
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" class="form-control" id="login" name="login" value="<?= $login ?>">
            </div>  
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= $nome ?>">
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="NOVA SENHA">
            </div>                
            <div class="form-group">
                <label for="nivel">Nível:</label>
                <select class="form-control" id="nivel" name="nivel">
                    <option value="0" <?= $nivel == 0 ? " selected" : "" ?>>Desabilitado</option>
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        $selected = $nivel == $i ? " selected" : "";
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