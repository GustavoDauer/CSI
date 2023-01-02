<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EquipamentoController
 *
 * @author dauer
 */
require_once '../include/global.php';
require_once '../Model/Equipamento.php';
require_once '../Model/Secao.php';
require_once '../Model/Usuario.php';
require_once '../MySQLDAO/EquipamentoDAO.php';
require_once '../MySQLDAO/SecaoDAO.php';
require_once '../MySQLDAO/UsuarioDAO.php';
require_once '../MySQLDAO/HostDAO.php';
require_once '../MySQLDAO/OrdemServicoDAO.php';

class EquipamentoController {

    private $instance, $instanceDAO;

    private function getFormData() {
        $this->instance = new Equipamento();
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->instance->setId(empty($id) ? filter_input(INPUT_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS) : $id);
        $this->instance->setTipo(filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setMarca(filter_input(INPUT_POST, "marca", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setModelo(filter_input(INPUT_POST, "modelo", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setResponsavel(filter_input(INPUT_POST, "responsavel", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setProblema(filter_input(INPUT_POST, "problema", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setSolucao(filter_input(INPUT_POST, "solucao", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setAcessorios(filter_input(INPUT_POST, "acessorios", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setSistemaOperacional(filter_input(INPUT_POST, "sistemaOperacional", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setMemoria(filter_input(INPUT_POST, "memoria", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setProcessador(filter_input(INPUT_POST, "processador", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setDiscorigido(filter_input(INPUT_POST, "discoRigido", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setPlacaDeVideo(filter_input(INPUT_POST, "placaDeVideo", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setPlacaDeRede(filter_input(INPUT_POST, "placaDeRede", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setTampa(filter_input(INPUT_POST, "tampa", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setBateria(filter_input(INPUT_POST, "bateria", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setCarregador(filter_input(INPUT_POST, "carregador", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setObservacao(filter_input(INPUT_POST, "observacao", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setIdSecao(filter_input(INPUT_POST, "idSecao", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setIdUsuario(filter_input(INPUT_POST, "idUsuario", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setIdHost(filter_input(INPUT_POST, "idHost", FILTER_SANITIZE_SPECIAL_CHARS));
    }

    public function insert() {
        $this->getFormData();
        if ($this->instance->validate()) {
            $this->instanceDAO = new EquipamentoDAO();
            if ($this->instanceDAO->insert($this->instance)) {
                header("Location: ../Controller/EquipamentoController.php?action=getAllList");
            } else {
                header("Location: ../View/view_error.php");
            }
        } else {
            $object = $this->instance;
            $secaoDAO = new SecaoDAO();
            $usuarioDAO = new UsuarioDAO();
            $hostDAO = new HostDAO();
            require_once '../View/view_equipamento_edit.php';
        }
    }

    public function update() {
        $this->getFormData();
        $this->instanceDAO = new EquipamentoDAO();
        if ($this->instance->validate() && $this->instance->getId() != null) {
            if ($this->instanceDAO->update($this->instance)) {
                header("Location: ../Controller/EquipamentoController.php?action=getAllList");
            } else {
                header("Location: ../View/view_error.php");
            }
        } else {
            $this->instance = $this->instanceDAO->getById($this->instance->getId());
            $object = $this->instance;
            if ($object != null) {
                $secaoDAO = new SecaoDAO();
                $usuarioDAO = new UsuarioDAO();
                $hostDAO = new HostDAO();
                require_once '../View/view_equipamento_edit.php';
            } else {
                header("Location: ../View/view_error.php");
            }
        }
    }

    public function delete() {
        try {
            $this->getFormData();
            $this->instanceDAO = new EquipamentoDAO();
            if ($this->instance->getId() != null) {
                if ($this->instanceDAO->delete($this->instance)) {
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                } else {
                    header("Location: ../View/view_error.php");
                }
            } else {
                header("Location: ../View/view_error.php");
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    public function getAllList() {
        try {
            $this->instanceDAO = new EquipamentoDAO();
            $objectList = $this->instanceDAO->getAllList();
            $secaoDAO = new SecaoDAO();
            $usuarioDAO = new UsuarioDAO();
            $ordemServicoDAO = new OrdemServicoDAO();
            require_once '../View/view_equipamento_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    public function search() {
        try {
            $this->getFormData();
            $this->instanceDAO = new EquipamentoDAO();
            $object = null;
            if ($this->instance->getId() != null) {
                $object = $this->instanceDAO->getByOSId($this->instance->getId());
                $secaoDAO = new SecaoDAO();
                $usuarioDAO = new UsuarioDAO();
            }
            require_once '../View/view_equipamento_busca.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    public function visualize() {
        $this->getFormData();
        $this->instanceDAO = new EquipamentoDAO();
        if ($this->instance->getId() != null) {
            $this->instance = $this->instanceDAO->getById($this->instance->getId());
            $object = $this->instance;
            if ($object == null) {
                header("Location: ../View/view_error.php");
            }
            $secaoDAO = new SecaoDAO();
            $usuarioDAO = new UsuarioDAO();
            $ordemServicoDAO = new OrdemServicoDAO();
            require_once '../View/view_equipamento_visualize.php';
        } else {
            header("Location: ../View/view_error.php");
        }
    }

}

$action = $_REQUEST["action"];
$controller = new EquipamentoController();
switch ($action) {
    case "insert" :
        ($_SESSION["nivel"] > 1) ? $controller->insert() : header("Location: /CSI/view_login.php");
        break;
    case "update" :
        ($_SESSION["nivel"] > 1) ? $controller->update() : header("Location: /CSI/view_login.php");
        break;
    case "delete" :
        ($_SESSION["nivel"] >= 10) ? $controller->delete() : header("Location: /CSI/view_login.php");
        break;
    case "getAllList" :
        $controller->getAllList();
        break;
    case "search" :
        $controller->search();
        break;
    case "visualize" :
        $controller->visualize();
        break;
}