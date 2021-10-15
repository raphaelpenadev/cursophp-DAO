<?php

require_once("config.php");

// Carrega um usuario (toString)
// $root = new Usuario();
// $root->LoadById(4);
// echo $root;

// Carrega uma lista de usuarios (toList)
// $lista = Usuario::getList();

// echo json_encode($lista);

// Carrega uma lista de usuarios buscando pelas letras passadas
// $search = Usuario::search("jo");

// echo json_encode($search);

// Carrega Usuario completando login e senha
$usuario = new Usuario();
$usuario->login('jose', '12345');
echo $usuario;
