<?php

    include 'ver_auth';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <title>Inicio - VAT Lanches</title>
        <?php include_once '../bibliotecas/bootstrap.html'; ?>
    </head>
    <body class="bg-lightgray">
        <?php include_once '../assets/header.php'; ?>
        <div class="container bg-light my-md-4 p-5">
            <div class="row justify-content-center mb-4">
                <h1>Bem-vindo! Administrador.</h1>
            </div>
            <div class="row justify-content-center">
                <h4>O que você gostaria de gerenciar hoje? </h4>
            </div>
            <div class="row">
                <div class="container m-3 p-4 border border-muted">
                    <div class="row justify-content-center p-2"><a href="gerenciar/encomendas.php"><button class="btn btn-dark">Encomendas</button></a></div>
                    <div class="row justify-content-center p-2"><a href="gerenciar/produtos.php"><button class="btn btn-dark">Produtos</button></a></div>
                    <div class="row justify-content-center p-2"><a href="gerenciar/clientes.php"><button class="btn btn-dark">Clientes</button></a></div>
                </div>
            </div>
        </div>
        <?php $footer_fixed = TRUE;  include_once '../assets/footer.php'; ?>
    </body>
</html>