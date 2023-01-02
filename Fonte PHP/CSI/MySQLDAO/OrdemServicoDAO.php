<?php

/* * *****************************************************************************
 * 
 * Copyright © 2021 Gustavo Henrique Mello Dauer - 2º Ten 
 * Chefe da Seção de Informática do 2º BE Cmb
 * Email: gustavodauer@gmail.com
 * 
 * Este arquivo é parte do programa SCC
 * 
 * SCC é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da Licença Pública Geral GNU como
 * publicada pela Free Software Foundation (FSF); na versão 3 da
 * Licença, ou qualquer versão posterior.

 * Este programa é distribuído na esperança de que possa ser útil,
 * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO
 * a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.

 * Você deve ter recebido uma cópia da Licença Pública Geral GNU junto
 * com este programa, Se não, veja <http://www.gnu.org/licenses/>.
 * 
 * ***************************************************************************** */

/**
 *
 * @author gustavodauer
 */
require_once '../include/conexao.php';
require_once '../Model/OrdemServico.php';

class OrdemServicoDAO extends OrdemServico {

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE OrdemServico SET "
                    . "responsavel = '" . $object->getResponsavel() . "', "
                    . "titulo = " . $object->getTitulo() . ", "
                    . "descricao = '" . $object->getDescricao() . "', "
                    . "solucao = '" . $object->getSolucao() . "', "
                    . "Prioridade_idPrioridade = " . $object->getIdPrioridade() . ", "
                    . "Status_idStatus = " . $object->getIdStatus() . ", "
                    . "Usuario_idUsuario = " . $object->getIdUsuario() . ", "
                    . "Equipamento_idEquipamento = " . $object->getIdEquipamento() . ", "
                    . "ordem = " . $object->getOrdem() . ", "
                    . "Secao_idSecao = " . $object->getIdSecao() . " "
                    . " WHERE idOrdemServico = '" . $object->getId() . "';";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList() { // ToDo
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM OrdemServico ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new OrdemServico($objectArray);
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
            $sql = "SELECT * "
                    . " FROM OrdemServico "
                    . " WHERE idOrdemServico = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new OrdemServico($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getByEquipamentoId($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM OrdemServico "
                    . " WHERE Equipamento_idEquipamento = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new OrdemServico($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idOrdemServico"],
            "data" => $row["data"],
            "responsavel" => $row["responsavel"],
            "titulo" => $row["titulo"],
            "descricao" => $row["descricao"],
            "solucao" => $row["solucao"],
            "prazo" => $row["prazo"],
            "idPrioridade" => $row["Prioridade_idPrioridade"],
            "idStatus" => $row["Status_idStatus"],
            "idUsuario" => $row["Usuario_idUsuario"],
            "ordem" => $row["ordem"],
            "idEquipamento" => $row["Equipamento_idEquipamento"],
            "idSecao" => $row["Secao_idSecao"]
        );
    }

}
