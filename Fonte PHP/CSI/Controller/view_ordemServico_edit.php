<?php
require_once '../include/comum.php';
$equipamento = isset($_GET["equipamentos"]) ? $_GET["equipamentos"] : "";
if (!isAdminLevel($NIVEL_OS_EDIT)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/conexao.php'; ?>
    <?php require_once '../include/header.php'; ?>
    <!------------------------------------------------>
    <?php
    $c = connect();
    $id = filter_input(INPUT_GET, "id");
    $sql = "SELECT *,idOrdemServico,titulo,descricao,data,prazo,prioridade,status,responsavel,Status_idStatus,Prioridade_idPrioridade,Usuario_idUsuario,OrdemServico.ordem "
            . "FROM OrdemServico "
            . "INNER JOIN Status on Status_idStatus = idStatus "
            . "INNER JOIN Prioridade on Prioridade_idPrioridade = idPrioridade "
            . "WHERE idOrdemServico = $id;";
    $result = $c->query($sql);

    if ($result->num_rows > 0) {
        $rowClass = "table-primary";

        while ($row = $result->fetch_assoc()) {
            $id = $row["idOrdemServico"];
            $titulo = $row["titulo"];
            $descricao = $row["descricao"];
            $data = $row["data"];
            $prazo = $row["prazo"];
            $prioridade = $row["Prioridade_idPrioridade"];
            $status = $row["Status_idStatus"];
            $responsavel = $row["responsavel"];
            $idSecao = $row["Secao_idSecao"];
//            $responsavelArray = explode(" / ", $responsavel);            
//            $secao = $responsavelArray[0];
//            $postoArray = explode(" ", $responsavelArray[1]);
//            $posto = $postoArray[0];
//            $responsavel = $postoArray[1];
            $usuario = $row["Usuario_idUsuario"];
            $ordem = $row["ordem"];
            $idEquipamento = $row["Equipamento_idEquipamento"];

//            if (count($postoArray > 2)) {
//                $responsavel .= " " . $postoArray[2];
//
//                if (count($postoArray > 3)) {
//                    $responsavel .= " " . $postoArray[3];
//                }
//            }
        }
    }

//$c->close();
    ?>   
    <div style="margin: 25px; padding: 25px; border: 1px solid blue;">
        <form action="sql_ordemServico_edit.php?equipamentos=<?= $equipamento ?>" method="POST">
            <input type="hidden" class="form-control" id="idOrdemServico" name="idOrdemServico" value="<?= $id ?>">
            <table border="0" cellspacing="7" cellpadding="7">
                <tr>
                    <td>
                        <select class="form-control" id="ordem" name="ordem">
                            <option disabled>ORDEM</option>
                            <?php
                            for ($i = 1; $i <= 100; $i++) {
                                $selected = $ordem == $i ? " selected" : "";
                                echo "<option value='$i' $selected>" . $i . "</option>";
                            }
                            ?>
                        </select>
                    </td>   
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td> 
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $titulo ?>" placeholder="SOLICITAÇÃO" size="70" required="required" <?= $idEquipamento > 0 ? "readonly" : "" ?>>
                    </td>            
                    <td rowspan="2" valign="top">   
                        <select class="form-control" id="secao" name="secao" size="17" style="width: 170px;" required="required" <?= $idEquipamento > 0 ? "readonly" : "" ?>>
                            <option selected disabled>Seção</option>
                            <?php
                            //$c = connect();
                            $sql = "SELECT idSecao,secao "
                                    . "FROM Secao "
                                    . "ORDER BY secao";
                            $result = $c->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["idSecao"] . "' " . ($idSecao == $row["idSecao"] ? "selected" : "") . ">" . $row["secao"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="responsavel" name="responsavel" value="<?= $responsavel ?>" placeholder="RESPONSÁVEL" size="25" <?= $idEquipamento > 0 ? "readonly" : "" ?>>                 
                    </td>
                </tr>
                <tr>
                    <td valign="top">                    
                        <label for="descricao">Descricao:</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="7" <?= $idEquipamento > 0 ? "readonly" : "" ?>><?= $descricao ?></textarea>
                    </td>
                    <td>
    <!--                        <select class="form-control" id="posto" name="posto" size="14" style="width: 250px;">
                            <option selected disabled>Posto</option>
                            <option value='Sd' <?= $posto == "Sd" ? "selected" : "" ?>>Sd</option>
                            <option value='Cb' <?= $posto == "Cb" ? "selected" : "" ?>>Cb</option>
                            <option value='Sgt' <?= $posto == "Sgt" ? "selected" : "" ?>>Sgt</option>
                            <option value='S Ten' <?= $posto == "S Ten" ? "selected" : "" ?>>S Ten</option>
                            <option value='Asp' <?= $posto == "Asp" ? "selected" : "" ?>>Asp</option>
                            <option value='Ten' <?= $posto == "Ten" ? "selected" : "" ?>>Ten</option>
                            <option value='Cap' <?= $posto == "Cap" ? "selected" : "" ?>>Cap</option>
                            <option value='Maj' <?= $posto == "Maj" ? "selected" : "" ?>>Maj</option>
                            <option value='TC' <?= $posto == "TC" ? "selected" : "" ?>>TC</option>
                            <option value='Cel' <?= $posto == "Cel" ? "selected" : "" ?>>Cel</option>
                            <option value='Gen' <?= $posto == "Gen" ? "selected" : "" ?>>Gen</option>
                            <option value=' ' <?= $posto == " " ? "selected" : "" ?>>Nenhum</option>
                        </select>-->
                    </td>
                </tr>            
                <tr>
                    <td valign="top">
                        <label for="inventario"><b>Inventário aplicado</b></label><br>
                        <?php
                        //$c = connect();
                        $sql = "SELECT id,idInventario,equipamento,date_format(data,'%d/%m/%y') as data, quantidade 
                FROM OrdemServico_has_Inventario 
                INNER JOIN Inventario ON idInventario = Inventario_idInventario
                WHERE OrdemServico_idOrdemServico = $id;";
                        $result = $c->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $remove = "<a href='sql_ordemServico_inventario_remove.php?id=" . $row["id"] . "&idOs=" . $id . "'>Remover</a>";
                                echo "<label>" . $row["equipamento"] . "(" . $row["data"] . " - " . $row["quantidade"] . " unds)</label> $remove<br>";
                            }
                        }

                        //$c->close();
                        ?>
                    </td>
                    <td valign="top" colspan="2">
                        <select class="form-control" id="inventario" name="inventario[]" multiple size="14">
                            <?php
                            //$c = connect();
                            $sql = "SELECT idInventario,equipamento,date_format(data,'%d/%m/%y') as data,quantidade FROM Inventario ";
                            $result = $c->query($sql);
                            echo "<option value='' disabled>Acrescentar Inventário</option>";

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $idInventario = $row["idInventario"];
                                    $equipamento = $row["equipamento"];
                                    $usos = 0;

                                    $sql = "SELECT COUNT(*) as usos "
                                            . "FROM OrdemServico_has_Inventario "
                                            . "WHERE Inventario_idInventario = $idInventario;";
                                    $resultUsos = $c->query($sql);

                                    if ($resultUsos->num_rows > 0) {
                                        while ($rowUsos = $resultUsos->fetch_assoc()) {
                                            $usos = $rowUsos["usos"];
                                        }
                                    }

                                    if ($usos < $row["quantidade"]) {
                                        echo "<option value='$idInventario'>" . $row["equipamento"] . "(" . $row["data"] . " - " . $usos . " / " . $row["quantidade"] . " unds)</option>";
                                    }
                                }
                            }

                            //$c->close();
                            ?>                                     
                        </select><br>
                        <button type="button" class="btn btn-primary" onclick="form.action = 'sql_ordemServico_edit.php?comeback=1&';form.submit()">Aplicar</button>
                    </td>                                  
                </tr>
                <tr>
                    <td>
                        <select class="form-control" id="status" name="status" size="5">
                            <option selected disabled>Status</option>
                            <?php
                            //$c = connect();
                            $sql = "SELECT idStatus,status FROM Status ";
                            $result = $c->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $statusId = $row["idStatus"];
                                    $selected = "";

                                    if ($row["idStatus"] == $status) {
                                        $selected = " selected='selected'";
                                    }

                                    echo "<option value='$statusId'" . $selected . ">" . $row["status"] . "</option>";
                                }
                            }

                            //$c->close();
                            ?>                                     
                        </select>
                    </td>
                    <td colspan="2">                    
                        <select class="form-control" id="prioridade" name="prioridade" size="5">
                            <option selected disabled>Prioridade</option>
                            <?php
                            //$c = connect();
                            $sql = "SELECT idPrioridade,prioridade FROM Prioridade ";
                            $result = $c->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $prioridadeId = $row["idPrioridade"];
                                    $selected = "";

                                    if ($row["idPrioridade"] == $prioridade) {
                                        $selected = " selected='selected'";
                                    }

                                    echo "<option value='$prioridadeId'" . $selected . ">" . $row["prioridade"] . "</option>";
                                }
                            }

                            //$c->close();
                            ?>                  
                        </select>
                    </td>            
                </tr>
                <tr>
                    <td>
                        <select class="form-control" id="usuario" name="usuario" size="5">
                            <option selected disabled>Responsável pela solução da tarefa</option>
                            <?php
                            //$c = connect();
                            $sql = "SELECT idUsuario,login FROM Usuario WHERE nivel > 0";
                            $result = $c->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $usuarioId = $row["idUsuario"];
                                    $selected = "";

                                    if ($row["idUsuario"] == $usuario) {
                                        $selected = " selected='selected'";
                                    }

                                    echo "<option value='$usuarioId'" . $selected . ">" . $row["login"] . "</option>";
                                }
                            }

                            $c->close();
                            ?>                  
                        </select>
                    </td>
                    <td colspan="2">&nbsp;</td>                
                </tr>
                <tr>
                    <td><button type="submit" class="btn btn-primary">Salvar</button></td>
                    <td colspan="2">&nbsp;</td>                
                </tr>
            </table>                                                   
        </form> 
    </div>
    <!------------------------------------------------>
<?php } ?>
<?php require_once '../include/footer.php'; ?>