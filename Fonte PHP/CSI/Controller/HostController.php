<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HostController
 *
 * @author dauer
 */
require_once '../include/global.php';
require_once '../Model/Host.php';
require_once '../Model/Secao.php';
require_once '../Model/Usuario.php';
require_once '../MySQLDAO/HostDAO.php';
require_once '../MySQLDAO/SecaoDAO.php';
require_once '../MySQLDAO/UsuarioDAO.php';

class HostController {

    private $instance, $instanceDAO;

    private function getFormData() {
        $this->instance = new Host();
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->instance->setId(empty($id) ? filter_input(INPUT_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS) : $id);
        $this->instance->setMac(filter_input(INPUT_POST, "mac", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setIdSecao(filter_input(INPUT_POST, "idSecao", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setTipo(filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setObservacao(filter_input(INPUT_POST, "observacao", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setGateway(filter_input(INPUT_POST, "gateway", FILTER_SANITIZE_SPECIAL_CHARS));
        $ipHost = filter_input(INPUT_POST, "ipHost", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->instance->setIpHost($ipHost == "1" ? 1 : 0);
        $this->instance->setOrdem(filter_input(INPUT_POST, "ordem", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setSistemaOperacional(filter_input(INPUT_POST, "sistemaOperacional", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setLacre(filter_input(INPUT_POST, "lacre", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setMemoria(filter_input(INPUT_POST, "memoria", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setMemoriaTipo(filter_input(INPUT_POST, "memoriaTipo", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setProcessador(filter_input(INPUT_POST, "processador", FILTER_SANITIZE_SPECIAL_CHARS));
        $this->instance->setDiscoRigido(filter_input(INPUT_POST, "discoRigido", FILTER_SANITIZE_SPECIAL_CHARS));
    }

    public function update() {
        $this->getFormData();
        $this->instanceDAO = new HostDAO();
        if (!empty($this->instance->getOrdem())) {
            if ($this->instanceDAO->update($this->instance)) {
                header("Location: ./view_host.php");
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
                require_once '../View/view_host_edit.php';
            } else {
                header("Location: ../View/view_error.php");
            }
        }
    }

    public function getAllList() {
//        try {
//            $this->instanceDAO = new HostDAO();
//            $objectList = $this->instanceDAO->getAllList();
//            $secaoDAO = new SecaoDAO();
//            $usuarioDAO = new UsuarioDAO();
//            require_once '../View/view_equipamento_list.php';
//        } catch (Exception $e) {
//            require_once '../View/view_error.php';
//        }
    }

}

$action = $_REQUEST["action"];
$controller = new HostController();
switch ($action) {
    case "update" :
        ($_SESSION["nivel"] > 1) ? $controller->update() : header("Location: view_login.php");
        break;
//    case "getAllList" :
//        $controller->getAllList();
//        break;
}