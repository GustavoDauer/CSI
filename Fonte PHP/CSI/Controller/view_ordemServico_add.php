<?php
require_once '../include/comum.php';

if (!isAdminLevel($NIVEL_OS_ADD)) {
    getResult(true, "view_login.php?permission=1", "Aguarde...", "Sucesso!", "Erro!", "Falta de permissão ou falha técnica!", 0);
} else {
    ?>
    <?php require_once '../include/conexao.php'; ?>
    <?php require_once '../include/header.php'; ?>
    <!------------------------------------------------>
    <div style="margin: 25px; padding: 25px; border: 1px solid blue;">
        <form action="sql_ordemServico_add.php" method="POST">
            <table border="0" cellspacing="7" cellpadding="7">   
                <tr>
                    <td>
                        <select class="form-control" id="ordem" name="ordem">
                            <option disabled selected>ORDEM</option>
                            <?php
                            for ($i = 1; $i <= 100; $i++) {
                                echo "<option value='$i'>" . $i . "</option>";
                            }
                            ?>
                        </select>
                    </td>   
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="SOLICITAÇÃO" size="70" required="required">
<!--                        <select class="form-control" id="titulo" name="titulo" required>
                            <option selected disabled>SOLICITAÇÃO</option>
                            <option value="Problema crítico no Computador (impeditivo ao uso do PC)">Problema crítico no Computador (impeditivo ao uso do PC)</option>
                            <option value="Problema cosmético no Computador (não impeditivo ao uso do PC)">Problema cosmético no Computador (não impeditivo ao uso do PC)</option>
                            <option value="Problema no acesso à rede de Internet/Intranet">Problema no acesso à rede de Internet/Intranet</option>
                            <option value="Problema no acesso à rede de compartilhamento de arquivos">Problema no acesso à rede de compartilhamento de arquivos</option>
                            <option value="Problema/Configuração relativo à impressora/scanner">Problema relativo à impressora/scanner</option>
                            <option value="Problema no telefone VoIP">Problema no telefone VoIP</option>
                            <option value="Problema no acesso à sistemas internos (Intranet, Sped, SiSBol, MadMax/Controle de Viaturas, Arranchamento, etc)">Problema no acesso à sistemas internos (Intranet, Sped, SiSBol, MadMax/Controle de Viaturas, Arranchamento, etc)</option>
                            <option value="Problema no acesso à sistemas externos">Problema no acesso à sistemas externos</option>
                            <option value="Cabeamento de novo/manutenção ponto de rede">Cabeamento de novo/manutenção ponto de rede</option>
                            <option value="Solicitação de 1x Computador">Solicitação de 1x Computador</option>
                            <option value="Solicitação de 1x Impressora/Scanner">Solicitação de 1x Impressora/Scanner</option>
                            <option value="Solicitação de 1x Mouse">Solicitação de 1x Mouse</option>
                            <option value="Solicitação de 1x Teclado">Solicitação de 1x Teclado</option>
                            <option value="Solicitação de 1x Monitor">Solicitação de 1x Monitor</option>
                            <option value="Solicitação de upgrade em Computador">Solicitação de upgrade em Computador</option>
                            <option value="Instalação software">Instalação software</option>
                            <option value="Carona de equipamentos ou peças">Carona de equipamentos ou peças</option>
                            <option value="Elaboração de pregões, dispensas de licitação ou cotações eletrônicas">Elaboração de pregões, dispensas de licitação ou cotações eletrônicas</option>
                        </select>-->
                    </td>            
                    <td rowspan="2" valign="top">   
                        <select class="form-control" id="secao" name="secao" size="17" style="width: 170px;" required="required">
                            <option selected disabled>Seção</option>
                            <?php
                            $c = connect();
                            $sql = "SELECT idSecao,secao "
                                    . "FROM Secao "
                                    . "ORDER BY secao";
                            $result = $c->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["idSecao"] . "' " . ">" . $row["secao"] . "</option>";
                                }
                            }

                            //$c->close();
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="responsavel" name="responsavel" value="" placeholder="RESPONSÁVEL" size="25">                 
                    </td>
                </tr>
                <tr>
                    <td valign="top">                    
                        <label for="descricao">Descricao:</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="7"></textarea>
                    </td>
                    <td>
<!--                        <select class="form-control" id="posto" name="posto" size="14" style="width: 250px;">
                            <option selected disabled>Posto</option>
                            <option value='Sd'>Sd</option>
                            <option value='Cb'>Cb</option>
                            <option value='Sgt'>Sgt</option>
                            <option value='S Ten'>S Ten</option>
                            <option value='Asp'>Asp</option>
                            <option value='Ten'>Ten</option>
                            <option value='Cap'>Cap</option>
                            <option value='Maj'>Maj</option>
                            <option value='TC'>TC</option>
                            <option value='Cel'>Cel</option>
                            <option value='Gen'>Gen</option>
                            <option value=' '>Nenhum</option>
                        </select>-->
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
                                    $selected = $statusId == 1 ? "selected" : "";

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
                                    $selected = $prioridadeId == 1 ? "selected" : "";

                                    if ($row["idPrioridade"] == $prioridade) {
                                        $selected = " selected='selected'";
                                    }

                                    echo "<option value='$prioridadeId'" . $selected . ">" . $row["prioridade"] . "</option>";
                                }
                            }

                            $c->close();
                            ?>                  
                        </select>
                    </td>            
                </tr>
                <tr>
                    <td><button type="submit" class="btn btn-primary">Cadastrar</button></td>
                    <td colspan="2">&nbsp;</td>                
                </tr>
            </table>                           
        </form> 
    </div>
    <!------------------------------------------------>
<?php } ?>
<?php require_once '../include/footer.php'; ?>