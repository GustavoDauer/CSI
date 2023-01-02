<?php
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_USUARIO_ADD)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/header.php'; ?>
    <!------------------------------------------------>
    <div style="margin: 25px; padding: 25px; width: 520px; border: 1px solid blue;">
        <form action="sql_usuario_add.php" method="POST">
            <div class="form-group">            
                <input type="text" class="form-control" id="login" name="login" placeholder="LOGIN">
            </div>
            <div class="form-group">            
                <input type="text" class="form-control" id="nome" name="nome" placeholder="NOME">
            </div>
            <div class="form-group">            
                <input type="password" class="form-control" id="senha" name="senha" placeholder="SENHA">
            </div>                
            <div class="form-group">
                <label for="nivel">Nível:</label>
                <select class="form-control" id="nivel" name="nivel">
                    <option value='0'>Desabilitado</option>
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo "<option value='$i'>" . $i . "</option>";
                    }
                    ?>                       
                </select>
            </div>                         
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form> 
    </div>
    <!------------------------------------------------>
<?php } ?>
<?php require_once '../include/footer.php'; ?>