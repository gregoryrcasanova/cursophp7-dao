<?php
echo "<h2>DAO: Data Access Object</h2>\n";

require_once("config.php");

$sql = new Sql();

$usuarios = $sql->select("SELECT * FROM tb_usuarios");

echo json_encode($usuarios);