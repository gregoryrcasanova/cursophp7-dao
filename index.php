<?php
echo "<h2>DAO: Data Access Object</h2>\n";

require_once("config.php");

$root = new Usuario();

$root->loadById(3);

echo $root;