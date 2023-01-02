<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EquipamentoDAO
 *
 * @author dauer
 */
require_once '../include/conexao.php';
require_once '../Model/Equipamento.php';

class EquipamentoDAO extends Equipamento {

    public function insert($object) {
        $this->fillObject($object);
        try {
            $c = connect();
            $sql = "INSERT INTO `secinfo`.`Equipamento`
            (
            `tipo`,
            `marca`,
            `modelo`,
            `responsavel`,
            `problema`,
            `solucao`,
            `acessorios`,
            `sistemaOperacional`,
            `memoria`,
            `processador`,
            `discoRigido`,
            `placaDeVideo`,
            `placaDeRede`,
            `tampa`,
            `bateria`,
            `carregador`,
            `observacao`,
            `Host_ip`
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
            ";
            $stmt = $c->prepare($sql);
            $stmt->bind_param(
                    'sssssssssssssiiiss',
                    $this->tipo,
                    $this->marca,
                    $this->modelo,
                    $this->responsavel,
                    $this->problema,
                    $this->solucao,
                    $this->acessorios,
                    $this->sistemaOperacional,
                    $this->memoria,
                    $this->processador,
                    $this->discoRigido,
                    $this->placaDeVideo,
                    $this->placaDeRede,
                    $this->tampa,
                    $this->bateria,
                    $this->carregador,
                    $this->observacao,
                    $this->idHost
            );
            $sqlOk = $stmt ? $stmt->execute() : false;
            //Definir ID
            $sql = "SELECT idEquipamento "
                    . " FROM Equipamento "
                    . " WHERE idEquipamento = LAST_INSERT_ID()";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $this->id = $row["idEquipamento"];
            }
            // Inserir OS
            $sql = "INSERT INTO "
                    . "OrdemServico (titulo, descricao, Prioridade_idPrioridade, Status_idStatus, responsavel, ordem, data, Equipamento_idEquipamento, Secao_idSecao, Usuario_idUsuario)"
                    . " VALUES ('OS de $this->tipo', '$this->problema', 4, 2, '$this->responsavel', 0, CURRENT_DATE, $this->id, $this->idSecao, $this->idUsuario)";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
        return true;
    }

    public function update($object) {
        $this->fillObject($object);
        try {
            $c = connect();
            $sql = "UPDATE `secinfo`.`Equipamento`
            SET
            `tipo` = ?,
            `marca` = ?,
            `modelo` = ?,
            `responsavel` = ?,
            `problema` = ?,
            `solucao` = ?,
            `acessorios` = ?,
            `sistemaOperacional` = ?,
            `memoria` = ?,
            `processador` = ?,
            `discoRigido` = ?,
            `placaDeVideo` = ?,
            `placaDeRede` = ?,
            `tampa` = ?,
            `bateria` = ?,
            `carregador` = ?,
            `observacao` = ?,
            `Host_ip` = ? 
            WHERE `idEquipamento` = ?;
            ";
            $stmt = $c->prepare($sql);
            $stmt->bind_param(
                    'sssssssssssssiiissi',
                    $this->tipo,
                    $this->marca,
                    $this->modelo,
                    $this->responsavel,
                    $this->problema,
                    $this->solucao,
                    $this->acessorios,
                    $this->sistemaOperacional,
                    $this->memoria,
                    $this->processador,
                    $this->discoRigido,
                    $this->placaDeVideo,
                    $this->placaDeRede,
                    $this->tampa,
                    $this->bateria,
                    $this->carregador,
                    $this->observacao,
                    $this->idHost,
                    $this->id
            );
            $sqlOk = $stmt ? $stmt->execute() : false;
            // Atualizar OS
            $sql = "UPDATE OrdemServico SET titulo = 'OS de $this->tipo', responsavel = '$this->responsavel', descricao = '$this->problema', Secao_idSecao = $this->idSecao, Usuario_idUsuario = $this->idUsuario "
                    . "WHERE Equipamento_idEquipamento = $this->id;";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
        return true;
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Equipamento "
                    . " WHERE idEquipamento = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList() {
        try {
            $c = connect();
            $sql = "SELECT * FROM Equipamento "
                    . "LEFT JOIN OrdemServico ON Equipamento_idEquipamento = idEquipamento "
                    . "WHERE Status_idStatus != 3";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Equipamento($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getById($id) {
        try {
            $c = connect();
            $sql = "SELECT *, Equipamento.solucao AS solucao "
                    . " FROM Equipamento "
                    . "LEFT JOIN OrdemServico ON Equipamento_idEquipamento = idEquipamento "
                    . " WHERE idEquipamento = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Equipamento($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getByOSId($id) {
        try {
            $c = connect();
            $sql = "SELECT *, Equipamento.solucao AS solucao "
                    . " FROM Equipamento "
                    . "INNER JOIN OrdemServico ON Equipamento_idEquipamento = idEquipamento "
                    . " WHERE idOrdemServico = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Equipamento($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idEquipamento"],
            "tipo" => $row["tipo"],
            "marca" => $row["marca"],
            "modelo" => $row["modelo"],
            "responsavel" => $row["responsavel"],
            "problema" => $row["problema"],
            "solucao" => $row["solucao"],
            "acessorios" => $row["acessorios"],
            "sistemaOperacional" => $row["sistemaOperacional"],
            "memoria" => $row["memoria"],
            "processador" => $row["processador"],
            "discoRigido" => $row["discoRigido"],
            "placaDeVideo" => $row["placaDeVideo"],
            "placaDeRede" => $row["placaDeRede"],
            "tampa" => $row["tampa"],
            "bateria" => $row["bateria"],
            "carregador" => $row["carregador"],
            "observacao" => $row["observacao"],
            "idSecao" => $row["Secao_idSecao"],
            "idUsuario" => $row["Usuario_idUsuario"],
            "idHost" => $row["Host_ip"]
        );
    }

    public function fillObject($object) {
        $this->id = $object->getId();
        $this->tipo = $object->getTipo();
        $this->marca = $object->getMarca();
        $this->modelo = $object->getModelo();
        $this->responsavel = $object->getResponsavel();
        $this->problema = $object->getProblema();
        $this->solucao = $object->getSolucao();
        $this->acessorios = $object->getAcessorios();
        $this->sistemaOperacional = $object->getSistemaOperacional();
        $this->memoria = $object->getMemoria();
        $this->processador = $object->getProcessador();
        $this->discoRigido = $object->getDiscoRigido();
        $this->placaDeVideo = $object->getPlacaDeVideo();
        $this->placaDeRede = $object->getPlacaDeRede();
        $this->tampa = $object->getTampa();
        $this->bateria = $object->getBateria();
        $this->carregador = $object->getCarregador();
        $this->observacao = $object->getObservacao();
        $this->idSecao = $object->getIdSecao();
        $this->idUsuario = $object->getIdUsuario();
        $this->idHost = $object->getIdHost();
    }

}
