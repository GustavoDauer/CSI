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
class OrdemServico {

    private $id,
            $data,
            $responsavel,
            $titulo,
            $descricao,
            $solucao,
            $prazo,
            $idPrioridade,
            $idStatus,
            $idUsuario,
            $ordem,
            $idEquipamento,
            $idSecao;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->data = $idOrRow["data"];
            $this->responsavel = $idOrRow["responsavel"];
            $this->titulo = $idOrRow["titulo"];
            $this->descricao = $idOrRow["descricao"];
            $this->solucao = $idOrRow["solucao"];
            $this->prazo = $idOrRow["prazo"];
            $this->idPrioridade = $idOrRow["idPrioridade"];
            $this->idStatus = $idOrRow["idStatus"];
            $this->idUsuario = $idOrRow["idUsuario"];
            $this->ordem = $idOrRow["ordem"];
            $this->idEquipamento = $idOrRow["idEquipamento"];
            $this->idSecao = $idOrRow["idSecao"];
        }
    }

    function getId() {
        return $this->id;
    }

    function getData() {
        return $this->data;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getSolucao() {
        return $this->solucao;
    }

    function getPrazo() {
        return $this->prazo;
    }

    function getIdPrioridade() {
        return $this->idPrioridade;
    }

    function getIdStatus() {
        return $this->idStatus;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getOrdem() {
        return $this->ordem;
    }

    function getIdEquipamento() {
        return $this->idEquipamento;
    }

    function getIdSecao() {
        return $this->idSecao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setSolucao($solucao) {
        $this->solucao = $solucao;
    }

    function setPrazo($prazo) {
        $this->prazo = $prazo;
    }

    function setIdPrioridade($idPrioridade) {
        $this->idPrioridade = $idPrioridade;
    }

    function setIdStatus($idStatus) {
        $this->idStatus = $idStatus;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setOrdem($ordem) {
        $this->ordem = $ordem;
    }

    function setIdEquipamento($idEquipamento) {
        $this->idEquipamento = $idEquipamento;
    }

    function setIdSecao($idSecao) {
        $this->idSecao = $idSecao;
    }

}
