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

        if (isset($results[0])) {
            $row = $results[0];

            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDtCadastro(new DateTime($row['dtcadastro']));
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
