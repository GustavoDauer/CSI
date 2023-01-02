<?php
require_once '../include/comum.php';
require_once '../include/header.php';
?>         
<br>       
<h5>
    Ficha de Equipamento 
    <span style="font-size: 14px;">
        | <a href="../Controller/EquipamentoController.php?action=visualize&id=<?= $object->getId() ?>" target="_blank">Visualizar</a>
        | <a href="#" onclick="history.back(-1);">Voltar</a>
    </span>
</h5>
<hr>
<form accept-charset="UTF-8" action="../Controller/EquipamentoController.php?action=<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
    <div class="form-group">  
        <div class="form-row">
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">RESPONSÁVEL</span>
                    <input class="form-control" type="text" name="responsavel" value="<?= $object->getResponsavel() ?>" onkeyup="this.value = this.value.toUpperCase();" maxlength="250">                    
                </div>
            </div>
            <div class="col">                    
                <select class="form-control" id="idSecao" name="idSecao" required="required">
                    <option selected disabled>Seção</option>
                    <?php
                    $secoes = $secaoDAO->getAllList();
                    foreach ($secoes as $secao) {
                        echo "<option value='" . $secao->getId() . "' " . ($object->getIdSecao() == $secao->getId() ? "selected" : "") . ">" . $secao->getSecao() . "</option>";
                    }
                    ?>                   
                </select>                    
            </div>
            <div class="col">
                <select class="form-control" id="idHost" name="idHost" required="required">
                    <option selected disabled>Sem IP</option>
                    <?php
                    $hosts = $hostDAO->getAllList();
                    foreach ($hosts as $host) {
                        echo "<option value='" . $host->getId() . "' " . ($host->getId() == $object->getIdHost() ? "selected" : "") . ">" . $host->getId() . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>    
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col">                    
                <div class="input-group-prepend">
                    <span class="input-group-text">Tipo</span>
                    <select name="tipo" class="form-control">
                        <option <?= $object->getTipo() == "Computador" ? "selected" : "" ?>>Computador</option>
                        <option <?= $object->getTipo() == "Notebook" ? "selected" : "" ?>>Notebook</option>
                        <option <?= $object->getTipo() == "Monitor" ? "selected" : "" ?>>Monitor</option>
                        <option <?= $object->getTipo() == "Impressora" ? "selected" : "" ?>>Impressora</option>
                        <option <?= $object->getTipo() == "Scanner" ? "selected" : "" ?>>Scanner</option>
                        <option <?= $object->getTipo() == "No-break" ? "selected" : "" ?>>No-break</option>
                        <option <?= $object->getTipo() == "Estabilizador" ? "selected" : "" ?>>Estabilizador</option>
                        <option <?= $object->getTipo() == "Filtro de linha" ? "selected" : "" ?>>Filtro de linha</option>
                        <option <?= $object->getTipo() == "Outros" ? "selected" : "" ?>>Outros</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">MARCA</span>
                    <input class="form-control" type="text" name="marca" value="<?= $object->getMarca() ?>" onkeyup="this.value = this.value.toUpperCase();" maxlength="25">
                </div>
            </div>
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">MODELO</span>
                    <input class="form-control" type="text" name="modelo" value="<?= $object->getModelo() ?>" onkeyup="this.value = this.value.toUpperCase();" maxlength="25">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">SISTEMA OPERACIONAL</span>
                    <select name="sistemaOperacional" class="form-control">
                        <option <?= $object->getSistemaOperacional() == "" ? "selected" : "" ?>>Nenhum</option>
                        <option <?= $object->getSistemaOperacional() == "Windows" ? "selected" : "" ?>>Windows</option>
                        <option <?= $object->getSistemaOperacional() == "Linux" ? "selected" : "" ?>>Linux</option>
                        <option <?= $object->getSistemaOperacional() == "MacOS" ? "selected" : "" ?>>MacOS</option>               
                    </select>
                </div>
            </div>         
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">PROCESSADOR</span>
                    <input class="form-control" type="text" name="processador" value="<?= $object->getProcessador() ?>" onkeyup="this.value = this.value.toUpperCase();" maxlength="25">
                </div>
            </div>
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">MEMÓRIA</span>
                    <input class="form-control" type="text" name="memoria" value="<?= $object->getMemoria() ?>" onkeyup="this.value = this.value.toUpperCase();" maxlength="25">
                </div>
            </div>                                
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">DISCO RÍGIDO</span>
                    <input class="form-control" type="text" name="discoRigido" value="<?= $object->getDiscoRigido() ?>" onkeyup="this.value = this.value.toUpperCase();" maxlength="25">
                </div>
            </div>                    
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">PLACA DE VÍDEO</span>
                    <input class="form-control" type="text" name="placaDeVideo" value="<?= $object->getPlacaDeVideo() ?>" onkeyup="this.value = this.value.toUpperCase();" maxlength="25">
                </div>
            </div>
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">PLACA DE REDE</span>
                    <input class="form-control" type="text" name="placaDeRede" value="<?= $object->getPlacaDeRede() ?>" onkeyup="this.value = this.value.toUpperCase();" maxlength="25">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">ACESSÓRIOS</span>
                    <input class="form-control" type="text" name="acessorios" value="<?= $object->getAcessorios() ?>" maxlength="70">
                </div>
            </div>        
            <div class="col-2">
                <div class="checkbox"><label><input type="checkbox" name="tampa" value="1" <?= !empty($object->getTampa()) ? "checked" : "" ?>> Tampa</label></div>           
                <div class="checkbox"><label><input type="checkbox" name="bateria" value="1" <?= !empty($object->getBateria()) ? "checked" : "" ?>> Bateria</label></div>            
                <div class="checkbox"><label><input type="checkbox" name="carregador" value="1" <?= !empty($object->getCarregador()) ? "checked" : "" ?>> Carregador</label></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">OBSERVAÇÃO</span>            
                    <textarea class="form-control" name="observacao" rows="4" maxlength="2500"><?= $object->getObservacao() ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">PROBLEMA</span>
                    <textarea class="form-control" name="problema" rows="5" maxlength="5200"><?= $object->getProblema() ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">SOLUÇÃO</span>
                    <textarea class="form-control" name="solucao" rows="5" maxlength="5200"><?= $object->getSolucao() ?></textarea>
                </div>
            </div>
        </div>
    </div>    
    <div class="form-group">
        <div class="form-row">
            <div class="col">
                <div class="input-group-prepend">
                    <span class="input-group-text">RECEPTOR</span>
                    <select class="form-control" id="idUsuario" name="idUsuario" required>
                        <?php
                        $usuarios = $usuarioDAO->getAllList(1);
                        foreach ($usuarios as $usuario) {
                            echo "<option value='" . $usuario->getId() . "' " . ($usuario->getId() == $object->getIdUsuario() ? "selected" : "") . ($_SESSION["nivel"] < 10 ? "readonly" : "") . ">" . $usuario->getNome() . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">                    
        <input class="btn btn-primary" type="submit" value="Salvar">
    </div>
</form>
<?php require_once '../include/footer.php'; ?>