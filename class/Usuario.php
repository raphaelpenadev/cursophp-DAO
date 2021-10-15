<?php

class Usuario
{
    private $idususario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getIdusuario()
    {
        return $this->idususario;
    }

    public function getLogin()
    {
        return $this->deslogin;
    }

    public function getSenha()
    {
        return $this->dessenha;
    }

    public function getDtCadastro()
    {
        return $this->dtcadastro;
    }

    public function setIdusuario($value)
    {
        $this->idususario = $value;
    }

    public function setDeslogin($value)
    {
        $this->deslogin = $value;
    }

    public function setDessenha($value)
    {
        $this->dessenha = $value;
    }

    public function setDtCadastro($value)
    {
        $this->dtcadastro = $value;
    }

    public function LoadById($id)
    {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", [
            ":ID" => $id,
        ]);

        if (count($results) > 0) {

            $row = $results[0];

            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDtCadastro(new DateTime($row['dtcadastro']));
        }
    }

    public static function getList()
    {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
    }

    public static function search($login)
    {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", [
            ':SEARCH' => "%" . $login . "%"
        ]);
    }

    public function login($login, $password)
    {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", [
            ":LOGIN" => $login,
            ":PASSWORD" => $password
        ]);

        if (count($results) > 0) {

            $row = $results[0];

            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDtCadastro(new DateTime($row['dtcadastro']));
        } else {
            throw new Exception("Login e/ou senha inválidos");
        }
    }

    public function __toString()
    {
        return json_encode([
            "idusuario" => $this->getIdusuario(),
            "deslogin" => $this->getLogin(),
            "dessenha" => $this->getSenha(),
            "dtcadastro" => $this->getDtCadastro()->format("d/m/Y H:i:s")
        ]);
    }
}
