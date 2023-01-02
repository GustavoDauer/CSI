<?php
require_once '../include/comum.php';
require_once '../include/header.php';
$ip = filter_input(INPUT_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS);
?>    
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="../js/jquery-mask/jquery.mask.min.js"></script>
<br>       
<h5>
    Editar Host 
    <span style="font-size: 14px;">        
        | <a href="#" onclick="history.back(-1);">Voltar</a>
    </span>
</h5>
<hr>
<form accept-charset="UTF-8" action="../Controller/HostController.php?action=update&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">    
    <div style="background-color: #f1fdff; padding: 25px; margin-bottom: 5px;">
        <sub style="font-size: 20px; font-family: sans-serif;letter-spacing: 5px;">Informações de rede </sub><hr>
        <div class="form-group">  
            <div class="form-row">
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">IP</span>
                        <input class="form-control" type="text" placeholder="IP" value="<?= $object->getId() ?>" readonly>  <!-- IGNORAR -->                  
                    </div>
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">MAC</span>
                        <input type="text" class="form-control" id="mac" name="mac" placeholder="MAC" value="<?= $object->getMac() ?>" maxlength="17" onkeypress="return (event.charCode >= 48 && event.charCode <= 58) || (event.charCode >= 97 && event.charCode <= 102);">
                    </div>
                </div>
            </div>    
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                                    
                    <div >
                        <input type="checkbox" class="" id="ipHost" name="ipHost" value="1" <?= $object->getIpHost() == "1" ? " checked='checked'" : ""; ?>>
                        <label class="" for="customCheck">IP FIXO</label>
                    </div>                
                </div>
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">GATEWAY</span>
                        <input type="text" class="form-control" id="gateway" name="gateway" placeholder="GATEWAY" value="<?= $object->getGateway() ?>" maxlength="15" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46);">
                    </div>
                </div>
            </div>    
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col"> 
                    <div class="input-group-prepend">
                        <span class="input-group-text">TIPO</span>
                        <select name="tipo" class="form-control">
                            <option value="" <?= $object->getTipo() == "" ? "selected" : "" ?>>Nenhum</option>
                            <option value="computador" <?= $object->getTipo() == "computador" ? "selected" : "" ?>>Computador</option>
                            <option value="notebook" <?= $object->getTipo() == "notebook" ? "selected" : "" ?>>Notebook</option>
                            <option value="impressora" <?= $object->getTipo() == "impressora" ? "selected" : "" ?>>Impressora/Scanner</option>
                            <option value="telefone" <?= $object->getTipo() == "telefone" ? "selected" : "" ?>>Telefone VoIP</option>
                            <option value="roteador" <?= $object->getTipo() == "roteador" ? "selected" : "" ?>>Roteador/Switch Gerenciável</option>
                            <option value="nanostation" <?= $object->getTipo() == "nanostation" ? "selected" : "" ?>>Nanostation</option>
                            <option value="camera" <?= $object->getTipo() == "camera" ? "selected" : "" ?>>Câmera</option>
                            <option value="servidor" <?= $object->getTipo() == "servidor" ? "selected" : "" ?>>Servidor</option>
                            <option value="vm" <?= $object->getTipo() == "vm" ? "selected" : "" ?>>VM</option>          
                        </select>
                    </div>
                </div>
                <div class="col"> 
                    <div class="input-group-prepend">
                        <span class="input-group-text">SEÇÃO</span>
                        <select class="form-control" id="idSecao" name="idSecao" required="required">
                            <option value="NULL" <?= $object->getIdSecao() == "" || $object->getIdSecao() == "NULL" ? "selected" : "" ?>>Nenhuma</option>
                            <?php
                            $secoes = $secaoDAO->getAllList();
                            foreach ($secoes as $secao) {
                                echo "<option value='" . $secao->getId() . "' " . ($object->getIdSecao() == $secao->getId() ? "selected" : "") . ">" . $secao->getSecao() . "</option>";
                            }
                            ?>                   
                        </select>                    
                    </div>
                </div>            
            </div>
        </div> 
    </div>
    <div style="background-color: #fdffdf; padding: 25px; margin-bottom: 5px;">
        <sub style="font-size: 20px; font-family: sans-serif;letter-spacing: 5px;">Informações de Computadores e Notebooks</sub><hr>
        <div class="form-group">
            <div class="form-row">
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">LACRE</span>
                        <input type="text" class="form-control" id="lacre" name="lacre" placeholder="LACRE" value="<?= $object->getLacre() ?>" maxlength="14">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">SISTEMA OPERACIONAL</span>
                        <select class="form-control" name="sistemaOperacional" class="form-control">
                            <option value="" <?= $object->getSistemaOperacional() == " " ? "selected" : "" ?>> </option>
                            <option value="linux ubuntu 18.04" <?= $object->getSistemaOperacional() == "linux ubuntu 18.04" ? "selected" : "" ?>>Ubuntu 18.04</option>
                            <option value="linux ubuntu 16.04" <?= $object->getSistemaOperacional() == "linux ubuntu 16.04" ? "selected" : "" ?>>Ubuntu 16.04</option>
                            <option value="linux mint 19.3" <?= $object->getSistemaOperacional() == "linux mint 19.3" ? "selected" : "" ?>>Mint 19.3</option>
                            <option value="linux mint 18.3" <?= $object->getSistemaOperacional() == "linux mint 18.3" ? "selected" : "" ?>>Mint 18.3</option>
                            <option value="linux mint 18.1" <?= $object->getSistemaOperacional() == "linux mint 18.1" ? "selected" : "" ?>>Mint 18.1</option>
                            <option value="linux debian" <?= $object->getSistemaOperacional() == "linux debian" ? "selected" : "" ?>>Debian</option>  
                            <option value="linux centos" <?= $object->getSistemaOperacional() == "linux centos" ? "selected" : "" ?>>CentOS</option>
                            <option value="linux xcpng" <?= $object->getSistemaOperacional() == "linux xcpng" ? "selected" : "" ?>>XCP-ng</option>
                            <option value="linux xenserver" <?= $object->getSistemaOperacional() == "linux xenserver" ? "selected" : "" ?>>Xen Server</option>
                            <option value="linux" <?= $object->getSistemaOperacional() == "linux" ? "selected" : "" ?>>Linux</option>
                            <option value="windows 10" <?= $object->getSistemaOperacional() == "windows 10" ? "selected" : "" ?>>Windows 10</option> 
                            <option value="windows 7" <?= $object->getSistemaOperacional() == "windows 7" ? "selected" : "" ?>>Windows 7</option>
                            <option value="windows" <?= $object->getSistemaOperacional() == "windows" ? "selected" : "" ?>>Windows</option>
                            <option value="macos" <?= $object->getSistemaOperacional() == "macos" ? "selected" : "" ?>>MacOS</option>                         
                        </select>                    
                    </div>
                </div>            
            </div>
        </div>  
        <div class="form-group">
            <div class="form-row">            
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">ARQUITETURA MEMÓRIA</span>
                        <select class="form-control" id="memoriaTipo" name="memoriaTipo" style="width: 170px;"> 
                            <option <?= $object->getMemoriaTipo() == " " ? "selected" : "" ?>> </option>
                            <option <?= $object->getMemoriaTipo() == "DDR3" ? "selected" : "" ?>>DDR3</option>
                            <option <?= $object->getMemoriaTipo() == "DDR4" ? "selected" : "" ?>>DDR4</option>
                            <option <?= $object->getMemoriaTipo() == "DDR2" ? "selected" : "" ?>>DDR2</option>
                            <option <?= $object->getMemoriaTipo() == "DDR" ? "selected" : "" ?>>DDR</option>                        
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">MEMÓRIA</span>
                        <select class="form-control" id="memoria" name="memoria" style="width: 170px;"> 
                            <option <?= $object->getMemoria() == " " ? "selected" : "" ?>> </option>
                            <option <?= $object->getMemoria() == "1GB" ? "selected" : "" ?>>1GB</option>
                            <option <?= $object->getMemoria() == "2GB" ? "selected" : "" ?>>2GB</option>
                            <option <?= $object->getMemoria() == "3GB" ? "selected" : "" ?>>3GB</option>
                            <option <?= $object->getMemoria() == "4GB" ? "selected" : "" ?>>4GB</option>
                            <option <?= $object->getMemoria() == "6GB" ? "selected" : "" ?>>6GB</option>
                            <option <?= $object->getMemoria() == "8GB" ? "selected" : "" ?>>8GB</option>
                            <option <?= $object->getMemoria() == "10GB" ? "selected" : "" ?>>10GB</option>
                            <option <?= $object->getMemoria() == "12GB" ? "selected" : "" ?>>12GB</option>
                            <option <?= $object->getMemoria() == "16GB" ? "selected" : "" ?>>16GB</option>
                            <option <?= $object->getMemoria() == "20GB" ? "selected" : "" ?>>20GB</option>
                            <option <?= $object->getMemoria() == "24GB" ? "selected" : "" ?>>24GB</option>
                            <option <?= $object->getMemoria() == "28GB" ? "selected" : "" ?>>28GB</option>
                            <option <?= $object->getMemoria() == "32GB" ? "selected" : "" ?>>32GB</option>
                            <option <?= $object->getMemoria() == "64GB" ? "selected" : "" ?>>64GB</option>
                            <option <?= $object->getMemoria() == "128GB" ? "selected" : "" ?>>128GB</option>
                            <option <?= $object->getMemoria() == "256GB" ? "selected" : "" ?>>256GB</option>
                        </select>
                    </div>
                </div>              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">PROCESSADOR</span>
                        <input class="form-control" type="text" placeholder="PROCESSADOR" name="processador" value="<?= $object->getProcessador() ?>" maxlength="25">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">DISCO RÍGIDO</span>
                        <select class="form-control" id="discoRigido" name="discoRigido" style="width: 170px;">                            
                            <option <?= $object->getDiscoRigido() == " " ? "selected" : "" ?>> </option>
                            <option <?= $object->getDiscoRigido() == "HD SATA" ? "selected" : "" ?>>HD SATA</option>
                            <option <?= $object->getDiscoRigido() == "SSD" ? "selected" : "" ?>>SSD</option>
                            <option <?= $object->getDiscoRigido() == "HD IDE" ? "selected" : "" ?>>HD IDE</option>
                        </select>
                    </div>
                </div>                                            
            </div>
        </div> 
    </div>
    <div style="background-color: #ffeeff; padding: 25px; margin-bottom: 5px;">
        <sub style="font-size: 20px; font-family: sans-serif;letter-spacing: 5px;">Informações genéricas</sub><hr>    
        <div class="form-group">
            <div class="form-row">
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">OBSERVAÇÃO</span>
                        <input type="text" class="form-control" id="observacao" name="observacao" placeholder="OBSERVAÇÃO" value="<?= $object->getObservacao() ?>" maxlength="25">
                    </div>
                </div>            
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">ORDEM EXIBIÇÃO</span>                    
                        <!--<select class="form-control" id="ordem" name="ordem" style="width: 170px;">-->                            
                        <?php
                        $selected = "";
                        $lastOctectIp = explode(".", $ip);
                        $ordem = $ordem == 0 ? $lastOctectIp[2] . $lastOctectIp[3] : $ordem;

//                            for ($i = 801; $i <= 83254; $i++) {
//                                if ($ordem == $i) {
//                                    $selected = " selected";
//                                } else {
//                                    $selected = "";
//                                }
//
//                                echo "<option value='$i' $selected>$i</option>";
//                            }
                        ?>
                        <!--</select>-->
                        <input type="number" class="form-control" id="ordem" name="ordem" placeholder="ORDEM" value="<?= $ordem ?>" maxlength="25" onkeypress="return event.charCode >= 48 && event.charCode <= 57;">
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <div class="form-group" align="center">                    
        <input class="btn btn-primary" type="submit" value="Salvar">
    </div>
</form>
<script>
    $(document).ready(function () {
        $('[name=mac]').mask('AA:AA:AA:AA:AA:AA');
    });
</script>
<?php require_once '../include/footer.php'; ?>