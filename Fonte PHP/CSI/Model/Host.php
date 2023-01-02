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
class Host {

    private $id, // id = ip
            $mac,
            $estado,
            $idSecao,
            $tipo,
            $observacao,
            $gateway,
            $ipHost,
            $ordem,
            $sistemaOperacional,
            $lacre,
            $dataOnline,
            $memoria,
            $memoriaTipo,
            $processador,
            $discoRigido;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->mac = $idOrRow["mac"];
            $this->estado = $idOrRow["estado"];
            $this->idSecao = $idOrRow["idSecao"];
            $this->tipo = $idOrRow["tipo"];
            $this->observacao = $idOrRow["observacao"];
            $this->gateway = $idOrRow["gateway"];
            $this->ipHost = $idOrRow["ipHost"];
            $this->ordem = $idOrRow["ordem"];
            $this->sistemaOperacional = $idOrRow["sistemaOperacional"];
            $this->lacre = $idOrRow["lacre"];
            $this->dataOnline = $idOrRow["dataOnline"];
            $this->memoria = $idOrRow["memoria"];
            $this->memoriaTipo = $idOrRow["memoriaTipo"];
            $this->processador = $idOrRow["processador"];
            $this->discoRigido = $idOrRow["discoRigido"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getMac() {
        return $this->mac;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getIdSecao() {
        return $this->idSecao;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function getGateway() {
        return $this->gateway;
    }

    public function getIpHost() {
        return $this->ipHost;
    }

    public function getOrdem() {
        return $this->ordem;
    }

    public function getSistemaOperacional() {
        return $this->sistemaOperacional;
    }

    public function getLacre() {
        return $this->lacre;
    }

    public function getDataOnline() {
        return $this->dataOnline;
    }

    public function getMemoria() {
        return $this->memoria;
    }

    public function getMemoriaTipo() {
        return $this->memoriaTipo;
    }

    public function getProcessador() {
        return $this->processador;
    }

    public function getDiscoRigido() {
        return $this->discoRigido;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setMac($mac) {
        $this->mac = $mac;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setIdSecao($idSecao) {
        $this->idSecao = $idSecao;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function setGateway($gateway) {
        $this->gateway = $gateway;
    }

    public function setIpHost($ipHost) {
        $this->ipHost = $ipHost;
    }

    public function setOrdem($ordem) {
        $this->ordem = $ordem;
    }

    public function setSistemaOperacional($sistemaOperacional) {
        $this->sistemaOperacional = $sistemaOperacional;
    }

    public function setLacre($lacre) {
        $this->lacre = $lacre;
    }

    public function setDataOnline($dataOnline) {
        $this->dataOnline = $dataOnline;
    }

    public function setMemoria($memoria) {
        $this->memoria = $memoria;
    }

    public function setMemoriaTipo($memoriaTipo) {
        $this->memoriaTipo = $memoriaTipo;
    }

    public function setProcessador($processador) {
        $this->processador = $processador;
    }

    public function setDiscoRigido($discoRigido) {
        $this->discoRigido = $discoRigido;
    }

}
