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
require_once '../Model/Usuario.php';

class UsuarioDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Usuario("
                    . "login, senha, nivel, status, nome"
                    . ") "
                    . "VALUES("
                    . "'" . $object->getLogin() . "', "
                    . "'" . $object->getSenha() . "', "
                    . $object->getNivel() . ", "
                    . $object->getStatus() . ", "
                    . "'" . $object->getNome() . "'"
                    . ");";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE Usuario SET "
                    . "login = '" . $object->getLogin() . "', ";
            $sql .= !empty($object->getSenha()) ? ", senha = '" . $object->getSenha() . "' " : "";
            $sql .= ", status = " . (empty($object->getStatus()) ? 0 : 1)
                    . ", nivel = " . $object->getNivel()
                    . ", nome = '" . $object->getNome() . "'"
                    . " WHERE idUsuario = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Usuario "
                    . " WHERE idUsuario = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($nivel = "") { // Nível 0 = usuário desabilitado
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Usuario ";
            $sql .= $nivel == "" ? "" : " WHERE nivel > $nivel";
            $sql .= " ORDER BY status DESC, nivel DESC, login, idUsuario";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Usuario($objectArray);
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
                    . " FROM Usuario "
                    . " WHERE idUsuario = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Usuario($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function login($usuario) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Usuario "
                    . " WHERE "
                    . "login = '" . $usuario->getLogin() . "' AND "
                    . "senha = '" . $usuario->getSenha() . "' AND "
                    . "status = 1";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Usuario($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idUsuario"],
            "login" => $row["login"],
            "senha" => $row["senha"],
            "nivel" => $row["nivel"],
            "status" => $row["status"],
            "nome" => $row["nome"]
        );
    }

}
