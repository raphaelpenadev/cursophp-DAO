<?php

class Sql extends PDO
{

    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
        echo "Conexão bem sucedida";
    }

    private function setParams($statement, $parameters = [])
    {
        foreach ($parameters as $key => $value) {
            $this->setParam($statement, $key, $value);
        }
    }

    private function setParam($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }

    public function queries($rawQuery, $params = [])
    {
        $stmt = $this->conn->prepare($rawQuery);

        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt;
    }

    public function select($rawQuery, $params = []): array
    {
        $stmt = $this->queries($rawQuery, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
