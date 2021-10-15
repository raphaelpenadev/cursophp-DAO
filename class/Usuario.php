<?php

class Usuario
{
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getIdusuario()
    {
        return $this->idusuario;
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
        $this->idusuario = $value;
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

            $this->setData($results[0]);
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
            $this->setData($results[0]);
        } else {
            throw new Exception("Login e/ou senha inválidos");
        }
    }

    public function setData($data)
    {
        $this->setIdusuario($data['idusuario']);
        $this->setDeslogin($data['deslogin']);
        $this->setDessenha($data['dessenha']);
        $this->setDtCadastro(new DateTime($data['dtcadastro']));
    }

    public function insert()
    {
        $sql = new Sql();

        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", [
            ":LOGIN" => $this->getLogin(),
            ":PASSWORD" => $this->getSenha()
        ]);

        if (count($results) > 0) {
            $this->setData($results[0]);
        }
    }

    public function update($login = '', $password = '')
    {
        $this->setDeslogin($login);
        $this->setDessenha($password);
        $sql = new Sql();
        $sql->queries("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", [
            ":LOGIN" => $this->getLogin(),
            ":PASSWORD" => $this->getSenha(),
            ":ID" => $this->getIdusuario()
        ]);
    }

    public function delete()
    {
        $sql = new Sql();
        $sql->queries("DELETE FROM tb_usuarios WHERE idusuario = :ID", [
            ":ID" => $this->getIdusuario()
        ]);

        $this->setIdusuario(0);
        $this->setDeslogin("");
        $this->setDessenha("");
        $this->setDtCadastro(new DateTime());
    }

    public function __construct($login = "", $password = "")
    {
        $this->setDeslogin($login);
        $this->setDessenha($password);
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
