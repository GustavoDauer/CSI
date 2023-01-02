<?php
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_INVENTARIO_ADD)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/header.php'; ?>
    <!------------------------------------------------>
    <div style="margin: 25px; padding: 25px; width: 520px; border: 1px solid blue;">
        <form action="sql_inventario_add.php" method="POST">
            <div class="form-group">            
                <input type="text" class="form-control" id="equipamento" name="equipamento" placeholder="Equipamento">
            </div>
            <div class="form-group">            
                <textarea class="form-control" id="especificacao" name="especificacao" placeholder="Especificação"></textarea>
            </div>                
            <div class="form-group">
                <label for="prioridade">Quantidade:</label>
                <select class="form-control" id="quantidade" name="quantidade" size="8">
                    <?php
                    for ($i = 0; $i <= 250; $i++) {
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