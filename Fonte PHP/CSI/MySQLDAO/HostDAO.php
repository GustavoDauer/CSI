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
require_once '../Model/Host.php';

class HostDAO extends Host {

    public function update($object) {
        try {            
            $c = connect();            
            $sql = "UPDATE Host SET "
                    . "mac = '" . $object->getMac() . "', "
                    . "Secao_idSecao = " . $object->getIdSecao() . ", "
                    . "tipo = '" . $object->getTipo() . "', "
                    . "observacao = '" . $object->getObservacao() . "', "
                    . "gateway = '" . $object->getGateway() . "', "
                    . "ipHost = " . $object->getIpHost() . ", "
                    . "ordem = " . $object->getOrdem() . ", "
                    . "sistemaOperacional = '" . $object->getSistemaOperacional() . "', "
                    . "lacre = '" . $object->getLacre() . "', "
                    . "memoria = '" . $object->getMemoria() . "', "
                    . "memoriaTipo = '" . $object->getMemoriaTipo() . "', "
                    . "processador = '" . $object->getProcessador() . "', "
                    . "discoRigido = '" . $object->getDiscoRigido() . "' "
                    . " WHERE ip = '" . $object->getId() . "';";            
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
            $sql = "SELECT * "
                    . " FROM Host "
                    . " ORDER BY ip";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Host($objectArray);
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
                    . " FROM Host "
                    . " WHERE ip = '$id'";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Host($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["ip"],
            "mac" => $row["mac"],
            "estado" => $row["estado"],
            "idSecao" => $row["Secao_idSecao"],
            "tipo" => $row["tipo"],
            "observacao" => $row["observacao"],
            "gateway" => $row["gateway"],
            "ipHost" => $row["ipHost"],
            "ordem" => $row["ordem"],
            "sistemaOperacional" => $row["sistemaOperacional"],
            "lacre" => $row["lacre"],
            "dataOnline" => $row["dataOnline"],
            "memoria" => $row["memoria"],
            "memoriaTipo" => $row["memoriaTipo"],
            "processador" => $row["processador"],
            "discoRigido" => $row["discoRigido"]
        );
    }

    public function fillObject($object) {
        $this->id = $object->getId();
        $this->mac = $object->getMac();
        $this->estado = $object->getEstado();
        $this->idSecao = $object->getIdSecao();
        $this->tipo = $object->getTipo();
        $this->observacao = $object->getObservacao();
        $this->gateway = $object->getGateway();
        $this->ipHost = $object->getIpHost();
        $this->ordem = $object->getOrdem();
        $this->sistemaOperacional = $object->getSistemaOperacional();
        $this->lacre = $object->getLacre();
        $this->dataOnline = $object->getDataOnline();
        $this->memoria = $object->getMemoria();
        $this->memoriaTipo = $object->getMemoriaTipo();
        $this->processador = $object->getProcessador();
        $this->discoRigido = $object->getDiscoRigido();
    }

}
