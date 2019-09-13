<?php

class Usuario {

    private $id_usuario;
    private $desc_login;
    private $desc_senha;
    private $dt_cadastro;

    public function __construct($login = NULL, $password = NULL) {
        $this->setDesc_login($login);
        $this->setDesc_senha($password);
    }

    public function getId_usuario() {
        return $this->id_usuario;
    }
    public function setId_usuario($id) {
        $this->id_usuario = $id;
    }
    public function getDesc_login() {
        return $this->desc_login;
    }
    public function setDesc_login($login) {
        $this->desc_login = $login;
    }
    public function getDesc_senha() {
        return $this->desc_senha;
    }
    public function setDesc_senha($senha) {
        $this->desc_senha = $senha;
    }
    public function getDt_cadastro() {
        return $this->dt_cadastro;
    }
    public function setDt_cadastro($data) {
        $this->dt_cadastro = $data;
    }

    public function loadById($id) {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE id_usuario = :ID", [
            ":ID" => $id
        ]);

        if (count($results) > 0) {

            $this->setData($results[0]);

        }

    }

    public static function getList() {
        $sql = new Sql;

        return $sql->select("SELECT * FROM tb_usuarios ORDER BY desc_login DESC");
    }

    public static function search($login) {

        $sql = new Sql;

        return $sql->select("SELECT * FROM tb_usuarios WHERE desc_login LIKE :SEARCH ORDER BY desc_login", [':SEARCH' => "%".$login."%"]);

    }

    public function login($login, $password) {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE desc_login = :LOGIN AND desc_senha = :PASSWORD", [
            ":LOGIN" => $login,
            ":PASSWORD" => $password
        ]);

        if (count($results) > 0) {

            $this->setData($results[0]);

        } else {

            throw new Exception("Login e/ou senha inválidos.");

        }

    }

    public function insert() {
        $sql = new Sql();

        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", [
            ':LOGIN' => $this->getDesc_login(),
            ':PASSWORD' => $this->getDesc_senha()
        ]);

        if (count($results) > 0) {
            $this->setData($results[0]);
        }

    }

    public function update($login, $password) {

        $this->setDesc_login($login);
        $this->setDesc_senha($password);

        $sql = new Sql();
        $sql->query("UPDATE tb_usuarios SET desc_login = :LOGIN, desc_senha = :PASSWORD WHERE id_usuario = :ID", [
            'LOGIN' => $this->getDesc_login(),
            'PASSWORD' => $this->getDesc_senha(),
            ':ID' => $this->getId_usuario()
        ]);
    }

    public function delete() {
        $sql = new Sql();
        $sql->query("DELETE FROM tb_usuarios WHERE id_usuario = :ID", [
            ":ID" => $this->getId_usuario()
        ]);

        $this->setId_usuario(0);
        $this->setDesc_login("");
        $this->setDesc_senha("");
        $this->setDt_cadastro(new DateTime());
    }   

    public function setData($data) {

        $this->setId_usuario($data['id_usuario']);
        $this->setDesc_login($data['desc_login']);
        $this->setDesc_senha($data['desc_senha']);
        $this->setDt_cadastro(new DateTime($data['dt_cadastro']));

    }

    public function __toString() {
        return json_encode([
            "id_usuario" => $this->getId_usuario(),
            "desc_login" => $this->getDesc_login(),
            "desc_senha" => $this->getDesc_senha(),
            "dt_cadastro" => $this->getDt_cadastro()->format("d/m/Y H:i:s")
        ]);
    }

}