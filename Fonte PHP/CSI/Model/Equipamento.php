<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Equipamento
 *
 * @author dauer
 */
class Equipamento {

    private $id, $tipo, $marca, $modelo, $data, $responsavel, $problema, $solucao, $acessorios;
    private $sistemaOperacional, $memoria, $processador, $discorigido, $placaDeVideo, $placaDeRede, $tampa, $bateria, $carregador, $observacao, $idSecao, $idUsuario, $idHost;

    function __construct($idOrRow = "") {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->tipo = $idOrRow["tipo"];
            $this->marca = $idOrRow["marca"];
            $this->modelo = $idOrRow["modelo"];
            $this->responsavel = $idOrRow["responsavel"];
            $this->problema = $idOrRow["problema"];
            $this->solucao = $idOrRow["solucao"];
            $this->acessorios = $idOrRow["acessorios"];
            $this->sistemaOperacional = $idOrRow["sistemaOperacional"];
            $this->memoria = $idOrRow["memoria"];
            $this->processador = $idOrRow["processador"];
            $this->discorigido = $idOrRow["discoRigido"];
            $this->placaDeVideo = $idOrRow["placaDeVideo"];
            $this->placaDeRede = $idOrRow["placaDeRede"];
            $this->tampa = $idOrRow["tampa"];
            $this->bateria = $idOrRow["bateria"];
            $this->carregador = $idOrRow["carregador"];
            $this->observacao = $idOrRow["observacao"];
            $this->idSecao = $idOrRow["idSecao"];
            $this->idUsuario = $idOrRow["idUsuario"];
            $this->idHost = $idOrRow["idHost"];
        }
    }

    function getTipo() {
        return $this->tipo;
    }

    function getData() {
        return $this->data;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getProblema() {
        return $this->problema;
    }

    function getSolucao() {
        return $this->solucao;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setProblema($problema) {
        $this->problema = $problema;
    }

    function setSolucao($solucao) {
        $this->solucao = $solucao;
    }

    function getMarca() {
        return $this->marca;
    }

    function getModelo() {
        return $this->modelo;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function getAcessorios() {
        return $this->acessorios;
    }

    function setAcessorios($acessorios) {
        $this->acessorios = $acessorios;
    }

    function getSistemaOperacional() {
        return $this->sistemaOperacional;
    }

    function getMemoria() {
        return $this->memoria;
    }

    function getProcessador() {
        return $this->processador;
    }

    function getDiscorigido() {
        return $this->discorigido;
    }

    function getPlacaDeVideo() {
        return $this->placaDeVideo;
    }

    function getPlacaDeRede() {
        return $this->placaDeRede;
    }

    function getTampa() {
        return $this->tampa;
    }

    function getBateria() {
        return $this->bateria;
    }

    function getCarregador() {
        return $this->carregador;
    }

    function getObservacao() {
        return $this->observacao;
    }

    function setSistemaOperacional($sistemaOperacional) {
        $this->sistemaOperacional = $sistemaOperacional;
    }

    function setMemoria($memoria) {
        $this->memoria = $memoria;
    }

    function setProcessador($processador) {
        $this->processador = $processador;
    }

    function setDiscorigido($discorigido) {
        $this->discorigido = $discorigido;
    }

    function setPlacaDeVideo($placaDeVideo) {
        $this->placaDeVideo = $placaDeVideo;
    }

    function setPlacaDeRede($placaDeRede) {
        $this->placaDeRede = $placaDeRede;
    }

    function setTampa($tampa) {
        $this->tampa = $tampa;
    }

    function setBateria($bateria) {
        $this->bateria = $bateria;
    }

    function setCarregador($carregador) {
        $this->carregador = $carregador;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getIdSecao() {
        return $this->idSecao;
    }

    function setIdSecao($idSecao) {
        $this->idSecao = $idSecao;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function getIdHost() {
        return $this->idHost;
    }

    function setIdHost($idHost) {
        $this->idHost = $idHost;
    }

    function validate() {
        if (!empty($this->tipo) && !empty($this->responsavel) && !empty($this->idSecao) && !empty($this->idUsuario)) {
            return true;
        }
        return false;
    }

}
