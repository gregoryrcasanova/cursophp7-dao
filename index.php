<?php
echo "<h2>DAO: Data Access Object</h2>\n";

require_once("config.php");

// Carrega um usuário
$root = new Usuario();
$root->loadById(3);
// echo $root;

// Carrega uma lista de usuários
$lista = Usuario::getList();
// echo json_encode($lista);

// Carrega uma lista de usuário buscado pelo login
$busca = Usuario::search("Jos");
// echo json_encode($busca);

// Carrega um usuário usando o login e a senha
$usuario = new Usuario();
$usuario->login("user", '12345');
// echo $usuario;

// Criando um novo usuário
$aluno = new Usuario("aluno", "@alun0");
// $aluno->setDesc_login("aluno");
// $aluno->setDesc_senha("@alun0");
$aluno->insert();
// echo $aluno;

$usuario = new Usuario();
$usuario->loadById(11);
$usuario->update("professor", "!@$@%#@");
echo $usuario;