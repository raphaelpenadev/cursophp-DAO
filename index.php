<?php

require_once("config.php");

$root = new Usuario();

$root->LoadById(4);

echo $root;
