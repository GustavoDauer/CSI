<?php
//require_once '../include/comum.php';
require_once '../include/header.php';
?>
<br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="14" style="text-align: center;"><span id="total">0</span> equipamentos</th>
        </tr>
        <tr>                
            <th>Tipo</th>
            <th>Host</th>
            <th>Responsável</th>
            <th>Receptor</th>
            <th>
                <?php if (isAdminLevel($NIVEL_EQUIPAMENTO_ADD)) { ?>
                    <a href="../Controller/EquipamentoController.php?action=insert"><img src='../imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                <?php } ?>
            </th>                
        </tr>
    </thead>
    <tbody id="myTable">   
        <?php if (is_array($objectList)) { ?> 
        <script>
            document.getElementById("total").innerHTML = "<?= count($objectList) ?>";
        </script>
        <?php
        foreach ($objectList as $object):
            $ordemServico = $ordemServicoDAO->getByEquipamentoId($object->getId());
            ?>        
            <tr>
                <td>
                    <a href="../Controller/EquipamentoController.php?action=visualize&id=<?= $object->getId() ?>" target="_blank"><?php echo $object->getTipo(); ?></a>
                </td>
                <td>
                    <a href="../Controller/HostController.php?action=update&id=<?= $object->getIdHost() ?>" target="_blank"><?= $object->getIdHost(); ?></a>
                </td>
                <td>
                    <a href="./view_ordemServico_edit.php?id=<?= $ordemServico->getId() ?>">#<?= $ordemServico->getId() ?> <?= $secaoDAO->getById($object->getIdSecao())->getSecao() ?> / <?= $object->getResponsavel() ?></a>
                </td>  
                <td>
                    <?= !empty($object->getIdUsuario()) ? $usuarioDAO->getById($object->getIdUsuario())->getNome() : "" ?>
                </td>
                <td style="white-space: nowrap">                                
                    <?php if (isAdminLevel($NIVEL_EQUIPAMENTO_EDIT)) { ?>
                        <a href="../Controller/EquipamentoController.php?action=update&id=<?= $object->getId() ?>"><img src='../imagens/editar.png' width='25' height='25' title='Editar'></a>
                    <?php } ?>
                    <?php if (isAdminLevel($NIVEL_EQUIPAMENTO_REMOVE)) { ?>
                        <a href="../Controller/EquipamentoController.php?action=delete&id=<?= $object->getId() ?>"><img src='../imagens/excluir.png' width='25' height='25' title='Excluir'></a>    
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>    
    <?php } ?>
</tbody>
</table>
<?php require_once '../include/footer.php'; ?>