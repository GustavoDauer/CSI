<?php
require_once '../include/header.php';
$permission = filter_input(INPUT_GET, "permission");
?>
<!------------------------------------------------>
<?php if ($permission == 1) { ?>
    <h2 style="font-size: 14px; font-family: sans-serif; color: red; margin: 7px; text-align: center;">Você não possui permissões para executar esta ação!</h2>
<?php } ?>
<div align="center">
    <div style="padding: 25px;">
        <form action="sql_login.php" method="POST">
            <div class="form-group">                
                <input type="text" class="form-control" placeholder="LOGIN" id="login" name="login">
            </div>
            <div class="form-group">                
                <input type="password" class="form-control" placeholder="SENHA" id="senha" name="senha">
            </div>            
            <button type="submit" class="btn btn-primary">Login</button>
        </form> 
    </div>
</div>
<?php require_once '../include/footer.php'; ?>