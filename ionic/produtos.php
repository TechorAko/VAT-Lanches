<?php

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

require_once "../bibliotecas/bancodedados.bli";
require_once "../bibliotecas/db_auth";

$_GET["cat"] = isset($_GET["cat"]) ? ["categoria" => $_GET["cat"]] : NULL;

echo json_encode($vatlanches->buscar("tblproduto", "*", $_GET["cat"], FALSE, "descricao"));

?>