<?php require_once '../include/comum.php'; ?> 
<?php $address = $_SERVER['REQUEST_URI']; ?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "utf-8">        
        <title>SecInfo - 2º BECmb</title>
        <link rel = "stylesheet" href = "../css/bootstrap.min.css">
        <script src = "../js/bootstrap.min.js"></script>
        <style type="text/css">
            .container {
                margin: 7px;
            }

            .rotulo {
                font-weight: bold;
            }

            .form-row .col {
                border-right: 1px solid;
                border-bottom: 1px solid;
                padding: 14px;
            }

            .form-row .col-2 {
                border-right: 1px solid;
                border-bottom: 1px solid;
            }

            .form-row {
                border-left: 1px solid;
            }

            .form-group {
                border-top: 1px solid;
            }

            h5 {
                font-family: serif;
                font-weight: bold;
                margin-top: 7px;
            }

            h4 {
                font-family: serif;
                font-weight: bold;
                letter-spacing: 5px;
                margin-top: 14px;
            }
        </style>      
    </head>
    <body>  
        <div class='container'>                        
            <div align="center">
                <img src="../imagens/cabecalho.png" height="250">
                <h4>SEÇÃO DE INFORMÁTICA</h4>
                <?php
                $ordemServico = $ordemServicoDAO->getByEquipamentoId($object->getId());
                ?>
                <h5><a href="../Controller/EquipamentoController.php?action=update&id=<?= $object->getId() ?>" title="Clique para editar a ficha" style="color:black;">Ficha de Recebimento de <?= $object->getTipo() ?> - OS #<?= $ordemServico->getId() ?></a></h5>
            </div>
            <hr>
            <form accept-charset="UTF-8" action="../Controller/EquipamentoController.php?action=update&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">      
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <span class="rotulo">RESPONSÁVEL:</span>
                            <?= $object->getResponsavel() ?>
                        </div>        
                        <div class="col">                                
                            <span class="rotulo">SEÇÃO:</span>    
                            <?= $secaoDAO->getById($object->getIdSecao())->getSecao() ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">                                    
                            <span class="rotulo">TIPO:</span>
                            <?= $object->getTipo() ?>
                        </div>
                        <?php if (!empty($object->getMarca())) { ?>
                            <div class="col">                
                                <span class="rotulo">MARCA:</span>
                                <?= $object->getMarca() ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($object->getModelo())) { ?>
                            <div class="col">                
                                <span class="rotulo">MODELO:</span>
                                <?= $object->getModelo() ?>
                            </div>
                        <?php } ?>
                    </div>   
                    <div class="form-row">
                        <?php if (!empty($object->getSistemaOperacional())) { ?>
                            <div class="col">
                                <span class="rotulo">SISTEMA OPERACIONAL:</span>
                                <?= $object->getSistemaOperacional() ?>                
                            </div>   
                        <?php } ?>
                        <?php if (!empty($object->getProcessador())) { ?>
                            <div class="col">
                                <span class="rotulo">PROCESSADOR:</span>
                                <?= $object->getProcessador() ?>
                            </div>  
                        <?php } ?>
                        <?php if (!empty($object->getMemoria())) { ?>
                            <div class="col">
                                <span class="rotulo">MEMÓRIA:</span>
                                <?= $object->getMemoria() ?>
                            </div>    
                        <?php } ?>
                    </div>
                    <div class="form-row">                        
                        <?php if (!empty($object->getDiscoRigido())) { ?>
                            <div class="col">
                                <span class="rotulo">DISCO RÍGIDO:</span>
                                <?= $object->getDiscoRigido() ?>
                            </div>  
                        <?php } ?>
                        <?php if (!empty($object->getPlacaDeVideo())) { ?>
                            <div class="col">
                                <span class="rotulo">PLACA DE VÍDEO:</span>
                                <?= $object->getPlacaDeVideo() ?>
                            </div>    
                        <?php } ?>
                        <?php if (!empty($object->getPlacaDeRede())) { ?>
                            <div class="col">
                                <span class="rotulo">PLACA DE REDE:</span>
                                <?= $object->getPlacaDeRede() ?>
                            </div>
                        <?php } ?>
                    </div>   
                    <div class="form-row">                        
                        <div class="col">
                            <span class="rotulo">ACESSÓRIOS:</span>
                            <?= !empty($object->getAcessorios()) ? $object->getAcessorios() : "Nenhum" ?>
                        </div>                           
                        <?php if ($object->getTipo() == "Computador" || $object->getTipo() == "Notebook") { ?>
                            <div class="col-2">
                                <div class="checkbox"><label><input type="checkbox" name="tampa" value="1" <?= !empty($object->getTampa()) ? "checked" : "" ?> readonly> Tampa</label></div>

                                <div class="checkbox"><label><input type="checkbox" name="bateria" value="1" <?= !empty($object->getBateria()) ? "checked" : "" ?> readonly> Bateria</label></div>            
                                <div class="checkbox"><label><input type="checkbox" name="carregador" value="1" <?= !empty($object->getCarregador()) ? "checked" : "" ?> readonly> Carregador</label></div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if (!empty($object->getMarca())) { ?>
                        <div class="form-row">
                            <div class="col">
                                <span class="rotulo">OBSERVAÇÃO:</span>
                                <?= !empty($object->getObservacao()) ? $object->getObservacao() : "Nenhuma" ?>     
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-row">
                        <div class="col">
                            <span class="rotulo">PROBLEMA:</span>
                            <?= $object->getProblema() ?>
                        </div>
                    </div>                    
                    <div class="form-row">
                        <div class="col">
                            <span class="rotulo">SOLUÇÃO:</span>
                            <?= $object->getSolucao() ?>
                        </div>    
                    </div>   
                    <div class="form-row">
                        <div class="col">
                            <span class="rotulo">RECEPTOR:</span>     
                            <?= $usuarioDAO->getById($object->getIdUsuario())->getNome() ?>
                        </div>   
                        <div class="col">
                            <span class="rotulo">ASSINATURA:</span>                             
                        </div>
                    </div>
                </div>                       
            </form>
        </div>    
    </body>
</html>